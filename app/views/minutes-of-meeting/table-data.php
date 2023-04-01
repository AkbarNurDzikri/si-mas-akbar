<div class="row">
  <div class="col-12 col-md-12" id="colDataTable">
    <div class="card">
      <!-- <?php var_dump($data['moms'])?> -->
      <div class="card-header">
        <a href="<?= BASEURL ?>/mom/new" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Notulen</a>
      </div>
      <div class="card-body table-responsive mt-3">
        <table class="table table-striped display" id="myTable">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Notulis</th>
              <th class="text-center">Tanggal Rapat</th>
              <th class="text-center">Jam Rapat</th>
              <th class="text-center">Tempat Rapat</th>
              <th class="text-center">Judul Rapat</th>
              <th class="text-center">Anggota Rapat</th>
              <th class="text-center">Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach($data['moms'] as $mom) : ?>
              <tr>
                <td class="text-center"><?= $i++ ?></td>
                <td class="text-center"><?= $mom['creator'] ?> <?= $mom['updated_by'] != NULL ? '(updated by <b>' . $mom['editor'] . '</b>)'  : '' ?></td>
                <td class="text-center"><?= date('d M y', strtotime($mom['meeting_date'])) ?></td>
                <td class="text-center"><?= $mom['meeting_time'] ?></td>
                <td class="text-center"><?= $mom['meeting_room'] ?></td>
                <td class="text-center"><?= $mom['meeting_participants'] ?></td>
                <td class="text-center"><?= $mom['title'] ?></td>
                <td class="text-center">
                  <a href="<?= BASEURL . "/mom/edit/" . $mom['id'] ?>" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a>
                  <button class="btn btn-sm btn-danger btnDelete" data-bs-toggle="modal" data-bs-target="#modalConfirmDelete" data-id="<?= $mom['id'] ?>" data-title="<?= $mom['title'] ?>"><i class="bi bi-trash3"></i></a>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>

<!-- Modal -->
<div class="modal fade" id="modalConfirmDelete" tabindex="-1" aria-labelledby="modalConfirmDeleteLabel" aria-hidden="true">
  <div class="modal-dialog modal-sm">
    <div class="modal-content">
      <div class="modal-header">
        <h1 class="modal-title fs-5" id="modalConfirmDeleteLabel">Confirmation</h1>
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
  const btnDelete = document.getElementsByClassName('btnDelete');
  for(let i = 0; i < btnDelete.length; i ++) {
    btnDelete[i].addEventListener('click', () => {
      $('#confirmText').html('Yakin hapus Notulen <span class="text-danger">' + btnDelete[i].getAttribute('data-title') + '</span> ?');
      $('#inputId').val(btnDelete[i].getAttribute('data-id'));
    });
  };

  $('#formDelete').on('submit', (e) => {
    e.preventDefault();

    $.ajax({
      url: '<?= BASEURL . '/mom/delete' ?>',
      type: 'POST',
      data: $('#formDelete').serialize(),
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menghapus notulen',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/mom" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menghapus notulen !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>