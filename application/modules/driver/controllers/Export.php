<?php
 
defined('BASEPATH') OR exit('No direct script access allowed');
 
class Export extends MY_Controller {
    // construct
    public function __construct() {
        parent::__construct();        
        parent::__construct();
        $this->config->load('config');
        
        $this->load->library(array('common/Tables','common/common','pagination','common/excel'));       
        $this->load->helper(array('common/common','url'));
        $this->config->load('config');
       // $this->load->library();       
        
    }    
 
      
    public function generatepaymentXls($data) {
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0);
        $filename = 'Payment';
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Email');     
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Driver name');        
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Driver Mobile No');       
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Customer name');       
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Txn Id	');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Amount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Payment date');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Status');     
        // set Row
        $rowCount = 2;
        foreach ($data->result() as $list) {
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $list->driver_email);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $list->driver_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $list->driver_mobile);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, $list->user_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount,$list->txn_id);                
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.$list->amount);                
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, date('M d Y',strtotime($list->ride_date)));                
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, $list->payment_status);                
            
            $rowCount++;
        }       
        $filename = $filename."-". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output');
    }  

    /* payout excel */
    public function generatepayouttXls($data) {
        $objPHPExcel = new PHPExcel(); 
        $objPHPExcel->setActiveSheetIndex(0);
        $filename = 'Payout';
        $objPHPExcel->getActiveSheet()->SetCellValue('A1', 'Name');     
        $objPHPExcel->getActiveSheet()->SetCellValue('B1', 'Email');        
        $objPHPExcel->getActiveSheet()->SetCellValue('C1', 'Mobile No');       
        $objPHPExcel->getActiveSheet()->SetCellValue('D1', 'Ride Date');       
        $objPHPExcel->getActiveSheet()->SetCellValue('E1', 'Customer Name');       
        $objPHPExcel->getActiveSheet()->SetCellValue('F1', 'Ride Amount');       
        $objPHPExcel->getActiveSheet()->SetCellValue('G1', 'Percentage');       
        $objPHPExcel->getActiveSheet()->SetCellValue('H1', 'Payout Amount');     
        // set Row
        $rate_detail =get_payout_amount();
        $rowCount = 2;
        $total_amount = 0;
        $total_payout_amount=0;
        foreach ($data->result() as $val) {
            $total_amount+=$val->amount;
            $day= strtolower(date('l',strtotime($val->ride_date)));
            $payout_amount =  (($val->amount*(100-$rate_detail->$day))/100);
            $total_payout_amount+=$payout_amount;
            $objPHPExcel->getActiveSheet()->SetCellValue('A' . $rowCount, $val->driver_name);
            $objPHPExcel->getActiveSheet()->SetCellValue('B' . $rowCount, $val->driver_email);
            $objPHPExcel->getActiveSheet()->SetCellValue('C' . $rowCount, $val->driver_mobile);
            $objPHPExcel->getActiveSheet()->SetCellValue('D' . $rowCount, date('M d Y',strtotime($val->ride_date)));
            $objPHPExcel->getActiveSheet()->SetCellValue('E' . $rowCount,$val->user_name);                
            $objPHPExcel->getActiveSheet()->SetCellValue('F' . $rowCount, '$'.number_format((float) ($val->amount), 2, '.', ''));                
            $objPHPExcel->getActiveSheet()->SetCellValue('G' . $rowCount, $rate_detail->$day.'%');                
            $objPHPExcel->getActiveSheet()->SetCellValue('H' . $rowCount, number_format((float) ($payout_amount), 2, '.', ''));                
            
            $rowCount++;
        }  
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.($rowCount+2), 'Total Ride Amount($) :'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.($rowCount+2), number_format((float) ($total_amount), 2, '.', ''));
        $objPHPExcel->getActiveSheet()->SetCellValue('G'.($rowCount+3), 'Total Payout Amount ($):'); 
        $objPHPExcel->getActiveSheet()->SetCellValue('H'.($rowCount+3), number_format((float) ($total_payout_amount), 2, '.', ''));     
        $filename = $filename."-". date("Y-m-d-H-i-s").".csv";
        header('Content-Type: application/vnd.ms-excel'); 
        header('Content-Disposition: attachment;filename="'.$filename.'"');
        header('Cache-Control: max-age=0'); 
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'CSV');  
        $objWriter->save('php://output');
    }

}
?>