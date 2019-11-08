<?php

namespace ModuleComposer\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

class UpdateModuleCommand extends Command
{
    protected static $defaultName = 'update';
    
    protected function configure()
    {
        $this
            ->setDescription('Update command')
            ->setHelp('Update module')
            ->addArgument('module-directory', InputArgument::REQUIRED, '')
            ->addOption('name', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('description', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('module-version', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('magento-number', null, InputOption::VALUE_REQUIRED, '', 1)
            ->addOption('psr4', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('repository', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('repository-use-name', null, InputOption::VALUE_NONE, '')
            ->addOption('replace', null, InputOption::VALUE_REQUIRED, '')
            ->addOption('force', null, InputOption::VALUE_NONE, '');
    }
    
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $moduleDirectory = rtrim(realpath($input->getArgument('module-directory')), DIRECTORY_SEPARATOR) . DIRECTORY_SEPARATOR;
        $name = $input->getOption('name');
        $description = $input->getOption('description');
        $version = $input->getOption('module-version');
        $magentoNumber = $input->getOption('magento-number');
        $psr4 = $input->getOption('psr4');
        $repository = $input->getOption('repository');
        $repositoryUseName = $input->getOption('repository-use-name');
        $force = $input->getOption('force');
        $replace = $input->getOption('replace');
        if (!empty($replace)) {
            $replace = json_decode($replace, true);
        } else {
            $replace = [];
        }
        
        $configurationPath = implode(DIRECTORY_SEPARATOR, [
            $moduleDirectory,
            'composer.json',
        ]);
        
        $configuration = [
            'type'    => "magento2-module",
            "license" => "GPL-3.0",
        
        ];
        if (file_exists($configurationPath)) {
            $configuration = array_merge($configuration, json_decode(file_get_contents($configurationPath), true));
        }
        
        if (!empty($name)) {
            $configuration['name'] = $name;
        }
        
        if (!empty($description)) {
            $configuration['description'] = $description;
        }
        
        if (!empty($version)) {
            $configuration['version'] = $version;
        }
        
        if ($magentoNumber == 2) {
            if (!isset($configuration['autoload'])) {
                $configuration['autoload'] = [
                    'files' => [
                        'registration.php',
                    ],
                    'psr-4' => [
                    ],
                ];
            }
            
            if (!empty($psr4)) {
                $configuration['autoload']['psr-4'] = [
                    $psr4 => '',
                ];
            }
        }
        
        $configurationString = json_encode($configuration, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);
        
        foreach ($replace as $search => $rep) {
            $configurationString = str_replace($search, $rep, $configurationString);
        }
        
        file_put_contents($configurationPath, $configurationString);
        
        $configuration = json_decode(file_get_contents($configurationPath), true);
        
        $gitPath = implode(DIRECTORY_SEPARATOR, [
            $moduleDirectory,
            '.git',
        ]);
        
        if (!file_exists($gitPath)) {
            $cmd = sprintf("cd %s ; git init", $moduleDirectory);
            exec($cmd);
        }
        
        $gitIgnorePath = implode(DIRECTORY_SEPARATOR, [
            $moduleDirectory,
            '.gitignore',
        ]);
        
        if (!file_exists($gitIgnorePath)) {
            $f = fopen($gitIgnorePath, 'w');
            fputs($f, sprintf(".idea %s", PHP_EOL));
            fputs($f, sprintf(".DS_Store %s", PHP_EOL));
            fclose($f);
        }
        
        if ($magentoNumber == 1) {
            $cmd = sprintf("cd '%s' ; /usr/local/bin/generate-modman", $moduleDirectory);
            exec($cmd);
        }
        
        $escapedModuleDirectory = $moduleDirectory;
        $escapedModuleDirectory = str_replace(" ", "\ ", $escapedModuleDirectory);
        $escapedModuleDirectory = str_replace("(", "\(", $escapedModuleDirectory);
        $escapedModuleDirectory = str_replace(")", "\)", $escapedModuleDirectory);
        
        $cmd = sprintf("cd '%s' ; git add -A", $escapedModuleDirectory);
        exec($cmd);
        
        $cmd = sprintf("cd '%s' ; git commit -m 'Updated at version %s'", $escapedModuleDirectory, $configuration['version']);
        exec($cmd);
        
        $cmd = sprintf("cd '%s' ; git tag v%s", $escapedModuleDirectory, $configuration['version']);
        exec($cmd);
        
        if ($force) {
            $cmd = sprintf("cd '%s' ; git tag v%s -f", $escapedModuleDirectory, $configuration['version']);
            exec($cmd);
        }
        
        if ($repository || $repositoryUseName) {
            
            if ($repositoryUseName) {
                $repositoryName = explode("/", $configuration['name']);
                $repository = sprintf('git@bitbucket.org:%s/magento%s_%s.git', $repositoryName[0], $magentoNumber, $repositoryName[1]);
            }
            $cmd = sprintf("cd '%s' ; git remote add origin %s", $escapedModuleDirectory, $repository);
            @exec($cmd);
        }

//        $cmd = sprintf("cd '%s' ; git push origin master", $escapedModuleDirectory);
//        exec($cmd);
        
        $cmd = sprintf("cd '%s' ; git push origin master --tags", $escapedModuleDirectory);
        exec($cmd);
        
        if ($force) {
            $cmd = sprintf("cd '%s' ; git push origin master --tags -f", $escapedModuleDirectory);
            exec($cmd);
        }
    }
}
