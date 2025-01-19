@extends("layouts.layout")

@section("title", "Revisi Document")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <div class="d-flex justify-content-between mb-1">
                    <h4 class="card-title fw-semibold mb-3">Semua Notifikasi</h4>
                        <a href="/#" class="btn btn-primary d-flex align-items-center">
                            Tandai semua telah dibaca
                        </a>
                    </div>

                    <div class="table-responsive mt-4">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Message</th>
                                    <th>Created</th>
                                    <th>Readed</th>
                                </tr>
                            </thead>
                            <!-- Isi notifikasi -->
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

