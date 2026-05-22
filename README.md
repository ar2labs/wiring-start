# Wiring Start

[![Build](https://github.com/ar2labs/wiring-start/actions/workflows/build.yml/badge.svg?branch=master)](https://github.com/ar2labs/wiring-start/actions/workflows/build.yml)
[![License](https://poser.pugx.org/ar2labs/wiring/license.svg)](https://github.com/ar2labs/wiring/blob/master/LICENSE.md)

Starter application for [ar2labs/wiring](https://github.com/ar2labs/wiring), a PSR-oriented PHP microframework backend.

## Stack

- PHP 8.5
- Wiring 2.3.7
- PHP-DI 7
- League Route 6
- Laminas Diactoros 3
- Eloquent 13
- Twig 3
- Symfony Console 8

## Quick Start

```bash
composer create-project ar2labs/wiring-start
cd wiring-start
cp .env.example .env
php maker serve
```

Open:

```bash
http://localhost:8000
```

You can also use Composer's script:

```bash
composer serve
```

## Quality Checks

```bash
composer test
composer php-cs-fixer
composer phpstan
```

## Requirements

- PHP 8.5+
- Composer 2
- PHP extensions: JSON, Mbstring, PDO

## Structure

- `app/App`: HTTP controllers, middleware, providers and models
- `app/Console`: CLI commands used by `maker`
- `boot`: application and container bootstrap
- `config`: application configuration
- `public`: web root
- `resources/view`: Twig templates
- `routes`: web and API routes
- `storage`: local database, cache and logs

## License

BSD-3-Clause. See [LICENSE.md](LICENSE.md).
