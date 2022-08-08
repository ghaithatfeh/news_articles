@extends('layouts.app')
@section('content')
    <article-component :article="{{ $article }}" :type="'edit'"></article-component>
@endsection
