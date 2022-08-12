<?php

namespace App\Http\Controllers;
use Config;
use Validator;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Success get category data',
            'data' => Category::query()
                        ->select('id','name','user_id')
                        ->paginate(config('config.paginate'))
        ]);
    }

    public function show($id)
    {
        try {
            $category = Category::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            $exception->getMessage();
        }

        return response()->json([
            'success' => true,
            'message' => 'success get data category',
            'data' => [
                'id' => $category->id,
                'name' => $category->name,
                'user_id' => $category->user_id
            ],
        ],200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->only(['name']),['name'=>'required']
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ],500);
        }
        $data = Category::create([
            'name' => $request->name,
            'user_id' => auth()->user()->id
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Category save successfully',
            'data' => array([
                'id' => $data->id,
                'name' => $data->name,
                'user_id' => $data->user_id
            ]),
        ],201);
    }

    public function update(Request $request,Category $category)
    {
        $validator = Validator::make(
            $request->only(['name']),['name'=>'required']
        );

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ],500);
        }

        $category->update([
            'name' => $request->name
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data post update successfully',
        ],200);

    }

    public function destroy($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete category successfully'
        ],200);
    }
}
