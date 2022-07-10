<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\RepositoryInterface\FilmRepositoryInterface;
use App\Repositories\Contracts\RepositoryInterface\TagRepositoryInterface;
use App\Repositories\Contracts\RepositoryInterface\FilmTagRepositoryInterface;
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
     * @var @filmTagRepository
     */
    protected $filmTagRepository;
    
    /**
     * @param FilmRepositoryInterface $filmRepository
     * @param TagRepositoryInterface $tagRepository
     * @param FilmTagRepositoryInterface $filmTagRepository
     */
    public function __construct(
        FilmRepositoryInterface $filmRepository,
        TagRepositoryInterface $tagRepository,
        FilmTagRepositoryInterface $filmTagRepository    
    )
    {
        $this->filmRepository = $filmRepository;
        $this->tagRepository = $tagRepository;
        $this->filmTagRepository = $filmTagRepository;
    }

    /**
     * @param Request $request
     * Hàm lấy ra film theo id/all 
     * @return JsonResponse
     */
    public function show(Request $request) : JsonResponse
    {
        try {
            $filmId = $request->query('id');
            if ($filmId == 'all') {
                $films = $this->filmRepository->getAll();

                return response()->json([
                    'errCode' => 0,
                    'message' => 'success',
                    'films' => $films
                ], 200);
            }

            if ($film = $this->filmRepository->find($filmId)) {
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
     * Hàm tạo film + tag film
     * @return JsonResponse
     */
    public function create(Request $request) : JsonResponse
    {
        try {
            $validator = Validator::make($request->all(), [
                'name_vi' => 'required|string',
                'name_en' => 'required|string',
                'description_vi' => 'required|string|max:1000',
                'description_en' => 'required|string|max:1000',
                'status' => 'required|string'
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }
            $data = $validator->validated();
            $data['release_date'] = $request->release_date; 
            dd($data);
            if (! $film = $this->filmRepository->create($data)) {
                return response()->json([
                    'errCode' => 1,
                    'message' => 'failed'
                ], 200);
            }

            if (isset($request['tag_id'])) {
                foreach ($request['tag_id'] as $tag_id) {
                    $tag= $this->tagRepository->find($tag_id);
                    if ($tag) {
                        $data = [
                            'tag_id' => $tag_id, 
                            'film_id' => $film->id
                        ];

                        if (! $this->filmTagRepository->create($data)) {
                            return response()->json([
                                'errCode' => 1,
                                'message' => 'failed'
                            ], 200);
                        }
                    } else {
                        return response()->json([
                            'errCode' => 1,
                            'message' => 'Could not find tag'
                        ], 200);
                    }
                }
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
     * Hàm update film + tag film
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
            
            $filmId = $request->query('id');

            if (! $film = $this->filmRepository->find($filmId)) {
                return response()->json([
                    'errCode' => 1,
                    'message' => 'Could not find film'
                ], 404);
            }

            if (! $this->filmRepository->update($filmId, $validator->validated())) {
                return response()->json([
                    'errCode' => 1,
                    'message' => 'failed'
                ], 200);
            }

            if (isset($request['tag_id'])) {
                foreach ($request['tag_id'] as $tag_id) {
                    $tagRequest[] = (int) $tag_id;
                    $tag = $this->tagRepository->find($tag_id);
                    if ($tag) {
                        $data = [
                            'tag_id' => $tag->id,
                            'film_id' => $film->id
                        ];
                        
                        if (! $exist = $this->filmTagRepository->checkIfExist($film->id, $tag->id)) {
                            if (! $this->filmTagRepository->create($data)) {
                                return response()->json([
                                    'errCode' => 1,
                                    'message' => 'failed'
                                ], 200);
                            }
                        }
                    } else {
                        return response()->json([
                            'errCode' => 1,
                            'message' => 'Could not find tag'
                        ], 200);
                    }
                }

                $arrayIdTag = $this->filmTagRepository->getAllIdFilmTags($film->id);
                $arrayDiff = array_diff($arrayIdTag, $tagRequest);
                if (count($arrayDiff) > 0) {
                    foreach ($arrayDiff as $diff) {
                        if (! $this->filmTagRepository->deleteTag($film->id, $diff)) {
                            return response()->json([
                                'errCode' => 1,
                                'message' => 'failed'
                            ], 200);
                        }
                    }
                }
            } else {
                $arrayIdTag = $this->filmTagRepository->getAllIdFilmTags($film->id);
                if ($arrayIdTag) {
                    foreach ($arrayIdTag as $tag) {
                        if (! $this->filmTagRepository->deleteTag($film->id, $tag)) {
                            return response()->json([
                                'errCode' => 1,
                                'message' => 'failed'
                            ], 200);
                        }
                    }
                }
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
     * Hàm xoá, xoá tag film
     * @return JsonResponse
     */
    public function delete(Request $request) : JsonResponse
    {
        try {
            $filmId = $request->query('id');
            if (! $film = $this->filmRepository->find($filmId)) {
                return response()->json([
                    'errcode' => 1,
                    'message' => 'Could not find film'
                ], 200);
            }

            if (! $this->filmRepository->delete($filmId)) {
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
