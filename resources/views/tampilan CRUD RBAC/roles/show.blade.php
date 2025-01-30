@extends('layouts.layout')

@section('title', __('rbac::roles.role_details'))

@section('content')
<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h2 class="mb-3">{!! __('rbac::roles.role_details') !!}: {{ $role->name }}</h2>
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
                                <td>Administrator</td>
                            </tr>
                            <tr>
                                <td>Slug</td>
                                <td>Administrator</td>
                            </tr>
                            <tr>
                                <td>Description</td>
                                <td>Administrator role</td>
                            </tr>
                            <tr>
                                <td>Permissions</td>
                                <td>
                                    <ul>
                                        <li><a href="">data</a></li>
                                        <li><a href="">data</a></li>
                                        <li><a href="">data</a></li>
                                        <li><a href="">data</a></li>
                                    </ul>
                                </td>
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