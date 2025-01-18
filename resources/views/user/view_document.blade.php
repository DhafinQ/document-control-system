@extends('layouts.layout')

@section("title", "Document")

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <h2 class="text-2xl font-bold pb-2">
                <span>
                    <i class="ti ti-file-description"></i>
                </span>
                Title
            </h2>
            <div class="table-responsive mt-4">
                <table class="table table-striped" id="myTable">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Title</th>
                            <th>Title</th>
                            <th>Title</th>
                            <th>Title</th>
                            <th>Title</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>test</td>
                            <td>Software Engineer</td>
                            <td>New York</td>
                            <td>30</td>
                            <td>30</td>
                            <td>2015-08-19</td>
                            <td><button class="btn btn-primary">Lihat File</button></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>Software Engineer</td>
                            <td>New York</td>
                            <td>30</td>
                            <td>30</td>
                            <td>2015-08-19</td>
                            <td><button class="btn btn-primary">Lihat File</button></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>Software Engineer</td>
                            <td>New York</td>
                            <td>30</td>
                            <td>30</td>
                            <td>2015-08-19</td>
                            <td><button class="btn btn-primary">Lihat File</button></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>Software Engineer</td>
                            <td>New York</td>
                            <td>30</td>
                            <td>30</td>
                            <td>2015-08-19</td>
                            <td><button class="btn btn-primary">Lihat File</button></td>
                        </tr>
                        <tr>
                            <td>John Doe</td>
                            <td>Software Engineer</td>
                            <td>New York</td>
                            <td>30</td>
                            <td>30</td>
                            <td>2015-08-19</td>
                            <td><button class="btn btn-primary">Lihat File</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection