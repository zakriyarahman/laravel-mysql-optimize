# Laravel MySQL Optimizer

A laravel package that optimizes mysql database tables.

## Installation

Via Composer

``` bash
$ composer require zakriyarahman/laravel-mysql-optimize
```

## Configuration

This package provides default configuration variables. Publish configuration to your repository for custom configuration.

``` bash
$ artisan vendor:publish --provider="Zaks\MySQLOptimier\ServiceProvider" --tag=config
```

## Usage

Optimize the database tables with optional database and tables/s.

``` bash
$ artisan db:optimize --database={DATABASE} --table={table[]}
```

## Testing

``` bash
$ composer test
```

## LICENSE

Please see [LICENSE](LICENSE) here

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE_OF_CONDUCT](CODE_OF_CONDUCT.md) for details.

## Credits

- [Zak Rahman][link-author]

## Coding standards

Please follow the following guides and code standards:

* [PSR 4 Coding Standards](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-4-autoloader.md)
* [PSR 2 Coding Style Guide](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-2-coding-style-guide.md)
* [PSR 1 Coding Standards](https://github.com/php-fig/fig-standards/blob/master/accepted/PSR-1-basic-coding-standard.md)

[link-author]: https://github.com/zakriyarahman

