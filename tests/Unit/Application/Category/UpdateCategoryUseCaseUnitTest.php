<?php

namespace Tests\Unit\Application\Category;

use Core\Application\Category\UpdateCategoryUseCase;

use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

use Core\Application\DTO\Category\UpdateCategory\{
    CategoryUpdateInputDTO,
    CategoryUpdateOutputDTO
};

class UpdateCategoryUseCaseUnitTest extends TestCase
{
    public function testRenameCategory()
    {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = 'Name';
        $categoryDescription = 'Desc';

        $this->mockEntity = Mockery::mock(EntityCategory::class, [
            $uuid,
            $categoryName,
            $categoryDescription
        ]);

        $this->mockEntity->shouldReceive('update');
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->mockRepository->shouldReceive('update')->andReturn($this->mockEntity);

        $this->mockInputDTO = Mockery::mock(CategoryUpdateInputDTO::class,[
            $uuid,
            'new name'
        ]);

        $useCase = new UpdateCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryUpdateOutputDTO::class, $responseUseCase);
        
        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('findById')->andReturn($this->mockEntity);
        $this->spy->shouldReceive('update')->andReturn($this->mockEntity);
        $useCase = new UpdateCategoryUseCase($this->spy);
        $useCase->execute($this->mockInputDTO);
        $this->spy->shouldHaveReceived('findById');
        $this->spy->shouldHaveReceived('update');


        Mockery::close();
    }
}