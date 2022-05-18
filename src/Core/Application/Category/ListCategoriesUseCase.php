<?php

namespace Core\Application\Category;

use Core\Application\DTO\Category\ListCategories\{
    ListCategoriesInputDTO,
    ListCategoriesOutputDTO
};

use Core\Domain\Repository\CategoryRepositoryInterface;

class ListCategoriesUseCase 
{
    protected $repository;

    public function __construct(CategoryRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(ListCategoriesInputDTO $input): ListCategoriesOutputDTO
    {
        $categories = $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage
        );

        return new ListCategoriesOutputDTO(
            items: $categories->items(),
            total: $categories->total(),
            last_page: $categories->lastPage(),
            first_page: $categories->firstPage(),
            per_page: $categories->perPage(),
            to: $categories->to(),
            from: $categories->from()
        );

        // return new ListCategoriesOutputDTO(
        //     items: array_map(function ($data) {
        //         return [
        //             'id' => $data->id,
        //             'name' => $data->name,
        //             'description' => $data->description,
        //             'is_active' => (bool) $data->is_active,
        //             'created_at' => (string) $data->createdAt()
        //         ];
        //     }, $categories->items()),
        //     total: $categories->total(),
        //     last_page: $categories->lastPage(),
        //     first_page: $categories->firstPage(),
        //     per_page: $categories->perPage(),
        //     to: $categories->to(),
        //     from: $categories->from()
        // );
    }
}