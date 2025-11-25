# Alphavel Framework

> Ultra-fast modular PHP framework powered by Swoole

[![PHP Version](https://img.shields.io/badge/php-%3E%3D8.4-blue.svg)](https://php.net)
[![PSR Compliant](https://img.shields.io/badge/PSR-1%2C3%2C4%2C11%2C12-green.svg)](https://www.php-fig.org/psr/)
[![License](https://img.shields.io/badge/license-MIT-green.svg)](LICENSE)

---

## ✨ Features

- ⚡ **520k+ req/s** - Swoole-powered performance
- 🏗️ **Modular** - Install only what you need  
- 📦 **PSR Compliant** - PSR-1, 3, 4, 11, 12 implemented
- 🎨 **Laravel-style** - Familiar facades, collections, helpers
- 🔄 **Auto-discovery** - Zero-config service providers
- 💉 **DI Container** - Powerful dependency injection
- 🚀 **Modern PHP** - Requires PHP 8.4+

## 📦 Installation

### Create New Project

```bash
composer create-project alphavel/skeleton my-app
cd my-app
php public/index.php
```

### Add to Existing Project

```bash
composer require alphavel/alphavel
```

## 🚀 Quick Start

```php
<?php

use Alphavel\Framework\Application;
use Alphavel\Framework\Response;

$app = Application::getInstance(__DIR__);

$app->get('/', function () {
    return Response::json(['message' => 'Hello Alphavel!']);
});

$app->run();
```

## 📦 Optional Packages

```bash
composer require alphavel/database    # Query Builder + ORM
composer require alphavel/cache       # Redis, File caching
composer require alphavel/validation  # Input validation
composer require alphavel/events      # Event dispatcher
composer require alphavel/logging     # PSR-3 logger
composer require alphavel/support     # Collections, helpers
```

## 📚 Documentation

**Full documentation**: https://github.com/alphavel/documentation

- [Getting Started](https://github.com/alphavel/documentation/blob/master/core/getting-started.md)
- [Architecture](https://github.com/alphavel/documentation/blob/master/core/architecture.md)
- [Service Providers](https://github.com/alphavel/documentation/blob/master/core/service-providers.md)
- [Facades](https://github.com/alphavel/documentation/blob/master/core/facades.md)
- [Performance](https://github.com/alphavel/documentation/blob/master/core/performance.md)

## 📄 License

MIT License
