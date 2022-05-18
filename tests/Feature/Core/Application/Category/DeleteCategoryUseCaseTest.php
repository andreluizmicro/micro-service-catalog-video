<?php

namespace Tests\Feature\Core\Application\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Application\Category\DeleteCategoryUseCase;
use Core\Application\DTO\Category\CategoryInputDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DeleteCategoryUseCaseTest extends TestCase
{
    
    public function testDelete()
    {
        $categoryDb = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCaseCategory =  new DeleteCategoryUseCase($repository);
        $responseUseCase = $useCaseCategory->execute(
            new CategoryInputDTO(
                id: $categoryDb->id 
            )
        );        

        $this->assertSoftDeleted($categoryDb);
    }
}
