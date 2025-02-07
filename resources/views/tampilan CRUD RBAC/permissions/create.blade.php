@extends('layouts.layout')

@section('title', __('rbac::permissions.create_permission'))

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="mb-3">Create permission</h2>
            <form>
                <div class="mb-3">
                    <label for="" class="form-label">Name</label>
                    <input type="name" class="form-control" id="">
                </div>
                <div class="mb-3">
                    <label for="" class="form-label">Description</label>
                    <input type="description" class="form-control" id="">
                </div>
                <button type="submit" class="btn btn-primary mt-3">Create</button>
            </form>
        </div>
    </div>
</div>
@endsection