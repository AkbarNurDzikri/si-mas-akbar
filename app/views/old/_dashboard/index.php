<?php
    $myLeaveBalance = $data['annualLeaveBalance']['leave_balance'];
    $annualLeaveCounted = $data['intervalAnnualLeave']['annual_leave_counted'];
    $annualLeaveApproved = $data['annualLeaveApproved']['annual_leave_approved'];
    $annualLeaveRejected = $data['annualLeaveRejected']['annual_leave_rejected'];
    $annualLeaveOnProgress = $data['annualLeaveOnProgress']['annual_leave_on_progress'];

    $specialLeaveCounted = $data['intervalSpecialLeave']['special_leave_counted'];
    $specialLeaveApproved = $data['specialLeaveApproved']['special_leave_approved'];
    $specialLeaveRejected = $data['specialLeaveRejected']['special_leave_rejected'];
    $specialLeaveOnProgress = $data['specialLeaveOnProgress']['special_leave_on_progress'];
?>
<div class="row">
<div class="col-md-4 mb-2">
        <div class="card">
            <div class="card-header bg-info">
                <h4 class="text-white text-center">Annual Leave ( <?= $annualLeaveCounted ?>x )</h4>
            </div>
            <div class="card-body">
                <div class="col-md mb-2">
                    <h6 class="text-center mt-3">Approved : <?= $annualLeaveApproved . ' Submissions' ?></h6>
                    <h6 class="text-center mt-3">Rejected : <?= $annualLeaveRejected . ' Submissions' ?></h6>
                    <h6 class="text-center mt-3">On Progress : <?= $annualLeaveOnProgress . ' Submissions' ?> </h6>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card">
            <div class="card-header bg-primary">
                <h4 class="text-white text-center">Annual Leave Balance</h4>
            </div>
            <div class="card-body">
                <div class="col-md mb-2">
                    <h4 class="text-center mt-3">
                        <?php if($myLeaveBalance == 1 || $myLeaveBalance == 0.5) : ?>
                            <?= $myLeaveBalance ?> Day
                        <?php elseif($myLeaveBalance > 1) : ?>
                            <?= $myLeaveBalance ?> Days
                        <?php else : ?>
                            Habis
                        <?php endif; ?>
                    </h4>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-4 mb-2">
        <div class="card">
            <div class="card-header bg-success">
                <h4 class="text-white text-center">Special Leave ( <?= $specialLeaveCounted ?>x )</h4>
            </div>
            <div class="card-body">
                <div class="col-md mb-2">
                    <h6 class="text-center mt-3">Approved : <?= $specialLeaveApproved . ' Submissions' ?></h6>
                    <h6 class="text-center mt-3">Rejected : <?= $specialLeaveRejected . ' Submissions' ?></h6>
                    <h6 class="text-center mt-3">On Progress : <?= $specialLeaveOnProgress . ' Submissions' ?> </h6>
                </div>
            </div>
        </div>
    </div>
</div>