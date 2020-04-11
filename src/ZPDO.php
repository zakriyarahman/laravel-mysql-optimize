<?php

namespace Zaks\MySQLOptimier;

class ZPDO extends \PDO
{
    /**
     * Construction
     *
     * @param  string      $dsn
     * @param  string      $dbaUsername
     * @param  string|null $dbaPassword
     */
    public function __contruct(string $dsn, string $dbaUsername, ?string $dbaPassword)
    {
        parent::__contruct($dsn, $dbaUsername, $dbaPassword);
    }
}
