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
                                <th>Employee Name</th>
                                <th>Join Date</th>
                                <th>Leave Balance</th>
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
                        <input type="hidden" id="input-emp-id" name="id">
                        <div class="row">
                            <div class="col-md mb-3">
                                <label for="input-emp-name" class="form-label">Employee Name</label>
                                <input type="text" class="form-control" id="input-emp-name" name="emp_name" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md mb-3">
                                <label for="input-join-date" class="form-label">Join Date</label>
                                <input type="date" class="form-control" id="input-join-date" name="join_date" autocomplete="off">
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md mb-3">
                                <label for="input-leave-balance" class="form-label">Leave Balance</label>
                                <input type="number" class="form-control" id="input-leave-balance" name="leave_balance" autocomplete="off">
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
        request.open('GET', '<?= BASEURL ?>/employees/getAll');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status == 200) {
                let results = JSON.parse(request.responseText);
                let no = 1;
                results.forEach((result) => {
                    let tr = document.createElement('tr');
                    let td1 = document.createElement('td');
                    let td2 = document.createElement('td');
                    let td3 = document.createElement('td');
                    let td4 = document.createElement('td');
                    let td5 = document.createElement('td');
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
                        btnDelete.setAttribute('data-name', result.emp_name);
                        btnDelete.innerHTML = '<i class="bi bi-trash3-fill"></i>';

                    td1.innerHTML = no++;
                    td2.innerHTML = result.emp_name;
                    td3.innerHTML = result.join_date;
                    td4.innerHTML = result.leave_balance;
                    td5.append(btnEdit);
                    td5.append(' ');
                    td5.append(btnDelete);
                    
                    tr.append(td1);
                    tr.append(td2);
                    tr.append(td3);
                    tr.append(td4);
                    tr.append(td5);
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

    let empId = document.getElementById('input-emp-id');
    let empName = document.getElementById('input-emp-name');
    let joinDate = document.getElementById('input-join-date');
    let leaveBalance = document.getElementById('input-leave-balance');
    
    const formClear = () => {
        empName.value = '';
        joinDate.value = '';
        leaveBalance.value = '';
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
        let request = new XMLHttpRequest();
        request.open('POST', '<?= BASEURL ?>/employees/validate');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status ==  200) {
                let results = JSON.parse(request.responseText);
                if(results) {
                    btnModalSave.disabled = true;
                    btnModalUpdate.disabled = true;
                    alertModal.setAttribute('class', alertClassWarning);
                    alertMsgModal.innerHTML = '<b>' + results.emp_name + '</b> sudah terdaftar !';
                    alertModalResponse();
                } else {
                    btnModalSave.disabled = false;
                    btnModalUpdate.disabled = false;
                }
            }
        };
        let formData = 'emp_name=' + empName.value;
        request.send(formData);
    };
    
    empName.addEventListener('keyup', validate); // cek saat nama karyawan di ketik 
    btnModalSave.addEventListener('mouseover', validate); //cek sebelum tombol save di klik
    // end validasi data double

    // validasi data kosong
    const notNull = () => {
        if(empName.value == '') {
            btnModalSave.disabled = true;
            btnModalUpdate.disabled = true;
            alertModal.setAttribute('class', alertClassWarning);
            alertMsgModal.innerHTML = 'Employee name wajib diisi !';
            alertModalResponse();
        } else if(joinDate.value == '') {
            btnModalSave.disabled = true;
            btnModalUpdate.disabled = true;
            alertModal.setAttribute('class', alertClassWarning);
            alertMsgModal.innerHTML = 'Join date wajib diisi !';
            alertModalResponse();
        } else if(leaveBalance.value == '') {
            btnModalSave.disabled = true;
            btnModalUpdate.disabled = true;
            alertModal.setAttribute('class', alertClassWarning);
            alertMsgModal.innerHTML = 'Leave balance wajib diisi !';
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
        joinDate.addEventListener('click', () => { btnModalSave.disabled = false; }); // aktifasi tombol save
        leaveBalance.addEventListener('keyup', () => { btnModalSave.disabled = false; }); // end aktifasi tombol save
    }; btnModalCreate.addEventListener('click', modalCreate);
    // end prepare tambah data

    // proses tambah data
    const createData = () => {
        let formData = 'emp_name=' + empName.value + '&join_date=' + joinDate.value + '&leave_balance=' + leaveBalance.value;
        let request = new XMLHttpRequest();
        request.open('POST', '<?= BASEURL ?>/employees/store');
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
                modalBody.addEventListener('mouseleave', notNull);

                let formData = 'id=' + btnEdit[i].getAttribute('data-id');
                let request = new XMLHttpRequest();
                request.open('POST', '<?= BASEURL ?>/employees/getDataById');
                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                request.onreadystatechange = () => {
                    if(request.readyState == 4 && request.status == 200) {
                        let results = JSON.parse(request.responseText);
                        empId.value = results.id;
                        empName.value = results.emp_name;
                        joinDate.value = results.join_date;
                        leaveBalance.value = results.leave_balance;
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
                empName.value = 'foo'; joinDate.value = '1945-08-17'; leaveBalance.value = 12;

                modalBody.append(confirmDelete);
                btnModalDelete.setAttribute('data-id', btnDelete[i].getAttribute('data-id'));
            });
        }
        // end get delete
    };
    // end get buttons
    
    // proses update data
    const updateData = () => {
        let formData = 'id=' + empId.value + '&emp_name=' + empName.value + '&join_date=' + joinDate.value + '&leave_balance=' + leaveBalance.value;
        let request = new XMLHttpRequest();
        request.open('POST', '<?= BASEURL ?>/employees/update');
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
            request.open('POST', '<?= BASEURL ?>/employees/destroy');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.onreadystatechange = () => {
                if(request.readyState == 4 && request.status == 200) {
                    let results = JSON.parse(request.responseText);
                    dataName = results.emp_name;
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
        request.open('POST', '<?= BASEURL ?>/employees/search');
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
                    let td4 = document.createElement('td');
                    let td5 = document.createElement('td');
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
                        btnDelete.setAttribute('data-name', result.emp_name);
                        btnDelete.innerHTML = '<i class="bi bi-trash3-fill"></i>';

                    td1.innerHTML = no++;
                    td2.innerHTML = result.emp_name;
                    td3.innerHTML = result.join_date;
                    td4.innerHTML = result.leave_balance;
                    td5.append(btnEdit);
                    td5.append(' ');
                    td5.append(btnDelete);

                    tr.append(td1);
                    tr.append(td2);
                    tr.append(td3);
                    tr.append(td4);
                    tr.append(td5);
                    tableBody.append(tr);
                });
                getButtons('btn-edit', 'btn-delete');
            }
        };
        request.send(keywords);
    }; document.getElementById('keywords').addEventListener('keyup', searchData);
    // end proses search data
</script>