@extends("layouts.layout")

@section("title", "Document")

@section("content")

<div class="container-fluid">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-plus">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
            <path d="M12 11l0 6" />
            <path d="M9 14l6 0" />
          </svg> Tambah Dokumen Baru</h5>
        <form action="#" method="POST" class="space-y-6">

            <!-- Nomor Dokumen -->
        <div class="mb-6">
            <label for="nomor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Noomor Dokumen</label>
            <input type="text" class="form-control" id="nomor" placeholder="Nomor Dokumen" required />
          </div>

            <!-- Judul -->
          <div class="mb-6">
            <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul</label>
            <input type="text" class="form-control" id="title" placeholder="Judul Dokumen" required />
          </div>

          <!-- Kategori -->
          <div class="mb-6">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori</label>
            <select id="category" name="category" class="form-control" required>
              <option value="" disabled selected>Pilih Kategori</option>
              <option value="kategori1">Kategori 1</option>
              <option value="kategori2">Kategori 2</option>
              <option value="kategori3">Kategori 3</option>
              <option value="kategori4">Kategori 4</option>
            </select>
          </div>
          <!-- Deskripsi -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Deskripsi Dokumen "
              required></textarea>
          </div>

          <!-- Role -->
          <div class="mb-6">
            <label for="role"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pengunggah</label>
            <select id="role" name="role" class="form-control" required>
              <option value="" disabled selected>Pilih </option>
              <option value="Admin">Admin</option>
              <option value="User">User</option>
            </select>
          </div>

          <!-- File -->
          <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload
              file</label>
            <input class="form-control" id="file_input" type="file" required>
            <p class="text-xs text-gray-500 dark:text-gray-400">PNG, JPG or PDF, DOC, DOCX (MAX. 5MB)</p>
          </div>

          <div class="flex justify-center">
            <a href="/manager/dokumen_aktif" class="btn btn-danger m-1">
              Batal
            </a>
            <button type="submit" class="btn btn-warning m-1">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection