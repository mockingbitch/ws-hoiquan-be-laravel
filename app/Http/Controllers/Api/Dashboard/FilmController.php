<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\RepositoryInterface\FilmRepositoryInterface;
use App\Repositories\Contracts\RepositoryInterface\TagRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Validator;


class FilmController extends Controller
{
    /**
     * @var @filmRepository
     */
    protected $filmRepository;

    /**
     * @var @tagRepository
     */
    protected $tagRepository;

    /**
     * @param FilmRepositoryInterface $filmRepository
     * @param TagRepositoryInterface $tagRepository
     */
    public function __construct(
        FilmRepositoryInterface $filmRepository,
        TagRepositoryInterface $tagRepository    
    )
    {
        $this->filmRepository = $filmRepository;
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
            $query = $request->query();
            if ($query['id'] == 'all') {
                $films = $this->filmRepository->getAll();

                return response()->json([
                    'errCode' => 0,
                    'message' => 'success',
                    'films' => $films
                ], 200);
            }

            if ($film = $this->filmRepository->find($query['id'])) {
                return response()->json([
                    'errCode' => 0,
                    'message' => 'success',
                    'film' => $film
                ], 200);
            }

            return response()->json([
                'errCode' => 1,
                'message' => 'Could not find film'
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
        // try {
            $validator = Validator::make($request->all(), [
                'name_vi' => 'required|string',
                'name_en' => 'required|string',
                'description_vi' => 'required|string|max:1000',
                'description_en' => 'required|string|max:1000',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            if (! $film = $this->filmRepository->create($validator->validated())) {
                return response()->json([
                    'errCode' => 1,
                    'message' => 'failed'
                ], 200);
            }

            if (isset($request['tag_id'])) {
                $tags = [];
                $tagName = [];
                foreach ($request['tag_id'] as $tag_id) {
                    $tag= $this->tagRepository->find($tag_id);
                    $tagName[] = $tag->value_vi;
                }
                dd($tagName);
                if (! $this->filmTagRepository->create($data)) {
                    return response()->json([
                        'errCode' => 1,
                        'message' => 'failed'
                    ], 200);
                }
            }

            return response()->json([
                'errCode' => 0,
                'message' => 'success'
            ], 201);
        // } catch (\Throwable $th) {
        //     return response()->json([
        //         'errCode' => 2,
        //         'message' => 'Something went wrong'
        //     ], 200);
        // }
    }

    /**
     * @param Request $request
     * 
     * @return JsonResponse
     */
    public function update(Request $request) : JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_vi' => 'required|string',
                'name_en' => 'required|string',
                'description_vi' => 'required|string|max:1000',
                'description_en' => 'required|string|max:1000',
                
            ]);
    
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $query = $request->query();
            if (! $film = $this->filmRepository->find($query['id'])) {
                return response()->json([
                    'errcode' => 1,
                    'message' => 'Could not find film'
                ], 200);
            }

            if (! $this->filmRepository->update($query['id'], $request->toArray())) {
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
            if (! $film = $this->filmRepository->find($query['id'])) {
                return response()->json([
                    'errcode' => 1,
                    'message' => 'Could not find film'
                ], 200);
            }

            if (! $this->filmRepository->delete($query['id'])) {
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
