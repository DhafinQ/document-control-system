<div class="mb-3">
    <label for="permission_name" class="form-label">{!! __('rbac::main.name') !!}</label>
    <input id="permission_name" type="text" class="form-control @if ($errors->has('name')) is-invalid @endif"
        name="name" value="{{ old('name', isset($permission) ? $permission->name : null) }}" required autofocus>
    @if ($errors->has('name'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </div>
    @endif
</div>
<div class="mb-3">
    <label for="permission_description" class="form-label">{!! __('rbac::main.description') !!}</label>
    <input id="permission_description" type="text"
        class="form-control @if ($errors->has('description')) is-invalid @endif" name="description"
        value="{{ old('description', isset($permission) ? $permission->description : null) }}" required autofocus>
    @if ($errors->has('description'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('description') }}</strong>
        </div>
    @endif
</div>
@if ($edit)
    <div class="mb-3">
        <label for="permission_slug" class="form-label">{!! __('rbac::main.slug') !!} ({!! __('rbac::main.generated_automatically') !!})</label>
        <input id="permission_slug" type="text" class="form-control" value="{{ $permission->slug }}" disabled>
    </div>
@endif
