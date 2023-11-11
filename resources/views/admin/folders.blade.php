@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">
    {{-- <div class="container"> --}}

        <button type="button" class="btn btn-primary mb-5" data-bs-toggle="modal" data-bs-target="#addFolderModal">
            Add Folder
        </button>




        <table class="table table-bordered table-responsive" id="departmentsTable" >
            <thead>
                <tr>

                    <th>Department</th>
                    <th>Name</th>
                    <th>Added By</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
                @foreach ($folders as $folder)
                <tr>

                    <td>{{ $folder->name }}</td>
                    <td>{{ $folder->department->name }}</td>
                    <td>{{ $folder->user->name }}</td>
                    <td>
                        <a class="btn btn-info btn-sm">Edit</a>
                        <a  class="btn btn-danger btn-sm">Delete</a>
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>





</div>


<!-- Modal with Folder Creation Form and Department Select -->
<div class="modal fade" id="addFolderModal" tabindex="-1" aria-labelledby="addFolderModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addFolderModalLabel">Add Folder</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('folders.create') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Folder Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="department_id" class="form-label">Department</label>
                        <select class="form-select" id="department_id" name="department_id" required>
                            <option value="" selected disabled>Select Department</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}">{{ $department->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Create Folder</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>



<script type="text/javascript">
    $(document).ready(function(){

        $('#departmentsTable').DataTable();

    });
</script>







@endsection
