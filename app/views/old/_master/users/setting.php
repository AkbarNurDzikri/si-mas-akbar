<div class="row">
    <div class="col-md-8 mx-auto">
        <div class="card mt-3">
            <div class="card-header">
                <h5>Edit Credentials</h5>
            </div>
            <div class="card-body">
                <form id="myForm">
                    <input type="hidden" name="id" id="input-user-id" value="<?= $_SESSION['userInfo']['id'] ?>">
                    <div class="row">
                        <div class="col-md mb-3">
                            <label for="input-username">Username</label>
                            <input type="text" class="form-control" id="input-username" name="username" value="<?= $_SESSION['userInfo']['username'] ?>" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3" id="row-input-password">
                            <label for="input-password">Password</label>
                            <input type="password" class="form-control" id="input-password" name="password" placeholder="Exist Password">
                        </div>
                    </div>
                    <div class="row" id="row-new-passw" style="display: none;">
                        <div class="col-md mb-3">
                            <label for="input-new-password">New Password</label>
                            <input type="password" class="form-control" id="input-new-password" name="new_password" placeholder="New Password">
                        </div>
                    </div>
                    <div class="row" id="row-confirm-passw" style="display: none;">
                        <div class="col-md mb-3">
                            <label for="input-confirm-password">Confirm New Password</label>
                            <input type="password" class="form-control" id="input-confirm-password" placeholder="Confirm New Password">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3 mx-auto">
                            <input class="form-check-input" type="checkbox" id="showPassw">
                            <label class="form-check-label" for="showPassw">
                                Show Password
                            </label>
                        </div>
                    </div>
                    <div class="row" id="row-btn-check-password">
                        <div class="col-md-3 mb-3 mx-auto">
                            <button type="button" class="btn btn-primary" id="btnCheckPassw">Check Password</button>
                        </div>
                    </div>
                    <div class="row" id="row-btn-change-password"  style="display: none;">
                        <div class="col-md text-center">
                            <button type="button" class="btn btn-primary" id="btnChangePassw">Change Password</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
    let userId = document.getElementById('input-user-id');
    let existPassw = document.getElementById('input-password');
    let newPassw = document.getElementById('input-new-password');
    let confirmPassw = document.getElementById('input-confirm-password');
    let checkBox = document.getElementById('showPassw');
    checkBox.addEventListener('click', () => {
        if(checkBox.checked == false) {
            existPassw.setAttribute('type', 'password');
            newPassw.setAttribute('type', 'password');
            confirmPassw.setAttribute('type', 'password');
        } else {
            existPassw.setAttribute('type', 'text');
            newPassw.setAttribute('type', 'text');
            confirmPassw.setAttribute('type', 'text');
        }
    });

    let rowBtnCheckPassw = document.getElementById('row-btn-check-password');
    let btnCheckPassw = document.getElementById('btnCheckPassw');
    let username = document.getElementById('input-username');
    let rowExistPassw = document.getElementById('row-input-password');
    let rowNewPassw = document.getElementById('row-new-passw');
    let rowConfirmPassw = document.getElementById('row-confirm-passw');
    let rowBtnChangePassw = document.getElementById('row-btn-change-password');
    const checkExistPassw = () => {
        let formData = 'username=' + <?= "'" . $_SESSION['userInfo']['username'] . "'" ?> + '&password=' + existPassw.value;
        let request = new XMLHttpRequest();
        request.open('POST', '<?= BASEURL ?>/auth/checkPassw');
        request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        request.onreadystatechange = () => {
            if(request.readyState == 4 && request.status == 200)  {
                let results = request.responseText;
                if(results == 1) {
                    Swal.fire({
                        icon: 'success',
                        title: 'Password dikenal. Lanjutkan proses edit username / password Anda',
                        showConfirmButton: false,
                        timer: 3000
                    })

                    setTimeout(() => {
                        username.readOnly = false;
                        rowNewPassw.style.display = 'block';
                        rowConfirmPassw.style.display = 'block';
                        rowBtnCheckPassw.style.display = 'none';
                        rowBtnChangePassw.style.display = 'block';
                        rowExistPassw.style.display = 'none';
                    }, 3000)
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Password tidak dikenal !',
                        showConfirmButton: false,
                        timer: 1500
                    })

                    setTimeout(() => {
                        username.readOnly = true;
                        rowNewPassw.style.display = 'none';
                        rowConfirmPassw.style.display = 'none';
                        rowBtnCheckPassw.style.display = 'block';
                        rowBtnChangePassw.style.display = 'none';
                        rowExistPassw.style.display = 'block';
                    }, 1500);
                }
            }
        };
        request.send(formData)
    }; btnCheckPassw.addEventListener('click', checkExistPassw);

    let btnChangePassw = document.getElementById('btnChangePassw');
    btnChangePassw.addEventListener('click', () => {
        if(newPassw.value == '') {
            Swal.fire({
                icon: 'error',
                title: 'Password baru tidak boleh kosong !',
                showConfirmButton: true
            })
        } else if(confirmPassw.value == newPassw.value) {
            let formData = 'id=' + userId.value + '&username=' + username.value + '&new_password=' + newPassw.value;
            let request = new XMLHttpRequest();
            request.open('POST', '<?= BASEURL ?>/auth/changeCredentials');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.onreadystatechange = () => {
                if(request.readyState == 4 && request.status == 200) {
                    let results = JSON.parse(request.responseText);
                    if(results.result > 0) {
                        Swal.fire({
                            icon: 'success',
                            title: results.message,
                            text: 'Silahkan login kembali',
                            showConfirmButton: false,
                            timer: 3000
                        })

                        setTimeout(() => {
                            window.location.href = '<?= BASEURL ?>';
                        }, 3000);
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: results.message,
                            showConfirmButton: true
                        })
                    }
                }
            };
            request.send(formData);
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Konfirmasi password tidak sesuai !',
                showConfirmButton: true
            })
        }
    });
</script>