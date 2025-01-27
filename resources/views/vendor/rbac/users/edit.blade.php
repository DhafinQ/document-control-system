@extends('layouts.layout')
@section('title', __('rbac::users.assign_roles'))
@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-3">{!! __('rbac::users.assign_roles_for_user') !!}:
                <a href="{{ route('show_user', ['id' => $user->memberKey]) }}">{{ $user->memberName }}</a>
            </h2>
            <form action="{{ route('update_user', ['id' => $user->memberKey]) }}" method="post">
                @include('rbac::users._fields')
                <input type="hidden" name="_token" value="{!! csrf_token() !!}">
                <button type="submit" class="btn btn-primary mt-3">{!! __('rbac::main.edit') !!}</button>
            </form>
        </div>
    </div>
</div>
@endsection
