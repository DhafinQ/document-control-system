@extends("layouts.layout")

@section("title", "Document")

@section("content")

<div class="container-fluid">
<div class="container-fluid">
    <div class="card">
    <div class="card-body">
        <h5 class="card-title fw-semibold mb-4">
            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-plus me-2">
                <path stroke="none" d="M0 0h24v24H0z" fill="none"/>
                <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                <path d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                <path d="M16 5l3 3" />
            </svg> 
            Add Role
        </h5>
        <form action="#" method="POST" class="space-y-6">
        <div class="mb-6">
            <label for="role" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role Name</label>
            <input type="text" class="form-control" id="role" placeholder="Role Name" required />
        </div>
        <div class="flex justify-center">
            <a href="/admin/roles" class="btn btn-danger m-1">
            Cancel
            </a>
            <button type="submit" class="btn btn-admin m-1">
            Submit
            </button>
        </div>
        </form>
    </div>
    </div>
</div>
</div>

@endsection