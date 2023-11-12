function loadConfigData() {
    var config_id = $("#config_id").val();
    $.ajax({
        url: '/admin/get-all-config-tables/' + config_id,
        type: 'GET',
        dataType: 'json', // Định dạng dữ liệu mong muốn (có thể là json, xml, html, ...)
        success: function (response) {
            console.log(response);
            if (response !== null && response !== undefined) {
                var productInfo = $("#productInfo");
                productInfo.empty();

                let products = response.configs;

                for (var j = 0; j < products.length; j++) {
                    let containerHTML = `<div class="card"><div class="card-body"><div class="product-container">`;
                    let productHTML = `
                        <div class="product-info">
                            <table class="table table-bordered">
                                <tbody>
                                    <tr>
                                        <td colspan="2" style="text-align: center;">
                                            <a target="_blank" href="${products[j].url}">
                                                <i class="fas fa-link"></i> Liên kết đến sản phẩm
                                            </a>
                                        </td>
                                    </tr>
                                    <tr >
                                        <td>Title</td>
                                        <td>${products[j].title}</td>
                                    </tr>
                                    <tr>
                                        <td >Price</td>
                                        <td>${products[j].price}</td>
                                    </tr>
                                    <tr>
                                        <td>Promo</td>
                                        <td>${products[j].promo}</td>
                                    </tr>
                                    <tr>
                                        <td>Shippingcost</td>
                                        <td>${products[j].shippingcost}</td>
                                    </tr>
                                    <tr>
                                        <td>Brand</td>
                                        <td>${products[j].brand}</td>
                                    </tr>
                                    <tr>
                                        <td>Reference</td>
                                        <td>${products[j].reference}</td>
                                    </tr>
                                    <tr>
                                        <td>MPN</td>
                                        <td>${products[j].mpn}</td>
                                    </tr>
                                    <tr>
                                        <td>Ean</td>
                                        <td>${products[j].ean}</td>
                                    </tr>
                                    <tr>
                                        <td>Image</td>
                                        <td><img src="${products[j].imageurl}" width="40px" height="40"></td>
                                    </tr>
                                    <tr>
                                        <td>Available</td>
                                        <td>${products[j].available}</td>
                                    </tr>
                                    <tr>
                                        <td>Spec</td>
                                        <td></td>
                                    </tr>
                                    <tr>
                                        <td>Description</td>
                                        <td>${products[j].description}</td>
                                    </tr>
                                    <tr>
                                        <td>HTTP CODE</td>
                                        <td>${products[j].httpcode}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>`;



                    if (products[j] && products[j].prices) {
                        let variantTableHTML = ` <div class="variant-info"><table class="table table-bordered">`;
                        products[j].prices.forEach((price, index) => {
                            variantTableHTML += `
                                <tr>
                                    <td>${products[j].titles[index]}</td>
                                    <td>${price}</td>
                                    <td>${products[j].discountprices[index]}</td>
                                    <td>${products[j].shippingcosts[index]}</td>
                                    <td>${products[j].references[index]}</td>
                                    <td>${products[j].mpns[index]}</td>
                                    <td>${products[j].eans[index]}</td>
                                    <td>${products[j].availables[index]}</td>
                                </tr>`;
                        });

                        variantTableHTML += `</table></div>`;
                        productHTML += variantTableHTML;
                    } else {
                        console.log("ko có biến thể");
                    }
                    containerHTML += productHTML;
                    containerHTML += `</div></div></div>`;
                    // Thêm HTML sản phẩm vào DOM
                    productInfo.append(containerHTML);

                }
            }

        },
        error: function (xhr, status, error) {
            console.log("Lỗi");
        }
    });

}

function updateConfig() {
    $("#update").click(function (event) {
        event.preventDefault();
        var config_id = $("#config_id").val();
        var csrfToken = $("#_token").val();
        var productconfigurationurl = $("#productconfigurationurl").val();
        var url = $("#url").val();
        var sitemapurl = $("#sitemapurl").val();
        var sitemaplevel1xpath = $("#sitemaplevel1xpath").val();
        var sitemaplevel2xpath = $("#sitemaplevel2xpath").val();
        var sitemaplevel3xpath = $("#sitemaplevel3xpath").val();
        var sitemapsubcategoryxpath = $("#sitemapsubcategoryxpath").val();
        var productxpath = $("#productxpath").val();
        var paginationxpath = $("#paginationxpath").val();
        var textareaHookcode = $("#textareaHookcode").val();
        var producttitlexpath = $("#producttitlexpath").val();
        var productpricexpath = $("#productpricexpath").val();
        var productdiscountpricexpath = $("#productdiscountpricexpath").val();
        var productbrandxpath = $("#productbrandxpath").val();
        var productreferencexpath = $("#productreferencexpath").val();
        var productmpnxpath = $("#productmpnxpath").val();
        var producteanxpath = $("#producteanxpath").val();
        var productimageurlxpath = $("#productimageurlxpath").val();
        var productdescriptionxpath = $("#productdescriptionxpath").val();
        var agentHookcode = $("#agentHookcode").val();

        var requestData = {
            productconfigurationurl: productconfigurationurl,
            url: url,
            sitemapurl: sitemapurl,
            sitemaplevel1xpath: sitemaplevel1xpath,
            sitemaplevel2xpath: sitemaplevel2xpath,
            sitemaplevel3xpath: sitemaplevel3xpath,
            sitemapsubcategoryxpath: sitemapsubcategoryxpath,
            productxpath: productxpath,
            paginationxpath: paginationxpath,
            textareaHookcode: textareaHookcode,
            producttitlexpath: producttitlexpath,
            productpricexpath: productpricexpath,
            productdiscountpricexpath: productdiscountpricexpath,
            productbrandxpath: productbrandxpath,
            productreferencexpath: productreferencexpath,
            productmpnxpath: productmpnxpath,
            producteanxpath: producteanxpath,
            productimageurlxpath: productimageurlxpath,
            productdescriptionxpath: productdescriptionxpath,
            agentHookcode: agentHookcode,
            _token: csrfToken
        };

        $.ajax({
            type: "PUT",
            url: "/admin/update-config/" + config_id,
            data: requestData,
            success: function (response) {
                loadConfigData();
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
    });
}

function agentHookCode() {
    $("#crawlers").click(function (event) {
        event.preventDefault();
        var csrfToken = $("#_token").val();
        var agentHookCode = $("#agentHookcode").val();
        var config_id = $("#config_id").val();

        console.log(csrfToken);
        console.log(agentHookCode);
        console.log(config_id);

        var requestData = {
            agentHookCode: agentHookCode,
            config_id: config_id,
            _token: csrfToken
        };

        $.ajax({
            type: "POST",
            url: "/admin/agent-hook-code",
            data: requestData,
            success: function (response) {
                console.log(response);
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
    });
}

function init() {
    loadConfigData();
    updateConfig();
    agentHookCode();
}

$(document).ready(function () {
    init();
});