<div class="row">
  <div class="col-12 col-md-12" id="colDataTable">
    <div class="card">
    <ul class="nav nav-tabs" id="myTab" role="tablist">
      <li class="nav-item" role="presentation">
        <button class="nav-link active" id="home-tab" data-bs-toggle="tab" data-bs-target="#tabZakatFitrah" type="button" role="tab" aria-controls="tabZakatFitrah" aria-selected="true">Zakat Fitrah</button>
      </li>
      <li class="nav-item" role="presentation">
        <button class="nav-link" id="profile-tab" data-bs-toggle="tab" data-bs-target="#tabZakatMal" type="button" role="tab" aria-controls="tabZakatMal" aria-selected="false">Zakat Mal</button>
      </li>
    </ul>
    
    <div class="card-body table-responsive mt-3">
      <div class="tab-content" id="myTabContent">
        <!-- tab zakat fitrah -->
        <div class="tab-pane fade show active" id="tabZakatFitrah" role="tabpanel" aria-labelledby="home-tab" tabindex="0">
            <a href="<?= BASEURL . '/zakat/fitrah' ?>" class="btn btn-primary btn-sm mb-3"><i class="bi bi-plus-circle"></i> Input Zakat</a>
            <table class="table table-striped display caption-top" id="myTable">
              <caption id="captionTable"></caption>
              <thead>
                <tr>
                  <th class="text-center align-middle">No</th>
                  <th class="text-center align-middle">Tanggal, Jam</th>
                  <th class="text-center align-middle">Nama Muzakki</th>
                  <th class="text-center align-middle">Alamat</th>
                  <th class="text-center align-middle">Nilai Zakat</th>
                  <th class="text-center align-middle">Keterangan</th>
                  <th class="text-center align-middle">Petugas</th>
                  <th class="text-center align-middle">Opsi</th>
                </tr>
              </thead>
              <tbody>
                <?php $i = 1; ?>
                <?php $totalUangMasuk = 0; ?>
                <?php foreach($data['zakat_fitrah_uang'] as $fitrah) : ?>
                  <?php $totalUangMasuk += $fitrah['qty_in'] ?>
                  <tr>
                    <td class="text-center align-middle"><?= $i++ ?></td>
                    <td class="text-center align-middle"><?= date('d-M-y, H:i', strtotime($fitrah['created_at'])) ?></td>
                    <td class="text-center align-middle"><?= $fitrah['person_name'] ?></td>
                    <td class="text-center align-middle"><?= $fitrah['person_address'] ?></td>
                    <td class="text-end align-middle">Rp. <?= number_format($fitrah['qty_in'], 2,',', '.') ?></td>
                    <td class="text-center align-middle"><?= $fitrah['remarks'] ?></td>
                    <td class="text-center align-middle"><?= $fitrah['username'] ?></td>
                    <td class="text-center align-middle">
                      <a href="<?= BASEURL . "/zakat/edit/" . $fitrah['id'] ?>" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>

          <!-- tab zakat mal -->
          <div class="tab-pane fade" id="tabZakatMal" role="tabpanel" aria-labelledby="profile-tab" tabindex="0">mal</div>
        </div>
      </div>
    </div>
  </div>
</div>

<script>
  $('#captionTable').html(`Total Zakat Uang : <b>Rp. <?= number_format($totalUangMasuk, 2, ',', '.') ?></b>`)
</script>