@extends('layouts.app')

@section('content')
    @auth
        @if (Auth::check() && Auth::user()->isAdmin())
            <div id="books_admin"></div>
            
            @else
            
            <div id="books_user"></div>
        @endif
    @endauth
@endsection
