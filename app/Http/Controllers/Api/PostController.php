<?php

namespace App\Http\Controllers\Api;

use App\Post;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($limit = 5)
    {
        $posts = Post::getPublished();
        
        return response()->json([
            'data' => $posts->limit($limit)->get(),
            'status' => Response::HTTP_OK,
            'count' => $posts->count(),
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json(['data' => $post,
            'status' => Response::HTTP_OK]);
    }
}
