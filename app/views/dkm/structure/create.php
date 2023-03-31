<div class="row">
  <div class="col-12 col-md-6" id="colForm">
    <div class="card">
      <div class="card-header">
        <a href="<?= BASEURL ?>/structure" class="btn btn-secondary btn-sm"><i class="bi bi-arrow-left"></i> Back</a>
      </div>
      <div class="card-body">
        <form id="myForm">
          <label for="child_id" class="form-label">Anggota</label>
          <select name="child_id" id="child_id" class="form-select mb-3" required>
            <option value="" disabled selected>Pilih Anggota</option>
            <?php foreach($data['members'] as $member) : ?>
              <option value="<?= $member['id'] ?>"><?= $member['member_name'] ?> (<?= $member['member_position'] ?>)</option>
            <?php endforeach; ?>
          </select>

          <label for="parent_id" class="form-label">Jalur Koordinasi</label>
          <select name="parent_id" id="parent_id" class="form-select mb-3" required>
            <option value="" disabled selected>Pilih Leader</option>
            <?php foreach($data['members'] as $member) : ?>
              <option value="<?= $member['id'] ?>"><?= $member['member_name'] ?> (<?= $member['member_position'] ?>)</option>
            <?php endforeach; ?>
          </select>

          <button type="submit" class="btn btn-primary btn-sm float-end">Save</button>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
  $('#myForm').on('submit', (e) => {
    e.preventDefault();    
    
    $.ajax({
      url: '<?= BASEURL . "/structure/create" ?>',
      type: 'POST',
      data: $('#myForm').serialize(),
      success: function(res) {
        if(res == 'success') {
          Swal.fire({
            icon: 'success',
            title: 'Berhasil membuat structure',
            showConfirmButton: true,
          }).then(() => {
            window.location = '<?= BASEURL . "/structure" ?>'
          });
        } else {
          Swal.fire({
            icon: 'error',
            title: 'Gagal membuat structure !',
            text: res,
            showConfirmButton: true,
          })
        }
      }
    });
  });
</script>