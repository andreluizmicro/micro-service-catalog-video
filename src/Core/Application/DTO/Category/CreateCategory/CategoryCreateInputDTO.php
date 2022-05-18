<?php

namespace Core\Application\DTO\Category\CreateCategory;

class CategoryCreateInputDTO
{
    public function __construct(
        public string $name,
        public string $description = '',
        public bool $isActive = true,
    )
    {
        
    }
}