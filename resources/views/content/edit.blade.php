@extends('layout')
@section('content')
    <form action="{{ '/content/' . $content['id'] }}" method="post">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control" value="{{ $content['title'] }}">
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control">{{ $content['notes'] }}</textarea>
        </div>
        <div class="form-group">
            <label for="links">links</label>
            <textarea name="links" id="links" class="form-control" placeholder="title: link (break line to add more)">{{ $content['links'] }}</textarea>
        </div>
        <div class="form-group">
            <label for="Section">Section</label>
            <select name="Section" id="Section" class="form-control">
                @foreach ($content['sections'] as $section)
                    @if ($content['selected_section_id'] == $section->id) 
                        <option value="{{ $section->id }}" selected> {{ $section->name }} </option>
                        @continue
                    @endif

                    <option value="{{ $section->id }}"> {{ $section->name }} </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="status">Status</label>
            <select name="status" id="status" class="form-control">
                @foreach ($content['status'] as $status)
                    @if ($content['current_status'] == $status) 
                        <option value="{{ $status }}" selected> {{ $status }} </option>
                        @continue
                    @endif
                    <option value="{{ $status }}"> {{ $status }} </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection