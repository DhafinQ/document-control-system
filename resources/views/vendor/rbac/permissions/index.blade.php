@extends("layouts.layout_admin")
@section('title', __('rbac::permissions.permissions'))
@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <a class="btn btn-success mb-3" href="{{ route('create_permission') }}">{!! __('rbac::permissions.create_permission') !!}</a>
                @if ($errors->has('items'))
                <div class="alert alert-danger" role="alert">
                    {{ $errors->first('items') }}
                </div>
            @endif
            <form id="delete-form" action="{{ route('delete_permission') }}" method="POST">
                @csrf
                <div class="table-responsive">
                    <h2 class="mb-3">Permissions</h2>
                    <table id="myTable" class="table table-hover" style="width:100%">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Slug</th>
                                <th>Description</th>
                                <th>Created</th>
                                <th>Actions</th>
                                <th>
                                    <input type="checkbox" id="select-all"> Deletion
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($dataProvider->get() as $key => $permission)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>{{ $permission->id }}</td>
                                    <td>
                                        <a href="{{ route('show_permission', ['id' => $permission->id]) }}">
                                            {{ $permission->name }}
                                        </a>
                                    </td>
                                    <td>{{ $permission->slug }}</td>
                                    <td>{{ $permission->description }}</td>
                                    <td>{{ $permission->created_at }}</td>
                                    <td>
                                        <a href="{{ route('show_permission', ['id' => $permission->id]) }}"
                                            class="btn btn-primary mt-2 mb-2">
                                            <i class="ti ti-eye"></i>
                                        </a>
                                        <a href="{{ route('edit_permission', ['permission' => $permission->id]) }}"
                                            class="btn btn-success mt-2 mb-2">
                                            <i class="ti ti-edit"></i>
                                        </a>
                                    </td>
                                    <td>
                                        <input type="checkbox" name="items[]" value="{{ $permission->id }}"
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
