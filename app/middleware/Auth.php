<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 18.10.2016
 * Time: 19:16
 */

namespace App\Middleware;


use App\Exceptions\Exception;

class Auth extends Middleware
{
    public function __construct()
    {
        $this->handle();
    }

    /**
     * Executions middleware destination
     * @throws Exception
     */
    protected function handle()
    {
        if(!$this->is_authorized()) {
            throw new Exception('Not authorized', 401);
        }
    }
}