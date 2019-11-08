<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/7
 * Time: 11:21
 */

namespace App\Annotation;

use Hyperf\Di\Annotation\AbstractAnnotation;

/**
 * @Annotation
 * @Target("METHOD")
 */
class User extends AbstractAnnotation
{
    /**
     * @var string
     */
    public $name = 'fangyi';

    public function test(){
        return 'jojo';
    }
}
