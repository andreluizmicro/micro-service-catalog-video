<?php

namespace Core\Application\Interfaces;

interface DBTransactionInterface 
{
    /**
     * Commit updates for alter database
     *
     * @return void
     */
    public function commit();

    /**
     * When catch exception execute rollback
     *
     * @return void
     */
    public function rollback();
}