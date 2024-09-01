<?php

namespace Core;

use Twig\Loader\FilesystemLoader;
use Twig\Environment;

class BaseController
{

    private $twig;

    public function __construct()
    {
        // Configure le chemin vers le dossier des vues
        $loader = new FilesystemLoader(__DIR__ . '/../app/Views');
        $this->twig = new Environment($loader, [
            'cache' => false, // Tu peux mettre un chemin vers un dossier de cache
            'debug' => true,  // Activer le mode debug si besoin
        ]);
    }

    /**
     * Charge une vue et transmet des données à la vue
     *
     * @param string $view Le nom de la vue à charger
     * @param array $data Les données à transmettre à la vue
     */
    protected function view($view, $data = [])
    {
        echo $this->twig->render($view . '.html.twig', $data);
        exit;
    }

    /**
     * Renvoie une réponse au format JSON
     *
     * @param mixed $data Les données à encoder en JSON
     * @param int $statusCode Le code de statut HTTP
     */
    protected function json($data, $statusCode = 200)
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        echo json_encode($data);
        exit;
    }

    /**
     * Redirige vers une autre URL
     *
     * @param string $route La route vers laquelle rediriger
     */
    protected function redirect($route)
    {
        header('Location: /' . trim($route, '/'));
        exit;
    }

    protected function redirectPost($url, $data)
    {
        echo '<form id="postForm" method="POST" action="' . htmlspecialchars($url) . '">';
        
        foreach ($data as $key => $value) {
            echo '<input type="hidden" name="' . htmlspecialchars($key) . '" value="' . htmlspecialchars($value) . '">';
        }
        
        echo '</form>';
        
        echo '<script type="text/javascript">
                document.getElementById("postForm").submit();
            </script>';
        
        exit;
    }
}
