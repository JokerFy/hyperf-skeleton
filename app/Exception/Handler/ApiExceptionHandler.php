<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/11
 * Time: 19:46
 */

namespace App\Exception\Handler;

use App\Exception\RequestException;
use App\Kernel\Http\Response;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Psr\Http\Message\ResponseInterface;
use App\Exception\BaseException;
use Hyperf\Di\Annotation\Inject;
use Throwable;

class ApiExceptionHandler extends ExceptionHandler
{
    /**
     * @Inject
     * @var Response
     */
    protected $response;
    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 判断被捕获到的异常是希望被捕获的异常
        if ($throwable instanceof BaseException) {
            // 格式化输出
            $data = [
                'code' => $throwable->code,
                'message' => $throwable->msg,
            ];

            // 阻止异常冒泡
            $this->stopPropagation();
            return $this->response->json($data);
//            return $response->withStatus(200)->withBody(new SwooleStream($data));
        }

        // 交给下一个异常处理器
        return $response;

        // 或者不做处理直接屏蔽异常
    }

    /**
     * 判断该异常处理器是否要对该异常进行处理
     */
    public function isValid(Throwable $throwable): bool
    {
        if($throwable instanceof BaseException){
            return true;
        }else{
            return false;
        }
    }
}
