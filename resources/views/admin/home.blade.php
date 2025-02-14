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
              <h5 class="card-title mb-9 fw-semibold">Total Dokumen</h5>
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">{{$totalDocs}}</h4>
                    <div class="d-flex align-items-center mb-3">
                      <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                      <p class="fs-3 mb-0">last year</p>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
              <div class="card-body pt-3 p-4">
              <h5 class="card-title mb-9 fw-semibold">Dokumen Yang Disetujui</h5>
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">{{$totalApprovedDocs}}</h4>
                    <div class="d-flex align-items-center mb-3">
                      <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                      <p class="fs-3 mb-0">last year</p>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
              <div class="card-body pt-3 p-4">
              <h5 class="card-title mb-9 fw-semibold">Dokumen Yang Ditolak</h5>
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">{{$totalDeniedDocs}}</h4>
                    <div class="d-flex align-items-center mb-3">
                      <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                      <p class="fs-3 mb-0">last year</p>
                    </div>
                </div>
              </div>
            </div>
          </div>
          <div class="col-sm-6 col-xl-3">
            <div class="card overflow-hidden rounded-2">
              <div class="card-body pt-3 p-4">
              <h5 class="card-title mb-9 fw-semibold">Dokumen Yang Direvisi</h5>
                <div class="col-8">
                  <h4 class="fw-semibold mb-3">{{$totalRevisedDocs}}</h4>
                    <div class="d-flex align-items-center mb-3">
                      <span class="me-1 rounded-circle bg-light-success round-20 d-flex align-items-center justify-content-center">
                        <i class="ti ti-arrow-up-left text-success"></i>
                      </span>
                      <p class="text-dark me-1 fs-3 mb-0">+9%</p>
                      <p class="fs-3 mb-0">last year</p>
                    </div>
                </div>
              </div>
            </div>
          </div>

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
                    <tr>
                      <td>1</td>
                      <td>Tutorial Laravel</td>
                      <td>Programming</td>
                      <td>Published</td>
                      <td>Andika</td>
                      <td>2025-02-14</td>
                      <td>
                        <button>Edit</button>
                        <button>Delete</button>
                      </td>
                    </tr>
                    <tr>
                      <td>2</td>
                      <td>Introduction to AR</td>
                      <td>Technology</td>
                      <td>Draft</td>
                      <td>Andika</td>
                      <td>2025-02-13</td>
                      <td>
                        <button>Edit</button>
                        <button>Delete</button>
                      </td>
                    </tr>
                    <tr>
                      <td>3</td>
                      <td>Unity Game Development</td>
                      <td>Game Development</td>
                      <td>Published</td>
                      <td>Andika</td>
                      <td>2025-02-12</td>
                      <td>
                        <button>Edit</button>
                        <button>Delete</button>
                      </td>
                    </tr>                  
                    {{-- @foreach ($documents as $document)
                    <tr>
                        <td>{{$document->code}}</td>
                        <td>{{$document->title}}</td>
                        <td>{{$document->category->name}}</td>
                        <td>
                            @php
                                $currentStatus = ($document->currentRevision->document_id === $document->id) ? $document->latestHistory->revision->status : 'Expired'
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
                                {{ $document->latestHistory->revision->status }}
                            </span>
                        </td>
                        <td>{{$document->uploader->name}}</td>
                        <td>{{ \Carbon\Carbon::parse($document->created_at)->format('d/m/Y-H:i:s') }}</td>
                        <td>
                            @canany(['edit-documents','edit-revisions'])
                            <div class="d-flex">
                                <a href="{{ route('document_revision.show',['documentRevision' => $document->latestHistory->revision->id]) }}" class="btn btn-sm btn-admin me-1">Detail</a>
                                @if ($document->currentRevision->document_id === $document->id && ($document->latestHistory->revision->status == 'Disetujui' || $document->latestHistory->revision->status == 'Pengajuan Revisi'))
                                <a href="{{ route('document_revision.edit', $document->latestHistory->revision->id) }}" class="btn btn-sm btn-approver">Revisi</a>
                                @endif
                            </div>
                            @endcanany
                        </td>
                    </tr>
                    @endforeach --}}
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