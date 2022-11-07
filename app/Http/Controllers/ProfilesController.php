<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Cache;
use Intervention\Image\Facades\Image;

class ProfilesController extends Controller
{
    public function index(User $user)
    {
        //dd($user);
        //$user = User::findOrFail($user);  //findOrFail used to find the user without exception error if the is not exist

        $follows = (auth()->user() ? auth()->user()->following->contains($user->id) : false);

        //dd($follows);

        $postCount = Cache::remember('count.posts' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->posts->count();
        });

        $followersCount = Cache::remember('count.followers' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->profile->followers->count();
        });

        $followingCount = Cache::remember('count.following' . $user->id, now()->addSeconds(30), function () use ($user) {
            return $user->following->count();
        });


        return view('profiles.index', compact('user', 'follows', 'postCount', 'followersCount' , 'followingCount'));
    }

    public function edit(User $user)
    {
        $this->authorize('update', $user->profile);  //$ php artisan make:policy ProfilePolicy -m Profile

        return view('profiles.edit', compact('user'));
    }

    public function update(User $user)
    {
        $this->authorize('update', $user->profile);

        $data = request()->validate([
            'title' => 'required',
            'description' => 'required',
            'url' => 'url',
            'image' => '',
        ]);

        //dd($data);

        if (request('image')) {

            $imagePath = request('image')->store('profile', 'public');

            $image = Image::make(public_path("storage/{$imagePath}"))->resize(1000, 1000);

            $image->save();

            $imageArray = ['image' => $imagePath];

        }

        auth()->user()->profile->update(array_merge(
            $data,
            $imageArray ?? []
        ));

        return redirect("/profile/{$user->id}");
    }
}
