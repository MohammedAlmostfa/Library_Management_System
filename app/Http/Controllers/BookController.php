<?php

namespace App\Http\Controllers;

use App\Http\Requests\BookFormRequest;

use App\Models\Book;
use App\Service\BookService;
use Illuminate\Http\Request;

class BookController extends Controller
{

    protected $bookService;
    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }
    //**________________________________________________________________________________________________
    /**
       ** show all boo; wit filters
    ** @param BookFormRequest $request
    * *@return \Illuminate\Http\JsonResponse
    */
    public function index(BookFormRequest $request)
    {
        // Retrieve the validated data from the request
        $validatedData = $request->validated();
        // Create a new book using the validated data
        $result = $this->bookService-> showfilterbooks($validatedData);
        // Return a JSON response with the result
        return response()->json([
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['status']);
    }


    //**________________________________________________________________________________________________
    /**
 ** Create a new book
 ** @param BookFormRequest $request
 * *@return \Illuminate\Http\JsonResponse
 */
    public function store(BookFormRequest $request)
    {
        // Retrieve the validated data from the request
        $validatedData = $request->validated();
        // Create a new book using the validated data
        $result = $this->bookService->createBook($validatedData);
        // Return a JSON response with the result
        return response()->json([
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['status']);
    }

   
    //**________________________________________________________________________________________________
    /**
     **update The book
    **@parBookFormRequest $request
    **@parm $id
    **return Responsejson(data,message)
    */

    public function update(BookFormRequest $request, string $id)
    {
        // Retrieve the validated data from the request
        $validatedData =  $request->validated();
        //update book using the validated data
        $result = $this->bookService->updateBook($validatedData, $id);
        // Return a JSON response with the result
        return response()->json([
            'message' => $result['message'],
            'data' => $result['data'],
        ], $result['status']);
    }
    //**________________________________________________________________________________________________
    /**
     **delete The  book
      **@parm $id
      **return Responsejson(data,message)
      */
    public function destroy(string $id)
    {
        //delete the book
        $result = $this->bookService->deleteBook($id);
        // Return a response
        return response()->json([
              'message' => $result['message'],
          ], $result['status']);
    }
    //**________________________________________________________________________________________________
    /**
     ** show The book
    **@parm $id
    **return Responsejson(data,message)
    */
    public function show(string $id)
    {
        //show the book
        $result = $this->bookService->ShowBook($id);
        // return response
        return response()->json([
              'message' => $result['message'],
              'data' => $result['data'],
          ], $result['status']);
    }

}
