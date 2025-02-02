@extends('layouts.layout_admin')

@section('title', 'Revisi Document')

@section('content')
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        <h5 class="card-title fw-semibold mb-4">Pengesahan Dokumen</h5>

                        <div class="table-responsive mt-4">

                            <table id="myTable" class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Nama</th>
                                        <th>Menggantikan Dokumen</th>
                                        <th>Status</th>
                                        <th>Berkas</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($revisions as $rev)
                                        <tr>
                                            <td>{{ $rev->document->code }}</td>
                                            <td>{{ $rev->document->title }}</td>
                                            <td>
                                                <ul class="list-group">
                                                    @foreach ($rev->revisedDocument() as $doc)
                                                        <li class="list-group-item">
                                                            <a href="{{route('document_revision.show-file', ['filename' => $doc->currentRevision->file_path])}}" target="blank">{{$doc->title}}</a>
                                                        </li>
                                                    @endforeach
                                                    @if (count($rev->revisedDocument()) == 0)
                                                        <li class="list-group-item">-</li>
                                                    @endif
                                                </ul>
                                            </td>
                                            <td>
                                                <span class="badge
                                                    @if ($rev->status === 'Disetujui')
                                                        bg-admin 
                                                    @else
                                                        bg-light text-dark
                                                    @endif
                                                ">
                                                    {{ $rev->status }}
                                                </span>
                                            </td>
                                            <td><a href="{{ route('document_revision.show-file', ['filename' => $rev->file_path]) }}"
                                                    target="_blank">Lihat File</a></td>
                                            @can('edit-approval')
                                                @if (($roles->contains('administrator') && $rev->acc_format && $rev->acc_content) || ($roles->contains('bagian-mutu') && $rev->acc_content) || ($roles->contains('pengendali-dokumen') && $rev->acc_format) || $rev->status === 'Disetujui')
                                                <td>
                                                    <button type="button" id="btn-modalTerima" class="btn btn-secondary btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#modalTerima"
                                                        data-id="{{ $rev->id }}">
                                                        Detail
                                                    </button>
                                                </td>
                                                @else
                                                <td>
                                                    <button type="button" id="btn-modalTerima" class="btn btn-admin btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#modalTerima"
                                                        data-id="{{ $rev->id }}">
                                                        Terima
                                                    </button>
                                                    <button type="button" id="btn-modalTolak" class="btn btn-approver btn-sm"
                                                        data-bs-toggle="modal" data-bs-target="#modalTolak"
                                                        data-id="{{ $rev->id }}">
                                                        Revisi
                                                    </button>
                                                </td>
                                                @endif
                                            @endcan
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            <!-- Modal Revisi-->
                            <div class="modal fade" id="modalTolak" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Tolak Dokumen</h5>
                                        </div>
                                        <div class="modal-body px-4">
                                            <form id="formTolak" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <input type="hidden" name="status" value="Pengajuan Revisi">
                                                <div class="row mb-3 align-items-center">
                                                    <div class="col-md-6">
                                                        <label for="exampleInputEmail1" class="form-label">Judul</label>
                                                        <input type="text" id="rev_judul_doc" disabled
                                                            class="form-control" aria-describedby="emailHelp">
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="exampleInputEmail1" class="form-label">ID
                                                            Dokumen</label>
                                                        <input type="text" class="form-control" id="rev_code_doc"
                                                            disabled aria-describedby="emailHelp">
                                                    </div>

                                                    <div class="col-md-12 mt-2">
                                                        <div class="form-group">
                                                            <label for="exampleInputEmail1" class="form-label">Kategori
                                                                Dokumen</label>
                                                            <select class="form-control" id="rev_category_doc" disabled>
                                                                @foreach ($categories as $category)
                                                                    <option>{{ $category->name }}</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>

                                                    <div class="row mb-3 align-items-center mt-2">

                                                        <div class="col-md-6">
                                                            <label for="exampleInputEmail1"
                                                                class="form-label">Pengunggah</label>
                                                            <input type="text" class="form-control" id="rev_uploader_doc"
                                                                disabled aria-describedby="emailHelp">
                                                        </div>
                                                        <div class="col-md-6 d-flex flex-column">
                                                            <label for="exampleInputEmail1" class="form-label">Berkas
                                                                Dokumen</label>
                                                            <a href="/dokumen/DOC-002.pdf" id="rev_url_doc"
                                                                target="_blank">Download</a>
                                                        </div>
                                                    </div>


                                                </div>
                                                <div class="mb-3">
                                                    <label for="exampleInputEmail1" class="form-label">Alasan
                                                        Penolakan<span class="text-danger">*</span></label>
                                                    <textarea class="form-control" name="reason" rows="2" required></textarea>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-danger">Konfirmasi Penolakan</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Modal Terima-->
                            <div class="modal fade" id="modalTerima" data-bs-backdrop="static" data-bs-keyboard="false"
                                tabindex="-1" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="staticBackdropLabel">Terima Dokumen</h5>
                                        </div>
                                        <div class="modal-body">
                                            <form id="formTerima" method="POST">
                                                @csrf
                                                @method('PUT')
                                                @if (auth()->user()->isRole('Kepala-Puskesmas'))
                                                    <input type="hidden" name="status" value="Disetujui">
                                                @else
                                                    <input type="hidden" name="status" value="Draft">
                                                @endif
                                                <div class="row mb-3 align-items-center">
                                                    <div class="col-md-6">
                                                        <label for="exampleInputEmail1" class="form-label">Judul</label>
                                                        <input type="text" class="form-control"
                                                            aria-describedby="emailHelp" id="acc_judul_doc" disabled>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <label for="exampleInputEmail1" class="form-label">ID
                                                            Dokumen</label>
                                                        <input type="text" class="form-control"
                                                            aria-describedby="emailHelp" id="acc_code_doc" disabled>
                                                    </div>

                                                </div>
                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="exampleInputEmail1" class="form-label">Kategori
                                                            Dokumen</label>
                                                        <select class="form-control" id="acc_category_doc" disabled>
                                                            @foreach ($categories as $category)
                                                                <option>{{ $category->name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 align-items-center mt-2">
                                                    <div class="col-md-6">
                                                        <label for="exampleInputEmail1"
                                                            class="form-label">Pengunggah</label>
                                                        <input type="text" class="form-control" id="acc_uplodeder_doc"
                                                            disabled aria-describedby="emailHelp">
                                                    </div>
                                                    <div class="col-md-6 d-flex flex-column">
                                                        <label for="exampleInputEmail1" class="form-label">Berkas
                                                            Dokumen</label>
                                                        <a href="/dokumen/DOC-002.pdf" id="acc_url_doc"
                                                            target="_blank">Download</a>
                                                    </div>
                                                </div>
                                                <div id="reason_container" class="row mb-3 align-items-center" style="display: none;">
                                                    <div class="col-md-12">
                                                        <label for="exampleInputEmail1" class="form-label">Alasan Revisi</label>
                                                        <textarea id="acc_reason" class="form-control" disabled></textarea>
                                                    </div>
                                                </div>
                                                <div class="row mb-3 align-items-center">
                                                    <div class="col-md-12">
                                                        <label for="exampleInputEmail1" class="form-label">Status
                                                            @if (auth()->user()->isRole('administrator'))
                                                                <span class="text-danger">*</span>
                                                            @endif
                                                        </label>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="1" id="acc_status1_doc" name="acc_format"
                                                                {{ auth()->user()->isRole('administrator') ? '' : 'disabled' }}>
                                                            <label class="form-check-label" for="flexCheckDefault">
                                                                Telah diverivikasi Pengendali dokumen
                                                            </label>
                                                        </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="checkbox"
                                                                value="1" id="acc_status2_doc" name="acc_content"
                                                                {{ auth()->user()->isRole('administrator') ? '' : 'disabled' }}
                                                                >
                                                            <label class="form-check-label" for="flexCheckChecked">
                                                                Telah diverifikasi bagian mutu
                                                            </label>
                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Batal</button>
                                            <button type="submit" class="btn btn-success" id="acc-btn">Konfirmasi Pengesahan</button>
                                        </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@section('customJS')
    <script>
        $(document).on('click', '#btn-modalTerima', function() {
            let id = $(this).data('id'); // get the data attribute value from the button
            let status = $(this).data('status'); // get the data attribute value from the button
            fetchDocumentData(id); // fetch data based on the id
        });

        $(document).on('click', '#btn-modalTolak', function() {
            let id = $(this).data('id'); // get the data attribute value from the button
            let status = $(this).data('status'); // get the data attribute value from the button
            fetchDocumentData(id); // fetch data based on the id
        });

        function fetchDocumentData(id) {
            $.ajax({
                url: '/document_revision/data/', // replace with your endpoint
                type: 'GET', // or 'POST', depending on your backend logic
                data: {
                    id: id
                },
                success: function(response) {
                    populateModal(response.data); // assume the server sends back a response with 'data'
                },
                error: function(xhr) {
                    console.error('Error fetching document data:', xhr);
                }
            });
        }

        function populateModal(data) {
            $('#reason_container').css('display','none');
            $('#acc_judul_doc').val(data.judul);
            $('#acc_code_doc').val(data.code);
            $('#acc_category_doc').val(data.category);
            $('#acc_uplodeder_doc').val(data.uploader);
            $('#acc_url_doc').attr('href', data.url);
            $('#acc_status1_doc').prop('checked', data.acc_format);
            $('#acc_status2_doc').prop('checked', data.acc_content);

            if(data.reason != ''){
                $('#reason_container').css('display','block');
                $('#acc_reason').val(data.reason);
            }

            $('#rev_judul_doc').val(data.judul);
            $('#rev_code_doc').val(data.code);
            $('#rev_category_doc').val(data.category);
            $('#rev_uploader_doc').val(data.uploader);
            $('#rev_url_doc').attr('href', data.url);

            if (data.status === 'Disetujui' || 
                (data.roles.includes("administrator") && data.acc_format && data.acc_content) || 
                (data.roles.includes("bagian-mutu") && data.acc_content) || 
                (data.roles.includes("pengendali-dokumen") && data.acc_format)) {
                
                $('#acc-btn').css('display', 'none');
                $('#acc_status1_doc').prop('disabled', true);
                $('#acc_status2_doc').prop('disabled', true);
            } else {
                $('#acc-btn').css('display', 'block');
            }   

            $('#formTolak').attr('action', '{{ url('/document_approval/') }}' + '/' + data.id);
            $('#formTerima').attr('action', '{{ url('/document_approval/') }}' + '/' + data.id);
        }
    </script>
@endsection
@endsection
