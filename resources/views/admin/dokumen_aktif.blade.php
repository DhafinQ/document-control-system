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

            <div class="d-flex justify-content-end mb-2">
                <!-- Tambah Dokumen -->
                <div>
                    <a href="/admin/dokumen_aktif/add" class="btn btn-admin d-flex align-items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                            class="icon icon-tabler icons-tabler-outline icon-tabler-file-plus me-2">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                            <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                            <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                            <path d="M12 11l0 6" />
                            <path d="M9 14l6 0" />
                        </svg>
                        Tambah Dokumen
                    </a>
                </div>
            </div>


            <!-- Tabel Dokumen -->
            <div class="table-responsive mt-4">
                <table class="table table-striped" id="myTable"  >
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nomor Dokumen</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Judul</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Deskripsi</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Kategori</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pengunggah</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">File</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-300">
                        <tr>
                            <td class="px-6 py-4 text-center">123/ABC/XXIVI/Dokumen_1</td>
                            <td class="px-6 py-4 text-center">Dokumen 1</td>
                            <td class="px-6 py-4 text-center">Deskripsi dokumen 1</td>
                            <td class="px-6 py-4 text-center">Kategori 1</td>
                            <td class="px-6 py-4 text-center">Admin</td>
                            <td class="px-6 py-4 text-center">Dokumen 1.pdf</td>
                            <td class="px-6 py-4 text-center">
                                <button class="btn btn-admin">Lihat Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-center">123/ABC/XXIVI/Dokumen_2</td>
                            <td class="px-6 py-4 text-center">Dokumen 2</td>
                            <td class="px-6 py-4 text-center">Deskripsi dokumen 2</td>
                            <td class="px-6 py-4 text-center">Kategori 2</td>
                            <td class="px-6 py-4 text-center">User </td>
                            <td class="px-6 py-4 text-center">Dokumen 2.pdf</td>
                            <td class="px-6 py-4 text-center">
                                <button class="btn btn-admin">Lihat Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-center">123/ABC/XXIVI/Dokumen_3</td>
                            <td class="px-6 py-4 text-center">Dokumen 3</td>
                            <td class="px-6 py-4 text-center">Deskripsi dokumen 3</td>
                            <td class="px-6 py-4 text-center">Kategori 3</td>
                            <td class="px-6 py-4 text-center">Admin</td>
                            <td class="px-6 py-4 text-center">Dokumen 3.pdf</td>
                            <td class="px-6 py-4 text-center">
                                <button class="btn btn-admin">Lihat Detail</button>
                            </td>
                        </tr>
                        <tr>
                            <td class="px-6 py-4 text-center">123/ABC/XXIVI/Dokumen_4</td>
                            <td class="px-6 py-4 text-center">Dokumen 4</td>
                            <td class="px-6 py-4 text-center">Deskripsi dokumen 4</td>
                            <td class="px-6 py-4 text-center">Kategori 4</td>
                            <td class="px-6 py-4 text-center">User  </td>
                            <td class="px-6 py-4 text-center">Dokumen 4.pdf</td>
                            <td class="px-6 py-4 text-center">
                                <button class="btn btn-admin">Lihat Detail</button>
                            </td>
                        </tr>
                        <!-- Tambahkan baris lainnya di sini -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection