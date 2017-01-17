<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 16.10.2016
 * Time: 15:51
 */

namespace Framework;


/**
 * Class BaseException
 * @package Framework
 */
class Exception extends \Exception
{
    protected $statusCode;

    public function __construct($message, $statusCode = 400, $code = 0, \Exception $previous = null)
    {
        $this->statusCode = $statusCode;
        parent::__construct($message, $code, $previous);
    }

    /**
     * Returns respond status code
     * @return int
     */
    public function getStatusCode()
    {
        return $this->statusCode;
    }
}