<?php
/**
 * Created by PhpStorm.
 * Date: 2019-05-19
 * Time: 14:46
 */

namespace jekyllpay;

use Katzgrau\KLogger\Logger as Klog;
use Exception;

class Jekyllpay
{
    private static $_instance = NULL;

    public static $logger = NULL;

    protected static $_config = [];

    protected $router = ['index', 'index', ];

    protected $result = '';


    public function __construct()
    {
    }

    public function initialize(array $config = [])
    {
        if ( empty(self::$_instance) ) {
            self::$_instance = new self();
        }

        self::$_config = array_merge(self::$_config, $config);

        self::logger();

        spl_autoload_register("self::autoload");

        return $this;
    }

    public static function autoload($className)
    {
        $fileName = APP_PATH . DIRECTORY_SEPARATOR . $className .'.php';
        if (!file_exists($fileName)) {
            $fileName = APP_PATH . DIRECTORY_SEPARATOR . dirname($className) . DIRECTORY_SEPARATOR . ucfirst(basename($className)) .'.php';
        }
        if (!file_exists($fileName)) {
            self::$logger->error('文件没有加载到: '. $fileName);
        }

        return require_once($fileName);
    }

    public function logger()
    {
        if (empty(self::$logger)) {
            self::$logger = new Klog(self::$_config['log']['LOG_PATH'], self::$_config['log']['level'], self::$_config['log']);
        }
        return self::$logger;
    }

    public function router()
    {
        $uri = trim(parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH), '/');
        $path = explode('/', strtolower($uri));

        // 规范URL
        if (!empty($path[0]) && $path[0] == 'index.php') {
            unset($path[0]);
        }
        $this->router = array_filter($path, function ($item) {
            return !empty($item);
        });
        $this->router = array_values($this->router);

        return $this;
    }

    public function runner()
    {
        $this->router();

        require_once(BASE_PATH .'core'. DIRECTORY_SEPARATOR .'controller.php');

        try {
            $cls = "controller\\". $this->router[0];
            $controller = new $cls;
            $this->result = call_user_func([$controller, $this->router[1] ]);
        } catch (Exception $e) {
            throw $e;
        }

        return $this;
    }

    public function output()
    {
        return true;
    }

}



