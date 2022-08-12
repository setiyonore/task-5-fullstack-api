<?php

namespace App\Http\Controllers;
use Config;
use Validator;
use App\Models\Post;
use Illuminate\Http\Request;
class PostController extends Controller
{
    public function index()
    {
        return response()->json([
            'success' => true,
            'message' => 'Success get post data',
            'data' => Post::query()
                        ->select('id','title','category_id')
                        ->paginate(config('config.paginate'))
        ]);
    }
    public function show($id)
    {
        try {
            $post = Post::findOrFail($id);
        } catch (ModelNotFoundException $exception) {
            $exception->getMessage();

        }

        return response()->json([
            'success' => true,
            'message' => 'Success get data post',
            'data' => [
                'id' => $post->id,
                'title' => $post->title,
                'content' => $post->content,
                'image' => $post->image,
                'user_id' => $post->user_id,
                'category_id' => $post->category_id
            ],
        ],200);
    }
    public function update(Request $request, Post $post)
    {
        $validator = Validator::make(
            $request->only(['title','content','image','category_id']),[
              'title' => 'required|min:5',
              'content' => 'required',
              'image' => 'required',
              'category_id' => 'required'
            ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ],500);
        }

        $post->update([
            'title' => $request->title,
            'content' => $request->content,
            'image' => $request->image,
            'category_id' => $request->category_id
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Data post update successfully',
        ],200);
    }
    public function store(Request $request)
    {
        $validator = Validator::make(
            $request->only(['title','content','image','category_id']),[
              'title' => 'required|min:5',
              'content' => 'required',
              'image' => 'required',
              'category_id' => 'required'
            ]);
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Please see errors parameter for all errors.',
                'errors' => $validator->errors()
            ],500);
        }
        $data = Post::create([
            'title' => $request['title'],
            'content' => $request['content'],
            'image' => $request['image'],
            'user_id' => auth()->user()->id,
            'category_id' => $request['category_id']
        ]);
        return response()->json([
            'success' => true,
            'message' => 'Post save successfully',
            'data' => array([
                'id' => $data->id,
                'title' => $data->title,
                'content' => $data->content,
                'image' => $data->image,
                'user_id' => $data->user_id,
                'category_id' => $data->category_id,
            ])
        ],200);

    }

    public function destroy($id)
    {
        $post = Post::findOrFail($id);
        $post->delete();
        return response()->json([
            'success' => true,
            'message' => 'Delete post successfully'
        ],200);
    }
}
