<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.10.2016
 * Time: 2:22
 */

namespace Framework;


/**
 * Class BaseModel
 * @package Framework
 */
abstract class Model
{
    protected $table;

    protected $pdo;

    public function __construct()
    {
        $this->pdo = DB::instance();
    }


    public static function all($columns = ["*"])
    {
        $columns = is_array($columns) ? $columns : func_get_args();

        $instance = new static;

        return $instance->get($columns);
    }

    public function get($columns = ["*"])
    {
        $columns = is_array($columns) ? $columns : func_get_args();
        return $this->pdo->query("select " . implode(", ", $columns) . " from {$this->getTable()};");
    }

    /**
     * @return mixed
     */
    public function getTable()
    {
        if(isset($this->table))
        {
            return $this->table;
        }

        return str_replace('\\', '', strtolower(basename(static::class) . 's'));
    }

    /**
     * @param mixed $table
     */
    public function setTable($table)
    {
        $this->table = $table;
    }


}