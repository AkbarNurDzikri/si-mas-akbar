<?php
require_once dirname(__DIR__, 3) . '/assets/dashboard/vendor/mpdf/autoload.php';

$mpdf = new \Mpdf\Mpdf();
$mpdf->SetFooter('{PAGENO}');
$html = '<!DOCTYPE html>
          <html lang="en">
          <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Print Notulen [ ' . $data['notulen']['title'] . ' ]</title>
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

            <hr>
            
            <h3 style="text-align: center;"><u>NOTULEN RAPAT</u></h3>

            <table border="0" style="border-collapse: collapse; margin-left: auto; margin-right: auto; margin-top: 20px; width: 700px;">
              <tr>
                <td style="border-bottom: 1px dotted black;">Tempat, tanggal & waktu rapat</td>
                <td style="border-bottom: 1px dotted black;">: </td>
                <td style="border-bottom: 1px dotted black;">'.$data['notulen']['meeting_room'] . ', ' . date('d-M-Y', strtotime($data['notulen']['meeting_date'])) . ' - ' . $data['notulen']['meeting_time'] .' WIB</td>
              </tr>
              <tr>
                <td style="border-bottom: 1px dotted black;">Judul rapat</td>
                <td style="border-bottom: 1px dotted black;">: </td>
                <td style="border-bottom: 1px dotted black;">'.$data['notulen']['title'].'</td>
              </tr>
              <tr>
                <td style="border-bottom: 1px dotted black;">Anggota rapat</td>
                <td style="border-bottom: 1px dotted black;">: </td>
                <td style="border-bottom: 1px dotted black;">'.$data['notulen']['meeting_participants'].'</td>
              </tr>
            </table>

            <p>Isi rapat :</p>
            <p style="padding-top: -25px;">'. $data['notulen']['body'] .'</p>

            <p style="text-align: right; color:grey;">Tanggal download : '. date('d-M-Y H:i') .' WIB</p>
          </body>
        </html>';
$mpdf->WriteHTML($html);
$mpdf->Output('Notulen Rapat ' . date('d-M-Y', strtotime($data['notulen']['meeting_date'])) . ' (' . $data['notulen']['title'] . ').pdf', 'I');
?>