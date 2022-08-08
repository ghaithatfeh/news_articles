@extends('layouts.app')
@section('content')
    <article-component :article="{{ $article }}" :type="'view'"></article-component>
@endsection
