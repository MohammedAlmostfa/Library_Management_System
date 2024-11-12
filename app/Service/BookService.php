<?php

namespace App\Service;

use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\Log;

class BookService
{
    /**
        * * show books
        * *@param array $data
        * *@return array(message,status,data)
        */

    public function showfilterbooks($data)
    {
        try {

            $query = Book::with('ratings');
            // check of the parameters that user need to filter the book

            if (!empty($data['author'])) {
                $query->byAuthor($data['author']);
            }

            if (!empty($data['category_id'])) {
                $query->byCategory($data['category_id']);
            }

            if (!empty($data['case'])) {
                $query->byCase($data['case']);
            }
            // GET the book
            $books = $query->get();
            //return $books;
            return [
                'message' => 'الكتب',
                'data' => $books,
                'status' => 200,
            ];
        } catch (Exception $e) {
            Log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطأ أثناء العرض: ',
                'data' => null,
                'status' => 500,
            ];
        }
    }

    //**________________________________________________________________________________________________
    /**
     * * creat book
     * *@param array $data
     * *@return array(message,status,data)
     */
    public function createBook($data)
    {
        try {
            // create book
            $book = Book::create($data);

            //reurn response
            return [
                'message' => 'تمت عملية الإضافة بنجاح',
                'data' => $book,
                'status' => 201,
            ];
        } catch (Exception $e) {
            log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطأ أثناء الإضافة: ',
                'data' => null,
                'status' => 500,
            ];
        }
    }
    //**________________________________________________________________________________________________
    /**
     * * update book data
     * *@param array $data
     * *@param $id
     * *@return array(message,status,data)
     */
    public function updateBook($data, $id)
    {
        try {
            // find the book
            $book = Book::find($id);
            // check if the book is  excite
            if (!$book) {
                return [
                    'message' => 'الكتاب غير موجود',
                    'status' => 404,
                    'data' => 'لا يوجد بيانات'
                ];
            } else {



                // update data
                $book->update([
'title'=>$data['title']??$book->title,
'author'=>$data['author']??$book->author,
'description'=>$data['description']??$book->description,
'published_at'=>$data['published_at']??$book->published_at,
'case'=>$data['case']??$book->case,
                ]);
                //reurn response wirh data
                return [
                    'message' => 'تمت عملية التحديث',
                    'data' => $book,
                    'status' => 200,
                ];
            }
        } catch (Exception $e) {
            //reurn response
            return [
                'message' => 'حدث خطأ أثناء التحديث',
                'status' => 500,
                'data' => 'لم يتم تحديث البيانات'
            ];
        }
    }
    //**________________________________________________________________________________________________
    /**
     ** show book data
     * *@param $id
     * *@return array(message,status,data)
     */
    public function ShowBook($id)
    {
        try {
            // find book
            $book = Book::find($id);
            //check that book exists
            if (!$book) {
                return [
                    'message' => 'الكتاب غير موجود',
                    'data' => $book,
                    'status' => 404,

                ];
            } else {
                return [
                    'message' => 'بيانات الكتاب',
                    'data' => $book,
                    'status' => 200,
                ];
            }
        } catch (Exception $e) {
            log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطا اثناء عمليةالعرض',
                'data' => 'لا يوجد بيانات لالعرض',
                'status' => 500,
            ];
        }
    }
    //**________________________________________________________________________________________________
    /**
     * * delet book dataa
     * *@param $id
     * *@return array(status, message,data)
     */
    public function deleteBook($id)
    {
        try {
            // find book
            $book = Book::find($id);
            //check that book exists
            if (!$book) {
                return [
                    'message' => 'الكتاب غير موجود',
                    'status' => 404,
                    'data' => 'لا يوجد بيانات'
                ];
            } else {
                $book->delete();
                return [
                    'message' => 'تمت عملية الحذف',
                    'data' => $book,
                    'status' => 200,
                ];
            }
        } catch (Exception $e) {
            log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطا اثناء عملية الحذف',
                'status' => 500,
                'data' => 'لم يتم حذف البيانات'
            ];
        }
    }
}
