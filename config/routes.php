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

use Hyperf\HttpServer\Router\Router;

//Router::addRoute(['GET', 'POST', 'HEAD'], '/', 'App\Controller\IndexController@index');
Router::addServer('websocket', function () {
    Router::get('/', 'App\Controller\WebSocketController');
});

Router::addServer('http', function () {
    Router::post('/sys/login', 'App\Controller\Admin\SysUserController@login');
});


Router::addGroup('/hy-admin/', function () {
    Router::get('sys/user/info/{id:\d+}', 'App\Controller\Admin\SysUserController@getInfo'); // 获取用户信息
}, ['middleware' => [\App\Middleware\JwtAuthMiddleware::class]]);


