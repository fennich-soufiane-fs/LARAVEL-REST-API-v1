<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Http\Requests\CreatePostRequest;
use Exception;
use App\Http\Requests\EditPostRequest;
use Illuminate\Support\Facades\Auth;


class PostController extends Controller
{
    public function index(Request $request) {

        try {
            $query = Post::query();
            $perPage = 2;
            $page = $request->input('page', 1);
            $search = $request->input('search');

            if($search) {
                // $query->whereRaw("titre LIKE '%" . $search ."%'");
                $query->where('titre', 'LIKE', "%{$search}%");
            }

            $total = $query->count();

            $result = $query->offset(($page - 1) * $perPage)->limit($perPage)->get();

            $posts = Post::all(); 
    
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Posts retrieved successfully',
                'current_page' => $page,
                'last_page' => ceil($total / $perPage),
                'items' => $result
            ], 200);
    
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'An error occurred while fetching posts.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function store(CreatePostRequest $request) {
        try {
            $post = new Post();
            $post->titre = $request->titre;
            $post->description = $request->description;
            $post->user_id = auth()->user()->id;
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

    public function update(EditPostRequest $request, Post $post) {
        try {
            $post->titre = $request->titre;
            $post->description = $request->description;
            $post->save();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Posts Updated Successfully',
                'data' => $post,
            ]);
        } catch (Exception $e) {
            return reqponse()->json($e);
        }
    }

    public function delete($id) {
        try {
            $post = Post::find($id); // Trouver le post sans lancer une exception automatique
    
            if (!$post) {
                return response()->json([
                    'status_code' => 404,
                    'status_message' => 'Post Not Found'
                ], 404);
            }
    
            $post->delete();
            return response()->json([
                'status_code' => 200,
                'status_message' => 'Post Deleted Successfully',
            ]);
    
        } catch (Exception $e) {
            return response()->json([
                'status_code' => 500,
                'status_message' => 'An error occurred.',
                'error' => $e->getMessage()
            ], 500);
        }
    } 
}
