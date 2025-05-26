<?php

namespace App\common;

class Resp implements \JsonSerializable
{
    // 状态码常量定义
    public const SUCCESS = 0;           // 成功
    public const NOT_FOUND = 10001;     // 请求的资源不存在
    public const ERROR = 10002;         // 错误
    public const UNAUTHORIZED = 10003;  // 未登录

    public int $code;
    public string $message;
    public bool $status;
    public $data;

    public function __construct(int $code, string $message, bool $status, $data = null)
    {
        $this->code = $code;
        $this->message = $message;
        $this->status = $status;
        $this->data = $data;
    }

    // 实现 JsonSerializable 接口，方便 json_encode
    public function jsonSerialize(): mixed
    {
        return [
            'code' => $this->code,
            'message' => $this->message,
            'status' => $this->status,
            'data' => $this->data,
        ];
    }

    // 输出 JSON 格式响应，默认直接输出并 exit，可以传 false 只返回字符串
    public static function json(self $response, bool $exit = true): ?string
    {
        header('Content-Type: application/json; charset=utf-8');
        $json = json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
        if ($exit) {
            echo $json;
            exit;
        }
        return $json;
    }

    // 统一错误响应，支持传入自定义 HTTP 状态码
    public static function error(string $message = '发生错误', int $code = self::ERROR, int $httpStatusCode = 200): void
    {
        // 根据错误码设置默认 HTTP 状态码，除非外部指定
        if ($httpStatusCode === 200) {
            switch ($code) {
                case self::UNAUTHORIZED:
                    $httpStatusCode = 401;
                    break;
                case self::NOT_FOUND:
                    $httpStatusCode = 404;
                    break;
                default:
                    $httpStatusCode = 200;
                    break;
            }
        }

        http_response_code($httpStatusCode);
        $response = new self($code, $message, false, []);
        self::json($response);
    }

    // 成功响应
    public static function success($data = [], string $message = '成功', int $httpStatusCode = 200): void
    {
        http_response_code($httpStatusCode);
        $response = new self(self::SUCCESS, $message, true, $data);
        self::json($response);
    }

    // 未登录响应
    public static function unauthorized(string $message = '未登录，请先登录！'): void
    {
        self::error($message, self::UNAUTHORIZED, 401);
    }

    // 资源不存在响应
    public static function notFound(string $message = '资源不存在'): void
    {
        self::error($message, self::NOT_FOUND, 404);
    }
}
