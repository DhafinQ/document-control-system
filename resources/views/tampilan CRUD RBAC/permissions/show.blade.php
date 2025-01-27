@extends('layouts.layout')

@section('title', __('rbac::permissions.permission_details'))

@section('content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-3">{!! __('rbac::permissions.permission_details') !!}: {{ $permission->name }}</h2>
                <a href="" class="btn btn-success">Edit roles</a>
                <button class="btn btn-danger">Delete roles</button>
                <div class="table-responsive">
                    <table class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>Attribute</th>
                                <th>Value</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Name</td>
                                <td>Administrate</td>
                            </tr>
                            <tr>
                                <td>Slug</td>
                                <td>Administrate</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>Administrator role</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>Izin untuk mengatur sistem</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
</div>
@endsection