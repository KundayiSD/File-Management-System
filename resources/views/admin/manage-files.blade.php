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
                            @if($file->is_locked)
                            <a  class="btn btn-success btn-sm" data-bs-toggle="modal" data-bs-target="#unlockFileModal{{ $file->id }}">
                                unlock
                            </a>
                            @else
                            <a href="#" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#archiveFileModal{{ $file->id }}">
                                Archive File
                            </a>
                            <a href="{{ route('files.download', $file->id) }}" class="btn btn-success btn-sm">
                               Download
                            </a>

                            <a href="#" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#editFileModal{{ $file->id }}">
                                Edit
                            </a>
                            {{-- lock file --}}
                            <a  class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#lockFileModal{{ $file->id }}">
                                Lock
                            </a>
                            <a  class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteFileModal{{ $file->id }}">
                                Delete
                            </a>
                            @endif
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
                                    <form method="POST" action="{{ route('files.update', $file->id) }}">
                                        @csrf
                                        @method('PATCH')
                                        <div class="mb-3">
                                            <label for="new_title" class="form-label">New Title</label>
                                            <input type="text" class="form-control" id="new_title" name="new_title" value="{{ $file->name }}" required>
                                        </div>
                                        <div class="mb-3">
                                            <label for="name" class="form-label">Select Access Type</label>
                                            <select class="form-select" id="type" name="type" required>
                                                <option @if($file->type=='open') selected @endif value="open">Public</option>
                                                <option @if($file->type=='restricted') selected @endif value="restricted">Private</option>
                                            </select>
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

                    <div class="modal fade" id="archiveFileModal{{ $file->id }}" tabindex="-1" aria-labelledby="archiveFileModalLabel{{ $file->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="archiveFileModalLabel{{ $file->id }}">Archive File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to archive this file?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="{{ route('files.archive', $file->id) }}" class="btn btn-primary">Yes, Archive</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="lockFileModal{{ $file->id }}" tabindex="-1" aria-labelledby="lockFileModalLabel{{ $file->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="unlockFileModalLabel{{ $file->id }}">Lock File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to lock this file?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="{{ route('files.lock', $file->id) }}" class="btn btn-primary">Yes, lock</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="unlockFileModal{{ $file->id }}" tabindex="-1" aria-labelledby="inlockFileModalLabel{{ $file->id }}" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="unlockFileModalLabel{{ $file->id }}">Unlock File</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <p>Are you sure you want to unlock this file?</p>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                    <a href="{{ route('files.unlock', $file->id) }}" class="btn btn-primary">Yes, unlock</a>
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
                                    <a href="{{ route('files.delete', $file->id) }}" class="btn btn-primary">Yes, delete</a>
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
                <form method="POST" action="{{ route('files.upload') }}" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Select Folder</label>
                        <select class="form-select" id="folder_id" name="folder_id" required>
                            <option value="" selected disabled>Select Folder</option>
                            @foreach ($folders as $folder)
                                <option value="{{ $folder->id }}">{{ $folder->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="name" class="form-label">Select Access Type</label>
                        <select class="form-select" id="type" name="type" required>
                            <option value="" selected disabled>Select Type</option>
                            <option value="open">Public</option>
                            <option value="restricted">Private</option>
                        </select>
                    </div>
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
