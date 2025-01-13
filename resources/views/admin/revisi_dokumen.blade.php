@extends("layouts.layout")

@section("title", "Revisi Document")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fw-semibold mb-4">Revisi Dokumen</h5>
                    <div class="table-responsive mt-4">
                        <table id="example" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
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
                                    <td>Andika</td>
                                    <td>Proposal</td>
                                    <td>Admin</td>
                                    <td><a href="#">Download</a></td>
                                    <td><a href="/admin/revisi_dokumen/forms" class="btn btn-sm btn-primary">Revisi</a></td>
                                </tr>
                                <tr>
                                    <td>2</td>
                                    <td>Rian</td>
                                    <td>Report</td>
                                    <td>Admin</td>
                                    <td><a href="#">Download</a></td>
                                    <td><a href="/admin/revisi_dokumen/forms" class="btn btn-sm btn-primary">Revisi</a></td>
                                </tr>
                                <tr>
                                    <td>3</td>
                                    <td>Budi</td>
                                    <td>Laporan</td>
                                    <td>Admin</td>
                                    <td><a href="/admin/revisi_dokumen/forms">Download</a></td>
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
