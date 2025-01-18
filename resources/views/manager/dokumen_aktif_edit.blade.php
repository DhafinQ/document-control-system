@extends("layouts.layout")

@section("title", "Document")

@section("content")

<div class="container-fluid">
  <div class="container-fluid">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title fw-semibold mb-4"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-settings">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 14m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
            <path d="M12 10.5v1.5" />
            <path d="M12 16v1.5" />
            <path d="M15.031 12.25l-1.299 .75" />
            <path d="M10.268 15l-1.3 .75" />
            <path d="M15 15.803l-1.285 -.773" />
            <path d="M10.285 12.97l-1.285 -.773" />
            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
          </svg> Edit Dokumen</h5>
        <form action="#" method="POST" class="space-y-6">
          <div>

            <!-- Judul -->
            <label for="title" class="block text-sm font-medium text-gray-700">Judul</label>
            <input type="text" name="title" id="title" class="form-control" value="Dokumen 1" required>
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

          <!-- Deksripsi -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi</label>
            <textarea name="description" id="description" rows="4" class="form-control"
              required>Deskripsi dokumen 1</textarea>
          </div>

          <!-- Role -->
          <div class="mb-6">
            <label for="category"
              class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Pengunggah</label>
            <select id="category" name="category" class="form-control" required>
              <option value="" disabled selected>Pilih </option>
              <option value="Admin">Admin</option>
              <option value="User">User</option>
            </select>
          </div>


          <!-- File Baru -->
          <div>
            <label for="file" class="block text-sm font-medium text-gray-700">File Baru (Opsional)</label>
            <input type="file" name="file" id="file" class="form-control">
            <p class="mt-2 text-sm text-gray-500">File saat ini: document1.pdf</p>
          </div>

          <div class="flex justify-center">
            <a href="/manager/dokumen_aktif" class="btn btn-danger m-1">
              Batal
            </a>
            <button type="submit" class="btn btn-admin m-1">
              Simpan Perubahan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@endsection