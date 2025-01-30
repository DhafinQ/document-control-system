@extends("layouts.layout_admin")
@section('title', __('rbac::permissions.edit_permission'))
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">

                <h2 class="mb-3">{!! __('rbac::permissions.edit_permission') !!}: <a href="{{route('show_permission', ['id' => $permission->id])}}">{{ $permission->name }}</a></h2>

                <form action="{{ route('update_permission', ['permission' => $permission->id]) }}" method="post">

                    @include('rbac::permissions._fields', ['edit' => true])

                    <button class="btn btn-admin mt-3" type="submit">{!! __('rbac::main.edit') !!}</button>

                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                </form>

            </div>
        </div>
    </div>

@stop
