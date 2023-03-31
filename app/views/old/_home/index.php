<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/home/login-style.css">
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/css/main/app.css">
  	<link rel="icon" href="<?= BASEURL ?>/assets/img/logo/logo-bfi.png">
    <title>E-Cuti Login</title>
</head>
<body>
    <div class="wrapper">
        <div class="logo">
            <img src="<?= BASEURL ?>/assets/img/logo/logo-bfi.png" alt="logo-bfi-img">
        </div>
        <div class="text-center mt-4 name">
            <marquee behavior="" direction="">Blasfolie Employee Information System</marquee>
        </div>
        <div class="alert alert-danger" role="alert" style="display: none;"><div class="fs-6">Username / Password tidak dikenal !</div></div>
        <form class="p-3 mt-3">
            <div class="form-field d-flex align-items-center">
                <span class="far fa-user"></span>
                <input type="text" name="username" id="username" placeholder="Username" autocomplete="off" autofocus>
            </div>
            <div class="form-field d-flex align-items-center">
                <span class="fas fa-key"></span>
                <input type="password" name="password" id="password" placeholder="Password">
            </div>
            <button type="button" class="btn mt-3" id="btnLogin">Login</button>
        </form>
        <div class="text-center fs-6">
            <input class="form-check-input" type="checkbox" id="showPassw">
            <label class="form-check-label" for="showPassw">Show Password</label>
        </div>
    </div>

    <script>
        let inputUsername = document.getElementById('username');
        let inputPassword = document.getElementById('password');
        let checkBox = document.getElementById('showPassw');
        let btnLogin = document.getElementById('btnLogin');
        let alert = document.getElementsByClassName('alert')[0];

        checkBox.addEventListener('click', () => {
            if(checkBox.checked == false) {
                inputPassword.setAttribute('type', 'password');
            } else {
                inputPassword.setAttribute('type', 'text');
            }
        });

        const loginProcess = () => {
            let formData = 'username=' + inputUsername.value + '&password=' + inputPassword.value;
            let request = new XMLHttpRequest();
            request.open('POST', '<?= BASEURL ?>/auth/index');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.onreadystatechange = () => {
                if(request.readyState == 4 && request.status == 200) {
                    let results = JSON.parse(request.responseText);
                    if(results.bool == 1) {
                        document.location.href = results.target_redirect;
                    } else {
                        alert.style.display = 'block';
                        setTimeout(() => {
                            alert.style.display = 'none';
                        }, 3000);
                    }
                }
            };
            request.send(formData);
        }; btnLogin.addEventListener('click', loginProcess);
    </script>
</body>
</html>