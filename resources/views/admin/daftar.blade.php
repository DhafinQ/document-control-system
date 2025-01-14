@extends("layouts.layout")

@section("title", "Document")

@section("content")

<div class="container-fluid">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body">
                <h2 class="text-2xl font-bold pb-2">
                    <span>
                        <i class="ti ti-file-description"></i>
                    </span>
                    Daftar Dokumen
                </h2>

                <div class="flex justify-between items-center mb-2">

                    <!-- Tambah Dokumen -->
                    <div>
                        <a href="/admin/tambah" class="px-2 py-2 bg-blue-500 text-secondary rounded-lg hover:bg-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="icon icon-tabler icons-tabler-outline icon-tabler-file-plus">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                <path d="M14 3v4a1 1 0 0 0 1 1h4" />
                                <path d="M17 21h-10a2 2 0 0 1 -2 -2v-14a2 2 0 0 1 2 -2h7l5 5v11a2 2 0 0 1 -2 2z" />
                                <path d="M12 11l0 6" />
                                <path d="M9 14l6 0" />
                            </svg> Tambah Dokumen
                        </a>
                    </div>

                    <!-- Search Bar -->
                    <div>
                        <input type="text" id="search" placeholder="Cari dokumen..."
                            class="px-4 py-2 border border-gray-300 rounded-lg w-64 mt-4" onkeyup="searchDocuments()">
                    </div>
                </div>

                <!-- Tabel Dokumen -->
                <div class="overflow-x-auto">
                    <table class="min-w-full" id="documentsTable">
                        <thead class="bg-gray-50">
                            <tr>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b-2 border-gray-300">
                                    Judul
                                </th>
                                <th
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider border-b-2 border-gray-300">
                                    Deskripsi
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b-2 border-gray-300">
                                    Kategori
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b-2 border-gray-300">
                                    Pengunggah
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b-2 border-gray-300">
                                    File
                                </th>
                                <th
                                    class="px-6 py-3 text-center text-xs font-medium text-gray-500 uppercase tracking-wider border-b-2 border-gray-300">
                                    Aksi
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-300">
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                    Dokumen 1
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300">
                                    Deskripsi dokumen 1
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                    Kategori 1
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                    Admin
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                    Dokumen 1.pdf
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border-b border-gray-300">
                                    <a href="/admin/edit" class="text-secondary hover:text-indigo-900 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path
                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg> Edit
                                    </a>
                                    <span class="mx-1"></span>
                                    <a href="/path/to/file2" class="text-secondary hover:text-indigo-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg> Lihat File
                                    </a>
                                </td>
                            </tr>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                    Dokumen 2
                                </td>
                                <td class="px-6 py-4 border-b border-gray-300">
                                    Deskripsi dokumen 2
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                    Kategori 2
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                    User
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap border-b border-gray-300">
                                    Dokumen 2.pdf
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium border-b border-gray-300">
                                    <a href="/admin/edit" class="text-secondary hover:text-indigo-900 mr-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-edit">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M7 7h-1a2 2 0 0 0 -2 2v9a2 2 0 0 0 2 2h9a2 2 0 0 0 2 -2v-1" />
                                            <path
                                                d="M20.385 6.585a2.1 2.1 0 0 0 -2.97 -2.97l-8.415 8.385v3h3l8.385 -8.415z" />
                                            <path d="M16 5l3 3" />
                                        </svg> Edit
                                    </a>
                                    <span class="mx-1"></span>
                                    <a href="/path/to/file2" class="text-secondary hover:text-indigo-900">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="icon icon-tabler icons-tabler-outline icon-tabler-eye">
                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                            <path d="M10 12a2 2 0 1 0 4 0a2 2 0 0 0 -4 0" />
                                            <path
                                                d="M21 12c-2.4 4 -5.4 6 -9 6c-3.6 0 -6.6 -2 -9 -6c2.4 -4 5.4 -6 9 -6c3.6 0 6.6 2 9 6" />
                                        </svg> Lihat File
                                    </a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <!-- Next page (Tabel) -->
                <div class="flex items-center justify-between mt-4">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <a href="#"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg -white hover:bg-gray-50">
                            Previous
                        </a>
                        <a href="#"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50">
                            Next
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function searchDocuments() {
        const input = document.getElementById('search');
        const filter = input.value.toLowerCase();
        const table = document.getElementById('documentsTable');
        const tr = table.getElementsByTagName('tr');

        for (let i = 1; i < tr.length; i++) { // Start from 1 to skip the header row
            const tdTitle = tr[i].getElementsByTagName('td')[0];
            const tdDescription = tr[i].getElementsByTagName('td')[1];
            if (tdTitle || tdDescription) {
                const titleText = tdTitle.textContent || tdTitle.innerText;
                const descriptionText = tdDescription.textContent || tdDescription.innerText;
                if (titleText.toLowerCase().indexOf(filter) > -1 || descriptionText.toLowerCase().indexOf(filter) > -1) {
                    tr[i].style.display = "";
                } else {
                    tr[i].style.display = "none";
                }
            }
        }
    }
</script>
@endsection