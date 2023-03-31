<div class="card mt-3">
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
                            <?php foreach($data['empLeave'] as $empLeave) : ?>
                                <tr>
                                    <td><?= $i++; ?></td>
                                    <td><?= $empLeave['emp_name'] ?></td>
                                    <td><?= date('l, d-M-Y h:i:s', strtotime($empLeave['created_at'])) . ' WIB' ?></td>
                                    <td><?= $empLeave['leave_type'] ?></td>
                                    <td><?= $empLeave['leave_reason'] ?></td>
                                    <td data-bs-toggle="modal" data-bs-target="#modalEvidences<?= $empLeave['id'] ?>" style="cursor: pointer;">
                                        <?php if( $empLeave['leave_evidence'] != '' ) : ?>
                                            <img src="<?= BASEURL. '/assets/img/leave_evidences/' . $empLeave['leave_evidence'] ?>" alt="Leave Evidence" style="height: 25px; width: 25px;">
                                        <?php endif; ?>
                                    </td>
                                    <td><?= date('l, d-M-Y', strtotime($empLeave['start_date'])) ?></td>
                                    <td><?= date('l, d-M-Y', strtotime($empLeave['end_date'])) ?></td>
                                    <td>
                                        <?php
                                            if($empLeave['number_of_day'] == 0) {
                                                $startDate = date_create($empLeave['start_date']);
                                                $endDate = date_create($empLeave['end_date']);
                                                $diffDay = date_diff($startDate, $endDate);
                                                $fixedDiffDay =  $diffDay->days + 1;
                                                echo $fixedDiffDay == 1 ? $fixedDiffDay . ' Day' : $fixedDiffDay . ' Days';
                                            } else {
                                                echo $empLeave['number_of_day'] == 1 ? $empLeave['number_of_day'] . ' Day' : $empLeave['number_of_day'] . ' Days';
                                            }
                                        ?>
                                    </td>
                                    <td><?= $empLeave['reason_rejected'] ?></td>
                                    <td>
                                        <?php
                                            if($empLeave['sign_to'] == NULL && $empLeave['status'] == 'Approved') {
                                                echo '<span"><i class="bi bi-check2-all text-success" style="font-size: 1.5rem;"></i> by ' . $empLeave['approved_by'] . '</span>';
                                            } else if($empLeave['sign_to'] == NULL && $empLeave['status'] == 'Rejected') {
                                                echo '<span><i class="bi bi-x-lg text-danger" style="font-size: 1.5rem;"></i> by ' . $empLeave['approved_by'] . '</span>';
                                            } else {
                                                echo '<i class="bi bi-hourglass-split text-primary" style="font-size: 1.5rem;"></i> ' . $empLeave['target_approval'];
                                            }
                                        ?>
                                    </td>
                                    <td>
                                        <?php if($empLeave['sign_to'] == $_SESSION['userInfo']['emp_id']) : ?>
                                            <button type="button" class="btn btn-outline-primary btn-sm mb-1 btn-edit" data-bs-toggle="modal" data-bs-target="#modal" data-id="<?= $empLeave['id'] ?>"><i class="bi bi-pencil-square"></i></button>
                                            <button type="button" class="btn btn-outline-danger btn-sm d-inline btn-delete" data-id="<?= $empLeave['id'] ?>"><i class="bi bi-trash3"></i></button>
                                        <?php elseif($_SESSION['userInfo']['dept_name'] == 'HR/GA' && $empLeave['status'] == 'Approved' && $empLeave['leave_type'] == 'Annual Leave') : ?> <!-- Jika leave type Special Leave ditampilkan juga, saldo cuti akan bertambah (yang seharusnya saldo cuti bertambah hanya jika Annual Leave yang dihapus) -->
                                            <button type="button" class="btn btn-outline-danger btn-sm d-inline btn-delete" data-id="<?= $empLeave['id'] ?>"><i class="bi bi-trash3"></i></button>
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
                    <input type="hidden" id="input-updated-by" name="updated_by">
                    <div class="row">
                        <div class="col-md mb-3">
                            <label for="input-leave-type" class="form-label">Leave Type</label>
                            <input name="leave_type" id="input-leave-type" class="form-control" readonly>
                        </div>
                    </div>
                    <div class="row" id="row-leave-evidence" style="display: none;">
                        <div class="col-md mb-3">
                            <label for="input-leave-evidence" class="form-label">Leave Evidence</label>
                            <!-- <input type="file" class="form-control" id="input-leave-evidence" name="leave_evidence"> -->
                            <input type="hidden" name="leave_evidence_old" id="input-leave-evidence-old">
                            <span id="span-leave-evidence-old" style="display: none;"><img id="img-leave-evidence-old" alt="Leave Evidence Old" style="width: 50px; height: 50px;"></span>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md mb-3">
                            <label for="input-leave-reason" class="form-label">Leave Reason</label>
                            <textarea name="leave_reason" id="input-leave-reason" class="form-control" placeholder="Brief Description ..." readonly></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="input-start-date" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="input-start-date" name="start_date" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-end-date" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="input-end-date" name="end_date" readonly>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="input-number-of-day" class="form-label">Number of Days</label>
                            <input type="int" class="form-control" id="input-number-of-day" name="number_of_day" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <input type="hidden" name="has_halfday" id="input-has-halfDay">
                            <input class="form-check-input" type="checkbox" id="checkBox-halfDay" disabled> <br>
                            <label class="form-check-label" for="checkBox-halfDay">Has Half Day</label>
                        </div>
                        <div class="col-md-4 mb-3">
                            <input type="hidden" name="has_holidays" id="input-has-holidays">
                            <input class="form-check-input" type="checkbox" id="checkBox-holidays" disabled> <br>
                            <label class="form-check-label" for="checkBox-holidays">Has Holidays</label>
                        </div>
                        <div class="col-md-4 mb-3" style="display: none;" id="col-number-of-holidays">
                            <input type="number" class="form-control" id="input-number-of-holidays" placeholder="Number of Holidays" readonly>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md mb-3">
                        <label class="form-label">Decision</label>
                            <select class="form-select mb-3" name="status" id="input-status">
                                    <option value="" disabled selected>Make a Decision</option>
                                    <option value="Approved" >Approve</option>
                                    <option value="Rejected" >Reject</option>
                            </select>
                        </div>
                    </div>

                    <div class="row" id="row-reason-rejected" style="display: none;">
                        <div class="col-md mb-3">
                            <label for="input-reason-rejected" class="form-">Reason Rejected</label>
                            <textarea class="form-control" name="reason_rejected" id="input-reason-rejected" placeholder="Jelaskan alasan singkat Anda me-reject cuti Karyawan"></textarea>
                        </div>
                    </div>

                    <div class="row" id="row-input-sign-to" style="display: none;">
                        <div class="col-md">
                            <?php
                                $nextApproval = '';
                                $userLevel = $_SESSION['userInfo']['position_name'];
                                $userDept = $_SESSION['userInfo']['dept_name'];
                                if($userLevel == 'Leader') {
                                    $nextApproval = 'Supervisor';
                                } else if($userLevel == 'Supervisor' || $userLevel == 'Staff' && $userDept != 'HR/GA' ) {
                                    $nextApproval = 'Factory Manager';
                                } else if($userLevel == 'Factory Manager') {
                                    $nextApproval = 'General Manager';
                                } else if($userLevel == 'General Manager') {
                                    $nextApproval = 'HR/GA';
                                } else if($userLevel == 'Staff' && $userDept == 'HR/GA') {
                                    $nextApproval = 'HR/GA';
                                } else {
                                    $nextApproval = 'Leader';
                                }
                            ?>
                            
                            <?php if( $userDept != 'HR/GA' ) : ?> <!-- di set seperti ini karena HR/GA adalah approval terakhir, tidak perlu meneruskan approval lagi -->
                                <label for="input-sign-to" class="form-label">Next Approval (<?= $nextApproval ?>)</label>
                                <select class="form-select" name="sign_to" id="input-sign-to">
                                    <option value="" disabled selected>Choose <?= $nextApproval ?></option>
                                    <?php foreach($data['getAtasan'] as $atasan) : ?>
                                        <option value="<?= $atasan['atasan_id'] ?>"><?= $atasan['atasan_name'] ?></option>
                                    <?php endforeach; ?>
                                </select>
                            <?php endif; ?>
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
<?php foreach($data['empLeave'] as $empLeave) : ?>
    <div class="modal fade" id="modalEvidences<?= $empLeave['id'] ?>" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="modalLabel">Leave Evidence <?= date('d-M-Y h:i:s', strtotime($empLeave['created_at'])) . " WIB" ?></h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <img src="<?= BASEURL . '/assets/img/leave_evidences/' . $empLeave['leave_evidence'] ?>" alt="Leave Evidence tidak terdeteksi !" style="width: 100%; height: 100%;">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="btnClose">Close</button>
                </div>
            </div>
        </div>
    </div>
<?php endforeach; ?>

<script>
    // modal variables
    let modalLabel = document.getElementById('modalLabel');
    let btnModalSubmit = document.getElementById('btnModalSubmit');
    
    // form data variables
    let myForm = document.getElementById('myForm');
    let inputLeaveId = document.getElementById('input-leave-id');
    let inputEmpId = document.getElementById('input-emp-id');
    let inputLeaveType = document.getElementById('input-leave-type');
    let inputLeaveEvidence = document.getElementById('input-leave-evidence');
    let inputLeaveEvidenceOld = document.getElementById('input-leave-evidence-old');
    let inputLeaveReason = document.getElementById('input-leave-reason');
    let inputStartDate = document.getElementById('input-start-date');
    let inputEndDate = document.getElementById('input-end-date');
    let inputNumberOfDay = document.getElementById('input-number-of-day');
    let inputStatus = document.getElementById('input-status');
    let inputReasonRejected = document.getElementById('input-reason-rejected');
    let checkBoxHalfDay = document.getElementById('checkBox-halfDay');
    let checkBoxHolidays = document.getElementById('checkBox-holidays');
    let inputNumberOfHolidays = document.getElementById('input-number-of-holidays');
    let inputSignTo = document.getElementById('input-sign-to');
    let inputHasHalfDay = document.getElementById('input-has-halfDay');
    let inputHasHolidays = document.getElementById('input-has-holidays');
    let spanImgLeaveEvidence = document.getElementById('span-leave-evidence-old');
    let imgLeaveEvidence = document.getElementById('img-leave-evidence-old');
    let inputUpdatedBy = document.getElementById('input-updated-by');

    // row input variable
    let rowLeaveEvidence = document.getElementById('row-leave-evidence');
    let rowReasonRejected = document.getElementById('row-reason-rejected');
    let rowInputSignTo = document.getElementById('row-input-sign-to');

    // col input variable
    let colNumberOfHolidays = document.getElementById('col-number-of-holidays');

    const checkInvalidItems = (e) => { // CHECKED
      	e.preventDefault();
        if(inputStatus.value == '') {
            Swal.fire({
                icon: 'error',
                title: 'Decision required !',
                text: 'Silahkan tentukan keputusan Anda',
                showConfirmButton: true
            });
            btnModalSubmit.disabled = true;
        } else if(<?= "'" . $_SESSION['userInfo']['dept_name'] . "'" ?> != 'HR/GA') { // di set seperti ini karena HR/GA adalah approval terakhir, tidak perlu meneruskan approval lagi
            if(inputStatus.value == 'Approved') {
                if(inputSignTo.value == '') {
                    btnModalSubmit.disabled = true;
                    Swal.fire({
                        icon: 'error',
                        title: 'Approval required !',
                        text: 'Silahkan pilih next approval',
                        showConfirmButton: true
                    });
                } else {
                  myForm.submit();
                }
            } else {
              if(inputReasonRejected.value == '') {
                    btnModalSubmit.disabled = true;
                    Swal.fire({
                        icon: 'error',
                        title: 'Reason rejected required !',
                        text: 'Silahkan isi alasan Anda menolak permohonan cuti karyawan',
                        showConfirmButton: true
                    });
                } else {
                    myForm.submit();
                }
            }
        } else {
            if(inputStatus.value == 'Approved') {
                myForm.submit();
            } else {
                if(inputReasonRejected.value == '') {
                    btnModalSubmit.disabled = true;
                    Swal.fire({
                        icon: 'error',
                        title: 'Reason rejected required !',
                        text: 'Silahkan isi alasan Anda menolak permohonan cuti karyawan',
                        showConfirmButton: true
                    });
                } else {
                    myForm.submit();
                }
            }
        }
    }; btnModalSubmit.addEventListener('click', checkInvalidItems);

    if(<?= "'" . $_SESSION['userInfo']['dept_name'] . "'" ?> != 'HR/GA') {
        inputSignTo.addEventListener('change', () => btnModalSubmit.disabled = false);
        inputStatus.addEventListener('change', () => btnModalSubmit.disabled = false);
      	inputReasonRejected.addEventListener('keyup', () => btnModalSubmit.disabled = false);
    }

    const showReasonOrSignTo = () => {
        if(inputStatus.value == 'Rejected') {
            rowReasonRejected.style.display = 'block';
            rowInputSignTo.style.display = 'none';
            btnModalSubmit.disabled = false;
        } else {
            rowReasonRejected.style.display = 'none';
            rowInputSignTo.style.display = 'block';
            btnModalSubmit.disabled = false;
        }
    }; inputStatus.addEventListener('change', showReasonOrSignTo);

    let btnEdit = document.getElementsByClassName('btn-edit');
    if(btnEdit) {
        for(let i = 0; i < btnEdit.length; i++) {
            btnEdit[i].addEventListener('click', () => {
                myForm.setAttribute('action', '<?= BASEURL ?>/leave/approval');
                btnModalSubmit.innerHTML = 'Sign Now';
                btnModalSubmit.style.display = 'block';
                btnModalSubmit.disabled = false;
                inputStatus.value = '';
                if(<?= '"' . $_SESSION['userInfo']['dept_name'] . '"' ?> != 'HR/GA') {
                    inputSignTo.value = '';
                }
                rowReasonRejected.style.display = 'none';

                let request = new XMLHttpRequest();
                request.open('POST', '<?= BASEURL ?>/leave/getEdit');
                request.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                request.onreadystatechange = () => {
                    if(request.readyState == 4 && request.status == 200) {
                        let results = JSON.parse(request.responseText);
                        modalLabel.innerHTML = 'Approval Permohonan Cuti : ' + results.emp_name;
                        inputLeaveId.value = results.id;
                        inputEmpId.value = results.emp_id;
                        inputLeaveType.value = results.leave_type;
                        if(results.leave_evidence == '') {
                            rowLeaveEvidence.style.display = 'none';
                            imgLeaveEvidence.removeAttribute('src');
                        } else {
                            if(inputLeaveType.value == 'Special Leave') {
                                rowLeaveEvidence.style.display = 'block';
                                inputLeaveEvidenceOld.value = results.leave_evidence;
                                imgLeaveEvidence.setAttribute('src', '<?= BASEURL . '/assets/img/leave_evidences/'  ?>' + results.leave_evidence);
                                spanImgLeaveEvidence.style.display = 'block';
                            }
                        }
                        inputLeaveReason.value = results.leave_reason;
                        inputStartDate.value = results.start_date;
                        inputEndDate.value = results.end_date;
                        inputNumberOfDay.value = results.number_of_day;
                        inputUpdatedBy.value = <?= $_SESSION['userInfo']['emp_id'] ?>;
                        results.has_halfday == 1 ? checkBoxHalfDay.checked = true : checkBoxHalfDay.checked = false;
                        results.has_holidays > 0 ? checkBoxHolidays.checked = true : checkBoxHolidays.checked = false;
                        results.has_holidays == 0 ? colNumberOfHolidays.style.display = 'none' : colNumberOfHolidays.style.display = 'block';
                        inputNumberOfHolidays.value = results.has_holidays;
                    }
                };
                request.send('id=' + btnEdit[i].getAttribute('data-id'));
            });
        }
    }

    let btnDelete = document.getElementsByClassName('btn-delete');
    for(let i = 0; i< btnDelete.length; i++) {
        btnDelete[i].addEventListener('click', () => {
            
            if(confirm('Yakin hapus data ini?') == true) {
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
                            window.location = '<?= BASEURL ?>' + '/leave/cutiKaryawan';
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