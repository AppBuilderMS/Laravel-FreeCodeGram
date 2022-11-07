<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Routing\Console\MiddlewareMakeCommand;
use Intervention\Image\Facades\Image;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $posts = Post::latest()->paginate(9);

        return view('posts.index', compact('posts'));
    }

    public function followersPosts()
    {
        $users = auth()->user()->following()->pluck('profiles.user_id');

        $posts = Post::whereIn('user_id', $users)->with('user')->latest()->paginate(5);  //orderBy('created_at', 'DESC')  == latest()
        //with('user') To solve the problem of limit 1 intelescop and user refere to relationship in post model
        //dd($posts);

        return view('posts.followers_posts', compact('posts'));
    }

    public function create()
    {
        return view('posts.create');
    }

    public function store()
    {
        $data= request()->validate([
            'caption' => 'required',
            'image' => 'required|image',
        ]);

        $imagePath =request('image')->store('uploads', 'public');

        $image = Image::make(public_path("storage/{$imagePath}"))->resize(1200, 1200);

        $image->save();

        //auth()->user()->posts()->create($data);

        auth()->user()->posts()->create([
            'caption' => $data['caption'],
            'image' => $imagePath,
        ]);

        //dd(request()->all());

        return redirect('/profile/' . auth()->user()->id);
    }

    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

}
