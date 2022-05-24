<?php

namespace Core\Application\DTO\Genre\CreateGenre;

class GenreCreateOutputDTO
{
    public function __construct(
        public string $id,
        public string $name,
        public bool $is_active,
        public string $created_at = ''
    ) { }
}