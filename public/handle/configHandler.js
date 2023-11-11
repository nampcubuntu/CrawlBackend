const loadConfigList = () => {
    $.ajax({
        url: '/admin/configs',
        type: 'GET',
        dataType: 'json',
        success: function (response) {
            let domainList = $("#config-table");
            let dataArray = response.data;
            domainList.empty();
            for (let i = 0; i < dataArray.length; i++) {
                domainList.append(`
                    <tr>
                        <th scope="row">${i + 1}</th>
                        <td>${dataArray[i].url}</td>
                        <td><a href="/admin/config/${dataArray[i].id}"><i class="fa fa-cog" style="font-size:15px;" ></i></td></a>
                        <td>
                            <a class="btn-action" href="#" onclick="deleteConfig(event,${dataArray[i].id})"><i class="fa fa-trash" style="color:red"></i></a>
                        </td>
                    </tr>
                `);
            }
        },
        error: function (xhr, status, error) {
            console.log('Domain empty !');
        }
    });
}

const resetModal = () => {
    let configForm = $("#configForm")[0];
    configForm.reset();
}

const createConfigName = () =>{
    $("#config-save").click(function (event) {
        event.preventDefault();
        let csrfToken = $("#_token").val();
        let url = $("#url").val();

        let requestData = {
            url: url,
            _token: csrfToken
        };

        $.ajax({
            type: "POST",
            url: "/admin/create-config",
            data: requestData, 
            success: function (response) {
                loadConfigList();
                $("#configModal").modal("hide");
                resetModal();
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

const deleteConfig = (event,id) =>{
    event.preventDefault();
  
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            let csrfToken = $("#_token").val();
            let requestData = {
                _token: csrfToken
            };
            $.ajax({
                type: "DELETE",
                url: "/admin/delete/" + id,
                data: requestData,
                success: function (response) {
                    loadConfigList();
                    $("#configModal").modal("hide");
                    resetModal();
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
    });
   
}

const init = () => {
    loadConfigList();
    createConfigName();
    resetModal();
}

$(document).ready(function () {
    init();
});

