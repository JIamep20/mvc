<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.10.2016
 * Time: 0:45
 */

namespace Framework;


use App\Exceptions\Exception;

class DB
{
    protected static $conn = false;

    /**
     * Makes query to DB
     * @param $query
     * @return mixed
     * @throws Exception
     */
    public static function query($query)
    {
        if(!self::$conn) {
            self::connect();
        }

        $data = self::$conn->query($query);
        
        if(!$data) {
            throw new Exception(self::$conn->error, 500);
        }

        return $data;
    }

    /**
     * Returns connection error
     * @return mixed
     */
    public static function getError(){
        return self::$conn->error;
    }

    /**
     * Trying to connect to DB
     * @throws Exception
     */
    protected static function connect()
    {
        self::$conn = new \mysqli(SETTINGS['db_host'], SETTINGS['db_user'], SETTINGS['db_password'], SETTINGS['db_name']);

        if(self::$conn->connect_error)
        {
            header("Content-Type: text/html; charset=ISO-1251");
            throw new Exception('Connection to DataBase failed' . (SETTINGS['debug'] ? ': ' . self::$conn->connect_error : '.'), 500);
        }
    }
}