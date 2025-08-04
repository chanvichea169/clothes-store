@extends('admin.layouts.master')
@section('title', ' - edit_user')
@section('content')
<div class="main-content-inner">
    <div class="main-content-wrap">
<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.user.update', ['id' => $user->id]) }}" method="POST" id="editUserForm">
                @csrf
                @method('PUT')
                <div class="modal-header">
                    <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
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
                        <input type="text" class="form-control" id="editUserMobile" name="phone" required>
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

    </div>
</div>

@endsection

@push('scripts')
<script>
    function editUser(id, name, email, mobile) {
        // Fill in form inputs
        document.getElementById('editUserId').value = id;
        document.getElementById('editUserName').value = name;
        document.getElementById('editUserEmail').value = email;
        document.getElementById('editUserMobile').value = mobile;

        // Set the form action dynamically
        const form = document.getElementById('editUserForm');
        form.action = `/admin/users/${id}`; // This MUST match your web.php route

        // Show the modal using jQuery
        $('#editUserModal').modal('show');
    }
</script>
@endpush

