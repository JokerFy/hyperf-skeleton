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
        $validated = $request->validated();
/*        $data = $request->validated();
        return $this->response->success([
            'user' => $data
        ]);*/
        $model = $this->sysUserService->getInfo(1);
        $format = SysUserFormatter::instance()->forArray($model);

        return $this->response->success([
            'user' => $format
        ]);
    }
}
