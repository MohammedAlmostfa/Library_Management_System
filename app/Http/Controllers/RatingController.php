<?php

namespace App\Http\Controllers;

use App\Http\Requests\RatingFormRequest;
use Illuminate\Http\Request;
use App\Service\RatingService;

;

class RatingController extends Controller
{
    protected $ratingService;
    public function __construct(RatingService  $ratingService)
    {
        $this->ratingService=$ratingService;
    }

    /**
         ** create a new Rating
        ** @param RatingFormRequest $request
        ** @return Responsejson(data,message)
         */
    public function store(RatingFormRequest $request)
    {

        $validatedData = $request->validated();
        $result =  $this->ratingService->createRating($validatedData);
        return response()->json([
            'message' => $result['message'],
 'data' => $result['data'],
        ], $result['status']);
    }
    /**
         * *This function is creat to update the Rating.
         * *@param \Illuminate\Http\RatingFormRequest $request
         * * @param $id
         * * @return \Illuminate\Http\JsonResponse
         */

    public function update(RatingFormRequest $request, $id)
    {
        $validatedData = $request->validated();
        $result =  $this->ratingService->updateRating($validatedData, $id);
        return response()->json([
            'message' => $result['message'],
               'data' => $result['data'],
        ], $result['status']);
    }

    /**
      * *This function is creat to delet a Rating.
      * *@param $id
      * *@return \Illuminate\Http\JsonResponse
      */
    public function destroy($id)
    {
        $result =  $this->ratingService->deleteRating($id);

        return response()->json([
                    'message' => $result['message'],
                ], $result['status']);

    }

    public function show($id)
    {

        $result =  $this->ratingService->showRating($id);

        return response()->json([
                    'message' => $result['message'],
                    'data' => $result['data'],
                ], $result['status']);


    }






}
