@extends('master')

@section('title', 'Todo')

@section('content')

    @if (session('data'))
        @php
            $data = Session::get('data');
            $tasks = $data['tasks'];
            $status = $data['status'];
        @endphp
    @endif

    <div class="alerts">
        @if (session('status'))
            <div class="alert alert-success">
                {{ session('status') }}
            </div>
        @endif

        @if (isset($status))
            <div class="alert alert-success">
                {{ $status }}
            </div>
        @endif

        @error('name')
            <div class="alert alert-danger">
                {{ $message }}
            </div>
        @enderror
    </div>

    <div class="card">
        <div class="card-header">
            New Task
        </div>
        <div class="card-body">
            <form action="{{ url('create') }}" method="post">
                @csrf
                <div class="mb-3">
                    <label for="task" class="form-label">Task</label>
                    <input type="text" class="form-control" id="task" name="name">
                </div>
                <button type="submit" class="btn btn-primary">Add</button>
            </form>

        </div>
    </div>

    <div class="card mt-5">
        <div class="card-header">
            Current Tasks
        </div>
        <div class="card-body">
            @if (isset($tasks))
                <table class="table">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Task</th>
                            <th scope="col"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tasks as $key => $value)
                            <tr>
                                <th scope="row">{{ $key + 1 }}</th>
                                <td>{{ $value->name }}</td>
                                <td><button class="btn btn-danger" onclick="on_delete({{ $value->id }})">delete</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @else
                <p class="text-primary">No Tasks Yet</p>
            @endif

        </div>
    </div>


    <script>
        function on_delete(task_id) {
            $confirm_result = confirm('are you sure?')

            if (!$confirm_result) return;

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                type: 'POST',
                url: '/delete' + '/' + task_id,
                success: function(returned_data) {
                    window.location.href = "/";
                },
            });
        }
    </script>

@endsection
