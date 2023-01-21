<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Comment;
use App\Models\Like;
use App\Models\Post;
use http\Env\Response;
use Illuminate\Http\JsonResponse;
use App\Http\Resources\UserActivityResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\CommentRequest;
use Symfony\Component\Console\Helper\Table;

class UserController extends Controller
{
    public function showUserActivity(Request $request): JsonResponse
    {
        return response()->json(new UserActivityResource(Auth::user()));
    }

    public function likePost($post_id): JsonResponse
    {
        if (count(DB::table('posts')->where('id', $post_id)->where('user_id', Auth::user()->getAuthIdentifier())->get()) == 1) {
            return response()->json([
                'error' => 'You can\'t like your own post',
            ]);
        }
        if (count(DB::Table('likes')->where('user_id', Auth::user()->getAuthIdentifier())->where('post_id', $post_id)->get()) == 1) {
            return response()->json(['error' => 'You already like this.']);
        }
        $new_like = Like::create([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'post_id' => $post_id,
        ]);

        return response()->json($new_like);
    }

    public function unlikePost($post_id): JsonResponse
    {
        $like = DB::table('likes')->where('user_id', Auth::user()->getAuthIdentifier())->where('post_id', $post_id)->delete();
        if ($like) {
            return response()->json(['message' => 'Unliked']);
        }
        return response()->json(['error' => 'You already unlike this']);
    }

    public function commentPost($post_id, CommentRequest $request)
    {
        $request = $request->validated();
        $new_comment = Comment::create([
            'user_id' => Auth::user()->getAuthIdentifier(),
            'post_id' => $post_id,
            'text' => $request['text']
        ]);
        return ($new_comment);
    }
}
