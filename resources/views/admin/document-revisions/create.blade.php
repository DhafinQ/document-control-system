@extends("layouts.layout")

@section("title", "Document")

@section("content")

      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Perbarui Dokumen</h5>

                  <form action="{{route('document_revision.store')}}" method="POST">
                    @csrf
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Judul</label>
                      <input type="text" name="title" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Kategori Dokumen</label>
                        <select class="form-control" id="exampleFormControlSelect1" name="category_id">
                          <option value="">-- Pilih --</option>
                          @foreach ($categories as $category)
                            <option value="{{$category->name}}" {{old('category_id') ? 'selected' : ''}}>{{$category->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">ID Dokumen</label>
                      <input type="text" name="code" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <label for="dokumen" class="form-label">Berkas Dokumen</label>
                      <input type="file" name="file_path" class="form-control" id="dokumen" aria-describedby="dokumenHelp" accept=".pdf,.doc,.docx,.txt">
                    </div>                    
                  </div>
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Pembaruan Dokumen</label>
                      <select id="my-select" name="rev[]" multiple="multiple" class="form-control">
                        @foreach ($approvedDocs as $doc)
                          <option value="{{$doc->id}}">{{$doc->document->title}}</option>
                          <option value="2">{{$doc->document->title}}</option>
                        @endforeach
                    </select>
                    </div>
                                    
                  </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Deskripsi</label>
                      <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Alasan</label>
                      <textarea class="form-control" name="reason" id="exampleFormControlTextarea1" rows="2"></textarea>
                    </div>
                    <div class="d-flex justify-content-center gap-2" style="width: 400px; margin: auto;">
                      <button type="button" class="btn btn-danger" onclick="history.back()">Kembali</button>
                      <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
                  
                  </form>

            </div>
          </div>
        </div>
      </div>
    </div>
@endsection