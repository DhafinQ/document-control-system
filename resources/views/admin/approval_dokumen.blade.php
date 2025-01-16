@extends("layouts.layout")

@section("title", "Revisi Document")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fw-semibold mb-4">Pengesahan Dokumen</h5>
                    
                    
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
                                    <td><a href="/admin/approval_dokumen/form" class="btn btn-sm btn-primary">Ubah Status</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>DOC-002</td>
                                    <td>Laporan Keuangan</td>
                                    <td>3</td>
                                    <td>Approved</td>
                                    <td><a href="/dokumen/DOC-002.pdf" target="_blank">Download</a></td>
                                    <td><a href="/admin/approval_dokumen/form" class="btn btn-sm btn-primary">Ubah Status</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>DOC-003</td>
                                    <td>Dokumen Teknis</td>
                                    <td>2</td>
                                    <td>Pending</td>
                                    <td><a href="/dokumen/DOC-003.pdf" target="_blank">Download</a></td>
                                    <td><a href="/admin/approval_dokumen/form" class="btn btn-sm btn-primary">Ubah Status</a></td>
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
