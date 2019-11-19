<?php

declare(strict_types=1);

namespace App\Middleware;

use App\Constants\Constants;
use App\Kernel\Http\Response;
use App\Service\Instance\JwtInstance;
use App\Service\SysMenuService;
use App\Service\SysUserService;
use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Annotation\Inject;
use Hyperf\HttpServer\Contract\RequestInterface;
use Hyperf\Logger\LoggerFactory;
use Phper666\JwtAuth\Jwt;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

class AdminMiddleware implements MiddlewareInterface
{
    /**
     * @Inject
     * @var Jwt
     */
    protected $jwt;

    /**
     * @var ContainerInterface
     */
    protected $container;

    /**
     * @Inject()
     * @var Response
     */
    private $respone;

    /**
     * @var LoggerFactory;
     */
    protected $logger;

    /**
     * @Inject
     * @var SysMenuService
     */
    protected $sysMenuService;


    public function __construct(ContainerInterface $container)
    {
        $this->container = $container;
        $this->logger = $container->get(StdoutLoggerInterface::class);
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        $request = $this->container->get(RequestInterface::class);
        $admin_id = $this->jwt->getParserData()['user_id'];
        $uri = $request->getRequestUri();
        $urIs = explode('/', $uri);

        $perms = null;
        if (count($urIs) >= 5) { // 权限标识
            $perms = $urIs[2] . ":" . $urIs[3] . ":" . $urIs[4];
        }

        $this->logger->notice(PHP_EOL . 'TIME:' . date("Y-m-d h:i:s") . PHP_EOL . "PERMS:" . $perms . PHP_EOL . "IP:" . $request->getServerParams()["remote_addr"]);

        if (env('APP_DEBUG', false) === true) {
            if($admin_id = 1){
                return $handler->handle($request);
            }
        }

        try {
            $this->jwt->checkToken();
        } catch (\Throwable $e) {
            $this->logger->error($e->getMessage());
//            return $this->respone->error($this->jwt->getHeaderToken());
//            return $this->respone->error($this->jwt->getTokenObj());
            return $this->respone->error($e->getMessage());
        }

        $allowPermissions = [];

        if ($admin_id != 1) {

            $data = $this->sysMenuService->nav($admin_id);
            if(!$data['permissions']){
                return $this->respone->error(Constants::PERMISSION_DENIED);
            }

            if (!empty($perms)) {
                // 没有访问权限
                if (!in_array($perms,$allowPermissions) && !in_array($perms, $data['permissions'])) {
                    return $this->respone->error(Constants::PERMISSION_DENIED);
                }
            }
        }

        return $handler->handle($request);
    }
}
