<?php

namespace Tests\Feature\Core\Application\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Application\Category\CreateCategoryUseCase;
use Core\Application\DTO\Category\CreateCategory\CategoryCreateInputDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateCategoryUseCaseTest extends TestCase
{
    public function testCreate()
    {
        $repository = new CategoryEloquentRepository(new Model());
        $useCaseCategory =  new CreateCategoryUseCase($repository);
        $responseUseCase = $useCaseCategory->execute(
            new CategoryCreateInputDTO(
                name: 'Teste',
            )
        );

        $this->assertEquals('Teste', $responseUseCase->name);
        $this->assertNotEmpty($responseUseCase->id);

        $this->assertDatabaseHas('categories', [
            'id' => $responseUseCase->id
        ]);
    }
}
