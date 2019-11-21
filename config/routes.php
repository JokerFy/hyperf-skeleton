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
    Router::get('/', 'App\Controller\Chat\ChatController');
});

Router::addGroup('/common/sys/', function () {
    Router::post('login', 'App\Controller\Admin\SysLoginController@login');
});


Router::addGroup('/hy-admin/', function () {
    // 获取用户列表
    Router::get('sys/user/list', 'App\Controller\Admin\SysUserController@list');
    // 获取登录用户信息
    Router::get('sys/user/info', 'App\Controller\Admin\SysUserController@getInfo');
    // 根据Id获取登录用户信息
    Router::get('sys/user/infoById', 'App\Controller\Admin\SysUserController@getInfoById');
    // 添加用户
    Router::post('sys/user/save', 'App\Controller\Admin\SysUserController@save');
    // 删除用户
    Router::delete('sys/user/delete', 'App\Controller\Admin\SysUserController@delete');
    // 更新用户
    Router::put('sys/user/update', 'App\Controller\Admin\SysUserController@update');


    // 获取导航菜单列表 / 权限
    Router::get('sys/menu/nav', 'App\Controller\Admin\SysMenuController@nav');
    // 获取菜单列表
    Router::get('sys/menu/list', 'App\Controller\Admin\SysMenuController@list');
    // 获取上级菜单
    Router::get('sys/menu/select', 'App\Controller\Admin\SysMenuController@select');
    // 获取菜单信息
    Router::get('sys/menu/info', 'App\Controller\Admin\SysMenuController@info');
    // 添加菜单
    Router::post('sys/menu/save', 'App\Controller\Admin\SysMenuController@save');
    // 修改菜单
    Router::put('sys/menu/update', 'App\Controller\Admin\SysMenuController@update');
    // 删除菜单
    Router::delete('sys/menu/delete', 'App\Controller\Admin\SysMenuController@delete');


    // 获取角色列表
    Router::get('sys/role/list', 'App\Controller\Admin\SysRoleController@list');
    // 获取角色列表, 根据当前用户
    Router::get('sys/role/select', 'App\Controller\Admin\SysRoleController@select');
    // 获取角色信息
    Router::get('sys/role/info', 'App\Controller\Admin\SysRoleController@info');
    // 添加角色
    Router::post('sys/role/save', 'App\Controller\Admin\SysRoleController@save');
    // 修改角色
    Router::put('sys/role/update', 'App\Controller\Admin\SysRoleController@update');
    // 删除角色
    Router::delete('sys/role/delete', 'App\Controller\Admin\SysRoleController@delete');

    Router::post('sys/user/test', 'App\Controller\Admin\SysUserController@test'); // 获取用户列表
});
//, ['middleware' => [\App\Middleware\AdminMiddleware::class]];


