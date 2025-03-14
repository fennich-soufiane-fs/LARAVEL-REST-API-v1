<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\CreatePostRequest;
use Exception;


class PostController extends Controller
{
    public function index() {
        return 'Liste des articles';
    }

    public function store(CreatePostRequest $request) {
        try {
            $post = new Post();
            $post->titre = $request->titre;
            $post->description = $request->description;
            $post->save();

            return response()->json([
                'status_code' => 200,
                'status_message' => 'Posts Created Successfully',
                'data' => $post,
            ]);
        } catch(Exeption $e) {
            return response()->json($e);
        }
    }
}
