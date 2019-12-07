<?php

namespace Tests\Support;

use Illuminate\Contracts\Console\Kernel;

trait DatabaseSetup
{
    /**
     * @var boolean
     */
    protected static $migrated = false;

    /**
     * Setup the test database.
     *
     * @return void
     */
    public function setupDatabase()
    {
        if ($this->isInMemory()) {
            $this->setupInMemoryDatabase();
            return;
        }
        $this->setupTestDatabase();
    }

    /**
     * Determine if the database is an in memory sqlite database.
     *
     * @return boolean
     */
    protected function isInMemory()
    {
        return config('database.connections')[config('database.default')]['database'] == ':memory:';
    }

    /**
     * Setup an in memory test sqlite database.
     *
     * @return void
     */
    protected function setupInMemoryDatabase()
    {
        $this->artisan('migrate');
        $this->app[Kernel::class]->setArtisan(null);
    }

    /**
     * Setup an none memory test database and start transactions.
     *
     * @return void
     */
    protected function setupTestDatabase()
    {
        if (!static::$migrated) {
            $this->setUpSqliteDatabase();
            $this->artisan('migrate:refresh');
            $this->app[Kernel::class]->setArtisan(null);
            static::$migrated = true;
        }
        $this->beginDatabaseTransaction();
    }

    /**
     * Setup an in memory test sqlite database.
     * @return void
     */
    protected function setUpSqliteDatabase()
    {
        $databaseInUse = config('database.connections')[config('database.default')];

        if ($databaseInUse['driver'] === 'sqlite') {
            shell_exec(sprintf('echo \'\' > %s', $databaseInUse['database']));
        }
    }

    /**
     * Start the Laravel database transactions.
     *
     * @return void
     */
    public function beginDatabaseTransaction()
    {
        $database = $this->app->make('db');

        foreach ($this->connectionsToTransact() as $name) {
            $database->connection($name)->beginTransaction();
        }

        $this->beforeApplicationDestroyed(function () use ($database) {
            foreach ($this->connectionsToTransact() as $name) {
                $database->connection($name)->rollBack();
            }
        });
    }

    /**
     * Determine the connection to start the transactions one
     * @return array
     */
    protected function connectionsToTransact()
    {
        return property_exists($this, 'connectionsToTransact') ? $this->connectionsToTransact : [null];
    }
}
