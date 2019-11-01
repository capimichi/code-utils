<?php
/**
 * Created by PhpStorm.
 * User: michele
 * Date: 16/10/2019
 * Time: 15:19
 */

namespace App\Service;


use Nesk\Puphpeteer\Puppeteer;
use Nesk\Puphpeteer\Resources\Browser;

class Chromium
{
    /**
     * @var Puppeteer
     */
    protected $puppeteer;
    
    /**
     * @var Browser
     */
    protected $browser;
    
    /**
     * @var array
     */
    protected $pages;
    
    /**
     * Chromium constructor.
     */
    public function __construct()
    {
        $this->puppeteer = new Puppeteer();
        $this->browser = $this->newBrowser();
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param $identifier
     *
     * @return mixed
     */
    public function getPage($identifier)
    {
        if (!isset($this->pages[$identifier])) {
            $this->pages[$identifier] = $this->newPage();
        }
        return $this->pages[$identifier];
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param $identifier
     */
    public function closePage($identifier)
    {
        if (isset($this->pages[$identifier])) {
            $this->pages[$identifier]->close();
            unset($this->pages[$identifier]);
        }
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @return mixed
     */
    public function newPage()
    {
        return $this->getBrowser()->newPage();
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @return mixed
     */
    public function newBrowser()
    {
        return $this->puppeteer->launch([
            'headless' => 1,
        ]);
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @return Browser
     */
    public function getBrowser()
    {
        if (!$this->browser) {
            $this->browser = $this->newBrowser();
        }
        return $this->browser;
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     */
    public function closeBrowser()
    {
        if ($this->browser) {
            $this->browser->close();
            $this->browser = null;
        }
    }
    
}