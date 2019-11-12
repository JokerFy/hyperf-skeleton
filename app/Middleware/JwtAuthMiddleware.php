<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/11
 * Time: 17:04
 */

namespace App\Middleware;

use App\Exception\TokenException;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface as HttpResponse;
use Phper666\JwtAuth\Exception\JWTException;
use Phper666\JwtAuth\Jwt;
use Hyperf\Di\Annotation\Inject;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;

class JwtAuthMiddleware
{
    /**
     * @var ContainerInterface
     */
    protected $container;


    /**
     * @Inject
     * @var Jwt
     */
    protected $jwt;

    /**
     * @var RequestInterface
     */
    protected $request;

    /**
     * @var HttpResponse
     */
    protected $response;

    public function __construct(ContainerInterface $container, HttpResponse $response, RequestInterface $request)
    {
        $this->container = $container;
        $this->response = $response;
        $this->request = $request;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // 根据具体业务判断逻辑走向，这里假设用户携带的token有效
        $request->getHeaders('token');
        try{
            $isValidToken = $this->jwt->checkToken();
        }catch (\Exception $e){
            throw new TokenException(['msg'=>$e->getMessage()]);
        }

        if ($isValidToken) {
            return $handler->handle($request);
        }
    }
}
