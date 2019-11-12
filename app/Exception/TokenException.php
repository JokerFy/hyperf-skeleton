<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/11
 * Time: 14:57
 */

namespace App\Exception;


class TokenException extends BaseException
{
    public $code = 40002;
    public $statusCode = 200;
    public $msg = "token验证失败";
}
