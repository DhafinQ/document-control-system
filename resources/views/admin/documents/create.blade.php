@extends("layouts.layout_admin")

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
          @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
        <form action="{{route('documents.store')}}" method="POST" class="space-y-6" enctype="multipart/form-data">
          @csrf
            <!-- Nomor Dokumen -->
        <div class="mb-6">
            <label for="nomor" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Nomor Dokumen<span class="text-danger">*</span></label>
            <input type="text" name="code" value="{{old('code')}}" class="form-control" id="nomor" placeholder="Nomor Dokumen" required />
          </div>

            <!-- Judul -->
          <div class="mb-6">
            <label for="judul" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Judul<span class="text-danger">*</span></label>
            <input type="text" name="title" value="{{old('title')}}" class="form-control" id="title" placeholder="Judul Dokumen" required />
          </div>

          <!-- Kategori -->
          <div class="mb-6">
            <label for="category" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Kategori<span class="text-danger">*</span></label>
            <select id="category" name="category_id" class="form-control" required>
              <option value="">-- Pilih --</option>
              @foreach($categories as $id => $name)
                  <option value="{{ $id }}" @if (old('category_id') == $id)
                    selected
                  @endif>{{ $name }}</option>
              @endforeach
            </select>
          </div>
          <!-- Deskripsi -->
          <div>
            <label for="description" class="block text-sm font-medium text-gray-700">Deskripsi<span class="text-danger">*</span></label>
            <textarea name="description" id="description" rows="4" class="form-control" placeholder="Deskripsi Dokumen "
              required>{{old('description')}}</textarea>
          </div>

          <!-- File -->
          <div class="mb-6">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="file_input">Upload
              file<span class="text-danger">*</span></label>
            <input class="form-control" id="file_input" type="file" name="file_path" required accept=".pdf,.doc,.docx,.txt">
            <p class="text-xs text-gray-500 dark:text-gray-400">PDF, DOC, DOCX (MAX. 5MB)</p>
          </div>

          <div class="flex justify-center">
            <a href="{{route('document_revision.index')}}" class="btn btn-danger m-1">
              Batal
            </a>
            <button type="submit" class="btn btn-admin m-1">
              Simpan
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection