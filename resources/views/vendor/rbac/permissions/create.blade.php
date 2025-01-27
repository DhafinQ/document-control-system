@extends('layouts.layout')
@section('title', __('rbac::permissions.create_permission'))
@section('content')

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
                <h2 class="mb-3">{!! __('rbac::permissions.create_permission') !!}</h2>

                <form action="{{ route('store_permission') }}" method="post">

                    @include('rbac::permissions._fields', ['edit' => false])

                    <button class="btn btn-primary mt-3" type="submit">{!! __('rbac::main.create') !!}</button>

                    <input type="hidden" value="{!! csrf_token() !!}" name="_token">

                </form>

            </div>
        </div>
    </div>

@stop
