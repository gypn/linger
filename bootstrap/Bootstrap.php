<?php

namespace Bootstrap;

use App\common\Resp;
use Linger\NoahBuscher\Macaw\Macaw;

class Bootstrap
{
    // 目录检查
    private static function dir()
    {
        // 检查并创建必要的目录
        createDirectoryIfNotExist(DATA_DIR);      // 创建数据目录
        createDirectoryIfNotExist(SESSION_DIR);   // 创建会话目录
        createDirectoryIfNotExist(TEMP_DIR);      // 创建临时目录
        createDirectoryIfNotExist(LOGS_DIR);      // 创建日志目录
        createDirectoryIfNotExist(UPLOAD_DIR);    // 创建上传目录
        createDirectoryIfNotExist(TEMPLATES_DIR); // 创建模板目录
    }

    // route 初始化路由
    private static function route()
    {
        // error 提示
        Macaw::error(function () {
            http_response_code(404); // 明确返回 404 状态码
            Resp::notFound();
        });

        // 加载自定义路由文件
        foreach (glob(ROOT_DIR . '/routes/*.php') as $file) {
            require_once $file;
        }
    }

    // Init 初始化
    public static function Init()
    {
        // 目录
        self::dir();

        // 路由初始化
        self::route();
    }
}
