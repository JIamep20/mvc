<?php

/**
 * Method for rendering app views
 * @param $view
 * @param array $args
 */
function render($view, $args = [])
{
    $loader = new Twig_Loader_Filesystem(TEMPLATES_DIR);
    $twig = new Twig_Environment($loader, SETTINGS['twig']['cache'] ? ['cache' => CACHE_DIR] : []);

    twig_extensions($twig);

    $template = $twig->loadTemplate($view . '.twig');
    $template->display($args);
}

