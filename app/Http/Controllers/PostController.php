<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use App\Models\Posts;

class PostController extends Controller
{
    public function addPost(Request $request){
        $content = $request->content; //
        $id = auth()->user()->getAuthIdentifier();
        $post =  new \App\Models\Posts(); // Модель Posts
        $post->content = $content; // Значение столбца content
        $post->author_id = $id; // Значение столбца author_id
        $post->save(); // Сохраняем в БД
    }

    public function showPost(Request $request){
        //$post = Posts::where('author_id', $authorId)->first();
        //$comments = Comment::where('post_id', $postId)->get(); // Получаем все записи
        //$userId = auth()->user()->getAuthIdentifier();
        //return view('profile.edit', ['post'=>$post]);
    }
}
