@extends("layouts.layout_admin")
@section('title', __('rbac::roles.create_role'))
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">

                <h2>{!! __('rbac::roles.create_role') !!}</h2>

                <form action="{{ route('store_role') }}" method="post">

                    @include('rbac::roles._fields', ['edit' => false])

                    <button class="btn btn-admin mt-3" type="submit">{!! __('rbac::main.create') !!}</button>

                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                </form>

        </div>
    </div>
</div>

@stop
