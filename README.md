Wiring Start
=======

Wiring is a PHP micro framework core with Interoperability (PSRs).

## Quick start

1. Clone the repo:

    ```bash
    git clone https://github.com/ar2labs/wiring-start.git
    ```

2. Change to the directory created

    ```bash
    cd wiring-skeleton/
    ```

3. Download Composer

    Run this in your terminal to get the latest Composer version:

    ```bash
    curl -sS https://getcomposer.org/installer | php
    ```

    or if you don't have curl:

    ```bash
    php -r "readfile('https://getcomposer.org/installer');" | php
    ```

4. Composer Install

    ```bash
    php composer.phar install
    ```

5. Start PHP Built-in web server:

    ```bash
    php maker serve
    ```

    or use:

    ```bash
    php -S 127.0.0.1:8000 -t public/
    ```

## Requirements

The following versions of PHP are supported by this version.

* PHP 7.1
* PHP 7.2
* PHP 7.3

## Documentation

Contribute to this documentation. ;)

## Copyright and license

Code and documentation copyright (c) 2019, Code released under the BSD-3-Clause license.
