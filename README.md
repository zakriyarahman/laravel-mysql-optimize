# Laravel MySQL Optimizer

A laravel package that optimizes mysql database tables.

OPTIMIZE TABLE statement is used to reorganize tables and compact any wasted space. The reorganized tables require less disk I/O to perform full table scans.

OPTIMIZE TABLE copies the data part of the table and rebuilds the indexes. The benefits come from improved packing of data within indexes, and reduced fragmentation within the tablespaces and on disk. The benefits vary depending on the data in each table. You may find that there are significant gains for some and not for others, or that the gains decrease over time until you next optimize the table. This operation can be slow if the table is large or if the indexes being rebuilt do not fit into the buffer pool. The first run after adding a lot of data to a table is often much slower than later runs.

For more details, please read the MySQL [website] on optimization techniques. (https://dev.mysql.com/doc/refman/8.0/en/optimization.html)

## Installation

Via Composer

``` bash
$ composer require zakriyarahman/laravel-mysql-optimize
```

## Configuration

This package provides default configuration variables. Publish configuration to your repository for custom configuration.
The default setting for the database is set to the environmental `DB_DATABASE` variable.

``` bash
$ artisan vendor:publish --provider="Zaks\MySQLOptimier\ServiceProvider" --tag=config
```

## Usage

Optimize the database tables with optional database and tables/s.

``` bash
$ artisan db:optimize --database={DATABASE} --table={table[]}
```

### Sample with defaults

Optimizes a default database (which is defined in the configuration of the package) with all the tables in that database.
Publish the package configuration to the change defualt database settings.

``` bash
$ artisan db:optimize
```

### Sample with custom database

Optimizes a custom database separate from the default database configuration.

``` bash
$ artisan db:optimize --database=database_test
```

### Sample with custom table arguments

Optimizes a set of tables only.

``` bash
$ artisan db:optimize --table=table_1 --table=table_2
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

