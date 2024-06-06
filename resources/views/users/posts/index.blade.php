@extends('layouts.app')

@section('content')

<div class="container bg-white p-3">
    <div class="row">
        <!-- Text area -->
        <div class="col">
            <form action="{{ route('posts.store') }}" method="POST">
                @csrf
                <div class="form-floating">
                    <textarea class="form-control @error('content') border border-danger @enderror" name="content" placeholder="Leave a comment here" id="floatingTextarea2" style="height: 100px"></textarea>
                    @error('content')
                        <div class="text-danger">
                            {{ $message }}
                        </div>
                    @enderror
                    <label for="floatingTextarea2">What's on your mind?</label>
                </div>
                <button type="submit" class="btn btn-primary mt-3">Post</button>
            </form>
        </div>

        <!-- Feed -->
        <div class="col">
            @if ($posts->isEmpty())
                <div class="p-3 text-white bg-secondary rounded border">
                    There are no posts yet!
                </div>
            @else
                @foreach ($posts as $post)
                    <div class="card my-3">
                        <div class="card-header">
                            @if ($post->user)
                                {{ $post->user->name }}
                            @else
                                Unknown User
                            @endif
                        </div>
                        <div class="card-body">
                            <blockquote class="blockquote mb-0">
                                <p>{{ $post->content }}</p>
                            </blockquote>

                            <hr>

                            <!-- Like, Edit and Delete Buttons -->
                            <div class="d-flex align-items-center mb-3">
                                <form action="{{ route('posts.likes', ['post' => $post, 'user' => auth()->user()->id]) }}" method="POST" class="me-2">
                                    @csrf
                                    <button class="btn btn-outline-primary btn-sm">Like <span class="badge text-bg-primary">{{ $post->likes->count() }}</span></button>
                                </form>

                                @can('update', $post)
                                    <button class="btn btn-outline-secondary btn-sm me-2" onclick="document.getElementById('edit-post-{{ $post->id }}').style.display='block'">Edit</button>
                                    <div id="edit-post-{{ $post->id }}" style="display: none;">
                                        <form action="{{ route('posts.update', $post->id) }}" method="POST" class="d-inline">
                                            @csrf
                                            @method('PUT')
                                            <textarea class="form-control @error('content') border border-danger @enderror" name="content" style="height: 100px">{{ $post->content }}</textarea>
                                            @error('content')
                                                <div class="text-danger">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                            <button type="submit" class="btn btn-success mt-2">Update</button>
                                        </form>
                                    </div>
                                @endcan

                                @can('delete', $post)
                                    <form action="{{ route('posts.destroy', $post->id) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                @endcan
                            </div>

                            <!-- Comments Section -->
                            <div class="mt-3">
                                <h5>Comments</h5>
                                @foreach ($post->comments as $comment)
                                    <div class="mb-1">
                                        <div>
                                            <p style="font-size: 1.10rem; padding: 0.25 rem 0;"><strong>{{ $comment->user->name }}</strong>: {{ $comment->content }}</p>
                                            <div class="d-inline-flex align-items-center">
                                                @can('update', $comment)
                                                    <button class="btn btn-link p-0 me-2" onclick="document.getElementById('edit-comment-{{ $comment->id }}').style.display='block'">Edit</button>
                                                    <div id="edit-comment-{{ $comment->id }}" style="display: none;">
                                                        <form action="{{ route('comments.update', $comment->id) }}" method="POST" class="d-inline">
                                                            @csrf
                                                            @method('PUT')
                                                            <textarea class="form-control @error('content') border border-danger @enderror" name="content" style="height: 100px">{{ $comment->content }}</textarea>
                                                            @error('content')
                                                                <div class="text-danger">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                            <button type="submit" class="btn btn-success mt-2">Update</button>
                                                        </form>
                                                    </div>
                                                @endcan

                                                @can('delete', $comment)
                                                    <form action="{{ route('comments.destroy', $comment->id) }}" method="POST" class="d-inline ms-2">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-link p-0">Delete</button>
                                                    </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <!-- Comment Form -->
                            <form action="{{ route('comments.store', $post) }}" method="POST" class="mt-3">
                                @csrf
                                <div class="form-floating">
                                    <textarea class="form-control @error('content') border border-danger @enderror" name="content" placeholder="Leave a comment here" id="floatingTextareaComment" style="height: 100px"></textarea>
                                    @error('content')
                                        <div class="text-danger">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                    <label for="floatingTextareaComment">Add a comment...</label>
                                </div>
                                <button type="submit" class="btn btn-primary mt-3">Comment</button>
                            </form>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>

</div>

@endsection
