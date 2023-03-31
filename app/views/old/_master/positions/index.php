<div class="card mt-3">
    <div class="card-header">
        <div class="row">
            <div class="col-md-1 mb-3">
                <button class="btn btn-primary" id="btnModalCreate" data-bs-toggle="modal" data-bs-target="#modal"><i class="bi bi-plus-square-dotted"></i></button>
            </div>
            <div class="col-md">
                <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Type here for search">
            </div>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md">
                <div class="table-responsive">
                    <table class="table caption-top table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Position Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="myForm">
                <div class="modal-body">
                    <div role="alert" style="display: none;" id="alertBootsModal">
                        <p id="alertMsgModal"></p>
                    </div>

                    
                    <div id="formDataWrapper">
                        <input type="hidden" id="input-position-id" name="id">
                        <div class="row">
                            <div class="col-md">
                                <label for="input-position-name" class="form-label">Position Name</label>
                                <input type="text" class="form-control" id="input-position-name" name="position_name" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" id="btnModalSave" data-bs-dismiss="modal" style="display: none;">Save</button>
                    <button type="button" class="btn btn-success" id="btnModalUpdate" data-bs-dismiss="modal" style="display: none;">Update</button>
                    <button type="button" class="btn btn-danger" id="btnModalDelete" data-bs-dismiss="modal" style="display: none;">Delete</button>
                    <button type="button" class="btn btn-secondary" id="btnClose" data-bs-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // pemanggilan function ini (loadData()) harus berisi parameter 'btn-edit' dan 'btn-delete' : example : loadData('btn-edit', 'btn-delete') untuk mengaktifkan function getButtons(...args)
    let loadData = (...args) => {
        let tableBody = document.querySelector('tbody');
        tableBody.innerHTML = '';
        
        let request = new XMLHttpRequest();
        request.open('GET', '<?= BASEURL ?>/positions/getAll');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status == 200) {
                let results = JSON.parse(request.responseText);
                let no = 1;
                results.forEach((result) => {
                    let tr = document.createElement('tr');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    let btnEdit = document.createElement('button');
                        btnEdit.setAttribute('class', 'btn btn-sm btn-outline-primary btn-edit');
                        btnEdit.setAttribute('data-bs-toggle', 'modal');
                        btnEdit.setAttribute('data-bs-target', '#modal');
                        btnEdit.setAttribute('data-id', result.id);
                        btnEdit.innerHTML = '<i class="bi bi-pencil-square"></i>';
                    let btnDelete = document.createElement('button');
                        btnDelete.setAttribute('class', 'btn btn-sm btn-outline-danger btn-delete');
                        btnDelete.setAttribute('data-bs-toggle', 'modal');
                        btnDelete.setAttribute('data-bs-target', '#modal');
                        btnDelete.setAttribute('data-id', result.id);
                        btnDelete.setAttribute('data-name', result.position_name);
                        btnDelete.innerHTML = '<i class="bi bi-trash3-fill"></i>';

                    td1.innerHTML = no++;
                    td2.innerHTML = result.position_name;
                    td3.append(btnEdit);
                    td3.append(' ');
                    td3.append(btnDelete);

                    tr.append(td1);
                    tr.append(td2);
                    tr.append(td3);
                    tableBody.append(tr);
                });
                getButtons(...args);
            }
        };
        request.send();
    }; loadData('btn-edit', 'btn-delete');

    // set alerts
    let alert = document.getElementById('alertBoots');
    let alertMsg = document.getElementById('alertMsg');
    let alertModal = document.getElementById('alertBootsModal');
    let alertMsgModal = document.getElementById('alertMsgModal');
    let alertClassWarning = 'alert alert-warning alert-dismissible fade show';
    
    const alertResponse = () => {
        alert.style.display = 'block';
        setTimeout(() => {
            alert.style.display = 'none';
        }, 3000);
    };

    const alertModalResponse = () => {
        alertModal.style.display = 'block';
        setTimeout(() => {
            alertModal.style.display = 'none';
        }, 1000);
    };
    // end set alerts

    // set form data
    let formDataWrapper = document.getElementById('formDataWrapper');
    let deptId = document.getElementById('input-position-id');
    let positionName = document.getElementById('input-position-name');
    
    const formClear = () => {
        positionName.value = '';
    };
    // end set form data
    
    // set modal
    let modalBody = document.getElementsByClassName('modal-body')[0];
    let btnModalCreate = document.getElementById('btnModalCreate');
    let modalLabel = document.getElementById('modalLabel');
    let btnModalSave = document.getElementById('btnModalSave');
    let btnModalUpdate = document.getElementById('btnModalUpdate');
    let btnModalDelete = document.getElementById('btnModalDelete');
    let btnClose = document.getElementById('btnClose');
    let confirmDelete = document.createElement('h3');
    // end set modal

    // validasi data double
    const validate = () => {
        let formData = 'position_name=' + positionName.value;
        let request = new XMLHttpRequest();
        request.open('POST', '<?= BASEURL ?>/positions/validate');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status ==  200) {
                let results = JSON.parse(request.responseText);
                if(results) {
                    btnModalSave.disabled = true;
                    btnModalUpdate.disabled = true;
                    alertModal.setAttribute('class', alertClassWarning);
                    alertMsgModal.innerHTML = '<b>' + results.position_name + '</b> sudah terdaftar !';
                    alertModalResponse();
                } else {
                    btnModalSave.disabled = false;
                    btnModalUpdate.disabled = false;
                }
            }
        };
        request.send(formData);
    }; positionName.addEventListener('keyup', validate);
    // end validasi data double

    // validasi data kosong
    const notNull = () => {
        if(positionName.value == '') {
            btnModalSave.disabled = true;
            btnModalUpdate.disabled = true;
            alertModal.setAttribute('class', alertClassWarning);
            alertMsgModal.innerHTML = 'Position name wajib diisi !';
            alertModalResponse();
        }
    };
    // end validasi data kosong

    // prepare tambah data
    const modalCreate = () => {
        formClear();
        modalLabel.innerHTML = 'Create Data';
        btnClose.innerHTML = 'Close';
        btnModalSave.style.display = 'block';
        btnModalSave.disabled = false;
        btnModalUpdate.style.display = 'none';
        btnModalDelete.style.display = 'none';
        formDataWrapper.style.display = 'block';
        confirmDelete.style.display = 'none';
        modalBody.addEventListener('mouseleave', notNull);
    }; btnModalCreate.addEventListener('click', modalCreate);
    // end prepare tambah data

    // proses tambah data
    const createData = () => {
        let formData = 'position_name=' + positionName.value;
        let request = new XMLHttpRequest();
        request.open('POST', '<?= BASEURL ?>/positions/store');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status == 200) {
                let results = JSON.parse(request.responseText);
                alert.setAttribute('class', results.alertClass);
                alertMsg.innerHTML = results.alertMsg;
                alertResponse();
                formClear();
                loadData('btn-edit', 'btn-delete');
            }
        };
        request.send(formData);
    }; btnModalSave.addEventListener('click', createData);
    // end proses tambah data

    // get buttons data
    const getButtons = (...args) => {
        // get edit
        let btnEdit = document.getElementsByClassName(args[0]);
        for(let i = 0; i < btnEdit.length; i ++) {
            btnEdit[i].addEventListener('click', () => {
                modalLabel.innerHTML = 'Edit Data';
                btnClose.innerHTML = 'Close';
                btnModalSave.style.display = 'none';
                btnModalUpdate.style.display = 'block';
                btnModalUpdate.disabled = false;
                btnModalDelete.style.display = 'none';
                formDataWrapper.style.display = 'block';
                confirmDelete.style.display = 'none';

                let formData = 'id=' + btnEdit[i].getAttribute('data-id');
                let request = new XMLHttpRequest();
                request.open('POST', '<?= BASEURL ?>/positions/getDataById');
                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                request.onreadystatechange = () => {
                    if(request.readyState == 4 && request.status == 200) {
                        let results = JSON.parse(request.responseText);
                        deptId.value = results.id;
                        positionName.value = results.position_name;
                    }
                };
                request.send(formData);
            });
        }
        // end get edit

        // get delete
        let btnDelete = document.getElementsByClassName(args[1]);
        for(let i = 0; i < btnDelete.length; i++) {
            btnDelete[i].addEventListener('click', () => {
                modalLabel.innerHTML = 'Confirmation';
                btnClose.innerHTML = 'Cancel';
                btnModalSave.style.display = 'none';
                btnModalUpdate.style.display = 'none';
                btnModalDelete.style.display = 'block';
                formDataWrapper.style.display = 'none';
                confirmDelete.innerHTML = 'Yakin hapus <b>"' + btnDelete[i].getAttribute('data-name') + '</b>" ?';
                confirmDelete.style.display = 'block';

                // default value ini dibuat hanya untuk "menahan" alert agar tidak muncul setelah validasi aktif sesaat setelah proses create data atau sesaat setelah edit data
                positionName.value = 'foo';

                modalBody.append(confirmDelete);
                btnModalDelete.setAttribute('data-id', btnDelete[i].getAttribute('data-id'));
            });
        }
        // end get delete
    };
    // end get buttons

    // proses update data
    const updateData = () => {
        let formData = 'id=' + deptId.value + '&position_name=' + positionName.value;
        let request = new XMLHttpRequest();
        request.open('POST', '<?= BASEURL ?>/positions/update');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status == 200) {
                let results = JSON.parse(request.responseText);
                alert.setAttribute('class', results.alertClass);
                alertMsg.innerHTML = results.alertMsg;
                alertResponse();
                formClear();
                loadData('btn-edit', 'btn-delete');
            }
        };
        request.send(formData);
    }; btnModalUpdate.addEventListener('click', updateData);
    // end proses update data

    // proses delete data
    const deleteData = () => {
        let formData = 'id=' + btnModalDelete.getAttribute('data-id');
        let request = new XMLHttpRequest();
            request.open('POST', '<?= BASEURL ?>/positions/destroy');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.onreadystatechange = () => {
                if(request.readyState == 4 && request.status == 200) {
                    let results = JSON.parse(request.responseText);
                    dataName = results.position_name;
                    alert.setAttribute('class', results.alertClass);
                    alertMsg.innerHTML = results.alertMsg;
                    alertResponse();
                    formClear();
                    loadData('btn-edit', 'btn-delete');
                }
            };
            request.send(formData);
    }; btnModalDelete.addEventListener('click', deleteData);
    // end proses delete data

    // proses search data
    let searchData = () => {
        let tableBody = document.querySelector('tbody');
        tableBody.innerHTML = '';
        
        let keywords = 'keywords=' + document.getElementById('keywords').value;
        let request = new XMLHttpRequest();
        request.open('POST', '<?= BASEURL ?>/positions/search');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status == 200) {
                let results = JSON.parse(request.responseText);
                let no = 1;
                results.forEach((result) => {
                    let tr = document.createElement('tr');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    let btnEdit = document.createElement('button');
                        btnEdit.setAttribute('class', 'btn btn-sm btn-outline-primary btn-edit');
                        btnEdit.setAttribute('data-bs-toggle', 'modal');
                        btnEdit.setAttribute('data-bs-target', '#modal');
                        btnEdit.setAttribute('data-id', result.id);
                        btnEdit.innerHTML = '<i class="bi bi-pencil-square"></i>';
                    let btnDelete = document.createElement('button');
                        btnDelete.setAttribute('class', 'btn btn-sm btn-outline-danger btn-delete');
                        btnDelete.setAttribute('data-bs-toggle', 'modal');
                        btnDelete.setAttribute('data-bs-target', '#modal');
                        btnDelete.setAttribute('data-id', result.id);
                        btnDelete.setAttribute('data-name', result.position_name);
                        btnDelete.innerHTML = '<i class="bi bi-trash3-fill"></i>';

                    td1.innerHTML = no++;
                    td2.innerHTML = result.position_name;
                    td3.append(btnEdit);
                    td3.append(' ');
                    td3.append(btnDelete);

                    tr.append(td1);
                    tr.append(td2);
                    tr.append(td3);
                    tableBody.append(tr);
                });
                getButtons('btn-edit', 'btn-delete');
            }
        };
        request.send(keywords);
    }; document.getElementById('keywords').addEventListener('keyup', searchData);
    // end proses search data
</script>