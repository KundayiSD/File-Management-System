@extends('admin.admin_dashboard')
@section('admin')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<div class="page-content">

    <header class="page-header">
        <div class="container-fluid">
            <h2 class="no-margin-bottom">Manage Achieved Files</h2>
        </div>
    </header>



    <table class="table table-bordered table-responsive" id="achievedFilesTable">
        <thead>
            <tr>
                <th>File Name</th>
                <th>Uploaded By</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($files as $file)
                <tr>
                    <td>{{ $file->name }}</td>
                    <td>{{ $file->user->name }}</td>
                    <td>
                        @if ($file->status == 'active')
                            <span class="badge bg-success">Active</span>
                        @else
                            <span class="badge bg-danger">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#unarchiveFileModal{{ $file->id }}">
                            Unarchive File
                        </a>
                    </td>
                </tr>
                <!-- Unarchive File Confirmation Modal -->
                <div class="modal fade" id="unarchiveFileModal{{ $file->id }}" tabindex="-1" aria-labelledby="unarchiveFileModalLabel{{ $file->id }}" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="unarchiveFileModalLabel{{ $file->id }}">Unarchive File</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <p>Are you sure you want to unarchive this file?</p>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                <a href="{{ route('files.unarchive', $file->id) }}" class="btn btn-primary">Yes, Unarchive</a>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </tbody>
    </table>









</div>


<script type="text/javascript">
$(document).ready(function(){

    $('#achievedFilesTable').DataTable();

});
</script>


@endsection
