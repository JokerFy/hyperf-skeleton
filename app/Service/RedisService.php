<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/21
 * Time: 18:06
 */

namespace App\Service;
use Hyperf\Utils\ApplicationContext;

class RedisService
{
    public $redis;
    public function __construct()
    {
        $container = ApplicationContext::getContainer();
        $this->redis = $container->get(\Redis::class);
    }
}
