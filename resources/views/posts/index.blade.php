@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>New Posts</h3>
        <div class="row">
            @if($posts->count() > 0)
                @foreach ($posts as $post)
                    <div class="col-md-4">
                        <a href="/profile/{{$post->user->id}}">
                            <img src="/storage/{{$post->image}}" class="w-100">
                        </a>
                        <p>
                            <span class="fw-bold">
                                <a class="text-decoration-none" href="/profile/{{$post->user->id}}">
                                    <span class="text-dark">{{$post->user->username}}</span>
                                </a>
                            </span>
                            {{$post->caption}}
                        </p>
                    </div>
                @endforeach
            @else
                <div class="alert alert-warning">
                    <h3>No Posts Yet</h3>
                </div>
            @endif
        </div>

        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                {{$posts->links()}}
            </div>
        </div>
    </div>
@endsection
