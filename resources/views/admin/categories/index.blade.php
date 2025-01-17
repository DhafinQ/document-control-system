@extends("layouts.layout")

@section("title", "Revisi Document")

@section("content")
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12">
                    <h5 class="card-title fw-semibold mb-4">Kategori Dokumen</h5>
                    <div class="d-flex justify-content-end mb-1">
                        <a href="{{ route('categories.create') }}" class="btn btn-primary d-flex align-items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon icon-tabler icons-tabler-outline icon-tabler-file-code-2">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M10 12h-1v5h1" />
                                <path d="M14 12h1v5h-1" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                            </svg>
                            Tambah Kategori Baru
                        </a>
                    </div>

                    <div class="table-responsive mt-4">
                        <table id="myTable" class="table table-striped">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Kategori</th>
                                    <th>Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($categories as $category)
                                <tr>
                                    <td>{{$category->id}}</td>
                                    <td>{{$category->name}}</td>
                                    <td>
                                        <a href="{{ route('categories.edit', $category) }}" class="btn btn-sm btn-primary">Edit</a>
                                        <form action="{{ route('categories.destroy', $category) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                                        </form>
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

@endsection

