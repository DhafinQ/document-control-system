@extends("layouts.layout_admin")

@section("title", "Revisi Document")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fw-semibold mb-4">Revisi Dokumen</h5>
                    
                    <div class="d-flex justify-content-end mb-1">
                        <a href="/admin/update_dokumen/forms" class="btn btn-admin d-flex align-items-center">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-code-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h-1v5h1" /><path d="M14 12h1v5h-1" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                            Perbarui Dokumen 
                        </a>
                        <a href="#" class="btn btn-admin d-flex align-items-center ms-2">
                            Download
                        </a>
                    </div>
                    <div class="table-responsive mt-4">
                        <table class="table table-borderless">
                            <tbody>
                                <tr>
                                    <th scope="row">No</th>
                                    <td>1</td>
                                </tr>
                                <tr>
                                    <th scope="row">ID Dokumen</th>
                                    <td>DOC-001</td>
                                </tr>
                                <tr>
                                    <th scope="row">Judul</th>
                                    <td>Proposal Pengembangan Aplikasi</td>
                                </tr>
                                <tr>
                                    <th scope="row">Kategori</th>
                                    <td>Teknologi</td>
                                </tr>
                                <tr>
                                    <th scope="row">Pembuat</th>
                                    <td>Andika</td>
                                </tr>
                                <tr>
                                    <th scope="row">Status</th>
                                    <td class="badge bg-admin">Diperbarui</td>
                                </tr>
                                <tr>
                                    <th scope="row">Deskripsi</th>
                                    <td></td>
                                </tr>
                                <tr>
                                    <th scope="row">Alasan</th>
                                    <td></td>
                                </tr>                                  
                            </tbody>
                        </table>
                </div>

                    <h5 class="card-title fw-semibold mt-5 mb-4">Riwayat Revisi</h5>
                    <div class="table-responsive">
                        <table id="revisionTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>ID Dokumen</th>
                                    <th>Judul</th>
                                    <th>Pengunggah</th>
                                    <th>Tanggal Revisi</th>
                                    <th>Keterangan</th>
                                    <th>File Dokumen</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>DOC-001</td>
                                    <td>Proposal Pengembangan Aplikasi</td>
                                    <td>Andika</td>
                                    <td>25 Januari 2025</td>
                                    <td>Update Isi Bab 3</td>
                                    <td>
                                        <a href="#" class="btn btn-admin btn-sm">Download</a> 
                                        <a href="#" class="btn btn-approver btn-sm ms-2">Lihat</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>DOC-002</td>
                                    <td>Laporan Keuangan Q1 2025</td>
                                    <td>Rian</td>
                                    <td>20 Januari 2025</td>
                                    <td>Perbaikan Angka Laba Rugi</td>
                                    <td>
                                        <a href="#" class="btn btn-admin btn-sm">Download</a> 
                                        <a href="#" class="btn btn-approver btn-sm ms-2">Lihat</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>DOC-003</td>
                                    <td>Rencana Strategis 2025</td>
                                    <td>Budi</td>
                                    <td>18 Januari 2025</td>
                                    <td>Penyesuaian Target Tahunan</td>
                                    <td>
                                        <a href="#" class="btn btn-admin btn-sm">Download</a> 
                                        <a href="#" class="btn btn-approver btn-sm ms-2">Lihat</a>
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