<?php

namespace Tests\Unit\Application\Genre;

use Core\Application\DTO\Genre\ListGenres\{
    ListGenresInputDTO,
    ListGenresOutputDTO
};
use Core\Application\Genre\ListGenresUseCase;
use Core\Domain\Repository\GenreRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class ListGenresUseCaseUnitTest extends TestCase
{
    
    public function testUseCase()
    {
        $mockRepository = Mockery::mock(stdClass::class, GenreRepositoryInterface::class);
        $mockRepository->shouldReceive('paginate')->andReturn($this->mockPagination());

        $mockInputDTO = Mockery::mock(ListGenresInputDTO::class, [
            'teste', 'desc', 1, 15
        ]);

        $useCase = new ListGenresUseCase($mockRepository);
        $response = $useCase->execute($mockInputDTO);

        $this->assertInstanceOf(ListGenresOutputDTO::class, $response);

        Mockery::close();
    }

    protected function mockPagination(array $items = [])
    {
        $this->mockPagination = Mockery::mock(stdClass::class, PaginationInterface::class);
        $this->mockPagination->shouldReceive('total')->andReturn(0);
        $this->mockPagination->shouldReceive('items')->andReturn($items);
        $this->mockPagination->shouldReceive('currentPage')->andReturn(0);
        $this->mockPagination->shouldReceive('lastPage')->andReturn(0);
        $this->mockPagination->shouldReceive('firstPage')->andReturn(0);
        $this->mockPagination->shouldReceive('perPage')->andReturn(0);
        $this->mockPagination->shouldReceive('to')->andReturn(0);
        $this->mockPagination->shouldReceive('from')->andReturn(0);
        
        return $this->mockPagination;
    }
}
