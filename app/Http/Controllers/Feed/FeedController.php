<?php

namespace App\Http\Controllers\Feed;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Comment;
use App\Models\Feed;
use App\Models\Like;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FeedController extends Controller
{

    public function index()
    {
        $feeds = Feed::with('user')->latest()->get();

        return response([
            'feeds' => $feeds
        ], 200);
    }

    public function store(PostRequest $request)
    {
        $request->validated();

        Auth::user()->feeds()->create([
            'content' => $request->content
        ]);


        return response([
            'msg' => 'Post succesfully submitted',
        ], 201);
    }


    public function likePost($feed_id)
    {
        $feed = Feed::whereId($feed_id)->first();

        if(!$feed){
            return response([
                "msg" => "Not found"
            ], 404);
        }

        if ($feed) {
            $like = Like::where(['User_id' => auth()->id(), 'feed_id' => $feed_id])->first();
            if($like){
                Like::where(['User_id' => auth()->id(), 'feed_id' => $feed_id])->delete();
                return response([
                    'msg' => 'Unliked'
                ], 200);
            }else{
                $liked = Like::create([
                    "user_id" => Auth::user()->id,
                    "feed_id" => $feed_id
                ]);

                return response([
                    'msg' => 'Liked',
                    'data' => $liked
                ], 200);
            }
        }else{
            return response([
                'msg' => 'Post does not exist.'
            ], 404);
        }

    }

    function getComments($feed_id)
    {
        $comments = Comment::with('feed', 'user')->whereFeedId($feed_id)->latest()->get();

        return response([
            'comment' => $comments
        ], 200);
    }

    public function comment(Request $request, $feed_id)
    {
        $request->validate([
            'body' => 'required|string'
        ]);

        $comment = Comment::create([
            'user_id' => Auth::user()->id,
            'feed_id' => $feed_id,
            'comment' => $request->body
        ]);

        return response([
            "msg" => "Comment successful",
            // "data" => $comment
        ], 201);
    }
}
