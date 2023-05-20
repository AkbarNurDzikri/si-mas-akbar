<?php
if(count($data['committee']) == 0 || count($data['budget']) == 0) {
  echo 
  '<!DOCTYPE html>
    <html lang="en">
    <head>
      <meta charset="UTF-8">
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <title>Notif</title>
      <link href="' . BASEURL . '/assets/dashboard/css/style.css" rel="stylesheet">
      <link href="' . BASEURL . '/assets/dashboard/vendor/sweetalert/dist/sweetalert2.min.css" rel="stylesheet">
      <script src="' . BASEURL . '/assets/dashboard/vendor/sweetalert/dist/sweetalert2.min.js"></script>
    </head>
    <body>
      <script>
        Swal.fire({
          icon: "error",
          title: "Panitia / Anggaran Acara belum dibuat !",
          text: "Silahkan buat terlebih dahulu ..",
          showConfirmButton: true,
        }).then(() => {
          window.location = "' . BASEURL . '/events"
        })
      </script>
    </body>
    </html>';
} else {
  require_once dirname(__DIR__, 3) . '/assets/dashboard/vendor/mpdf/autoload.php';

  $mpdf = new \Mpdf\Mpdf();
  $mpdf->SetFooter('{PAGENO}');
  $html = '<!DOCTYPE html>
            <html lang="en">
            <head>
              <meta charset="UTF-8">
              <meta http-equiv="X-UA-Compatible" content="IE=edge">
              <meta name="viewport" content="width=device-width, initial-scale=1.0">
              <title>Print Acara [ ' . $data['event']['title'] . ' ]</title>
            </head>
            <body>
              <table style="margin-left: auto; margin-right: auto;">
                <tr>
                  <td rowspan="3"><img src="'. BASEURL . '/assets/images/icons/Foto Masjid Depan.jpeg' .'" style="width: 80px; margin-left: -70px; margin-right: 30px;"></td>
                </tr>
                <tr>
                  <td style="text-align: center;">
                    <h2 style="padding-bottom: -15px;">DEWAN KEMAKMURAN MASJID AL-AKBAR</h2>
                    <p style="padding-bottom: -15px;">Perumahan Mutiara Alam Permai - Dusun Babakan Ciranggon</p>
                    <p style="padding-bottom: -15px;">Desa Pasir Jengkol, Kec. Majalaya, Kab. Karawang, Prov. Jawa Barat</p>
                  </td>
                </tr>
              </table>

              <hr> <hr style="margin-top: -11px;">
              
              <h4 style="text-align: center;"><u>KONSEP ACARA</u></h4>
              <h4 style="text-align: center; padding-top: -12px;"><u>'. strtoupper($data['event']['title']) .'</u></h4>

              <table border="0" style="border-collapse: collapse; margin-left: auto; margin-right: auto; margin: 20px 0 30px 0; width: 700px;">
                <tr>
                  <td>Dasar</td>
                  <td>: </td>
                  <td>Hasil rapat tanggal ' . date('d-M-Y', strtotime($data['committee'][0]['meeting_date'])) . ' - ' . $data['committee'][0]['meeting_time'] .' WIB @ ' . $data['committee'][0]['meeting_room'] . '</td>
                </tr>
                <tr>
                  <td>Anggota rapat</td>
                  <td>: </td>
                  <td>'.$data['committee'][0]['meeting_participants'].'</td>
                </tr>
              </table>

              <ul>
                <li><b>Susunan Panitia</b></li>';
                $x = 1;
                foreach($data['committee'] as $comm) {
                  $html .= '<p style="margin-bottom: 0px;">'. $x++ . '. ' . $comm['position'] . ' - ' . $comm['person_name'] .'</p>';
                  $html .= '<span>Tugas & Tanggung Jawab : '. $comm['main_duties_and_functions'] .'</span>';
                }
                $totalBudget = 0;
                $y = 1;
      $html .= '<li style="padding-top: 15px;"><b>Anggaran Dana</b></li>';
                foreach($data['budget'] as $budg) {
                  $html .= '<p style="margin-bottom: 0px;">'. $y++ . '. ' . $budg['budget_name'] . ' - Rp. ' . number_format($budg['budget_price'], 2, ',', '.') .'</p>';
                  $html .= '<span>Keterangan : '. $budg['remarks'] .'</span>';
                  $totalBudget += $budg['budget_price'];
                }
      $html .= '<h4><b>Total Anggaran : Rp. '. number_format($totalBudget, 2, ',', '.') .'</b></h4>';
    $html .= '</ul>';

    $html .= '<p style="text-align: right; color:grey;">Tanggal download : '. date('d-M-Y H:i') .' WIB</p>
            </body>
          </html>';
  $mpdf->WriteHTML($html);
  $mpdf->Output('Print Konsep Acara ' . $data['event']['title'] . '.pdf', 'I');
}
?>