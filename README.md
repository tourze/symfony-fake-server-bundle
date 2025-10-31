# Symfony Fake Server Bundle

[English](README.md) | [中文](README.zh-CN.md)

A Symfony bundle that returns fake server headers to deceive scanners and perform invalid scans.

## Installation

```bash
composer require tourze/symfony-fake-server-bundle
```

## Quick Start

1. Add the bundle to your `config/bundles.php`:

```php
<?php

return [
    // ...
    Tourze\FakeServerBundle\FakeServerBundle::class => ['all' => true],
];
```

2. The bundle will automatically register the event subscriber and start adding fake server headers to responses.

## Usage

The bundle automatically adds a fake `Server` header to HTTP responses that don't already have one. It randomly selects from a predefined list of common server types to help mask the actual server technology.

### Available Fake Server Headers

- `cloudflare`
- `Windows-Azure-Web/1.0`
- `Microsoft-HTTPAPI/2.0`
- `Tengine`
- `nginx`
- `marco/3.2`
- `JSP3/2.0.14`
- `Microsoft-IIS/10.0`

### Example

When a request is made to your application, the response will include a randomly selected server header:

```
HTTP/1.1 200 OK
Server: nginx
Content-Type: text/html; charset=UTF-8
...
```

## Configuration

This bundle works out of the box with no configuration required. The fake server headers are automatically applied to all responses.

## License

MIT