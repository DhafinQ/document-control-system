@extends('layouts.layout')
@section('title', __('rbac::users.users'))
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a href="{{ route('create_users') }}" class="btn btn-success mb-3">Create User</a>
                @if ($errors->has('items'))
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first('items') }}
                </div>
            @endif
                <form id="delete-form" action="{{ route('delete_user') }}" method="POST">
                    @csrf
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
                                    <th>
                                        <input type="checkbox" id="select-all"> Deletion
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($dataProvider->get() as $key => $user)
                                    <tr>
                                        <td>{{ $key + 1 }}</td>
                                        <td>{{ $user->memberKey }}</td>
                                        <td>
                                            <a href="{{ route('show_user', ['id' => $user->memberKey]) }}">
                                                {{ $user->memberName }}
                                            </a>
                                        </td>
                                        <td>
                                            <ul class="list-group list-group-flush">
                                                @foreach ($user->roles as $role)
                                                    <li class="list-group-item p-2">
                                                        <a href="{{ route('show_role', ['id' => $role->id]) }}">
                                                            {{ $role->name }}
                                                        </a>
                                                    </li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td>{{ $user->created_at }}</td>
                                        <td>
                                            <a href="{{ route('show_user', ['id' => $user->memberKey]) }}"
                                                class="btn btn-primary">
                                                <i class="ti ti-eye"></i>
                                            </a>
                                            <a href="{{ route('edit_user', ['id' => $user->memberKey]) }}"
                                                class="btn btn-success">
                                                <i class="ti ti-edit"></i>
                                            </a>
                                        </td>
                                        <td>
                                            @if (Gate::allows(\Itstructure\LaRbac\Models\Permission::DELETE_MEMBER_FLAG, $user->memberKey))
                                                <input type="checkbox" name="items[]" value="{{ $user->memberKey }}"
                                                    class="form-check-input">
                                            @endif
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
