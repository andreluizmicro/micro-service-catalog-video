<?php

namespace Core\Application\DTO\Category\ListCategories;

class ListCategoriesOutputDTO
{
    public function __construct(
        public int $total,
        public int $last_page,
        public int $first_page,
        public int $per_page,
        public int $to,
        public int $from,
        public array $items,
    ) { }
}