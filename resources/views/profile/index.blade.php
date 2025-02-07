@extends("layouts.layout_admin")

@section("title", "Profile")

@section('content')
<div class="container pt-4">\
    <div class="container mt-4">
        <p class="fs-5 fw-bolder">Data Pengguna</p>
        <hr class="border border-success border-2 opacity-100">
        <div class="row">
            <div class="col">
                <div class="card p-3">
                    <div class="row g-3">
                        <div class="col-md-2 text-center ms-4">
                            <img src="{{ asset('assets/images/profile/user-1.jpg') }}"class="img-fluid rounded-circle border mt-5" alt="Profile Picture">
                            <a href="{{ route('profile.edit') }}" class="btn btn-success mt-5">
                                <i class="ti ti-edit"></i> Ubah Profile
                            </a>
                            

                        </div>
                        <div class="col-md-8 ms-5">
                            <fieldset disabled>
                                <div class="mb-3">
                                  <label for="disabledTextInput" class="form-label">Nama</label>
                                  <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input" value="{{ $user->name }}">
                                </div>
                                <div class="mb-3">
                                    <label for="disabledTextInput" class="form-label">Email</label>
                                    <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input" value="{{ $user->email }}">
                                </div>
                                <div class="mb-3">
                                    <label for="disabledTextInput" class="form-label">Role</label>
                                    <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input" value="{{ $roles }}">
                                </div>
                                <div class="mb-3">
                                    <label for="disabledTextInput" class="form-label">Password</label>
                                    <input type="text" id="disabledTextInput" class="form-control" placeholder="Disabled input" value="**********">
                                </div>
                                  

                             </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
        
</div>
@endsection
