<div class="col-md mb-3">
    <button class="btn btn-primary" id="btnModalCreate" data-bs-toggle="modal" data-bs-target="#modal"><i class="bi bi-plus-square-dotted"></i></button>
</div>
<div class="card mt-3">
    <!-- <div class="card-header">
        <div class="row">
            <div class="col-md">
                <input type="text" class="form-control" id="keywords" name="keywords" placeholder="Type here for search">
            </div>
        </div>
    </div> -->
    <div class="card-body">
        <div class="row">
            <div class="col-md">
                <div class="table-responsive">
                    <table class="table caption-top table-hover">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Employee Name</th>
                                <th>Publish Date</th>
                                <th>Leave Type</th>
                                <th>Leave Reason</th>
                                <th>Leave Evidence</th>
                                <th>Start Date</th>
                                <th>End Date Date</th>
                                <th>Number of Days</th>
                                <th>Reason Rejected</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1; ?>
                            <?php foreach($data['myLeave'] as $myLeave) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $myLeave['emp_name'] ?></td>
                                    <td><?= date('l, d-M-Y h:i:s', strtotime($myLeave['created_at'])) . ' WIB' ?></td>
                                    <td><?= $myLeave['leave_type'] ?></td>
                                    <td><?= $myLeave['leave_reason'] ?></td>
                                    <td data-bs-toggle="modal" data-bs-target="#modalEvidences<?= $myLeave['id'] ?>" style="cursor: pointer;">
                                        <?php if( $myLeave['leave_evidence'] ) : ?>
                                            <img src="<?= BASEURL. '/assets/img/leave_evidences/' . $myLeave['leave_evidence'] ?>" alt="Leave Evidence" style="height: 25px; width: 25px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('l, d-M-Y', strtotime($myLeave['start_date'])) ?></td>
                                    <td><?= date('l, d-M-Y', strtotime($myLeave['end_date'])) ?></td>
                                    <td>
                                        <?php
                                            if($myLeave['number_of_day'] == 0) {
                                                $startDate = date_create($myLeave['start_date']);
                                                $endDate = date_create($myLeave['end_date']);
                                                $diffDay = date_diff($startDate, $endDate);
                                                $fixedDiffDay =  $diffDay->days + 1;
                                                echo $fixedDiffDay == 1 ? $fixedDiffDay . ' Day' : $fixedDiffDay . ' Days';
                                            } else {
                                                echo $myLeave['number_of_day'] == 1 ? $myLeave['number_of_day'] . ' Day' : $myLeave['number_of_day'] . ' Days';
                                            }
                                        ?>
                                    </td>
                                    <td><?= $myLeave['reason_rejected'] ?></td>
                                    <td>
                                        <?php
                                            if($myLeave['sign_to'] == NULL && $myLeave['status'] == 'Approved') {
                                                echo '<span"><i class="bi bi-check2-all text-success" style="font-size: 1.5rem;"></i> by ' . $myLeave['approved_by'] . ' @ ' . date('d-M-Y h:i:s', strtotime($myLeave['updated_at'])) . ' WIB' . '</span>';
                                            } else if($myLeave['sign_to'] == NULL && $myLeave['status'] == 'Rejected') {
                                                echo '<span><i class="bi bi-x-lg text-danger" style="font-size: 1.5rem;"></i> by ' . $myLeave['approved_by'] . '</span>';
                                            } else {
                                                echo '<i class="bi bi-hourglass-split text-primary" style="font-size: 1.5rem;"></i> ' . $myLeave['target_approval'];
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($myLeave['sign_to'] != NULL ) : ?> <!-- nilai NULL pada column sign_to di database == approval sudah sampai HRD atau di reject oleh atasan (siapapun) -->
                                            <button type="button" class="btn btn-outline-primary btn-sm mb-1 btn-edit" data-bs-toggle="modal" data-bs-target="#modal" data-id="<?= $myLeave['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-outline-danger btn-sm d-inline btn-delete" data-id="<?= $myLeave['id'] ?>"><i class="bi bi-trash3"></i></button>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="modalLabel">Modal title</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="myForm" method="POST" enctype="multipart/form-data">
                <div class="modal-body">
                    <input type="hidden" id="input-leave-id" name="id"> <!-- id ini sengaja disediakan untuk menampung nilai id saat proses edit, meskipun saat proses create tidak berisi nilai apapun krn auto_increment di database -->
                    <input type="hidden" id="input-emp-id" name="emp_id" value="<?= $_SESSION['userInfo']['emp_id'] ?>">
                    <input type="hidden" class="form-control" id="input-status" name="status" value="Approved"> <!-- value di set default Approved agar tidak terlalu banyak item enum di database -->
                    <div class="row">
                        <div class="col-md mb-3" id="col-input-leave-type">
                            <label for="input-leave-type" class="form-label">Leave Type</label>
                            <select name="leave_type" id="input-leave-type" class="form-select">
                                <option value="Annual Leave">Annual Leave</option>
                                <option value="Special Leave">Special Leave</option>
                            </select>
                        </div>
                        <div class="col-md mb-3" id="col-input-leave-type-edit" style="display: none;">
                            <label for="input-leave-type-edit" class="form-label">Leave Type</label>
                            <input type="text" class="form-control" name="leave_type_edit" id="input-leave-type-edit" readonly>
                        </div>
                        <div class="col-md mb-3">
                            <label for="input-leave-balance" class="form-label">Annual Leave Balance</label>
                            <input type="number" class="form-control" id="input-leave-balance" name="leave_balance" readonly>
                        </div>
                    </div>
                    <div class="row" id="row-leave-evidence" style="display: none;">
                        <div class="col-md mb-3">
                            <label for="input-leave-evidence" class="form-label">Leave Evidence</label>
                            <input type="file" class="form-control" id="input-leave-evidence" name="leave_evidence">
                            <input type="hidden" name="leave_evidence_old" id="input-leave-evidence-old">
                            <span id="span-leave-evidence-old" class="mt-3" style="display: none;"><img id="img-leave-evidence-old" alt="Leave Evidence Old" style="width: 50px; height: 50px;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3">
                            <label for="input-leave-reason" class="form-label">Leave Reason</label>
                            <textarea name="leave_reason" id="input-leave-reason" class="form-control" placeholder="Brief Description ..."></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="input-start-date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="input-start-date" name="start_date">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-end-date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="input-end-date" name="end_date">
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-number-of-day" class="form-label">Number of Days</label>
                            <input type="int" class="form-control" id="input-number-of-day" name="number_of_day" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3" id="col-input-has-halfDay">
                            <input type="hidden" name="has_halfday" id="input-has-halfDay">
                            <input class="form-check-input" type="checkbox" id="checkBox-halfDay"> <br>
                            <label class="form-check-label" for="checkBox-halfDay">Has Half Day</label>
                        </div>
                        <div class="col-md-4 mb-3" id="col-input-has-holidays">
                            <input type="hidden" name="has_holidays" id="input-has-holidays">
                            <input class="form-check-input" type="checkbox" id="checkBox-holidays"> <br>
                            <label class="form-check-label" for="checkBox-holidays">Has Holidays</label>
                        </div>
                        <div class="col-md-4 mb-3" style="display: none;" id="col-number-of-holidays">
                            <input type="number" class="form-control" id="input-number-of-holidays" placeholder="Number of Holidays">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md">
                            <?php
                                $approval = '';
                                $userLevel = $_SESSION['userInfo']['position_name'];
                                switch($userLevel) {
                                    case 'Leader' :
                                        $approval = 'Supervisor';
                                        break;
                                    case 'Supervisor' :
                                        $approval = 'Factory Manager';
                                        break;
                                    case 'Factory Manager' :
                                        $approval = 'Manager';
                                        break;
                                    case 'Manager' :
                                        $approval = 'HR/GA';
                                        break;
                                    case 'Staff' :
                                        $approval = 'Factory Manager';
                                        break;
                                    default :
                                        $approval = 'Leader';
                                }
                            ?>
                            <label for="input-sign-to" class="form-label">Approval <?= $approval ?></label>
                            <select class="form-select" name="sign_to" id="input-sign-to">
                                <option value="" disabled selected>Choose Approval</option>
                                <?php foreach($data['getAtasan'] as $atasan) : ?>
                                    <option value="<?= $atasan['atasan_id'] ?>"><?= $atasan['atasan_name'] ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary" id="btnModalSubmit">Submit</button>
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Modal Leave Evidences -->
<?php foreach($data['myLeave'] as $myLeave) : ?>
    <div class="modal fade" id="modalEvidences<?= $myLeave['id'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel">Leave Evidence <?= date('d-M-Y h:i:s', strtotime($myLeave['created_at'])) . " WIB" ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="<?= BASEURL . '/assets/img/leave_evidences/' . $myLeave['leave_evidence'] ?>" alt="Leave Evidence tidak terdeteksi !" style="width: 100%; height: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    const topupCuti = () => { // CHECKED
        let joinDate = new Date(<?= "'".$_SESSION['userInfo']['join_date']."'" ?>);
        let dateNow = new Date();
        const oneDay = 1000 * 60 * 60 * 24;
        let membershipPeriod = Math.round((dateNow - joinDate) / oneDay);
        const userId = <?= "'".$_SESSION['userInfo']['emp_id']."'" ?>;
        let leaveTopupCurrentYear = <?= "'".$data['getLeaveTopup']['topup_current_year']."'" ?>;
        let currentYear = new Date().getFullYear();

        if(leaveTopupCurrentYear == '' && membershipPeriod >= 365) {
            let request = new XMLHttpRequest();
            request.open('POST', '<?= BASEURL ?>/leave/topupCuti');
            request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            request.onreadystatechange = () => {
                if(request.readyState == 4 && request.status == 200) {
                    let results = JSON.parse(request.responseText);
                    Swal.fire({
                        icon: results.icon,
                        title: results.title,
                        text: results.text
                    }).then(function() {
                        window.location = '<?= BASEURL ?>' + '/leave';
                    });
                }
            };
            request.send('emp_id=' + userId + '&number_of_day=' + 12 + '&remarks=' + 'Topup annual leave' + '&year_stamp=' + currentYear);
        }
    }; topupCuti();

    // modal variables
    let btnModalCreate = document.getElementById('btnModalCreate');
    let modalLabel = document.getElementById('modalLabel');
    let btnModalSubmit = document.getElementById('btnModalSubmit');
    
    // form data variables
    let myForm = document.getElementById('myForm');
    let inputLeaveId = document.getElementById('input-leave-id');
    let inputEmpId = document.getElementById('input-emp-id');
    let inputLeaveType = document.getElementById('input-leave-type');
    let inputLeaveTypeEdit = document.getElementById('input-leave-type-edit');
    let inputLeaveBalance = document.getElementById('input-leave-balance');
    let inputLeaveEvidence = document.getElementById('input-leave-evidence');
    let inputLeaveEvidenceOld = document.getElementById('input-leave-evidence-old');
    let inputLeaveReason = document.getElementById('input-leave-reason');
    let inputStartDate = document.getElementById('input-start-date');
    let inputEndDate = document.getElementById('input-end-date');
    let inputNumberOfDay = document.getElementById('input-number-of-day');
    let inputStatus = document.getElementById('input-status');
    let checkBoxHalfDay = document.getElementById('checkBox-halfDay');
    let checkBoxHolidays = document.getElementById('checkBox-holidays');
    let inputNumberOfHolidays = document.getElementById('input-number-of-holidays');
    let inputSignTo = document.getElementById('input-sign-to');
    let inputHasHalfDay = document.getElementById('input-has-halfDay');
    let inputHasHolidays = document.getElementById('input-has-holidays');
    let spanImgLeaveEvidence = document.getElementById('span-leave-evidence-old');
    let imgLeaveEvidence = document.getElementById('img-leave-evidence-old');

    // row input variable
    let rowLeaveEvidence = document.getElementById('row-leave-evidence');

    // col input variable
    let colNumberOfHolidays = document.getElementById('col-number-of-holidays');
    let colInputLeaveType = document.getElementById('col-input-leave-type');
    let colInputLeaveTypeEdit = document.getElementById('col-input-leave-type-edit');
    let colInputHasHolidays = document.getElementById('col-input-has-holidays');
    let colInputHasHalfday = document.getElementById('col-input-has-halfDay');

    const clearForm = () => { // CHECKED
        inputLeaveType.value = 'Annual Leave';
        rowLeaveEvidence.style.display = 'none';
        spanImgLeaveEvidence.style.display = 'none';
        inputLeaveEvidence.value = '';
        inputLeaveReason.value = '';
        inputStartDate.value = '';
        inputEndDate.value = '';
        inputNumberOfDay.value = '';
        checkBoxHalfDay.checked = false;
        checkBoxHolidays.checked = false;
        inputNumberOfHolidays.value = '';
        inputSignTo.value = '';
    };

    const selectLeaveType = () => { // CHECKED
        if(inputLeaveType.value == 'Annual Leave') {
            rowLeaveEvidence.style.display = 'none';
            btnModalSubmit.disabled = false;
            colInputHasHalfday.style.display = 'block';
            colInputHasHolidays.style.display = 'block';
            inputLeaveBalance.value = <?= $data['getLeaveBalance']['leave_balance'] ?>;
        } else {
            rowLeaveEvidence.style.display = 'block';
            btnModalSubmit.disabled = false;
            colInputHasHalfday.style.display = 'none';
            colInputHasHolidays.style.display = 'none';
            inputLeaveBalance.value = 12;
        }
    }; inputLeaveType.addEventListener('change', selectLeaveType)

    btnModalCreate.addEventListener('click', () => { // CHECKED
        inputLeaveType.disabled = false;
        inputLeaveType.setAttribute('name', 'leave_type');
        colInputLeaveType.style.display = 'block';
        colInputLeaveTypeEdit.style.display = 'none';
        modalLabel.innerHTML = 'Permohonan Cuti';
        inputLeaveBalance.value = <?= $data['getLeaveBalance']['leave_balance'] ?>;
        colInputHasHalfday.style.display = 'block';
            colInputHasHolidays.style.display = 'block';
        btnModalSubmit.innerHTML = 'Submit';
        btnModalSubmit.style.display = 'block';
        clearForm();
        myForm.setAttribute('action', '<?= BASEURL ?>/leave/prosesCuti');
    });

    inputLeaveEvidence.addEventListener('click', () => btnModalSubmit.disabled = false);
    inputLeaveReason.addEventListener('keyup', () => btnModalSubmit.disabled = false);
    inputStartDate.addEventListener('change', () => btnModalSubmit.disabled = false);
    inputEndDate.addEventListener('change', () => btnModalSubmit.disabled = false);
    inputSignTo.addEventListener('change', () => btnModalSubmit.disabled = false);

    const countNumberOfDay = () => { // CHECKED
        checkBoxHalfDay.checked = false;
        checkBoxHolidays.checked = false;
        colNumberOfHolidays.style.display = 'none';
        inputNumberOfHolidays.value = '';

        const oneDay = 1000 * 60 * 60 * 24; // milisecond * detik * menit  * jam
        let firstDate = new Date(inputStartDate.value);
        let secondDate = new Date(inputEndDate.value);
        // let diffDays = Math.round(Math.abs((firstDate - secondDate) / oneDay));
        // let diffDays = Math.round((secondDate - firstDate) / oneDay);
        let diffDays = (secondDate - firstDate) / oneDay;
        inputNumberOfDay.value = diffDays + 1;
    }; inputStartDate.addEventListener('change', countNumberOfDay); inputEndDate.addEventListener('change', countNumberOfDay);

    checkBoxHalfDay.addEventListener('click', () => { // CHECKED
        const oneDay = 1000 * 60 * 60 * 24;
        let firstDate = new Date(inputStartDate.value);
        let secondDate = new Date(inputEndDate.value);
        let diffDays = (secondDate - firstDate) / oneDay;

        if(checkBoxHalfDay.checked == true) {
            if(checkBoxHolidays.checked == true) {
                inputNumberOfDay.value = (diffDays + 1) - 0.5 - inputNumberOfHolidays.value;
            } else {
                inputNumberOfDay.value = (diffDays + 1) - 0.5;
            }
        } else {
            if(checkBoxHolidays.checked == true) {
                inputNumberOfDay.value = (diffDays + 1) - inputNumberOfHolidays.value;
            } else {
                inputNumberOfDay.value = (diffDays + 1);
            }
        }
        btnModalSubmit.disabled = false;
    });

    checkBoxHolidays.addEventListener('click', () => { // CHECKED
        const oneDay = 1000 * 60 * 60 * 24;
        let firstDate = new Date(inputStartDate.value);
        let secondDate = new Date(inputEndDate.value);
        let diffDays = (secondDate - firstDate) / oneDay;

        if(checkBoxHolidays.checked == true) {
            colNumberOfHolidays.style.display = 'block';
            if(checkBoxHalfDay.checked == true) {
                inputNumberOfDay.value = (diffDays + 1) - 0.5 - inputNumberOfHolidays.value;
            } else {
                inputNumberOfDay.value = (diffDays + 1) - inputNumberOfHolidays.value;
            }
        } else {
            colNumberOfHolidays.style.display = 'none';
            if(checkBoxHalfDay.checked == true) {
                inputNumberOfDay.value = (diffDays + 1) - 0.5;
            } else {
                inputNumberOfDay.value = (diffDays + 1);
            }
        }
        btnModalSubmit.disabled = false;
    });

    inputNumberOfHolidays.addEventListener('keyup', () => { // CHECKED
        const oneDay = 1000 * 60 * 60 * 24;
        let firstDate = new Date(inputStartDate.value);
        let secondDate = new Date(inputEndDate.value);
        let diffDays = (secondDate - firstDate) / oneDay;

        if(inputNumberOfHolidays.value > 0) {
            if(checkBoxHalfDay.checked == true) {
                inputNumberOfDay.value = (diffDays + 1) - 0.5 - inputNumberOfHolidays.value;
            } else {
                inputNumberOfDay.value = (diffDays + 1) - inputNumberOfHolidays.value;
            }
        } else {
            if(checkBoxHalfDay.checked == true) {
                inputNumberOfDay.value = (diffDays + 1) - 0.5;
            } else {
                inputNumberOfDay.value = (diffDays + 1);
            }
        }
    });

    const prosesCuti = (e) => { // CHECKED
        e.preventDefault();
        
        if(inputLeaveType.value == 'Annual Leave') {
            if(inputLeaveReason.value == '') {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Leave reason required !',
                    showConfirmButton: true
                });
            } else if(inputStartDate.value == '') {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Start date required !',
                    showConfirmButton: true
                });
            } else if(inputEndDate.value == '') {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'End date required !',
                    showConfirmButton: true
                });
            } else if(inputNumberOfDay.value <= 0) {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid date range !',
                    text: 'Number of Days tidak boleh kurang dari 1 !',
                    showConfirmButton: true
                });
            } else if(Number(inputNumberOfDay.value) > Number(inputLeaveBalance.value)) {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Too many days off',
                    text: 'Saldo cuti Anda tidak cukup !',
                    showConfirmButton: true
                });
            } else if(inputSignTo.value == '') {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Approval required !',
                    text: 'Silahkan pilih atasan Anda',
                    showConfirmButton: true
                });
            } else {
                checkBoxHalfDay.checked == true ? inputHasHalfDay.value = 1 : 0;
                checkBoxHolidays.checked == true ? inputHasHolidays.value = inputNumberOfHolidays.value : 0;
                myForm.submit();
            }
        } else if(inputLeaveType.value == 'Special Leave') {
            if(inputLeaveEvidence.value == '') {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Leave evidence required !',
                    text: 'Silahkan lampirkan bukti Cuti Khusus Anda !',
                    showConfirmButton: true
                });
            } else if(inputLeaveReason.value == '') {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Leave reason required !',
                    showConfirmButton: true
                });
            } else if(inputStartDate.value == '') {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Start date required !',
                    showConfirmButton: true
                });
            } else if(inputEndDate.value == '') {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'End date required !',
                    showConfirmButton: true
                });
            } else if(inputNumberOfDay.value <= 0) {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Invalid date range !',
                    text: 'Number of Days tidak boleh kurang dari 1 !',
                    showConfirmButton: true
                });
            } else if(Number(inputNumberOfDay.value) > Number(inputLeaveBalance.value)) {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Too many days off',
                    text: 'Saldo cuti Anda tidak cukup !',
                    showConfirmButton: true
                });
            } else if(inputSignTo.value == '') {
                btnModalSubmit.disabled = true;
                Swal.fire({
                    icon: 'error',
                    title: 'Approval required !',
                    text: 'Silahkan pilih atasan Anda',
                    showConfirmButton: true
                });
            } else {
                checkBoxHalfDay.checked == true ? inputHasHalfDay.value = 1 : 0;
                checkBoxHolidays.checked == true ? inputHasHolidays.value = inputNumberOfHolidays.value : 0;
                myForm.submit();
            }
        }
    }; btnModalSubmit.addEventListener('click', prosesCuti);

    let btnEdit = document.getElementsByClassName('btn-edit');
    if(btnEdit) {
        for(let i = 0; i < btnEdit.length; i++) {
            btnEdit[i].addEventListener('click', () => {
                myForm.setAttribute('action', '<?= BASEURL ?>/leave/update');
                modalLabel.innerHTML = 'Edit Permohonan Cuti';
                btnModalSubmit.innerHTML = 'Update';
                btnModalSubmit.disabled = false;
                inputLeaveType.removeAttribute('name');
                
                let request = new XMLHttpRequest();
                request.open('POST', '<?= BASEURL ?>/leave/getEdit');
                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                request.onreadystatechange = () => {
                    if(request.readyState == 4 && request.status == 200) {
                        let results = JSON.parse(request.responseText);
                        let leaveBalance = <?= $data['getLeaveBalance']['leave_balance'] ?>;
                        let leaveBalanceRefund = Number(leaveBalance) + Number(results.number_of_day); // saldo dikembalikan dahulu agar jika qty cuti yang diupdate > qty cuti sebelumnya, saldo masih cukup dan bisa di proses
                        inputLeaveId.value = results.id;
                        inputEmpId.value = results.emp_id;
                        inputLeaveTypeEdit.value = results.leave_type;
                        colInputLeaveType.style.display = 'none';
                        colInputLeaveTypeEdit.style.display = 'block';
                        if(inputLeaveTypeEdit.value == 'Annual Leave') {
                            inputLeaveBalance.value = leaveBalanceRefund;
                        } else {
                            inputLeaveBalance.value = leaveBalance;
                        }

                        if(results.leave_type == 'Special Leave') {
                            rowLeaveEvidence.style.display = 'block';
                            inputLeaveEvidenceOld.value = results.leave_evidence;
                            imgLeaveEvidence.setAttribute('src', '<?= BASEURL ?>/assets/img/leave_evidences/' + results.leave_evidence);
                            spanImgLeaveEvidence.style.display = 'block';
                            colInputHasHalfday.style.display = 'none';
                            colInputHasHolidays.style.display = 'none';
                        } else {
                            rowLeaveEvidence.style.display = 'none';
                            spanImgLeaveEvidence.style.display = 'none';
                            colInputHasHalfday.style.display = 'block';
                            colInputHasHolidays.style.display = 'block';
                        }
                        inputLeaveReason.value = results.leave_reason;
                        inputStartDate.value = results.start_date;
                        inputEndDate.value = results.end_date;
                        inputNumberOfDay.value = results.number_of_day;
                        results.has_halfday == 1 ? checkBoxHalfDay.checked = true : checkBoxHalfDay.checked = false;
                        results.has_holidays > 0 ? checkBoxHolidays.checked = true : checkBoxHolidays.checked = false;
                        results.has_holidays == 0 ? colNumberOfHolidays.style.display = 'none' : colNumberOfHolidays.style.display = 'block';
                        inputNumberOfHolidays.value = results.has_holidays;
                        inputSignTo.value = results.sign_to; // saat approval sudah melewati atasan langsung (approval pertama), option pada select tidak akan menampilkan nama atasan berikutnya. Karena jika ada perubahan setelah cuti di approve oleh (atasan pertama dan sebelum di approve HRD), proses approval harus sepengetahuan atasan pertama.
                    }
                };
                request.send('id=' + btnEdit[i].getAttribute('data-id'));
            });
        }
    }

    let btnDelete = document.getElementsByClassName('btn-delete');
    for(let i = 0; i< btnDelete.length; i++) {
        btnDelete[i].addEventListener('click', () => {
            
            if(confirm('Yakin hapus permohonan cuti ini?') == true) {
                let id = btnDelete[i].getAttribute('data-id');
                let request = new XMLHttpRequest();
                request.open('POST', '<?= BASEURL ?>/leave/destroy');
                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                request.onreadystatechange = () => {
                    if(request.readyState == 4 && request.status == 200) {
                        let results = JSON.parse(request.responseText);
                        Swal.fire({
                            icon: results.icon,
                            title: results.title,
                            text: results.text,
                            showConfirmButton: true
                        }).then(function() {
                            window.location = '<?= BASEURL ?>' + '/leave';
                        });;
                    }
                };
                request.send('id=' + id);
            } else {
                return false;
            }
            
        });
    }
</script>