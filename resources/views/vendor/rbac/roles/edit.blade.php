@extends('layouts.layout')
@section('title', __('rbac::roles.edit_role'))
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">

                <h2 mb-3>{!! __('rbac::roles.edit_role') !!}:
                    <a href="{{route('show_role', ['id' => $role->id])}}">{{ $role->name }}</a>
                </h2>

                <form action="{{ route('update_role', ['role' => $role->id]) }}" method="post">

                    @include('rbac::roles._fields', ['edit' => true])

                    <button class="btn btn-primary mt-3" type="submit">{!! __('rbac::main.edit') !!}</button>

                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                </form>

            </div>
        </div>
</div>

@stop
