@extends("layouts.layout_admin")

@section("title", "Document")

@section("content")

      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Revisi Dokumen</h5>

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
                      <label for="exampleInputEmail1" class="form-label">ID Dokumen</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <label for="dokumen" class="form-label">Berkas Dokumen</label>
                      <input type="file" class="form-control" id="dokumen" aria-describedby="dokumenHelp" accept=".pdf,.doc,.docx,.txt">
                    </div>                    
                  </div>
                  <div class="row mb-3 align-items-center">
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Pengunggah</label>
                      <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                    </div>
                    <div class="col-md-6">
                      <label for="exampleInputEmail1" class="form-label">Pembaruan Dokumen</label>
                      <select id="my-select" name="character" multiple="multiple">
                        <option value="Peter">Peter Griffin</option>
                        <option value="Lois">Lois Griffin</option>
                        <option value="Chris">Chris Griffin</option>
                        <option value="Meg">Meg Griffin</option>
                        <option value="Stewie">Stewie Griffin</option>
                        <option value="Cleveland">Cleveland Brown</option>    
                        <option value="Joe">Joe Swanson</option>    
                        <option value="Quagmire">Glenn Quagmire</option>    
                        <option value="Evil Monkey">Evil Monkey</option>
                        <option value="Herbert">John Herbert</option>   
                    </select>
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
                    <div class="d-flex justify-content-center gap-2" style="width: 400px; margin: auto;">
                      <button type="button" class="btn btn-danger" onclick="history.back()">Kembali</button>
                      <a href="/admin/revisi_dokumen">
                          <button type="submit" class="btn btn-primary">Submit</button>
                      </a>
                  </div>
                  </form>

            </div>
          </div>
        </div>
      </div>
    </div>
@endsection