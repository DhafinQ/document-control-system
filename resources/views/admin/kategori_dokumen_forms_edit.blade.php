@extends("layouts.layout")

@section("title", "Document")

@section("content")

      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Edit Kategori Dokumen</h5>

              <form>
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="exampleInputEmail1" class="form-label">Nama Kategori</label>
                        <input type="text" class="form-control" id="exampleInputEmail1" style="width: 100%;">
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-2">
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
