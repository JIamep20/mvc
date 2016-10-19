<?php

/**
 * Redirects user to specified URL
 * @param string $path
 */
function redirect($path = '')
{
    header('Location: http://' . $_SERVER['SERVER_NAME'] . '/' . trim($path, '/'));
    die();
}
