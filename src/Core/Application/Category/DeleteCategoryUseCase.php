<?php

namespace Core\Application\Category;

use Core\Application\DTO\Category\CategoryInputDTO;
use Core\Application\DTO\Category\DeleteCategory\CategoryDeleteOuputDTO;
use Core\Domain\Repository\CategoryRepositoryInterface;

class DeleteCategoryUseCase 
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryInputDTO $input): CategoryDeleteOuputDTO
    {
        
        $reponseDelete = $this->repository->delete($input->id);

        return new CategoryDeleteOuputDTO(
            success: $reponseDelete
        );
    }
}