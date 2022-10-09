@extends('layout');
@section('content')
    <table class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Actions</th>
                <th>Id</th>
                <th>Name</th>
                <th>Updated at</th>
                <th>Created At</th>
                <th>Contents binded</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($sections as $section)
                <tr data-id="{{ $section->id }}" class="content-line">
                    <td>
                        actions here
                    </td>
                    <td>{{ $section->id }}</td>
                    <td>{{ $section->name}}</td>
                    <td>{{ $section->updated_at}}</td>
                    <td>{{ $section->created_at}}</td>
                    <td>{{ $section->content_count}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        (function(){
            const contentLine = document.querySelectorAll('.content-line');
            contentLine.forEach((content) => {
                content.addEventListener('click', (event) => {
                    const sectionId = content.dataset.id;
                    window.open(`/section/${sectionId}/contents`, 'section content' + sectionId);
                })
            });
        })();
    </script>
@endsection