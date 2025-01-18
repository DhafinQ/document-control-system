@extends('layout.master')

@section('content')
<div class="container">
    <h4>Edit Profile</h4>
    <div class="card">
        <div class="card-body">
            <form action="/user/profile-information" method="POST">
                @csrf
                @method('PUT')

                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" required>
                </div>

                <button type="submit" class="btn btn-success">
                    <i class="ti ti-save"></i> Save Changes
                </button>
            </form>
        </div>
    </div>
</div>
<div class="card mt-4">
    <div class="card-header">
        <h5>Change Password</h5>
    </div>
    <div class="card-body">
        <form action="/user/password" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="current_password" class="form-label">Current Password</label>
                <input type="password" id="current_password" name="current_password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">New Password</label>
                <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="password_confirmation" class="form-label">Confirm New Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-danger">
                <i class="ti ti-key"></i> Update Password
            </button>
        </form>
    </div>
</div>
@endsection
