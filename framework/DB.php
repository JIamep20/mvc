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
    protected $pdo = null;
    protected static $instance = null;


    public function __construct()
    {
        $dsn = "mysql:host=" . SETTINGS['db_host'] . ";dbname=" . SETTINGS['db_name'] . ";charset=utf8";
        $opt = array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC
        );
        $this->pdo = new \PDO($dsn, SETTINGS['db_user'], SETTINGS['db_password'], $opt);
    }

    public static function instance()
    {
        if (self::$instance === null) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    public function query($query)
    {
        $s = $this->pdo->prepare($query);
        $res = $s->execute();

        if ($res !== false) {
            return $s->fetchAll();
        }

        return [];
    }

    public function execute($query)
    {
        $s = $this->pdo->prepare($query);

        return $s->execute();
    }

    public function getError()
    {
        return $this->pdo->errorInfo();
    }

    protected function r($statement)
    {
        dump($statement->queryString);
    }
}