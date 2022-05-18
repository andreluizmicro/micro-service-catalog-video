<?php

namespace Core\Application\Category;

use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;

use Core\Application\DTO\Category\UpdateCategory\{
    CategoryUpdateInputDTO,
    CategoryUpdateOutputDTO
};

class UpdateCategoryUseCase
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(CategoryUpdateInputDTO $input): CategoryUpdateOutputDTO
    {
        $category = $this->repository->findById($input->id);

        $category->update(
            name: $input->name,
            description: $input->description ?? $category->description, // Se for diferente de nulo atualiza com o $input, se for nulo pega o valor que estava antes
        );

        $categoryUpdated = $this->repository->update($category);

        return new CategoryUpdateOutputDTO(
            id: $categoryUpdated->id,
            name: $categoryUpdated->name,
            description: $categoryUpdated->description,
            isActive: $categoryUpdated->isActive,
            created_at: $categoryUpdated->createdAt()
        );
    }
}