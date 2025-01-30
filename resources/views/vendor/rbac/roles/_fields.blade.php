<div class="mb-3">
    <label for="role_name" class="form-label">{!! __('rbac::main.name') !!}</label>
    <input id="role_name" type="text" class="form-control @if ($errors->has('name')) is-invalid @endif"
        name="name" value="{{ old('name', isset($role) ? $role->name : null) }}" required autofocus>
    @if ($errors->has('name'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('name') }}</strong>
        </div>
    @endif
</div>


<div class="mb-3">
    <label for="role_description" class="form-label">{!! __('rbac::main.description') !!}</label>
    <input id="role_description" type="text" class="form-control @if ($errors->has('description')) is-invalid @endif"
        name="description" value="{{ old('description', isset($role) ? $role->description : null) }}" required
        autofocus>
    @if ($errors->has('description'))
        <div class="invalid-feedback">
            <strong>{{ $errors->first('description') }}</strong>
        </div>
    @endif
</div>


@if ($edit)
    <div class="mb-3">
        <div class="form-group">
            <label for="role_slug" class="form-label">{!! __('rbac::main.slug') !!} ({!! __('rbac::main.generated_automatically') !!})</label>
            <input id="role_slug" type="text" class="form-control" value="{{ $role->slug }}" disabled>
        </div>
    </div>
@endif


<label for="permissions_form_group" class="form-label">{!! __('rbac::permissions.permissions') !!}</label>
<div class="row">
    <div class="col">
        @foreach ($allPermissions as $id => $name)
            <div class="form-check">
                <input class="form-check-input @if ($errors->has('permissions')) is-invalid @endif" type="checkbox"
                    name="permissions[]" value="{{ $id }}" id="permission_checkbox_{{ $id }}"
                    @if (isset($currentPermissions) && in_array($id, $currentPermissions)) checked @endif>
                <label class="form-check-label" for="permission_checkbox_{{ $id }}">
                    {{ $name }}
                </label>
            </div>
        @endforeach
        @if ($errors->has('permissions'))
            <div class="alert alert-danger px-3 py-2" role="alert">
                <strong>{{ $errors->first('permissions') }}</strong>
            </div>
        @endif
    </div>
</div>
