<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/8
 * Time: 17:27
 */

namespace App\Controller\Admin;

use App\Request\UserInfoRequest;
use Hyperf\Di\Annotation\Inject;
use App\Controller\AbstractController;
use App\Service\Formatter\SysUserFormatter;
use App\Service\SysUserService;

class SysUserController extends AbstractController
{
    /**
     * @Inject
     * @var SysUserService
     */
    protected $sysUserService;

    /**
     * 用户信息
     */
    public function getInfo(UserInfoRequest $request)
    {
        $user_id = $request->validated()['user_id'];
        $model = $this->sysUserService->getInfo($user_id);

        return $this->response->successNotify([
            'user' => $model
        ]);
    }
}
