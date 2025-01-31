@extends('layouts.layout')

@section('title', __('rbac::users.assign_roles'))

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-3">{!! __('rbac::users.assign_roles_for_user') !!}: <a
                    href="{{route('show_user', ['id' => $user->memberKey])}}">{{ $user->memberName }}</a></h2>
            <h5>Roles:</h5>        
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    staff
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                <label class="form-check-label" for="flexCheckDefault">
                    reviewer
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked disabled>
                <label class="form-check-label" for="flexCheckChecked">
                    Checked checkbox
                </label>
            </div>
            <button type="submit" class="btn btn-primary mt-3">Edit</button>
        </div>
    </div>
</div>
@endsection