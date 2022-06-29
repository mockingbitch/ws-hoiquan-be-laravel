<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\RepositoryInterface\TagRepositoryInterface;
use Illuminate\Http\JsonResponse;

class TagController extends Controller
{
    /**
     * @var @tagRepository
     */
    protected $tagRepository;

    /**
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(TagRepositoryInterface $tagRepository)
    {
        $this->tagRepository = $tagRepository;
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function show(Request $request) : JsonResponse
    {
        try {
            $tagId = $request->query('id');
            if ($tagId == 'all') {
                $tags = $this->tagRepository->getAll();

                return response()->json([
                    'errCode' => 0,
                    'message' => 'success',
                    'tags' => $tags
                ], 200);
            }

            if ($tag = $this->tagRepository->find($tagId)) {
                return response()->json([
                    'errCode' => 0,
                    'message' => 'success',
                    'tag' => $tag
                ], 200);
            }

            return response()->json([
                'errCode' => 1,
                'message' => 'Could not find tag'
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
            if (! $this->tagRepository->create($request->toArray())) {
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
            $tagId = $request->query('id');
            if (! $tag = $this->tagRepository->find($tagId)) {
                return response()->json([
                    'errcode' => 1,
                    'message' => 'Could not find tag'
                ], 200);
            }

            if (! $this->tagRepository->update($tagId, $request->toArray())) {
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
            $tagId = $request->query('id');
            if (! $tag = $this->tagRepository->find($tagId)) {
                return response()->json([
                    'errcode' => 1,
                    'message' => 'Could not find tag'
                ], 200);
            }

            if (! $this->tagRepository->delete($tagId)) {
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
