@extends("layouts.layout")

@section("title", "Revisi Document")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fw-semibold mb-4">Pengesahan Dokumen</h5>


  
                <!-- Modal Revisi-->
                <div class="modal fade" id="modalTolak" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                        <h5 class="modal-title" id="staticBackdropLabel">Tolak Dokumen</h5>
                        </div>
                        <div class="modal-body">
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
                                        <option>3</option>
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
                                  <div class="col-md-6 d-flex flex-column">
                                    <label for="exampleInputEmail1" class="form-label">Lihat Dokumen</label>
                                    <a href="/dokumen/DOC-002.pdf" target="_blank">Download</a>
                                </div>                                
                                </div>
                                <div class="row mb-3 align-items-center">
                                  <div class="col-md-6">
                                    <label for="exampleInputEmail1" class="form-label">Pengunggah</label>
                                    <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                  </div>
                                
                                </div>
                                  <div class="mb-3">
                                    <label for="exampleInputEmail1" class="form-label">Alasan Penolakan</label>
                                    <textarea class="form-control" id="exampleFormControlTextarea1" rows="2"></textarea>
                                  </div>
                                </form>
                        </div>
                        <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-danger">Konfirmasi Penolakan</button>
                        </div>
                    </div>
                    </div>
                </div>

                       <!-- Modal Terima-->
                       <div class="modal fade" id="modalTerima" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                        <div class="modal-content">
                            <div class="modal-header">
                            <h5 class="modal-title" id="staticBackdropLabel">Terima Dokumen</h5>
                            </div>
                            <div class="modal-body">
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
                                            <option>3</option>
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
                                      <div class="col-md-6 d-flex flex-column">
                                        <label for="exampleInputEmail1" class="form-label">Lihat Dokumen</label>
                                        <a href="/dokumen/DOC-002.pdf" target="_blank">Download</a>
                                    </div>                                
                                    </div>
                                    <div class="row mb-3 align-items-center">
                                      <div class="col-md-6">
                                        <label for="exampleInputEmail1" class="form-label">Pengunggah</label>
                                        <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp">
                                      </div>
                                      <div class="col-md-6">
                                        <label for="exampleInputEmail1" class="form-label">Status</label>
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                              Telah diverivikasi Pengendali dokumen
                                            </label>
                                          </div>
                                          <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="flexCheckChecked" checked>
                                            <label class="form-check-label" for="flexCheckChecked">
                                              Telah diverifikasi bagian mutu
                                            </label>
                                          </div>
                                      </div>
                                    </div>
                                    </form>
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="button" class="btn btn-success">Konfirmasi Pengesahan</button>
                            </div>
                        </div>
                        </div>
                    </div>
                    
                    <div class="table-responsive mt-4">
                        
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID</th>
                                    <th>Nama</th>
                                    <th>Nomor Revisi</th>
                                    <th>Status</th>
                                    <th>Berkas</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>DOC-001</td>
                                    <td>Proposal Proyek A</td>
                                    <td>1</td>
                                    <td>Draft</td>
                                    <td><a href="/dokumen/DOC-001.pdf" target="_blank">Download</a></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTerima">
                                            Terima
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak">
                                            Revisi
                                        </button>
                                    </td>

                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>DOC-002</td>
                                    <td>Laporan Keuangan</td>
                                    <td>3</td>
                                    <td>Approved</td>
                                    <td><a href="/dokumen/DOC-002.pdf" target="_blank">Download</a></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTerima">
                                            Terima
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak">
                                          Revisi
                                      </button>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>DOC-003</td>
                                    <td>Dokumen Teknis</td>
                                    <td>2</td>
                                    <td>Pending</td>
                                    <td><a href="/dokumen/DOC-003.pdf" target="_blank">Download</a></td>
                                    <td>
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalTerima">
                                            Terima
                                        </button>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#modalTolak">
                                          Revisi
                                      </button>
                                    </td>

                                </tr>
                            </tbody>
                        </table>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection