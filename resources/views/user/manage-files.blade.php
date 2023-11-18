@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">
    {{-- <div class="container"> --}}

        <button type="button" class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#uploadFileModal">
            Upload File
        </button>



        <table class="table table-bordered table-responsive" id="filesTable" >
            <thead>
                <tr>

                    <th>File Name</th>
                    <th>Uploaded By</th>
                    <th>Access Type</th>
                    <th>Status</th>
                    <th>Action</th>

                </tr>
            </thead>
            <tbody>
               @foreach ($files as $file)
                    <tr>

                        <td>{{ $file->name }} @if($file->is_locked)<span class="alert-danger">Locked</span>@endif</td>
                        <td>{{ $file->user->name }}</td>
                        <td>@if($file->type=='open')Public @else Private @endif</td>
                        <td>
                            @if ($file->status == 'active')
                            <span class="badge bg-success">Active</span>
                            @else
                            <span class="badge bg-danger">Inactive</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('secretary.files.download', $file->id) }}" class="btn btn-success btn-sm">
                               Download
                            </a>
                            <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editFileModal{{ $file->id }}">
                                Edit
                            </a>
                            <a  class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFileModal{{ $file->id }}">
                                Delete
                            </a>
                        </td>
                    <tr/>

                    <div class="modal fade" id="editFileModal{{ $file->id }}" tabindex="-1" aria-labelledby="editFileModalLabel{{ $file->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editFileModalLabel{{ $file->id }}">Edit File Title</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <form method="POST" action="{{ route('users.files.update', $file->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <label for="new_title" class="form-label">New Title</label>
                                            <input type="text" class="form-control" id="new_title" name="new_title" value="{{ $file->name }}" required>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Save Changes</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal fade" id="deleteFileModal{{ $file->id }}" tabindex="-1" aria-labelledby="deleteFileModalLabel{{ $file->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="deleteFileModalLabel{{ $file->id }}">Delete File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to delete this file?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="{{ route('users.files.delete', $file->id) }}" class="btn btn-primary">Yes, delete</a>
                                </div>
                            </div>
                        </div>
                    </div>

                    @endforeach
            </tbody>
        </table>







<!-- Modal -->
<div class="modal fade" id="uploadFileModal" tabindex="-1" aria-labelledby="uploadFileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadFileModalLabel">Upload File</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('users.files.upload') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">File Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">Choose File</label>
                        <input type="file" class="form-control" id="file" name="file" accept=".pdf, .doc, .docx, .txt" required>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload File</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

</div>


<script type="text/javascript">
$(document).ready(function(){

    $('#filesTable').DataTable();

});
</script>


@endsection