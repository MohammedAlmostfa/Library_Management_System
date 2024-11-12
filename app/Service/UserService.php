<?php

namespace App\Service;

use App\Models\User;

use Exception;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;

class UserService
{
    //**________________________________________________________________________________________________
    public function showUsers()
    {
        try {
            //get all users
            $data = User::all();
            // rturn all users
            return [
                'message' => 'نم عرض المستخدمين ',
                'status' => 200,
                'data' => $data,
            ];
        } catch (Exception $e) {

            return [
                'message' => 'حدث خطاء اثنا عرض المستخدمسن',
                'status' => 500,
                'data' => 'لم يتم عرض البيانات'
            ];
        }
    }
    //**________________________________________________________________________________________________
    /**
     * *This function is created to store a new User.
     ** @param$ data
     * *@return array(message,data,status)
     */
    public function createUser($credentials)
    {
        try {
            // Create user
            $user = User::create([
                'name' => $credentials['name'],
                'email' => $credentials['email'],
                'password' => Hash::make($credentials['password']),
            ]);
            //return $user data
            return [
                'message' => 'نم انشاء الحساب',
                'status' => 200,
                'data' => $user,
            ];
        } catch (Exception $e) {
            Log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطاء اثنا انشاء الحساب',
                'status' => 500,
                'data' => 'لم يتم عرض البيانات'
            ];
        }
    }
    //**________________________________________________________________________________________________
    /**
     * *This function is creat to update a  user.
     * * @param $data
     * *@param User $user
     * *@retur array(message.status.data)
     */
    public function updateUser($data, $id)
    {
        try {
            $user = User::find($id);

            if (!$user) {
                return [
                    'message' => 'المستخدم غير موجود',
                    'status' => 404,
                    'data' => 'لا يوجد بيانات'
                ];
            } else {

                $user->update($data);
                return [
                    'message' => 'تمت عملية التحديث',
                    'data' => $data,
                    'status' => 200,
                ];
            }
        } catch (Exception $e) {
            Log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطأ أثناء التحديث',
                'status' => 500,
                'data' => 'لم يتم تحديث البيانات'
            ];
        }
    }

    //**________________________________________________________________________________________________
    /**
     * *This function is creat to delet  a user.
     **@param $id
     * *@return(status, data,message)
     */
    public function deletUser($id)
    {
        try {
            // find the user
            $user = User::find($id);

            if (!$user) {
                //if the user not exist
                return [
                    'message' => 'المستخدم غير موجود',
                    'status' => 404,
                ];
            } else {
                //delete the user
                $user->delete();
                return [
                    'message' => 'تمت عملية الحذف',
                    'status' => 200,
                ];
            }
        } catch (Exception $e) {
            Log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطأ أثناء الحذف',
                'status' => 500,
            ];
        }
    }

    //**________________________________________________________________________________________________
    /**
     * *This function is creat to show  a user.
     **@param $id
     * *@return($message,status,data)
     */
    public function showUser($id)
    {
        //find the user
        $query = User::find($id);

        try {
            if (empty($user)) {
                //if the user not exist
                return [
                    'message' => 'المستخدم غير موجود',
                    'status' => 404,
                    'data' => 'لا يوجد بيانات'
                ];
            } else {

                // rturn uuser data
                return [
                    'message' => 'تمت عملية العرض',
                    'data' => $user,
                    'status' => 200,
                ];
            }
        } catch (Exception $e) {
            Log::error('Error in returning book: ' . $e->getMessage());
            return [
                'message' => 'حدث خطأ أثناء العرض',
                'status' => 500,
                'data' => 'لا يوجد بيانات'
            ];
        }
    }
}
