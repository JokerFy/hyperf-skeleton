<?php
/**
 * Created by PhpStorm.
 * User: fin
 * Date: 2020/1/13
 * Time: 17:52
 */

namespace App\Controller\Coroutine;


use App\Controller\AbstractController;
use function foo\func;
use \Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\HttpServer\Contract\ResponseInterface;
use Swoole\Coroutine;

class TrainController extends AbstractController
{
    public function index()
    {
        $time_start = microtime()*1000;
        $file = fopen("./train1.txt", "w");
        fwrite($file, "");
        for ($i = 0; $i < 100; $i++) {
            go(function () use ($i) {
                $id = \Hyperf\Utils\Coroutine::id();
                $file = fopen("./train1.txt", "a+");
                fwrite($file, $i ." - ". $id . "\n");
                fclose($file);
            });
        }
        $time_end = microtime()*1000;

        return $this->response->success(["time"=>($time_end - $time_start)."s"]);
    }

    public function index2()
    {
        $time_start = microtime()*1000;
        $file = fopen("./train2.txt", "w");
        fwrite($file, "");
        for ($i = 0; $i < 100; $i++) {
            $id = \Hyperf\Utils\Coroutine::id();
            $file = fopen("./train2.txt", "a+");
            fwrite($file, $i ." - ". $id . "\n");
            fclose($file);
        }
        $time_end = microtime()*1000;

        return $this->response->success(["time"=>($time_end - $time_start)."s"]);
    }
}
