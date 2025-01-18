@extends("layouts.layout")

@section("title", "Document")

@section("content")

      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Perbarui Dokumen</h5>
              @if ($errors->any())
                  <div class="alert alert-danger">
                      <ul>
                          @foreach ($errors->all() as $error)
                              <li>{{ $error }}</li>
                          @endforeach
                      </ul>
                  </div>
              @endif
                  <form action="{{route('document_revision.store')}}" method="POST" enctype="multipart/form-data">
                    @csrf
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Judul<span class="text-danger">*</span></label>
                      <input type="text" name="title" value="{{old('title') ?? ''}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Kategori Dokumen<span class="text-danger">*</span></label>
                        <select class="form-control" id="exampleFormControlSelect1" name="category_id">
                          <option value="">-- Pilih --</option>
                          @foreach ($categories as $category)
                            <option value="{{$category->id}}" {{old('category_id') ? 'selected' : ''}}>{{$category->name}}</option>
                          @endforeach
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">ID Dokumen<span class="text-danger">*</span></label>
                      <input type="text" name="code" value="{{old('code') ?? ''}}" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <label for="dokumen" class="form-label">Berkas Dokumen<span class="text-danger">*</span></label>
                      <input type="file" name="file_path" class="form-control" id="dokumen" aria-describedby="dokumenHelp" accept=".pdf,.doc,.docx,.txt">
                    </div>                    
                  </div>
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Pembaruan Dokumen<span class="text-danger">*</span></label>
                      <select id="my-select" name="rev[]" multiple="multiple" class="form-control">
                        @foreach ($approvedDocs as $doc)
                          <option value="{{$doc->currentRevision->id}}" @if(in_array($doc->id, old('rev', []))) selected @endif>{{$doc->title}}</option>
                        @endforeach
                    </select>
                    </div>
                                    
                  </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Deskripsi<span class="text-danger">*</span></label>
                      <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="2">{{old('description') ?? ''}}</textarea>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Alasan<span class="text-danger">*</span></label>
                      <textarea class="form-control" name="reason" id="exampleFormControlTextarea1" rows="2">{{old('reason') ?? ''}}</textarea>
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