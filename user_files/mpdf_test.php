<?php 

require_once  './../vendor/autoload.php';

$mpdf = new mPDF();
$stylesheet = file_get_contents('pdf_style.css');
$mpdf->WriteHTML($stylesheet,1);
$mpdf->WriteHTML('

<h1>Hello world! <br><br><barcode code="100152" type="C128A" class="barcode"  /></h1>

');
$mpdf->Output();

?>