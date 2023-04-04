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
            <title>Print Susunan Panitia [ ' . $data['committees'][0]['event_name'] . ' ]</title>
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
            
            <h3 style="text-align: center;"><u>SUSUNAN PANITIA ACARA</u></h3>
            <h3 style="text-align: center; padding-top: -10px; padding-bottom: -10px;"><u>' . strtoupper($data['committees'][0]['event_name']) . '</u></h3>

            <table border="0" style="border-collapse: collapse; margin-top: 30px; margin-bottom: 50px;">
              <tr>
                <td style="border-bottom: 1px dotted black;"><b>Dasar</b></td>
                <td style="border-bottom: 1px dotted black;">: </td>
                <td style="border-bottom: 1px dotted black;">Hasil rapat tanggal ' . date('d-M-Y', strtotime($data['committees'][0]['meeting_date'])) . ' - ' . $data['committees'][0]['meeting_time'] .' WIB @ ' . $data['committees'][0]['meeting_room'] . '</td>
              </tr>
              <tr>
                <td style="border-bottom: 1px dotted black;"><b>Anggota rapat</b></td>
                <td style="border-bottom: 1px dotted black;">: </td>
                <td style="border-bottom: 1px dotted black;">'.$data['committees'][0]['meeting_participants'].'</td>
              </tr>
            </table>';
            foreach($data['committees'] as $committe) {
              $html .= '<ul>
                <li>
                  <b>'. $committe['position'] . ' - ' . $committe['person_name'] . '</b> <br>
                  <i><u>Tugas pokok dan fungsi</u></i> : <br>' . $committe['main_duties_and_functions'] .
                '</li>
              </ul>';
            };


  $html .= '<p><i>"Struktur panitia ini dibentuk sebagai pedoman dalam melaksanakan tugas dan tanggung jawab setiap panitia, serta sebagai pengingat jalur koordinasi antar seksi agar komunikasi lebih terarah dan tepat sasaran. Semoga Allah meridhai apa yang kita perbuat aamiin."</i></p>
            <p style="text-align: right; color:grey; margin-top: 50px;">Tanggal download : '. date('d-M-Y H:i') .' WIB</p>
          </body>
        </html>';
$mpdf->WriteHTML($html);
$mpdf->Output('Susunan Panitia ' . $data['committees'][0]['event_name'] . ' (' . date('d-M-Y', strtotime($data['committees'][0]['event_date'])) . ').pdf', 'I');
?>