<?php

namespace Tests\Unit\Application\Genre;

use Core\Application\DTO\Genre\GenreInputDTO;
use Core\Application\DTO\Genre\GenreOutputDTO;
use Core\Application\Genre\ListGenreUseCase;
use Core\Domain\Entity\Genre as EntityGenre;
use Core\Domain\Entity\Genre;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\ValueObject\Uuid as ValueObjectUuid;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class ListGenreUseCaseUnitTest extends TestCase
{
    
    public function testListSingle()
    {
        $uuid = (string) Uuid::uuid4();

        $mockEntity = Mockery::mock(EntityGenre::class, [
            'teste', new ValueObjectUuid($uuid), true, []
        ]);

        $mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $mockRepository = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('findById')->andReturn($mockEntity);

        $mockInputDTO = Mockery::mock(GenreInputDTO::class, [
            $uuid
        ]);

        $useCase = new ListGenreUseCase($mockRepository);
        $response = $useCase->execute($mockInputDTO);

        $this->assertInstanceOf(GenreOutputDTO::class, $response);

        Mockery::close();
    }
}
