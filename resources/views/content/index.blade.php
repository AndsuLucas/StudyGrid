@extends('layout')
@section('content')
    <table  class="table table-hover">
        <thead class="thead-dark">
            <tr>
                <th>Actions</th>
                <th>Id</th>
                <th>Title</th>
                <th>Section</th>
                <th>Status</th>
                <th>Updated at</th>
                <th>Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($contents as $content)
                <tr data-id="{{ $content->id }}" class="content-line">
                    <td>
                        <form action="{{ 'content/' . $content->id }}" method="POST" id="formDelete">
                            @csrf
                            @method('DELETE')
                            <button class="btn-sm btn-danger delete-button" type="submit">DELETE</button>
                        </form>
                        <br>
                        <a href="{{ 'content/' . $content->id . '/edit' }}" class="btn-sm btn-info">EDIT</a>
                    </td>
                    <td>{{ $content->id }}</td>
                    <td>{{ $content->title}}</td>
                    <td>{{ $content->Section}}</td>
                    <td>{{ $content->status}}</td>
                    <td>{{ $content->updated_at}}</td>
                    <td>{{ $content->created_at}}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <script>
        (function() {
            const deleteButton = document.querySelectorAll('.delete-button');
            deleteButton.forEach((element) => {
                element.addEventListener('click', (event) => {
                    event.preventDefault();
                    event.stopPropagation();
                    const mustDelete = confirm('Delete register?');
                    if (!mustDelete) {
                        return;
                    }

                    document.querySelector('#formDelete').submit();
                });
            });

            const contentLine = document.querySelectorAll('.content-line');
            contentLine.forEach((element) => {
                element.addEventListener('click', (event) => {
                    event.stopPropagation();
                    if (!confirm('Edit this register?')) {
                        return;
                    }
                    const contentId = element.dataset.id;
                    window.location = '/content/' + contentId;
                });
            });
        })();
    </script>
@endsection