<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\{
    StoreCategoryRequest,
    UpdateCategoryRequest
};
use App\Http\Resources\CategoryResource;
use Core\Application\Category\{
    CreateCategoryUseCase,
    DeleteCategoryUseCase,
    ListCategoriesUseCase,
    ListCategoryUseCase,
    UpdateCategoryUseCase
};
use Core\Application\DTO\Category\CategoryInputDTO;
use Core\Application\DTO\Category\CreateCategory\CategoryCreateInputDTO;
use Core\Application\DTO\Category\ListCategories\ListCategoriesInputDTO;
use Core\Application\DTO\Category\UpdateCategory\CategoryUpdateInputDTO;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Http\Response;

class CategoryController extends Controller
{
    public function index(Request $request, ListCategoriesUseCase $useCase): AnonymousResourceCollection
    {
        $response = $useCase->execute(
            input: new ListCategoriesInputDTO(
                filter: $request->get('filter', ''),
                order: $request->get('order', 'DESC'),
                page: (int) $request->get('page', 1),
                totalPage: (int) $request->Get('total_page', 15),
            )
        );

        return CategoryResource::collection(collect($response->items))
            ->additional([
                'meta' => [
                    'total' => $response->total,
                    'last_page' => $response->last_page,
                    'first_page' => $response->first_page,
                    'per_page' => $response->per_page,
                    'to' => $response->to,
                    'from' => $response->from,
                ]
            ]);                         
    }

    public function store(StoreCategoryRequest $request, CreateCategoryUseCase $useCase): JsonResponse
    {
        $response = $useCase->execute(
            input: new CategoryCreateInputDTO(
                name: $request->name,
                description: $request->description ?? '',
                isActive: (bool) $request->is_active ?? true   
            )
        );

        return (new CategoryResource(collect($response)))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(ListCategoryUseCase $useCase, string $id)
    {
        $category = $useCase->execute(new CategoryInputDTO($id));

        return (new CategoryResource(collect($category)))->response();
    }

    public function update(UpdateCategoryRequest $request, UpdateCategoryUseCase $useCase, string $id): JsonResponse
    {
        $response = $useCase->execute(
            input: new CategoryUpdateInputDTO(
                id: $id,
                name: $request->name,
                description: $request->description ?? '',
                isActive: $request->isActive ?? true
            )
        );

        return (new CategoryResource(collect($response)))->response();
    }

    public function destroy(DeleteCategoryUseCase $useCase, string $id): Response
    {
        $useCase->execute(
            input: new CategoryInputDTO(
                id: $id
            )
        );

        return response()->noContent();
    }
}