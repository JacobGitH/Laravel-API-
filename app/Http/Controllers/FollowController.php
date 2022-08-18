<?php

namespace App\Http\Controllers;

use App\Models\Follow;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class FollowController extends Controller
{
    //follows user through id
    //might change to email later
    public function follow($id){

        $follow = Follow::create([
            'user_id' => Auth::id(),
            'follow_id' => $id,
        ]);

        return $follow;
    }

    //shows all posts of people zou follow
    public function showFollows(){
        $follows = Follow::where('user_id', auth('sanctum')->user()->id)->get();
        $followings = [];
        //stores user ids in array for whereIn method
        foreach($follows as $follow){
        array_push($followings, $follow->follow_id);
        }

        $posts = DB::table('posts')->whereIn('user_id', $followings)->get();

        return $posts->all();
    }

    public function unfollow($id){
        
        $follow = Follow::where('follow_id', $id)->where('user_id', auth('sanctum')->user()->id);
        $follow->delete();

        return ['message' => 'user unfollowed'];
    }
}
