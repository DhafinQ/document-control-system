@extends($rbacLayout)

@section('title', __('rbac::users.create_user'))

@section('content')
    <section class="content container-fluid">
        <div class="row">
            <div class="col-md-8 offset-md-2">

                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{ __('rbac::users.create_user') }}</h3>
                    </div>

                    <div class="card-body">
                        <form action="{{ route('store_user') }}" method="POST">
                            @csrf

                            {{-- Name --}}
                            <div class="form-group">
                                <label for="name">{{ __('Name') }}</label>
                                <input type="text" name="name" id="name" class="form-control" placeholder="{{ __('Enter name') }}" required>
                            </div>

                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email">{{ __('Email') }}</label>
                                <input type="email" name="email" id="email" class="form-control" placeholder="{{ __('Enter email') }}" required>
                            </div>

                            {{-- Password --}}
                            <div class="form-group">
                                <label for="password">{{ __('Password') }}</label>
                                <input type="password" name="password" id="password" class="form-control" placeholder="{{ __('Enter password') }}" required>
                            </div>

                            {{-- Role --}}
                            <div class="form-group">
                                <label for="role">{{ __('Role') }}</label>
                                <select name="role" id="role" class="form-control" required>
                                    <option value="" disabled selected>{{ __('Select role') }}</option>
                                    @foreach ($roles as $role)
                                        <option value="{{ $role->id }}">{{ $role->name }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <button type="submit" class="btn btn-primary">{{ __('Create User') }}</button>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection
