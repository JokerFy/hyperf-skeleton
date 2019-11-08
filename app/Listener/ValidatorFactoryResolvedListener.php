<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/8
 * Time: 20:32
 */
namespace App\Listener;

use Hyperf\Di\Annotation\Inject;
use App\Service\SysUserService;
use Hyperf\Event\Contract\ListenerInterface;
use Hyperf\Validation\Contract\ValidatorFactoryInterface;
use Hyperf\Validation\Event\ValidatorFactoryResolved;

class ValidatorFactoryResolvedListener implements ListenerInterface
{
    /**
     * @Inject
     * @var SysUserService
     */
    protected $sysUserService;

    public function listen(): array
    {
        return [
            ValidatorFactoryResolved::class,
        ];
    }

    public function process(object $event)
    {
        /**  @var ValidatorFactoryInterface $validatorFactory */
        $validatorFactory = $event->validatorFactory;
        // 注册了 foo 验证器
        $validatorFactory->extend('userCheck', function ($attribute, $value, $parameters, $validator) {
            $user = $this->sysUserService->userCheck($value);
            if(!$user) return $value == 'user';
        });
        // 当创建一个自定义验证规则时，你可能有时候需要为错误信息定义自定义占位符这里扩展了 :foo 占位符
        $validatorFactory->replacer('user', function ($message, $attribute, $rule, $parameters) {
            return str_replace(':user', $attribute, $message);
        });
    }

}
