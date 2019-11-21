<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2019/11/21
 * Time: 19:52
 */

namespace App\Service\Chat;
use App\Model\Chat\Message;
use Hyperf\Di\Annotation\Inject;

class MessageService
{
    /**
     * @Inject
     * @var Message
     */
    protected $message;

}
