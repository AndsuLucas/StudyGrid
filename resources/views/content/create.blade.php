@extends('layout')

@section('content')
    <form action="/content" method="post">
        @csrf
        <div class="form-group">
            <label for="title">Title</label>
            <input type="text" name="title" id="title" class="form-control">
        </div>
        <div class="form-group">
            <label for="notes">Notes</label>
            <textarea name="notes" id="notes" class="form-control"></textarea>
        </div>
        <div class="form-group">
            <label for="links">links</label>
            <textarea name="links" id="links" class="form-control" placeholder="'title->link' (break line to add more)"></textarea>
        </div>
        <div class="form-group">
            <label for="Section">Section</label>
            <select name="Section" id="Section" class="form-control">
                @foreach ($available_sections as $section)
                    <option value="{{ $section->id}}"> {{ $section->name }} </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
@endsection