<?php

/**
 * Function for convenient var_dumping
 * @param $data
 * @param bool $exit
 */
function dump($data, $exit = false) {
    echo '<pre>';
    var_dump($data);
    echo '</pre>';

    if($exit) exit;
}