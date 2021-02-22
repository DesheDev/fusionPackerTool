<?php
    
    function createLoader() {
        /**
         * Obtenemos el loader y lo comprimimos
         */
        $contenido = "";
        $ruta = "source/core/loader/";
        //$contenido .= file_get_contents("{$ruta}path.php") . "\n";
        $contenido .= file_get_contents("{$ruta}mainLoader.php") . "\n";
        //$contenido .= file_get_contents("{$ruta}routersLoader.php") . "\n";
        $fichero = "dist/core/appCore.php";
        file_put_contents($fichero, $contenido, FILE_APPEND);
    }

    function createBaseMod() {
        $directorios = file_get_contents("build.json");
        $directorios = json_decode($directorios, true);
        foreach ($directorios['directories'] as $carpetas) {
            mkdir("dist/{$carpetas}");
        }
        /**
         * Obtenemos las librerias y las juntamos
         */
        $contenido = "";
        foreach (glob("source/core/modules/*.php") as $baseModule) {
            $contenido .= file_get_contents($baseModule) . "\n";
        }
        $fichero = "dist/core/appCore.php";
        file_put_contents($fichero, $contenido);
    }

    function versionData () {
        date_default_timezone_set("America/Mexico_City");
        $version = file_get_contents("build.json");
        $version = json_decode($version, true);
        
        $version['build']       = $version['build'] + 1;
        $version['buildDate']   = date("F j, Y, g:i a");
        $contenido              = json_encode($version);
        
        $fichero = "build.json";
        file_put_contents($fichero, $contenido);
        
        unset($version['directories']);
        $contenido  = json_encode($version);
        $fichero    = "dist/core/config/fusionVersion.json";
        file_put_contents($fichero, $contenido);
    }

    function cleanCore() {
        $fichero = "dist/core/appCore.php";
        $contenido = file_get_contents($fichero);
        $cleanCore = str_replace("<?php","", $contenido);
        $cleanCore = str_replace("?>","", $cleanCore);
        $cleanCore = "<?php" . $cleanCore . "?>";
        
        file_put_contents($fichero, $cleanCore);
    }

    //transferConf();
    createBaseMod();
    createLoader();
    versionData();
    cleanCore();
?>