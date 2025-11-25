@extends('layouts.app')

@section('content')
    <div id="app"></div>
@endsection

@viteReactRefresh
@vite('resources/js/app.jsx')
