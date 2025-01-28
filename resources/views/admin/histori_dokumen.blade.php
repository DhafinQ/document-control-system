@extends("layouts.layout_admin")

@section("title", "Document")

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body">
            <div class="table-responsive mt-4">
                <table class="table table-striped" id="myTable"  >
                    <thead> 
                        <tr>
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
                            <td>John Doe</td>
                            <td>Software Engineer</td>
                            <td>New York</td>
                            <td>30</td>
                            <td>2015-08-19</td>
                            <td>$120,000</td>
                        </tr>
                        <tr>
                            <td>Jane Smith</td>
                            <td>Project Manager</td>
                            <td>London</td>
                            <td>40</td>
                            <td>2012-03-23</td>
                            <td>$95,000</td>
                        </tr>
                        <tr>
                            <td>James Brown</td>
                            <td>UX Designer</td>
                            <td>San Francisco</td>
                            <td>28</td>
                            <td>2018-07-14</td>
                            <td>$85,000</td>
                        </tr>
                        <tr>
                            <td>Mary Johnson</td>
                            <td>Data Scientist</td>
                            <td>Chicago</td>
                            <td>35</td>
                            <td>2016-10-05</td>
                            <td>$110,000</td>
                        </tr>
                        <tr>
                            <td>Robert Williams</td>
                            <td>Backend Developer</td>
                            <td>Los Angeles</td>
                            <td>25</td>
                            <td>2019-06-12</td>
                            <td>$95,000</td>
                        </tr>
                        <tr>
                            <td>Linda Miller</td>
                            <td>Front-End Developer</td>
                            <td>Seattle</td>
                            <td>32</td>
                            <td>2017-04-22</td>
                            <td>$92,000</td>
                        </tr>
                        <tr>
                            <td>Michael Davis</td>
                            <td>DevOps Engineer</td>
                            <td>Denver</td>
                            <td>29</td>
                            <td>2020-01-09</td>
                            <td>$105,000</td>
                        </tr>
                        <tr>
                            <td>Emily Wilson</td>
                            <td>Product Manager</td>
                            <td>Miami</td>
                            <td>38</td>
                            <td>2013-11-13</td>
                            <td>$115,000</td>
                        </tr>
                        <tr>
                            <td>David Moore</td>
                            <td>System Administrator</td>
                            <td>Houston</td>
                            <td>45</td>
                            <td>2010-02-25</td>
                            <td>$80,000</td>
                        </tr>
                        <tr>
                            <td>Sarah Taylor</td>
                            <td>Business Analyst</td>
                            <td>Boston</td>
                            <td>27</td>
                            <td>2019-08-15</td>
                            <td>$70,000</td>
                        </tr>
                        <tr>
                            <td>Thomas Anderson</td>
                            <td>Web Developer</td>
                            <td>Los Angeles</td>
                            <td>24</td>
                            <td>2021-03-02</td>
                            <td>$65,000</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection