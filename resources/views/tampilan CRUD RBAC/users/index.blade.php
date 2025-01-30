@extends('layouts.layout')

@section('title', __('rbac::users.users'))

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <a href="" class="btn btn-success mb-3">Create user</a>
            <div class="table-responsive">
                <h2 class="mb-3">Users</h2>
                <table id="myTable" class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Roles</th>
                            <th>Created</th>
                            <th>Actions</th>
                            <th>Deleted</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>data</td>
                            <td>
                                <a href="" class="btn btn-primary mt-2 mb-2"><i class="ti ti-eye"></i></a>
                                <a href="" class="btn btn-success mt-2 mb-2"><i class="ti ti-edit"></i></a>
                            </td>
                            <td>data</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
