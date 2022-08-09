@extends('layouts.app')
@section('content')
    <div class="d-flex justify-content-between align-items-center border-bottom">
        <h1>{{ Request::is('article/my-article') ? 'My' : 'All' }} Articles</h1>
        <a class="btn btn-success" href="{{ route('article.create') }}">Create New Article</a>
    </div>
    @forelse ($articles as $article)
        <div class="card my-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <h3 class="card-title">{{ $article->title }}</h3>
                    <div class="actions">
                        <a class="mx-2" href="{{ route('article.show', ['article' => $article]) }}">View</a>
                        @if (auth()->id() == $article->user_id)
                            <a class="mx-2" href="{{ route('article.edit', ['article' => $article->slug]) }}">Edit</a>
                            <a class="mx-2" href="#" onclick="deleteArticle(event, {{ $article->id }})">Delete</a>
                            <form id="delete-form-{{ $article->id }}" method="POST"
                                action="{{ route('article.destroy', ['article' => $article->slug]) }}">
                                @csrf
                                @method('DELETE')
                            </form>
                        @endif
                    </div>
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
    @empty
        <h5 class="mt-5 pt-5 text-center text-danger fst-italic">No articles yet.</h5>
    @endforelse
    {{ $articles->links() }}
@endsection

@section('script')
    <script>
        function deleteArticle(e, formId) {
            e.preventDefault()
            if (confirm('Are you sure you want to delete this article?'))
                document.getElementById('delete-form-' + formId).submit()
        }
    </script>
@endsection
