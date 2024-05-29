<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function getPosts(Request $request) {
        // dd(Post::get());
        return Post::get();
    }

}
