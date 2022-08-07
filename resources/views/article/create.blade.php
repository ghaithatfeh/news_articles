@extends('layouts.app')
@section('content')
    @if ($errors->any())
        <div class="d-flex justify-content-center">
            <div class="alert alert-danger">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        </div>
    @endif
    <article-component></article-component>
@endsection
