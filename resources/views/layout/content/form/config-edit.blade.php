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
                            <input type="hidden" name="config_id" id="config_id" value="{{ $config->id }}" />
                            <div class="form-group">
                                <label for="admin_form_productconfigurationurl">Products</label>
                                <input id="productconfigurationurl" type="text" value="{{ $config->productconfigurationurl }}" name="productconfigurationurl" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_url">URL</label>
                                <input id="url" type="text" name="url" value="{{ $config->url }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="admin_form_sitemapurl">sitemap</label>
                                <input id="sitemapurl" type="text" name="sitemapurl" value="{{ $config->sitemapurl }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="admin_form_sitemaplevel1xpath">Categories level 1</label>
                                <input id="sitemaplevel1xpath" type="text" name="sitemaplevel1xpath" value="{{ $config->sitemaplevel1xpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="admin_form_sitemaplevel2xpath">Categories level 2</label>
                                <input id="sitemaplevel2xpath" type="text" name="sitemaplevel2xpath" value="{{ $config->sitemaplevel2xpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="admin_form_sitemaplevel3xpath">Categories level 3</label>
                                <input id="sitemaplevel3xpath" type="text" name="sitemaplevel3xpath" value="{{ $config->sitemaplevel3xpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="sitemapsubcategoryxpath">Sub-categories (3 levels recursive)</label>
                                <input id="sitemapsubcategoryxpath" type="text" name="sitemapsubcategoryxpath" value="{{ $config->sitemapsubcategoryxpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_producturl">Products links</label>
                                <input id="productxpath" type="text" name="productxpath" value="{{ $config->productxpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_pagination">Pagination links</label>
                                <input id="paginationxpath" type="text" name="paginationxpath" value="{{ $config->paginationxpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_hookcode">Hook code</label>
                                <textarea style="height: 300px;color:black" id="textareaHookcode" type="text" name="textareaHookcode" data-parsley-trigger="change" required="" autocomplete="off" class="form-control code-textarea code-editor">{{ $config->textareaHookcode }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="admin_form_title">Title</label>
                                <input id="producttitlexpath" type="text" name="producttitlexpath" value="{{ $config->producttitlexpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_price">Price</label>
                                <input id="productpricexpath" type="text" name="productpricexpath" value="{{ $config->productpricexpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_discountprice">Promo</label>
                                <input id="productdiscountpricexpath" type="text" name="productdiscountpricexpath" value="{{ $config->productdiscountpricexpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_brand">Brand</label>
                                <input id="productbrandxpath" type="text" name="productbrandxpath" value="{{ $config->productbrandxpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_reference">Reference</label>
                                <input id="productreferencexpath" type="text" name="productreferencexpath" value="{{ $config->productreferencexpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_mpn">MPN</label>
                                <input id="productmpnxpath" type="text" name="productmpnxpath" value="{{ $config->productmpnxpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_ean">EAN</label>
                                <input id="producteanxpath" type="text" name="producteanxpath" value="{{ $config->producteanxpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_imageurl">Image URL</label>
                                <input id="productimageurlxpath" type="text" name="productimageurlxpath" value="{{ $config->productimageurlxpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="admin_form_description">Description</label>
                                <input id="productdescriptionxpath" type="text" name="productdescriptionxpath" value="{{ $config->productdescriptionxpath }}" data-parsley-trigger="change" required="" autocomplete="off" class="form-control">
                            </div>

                            <div class="row">
                                <div style="margin-bottom: 2px;" class="col-sm-12 pl-0">
                                    <p class="text-right">
                                        <button type="button" id="crawlers" class="btn btn-space btn-secondary">Crawlers</button>
                                    </p>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="admin_form_hookcode">Agent</label>
                                <textarea style="height: 300px;color:black" id="agentHookcode" type="text" name="agentHookcode" data-parsley-trigger="change" required="" autocomplete="off" class="form-control code-textarea">{{ $config->agentHookcode }}</textarea>
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
            <div class="col-xl-4 col-lg-2 col-md-12 col-sm-12 col-12" id="productInfo">

            </div>
            <!-- ============================================================== -->
            <!-- end horizontal form -->
            <!-- ============================================================== -->
        </div>

    </div>
</div>

@include('layout.footer.footer')
<script src="{{ asset('handle/configEditor.js') }}"></script>
@endsection