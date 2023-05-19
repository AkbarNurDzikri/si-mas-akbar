<div class="row">
  <div class="col-12 col-md-12" id="colDataTable">
    <div class="card">
      <div class="card-header">
        <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#modalLoadEvent"><i class="bi bi-plus-circle"></i> Buat Anggaran</button>
      </div>
      <div class="card-body table-responsive mt-3">
        <table class="table table-striped display" id="myTable">
          <thead>
            <tr>
              <th class="text-center align-middle">No</th>
              <th class="text-center align-middle">Nama Acara</th>
              <th class="text-center align-middle">Dibuat Oleh</th>
              <th class="text-center align-middle">Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach($data['budgets'] as $budget) : ?>
              <tr>
                <td class="text-center align-middle"><?= $i++ ?></td>
                <td class="text-center align-middle"><?= $budget['event_name'] ?></td>
                <td class="text-center align-middle"><?= $budget['creator'] ?> <?= $budget['updated_by'] != NULL ? '(updated by <b>' . $budget['editor'] . '</b>)'  : '' ?></td>
                <td class="text-center align-middle">
                  <a href="<?= BASEURL . "/budgeting/edit/" . $budget['event_id'] ?>" class="btn btn-sm btn-success mb-1"><i class="bi bi-eye"></i> Detail</a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal Load Events -->
<div class="modal fade" id="modalLoadEvent" tabindex="-1" aria-labelledby="modalLoadEventLabel" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <table class="table mx-auto">
          <h5 class="text-center"><b>Daftar Acara :</b></h5>
          <?php $i = 1;?>
          <?php foreach($data['events'] as $event) : ?>
            <tr>
              <td style="border-bottom: 1px solid grey;" class="align-middle col"><?= $i++ . '. ' . $event['event_name'] ?></td>
              <td style="border-bottom: 1px solid grey;" class="align-middle col"><a href="<?= BASEURL ?>/budgeting/new/<?= $event['id'] ?>" class="btn btn-sm btn-success"><i class="bi bi-arrow-right-circle"></i> Go</a></td>
            </tr>
          <?php endforeach; ?>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Cancel</button>
      </div>
    </div>
  </div>
</div>