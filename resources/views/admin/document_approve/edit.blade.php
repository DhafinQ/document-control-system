@extends("layouts.layout_admin")

@section("title", "Document")

@section("content")

      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Dokumen Approval</h5>
              @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
                  <form action="{{ route('document_approval.update', ['documentRevision' => $documentRevision->id]) }}" method="POST">
                    @csrf
                    @method('PUT')
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Judul</label>
                      <input type="text" name="title" readonly value="{{old('title') ?? $documentRevision->document->title}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Kategori Dokumen</label>
                        <select class="form-control" id="exampleFormControlSelect1" disabled name="category_id">
                          <option value="">-- Pilih --</option>
                          @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{ old('category_id', $documentRevision->document->category_id) == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">ID Dokumen</label>
                      <input type="text" name="code" value="{{old('code') ?? $documentRevision->document->code}}" readonly class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <label for="dokumen" class="form-label">Berkas Dokumen</label>
                      <br>
                      <a class="btn btn-light text-dark" href="{{route('document_revision.show-file',['filename' => $documentRevision->file_path])}}" target="_blank">Lihat Dokumen</a>
                    </div>                    
                  </div>
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Pengunggah</label>
                      <input type="text" value="{{$documentRevision->reviser->name}}" readonly class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Status<span class="text-danger">*</span></label>
                      <div class="dropdown">
                        <div id="additional-input-container"></div>
                        <a class="btn btn-admin dropdown-toggle" href="#" role="button" id="dropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                          Ubah Status
                        </a>
                    
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                          <li><a class="dropdown-item" href="#">Disetujui</a></li>
                          <li><a class="dropdown-item" href="#">Ditolak</a></li>
                        </ul>
                      </div>
                    </div>
                  </div>
                  <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Deskripsi</label>
                      <textarea class="form-control" name="description" readonly id="exampleFormControlTextarea1" rows="2">{{old('description', $documentRevision->description)}}</textarea>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Alasan Approval<span class="text-danger">*</span></label>
                      <textarea class="form-control" name="reason" id="exampleFormControlTextarea1" rows="2"></textarea>
                    </div>
                    <div class="d-flex justify-content-center gap-2" style="width: 400px; margin: auto;">
                      <button type="button" class="btn btn-danger" onclick="history.back()">Kembali</button>
                      <button type="submit" class="btn btn-admin">Submit</button>
                  </div>
                  </form>

            </div>
          </div>
        </div>
      </div>
    </div>

    @section('customJS')
    <script>
      // Menangani perubahan teks ketika dropdown item dipilih
      $(document).ready(function() {
          $('.dropdown-item').on('click', function() {
              var selectedText = $(this).text(); // Ambil teks item yang dipilih
              $('#dropdownMenuLink').text(selectedText); // Ubah teks link dropdown

              $('#additional-input-container').empty();

              if (selectedText === 'Disetujui') {
                  $('#additional-input-container').append(`
                      <input type="hidden" name="status" value="Disetujui">
                  `);
              } else if (selectedText === 'Ditolak') {
                  $('#additional-input-container').append(`
                      <input type="hidden" name="status" value="Ditolak">
                  `);
              }
          });
      });

      

  </script>
    @endsection
  
@endsection