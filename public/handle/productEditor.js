function loadProduct() {
    let product_id = $("#product_id").val();
    $.ajax({
        url: '/admin/product/' + product_id + '/show',
        type: 'GET',
        dataType: 'json', // Định dạng dữ liệu mong muốn (có thể là json, xml, html, ...)
        success: function (response) {
            console.log(response.product.title);
            if (response !== null && response !== undefined) {
                let product_edit = $("#product-edit");
                product_edit.empty();
       
                let product = response.product;

                let containerHTML = `<div class="card"><div class="card-body"><div class="product-container">`;
                let productHTML = `
                    <div class="product-info">
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <td colspan="2" style="text-align: center;">
                                        <a target="_blank" href="${product.url}">
                                            <i class="fas fa-link"></i> Liên kết đến sản phẩm
                                        </a>
                                    </td>
                                </tr>
                                <tr >
                                    <td>Title</td>
                                    <td>${product.title}</td>
                                </tr>
                                <tr>
                                    <td >Price</td>
                                    <td>${product.price}</td>
                                </tr>
                                <tr>
                                    <td>Promo</td>
                                    <td>${product.promo}</td>
                                </tr>
                                <tr>
                                    <td>Shippingcost</td>
                                    <td>${product.shippingcost}</td>
                                </tr>
                                <tr>
                                    <td>Brand</td>
                                    <td>${product.brand}</td>
                                </tr>
                                <tr>
                                    <td>Reference</td>
                                    <td>${product.reference}</td>
                                </tr>
                                <tr>
                                    <td>MPN</td>
                                    <td>${product.mpn}</td>
                                </tr>
                                <tr>
                                    <td>Ean</td>
                                    <td>${product.ean}</td>
                                </tr>
                                <tr>
                                    <td>Image</td>
                                    <td><img src="${product.imageurl}" width="40px" height="40"></td>
                                </tr>
                                <tr>
                                    <td>Available</td>
                                    <td>${product.available}</td>
                                </tr>
                                <tr>
                                    <td>Spec</td>
                                    <td>${product.spec}</td>
                                </tr>
                                <tr>
                                    <td>Description</td>
                                    <td>${product.description}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>`;

                containerHTML += productHTML;
                containerHTML +=`</div></div></div>`;
                // Thêm HTML sản phẩm vào DOM
                product_edit.append(containerHTML);
                
            }
        },
        error: function (xhr, status, error) {
            console.log("Lỗi");
        }
    });

}

function updateProduct(){
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    let id = $("#product_id").val();
    let title = $("#title").val();
    let price = $("#price").val();
    let promo = $("#promo").val();
    let shippingcost = $("#shippingcost").val();
    let brand = $("#brand").val();
    let reference = $("#reference").val();
    let mpn = $("#mpn").val();
    let ean = $("#ean").val();
    let imageurl = $("#imageurl").val();
    let available = $("#available").val();
    let spec = $("#spec").val();
    let description = $("#description").val();

    let requestData = {
        title: title,
        price: price,
        promo: promo,
        shippingcost: shippingcost,
        brand: brand,
        reference: reference,
        mpn: mpn,
        ean: ean,
        imageurl: imageurl,
        available: available,
        spec: spec,
        description: description,
        _token: csrfToken
    };


    $.ajax({
        type: "PUT",
        url: "/admin/product/"+ id +"/update", 
        data: requestData, 
        success: function (response) {
            loadProduct();
            Swal.fire({
                icon: 'success', 
                title: 'success',
                showConfirmButton: false, 
                timer: 800 
            });

        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error', 
                title: 'error',
                showConfirmButton: false,
                timer: 1500 
            });
        }
    });
}

function rematchedProduct(){
    let id = $("#product_id").val();
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    let requestData = {
        _token: csrfToken
    };

    $.ajax({
        type: "PUT",
        url: "/admin/rematched-product/" + id, 
        data: requestData, 
        success: function (response) {
            console.log(response);
            Swal.fire({
                icon: 'success', 
                title: 'success',
                showConfirmButton: false, 
                timer: 800 
            });
            loadProduct();

        },
        error: function (xhr, status, error) {
            Swal.fire({
                icon: 'error', 
                title: 'error',
                showConfirmButton: false,
                timer: 1500 
            });
        }
    });
    
}

function init() {
    loadProduct();
    ClassicEditor
    .create(document.querySelector('#editor'))
    .catch(error => {
        console.error(error);
    });
}

$(document).ready(function () {
    init();
});
