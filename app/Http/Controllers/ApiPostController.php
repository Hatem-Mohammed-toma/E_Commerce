<?php

namespace App\Http\Controllers;

use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ApiPostController extends Controller
{
    public function all(){
        // all admin pending
        // $posts = Post::where('status', 'pending')->get();
        // return PostResource::collection($posts);
        $posts = Post::select('id','title', 'content')
                 ->where('status', 'pending')
                 ->get();

    // Return the posts as a JSON response
    return response()->json($posts);
    }

    public function postuser()
    {
        // Query to get posts with status 'accepted'
        $posts = Post::select('id', 'title', 'content', 'user_id', 'media')
                     ->where('status', 'accepted')
                     ->get()
                     ->map(function($post) {
                         // Transform media path to a full URL
                         if ($post->media) {
                             $post->media = asset('storage/' . $post->media);
                         }
                         return $post;
                     });

        // Return the posts as a JSON response
        return response()->json($posts);
    }

    public function store(Request $request)
    {
        $access_token = $request->header("access_token");
        // Retrieve the user by access token (assuming tokens are stored in the database)
        $user = User::where('access_token', $access_token )->first();

        if (!$user) {
            return response()->json([
                "msg" => "Unauthorized"
            ], 401);
        }

        $validator = Validator::make($request->all(), [
            "title" => "required|string|max:255",
            "content" => "required|string|max:255",
            "media" => "nullable|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480", // Optional media

        ]);
       // "image"=>"required|file|mimes:jpg,jpeg,png,mp4,mov,avi|max:20480",
        // If validation fails, return errors
        if ($validator->fails()) {
            return response()->json([
                "errors" => $validator->errors()
            ], 422);
        }
//  // Handle file upload if provided
//      $mediaPath = null;
//     if ($request->hasFile('media')) {
     $mediaPath = Storage::putFile("posts", $request->media);
//     }
    // $request->image
        Post::create([
            "title" => $request->title,
            "content" => $request->content,
            "user_id" => $user->id, // Include the user ID
            "media" => $mediaPath, // Save the file path, or null if no file uploaded

        ]);

        return response()->json([
            "msg" => "Post added successfully"
        ], 201);
    }



///   canceld and accepted
    public function update(Request $request, $status, $id)
{
    // Validate the status parameter directly from the route
    $validator = Validator::make(['status' => $status], [
        'status' => 'required|string|in:pending,accepted,canceled',
    ]);

    if ($validator->fails()) {
        return response()->json([
            "errors" => $validator->errors()
        ], 422); // 422 Unprocessable Entity for validation errors
    }

    // Find the post by its ID
    $post = Post::find($id);
    if ($post === null) {
        return response()->json([
            "msg" => "Post not found"
        ], 404); // 404 Not Found
    }

    // Check if the status is 'canceled' and delete the post if it is
    if ($status === 'canceled') {
        $post->delete();
        return response()->json([
            "msg" => "Post canceled and deleted successfully"
        ], 200); // 200 OK
    }

    // Update the post status
    $post->update([
        "status" => $status,
    ]);

    return response()->json([
        "msg" => "Post updated successfully",
        "post" => $post
    ], 200);
}


//     public function delete($id)
// {
//     // Find the post by its ID
//     $post = Post::find($id);

//     // If the post is not found, return a 404 Not Found response
//     if ($post === null) {
//         return response()->json([
//             "msg" => "Post not found"
//         ], 404); // 404 Not Found
//     }

//     // Delete the post
//     $post->delete();

//     // Return a success response
//     return response()->json([
//         "msg" => "Post deleted successfully"
//     ], 200); // 200 OK
// }

public function delete_user(Request $request, $id)
{
    $access_token = $request->header("access_token");
    $user = User::where('access_token', $access_token )->first();

    if (!$access_token) {
        return response()->json([
            "msg" => "Access token is required"
        ], 401);
    }

    $post = Post::find($id);
    if ($post === null) {
        return response()->json([
            "msg" => "Post not found"
        ], 404); // 404 Not Found
    }
    if ($post->user_id !== $user->id) {
        return response()->json([
            "msg" => "Unauthorized"
        ], 403); // 403 Forbidden
    }
    // Delete the post
    $post->delete();

    return response()->json([
        "msg" => "Post deleted successfully"
    ], 200);
}


}
