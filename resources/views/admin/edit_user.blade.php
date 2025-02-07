@extends("layouts.layout_admin")

@section("title", "Document")

@section('content')
<div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Form Tambah User</h5>
              <div class="card">
                <div class="card-body">
                  <form>
                    <div class="mb-3">
                      <label for="exampleInputEmail1" class="form-label">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" placeholder="Masukkan Email Anda">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputName1" class="form-label">Nama</label>
                      <input type="name" class="form-control" id="exampleInputName1" aria-describedby="nameHelp" placeholder="Masukkan Nama Anda">
                    </div>
                    <div class="mb-3">
                      <label for="exampleInputPassword1" class="form-label">Password</label>
                      <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Masukkan Password Anda">
                    </div>
                    <button type="submit" class="btn btn-success">Submit</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  @endsection