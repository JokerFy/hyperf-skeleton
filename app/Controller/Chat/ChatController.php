<?php
declare(strict_types=1);

namespace App\Controller\Chat;

use App\Service\Chat\MessageService;
use App\Service\RedisService;
use Hyperf\Di\Annotation\Inject;
use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

class ChatController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    /**
     * @Inject
     * @var RedisService
     */
    public $redisServe;

    /**
     * @Inject
     * @var MessageService
     */
    public $messageService;

    public $userId = 1;

    public function onMessage(WebSocketServer $server, Frame $frame): void
    {
        $server->push($frame->fd, 'Send by Front: ' . $frame->data);
        // 客户端data结构应该是{"user_id":"1","dstid":"2","content":"123","type":"1"}
        // 1.解析data，获取dstid（目标id）
        // 2.根据redis获取dstid的fd号
        // 3.获取ws当前所有的链接的fd，判断上一步获取的fd号是否存在
        // 4.存在的的话就直接给fd发送消息，否则的话则存入数据库标记为未读信息
    }

    public function onClose(Server $server, int $fd, int $reactorId): void
    {
        //当聊天窗口关闭的时候，删除redis中的user_fd的值，这样就可以保证窗口的唯一性
        $this->redisServe->redis->del('user_'.$this->userId.'_fd');
        $server->push($fd, 'Fd closed: '.$fd);
    }

    public function onOpen(WebSocketServer $server, Request $request): void
    {
        $server->push($request->fd, 'Send By Serve: ' .'Server open ws -> '.$request->fd);
        //获取当前登录的user_id和fd，实时更新到redis中，如果关闭窗口则要销毁
        $this->redisServe->redis->set('user_'.$this->userId.'_fd',3600,$request->fd);
    }

    public function onRequest(WebSocketServer $server, Request $request){
        $server->push($request->fd, 'fangyi666666啊啊啊');
    }
}
