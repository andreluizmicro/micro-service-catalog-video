<?php

namespace Tests\Unit\Application\Genre;

use Core\Application\DTO\Genre\CreateGenre\{
    GenreCreateInputDTO,
    GenreCreateOutputDTO
};
use Core\Application\Genre\CreateGenreUseCase;
use Core\Application\Interfaces\DBTransactionInterface;
use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Repository\{
    CategoryRepositoryInterface,
    GenreRepositoryInterface
};
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateGenreUseCaseUnitTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testCreate()
    {
        $uuid = (string) Uuid::uuid4();

        $mockEntity = Mockery::mock(EntityGenre::class, [
            'teste', new ValueObjectUuid($uuid), true, []
        ]);

        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepository = Mockery::mock(StdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('insert')->andReturn($mockEntity);

        $mockDbTransaction = Mockery::mock(stdClass::class, DBTransactionInterface::class);
        $mockDbTransaction->shouldReceive('commit');
        $mockDbTransaction->shouldReceive('rollback');

        $mockCategoryRepository = Mockery::mock(StdClass::class, CategoryRepositoryInterface::class);
        $mockCategoryRepository->shouldReceive('getCategoriesIdsByListIds')->andReturn([$uuid]);

        $mockCreateInputDTO = Mockery::mock(GenreCreateInputDTO::class, [
            'name', [$uuid], true
        ]);

        $useCase = new CreateGenreUseCase($mockRepository, $mockDbTransaction, $mockCategoryRepository);
        $response = $useCase->execute($mockCreateInputDTO);

        $this->assertInstanceOf(GenreCreateOutputDTO::class, $response);

        Mockery::close();
    }
}
