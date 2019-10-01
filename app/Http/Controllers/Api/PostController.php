<?php

namespace App\Http\Controllers\Api;

use App\Post;
use App\Http\Controllers\Controller;
use App\Rules\UniqueSlug;
use Carbon\Carbon;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($limit = 5)
    {
        $posts = Post::getPublished()->whereType('post');
        
        return response()->json([
            'data' => $posts->limit($limit)->get(),
            'status' => Response::HTTP_OK,
            'count' => $posts->count(),
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show($postID)
    {
        if ($post = Post::find($postID)) {
            return response()->json([
                'result' => true,
                'data' => ['post' => $post],
                'status' => Response::HTTP_OK,
            ], 200);
        } else {
            return response()->json([
                'result' => false,
                'status' => Response::HTTP_NOT_FOUND,
            ], 404);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->except(['token', 'user']);

        $validator = Validator::make($data, [
            'title' => ['required', 'min:3', 'max:255', new UniqueSlug],
            'longTitle' => 'nullable|min:3|max:255',
            'summary' => 'nullable',
            'body' => 'required|min:3',
            'commentable' => 'nullable|boolean',
            'featured' => 'nullable|boolean',
            'featureimage' => 'nullable',
            'published' => 'nullable|boolean',
            'published_at_date' => 'nullable|date',
            'published_at_time' => 'nullable|date_format:"H:i"',
            'type' => 'nullable',
            'use_hash' => 'nullable',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'result' => false,
                'data' => ['errors' => $validator->errors()],
                'status' => Response::HTTP_UNPROCESSABLE_ENTITY
            ], 422);
        }
        
        if (!isset($data['commentable'])) {
            $data['commentable'] = 0;
        }

        if (!isset($data['featured'])) {
            $data['featured'] = 0;
        }

        if (!isset($data['published'])) {
            $data['published'] = 1;
        }

        if (!isset($data['published_at_date'])) {
            $data['published_at_date'] = Carbon::now()->toDateString();
        }

        if (!isset($data['published_at_time'])) {
            $data['published_at_time'] = Carbon::now()->toTimeString();
        }

        if (!isset($data['use_hash'])) {
            $data['use_hash'] = 0;
        }

        $data = Post::processData($data);

        $data['body'] = "<p>".nl2br($data['body'])."</p>";
        
        $post = Post::create($data)->sync($request);
        
        return response()->json([
            'result' => true,
            'data' => ['post' => $post->fresh()],
            'status' => Response::HTTP_OK
        ], 200);
    }
}
