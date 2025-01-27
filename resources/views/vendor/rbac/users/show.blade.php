@extends('layouts.layout')
@section('title', __('rbac::users.user_details'))
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-3">{!! __('rbac::users.user_details') !!}: {{ $user->memberName }}</h2>
            <a href="{{ route('edit_user', ['id' => $user->memberKey]) }}" class="btn btn-success mb-3">
                {!! __('rbac::users.assign_roles') !!}
            </a>
            @can(Itstructure\LaRbac\Models\Permission::DELETE_MEMBER_FLAG, $user->memberKey)
                <form action="{{ route('delete_user') }}" method="post" style="display: inline-block;">
                    @csrf
                    <input type="hidden" value="{{ $user->memberKey }}" name="items[]">
                    <button type="submit" class="btn btn-danger mb-3"
                            onclick="return confirm('{!! __('rbac::main.delete_confirm') !!}')">
                        {!! __('rbac::users.delete_user') !!}
                    </button>
                </form>
            @endcan
            <div class="table-responsive">
                <table class="table table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>{!! __('rbac::main.attribute') !!}</th>
                            <th>{!! __('rbac::main.value') !!}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>{!! __('rbac::users.name') !!}</td>
                            <td>{{ $user->memberName }}</td>
                        </tr>
                        <tr>
                            <td>{!! __('rbac::roles.roles') !!}</td>
                            <td>
                                <ul class="list-group list-group-flush">
                                    @foreach($user->roles as $role)
                                        <li class="list-group-item p-2">
                                            <a href="{{ route('show_role', ['id' => $role->id]) }}">
                                                {{ $role->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
