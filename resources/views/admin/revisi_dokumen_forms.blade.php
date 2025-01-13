@extends("layouts.layout")

@section("title", "Document")

@section("content")

      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Forms</h5>

                  <form>
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Judul</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <div class="form-group">
                        <label for="exampleInputEmail1" class="form-label">Kategori Dokumen</label>
                        <select class="form-control" id="exampleFormControlSelect1">
                          <option>1</option>
                          <option>2</option>
                          <option>3</option>
                          <option>4</option>
                          <option>5</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Pengunggah</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <label for="dokumen" class="form-label">Dokumen</label>
                      <input type="file" class="form-control" id="dokumen" aria-describedby="dokumenHelp" accept=".pdf,.doc,.docx,.txt">
                    </div>                    
                  </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Deskripsi</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Alasan</label>
                      <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                    </div>
                    <div class="mx-auto" style="width: 200px;">
                      <a href="/admin/revisi_dokumen">
                         <!-- Ganti menjadi sumbit disini -->
                      <button type="sumbit" class="btn btn-primary">Submit</button>
                      </a>
                    </div>
                  </form>

            </div>
          </div>
        </div>
      </div>
    </div>
@endsection