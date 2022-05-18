<?php

namespace Core\Domain\Repository;

use Core\Domain\Entity\Category;

interface CategoryRepositoryInterface
{
    /**
    * Insert new Category
    *
    * @param Category $category
    * @return Category
    */
    public function insert(Category $category): Category;

    /**
    * Find All Categories
    *
    * @param string $filter
    * @param string $order
    * @return Array
    */
    public function findAll(string $filter = '', $order = 'DESC'): Array;

    /**
     * Find Category by Id
     *
     * @param string $id
     * @return Category
     */
    public function findById(string $id): Category;

   /**
    * Find Category with paginate
    *
    * @param string $filter
    * @param string $order
    * @param integer $page
    * @param integer $totalPage
    * @return PaginationInterface
    */
   public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface;


   /**
    * Update Category
    *
    * @param Category $category
    * @return Category
    */
   public function update(Category $category): Category;

   /**
    * Delete Category by Id
    *
    * @param string $id
    * @return boolean
    */
   public function delete(string $id): bool;

}