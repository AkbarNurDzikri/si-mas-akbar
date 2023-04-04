<div class="row">
  <div class="col-12 col-md-12" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/committees" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
        <a href="<?= BASEURL ?>/committees/pdf/<?= $data['committee'][0]['event_id'] ?>" class="btn btn-danger btn-sm"><i class="bi bi-file-earmark-pdf"></i> PDF</a>
      </div>
      <div class="card-body">
        <input type="hidden" name="id" value="<?= $data['committee'][0]['id'] ?>" id="id">
        <h5 class="mt-3"><?= isset($data['committee'][0]['event_name']) ? $data['committee'][0]['event_name'] : 'Panitia Belum Dibuat' ?></h5>
        
        <div id="boxPanitia">
          <div class="inputPanitia mt-3">
            <?php $no = 1; $titlePanitia = 1; $textTitlePanitia = 1;?>
            <?php foreach($data['committee'] as $comm) : ?>
              <h6 class="text-muted d-inline" id="titlePanitia<?= $titlePanitia++ ?>">Panitia #<?= $textTitlePanitia++ ?></h6> | 
              <a href="#" class="text-primary updatePanitia" data-id="<?= $comm['id'] ?>" data-event-id="<?= $comm['event_id'] ?>"><b><i class="bi bi-send-check"></i> Update</b></a> | 
              <a href="#" class="text-danger confirmDeleteCommittee" data-bs-toggle="modal" data-bs-target="#modalDeleteCommittee" data-id="<?= $comm['id'] ?>" data-name="<?= $comm['person_name'] ?>"><b><i class="bi bi-trash3"></i> Hapus</b></a> <br>

              <label for="personName" class="form-label" id="labelpersonName">Nama Panitia</label>
              <input type="text" class="form-control mb-3 personNames" name="person_name" value="<?= $comm['person_name'] ?>" placeholder="Syaipul Nur" autocomplete="off" required>
              
              <label for="position" class="form-label" id="labelposition">Jabatan</label>
              <input type="text" class="form-control mb-3 positions" name="position" value="<?= $comm['position'] ?>" placeholder="Ketua" autocomplete="off" required>

              <label for="duties" class="form-label" id="labelduties">Tupoksi</label>
              <textarea class="form-control mb-3 duties" name="main_duties_and_functions" placeholder="Melaporkan progress tanggung jawab kepada ketua .." required><?= $comm['main_duties_and_functions'] ?></textarea>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Form Update -->
<form id="formUpdate" action="<?= BASEURL . '/committees/update' ?>" method="POST">
  <input type="hidden" name="event_id" id="inputEventId">
  <input type="hidden" name="id" id="inputIdUpdate">
  <input type="hidden" name="person_name" id="inputPanitiaName">
  <input type="hidden" name="position" id="inputPanitiaPosition">
  <input type="hidden" name="main_duties_and_functions" id="inputPanitiaTupoksi">
</form>

<!-- Modal Confirm Delete -->
<div class="modal fade" id="modalDeleteCommittee" tabindex="-1" aria-labelledby="modalDeleteCommitteeLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalDeleteCommitteeLabel">Confirmation</h1>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="formDelete">
          <input type="hidden" id="inputId" name="id">
          <h4 class="text-center" id="confirmText"></h4>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-sm btn-danger">Delete</button>
          <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Close</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const btnUpdate = $('.updatePanitia');
  for(let i = 0; i < btnUpdate.length; i++) {
    btnUpdate[i].addEventListener('click', () => {
      $('#inputIdUpdate').val(btnUpdate[i].getAttribute('data-id'));
      const inputPanitiaName = $('.personNames');
      const inputPanitiaPosition = $('.positions');
      const inputPanitiaDuties = $('.duties');
      $('#inputEventId').val(btnUpdate[i].getAttribute('data-event-id'));
      $('#inputPanitiaName').val(inputPanitiaName[i].value);
      $('#inputPanitiaPosition').val(inputPanitiaPosition[i].value);
      $('#inputPanitiaTupoksi').val(inputPanitiaDuties[i].value);
      $('#formUpdate').submit();
    });
  }

  const btnDelete = $('.confirmDeleteCommittee');
  for(let i = 0; i < btnDelete.length; i++) {
    btnDelete[i].addEventListener('click', () => {
      $('#inputId').val(btnDelete[i].getAttribute('data-id'));
      $('#confirmText').html('Yakin hapus panitia <span class="text-danger">' + btnDelete[i].getAttribute('data-name') + '</span> ?');
    });
  }

  $('#formDelete').on('submit', (e) => {
    e.preventDefault();

    const formData = $('#formDelete').serialize();

    $.ajax({
      url: '<?= BASEURL . '/committees/delete' ?>',
      type: 'POST',
      data: formData,
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menghapus panitia',
            showConfirmButton: true,
          }).then(() => {
            location.reload();
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menghapus panitia !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>