<?php
declare(strict_types=1);

namespace App\Controller;

use Hyperf\Contract\OnCloseInterface;
use Hyperf\Contract\OnMessageInterface;
use Hyperf\Contract\OnOpenInterface;
use Swoole\Http\Request;
use Swoole\Server;
use Swoole\Websocket\Frame;
use Swoole\WebSocket\Server as WebSocketServer;

class WebSocketController implements OnMessageInterface, OnOpenInterface, OnCloseInterface
{
    public function onMessage(WebSocketServer $server, Frame $frame): void
    {
        $server->push($frame->fd, 'Recv: ' . $frame->data);
        $server->push($frame->fd, 'Recv: ' . 9999);
    }

    public function onClose(Server $server, int $fd, int $reactorId): void
    {

        var_dump('closedadfadfa');
    }

    public function onOpen(WebSocketServer $server, Request $request): void
    {
        $server->push($request->fd, 'fangyi666666把');
        $server->push($request->fd, 'Opened');
    }

    public function onRequest(WebSocketServer $server, Request $request){
        $server->push($request->fd, 'fangyi666666啊啊啊');
    }
}
