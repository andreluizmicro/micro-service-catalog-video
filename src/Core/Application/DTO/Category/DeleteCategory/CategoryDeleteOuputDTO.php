<?php

namespace Core\Application\DTO\Category\DeleteCategory;

class CategoryDeleteOuputDTO
{
    public function __construct(
        public bool $success
    ) {}
}
