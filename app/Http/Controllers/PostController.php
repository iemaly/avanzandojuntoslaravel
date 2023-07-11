<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Models\Business;
use App\Models\Post;
use Illuminate\Support\Facades\Mail;
use App\Traits\ImageUploadTrait;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    use ImageUploadTrait;

    function index()
    {
        $business = auth('business_api')->id();
        $posts = $business==null?Post::with('business')->get():Post::with('business')->where('business_id', $business)->get();
        return response()->json(['status'=>true, 'data'=>$posts]);
    }

    function indexForAll()
    {
        $posts = Post::with('business')->where('status',1)->get();
        return response()->json(['status'=>true, 'data'=>$posts]);
    }

    public function store(StorePostRequest $request)
    {
        $request = $request->validated();
        
        try {
            if (!empty($request['image'])) {
                $imageName = $request['image']->getClientOriginalName() . '.' . $request['image']->extension();
                $request['image']->move(public_path('uploads/posts/images'), $imageName);
                $request['image'] = $imageName;
            }
            $post = Post::create($request);
            return response()->json(['status'=>true, 'response'=>'Record Created', 'data'=>$post]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function update(UpdatePostRequest $request, $post)
    {
        $request = $request->validated();
        
        try {
            $post = Post::find($post);
            $post->update($request);
            return response()->json(['status'=>true, 'response'=>'Record Updated', 'data'=>$post]);
        } catch (\Throwable $th) {
            return response()->json(['status'=>false, 'error'=>$th->getMessage()]);
        }
    }

    function show($post)
    {
        $post = Post::with('business')->find($post);
        return response()->json(['status'=>true, 'data'=>$post]);
    }

    function showForAll($post)
    {
        $post = Post::with('business')->where('status',1)->find($post);
        return response()->json(['status'=>true, 'data'=>$post]);
    }

    function destroy($post)
    {
        return Post::destroy($post);
    }

    function activate($post)
    {
        $post = Post::with('business')->find($post);
        $post->update(['status'=>1]);

        Mail::raw("Sir your post is approved on avanzando juntos", function ($message) use ($post) 
        {
            $message->to($post->business->email)->subject('Post Approved');
            $message->from(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME'));
        });
        return response()->json(['status'=>true, 'response'=>"Post Approved"]);
    }

    function imageUpdate($post)
    {
        $validator = Validator::make(
            request()->all(),
            [
                'image' => 'required|mimes:jpeg,jpg,png,gif|max:30000',
            ]
        );

        if ($validator->fails()) return back()->withErrors($validator)->withInput();

        $media = Post::find($post);
        try {
            // DELETING OLD IMAGE IF EXISTS
            if (!empty($media->image)) {
                $this->deleteImage($media->image);
                $media->update(['image' => (NULL)]);
            }

            // UPLOADING NEW IMAGE
            $imageName = request()->image->getClientOriginalName() . '.' . request()->image->extension();
            request()->image->move(public_path('uploads/posts/images'), $imageName);
            request()->image = $imageName;
            $media->update(['image' => request()->image]);
            return response()->json(['status' => true, 'response' => 'Record Updated']);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()]);
        }
    }
}
