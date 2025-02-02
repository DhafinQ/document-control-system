@extends("layouts.layout_admin")

@section("title", "Profile")

@section('content')
<div class="container pt-4">
    <h4>Profile</h4>
    <div class="card">
        <div class="card-body">
            <p><strong>Name:</strong> {{ $user->name }}</p>
            <p><strong>Email:</strong> {{ $user->email }}</p>
            <p><strong>Role:</strong> {{ $roles }}</p>
            <a href="{{ route('profile.edit') }}" class="btn btn-admin">
                <i class="ti ti-edit"></i> Edit Profile
            </a>
        </div>
    </div>
</div>
@endsection
