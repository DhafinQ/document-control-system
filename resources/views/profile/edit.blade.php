@extends("layouts.layout_admin")

@section("title", "Edit Profile")
@section('content')
<div class="container pt-4">
    <h4>Edit Profile</h4>

    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif

    @if ($errors->updatePassword->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->updatePassword->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if ($errors->updateProfileInformation->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->updateProfileInformation->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row mt-4">
        
        <!-- Card Change Credentials -->
        <div class="col-md-6">
            <div class="card border-top border-success border-2">

                <div class="card-header">
                    <h5>Change Profile</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user-profile-information.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label for="name" class="form-label">Name</label>
                            <input type="text" id="name" name="name" class="form-control"
                                value="{{ auth()->user()->name }}" required>
                        </div>

                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" id="email" name="email" class="form-control"
                                value="{{ auth()->user()->email }}" required>
                        </div>
                        
                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-admin">
                                <i class="ti ti-save"></i> Save Changes
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Card Change Password -->
        <div class="col-md-6">
            <div class="card border-top border-warning border-2">
                <div class="card-header">
                    <h5>Change Password</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('user-password.update') }}" method="POST">
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

                        <div class="text-center mt-3">
                            <button type="submit" class="btn btn-danger">
                                <i class="ti ti-key"></i> Update Password
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


@endsection
