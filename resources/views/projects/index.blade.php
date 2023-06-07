@extends('projects.layout')

@section('title', 'Projects')

@section('content')
<br>
<div class="container">
    <div class="row">
        <div class="col-lg-12">
            <div class="pull-left">
                <h2>PROJECTS</h2>
            </div><br>
            <div class="pull-right">
                <a class="btn btn-success" href="{{ route('projects.create') }}" style="margin-bottom: 20px;"> + </a>
            </div>
        </div>
    </div>

    @if ($message = Session::get('success'))
        <div class="alert alert-success">
        <p>{{ $message }}</p>
        </div>
    @endif

    <table id="example" class="table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Project Name</th>
                <th>Project Description</th>
                <th width="280px">Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($projects as $project)
            <tr>
                <td>{{ $project->id }}</td>
                <td>{{ $project->project_name }}</td>
                <td>{{ $project->project_description }}</td>
                <td>
                    <form action="{{ route('projects.destroy',$project->id) }}" method="POST">
                        <a class="btn btn-info" href=" ">Show</a>
                        <a class="btn btn-primary" href=" ">Edit</a>
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger" >Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
<script defer src="https://code.jquery.com/jquery-3.5.1.js"></script>
<script defer src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
<script defer src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script defer src="script.js"></script>
<script>
    $(document).ready(function() {
        $('#example').DataTable();
    });
</script>
@endsection
