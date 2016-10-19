<?php

/**
 * Converts mysql query result to assoc array
 * @param $result
 * @return array
 */
function assoc_array($result)
{
    $data = [];

    while($row = mysqli_fetch_assoc($result))
    {
        $data[] = $row;
    }

    return $data;
}