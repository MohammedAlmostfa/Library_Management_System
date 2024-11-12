<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CategoryController extends Controller
{
    /**
     * function creat to display all categories
     * @param No thing
     * @return json response(all categories)
     */
    public function index()
    {
        try {
            $categories = Category::all();

            return response()->json(['message' => 'الفئات  المتوفرة','categories' => $categories], 200);

        } catch (\Exception $e) {
            Log::error(' خطاء اثناء عرض الفئة' . $e->getMessage());

            return response()->json(['message' => 'حدث خطاء اثناء عرض الفئة'], 500);
        }
    }
    /**
 * function creat to crat  categorie
 * @param Category $category
 * @return json response(message)
 */
    public function store(CategoryRequest $request)
    {
        try {
            $validatedData = $request->validated();
            $category = Category::create($validatedData);
            return response()->json(['message' => 'تم الانشاءالفئة', 'category' => $category], 200);
        } catch (\Exception $e) {
            Log::error(' خطاء اثناء اصافة الفئة' . $e->getMessage());

            return response()->json(['message' => 'حدث خطاء اثناء انشاء الفئة'], 500);
        }
    }
    /**
     * function creat to update  categorie
     * @param Category $category
     * @param integer $id(id of category)
     * @return json response(message)
     */
    public function update(CategoryRequest $request, $id)
    {
        try {
            $category = Category::find($id);

            if ($category) {
                // Validate category
                $validatedData = $request->validated();
                // Update data
                $category->update($validatedData);
                return response()->json(['message' => 'تم تعديل الفئة', 'category' => $category], 200);
            } else {
                return response()->json(['message' => 'غير موجود', 'category' => null], 404);
            }
        } catch (\Exception $e) {
            Log::error('خطاء اثناء تعديل الفئة: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطاء اثناء تعديل الفئة'], 500);
        }
    }

    /**
     * function creat to delet  categorie
     * @param integer $id(id of category)
     * @return json response(message)
     */

    public function destroy($id)
    {
        try {
            $category=Category::find($id);
            if ($category) {
                $category->delete();
            } else {
                return response()->json(['message' => ' غير موجود', 'category' => $category], 404);
            }
            return response()->json(['message' => 'تم حذف الفئة', 'category' => $category], 200);
        } catch (\Exception $e) {
            Log::error('خطاء في حذف الفئة: ' . $e->getMessage());
            return response()->json(['message' => 'حدث خطاء اثناء حذف الفئة'], 500);
        }
    }
















}
