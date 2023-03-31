<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/structure" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="formEdit">
          <input type="hidden" name="id" value="<?= $data['member']['id'] ?>">
          <label for="child_id" class="form-label">Anggota</label>
            <select name="child_id" id="child_id" class="form-select mb-3" required>
              <option value="<?= $data['member']['member_id'] ?>"><?= $data['member']['member_name'] ?></option>
              <option value="" disabled>Pilih Anggota</option>
              <?php foreach($data['members'] as $member) : ?>
                <option value="<?= $member['id'] ?>"><?= $member['member_name'] ?> (<?= $member['member_position'] ?>)</option>
              <?php endforeach; ?>
            </select>

            <label for="parent_id" class="form-label">Jalur Koordinasi</label>
            <select name="parent_id" id="parent_id" class="form-select mb-3" required>
              <option value="<?= $data['member']['leader_id'] ?>"><?= $data['member']['leader_name'] ?></option>
              <option value="" disabled>Pilih Leader</option>
              <?php foreach($data['members'] as $member) : ?>
                <option value="<?= $member['id'] ?>"><?= $member['member_name'] ?> (<?= $member['member_position'] ?>)</option>
              <?php endforeach; ?>
            </select>

            <button type="submit" class="btn btn-primary btn-sm float-end">Update</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>  
  $('#formEdit').on('submit', (e) => {
    e.preventDefault();

    $.ajax({
      url: '<?= BASEURL . '/structure/update' ?>',
      type: 'POST',
      data: $('#formEdit').serialize(),
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil merubah structure',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/structure" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal merubah structure',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>