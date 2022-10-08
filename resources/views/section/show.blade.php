@extends('layout')
@section('content')
    <div class="row mt-1">
        <div class="col">
            <h1>{{ $section['name'] }}</h1>
            <hr>
        </div>
    </div>
    <div class="row mt-1">
        <div class="col">
            <h2>Contents</h2>
            @if (isset($section['contents']))
                <ul class="list-group">
                    @foreach ($section['contents'] as $content)
                        <li class="list-group-item">
                            <a href="#" target="_blank">
                                {{ $content->title . " (" . $content->status .")" }}
                            </a>
                        </li>
                    @endforeach
                </ul>
            @else
                <p>No content binded!</p>
            @endif
        </div>
    </div>
@endsection