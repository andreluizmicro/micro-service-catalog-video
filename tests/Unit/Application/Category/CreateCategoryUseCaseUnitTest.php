<?php

namespace Tests\Unit\Application\Category;

use Core\Application\Category\CreateCategoryUseCase;
use Core\Application\DTO\Category\CreateCategory\{
    CategoryCreateInputDTO,
    CategoryCreateOutputDTO
};
use Core\Domain\Entity\Category;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class CreateCategoryUseCaseUnitTest extends TestCase
{
    public function testCreateNewCategory()
    {
        $uuid = Uuid::uuid4()->toString();
        $categoryName = 'name cat';

        $this->mockEntity = Mockery::mock(Category::class, [
            $uuid,
            $categoryName
        ]);

        $this->mockEntity->shouldReceive('id')->andReturn($uuid);
        $this->mockEntity->shouldReceive('createdAt')->andReturn(date('Y-m-d H:i:s'));

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('insert')->andReturn($this->mockEntity);

        $this->mockInputDTO = Mockery::mock(CategoryCreateInputDTO::class, [
            $categoryName
        ]);

        $useCase = new CreateCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryCreateOutputDTO::class, $responseUseCase);
        $this->assertEquals($categoryName, $responseUseCase->name);
        $this->assertEquals('', $responseUseCase->description);

        /**
         * Garante que está chamando o método insert do repository
         * 
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('insert')->andReturn($this->mockEntity);
        $useCase = new CreateCategoryUseCase($this->spy);
        $responseUseCase = $useCase->execute($this->mockInputDTO);
        $this->spy->shouldHaveReceived('insert');

        Mockery::close();
    }

}