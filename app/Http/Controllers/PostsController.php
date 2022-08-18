<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostsController extends Controller
{
    public function read(){
        return Post::all();
    }

    public function readSingle($id){
        return Post::find($id);
    }

    public function create(Request $request){
        $form = $request->validate([
            'name' => 'required',
            'tag' => 'nullable',
            'description' => 'nullable',
        ]);
        $form['user_id'] = Auth::id();
        return Post::create($form);
    }

    public function update(Request $request, $id){
        $post = Post::find($id);
        $post->update($request->all());

        return $post;
    }

    public function delete($id){
        $post = Post::find($id);
        $post->delete($id);

        return ['message' => 'posts with id:'.$id.' has been deleted'];
    }
}
