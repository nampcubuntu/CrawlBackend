@extends('layout.content.tables.index')

@section('content')
<div class="dashboard-wrapper">
    <div class="container-fluid  dashboard-content">
        <!-- ============================================================== -->
        <!-- pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 col-12">
                <div class="page-header">
                    <h2 class="pageheader-title">General Tables </h2>
                    <p class="pageheader-text">Proin placerat ante duiullam scelerisque a velit ac porta, fusce sit amet vestibulum mi. Morbi lobortis pulvinar quam.</p>
                    <div class="page-breadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Dashboard</a></li>
                                <li class="breadcrumb-item"><a href="#" class="breadcrumb-link">Tables</a></li>
                                <li class="breadcrumb-item active" aria-current="page">General Tables</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- end pageheader -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- ============================================================== -->
            <!-- bordered table -->
            <!-- ============================================================== -->

            <div class="col-xl-12 col-lg-6 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <select class="custom-select" id="custom-select">
                    </select>
                    <h5 class="card-header">Products Table</h5>
                    <div class="card-body">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Title</th>
                                    <th scope="col">Price</th>
                                    <th scope="col">Promo</th>
                                    <th scope="col">Shippingcost</th>
                                    <th scope="col">Brand</th>
                                    <th scope="col">Reference</th>
                                    <th scope="col">Mpn</th>
                                    <th scope="col">Ean</th>
                                    <th scope="col">Image</th>
                                    <th scope="col">Vailable</th>
                                    <th scope="col">Description</th>
                                    <th scope="col">Link</th>
                                    <th scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody id="product-table"></tbody>
                        </table>

                    </div>
                    <nav aria-label="Page navigation">
                        <ul class="pagination" id="pagination">

                        </ul>
                    </nav>

                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end bordered table -->
        </div>
    </div>
</div>
    @include('layout.footer.footer')
    <script src="{{ asset('handle/productHandler.js') }}"></script>
@endsection