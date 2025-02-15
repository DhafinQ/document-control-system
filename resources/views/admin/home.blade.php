@extends("layouts.layout_admin")

@section("title", "Document")

@section("content")
      <div class="container-fluid">
        <div class="row mt-5">
          <div class="col-lg-4">
            <div class="row">
              <div class="col-lg-12">
                <div class="card overflow-hidden">
                  <div class="card-body p-4">
                    <h5 class="card-title mb-9 fw-semibold">Selamat Datang Kembali !</h5>
                    <div class="row align-items-center">
                      <div class="col-8">
                        <h4 class="fw-semibold mb-3">{{auth()->user()->name}}</h4>

                        <div class="d-flex align-items-center">
                          <div class="me-4">
                            <span class="fs-2"><a href="{{route('profile')}}" class="btn btn-admin m-1">Settings</a></span>
                          </div>
                          <div>
                            <span class="fs-2"><button type="button" class="btn btn-approver m-1" onclick="document.getElementById('logout-form').submit();">Logout</button></span>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="row mt-3">
          <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
              <div class="card-body pt-3 p-4">
              <h5 class="card-title mb-9 fw-semibold">
                <span>
                  <i class="ti ti-files"></i>
                </span>
                Total Dokumen
              </h5>
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">{{$totalDocs}}</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
              <div class="card-body pt-3 p-4">
              <h5 class="card-title mb-9 fw-semibold">
                <span class="text-success">
                  <i class="ti ti-checkbox"></i>
                </span>
                Dokumen Aktif
              </h5>
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">{{$totalApprovedDocs}}</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
              <div class="card-body pt-3 p-4">
                <h5 class="card-title mb-9 fw-semibold">
                  <span class="text-warning">
                    <i class="ti ti-clock"></i>
                  </span>
                Proses Pengajuan
              </h5>
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">{{$totalRevisedDocs}}</h4>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
              <div class="card-body pt-3 p-4">
              <h5 class="card-title mb-9 fw-semibold">
                <span class="text-danger">
                  <i class="ti ti-x"></i>
                </span>
                Dokumen Expired
              </h5>
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">{{$totalDeniedDocs}}</h4>
                </div>
              </div>
            </div>
          </div>
          <h4>Dokumen Terbaru</h4>
          <div class="table-responsive mt-4">
            <table id="tableDocument" class="table table-striped">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Judul</th>
                        <th>Kategori</th>
                        <th>Status</th>
                        <th>Uploader</th>
                        <th>Created At</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>                 
                    @foreach ($documents as $document)
                    <tr>
                        <td>{{$document->code}}</td>
                        <td>{{$document->title}}</td>
                        <td>{{$document->category->name}}</td>
                        <td>
                            @php
                                $currentStatus = ($document->currentRevision->document_id === $document->id) ? $document->latestRevision->status : 'Expired'
                            @endphp
                            <span class="badge
                            @if ($currentStatus === 'Draft')
                                bg-light text-dark
                            @elseif ($currentStatus === 'Disetujui')
                                bg-success
                            @elseif ($currentStatus === 'Pengajuan Revisi' || $currentStatus === 'Proses Revisi')
                                bg-warning
                            @elseif ($currentStatus === 'Expired')
                                bg-danger
                            @endif
                            ">
                                {{ $document->latestRevision->status }}
                            </span>
                        </td>
                        <td>{{$document->uploader->name}}</td>
                        <td>{{ \Carbon\Carbon::parse($document->created_at)->format('d/m/Y-H:i:s') }}</td>
                        <td>
                          <div class="d-flex">
                            
                            @canany(['edit-documents','edit-revisions'])
                              @if ($document->currentRevision->checkUploaderRoles())
                                <a href="{{ route('document_revision.show',['documentRevision' => $document->currentRevision->latestRevision($document->id)->id]) }}" class="btn btn-sm btn-admin me-1">Lihat</a>
                                @if ($document->currentRevision->document_id === $document->id && ($document->latestHistory->revision->status == 'Disetujui' || $document->latestHistory->revision->status == 'Pengajuan Revisi'))
                                  <a href="{{ route('document_revision.edit', $document->latestHistory->revision->id) }}" class="btn btn-sm btn-approver">Revisi</a>
                                @endif
                              @elseif($document->is_active || $document->currentRevision->latestRevision($document->id)->status === 'Expired'))
                                <a href="{{ route('documents.show',['document' => $document->id]) }}" class="btn btn-sm btn-admin me-1">Lihat</a>
                              @endif

                            @else
                              @if ($document->is_active || $document->currentRevision->latestRevision($document->id)->status === 'Expired')
                                <a href="{{ route('documents.show',['document' => $document->id]) }}" class="btn btn-sm btn-admin me-1">Lihat</a>
                              @endif
                            @endcanany
                          </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
          </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    @section('customJS')
    <script src="{{asset('assets/js/datatablesDocuments.js')}}"></script>
    @endsection
@endsection