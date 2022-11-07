@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-3 p-5">
            <img  class="_6q-tv rounded-circle mx-auto d-block w-100" src="{{ $user->profile->profileImage() }}">
        </div>
        <div class="col-9 pt-5">
            <div class="d-flex justify-content-between align-items-baseline">
                <div class='d-flex align-items-center' >
                    <div class="h3 pe-3">{{ $user->username }}</div>
                    <follow-button user-id="{{ $user->id }}" follows={{ $follows }}></follow-button>
                </div>


                @can('update', $user->profile)
                    <a class="text-decoration-none" href="/p/create">Add New Post</a>
                @endcan

            </div>

            @can('update', $user->profile)
                <a class="text-decoration-none" href="/profile/{{$user->id}}/edit">Edit Profile</a>
            @endcan


            <div class="d-flex">
                <div class="pe-5"><strong>{{ $postCount }}</strong> posts</div>
                <div class="pe-5"><strong>{{ $followersCount }}</strong> followers</div>
                <div class="pe-5" ><strong>{{ $followingCount }}</strong> following</div>
            </div>

            <div class="pt-4 font-weight-bold">{{ $user->profile->title }}</div>
            <div>{{ $user->profile->description }}</div>
            <div><a href="#">{{ $user->profile->url ?? "N/A" }}</a></div>
        </div>
    </div>

    <div class="row pt-5">
        @foreach ($user->posts as $post)
            <div class="col-4 pb-4">
                <a href="/p/{{ $post->id }}">
                    <img src="/storage/{{ $post->image }}" class="w-100">
                </a>
            </div>
        @endforeach

    </div>
</div>
@endsection
