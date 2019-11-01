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
use Nesk\Rialto\Data\JsFunction;

class Translator
{
    
    const GOOGLE_TRANSLATE_URL = "https://translate.google.com/#view=home&op=translate&sl={sourceLocale}&tl={targetLocale}&text={text}";
    
    const CHROMIUM_PAGE = 'translator';
    
    /**
     * @var Chromium
     */
    protected $chromium;
    
    /**
     * Translator constructor.
     *
     * @param Chromium $chromium
     */
    public function __construct(Chromium $chromium)
    {
        $this->chromium = $chromium;
    }
    
    /**
     * @author Michele Capicchioni <capimichi@gmail.com>
     *
     * @param $sourceLocale
     * @param $targetLocale
     * @param $text
     *
     * @return mixed
     * @throws \Exception
     */
    public function translate($sourceLocale, $targetLocale, $text)
    {
        $url = self::GOOGLE_TRANSLATE_URL;
        $url = str_replace("{sourceLocale}", $sourceLocale, $url);
        $url = str_replace("{targetLocale}", $targetLocale, $url);
        $url = str_replace("{text}", urlencode($text), $url);
        
        $page = $this->chromium->getPage(self::CHROMIUM_PAGE);
        
        try {
            $page->tryCatch->goto($url);
            $page->waitFor(2000);
            $translationBox = $page->querySelector('.result-shield-container > span > span');
            $translationText = $translationBox->evaluate(JsFunction::createWithParameters(['element'])
                ->body("return element.textContent"));
            return ucfirst($translationText);
        } catch (\Exception $exception) {
            throw new \Exception('Cannot translate');
        }
    }
    
}