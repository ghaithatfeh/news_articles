@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Articles</h1>
        <a class="btn btn-success" href="{{ route('article.create') }}">Create New Article</a>
    </div>
    @foreach ($articles as $article)
        <div class="card my-3">
            <div class="card-body">
                <h5 class="card-title">{{ $article->title }}</h5>
                <p class="card-text">This is a wider card with supporting text below as a natural lead-in to additional
                    content.
                    This content is a little bit longer.</p>
                <p class="card-text">
                    <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                </p>
            </div>
        </div>
    @endforeach
    {{ $articles->links() }}
@endsection
