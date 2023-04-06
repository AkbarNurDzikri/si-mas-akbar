<div class="row">
  <div class="col-12 col-md-12" id="colDataTable">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/users/new" class="btn btn-primary btn-sm"><i class="bi bi-plus-circle"></i> User</a>
      </div>
      <div class="card-body table-responsive mt-3">
        <table class="table table-striped display" id="myTable">
          <thead>
            <tr>
              <th class="text-center">No</th>
              <th class="text-center">Full Name</th>
              <th class="text-center">Username</th>
              <th class="text-center">Email</th>
              <th class="text-center">Hak Akses</th>
              <th class="text-center">Opsi</th>
            </tr>
          </thead>
          <tbody>
            <?php $i = 1; ?>
            <?php foreach($data['users'] as $user) : ?>
              <tr>
                <td class="text-center"><?= $i++ ?></td>
                <td class="text-center"><?= $user['member_name'] ?></td>
                <td class="text-center"><?= $user['username'] ?></td>
                <td class="text-center"><?= $user['email'] ?></td>
                <td class="text-center"><?= $user['role_name'] ?></td>
                <td class="text-center">
                  <a href="<?= BASEURL . "/users/edit/" . $user['id'] ?>" class="btn btn-sm btn-success mb-1"><i class="bi bi-pencil-square"></i></a>
                  <button class="btn btn-sm btn-danger btnDelete" data-bs-toggle="modal" data-bs-target="#modalConfirmDelete" data-id="<?= $user['id'] ?>" data-username="<?= $user['username'] ?>"><i class="bi bi-trash3"></i></a>
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
      $('#confirmText').html('Yakin hapus user <span class="text-danger">' + btnDelete[i].getAttribute('data-username') + ' ?');
      $('#inputId').val(btnDelete[i].getAttribute('data-id'));
    });
  };

  $('#formDelete').on('submit', (e) => {
    e.preventDefault();

    $.ajax({
      url: '<?= BASEURL . '/users/delete' ?>',
      type: 'POST',
      data: $('#formDelete').serialize(),
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil menghapus user',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/users" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal menghapus user',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>