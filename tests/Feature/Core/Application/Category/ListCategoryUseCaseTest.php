<?php

namespace Tests\Feature\Core\Application\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Application\Category\ListCategoryUseCase;
use Core\Application\DTO\Category\CategoryInputDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListCategoryUseCaseTest extends TestCase
{
    public function test_list()
    {
        $categoryDb = Model::factory()->create();

        $repository = new CategoryEloquentRepository(new Model());
        $useCaseCategory =  new ListCategoryUseCase($repository);
        $responseUseCase = $useCaseCategory->execute(
            new CategoryInputDTO(
                id: $categoryDb->id 
            )
        );    

        $this->assertEquals($categoryDb->id, $responseUseCase->id);
        $this->assertEquals($categoryDb->name, $responseUseCase->name);
        $this->assertEquals($categoryDb->description, $responseUseCase->description);
    }
}
