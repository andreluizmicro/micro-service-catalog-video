<?php

namespace App\Repositories\Eloquent;

use App\Models\Category as Model;
use App\Repositories\Presenters\PaginationPresenter;
use Core\Domain\Entity\Category as EntityCategory;
use Core\Domain\Exception\NotFoundException;
use Core\Domain\Repository\CategoryRepositoryInterface;
use Core\Domain\Repository\PaginationInterface;

class CategoryEloquentRepository implements CategoryRepositoryInterface
{
    protected $model;

    public function __construct(private Model $category)
    {
        $this->model = $category;
    }

    public function insert(EntityCategory $entityCategory): EntityCategory
    {
        $entityCategory = $this->model->create([
            'id' => $entityCategory->id(), 
            'name' => $entityCategory->name,
            'description' => $entityCategory->description,
            'is_active' => $entityCategory->isActive,
            'created_at' => $entityCategory->createdAt()
        ]);

        return $this->toCategory($entityCategory);
    }

    public function findById(string $id): EntityCategory
    {
        if (!$category = $this->model->find($id)){
            throw new NotFoundException('Category not Found');
        }

        return $this->toCategory($category);
    }

    public function getCategoriesIdsByListIds(array $categoriesId = []): array
    {
        return $this->model
                    ->whereIn('id', $categoriesId)
                    ->get()
                    ->pluck('id');
    }

    public function findAll(string $filter = '', $order = 'DESC'): array
    {
        $categories = $this->model
                            ->where(function($query) use ($filter) {
                                if ($filter)
                                    $query->where('name', 'LIKE', "%{$filter}%");
                            })
                            ->orderBy('id', $order)
                            ->get();

        return $categories->toArray();
    }

    public function paginate(string $filter = '', $order = 'DESC', int $page = 1, int $totalPage = 15): PaginationInterface
    {
        $query = $this->model;
        if($filter) {
            $query->where('name', 'LIKE', "%${$filter}%");
        }
        $query->orderBy('id', $order);
        $paginator = $query->paginate();

        return new PaginationPresenter($paginator);
    }

    public function update(EntityCategory $category): EntityCategory
    {
        if (!$categoryDb = $this->model->find($category->id)){
            throw new NotFoundException('Category not found');
        }

        $categoryDb->update([
            'name' => $category->name,
            'description' => $category->description,
            'is_active' => $category->isActive
        ]);

        $categoryDb->refresh();

        return $this->toCategory($categoryDb);

    }

    public function delete(string $id): bool
    {
        if (!$categoryDb = $this->model->find($id)){
            throw new NotFoundException('Category not found');
        }

        return $categoryDb->delete();
    }

    private function toCategory(object $object): EntityCategory
    {
        $entity = new EntityCategory(
            id: $object->id,
            name: $object->name,
            description: $object->description,
        );
        
        ((bool) $object->is_active) ? $entity->activate() : $entity->desable();

        return $entity;
    }
   
}