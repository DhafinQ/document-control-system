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
                            <span class="fs-2"><button type="button" class="btn btn-admin m-1">Settings</button></span>
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
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    
@endsection