<?php

namespace Tests\Feature\Core\Application\Category;

use App\Models\Category as Model;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Application\Category\ListCategoriesUseCase;
use Core\Application\DTO\Category\ListCategories\ListCategoriesInputDTO;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ListCategoriesUseCaseTest extends TestCase
{
    public function testListEmpty()
    {
        $responseUseCase = $this->createUseCase();     

        $this->assertCount(0, $responseUseCase->items);
    }

    public function testListAll()
    {
        $categoriesDb = Model::factory()->count(20)->create();

        $responseUseCase = $this->createUseCase();   
        
        
        $this->assertCount(15, $responseUseCase->items);
        $this->assertEquals(count($categoriesDb), $responseUseCase->total);
    }

    private function createUseCase()
    {
        $repository = new CategoryEloquentRepository(new Model());
        $useCaseCategory =  new ListCategoriesUseCase($repository);
        return $useCaseCategory->execute(new ListCategoriesInputDTO());    
    }
}
