<?php
/**
 * Created by PhpStorm.
 * User: GSU
 * Date: 06.02.2018
 * Time: 1:01
 */

class EventHandlersLoader
{

    /**
     * @param $strHandlerName
     * подключение обработчика события
     */
    public static function includeEventHandler($strHandlerName)
    {

        if ($strHandlerName) {
            $arHandlerName = explode("_", $strHandlerName);
            require_once(__DIR__ . '/HelperEventHandlers/' . $arHandlerName[0] . '/' . $arHandlerName[1] . '/' . $arHandlerName[2] . '.php');
        } else {

            $directory = new \RecursiveDirectoryIterator(__DIR__ . '/HelperEventHandlers/');
            $iterator = new \RecursiveIteratorIterator($directory);
            foreach ($iterator as $info) {

                if ($info->getFilename()[0] === '.') continue;
                require_once ($info->getPathname());
            }

        }

    }


    /**
     * @param string $inEncode
     * @param string $outEncode
     * список доступных для подключения обработчиков событий
     */
    public static function getEventHandlersInfo($inEncode = "utf-8", $outEncode = "windows-1251"){

        $directory = new \RecursiveDirectoryIterator(__DIR__ . '/HelperEventHandlers/');
        $iterator = new \RecursiveIteratorIterator($directory);
        foreach ($iterator as $info) {

            if ($info->getFilename()[0] === '.') continue;
            $fileContent = file_get_contents($info->getPathname());

            $tokens = token_get_all($fileContent);

            echo iconv($inEncode, $outEncode, $tokens[2][1]) . "<br>" . $tokens[12][1] . "<hr>";

        }

    }


}