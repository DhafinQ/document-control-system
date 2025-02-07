@extends("layouts.layout_admin")

@section("title", "Document")

@section("content")

      <div class="container-fluid">
        <div class="container-fluid">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title fw-semibold mb-4">Edit Kategori Dokumen</h5>
              @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
              @endif
              <form action="{{ route('categories.update', $category) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="row mb-3">
                    <div class="col-md-12">
                        <label for="exampleInputEmail1" class="form-label">Nama Kategori<span class="text-danger">*</span></label>
                        <input type="text" class="form-control" id="exampleInputEmail1" name="name" value="{{ old('name') ?? $category->name}}" style="width: 100%;">
                    </div>
                </div>
                <div class="d-flex justify-content-center gap-2">
                    <button type="button" class="btn btn-danger" onclick="history.back()">Kembali</button>
                    <button type="submit" class="btn btn-admin">Submit</button>
                </div>
            </form>
            

            </div>
          </div>
        </div>
      </div>
    </div>
@endsection