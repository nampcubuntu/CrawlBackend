function getAndDisplayProductList(pageNumber = null,config_id) {
    let pageUrl = '/admin/products/'+config_id;
    if(pageNumber != null){
        pageUrl = pageUrl+'?'+pageNumber;
    }
    console.log(pageUrl);
    $.ajax({
        url: pageUrl,
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            console.log(response);

            var pagination = $("#pagination");
            var productList = $("#product-table");
            var selectList = $("#select-push");
            pagination.empty();
            selectList.empty();
            productList.empty();

            let pages = response.results;
            let acounts = response.results;
            let products = response.results.data;
            for (var i = 0; i < products.length; i++) {
                productList.append(`
                    <tr>
                        <th scope="row">${i + 1}</th>
                        <td>${products[i].title}</td>
                        <td>${products[i].price}</td>
                        <td>${products[i].promo}</td>
                        <td>${products[i].shippingcost}</td>
                        <td>${products[i].brand}</td>
                        <td>${products[i].reference}</td>
                        <td>${products[i].mpn}</td>
                        <td>${products[i].ean}</td>
                        <td><img src="${products[i].imageurl}" width="30px" height="30"></td>
                        <td>${products[i].available}</td>
                        <td>${products[i].description}</td>
                        <td>
                            <a class="action-icon" target="_blank" href="${products[i].url}">
                                <i class="fa fa-link"></i>
                            </a>
                        </td>
                        <td>
                            <a class="action-icon" href="/admin/product/${products[i].id}/edit"><i class="fa fa-edit" style="color:blue"></i></a>
                            <a class="action-icon" href="#"><i class="fa fa-trash" style="color:red"></i></a>
                            <a class="action-icon" href="#" onclick="rematchedProduct(event,${products[i].id})"><i class="fas fa-sync" style="color:green"></i></a>      
                        </td>
                    </tr>
                `);
            }

            pages.links.forEach((link, index) => {
     
                if(link.label.includes("Previous")){
                    pagination.append(`
                        <li class="page-item ${link.url ? '' : 'disabled'}">
                            <a class="page-link" href="#" data-link="${link.url}" tabindex="-1">${link.label}</a>
                        </li>
                    `);
                }

                if (link.url && link.label && !link.label.includes("Previous") && !link.label.includes("Next")) {
                pagination.append(`
                    <li class="page-item ${link.active ? 'active' : ''}">
                        <a class="page-link" href="#" data-link="${link.url}">${link.label}</a>
                    </li>
                `);
                }

                if(link.label.includes("Next")){
                    pagination.append(`
                        <li class="page-item ${link.url ? '' : 'disabled'}">
                            <a class="page-link" href="#" data-link="${link.url}">${link.label}</a>
                        </li>
                    `);
                }
            });

            for (var n = 0; n < acounts.length; n++) {
                selectList.append(`
                    <option value="${acounts[n].id}">${acounts[n].login_url}</option>
                `);
            }
        },
        error: function (xhr, status, error) {
            console.log('Account empty !');
        }
    });
}

function dropdownConfig(){
    $.ajax({
        url: '/admin/configs',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            var select = $("#custom-select");
            select.empty();
            let dataArray = response.data;
            for (var i = 0; i < dataArray.length; i++) {
                select.append(`
                    <option value="${dataArray[i].id}" ${i === 0 ? 'selected="selected"' : ''}>${dataArray[i].url}</option>
                `);
            }
            if (dataArray && dataArray[0]) {
                getAndDisplayProductList(null,dataArray[0].id);
            }
        },
        error: function (xhr, status, error) {
            console.log('Domain empty !');
        }
    });
}


function handleSelectChange() {
    $(this).find('option').removeAttr('selected');
    let selectedValue = $(this).val();
    $(this).find('option[value="' + selectedValue + '"]').attr('selected', 'selected');
    getAndDisplayProductList(null,selectedValue);
}

function loadPages(event) {
    event.preventDefault(); 

    let url = $(this).data('link'); 
    let pageNumber = url.split('?')[1];
    
    let selectedValue = $('#custom-select option:selected').val();
    getAndDisplayProductList(pageNumber,selectedValue);

}

function rematchedProduct(event,id){
    event.preventDefault();
    let csrfToken = $('meta[name="csrf-token"]').attr('content');
    console.log(csrfToken);
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
    dropdownConfig();
    $('#custom-select').change(handleSelectChange);
    $(document).on('click', '#pagination .page-link', loadPages);
}

$(document).ready(function () {
    init();
});