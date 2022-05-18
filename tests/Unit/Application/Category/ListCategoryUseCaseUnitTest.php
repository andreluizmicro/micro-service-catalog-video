<?php

namespace Tests\Unit\Application\Category;

use Core\Application\Category\ListCategoryUseCase;
use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

use Core\Application\DTO\Category\{
    CategoryInputDTO,
    CategoryOutputDTO
};

class ListCategoryUseCaseUnitTest extends TestCase
{
    public function testGetById()
    {
        $id = (string) Uuid::uuid4()->toString();

        $this->mockEntity = Mockery::mock(Category::class, [
            $id,
            'teste category'
        ]);

        $this->mockEntity->shouldReceive('id')->andReturn($id);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')
                            ->with($id)
                            ->andReturn($this->mockEntity);

        $this->mockInputDTO = Mockery::mock(CategoryInputDTO::class, [
            $id
        ]);

        $useCase = new ListCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryOutputDTO::class, $responseUseCase);
        $this->assertEquals('teste category', $responseUseCase->name);
        $this->assertEquals($id, $responseUseCase->id);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->with($id)->andReturn($this->mockEntity);
        $useCase = new ListCategoryUseCase($this->spy);
        $responseUseCase = $useCase->execute($this->mockInputDTO);
        $this->spy->shouldHaveReceived('findById');

    }

    protected function tearDown(): void
    {
        Mockery::close();
        parent::tearDown();
    }
}