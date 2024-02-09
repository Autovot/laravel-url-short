@extends('layout.master')
@section('titulo', 'URL Shortener')
@section('main')
    <h2>Prueba</h2>
    <a href="dash"><button>Dashboard</button></a>
    <form action="/api/shortener" method="POST">
        @csrf
        <label for="url-input">
            <input type="url" name="url-input" id="url-input">
        </label>
        <label for="send">
            <input type="submit" value="SMASH" id="send">
        </label>
        <label for="url-output">
            <input type="url" name="url-output" id="url-output" @disabled(true) </label>
    </form>
@endsection
