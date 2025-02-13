@extends("layouts.layout_admin")

@section("title", "Document")

@section("content")

<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="text-2xl font-bold pb-2">
                <span>
                    <i class="ti ti-file-description"></i>
                </span>
                Daftar Dokumen
            </h2>




            <!-- Tabel Dokumen -->
            <div class="table-responsive mt-4">
                <table class="table table-striped" id="tableDocument">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengunggah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300">
                        @foreach ($documents as $document)
                        <tr>
                            <td class="px-6 py-4 text-center">{{$document->code}}</td>
                            <td class="px-6 py-4 text-center">{{$document->title}}</td>
                            <td class="px-6 py-4 text-center">{{$document->category->name}}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="badge
                                @if ($document->latestRevision->status === 'Disetujui' && $document->is_active)
                                bg-admin 
                                @elseif($document->latestRevision->status === 'Proses Revisi' || $document->latestRevision->status === 'Pengajuan Revisi')
                                    bg-warning
                                @elseif($document->latestRevision->status === 'Draft')
                                    bg-light text-dark
                                @else
                                    bg-danger
                                @endif
                                ">
                                    {{$document->latestRevision->status}}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">{{$document->uploader->name}}</td>
                            <td class="px-6 py-4 text-center">
                                <a href="{{route('documents.show',['document' => $document->id])}}" class="btn btn-admin btn-sm">Detail</a>
                            </td>
                        </tr>
                        @endforeach
                        <!-- Tambahkan baris lainnya di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@section('customJS')
    <script src="{{asset('assets/js/datatablesDocuments.js')}}"></script>
@endsection
@endsection