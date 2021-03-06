<?php

namespace Core\Application\Genre;

use Core\Application\DTO\Genre\{
    GenreInputDTO,
    GenreOutputDTO
};
use Core\Domain\Repository\GenreRepositoryInterface;

class ListGenreUseCase
{
    protected $repository;

    public function __construct(GenreRepositoryInterface $repository)
    {
        $this->repository = $repository;
    }

    public function execute(GenreInputDTO $input): GenreOutputDTO
    {
        $genre = $this->repository->findById(id: $input->id);

        return new GenreOutputDTO(
            id: (string) $genre->id,
            name: $genre->name,
            is_active: $genre->isActive,
            created_at: $genre->createdAt(),
        );
    }
}