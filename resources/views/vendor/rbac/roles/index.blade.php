@extends('layouts.layout')
@section('title', __('rbac::roles.roles'))
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a class="btn btn-success mb-3" href="{{ route('create_role') }}">{!! __('rbac::roles.create_role') !!}</a>
                @if ($errors->has('items'))
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first('items') }}
                </div>
            @endif
            <form id="delete-form" action="{{ route('delete_role') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <h2 class="mb-3">Roles</h2>
                    <table id="myTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Permission</th>
                                <th>Created</th>
                                <th>Actions</th>
                                <th>
                                    <input type="checkbox" id="select-all"> Deletion
                                </th>
                        </thead>
                        <tbody>
                            @foreach ($dataProvider->get() as $key => $role)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $role->id }}</td>
                                    <td>
                                        <a href="{{ route('show_role', ['id' => $role->id]) }}">
                                            {{ $role->name }}
                                        </a>
                                    </td>
                                    <td>{{ $role->slug }}</td>
                                    <td>{{ $role->description }}</td>
                                    <td>
                                        <ul class="list-group list-group-flush">
                                            @foreach ($role->permissions as $permission)
                                                <li class="list-group-item p-2">
                                                    <a href="{{ route('show_permission', ['id' => $permission->id]) }}">
                                                        {{ $permission->name }}
                                                    </a>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td>{{ $role->created_at }}</td>
                                    <td>
                                        <a href="{{ route('show_role', ['id' => $role->id]) }}"
                                            class="btn btn-primary ">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('edit_role', ['role' => $role->id]) }}"
                                            class="btn btn-success">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                            <input type="checkbox" name="items[]" value="{{ $role->id }}"
                                                class="form-check-input">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-danger mt-3">Delete Selected</button>
            </form>
            </div>
        </div>
    </div>
@endsection
