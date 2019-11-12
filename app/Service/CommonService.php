<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/12
 * Time: 11:03
 */

namespace App\Service;


class CommonService
{
    // 密码加密
    public function setPassword($pwd,$salt)
    {
        $pwd = md5(md5($pwd).$salt);
        return $pwd;
    }
}
