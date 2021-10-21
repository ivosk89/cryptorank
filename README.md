# laminas-mvc-skeleton

## System requirements
```bash
PHP 7.4
Composer 2.1.9
node 10.19.0
yarn 1.22.15
Google Chrome browser 95.0.4638.54
```

## Installation
```bash
composer install
yarn install
```


Once installed, you can test it out immediately using PHP's built-in web server:

```bash
php -S 0.0.0.0:8080 -t public
# OR use the composer alias:
composer run --timeout 0 serve
```

This will start the cli-server on port 8080, and bind it to all network
interfaces. You can then visit the site at http://localhost:8080/

**Note:** The built-in CLI server is *for development only*.

## Development mode
```bash
$ composer development-enable  # enable development mode
$ composer development-disable # disable development mode
$ composer development-status  # whether or not development mode is enabled
```
