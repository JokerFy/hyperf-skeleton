<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/11
 * Time: 14:49
 */

namespace App\Exception\Handler;
use App\Constants\ErrorCode;
use Hyperf\ExceptionHandler\ExceptionHandler;
use Hyperf\HttpMessage\Stream\SwooleStream;
use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
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

    /**
     * @var ContainerInterface
     */
    protected $container;


    public function handle(Throwable $throwable, ResponseInterface $response)
    {
        // 判断被捕获到的异常是希望被捕获的异常
        if ($throwable instanceof ValidationException) {
            /** @var \Hyperf\Validation\ValidationException $throwable */
            $body = $throwable->validator->errors()->first();
            $arr = json_encode([
                'code' => ErrorCode::PARAMS_INVALID,
                'msg' => $body
            ]);
            // 阻止异常冒泡
            $this->stopPropagation();
/*            $response = $this->container->get($response);
            $response->withStatus(200)->withBody(new SwooleStream($arr));*/
            return $this->response->response()->withStatus(200)
                ->withHeader('Access-Control-Allow-Origin', 'http://localhost:8001')
                ->withHeader('Access-Control-Allow-Credentials', 'true')
                // Headers 可以根据实际情况进行改写。
                ->withHeader('Access-Control-Allow-Headers', 'Accept,X-Requested-With,XMLHttpRequest,DNT,Keep-Alive,User-Agent,Cache-Control,Content-Type,Authorization,token')
                ->withHeader('Access-Control-Allow-Methods', 'GET,POST,PUT,DELETE,OPTIONS')->withBody(new SwooleStream($arr));

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

