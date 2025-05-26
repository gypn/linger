<?php

use Bootstrap\Bootstrap;
use Linger\NoahBuscher\Macaw\Macaw;

// 根目录
define('ROOT_DIR', __DIR__ . '/..');
define('PUBLIC_DIR', ROOT_DIR . '/public');
// 数据目录
define('DATA_DIR', ROOT_DIR . '/data');
// session存储目录
define('SESSION_DIR', ROOT_DIR . '/data/session');
// 临时目录
define('TEMP_DIR', ROOT_DIR . '/data/temp');
// 日志目录
define('LOGS_DIR', ROOT_DIR . '/logs');
// 上传目录
define('UPLOAD_DIR', PUBLIC_DIR . '/upload');
// 模板目录
define('TEMPLATES_DIR', ROOT_DIR . '/templates');

// autoload.php
require_once ROOT_DIR . '/vendor/autoload.php';


// 允许跨域访问
header('Access-Control-Allow-Origin: *'); // 允许所有来源
header('Access-Control-Allow-Methods: GET, POST'); // 允许的 HTTP 方法
header('Access-Control-Allow-Headers: Content-Type, Authorization'); // 允许的请求头

// 如果是 OPTIONS 请求，则直接返回成功响应，避免跨域预检请求被阻塞
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// 配置
initEnv(ROOT_DIR . '/.env', ROOT_DIR . '/.env.example');

// 路由初始化
Bootstrap::Init();
// 配置初始化，放在bootstrap::Init(); 后，方法中有seesion目录的创建
require_once ROOT_DIR . '/config/config.php';
// 分发请求，匹配路由并执行回调
Macaw::dispatch();
