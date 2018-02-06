<?php
/**
 * Created by PhpStorm.
 * User: GSU
 * Date: 06.02.2018
 * Time: 1:01
 */

class EventHandlersLoader
{


    private $pathToDirectory;
    private $aPathToDirectory;

    public function setPath($pathToDirectory = '')
    {
        self::setIncludePath(self::getArrayPathToDirectory($pathToDirectory));
        spl_autoload_register(array('self', 'autoloadHandlers'));
    }

    private function getArrayPathToDirectory($pathToDirectory)
    {
        static $aPathToDirectory;

        if (!isset($aPathToDirectory)) $aPathToDirectory = array();

        if (is_dir($pathToDirectory)) {
            $aNamesFileAndDirectory = scandir($pathToDirectory);

            if (is_array($aNamesFileAndDirectory)) {
                $aNamesFileAndDirectory = array_diff($aNamesFileAndDirectory, array('.', '..'));

                if (!empty($aNamesFileAndDirectory)) {

                    foreach($aNamesFileAndDirectory as $nameFileOrDirectory) {
                        $fullPathToFileOrDirectory = $pathToDirectory.DIRECTORY_SEPARATOR.$nameFileOrDirectory;

                        if (is_dir($fullPathToFileOrDirectory)) {

                            $goodPath = explode($_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR, $pathToDirectory.DIRECTORY_SEPARATOR.$nameFileOrDirectory.DIRECTORY_SEPARATOR);
                            $aPathToDirectory[] = $goodPath[1];

                            self::getArrayPathToDirectory($fullPathToFileOrDirectory);
                        }
                    }
                }
            }
        }
        return $aPathToDirectory;
    }

    private function setIncludePath($aPathToDirectory)
    {
        set_include_path('.'.PATH_SEPARATOR.implode(PATH_SEPARATOR, $aPathToDirectory));
    }

    private static function autoloadHandlers($className)
    {
        $fileName = strtolower($className.'.php');
        require_once($fileName);
    }


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

            //$_SERVER['DOCUMENT_ROOT']
            self::setPath(__DIR__ . '/HelperEventHandlers/');

        }

    }


    public static function getEventHandlersInfo(){
        $iterator = new RecursiveDirectoryIterator('/HelperEventHandlers/');
        $filter = new RegexIterator($iterator->getChildren(), '/.(php)$/');
        $filelist = array();
        //$arEventHandlersDescriptions = array();
        foreach ($filter as $entry) {
            //require $entry->getFilename();
            $fileContent = file_get_contents($entry->getFilename());
            $szSearchPattern = '~/** [^>]* */>~';
            preg_match_all( $szSearchPattern, $fileContent, $aPics );
            $iNumberOfPics = count($aPics[0]);

            if ( $iNumberOfPics > 0 ) {
                for ( $i=0; $i < $iNumberOfPics ; $i++ ) {
                    echo $entry->getFilename() . "<br>" . $aPics[0][$i];
                };
            };

        }

    }

    
    
    

}