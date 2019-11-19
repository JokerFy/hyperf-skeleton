<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/11
 * Time: 14:49
 */

namespace App\Exception\Handler;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use Throwable;
use Hyperf\Validation\ValidationException;
use App\Kernel\Http\Response;
use Hyperf\Di\Annotation\Inject;

class ValidationExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject
     * @var Response
     */
    protected $response;

    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 判断被捕获到的异常是希望被捕获的异常
        if ($throwable instanceof ValidationException) {
            /** @var \Hyperf\Validation\ValidationException $throwable */
            $body = $throwable->validator->errors()->first();
            $arr = [
                'code' => 41000,
                'msg' => $body
            ];
            // 阻止异常冒泡
            $this->stopPropagation();
            return $this->response->json($arr);
        }
        // 交给下一个异常处理器
        return $response;
    }

    public function isValid(Throwable $throwable): bool
    {
        if($throwable instanceof ValidationException){
            return true;
        }else{
            return false;
        }
    }
}

