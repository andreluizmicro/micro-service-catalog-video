<?php

namespace Test\Unit\Application\Category;

use Core\Application\Category\DeleteCategoryUseCase;
use Core\Application\DTO\Category\CategoryInputDTO;
use Core\Application\DTO\Category\DeleteCategory\CategoryDeleteOuputDTO;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Mockery;
use PHPUnit\Framework\TestCase;
use Ramsey\Uuid\Uuid;
use stdClass;

class DeleteCategoryUseCaseUnitTest extends TestCase
{
    public function testDelete()
    {

        $uuid = (string) Uuid::uuid4()->toString();

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('delete')->andReturn(true);

        $this->mockInputDTO = Mockery::mock(CategoryInputDTO::class, [$uuid]);

        $useCase = new DeleteCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryDeleteOuputDTO::class, $responseUseCase);
        $this->assertTrue($responseUseCase->success);

        /**
         * Spies
         */
        $this->spy = Mockery::spy(stdClass::class, CategoryRepositoryInterface::class);
        $this->spy->shouldReceive('delete')->andReturn(true);
        $useCase = new DeleteCategoryUseCase($this->spy);
        $responseUseCase = $useCase->execute($this->mockInputDTO);
        $this->spy->shouldHaveReceived('delete');

    }

    public function testDeleteFalse()
    {

        $uuid = (string) Uuid::uuid4()->toString();

        $this->mockRepository = Mockery::mock(stdClass::class, CategoryRepositoryInterface::class);
        $this->mockRepository->shouldReceive('delete')->andReturn(false);

        $this->mockInputDTO = Mockery::mock(CategoryInputDTO::class, [$uuid]);

        $useCase = new DeleteCategoryUseCase($this->mockRepository);
        $responseUseCase = $useCase->execute($this->mockInputDTO);

        $this->assertInstanceOf(CategoryDeleteOuputDTO::class, $responseUseCase);
        $this->assertFalse($responseUseCase->success);

    }

    protected function tearDown(): void
    {
        Mockery::close();

        parent::tearDown();
        
    }
    
}