<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Genre;

interface GenreRepositoryInterface
{
    /**
    * Insert new Genre
    *
    * @param Genre $genre
    * @return Genre
    */
    public function insert(Genre $genre): Genre;

    /**
    * Find All Genres
    *
    * @param string $filter
    * @param string $order
    * @return Array
    */
    public function findAll(string $filter = '', $order = 'DESC'): Array;

    /**
     * Find Genre by Id
     *
     * @param string $id
     * @return Genre
     */
    public function findById(string $id): Genre;

   /**
    * Find Genre with paginate
    *
    * @param string $filter
    * @param string $order
    * @param integer $page
    * @param integer $totalPage
    * @return PaginationInterface
    */
   public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface;


   /**
    * Update Genre
    *
    * @param Genre $genre
    * @return Genre
    */
   public function update(Genre $genre): Genre;

   /**
    * Delete Genre by Id
    *
    * @param string $id
    * @return boolean
    */
   public function delete(string $id): bool;

}