<?php

/**Provides additional functions in views
 * @param $twig
 */

function twig_extensions($twig)
{
    $twig->addFunction(new Twig_SimpleFunction('session_get', function($subject = 'info') {
        if(array_key_exists($subject, $_SESSION)) {
            $temp = $_SESSION[$subject];
            unset($_SESSION[$subject]);
            return $temp;
        }
        return null;
    }));

    $twig->addFunction(new Twig_SimpleFunction('session_check', function($subject = 'info') {
        if(array_key_exists($subject, $_SESSION)) {
            return true;
        }
        return false;
    }));

    $twig->addFunction(new Twig_SimpleFunction('is_authorized', function() {
        return array_key_exists('login', $_SESSION);
    }));
}