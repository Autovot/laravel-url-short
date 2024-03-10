@extends('layout.master')
@section('titulo', 'Dash URL Shortener')
@section('main')
    <h2>Dashboard</h2>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>URL Origin</th>
                <th>URL Shortened</th>
                <th>uses</th>
                <th>Last use</th>
                <th>Created</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($data as $item)
                <tr>
                    <th>
                        {{ $item->id }}
                    </th>
                    <th>
                        {{ $item->origin }}
                    </th>
                    <th>
                        <a href="{{ env('APP_URL', 'http://localhost') }}/{{ $item->smashed }}">
                            {{ env('APP_URL', 'http://localhost') }}/{{ $item->smashed }}
                        </a>
                    </th>
                    <th>
                        {{ $item->used }}
                    </th>
                    <th>
                        {{ $item->updated_at }}
                    </th>
                    <th>
                        {{ $item->created_at }}
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
