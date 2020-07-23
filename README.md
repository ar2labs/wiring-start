Wiring Start
============

[![Build Status](https://travis-ci.org/ar2labs/wiring-start.svg?branch=master)](https://travis-ci.org/ar2labs/wiring-start)
<a href="https://github.com/ar2labs/wiring/blob/master/LICENSE.md"><img src="https://poser.pugx.org/ar2labs/wiring/license.svg" alt="License"></a>

Wiring is a PHP micro framework core with Interoperability (PSRs).

## Quick start

1. Clone the repo:

    ```bash
    git clone https://github.com/ar2labs/wiring-start.git
    ```

2. Change to the directory created

    ```bash
    cd wiring-start/
    ```

3. Composer Install

    ```bash
    composer install
    ```

    or if you don't have a composer installation:

    [Get Composer](https://getcomposer.org/download/)

4. Create `.env`

    ```bash
    cp .env.example .env
    ```

5. Start PHP Built-in web server:

    ```bash
    php maker serve
    ```

    or run with php:

    ```bash
    php -S 127.0.0.1:8000 -t public/
    ```

6. Open your browser at:

    ```bash
    http://127.0.0.1:8000
    ```

## Requirements

The following versions of PHP are supported by this version.

* PHP 7.2
* PHP 7.3
* PHP 7.4

PHP Extension Requirements:

* CMath
* Ctype
* JSON
* Mbstring
* OpenSSL
* PDO
* Tokenizer
* XML

## Copyright and license

Code and documentation copyright (c) 2020, Code released under the <a href="https://github.com/ar2labs/wiring/blob/master/LICENSE.md">BSD-3-Clause license</a>.
