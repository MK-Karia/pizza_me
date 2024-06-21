<?php
declare(strict_types=1);

namespace App;

class Config
{
    public static function getDatabaseDsn(): string
    {
        return 'mysql:host=127.0.0.1;dbname=pizza_me';
    }

    public static function getDatabaseUser(): string
    {
        return 'mkkaria';
    }

    public static function getDatabasePassword(): string
    {
        return 'mk5serverforweb';
    }
}