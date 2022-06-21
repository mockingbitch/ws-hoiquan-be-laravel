<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @var @categoryRepository
     */
    protected $categoryRepository;

    /**
     * @param CategoryRepositoryInterface $categoryRepository
     */
    public function __construct(CategoryRepositoryInterface $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function show(Request $request) : JsonResponse
    {
        try {
            $query = $request->query();
            if ($query['id'] == 'all') {
                $categories = $this->categoryRepository->getAll();

                return response()->json([
                    'errCode' => 0,
                    'message' => 'success',
                    'categories' => $categories
                ], 200);
            }

            if ($category = $this->categoryRepository->find($query['id'])) {
                return response()->json([
                    'errCode' => 0,
                    'message' => 'success',
                    'category' => $category
                ], 200);
            }

            return response()->json([
                'errCode' => 1,
                'message' => 'failed'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'errCode' => 2,
                'message' => 'failed'
            ], 200);
        }
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        try {
            if (! $this->categoryRepository->create($request->toArray())) {
                return response()->json([
                    'errCode' => 1,
                    'message' => 'failed'
                ], 200);
            }

            return response()->json([
                'errCode' => 0,
                'message' => 'success'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'errCode' => 2,
                'message' => 'Something went wrong'
            ], 200);
        }
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function update(Request $request) : JsonResponse
    {
        try {
            $query = $request->query();
            if (! $category = $this->categoryRepository->find($query['id'])) {
                return response()->json([
                    'errcode' => 1,
                    'message' => 'Could not find category'
                ], 200);
            }

            if (! $this->categoryRepository->update($query['id'], $request->toArray())) {
                return response()->json([
                    'errCode' => 1,
                    'message' => 'failed'
                ], 200);
            }

            return response()->json([
                'errCode' => 0,
                'message' => 'success'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'errCode' => 2,
                'message' => 'Something went wrong'
            ], 200);
        }
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function delete(Request $request) : JsonResponse
    {
        try {
            $query = $request->query();
            if (! $category = $this->categoryRepository->find($query['id'])) {
                return response()->json([
                    'errcode' => 1,
                    'message' => 'Could not find category'
                ], 200);
            }

            if (! $this->categoryRepository->delete($query['id'])) {
                return response()->json([
                    'errcode' => 1,
                    'message' => 'failed'
                ], 200);
            }

            return response()->json([
                'errcode' => 0,
                'message' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'errCode' => 2,
                'message' => 'Something went wrong'
            ], 200);
        }
    }
}
