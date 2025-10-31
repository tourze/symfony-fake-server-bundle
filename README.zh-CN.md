# Symfony Fake Server Bundle

[English](README.md) | [中文](README.zh-CN.md)

一个 Symfony Bundle，用于返回伪造的服务器头信息，以欺骗扫描器进行无效扫描。

## 安装

```bash
composer require tourze/symfony-fake-server-bundle
```

## 快速开始

1. 将 bundle 添加到您的 `config/bundles.php`：

```php
<?php

return [
    // ...
    Tourze\FakeServerBundle\FakeServerBundle::class => ['all' => true],
];
```

2. Bundle 将自动注册事件订阅器并开始向响应添加伪造的服务器头。

## 使用方法

Bundle 会自动向尚未包含 `Server` 头的 HTTP 响应添加伪造的服务器头。它会从预定义的常见服务器类型列表中随机选择一个，以帮助掩盖实际的服务器技术。

### 可用的伪造服务器头

- `cloudflare`
- `Windows-Azure-Web/1.0`
- `Microsoft-HTTPAPI/2.0`
- `Tengine`
- `nginx`
- `marco/3.2`
- `JSP3/2.0.14`
- `Microsoft-IIS/10.0`

### 示例

当向您的应用程序发出请求时，响应将包含随机选择的服务器头：

```
HTTP/1.1 200 OK
Server: nginx
Content-Type: text/html; charset=UTF-8
...
```

## 配置

此 bundle 开箱即用，无需任何配置。伪造的服务器头会自动应用于所有响应。

## 许可证

MIT
