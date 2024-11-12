<?php

namespace App\Service;

use App\Models\Book;
use App\Models\BorrowRecord;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class BorrowrecordService
{
    /**
     * * Borrow a book
     * *@param array $data
     * *@return array(message,status,data)
     */
    public function createBorrow($data)
    {
        try {
            $book = Book::find($data['book_id']);

            if ($book['case'] == 'Borrowed') {
                return [
                    'message' => 'الكتاب  مستعار',
                    'status' => 404,
                ];
            } else {
                // create boorrow record
                $borrow = BorrowRecord::create([
                    'book_id' => $data['book_id'],
                    'user_id' => Auth::user()->id,
                    'borrowed_at' => $data['borrowed_at'],
                    'returned_at' => date('Y-m-d', strtotime($data['borrowed_at'] . ' + 14 days')),
                    'due_date' => null,
                ]);
                //Update book case
                $book->update([
                    'case' => 'Borrowed',
                ]);
                //return messegge
                return [
                    'message' => 'تمت عملية الاستعارة بنجاح',
                    'status' => 201,
                ];
            }
        } catch (Exception $e) {
            Log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطأ أثناء الاستعارة: ' . $e->getMessage(),
                'status' => 500,
                'data' => null,
            ];
        }
    }
    //**________________________________________________________________________________________________
    /**
     ** Return the book
     **@param array $data
     **@param $id
     **@return array(message,status,data)
     */
    public function updateBorrow($id, $data)
    {
        try {
            // Find the borrow record
            $borrow = BorrowRecord::find($id);
            // Find the book
            $book = Book::find($borrow['book_id']);
            // Check the status of who borrowed the book
            if (Auth::user()->id != $borrow['user_id']) {
                return [
                    'message' => 'لم تقم انت باستعارة الكتاب',
                    'status' => 403,
                ];
            } else {

                // Check the status of the book
                if ($book['case'] == 'existing') {
                    return [
                        'message' => 'الكتاب غير مستعار',
                        'status' => 404,
                    ];
                } else {
                    //Update book case
                    $book->update(['case' => 'existing',]);
                    // inster the date of  return
                    $borrow->update([
                        'due_date' => $data['due_date'],
                    ]);
                    // return meessegw
                    return [
                        'message' => 'تمت عملية الإعادة',
                        'status' => 200,
                    ];
                }
            }
        } catch (Exception $e) {
            Log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطأ أثناء عملية الإعادة',
                'status' => 500,
            ];
        }
    }
    //**________________________________________________________________________________________________
    /**
     **show the borrows
     **@param array $data
     **@return array(message,status,data)
     */
    public function showBorrows($data)
    {
        try {
            $query = BorrowRecord::query();
            // check of the parameters that user need to filter the book

            if (!empty($data['borrowed_at'])) {
                $query->byborrowed_at($data['borrowed_at']);
            }
            // GET the borrows
            $borrows = $query->get()->makeHidden(['created_at', 'updated_at']);
            //return borrows;
            return [
                'message' => 'السجل',
                'data' => $borrows,
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
     **show the borrows
     **@param $id
     **@return array(message,status,data)
     */
    public function showBorrow($id)
    {
        try {
            // find borrows
            $borrow = BorrowRecord::find($id);
            //check that borrow exists
            if (!$borrow) {
                return [
                    'message' => 'السجل غير موجود',
                    'status' => 404,
                    'data' => 'لا يوجد بيانات'
                ];
            } else {
                return [
                    'message' => 'بيانات السجل',
                    'data' => $borrow,
                    'status' => 200,
                ];
            }
        } catch (Exception $e) {
            Log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطا اثناء عمليةالعرض',
                'status' => 500,
                'data' => 'لم يتم عرض البيانات'
            ];
        }
    }


    //**________________________________________________________________________________________________
    /**
     * * delet Borrowrecord with Before a specific date
     * *@param $date
     * *@return array
     */
    public function deleteBooksBeforeDate($date)
    {
        try {
            $query = BorrowRecord::query();
            // check of the parameters that user need to filter the book
            if (!empty($date)) {
                $borrow = $query->byborrowed_at2($date);
                // check if there are  borroow recordto  to delet
                if ($borrow == "") {
                    return [
                        'message' => '  لا يوجد بيانات لالحذف  قبل هذا التاريخ',
                        'status' => 404,
                    ];
                } else {
                    //delete the date
                    foreach ($borrow as $borrow) {
                        $borrow->delete();
                    }
                    return [
                        'message' => 'تمت عملية الحذف',
                        'status' => 200,
                    ];
                }
            }
        } catch (Exception $e) {
            Log::error('Error in returning book: ' . $e->getMessage());

            return [
                'message' => 'حدث خطأ أثناء عملية الحذف',
                'status' => 500,
                'data' => 'لم يتم حذف البيانات'
            ];
        }
    }
}
