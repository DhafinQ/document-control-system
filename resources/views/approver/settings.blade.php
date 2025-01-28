@extends("layouts.layout_approver")

@section("title", "Document")

@section("content")

<div class="container-fluid">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-plus">
<path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" /><path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
          </svg> Settings </h5>
        <form action="#" method="POST" class="space-y-6">

            <!-- Nama -->
        <div class="mb-6">
            <label for="nomor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nama User</label>
            <input type="text" class="form-control" id="nomor" placeholder="Nomor Dokumen" required />
          </div>

            <!-- Username -->
          <div class="mb-6">
            <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Username</label>
            <input type="text" class="form-control" id="title" placeholder="Judul Dokumen" required />
          </div>

            <!-- Role -->
          <div class="mb-6 mt-3">
            <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Role Anda Saat Ini</label>
            <input type="text" class="form-control" id="password" placeholder="Role Anda Saat Ini" required />
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection