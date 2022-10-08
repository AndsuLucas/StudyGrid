@extends('layout')
@section('content')
    <main>
        <div class="row mt-1">
            <div class="col">
                <h1>{{ $content['title'] }}</h1>
                <span>({{ $content['status'] }})</span>
                <hr>
            </div>
        </div>
        <div class="row mt-1">
            <div class="col">
                <h2>Links</h2>
                @if (isset($content['links']))
                    <ul class="list-group">
                        @foreach ($content['links'] as $linkTitle => $link)
                            <li class="list-group-item">
                                <strong>{{ $linkTitle . ':' }}</strong>
                                <a href="{{ $link }}" target="_blank"> Content </a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <p>No links!</p>
                @endif
            </div>
        </div>
        <div class="row mt-2">
            <div class="col">
                <h2>Notes</h2>
                <p>{{ $content['notes'] }}</p>
            </div>
        </div>
    </main>
@endsection