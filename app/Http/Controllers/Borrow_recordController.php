<?php

namespace App\Http\Controllers;

use App\Http\Requests\BorrowRecordFormRequest;
use Illuminate\Http\Request;
use App\Models\BorrowRecord;
use App\Service\BorrowrecordService;

class Borrow_recordController extends Controller
{
    protected $borrowrecordService;

    public function __construct(BorrowrecordService $borrowrecordService)
    {
        $this->borrowrecordService =  $borrowrecordService;
    }
    //**________________________________________________________________________________________________
  
    /**
 ** Create a new borrowed
 ** @param BookFormRequest $request
 * *@return \Illuminate\Http\JsonResponse
 */
    public function store(BorrowRecordFormRequest $request)
    {
        // Retrieve the validated data from the request
        $validatedData =  $request->validated();
        //create a new borrow record
        $result = $this->borrowrecordService->createBorrow($validatedData);
        //return resposjson
        return response()->json([
            'message' => $result['message'],
        ], $result['status']);
    }
    //**________________________________________________________________________________________________
    /**
 ** return  the book
 ** @param BookFormRequest $request
  ** @param $id
 * *@return \Illuminate\Http\JsonResponse
 */
    public function update(BorrowRecordFormRequest $request, $id)
    {
        // Retrieve the validated data from the request
        $validated_date =  $request->validated();
        //updata the borrow record
        $result = $this->borrowrecordService->updateBorrow($id, $validated_date);
        return response()->json([
            'message' => $result['message'],
        ], $result['status']);
    }
    //**________________________________________________________________________________________________
    /**
    ** show the borrow record
 ** @param nothing
 * *@return \Illuminate\Http\JsonResponse
 */
    public function index(BorrowRecordFormRequest $request)
    {
        // Retrieve the validated data from the request
        $validated_date =  $request->validated();
        // show the borrow record
        $result = $this->borrowrecordService->showBorrows($validated_date);
        return response()->json([
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['status']);
    }
    
    //**________________________________________________________________________________________________
    /**
** show the borrow
 ** @param id
 * *@return \Illuminate\Http\JsonResponse
 */
    public function show($id)
    {
        $result = $this->borrowrecordService->showBorrow($id);
        return response()->json([
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['status']);
    }
    //**________________________________________________________________________________________________
    /**
     ** delet  the borrow Before a specific date
 ** @param data
 * *@return \Illuminate\Http\JsonResponse
 */
    public function destroy($date)
    {
        $result = $this->borrowrecordService->deleteBooksBeforeDate($date);
        return response()->json([
            'message' => $result['message'],
        ], $result['status']);

    }
   

}
