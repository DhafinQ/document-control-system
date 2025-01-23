@extends('layouts.layout')

@section('title', __('rbac::users.create_user'))

@section('content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h2 class="fw-semibold mb-4">Create User</h2>
                <form>
                    <div class="mb-3">
                        <label for="exampleInputName1" class="form-label">Name</label>
                        <input type="name" class="form-control" id="exampleInputName1" aria-describedby="nameHelp"
                            placeholder="Enter name">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputEmail1" class="form-label">Email</label>
                        <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp"
                            placeholder="Enter email">
                    </div>
                    <div class="mb-3">
                        <label for="exampleInputPassword1" class="form-label">Password</label>
                        <input type="password" class="form-control" id="exampleInputPassword1"
                            placeholder="Enter password">
                    </div>
                    <div class="mb-3">
                    <label class="form-label">Role</label>
                        <select class="form-select">
                            <option value="">One</option>
                            <option value="">Two</option>
                            <option value="">Three</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection