<?php

declare(strict_types=1);

namespace App\Exception;

use App\Constants\ErrorCode;
use Hyperf\Server\Exception\ServerException;
use Throwable;

class RequestException extends BaseException
{
    public $code = ErrorCode::PARAMS_INVALID;
    public $msg = '';
    public $statusCode = 200;
}
