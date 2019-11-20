<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace App\Constants;

use Hyperf\Constants\AbstractConstants;
use Hyperf\Constants\Annotation\Constants;

/**
 * @Constants
 */
class ErrorCode extends AbstractConstants
{
    /**
     * @Message("Server Error！")
     */
    const SERVER_ERROR = 50000;

    /**
     * @Message("Token已失效")
     */
    const TOKEN_INVALID = 70000;

    /**
     * @Message("用户没有注册")
     */
    const USER_NOT_REGIST = 70001;

    /**
     * @Message("参数错误")
     */
    const PARAMS_INVALID = 10000;

    /**
     * @Message("用户不存在")
     */
    const USER_NOT_EXIST = 10001;

    /**
     * @Message("用户越权操作")
     */
    const USER_INVALID = 10002;

    /**
     * @Message("用户密码错误")
     */
    const USER_PASSWORD_INVALID = 10003;

    /**
     * @Message("当前记录不存在")
     */
    const NOTE_NOT_EXIST = 11000;

}
