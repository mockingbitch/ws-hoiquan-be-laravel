<?php

namespace App\Http\Controllers\Api\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\Contracts\RepositoryInterface\VoteRepositoryInterface;
use App\Repositories\Contracts\RepositoryInterface\FilmRepositoryInterface;
use Illuminate\Http\JsonResponse;
use Validator;

class VoteController extends Controller
{
    /**
     * @voteRepository
     */
    protected $voteRepository;

    /**
     * @filmRepository
     */
    protected $filmRepository;

    /**
     * @param VoteRepositoryInterface $voteRepository
     */
    public function __construct(
        VoteRepositoryInterface $voteRepository,
        FilmRepositoryInterface $filmRepository
    )
    {
        $this->voteRepository = $voteRepository;
        $this->filmRepository = $filmRepository;
    }

    /**
     * @param Request $request
     * 
     * @return void
     */
    public function create(Request $request)
    {
        try {
            $filmId = $request->query('film_id');

            if (! $this->filmRepository->find($filmId)) {
                return response()->json([
                    'errCode' => 1,
                    'message' => 'Could not find film'
                ], 200);
            }

            $user = auth()->user();
            $validator = Validator::make($request->all(), [
                'percent' => 'required|numeric|integer|between:1,100',
                'comment' => 'string|max:1000',
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $data = $validator->validated();
            $data['film_id'] = $filmId;
            $data['user_id'] = $user->id;

            if ($this->voteRepository->checkIfExistVote($user->id)) {
                return response()->json([
                    'errCode' => 1,
                    'message' => 'Voted'
                ], 200);
            }

            if (! $this->voteRepository->create($data)) {
                return response()->json([
                    'errCode' => 1,
                    'message' => 'failed'
                ], 200);
            }

            $count = $this->voteRepository->count($filmId);
            $percent = $this->voteRepository->calculatePercent($filmId);

            if ($count && $count > 0 && $percent) {
                if (! $this->filmRepository->update($filmId, ['vote' => $count, 'percent' => $percent])) {
                    return response()->json([
                        'errCode' => 1,
                        'message' => 'failed'
                    ], 200);
                }
            }
            
            return response()->json([
                'errCode' => 0,
                'message' => 'success'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'errCode' => 2,
                'message' => 'Something went wrong'
            ], 200);
        }
    }

    public function update(Request $request)
    {
        try {
            $voteId = $request->query('id');
            $validator = Validator::make($request->all(), [
                'percent' => 'required|numeric|integer|between:1,100',
                'comment' => 'string|max:1000',
            ]);
            
            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            if ($this->voteRepository->find($voteId)) {
                if ($this->voteRepository->update($voteId, $validator->validated())) {
                    return response()->json([
                        'errCode' => 0,
                        'message' => 'success'
                    ], 200);
                }
            }

            return response()->json([
                'errCode' => 1,
                'message' => 'failed'
            ], 200);
        } catch (\Throwable $th) {
            return response()->json([
                'errCode' => 2,
                'message' => 'Something went wrong'
            ], 200);
        }
    }
}
