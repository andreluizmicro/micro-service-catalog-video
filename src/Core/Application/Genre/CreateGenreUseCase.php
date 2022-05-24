<?php

namespace Core\Application\Genre;

use Core\Application\DTO\Genre\CreateGenre\{
    GenreCreateInputDTO,
    GenreCreateOutputDTO
};
use Core\Application\Interfaces\DBTransactionInterface;
use Core\Domain\Entity\Genre;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\{
    CategoryRepositoryInterface,
    GenreRepositoryInterface
};

class CreateGenreUseCase
{
    protected $genreRepository;
    protected $transaction;
    protected $categoryRepsitory;

    public function __construct(
        GenreRepositoryInterface $GenreRepository,
        DBTransactionInterface $transaction,
        CategoryRepositoryInterface $categoryRepsitory
    
    ) {
        $this->genreRepository = $GenreRepository;
        $this->transaction = $transaction;
        $this->categoryRepsitory = $categoryRepsitory;
    }

    public function execute(GenreCreateInputDTO $input): GenreCreateOutputDTO
    {
        try {
            $genre = new Genre(
                name: $input->name,
                isActive: $input->isActive,
                categoriesId: $input->categoriesId
            );

            $this->validateCategoriesId($input->categoriesId);

            $genreDb = $this->genreRepository->insert($genre);

            return new GenreCreateOutputDTO(
                id: (string) $genreDb->id,
                name: $genreDb->name,
                is_active: $genreDb->isActive,
                created_at:$genreDb->createdAt(),
            );
            $this->transaction->commit();
        } catch (\Throwable $th) {
            $this->transaction->rollback();
            throw $th;
        }
    }

    private function validateCategoriesId(array $categoriesId = [])
    {
        $categoriesDb = $this->categoryRepsitory->getCategoriesIdsByListIds($categoriesId);

        if(count($categoriesDb) != count($categoriesId)) {
            throw new NotFoundException('Category Not Found');
        }
    }
}