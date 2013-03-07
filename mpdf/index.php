<?php
define('_MPDF_PATH','./');
include("mpdf.php");


//==============================================================
//==============================================================
//==============================================================
$mpdf=new mPDF('utf-8', 'A4', '8', '', 10, 10, 7, 7, 10, 10);
$mpdf->default_lineheight_correction = 1.2;
// LOAD a stylesheet
//$stylesheet = file_get_contents('mpdfstyletables.css');
//$stylesheet = file_get_contents('mpdf.css');
$css = file_get_contents('test.css');
$html = file_get_contents('test.html');
$mpdf->WriteHTML($css,1);
$mpdf->WriteHTML($html);
$mpdf->Output('filename.pdf','F');
exit;
?>