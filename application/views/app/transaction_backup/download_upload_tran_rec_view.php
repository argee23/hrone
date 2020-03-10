<?php

 if(isset($_POST["Import"]))
   {

$file_name = $_FILES["file"]["tmp_name"];
$objPHPExcel = PHPExcel_IOFactory::load($file_name);

$highestColumm = $objPHPExcel->setActiveSheetIndex(0)->getHighestColumn();
$highestRow = $objPHPExcel->setActiveSheetIndex(0)->getHighestRow();

echo '<table border="1">
<thead>
<tr>
  <td>Employee ID </td>
  <td>Employee Name </td>
  <td>Date(mm.dd.yy) </td>
  <td>Leave Type </td>
  <td>Address while on leave </td>
  <td>Half day? </td>
  <td> Reason</td>
  <td>Leave Balance </td>
  <td>Remarks </td>
</tr>
</thead>
';
foreach ($objPHPExcel->setActiveSheetIndex(0)->getRowIterator() as $row) {

    $cellIterator = $row->getCellIterator();
    $cellIterator->setIterateOnlyExistingCells(false);

    echo '<tr>';
    foreach ($cellIterator as $cell) {
        if (!is_null($cell)) {

            $value = $cell->getCalculatedValue();
              $row_number=$cell->getRow();
              if($row_number==1){
                
              }else{
              echo '<td>'.$row_number.$value .
              '</td>';
              }
        }
    }
    //
    echo '</tr>';
}
echo '</table>';
}
 

// echo 'COLUMN: ', $cell->getColumn(), PHP_EOL;
// echo 'COORDINATE: ', $cell->getCoordinate(), PHP_EOL;
// echo 'RAW VALUE: ', $cell->getCalculatedValue(), PHP_EOL;
?>


