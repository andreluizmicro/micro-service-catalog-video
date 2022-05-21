<?php

namespace Core\Application\Genre;

use Core\Application\DTO\Genre\ListGenres\ListGenresInputDTO;
use Core\Application\DTO\Genre\ListGenres\ListGenresOutputDTO;
use Core\Domain\Repository\GenreRepositoryInterface;

class ListGenresUseCase
{
    public function __construct(protected GenreRepositoryInterface $repository) { } 
    
    public function execute(ListGenresInputDTO $input): ListGenresOutputDTO
    {
        $response = $this->repository->paginate(
            filter: $input->filter,
            order: $input->order,
            page: $input->page,
            totalPage: $input->totalPage,
        );

        return new ListGenresOutputDTO(
            items: $response->items(),
            total: $response->total(),
            current_page: $response->currentPage(),
            last_page: $response->lastPage(),
            first_page: $response->firstPage(),
            per_page: $response->perPage(),
            to: $response->to(),
            from: $response->from()
        );
    }
}