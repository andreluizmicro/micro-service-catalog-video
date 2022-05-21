<?php

namespace Core\Application\DTO\Genre\ListGenres;

class ListGenresInputDTO
{
    public function __construct(
        public string $filter = '',
        public string $order = 'DESC',
        public int $page = 1,
        public $totalPage = 15,
    ) { }
}