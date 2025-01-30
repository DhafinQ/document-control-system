@extends("layouts.layout_admin")
@section('title', __('rbac::permissions.permission_details'))
@section('content')

    <div class="container-fluid">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <h2 class="mb-3">{!! __('rbac::permissions.permission_details') !!}: {{ $permission->name }}</h2>
                    <form action="{{ route('delete_permission') }}" method="post">
                        <a class="btn btn-success" href="{{ route('edit_permission', ['permission' => $permission->id]) }}"
                            title="{!! __('rbac::main.edit') !!}">{!! __('rbac::permissions.edit_permission') !!}</a>
                        <input type="submit" class="btn btn-danger" value="{!! __('rbac::permissions.delete_permission') !!}"
                            title="{!! __('rbac::main.delete') !!}" onclick="return confirm('{!! __('rbac::main.delete_confirm') !!}')">
                        <input type="hidden" value="{{ $permission->id }}" name="items[]">
                        <input type="hidden" value="{!! csrf_token() !!}" name="_token">
                    </form>


                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <tr>
                                    <th>{!! __('rbac::main.attribute') !!}</th>
                                    <th>{!! __('rbac::main.value') !!}</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>{!! __('rbac::main.name') !!}</td>
                                    <td>{{ $permission->name }}</td>
                                </tr>
                                <tr>
                                    <td>{!! __('rbac::main.slug') !!}</td>
                                    <td>{{ $permission->slug }}</td>
                                </tr>
                                <tr>
                                    <td>{!! __('rbac::main.description') !!}</td>
                                    <td>{{ $permission->description }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
