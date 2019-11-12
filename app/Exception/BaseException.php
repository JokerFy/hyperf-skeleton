<?php
namespace App\Exception;

use App\Constants\ErrorCode;
use Hyperf\Server\Exception\ServerException;
use Throwable;

/**
 * Class BaseException
 * 自定义异常类的基类
 */
class BaseException extends ServerException
{
    public $code = 40000;
    public $msg = 'invalid parameters';
    public $statusCode = 200;

    public $shouldToClient = true;

    /**
     * 构造函数，接收一个关联数组
     * @param array $params 关联数组只应包含code、msg和errorCode，且不应该是空值
     */
    public function __construct($params=[])
    {
        if(!is_array($params)){
            return;
        }
        if(array_key_exists('code',$params)){
            $this->code = $params['code'];
        }
        if(array_key_exists('msg',$params)){
            $this->msg = $params['msg'];
        }
        if(array_key_exists('statusCode',$params)){
            $this->statusCode = $params['statusCode'];
        }

        parent::__construct($this->msg, $this->code);
    }
}

