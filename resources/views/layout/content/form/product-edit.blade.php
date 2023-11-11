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
            <!-- basic form -->
            <!-- ============================================================== -->
            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-12">
                <div class="card">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-sm-12 pl-0">
                                <p class="text-right">
                                    <button type="button" id="update" class="btn btn-space btn-primary">Save</button>
                                </p>
                            </div>
                        </div>

                        <form action="#" id="editshopform" data-parsley-validate="">
                            <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}" />
                            <input type="hidden" name="product_id" id="product_id" value="{{ $product->id }}" />
                            <div class="form-group">
                                <label for="admin_form_title">Title</label>
                                <input id="title" type="text" name="title" value="{{ $product->title }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_price">Price</label>
                                <input id="price" type="text" name="price" value="{{ $product->price }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_promo">Promo</label>
                                <input id="promo" type="text" name="promo" value="{{ $product->promo }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_shipping">Shipping</label>
                                <input id="shippingcost" type="text" name="shippingcost" value="{{ $product->shippingcost }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_brand">Reference</label>
                                <input id="brand" type="text" name="brand" value="{{ $product->brand }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="admin_form_reference">Reference</label>
                                <input id="reference" type="text" name="reference" value="{{ $product->reference }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_mpn">MPN</label>
                                <input id="mpn" type="text" name="mpn" value="{{ $product->mpn }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_ean">EAN</label>
                                <input id="ean" type="text" name="ean" value="{{ $product->ean }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_imageurl">Image URL</label>
                                <input id="productimageurlxpath" type="text" name="productimageurlxpath" value="{{ $product->productimageurlxpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_available">Available</label>
                                <input id="available" type="text" name="available" value="{{ $product->available }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            
                            <div class="form-group">
                                <label for="admin_form_description">Description</label>
                                <input id="description" type="text" name="description" value="{{ $product->description }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>

                            <div class="row">
                                <div style="margin-bottom: 2px;" class="col-sm-12 pl-0">
                                    <p class="text-right">
                                        <button type="button" id="crawlers" class="btn btn-space btn-secondary">Crawlers</button>
                                    </p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end basic form -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- horizontal form -->
            <!-- ============================================================== -->
            <div class="col-xl-4 col-lg-2 col-md-12 col-sm-12 col-12" id="product-edit">

            </div>
            <!-- ============================================================== -->
            <!-- end horizontal form -->
            <!-- ============================================================== -->
        </div>

    </div>
</div>

@include('layout.footer.footer')
<script src="{{ asset('handle/productEditor.js') }}"></script>
@endsection