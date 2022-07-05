<?php

namespace App\Helpers;

use Illuminate\Support\Facades\DB;

class DBSwap
{
    public static function setConnection($connection)
    {
        DB::setDefaultConnection($connection);
        DB::purge($connection);
        DB::reconnect($connection);
    }
}