<?php

declare(strict_types=1);

namespace App\Kernel\Http;

use App\Constants\ErrorCode;
use Hyperf\HttpMessage\Cookie\Cookie;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Hyperf\Utils\Context;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface as PsrResponseInterface;

class Response
{
    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @var ResponseInterface
     */
    protected $response;

    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->response = $container->get(ResponseInterface::class);
    }

    /**
     * @param array $data
     * @return PsrResponseInterface
     */
    public function success($data = [])
    {
        $data = array_merge([
            'code' => 20000,
            'msg' => 'success'
        ], $data);

        return $this->response->json($data);
    }

    public function successNotify($data = [])
    {
        $data = array_merge([
            'code' => 20000,
            'msg' => 'success'
        ],$this->parse_field($data));

        return $this->response->json($data);
    }

    /**
     * 主要用于将数据库中有下划线的字段转换为驼峰式命名
     * 如role_id = roleId,create_user_id = createUserId
     * */
    public function parse_field($arr)
    {
        $array = [];
        if (gettype($arr) == 'object') {
            $arr = $arr->toArray();
        }

        foreach ($arr as $key => $val) {
            //如果是数组代表是多重数组嵌套
            if (is_array($val)) {
                $array[$key] = $this->parse_field($val);
            } elseif (gettype($val) == 'object') {
                //可能数据是对象
                $array[$key] = $this->parse_field($val->toArray());
            } else {
                $newKey = preg_replace_callback('/_+([a-z])/', function ($matches) {
                    return strtoupper($matches[1]);
                }, $key);
                $array[$newKey] = $val;
            }
        }
        return $array;
    }

    /**
     * @param $data
     * @return PsrResponseInterface
     */
    public function json($data)
    {
        return $this->response->json($data);
    }

    /**
     * @param string $message
     * @param int $code
     * @return PsrResponseInterface
     */
    public function error($message = '', $code = ErrorCode::SERVER_ERROR)
    {
        return $this->response->json([
            'code' => $code,
            'msg' => $message,
        ]);
    }

    public function redirect($url, $status = 302)
    {
        return $this->response()
            ->withAddedHeader('Location', (string)$url)
            ->withStatus($status);
    }

    public function cookie(Cookie $cookie)
    {
        $response = $this->response()->withCookie($cookie);
        Context::set(PsrResponseInterface::class, $response);
        return $this;
    }

    /**
     * @return \Hyperf\HttpMessage\Server\Response
     */
    public function response()
    {
        return Context::get(PsrResponseInterface::class);
    }

}
