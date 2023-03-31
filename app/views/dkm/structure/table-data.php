<div class="row">
  <div class="col-12 col-md-12" id="colDataTable">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/structure/new" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> Anggota</a>
      </div>
      <div class="card-body table-responsive mt-3">
        <table class="table table-striped display" id="myTable">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Nama Anggota</th>
              <th class="text-center">Nama Leader</th>
              <th class="text-center">Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach($data['members'] as $member) : ?>
              <tr>
                <td class="text-center"><?= $i++ ?></td>
                <td class="text-center"><?= $member['member_name'] ?></td>
                <td class="text-center"><?= $member['leader_name'] ?></td>
                <td class="text-center">
                  <a href="<?= BASEURL . "/structure/edit/" . $member['id'] ?>" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a>
                  <button class="btn btn-sm btn-danger btnDelete" data-bs-toggle="modal" data-bs-target="#modalConfirmDelete" data-id="<?= $member['id'] ?>" data-member-name="<?= $member['member_name'] ?>" data-leader-name="<?= $member['leader_name'] ?>"><i class="bi bi-trash3"></i></a>
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
          <button type="button" class="btn btn-sm btn-primary" data-bs-dismiss="modal">Cancel</button>
        </div>
      </form>
    </div>
  </div>
</div>

<script>
  const btnDelete = document.getElementsByClassName('btnDelete');
  for(let i = 0; i < btnDelete.length; i ++) {
    btnDelete[i].addEventListener('click', () => {
      $('#confirmText').html('Yakin hapus pasangan struktur <span class="text-danger">' + btnDelete[i].getAttribute('data-member-name') + '</span> dan <span class="text-danger">' + btnDelete[i].getAttribute('data-leader-name') + '</span> ?');
      $('#inputId').val(btnDelete[i].getAttribute('data-id'));
    });
  };

  $('#formDelete').on('submit', (e) => {
    e.preventDefault();

    $.ajax({
      url: '<?= BASEURL . '/structure/delete' ?>',
      type: 'POST',
      data: $('#formDelete').serialize(),
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menghapus structure',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/structure" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menghapus structure',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>