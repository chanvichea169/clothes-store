@extends('admin.layouts.master')
@section('title', ' - edit_user')
@section('content')

<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('admin.user.update') }}" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="editUserId" name="id">

                    <div class="form-group">
                        <label for="editUserName">Name</label>
                        <input type="text" class="form-control" id="editUserName" name="name" required>
                    </div>

                    <div class="form-group">
                        <label for="editUserEmail">Email</label>
                        <input type="email" class="form-control" id="editUserEmail" name="email" required>
                    </div>

                    <div class="form-group">
                        <label for="editUserMobile">Phone</label>
                        <input type="text" class="form-control" id="editUserMobile" name="mobile" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function editUser(id, name, email, mobile) {
        document.getElementById('editUserId').value = id;
        document.getElementById('editUserName').value = name;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserMobile').value = mobile;
    }
</script>
@endpush
