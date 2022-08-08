@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center">
        <h1>Articles</h1>
        <a class="btn btn-success" href="{{ route('article.create') }}">Create New Article</a>
    </div>
    @foreach ($articles as $article)
        <div class="card my-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">{{ $article->title }}</h3>
                    @if (auth()->id() == $article->user_id)
                        <div class="actions">
                            <a class="mx-2" href="">Edit</a>
                            <a class="mx-2" href="" onclick="deleteArticle(event)">Delete</a>
                            <form id="delete-form" method="POST"
                                action="{{ route('article.delete', ['article' => $article->id]) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        </div>
                    @endif
                </div>
                @foreach ($article->blocks->take(2) as $block)
                    <p>{!! $block->value !!}</p>
                @endforeach
                <p class="card-text">
                    <small class="text-muted">{{ $article->user->name }}</small> |
                    <small class="text-muted">{{ $article->created_at->diffForHumans() }}</small>
                </p>
            </div>
        </div>
    @endforeach
    {{ $articles->links() }}
@endsection

@section('script')
    <script>
        function deleteArticle(e) {
            e.preventDefault()
            if (confirm('Are you sure you want to delete this article?'))
                document.getElementById('delete-form').submit()
        }
    </script>
@endsection
