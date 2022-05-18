<?php

namespace Core\Domain\Repository;

interface PaginationInterface
{
    /**
     * Return stdClass
     * 
     * @return stdClass[]
     */
    public function items() : array;   
    
    /**
     * Return total Page
     *
     * @return integer
     */
    public function total(): int;

    /**
     * Return first Page 
     *
     * @return integer
     */
    public function lastPage(): int;

    /**
     * return Fisrt Page
     *
     * @return integer
     */
    public function firstPage(): int;

    /**
     * Return actual Page
     *
     * @return integer
     */
    public function currentPage(): int;

    /**
     * Return Quantity per Page
     *
     * @return integer
     */
    public function perPage():int;

    /**
     * Return first item, page 1, page 7...
     *
     * @return integer
     */
    public function to(): int;

    /**
     * Return from
     *
     * @return integer
     */
    public function from(): int;

}