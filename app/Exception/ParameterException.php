<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/11
 * Time: 14:57
 */

namespace App\Exception;


class ParameterException extends BaseException
{
    public $code = 10000;
    public $statusCode = 200;
    public $msg = "invalid parameters";
}
