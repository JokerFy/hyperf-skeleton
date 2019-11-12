<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/11
 * Time: 14:57
 */

namespace App\Exception;


class LoginException extends BaseException
{
    public $code = 40001;
    public $statusCode = 200;
    public $msg = "登录失败";
}
