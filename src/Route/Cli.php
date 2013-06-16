<?php
/**
 * Cli.php.
 */

namespace Route;

use Pagon\Route\Cli as Route;

class Cli extends Route
{
    protected function before()
    {
        $this->loadOrm();
    }

    /**
     * Load ORM and database
     */
    protected function loadOrm()
    {
        $this->app->loadOrm();
    }
}