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
        $this->stopPropagation();
        /** @var \Hyperf\Validation\ValidationException $throwable */
        $body = $throwable->validator->errors()->first();
        $arr = [
            'code'=>'40000',
            'msg' => $body
        ];
        return $this->response->json($arr);
    }

    public function isValid(Throwable $throwable): bool
    {
        return $throwable instanceof ValidationException;
    }
}

