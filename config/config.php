<?php

// 设置默认时区
date_default_timezone_set('Asia/Shanghai');

// 设置字符编码
ini_set('default_charset', 'UTF-8');

// 启用输出缓冲
ini_set('output_buffering', 'On');

// 设置本地化环境
setlocale(LC_ALL, 'zh_CN.UTF-8');

// 设置 session 存储目录
ini_set('session.save_path', SESSION_DIR);

// 配置 session cookie 安全设置
ini_set('session.cookie_lifetime', 0);  // 会话结束后立即删除 cookie
ini_set('session.cookie_secure', '1');  // 仅通过 HTTPS 传输 session cookie
ini_set('session.cookie_httponly', '1');  // 防止 JavaScript 访问 session cookie
ini_set('session.use_strict_mode', 1);  // 启用严格模式，防止通过预测性 ID 像生成 session ID

// 启动 session
session_start();

// 禁用危险的 PHP 函数
ini_set('disable_functions', 'exec,passthru,shell_exec');

// 根据操作系统设置错误报告和日志配置
$isDebug = getenv('LINGR_DEBUG') === 'true';
$osSeparator = PHP_OS_FAMILY === 'Windows' ? '\\' : '/';  // 根据操作系统选择路径分隔符

// 设置错误报告级别
if ($isDebug) {
    // 开发环境
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
} else {
    // 生产环境
    error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);  // 移除 E_STRICT
    ini_set('display_errors', '0');
    ini_set('log_errors', '1');
    ini_set('error_log', LOGS_DIR . $osSeparator . 'php_error.log');  // 根据操作系统设置路径分隔符
}
