<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include_once("PHPExcel/PHPExcel.php");
include_once("PHPExcel/PHPExcel/IOFactory.php");
require('db_config.php');



if(isset($_POST['Submit'])){

  if (!empty($_FILES) && isset($_FILES['file_name'])) {
      $file = $_FILES['file_name']['tmp_name'];
      
      $objPHPExcel = PHPExcel_IOFactory::load($file);
     
      // GET WORKSHEET DIMENSIONS
      $sheet = $objPHPExcel->getSheet(0);
      $highestRow = $sheet->getHighestRow();
      $highestColumn = $sheet->getHighestColumn();

      $data= array();
      

      for ($row = 2; $row <= $highestRow; $row++){
        // READING THE ROW
        $rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,NULL,TRUE,FALSE);

        $id=isset($rowData[0][0])?$rowData[0][0]:'';
        $product_name=isset($rowData[0][1])?$rowData[0][1]:'';
        $offer_id=isset($rowData[0][2])?$rowData[0][2]:'';
        $company_id=isset($rowData[0][3])?$rowData[0][3]:'';
        $description=isset($rowData[0][4])?$rowData[0][4]:'';
        
         // INSERT INTO DB
         if($product_name!='' || $offer_id!='' || $company_id!='' || $description!=''){
            $query = "insert into data(product_name,offer_id,company_id,description) values('".$product_name."','".$offer_id."','".$company_id."','".$description."')";
             $res = $mysqli->query($query);
            if($res){
              echo "inserted";
            }
         }

      }
   
  }

}
?>