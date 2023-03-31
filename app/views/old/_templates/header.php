<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="<?= BASEURL ?>/assets/img/logo/logo-bfi.png">
    <title>E-Cuti | <?= $data['title'] ?></title>
    
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/main/app.css">
    <link rel="stylesheet" href="<?= BASEURL; ?>/assets/css/main/app-dark.css">
    <script src="<?= BASEURL; ?>/assets/jquery/jquery-3.6.1.min.js"></script>
    <link rel="stylesheet" href="<?= BASEURL ?>/assets/package/dist/sweetalert2.min.css">
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href=""><img src="<?= BASEURL; ?>/assets/img/logo/logo-bfi.png" alt="Logo" srcset="" style="width: 50px; height: 50px;"><br><!--<span style="font-size: 22px;">E-Cuti BFI</span>--></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21"><g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"><path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path><g transform="translate(-210 -1)"><path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path><circle cx="220.5" cy="11.5" r="4"></circle><path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path></g></g></svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" >
                                <label class="form-check-label" ></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path></svg>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">
                            <!-- Logged in as : </br> -->
                            <?php echo(isset($_SESSION['userInfo']) ? '<h5>' . $_SESSION['userInfo']['emp_name'] . '</h5>' : 'Anonym') ?>
                            <i class="bi bi-award"></i> <?php echo(isset($_SESSION['userInfo']) ? '<b>' . $_SESSION['userInfo']['dept_name'] . ' - ' . $_SESSION['userInfo']['position_name'] .'</b>' : 'Anonym') ?>
                        </li>
                        <hr>

                        <li
                            class="sidebar-item <?= $data['title'] == 'Dashboard' ? 'active' : ''; ?>">
                            <a href="<?= BASEURL; ?>/dashboard" class='sidebar-link'>
                                <i class="bi bi-speedometer2"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <li class='sidebar-item has-sub 
                            <?= $data['title'] == 'Cuti Saya' ? 'active' : ''; ?>
                            <?= $data['title'] == 'Cuti Karyawan' ? 'active' : ''; ?>
                            <?= $data['title'] == 'Saldo Cuti Karyawan' ? 'active' : ''; ?>
                        
                        '>
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-cup-hot-fill"></i>
                                <span>Cuti</span>
                            </a>
                            <ul class='submenu 
                                <?= $data['title'] == 'Cuti Saya' ? 'active' : ''; ?>
                                <?= $data['title'] == 'Cuti Karyawan' ? 'active' : ''; ?>
                                <?= $data['title'] == 'Saldo Cuti Karyawan' ? 'active' : ''; ?>
                            '>
                                <li class='submenu-item <?= $data['title'] == 'Cuti Saya' ? 'active' : ''; ?>'><a href='<?= BASEURL; ?>/leave'>Cuti Saya</a></li>
                                <?php $userLevel = $_SESSION['userInfo']['position_name']; ?>
                                <?php $userDept = $_SESSION['userInfo']['dept_name']; ?>
                                <?php if($userLevel == 'Leader' || $userLevel == 'Supervisor' || $userLevel == 'Factory Manager' || $userLevel == 'General Manager' || ($userLevel == 'Staff' && $userDept == 'HR/GA') || ($userLevel == 'Admin' && $userDept == 'System')) : ?>
                                    <li class='submenu-item <?= $data['title'] == 'Cuti Karyawan' ? 'active' : ''; ?>'><a href='<?= BASEURL; ?>/leave/cutiKaryawan'>Cuti Karyawan</a></li>
                                <?php endif; ?>
                                <?php if($userLevel == 'Factory Manager' || $userLevel == 'General Manager' || ($userLevel == 'Staff' && $userDept == 'HR/GA') || ($userLevel == 'Admin' && $userDept == 'System')) : ?>
                                    <li class='submenu-item <?= $data['title'] == 'Saldo Cuti Karyawan' ? 'active' : ''; ?>'><a href='<?= BASEURL; ?>/leave/saldoCutiKaryawan'>Saldo Cuti Karyawan</a></li>
                                <?php endif; ?>
                            </ul>
                        </li>

                        <?php if(($userLevel == 'Admin' && $userDept == 'System') || ($userLevel == 'Staff' && $userDept == 'HR/GA')) : ?>
                            <li class='sidebar-item has-sub 
                                <?= $data['title'] == 'Master Employees' ? 'active' : ''; ?>
                                <?= $data['title'] == 'Master Departments' ? 'active' : ''; ?>
                                <?= $data['title'] == 'Master Users' ? 'active' : ''; ?>
                                <?= $data['title'] == 'Master Positions' ? 'active' : ''; ?>
                                <?= $data['title'] == 'Master Status' ? 'active' : ''; ?>
                            
                            '>
                                <a href="#" class='sidebar-link'>
                                    <i class="bi bi-ui-checks"></i>
                                    <span>Master Data</span>
                                </a>
                                <ul class='submenu 
                                    <?= $data['title'] == 'Master Employees' ? 'active' : ''; ?>
                                    <?= $data['title'] == 'Master Departments' ? 'active' : ''; ?>
                                    <?= $data['title'] == 'Master Users' ? 'active' : ''; ?>
                                    <?= $data['title'] == 'Master Positions' ? 'active' : ''; ?>
                                    <?= $data['title'] == 'Master Status' ? 'active' : ''; ?>
                                '>
                                    <li class='submenu-item <?= $data['title'] == 'Master Employees' ? 'active' : ''; ?>'><a href='<?= BASEURL; ?>/employees'>Master Employees</a></li>
                                    <li class='submenu-item <?= $data['title'] == 'Master Departments' ? 'active' : ''; ?>'><a href='<?= BASEURL; ?>/depts'>Master Depts</a></li>
                                    <li class='submenu-item <?= $data['title'] == 'Master Users' ? 'active' : ''; ?>'><a href='<?= BASEURL; ?>/users'>Master Users</a></li>
                                    <li class='submenu-item <?= $data['title'] == 'Master Positions' ? 'active' : ''; ?>'><a href='<?= BASEURL; ?>/positions'>Master Positions</a></li>
                                    <li class='submenu-item <?= $data['title'] == 'Master Status' ? 'active' : ''; ?>'><a href='<?= BASEURL; ?>/status'>Master Status</a></li>
                                </ul>
                            </li>
                        <?php endif; ?>

                        <li
                            class="sidebar-item <?= $data['title'] == 'User Setting' ? 'active' : ''; ?>">
                            <a href="<?= BASEURL; ?>/auth/setting" class='sidebar-link'>
                                <i class="bi bi-gear"></i>
                                <span>Setting</span>
                            </a>
                        </li>

                        <li
                            class="sidebar-item">
                            <a href="#" class='sidebar-link' data-bs-toggle="modal" data-bs-target="#modalLogout">
                                <i class="bi bi-box-arrow-left"></i>
                                <span>Logout</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
            <div id="main">
                <header class="mb-3">
                    <a href="#" class="burger-btn d-block d-xl-none">
                        <i class="bi bi-justify fs-3"></i>
                    </a>
                </header>
                <div class="row">
                    <div class="col-md">
                        <h3><?= $data['title'] ?></h3>
                        <hr>
                    </div>
                </div>
                <div role="alert" style="display: none;" id="alertBoots">
                    <p id="alertMsg"></p>
                </div>