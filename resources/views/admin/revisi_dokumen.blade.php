@extends("layouts.layout")

@section("title", "Revisi Document")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fw-semibold mb-4">Revisi Dokumen</h5>
                    
                    <div class="d-flex justify-content-end mb-1">
                        <a href="/admin/update_dokumen/forms" class="btn btn-primary d-flex align-items-center">
                            <svg  xmlns="http://www.w3.org/2000/svg"  width="24"  height="24"  viewBox="0 0 24 24"  fill="none"  stroke="currentColor"  stroke-width="2"  stroke-linecap="round"  stroke-linejoin="round"  class="icon icon-tabler icons-tabler-outline icon-tabler-file-code-2"><path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M10 12h-1v5h1" /><path d="M14 12h1v5h-1" /><path d="M14 3v4a1 1 0 0 0 1 1h4" /><path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" /></svg>
                            Perbarui Dokumen 
                        </a>
                    </div>
                    
                    
                    <div class="table-responsive mt-4">
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Id</th>
                                    <th>Judul</th>
                                    <th>Kategori</th>
                                    <th>Uploader</th>
                                    <th>File Dokumen</th>
                                    <th>Revisi</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>DOC-001</td>
                                    <td>Proposal Pengembangan Aplikasi</td>
                                    <td>Teknologi</td>
                                    <td>Andika</td>
                                    <td><a href="/dokumen/DOC-001.pdf" target="_blank">Download</a></td>
                                    <td><a href="/admin/revisi_dokumen/forms" class="btn btn-sm btn-primary">Revisi</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>DOC-002</td>
                                    <td>Laporan Keuangan Q1 2025</td>
                                    <td>Keuangan</td>
                                    <td>Rian</td>
                                    <td><a href="/dokumen/DOC-002.pdf" target="_blank">Download</a></td>
                                    <td><a href="/admin/revisi_dokumen/forms" class="btn btn-sm btn-primary">Revisi</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>DOC-003</td>
                                    <td>Rencana Strategis 2025</td>
                                    <td>Manajemen</td>
                                    <td>Budi</td>
                                    <td><a href="/dokumen/DOC-003.pdf" target="_blank">Download</a></td>
                                    <td><a href="/admin/revisi_dokumen/forms" class="btn btn-sm btn-primary">Revisi</a></td>
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