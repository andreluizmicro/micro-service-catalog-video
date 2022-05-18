<?php

namespace Tests\Feature\App\Repositories\Eloquent;

use App\Models\Category as Model;
use App\Models\Category;
use App\Repositories\Eloquent\CategoryEloquentRepository;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\PaginationInterface;

class CategoryEloquentRepositoryTest extends TestCase
{
    
    protected $repository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->repository = new CategoryEloquentRepository(new Model());
        
    }
    
    public function testInsert()
    {
        $entitycategory = new EntityCategory(
            name: 'Teste'
        );

        $response = $this->repository->insert($entitycategory);

        $this->assertInstanceOf(CategoryRepositoryInterface::class, $this->repository);
        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertDatabaseHas('categories', [
            'name' => $entitycategory->name
        ]);
    }

    public function testFindAll()
    {
        Model::factory()->count(10)->create();

        $response = $this->repository->findAll();

        $this->assertCount(10, $response);
    }

    public function testFindById()
    {
        $category = Model::factory()->create();

        $response = $this->repository->findById($category->id);

        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertEquals($category->id, $response->id());
    }

    public function testFindByIdNotFound()
    {
        try {
            $this->repository->findById('fakeValue');
            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testPagination()
    {
        Model::factory()->count(20)->create();

        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(15, $response->items());
    }

    public function testPaginationWithout()
    {
        $response = $this->repository->paginate();

        $this->assertInstanceOf(PaginationInterface::class, $response);
        $this->assertCount(0, $response->items());
    }

    public function testUpdateIdNotFound()
    {
        try {
            $category = new EntityCategory(name: 'test');
            $this->repository->update($category);

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testUpdate()
    {
        
        $categoryDb = Category::factory()->create();

        $category = new EntityCategory(
            id: $categoryDb->id,
            name: 'updated name',
        );
            
        $response = $this->repository->update($category);

        $this->assertInstanceOf(EntityCategory::class, $response);
        $this->assertNotEquals($response->name, $categoryDb->name);
        $this->assertEquals('updated name', $response->name);
    }

    public function testDeleteIdNotFound()
    {
        try {
            $this->repository->delete('fake_id');

            $this->assertTrue(false);
        } catch (\Throwable $th) {
            $this->assertInstanceOf(NotFoundException::class, $th);
        }
    }

    public function testDelete()
    {
        $categoryDb = Category::factory()->create();

        $response = $this->repository->delete($categoryDb->id);

        $this->assertTrue($response);
    }
}
