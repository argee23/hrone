<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

require APPPATH.'controllers/general.php'; 
	
class Report_pms extends General{

	function __construct(){
		parent::__construct();	
		$this->load->model("app/report_pms_model");
		$this->load->model("general_model");
		$this->load->dbforge();
		$this->load->library(array('PHPExcel','PHPExcel/IOFactory'));

		if(General::is_logged_in() == FALSE){
            redirect(base_url().'login');    
        }
		General::variable();
	}

	//index
	public function index(){	
		$this->data['onload'] = $this->session->flashdata('onload');
		$this->data['message'] = $this->session->flashdata('message');

		
		$this->load->view('app/reports/pms/general_form/index');
		
	}
	public function get_approval_reports($val){
	
			$data['approval_type'] = $val;
			$data['get_all_approval'] = $this->report_pms_model->get_all_approval();
	
		
		$this->load->view('app/reports/pms/approval/approval',$data);
	
	}
	public function get_evaluate_reports($val){
	
			$data['evaluation_type'] = $val;
			$data['get_all_evaluation'] = $this->report_pms_model->get_all_evaluation();
	
		
		$this->load->view('app/reports/pms/evaluation/evaluation',$data);
	
	}
		public function get_all_reports(){
	
			
		$data['c'] =$this->report_pms_model->get_c();
		$data['get_appraisal_schedule'] =$this->report_pms_model->get_appraisal_schedule();
		$data['get_all'] = $this->report_pms_model->get_all();
		$this->load->view('app/reports/pms/all/all',$data);
	
	}
	public function SearchResult() 
{
;
    $term = $this->input->get('term');
    $getDetail = $this->report_pms_model->getSearch($term);
    $data = array();
    foreach ($getDetail as $value) {
        $data[] = array(
            'label' => $value['fullname'],
            'value' => $value['employee_id']);
    }
    echo json_encode($data);
}
		public function all(){
	
			


		$get_all= $this->report_pms_model->get_all();
		$s = '';

		foreach($get_all as $get_all){ 
			
			$s += $get_all->score;
			$res = $this->report_pms_model->get_approver($get_all->approvers); 
			     if($get_all->status== 'done'){
                $q = '<td style="background-color: #03CB72; color:white"> Completed;  </td>';
                }else{
                 $q = '<td style="background-color: #E3435B;color:white">Not Initiated; </td>';
                  }
		    echo '<tr>
                <td>'.$get_all->fullname.'</td>
                <td>'.  $res->fullname.'</td>'
           		.$q.
                '<td>'.  $get_all->appraisal_period_type_dates.'</td>
                <td>'.$get_all->score.'('.$get_all->score_equivalent.')</td>
                <td>'.$get_all->agreement.'</td>

             
            </tr>';
        }
      
 		
	
	}



			public function get_department_sec(){
				$i = $this->input->post('text1');
				$c = $this->input->post('c');
				if($c == 'section'){
					$q = $this->report_pms_model->get_section($i);
						foreach($q as $e){
							  $res[]=array(
							  	'qwe' => 'section',		
						        'id' => $e->section_id,
						        'name' => $e->section_name
								);
							}	
				}elseif($c == 'department'){

					$q = $this->report_pms_model->get_department($i);
						foreach($q as $e){
							  $res[]=array(	
							  	'qwe' =>'department',	
						        'id' => $e->department_id,
						        'name' => $e->dept_name
								);
							}	

				}elseif($c == 'classification'){

					$q = $this->report_pms_model->get_classification($i);
						foreach($q as $e){
							  $res[]=array(	
							  	'qwe' =>'classification',	
						        'id' => $e->classification_id,
						        'name' => $e->classification
								);
							}	

				}elseif($c == 'position'){

					$q = $this->report_pms_model->get_position($i);
						foreach($q as $e){
							  $res[]=array(	
							  	'qwe' =>'position',	
						        'id' => $e->position_id,
						        'name' => $e->position_name
								);
							}	

				}elseif($c == 'location'){

					$q = $this->report_pms_model->get_location($i);
						foreach($q as $e){
							  $res[]=array(	
							  	'qwe' =>'location',	
						        'id' => $e->location_id,
						        'name' => $e->location_name
								);
							}	

				}
				
				
			
				
					echo json_encode($res);	
		}
	public function recommendation(){
	
			$data['get_appraisal_schedule'] =$this->report_pms_model->get_appraisal_schedule();
	$data['c'] =$this->report_pms_model->get_c();
				$data['comend']  = $recommendation =$this->report_pms_model->recommendation();
		$this->load->view('app/reports/pms/recommendation/recommendation',$data);
	
	}



	public function evaluators(){
					$recommendation =$this->report_pms_model->recommendation();
		           foreach($recommendation as $recommendation){
		           	$res1 = $this->report_pms_model->get_evaluator($recommendation->employee_id);
		           	$res = $this->report_pms_model->get_evaluator($recommendation->recommended_by);
		           	$salary ='';
		               if($recommendation->salary_increase){
                        $salary .= 'Salary increase'.'<br>'.$recommendation->salary;
                    }
                    if($recommendation->regularization){
                        $salary .='regularization'.'<br>'.$recommendation->regularization;
                    }
                        if($recommendation->contract_renewal){
                        $salary .='contract_renewal'.'<br>';
                    }
                        if($recommendation->for_lateral_transfer){
                        $salary .= 'for_lateral_transfer'.'<br>'.$recommendation->department;
                    }
                        if($recommendation->promotion){
                        $salary .= 'promotion'.'<br>'.$recommendation->position;
                    }

                    if($recommendation->demotion){
                        $salary .= 'demotion'.'<br>'.$recommendation->pos4;
                    }

                    if($recommendation->extend_probationary_period){
                        $salary .= 'extend_probationary_period'.'<br>'.$recommendation->no_months;
                    }
                    if($recommendation->retain_in_existing_position){
                        $salary .= 'retain_in_existing_position'.'<br>';
                    }
                    if($recommendation->promotion){
                        $salary .= 'promotion'.'<br>'.$recommendation->position;
                    }
                        if($recommendation->end_of_contract){
                        $salary .= 'end_of_contract'.'<br>';
                    }

		           echo '<tr><td>'. $res1->fullname.'</td><td>'.$res->fullname.'</td><td>'.$salary.'</td><td><a>Click To View</a></td></tr> ';
          
   }


	}	


 
// public function excel_general_forms2(){

// 	$MyGeneralForm = $this->report_pms_model->GetGeneralForms();//desc

// 	$CountGeneralForms = $this->report_pms_model->CountGeneralForms();

// 	$PmsSetting = $this->report_pms_model->pmsSingleSettings();

// 	$this->load->library('PHPExcel');
// 	$objPHPExcel = new PHPExcel();
// 	 $activeSheet = $objPHPExcel->getActiveSheet();
//     //..
//     //...
//      $activeSheet->getStyle("E")
//                  ->getAlignment()
//                  ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
// 	$i=0;
// 	$formPartsTotal=$CountGeneralForms->countId;
//     $columnarray = array(
//                 'A',
//                 'B',
//                 'C',
//                 'D',
//                 'E',
//                 'F',
//                 'G',
//                 'H',
//                 'I',
//                 'J',
//                 'K');

// // ==Start Cover & instructions.
// $coverWorkSheet = $objPHPExcel->createSheet($i);
// $coverWorkSheet->setCellValue('A1', 'PERFORMANCE APPRAISAL FORM (PAF)');

// $row=2;
// $coverWorkSheet->setCellValue('A3', 'General Instructions');
// $coverWorkSheet->setCellValue('A4', $PmsSetting->gen_instruction);

// $coverWorkSheet->getColumnDimension('A')->setWidth('120'); // fixes size
// $coverWorkSheet->getStyle('A4:B4') ->getAlignment()->setWrapText(true); // wrap

// $row=6;
// //$MyAscGeneralForm = $this->report_pms_model->GetAscGeneralForms();//ascending gen form
// foreach($MyGeneralForm as $g){
// 	$col=0;
// 	$coverWorkSheet->setCellValue($columnarray[$col].$row, $g->form_part);
// 	$row++;
// 	$coverWorkSheet->setCellValue($columnarray[$col].$row, $g->form_instruction);
// 	$coverWorkSheet->getStyle('A'.$row.':B'.$row.'') ->getAlignment()->setWrapText(true);

// 	$row=$row+2;
// }


// $coverWorkSheet->setTitle('Cover & Instructions');
// $coverWorkSheet->getStyle('A1')->applyFromArray(
//     array(
//         'fill' => array(
//             'type' => PHPExcel_Style_Fill::FILL_SOLID,
//             'color' => array('rgb' => 'FF0000')
//         )
//     )
// );
// $coverWorkSheet->getStyle('A3')->applyFromArray(
//     array(
//         'fill' => array(
//             'type' => PHPExcel_Style_Fill::FILL_SOLID,
//             'color' => array('rgb' => 'FF0000')
//         )
//     )
// );
// $coverWorkSheet->getStyle('A6')->applyFromArray(
//     array(
//         'fill' => array(
//             'type' => PHPExcel_Style_Fill::FILL_SOLID,
//             'color' => array('rgb' => 'FF0000')
//         )
//     )
// );






// // ==End Cover & instructions.
			
// 	$style = array(
//         'alignment' => array(
//             'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//                'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
//         )
//     );

//     $activeSheet->getDefaultStyle()->applyFromArray($style);

//  			foreach($MyGeneralForm as $m){
//  				 $i=$i+1;
//  				 $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
//  				 $form_part_id=$m->fid;
//  				 $form_part=$m->form_part;
//  				 $form_title=$m->form_title;
//  				 $form_instruction=$m->form_instruction;
 				 
// 		                $objWorkSheet->setCellValue('A1', 'Part: '.$form_part.'');
// 		                $objWorkSheet->setCellValue('B1', $form_title);
// 		                $row=3;

// 		                $objWorkSheet->setCellValue('A3', 'Instructions');
// 		                $row=4;
// 		                $objWorkSheet->setCellValue('C4', $form_instruction);

// 		                // $row=6;

// 		                $objWorkSheet->setCellValue('A5', 'Score');
// 		                $objWorkSheet->setCellValue('B5', 'Score Equivalent');
// 		                $objWorkSheet->setCellValue('C5', 'Score Guide');

// 		                $row=7;

//  				 $ScoreRate=$this->report_pms_model->GetScoreRate($form_part_id);

// 					$styleArray = array(
// 					  'borders' => array(
// 					    'allborders' => array(
// 					      'style' => PHPExcel_Style_Border::BORDER_THIN
// 					    )
// 					  ),
// 					  'fill' => array(
//             'type' => PHPExcel_Style_Fill::FILL_SOLID,  
//             'color' => array('rgb' => '33a532')
//         ),
//          'alignment' => array(
//        'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
//        'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
//    ) 
// 					); 



//  				 if(!empty($ScoreRate)){
// 		                foreach($ScoreRate as $idata){
// 		                    $col=0;
// 		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->score);    
// 		                    $col++;
// 		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->score_equivalent);
// 		                    $col++;
// 		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->scoring_guide);
// 		                    $row++;

// 		                }
//  				 }else{

//  				 }

//  				 $row=$row+1;
//  				 		$scoring_posLoc="A$row";
//  				 		$scoring_areaLoc="B$row";
//  				 		$scoring_detailsLoc="C$row";
//  				 		$scoring_weighTLoc="D$row";
 				 		

// 		                $objWorkSheet->setCellValue($scoring_posLoc, 'Position');
// 		                $objWorkSheet->setCellValue($scoring_areaLoc, 'Area');
// 		                $objWorkSheet->setCellValue($scoring_detailsLoc, 'Details');
// 		                $objWorkSheet->setCellValue($scoring_weighTLoc, 'Weight');

// 		                $objWorkSheet->getStyle($scoring_posLoc.':'.$scoring_weighTLoc)->applyFromArray($styleArray);

// 		        $ScoreCriteria=$this->report_pms_model->GetScoreCriteriaPosBased($form_part_id);
// 		        $ScoreCriteriaGeneral=$this->report_pms_model->GetScoreCriteriaGeneral($form_part_id);
// 		       	$row=$row+1;
		 

// 		        if(!empty($ScoreCriteria)){
// 		                foreach($ScoreCriteria as $idata){
// 		                    $col=0;
// 		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->position);    
// 		                    $col++;
// 		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->area);
// 		                    $col++;
// 		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->description);
// 		                    $col++;
// 		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->weight);
// 		                    $row++;

// 		                }
// 		        }else{

// 		        }

// 				// border & autosize
// 				foreach(range('A','C') as $v){
// 				$objWorkSheet->getStyle(''.$v.'3:'.$v.'3')->applyFromArray($styleArray);
// 				$objWorkSheet->getStyle(''.$v.'5:'.$v.'5')->applyFromArray($styleArray);
	
// 				$objWorkSheet->getStyle('C4:D999')->getAlignment()->setWrapText(true); 
// 				}
// 				// $objWorkSheet->getStyle('A3:C3')->applyFromArray($styleArray);
// 				unset($styleArray);

// 				// $objWorkSheet->getColumnDimension('A')->setAutoSize(true); //autosize
// 				$objWorkSheet->getColumnDimension('C')->setWidth('100'); // fixes size
// 				$objWorkSheet->getColumnDimension('B')->setWidth('20'); // fixes size
// 				$objWorkSheet->getColumnDimension('A')->setWidth('20'); // fixes size

// 				$objWorkSheet->getStyle('C4:D5') ->getAlignment()->setWrapText(true); // wrap
 			
//  				$objWorkSheet->setTitle($m->form_title);
//  			}


   
 
// 		// $styleArray = array(
// 		//   'borders' => array(
// 		//     'allborders' => array(
// 		//       'style' => PHPExcel_Style_Border::BORDER_DOUBLE
// 		//     )
// 		//   )
// 		// );  

// 		// $objPHPExcel->getActiveSheet()->getStyle('A3:C3')->applyFromArray($styleArray);
// 		// unset($styleArray);
// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('50');
// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
// 		// $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
// 		// $objPHPExcel->getActiveSheet()->getStyle('C6:C7') ->getAlignment()->setWrapText(true); 


//         header('Content-Type: application/vnd.ms-excel'); //mime type
//         header('Content-Disposition: attachment;filename="filename.xls"'); //tell browser what's the file name
//         header('Cache-Control: max-age=0'); //no cache

// 		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
// 		$objWriter->save('php://output');
// 		exit; 

// }

public function get_score($q,$no){
		$MyGeneralForm = $this->report_pms_model->general_form($q);//desc
$recommendation_portal = $this->report_pms_model->recommendation_portal($no);//desc
	$CountGeneralForms = $this->report_pms_model->CountGeneralForms();

	$PmsSetting = $q;
	$view_score = $this->report_pms_model->get_score($q);
	$fscore = $this->report_pms_model->fscore($no);
	$this->load->library('PHPExcel');
	$objPHPExcel = new PHPExcel();
	 $activeSheet = $objPHPExcel->getActiveSheet();

    //...
     $activeSheet->getStyle("A")
                 ->getAlignment()
                 ->setHorizontal(\PHPExcel_Style_Alignment::VERTICAL_CENTER);
	$i=0;
	$formPartsTotal=$CountGeneralForms->countId;
    $columnarray = array(
                'A',
                'B',
                'C',
                'D',
                'E',
                'F',
                'G',
                'H',
                'I',
                'J',
                'K');

//==Start Cover & instructions.
$coverWorkSheet = $objPHPExcel->createSheet($i);
$coverWorkSheet->mergeCells('G4:I4')->setCellValue('G4', 'PERFORMANCE APPRAISAL FORM (PAF)');

$row=2;



$coverWorkSheet->setCellValue('A4', 'Form title')->getStyle("A4")->getFont()->setBold( true );
$coverWorkSheet->setCellValue('B4', 'Weight')->getStyle("B4")->getFont()->setBold( true );
$coverWorkSheet->setCellValue('C4', 'Part rating  ')->getStyle("C4")->getFont()->setBold( true );
$coverWorkSheet->setCellValue('D4', 'Rating  ')->getStyle("D4")->getFont()->setBold( true );

$objRichText = new PHPExcel_RichText();
$regularization = new PHPExcel_RichText();
$promotion = new PHPExcel_RichText();
$demotion = new PHPExcel_RichText();
$extend_probationary_period = new PHPExcel_RichText();
$contract_renewal = new PHPExcel_RichText();
$for_lateral_transfer = new PHPExcel_RichText();



;
$qwe = new PHPExcel_RichText();
		$objBold =	$qwe->createTextRun('position:');
if(!empty($recommendation_portal->pos4)){
	$recommendation_portal = $recommendation_portal->pos4;
}else{
	$recommendation_portalpos4 = '';
}
 $qwe->createText($recommendation_portalpos4);


$objBold->getFont()->setBold(true);
if(!empty($recommendation_portal->regularization)){
	$objBold =	$regularization->createTextRun('Date:');

 $regularization->createText($recommendation_portal->date);
$objBold->getFont()->setBold(true);
	$coverWorkSheet->setCellValue('H6','✓' );
	$coverWorkSheet->setCellValue('I6', $regularization);

}
if(!empty($recommendation_portal->promotion)){
	$objBold =	$promotion->createTextRun('position:');

 $promotion->createText($recommendation_portal->pos);
$objBold->getFont()->setBold(true);
		$coverWorkSheet->setCellValue('H8','✓' );
		$coverWorkSheet->setCellValue('I8', $promotion);


}
if(!empty($recommendation_portal->demotion)){

		$objBold =	$demotion->createTextRun('position:');

 $demotion->createText($recommendation_portal->pos4);
$objBold->getFont()->setBold(true);

	$coverWorkSheet->setCellValue('H10','✓' );
	$coverWorkSheet->setCellValue('I10', $demotion);

}
if(!empty($recommendation_portal->retain_in_existing_position)){
	$coverWorkSheet->setCellValue('H12','✓' );


}
if(!empty($recommendation_portal->extend_probationary_period)){
		$objBold =	$extend_probationary_period->createTextRun('no of months:');

 $extend_probationary_period->createText($recommendation_portal->pos);
$objBold->getFont()->setBold(true);
			$coverWorkSheet->setCellValue('I14',$extend_probationary_period);
	$coverWorkSheet->setCellValue('H14','✓' );
}
	

if(!empty($recommendation_portal->contract_renewal)){
			$objBold =	$contract_renewal->createTextRun('from');

 $contract_renewal->createText($recommendation_portal->from);
$objBold->getFont()->setBold(true);

			$objBold =	$contract_renewal->createTextRun('to');

 $contract_renewal->createText($recommendation_portal->to);
$objBold->getFont()->setBold(true);



	$coverWorkSheet->setCellValue('I16',$contract_renewal);
	$coverWorkSheet->setCellValue('H16','✓' );
}
if(!empty($recommendation_portal->end_of_contract)){
	$coverWorkSheet->setCellValue('H18','✓' );
}
if(!empty($recommendation_portal->for_lateral_transfer)){
			$objBold =	$for_lateral_transfer->createTextRun('position:');

 $for_lateral_transfer->createText("$recommendation_portal->c_position \n" );
$objBold->getFont()->setBold(true);
			$objBold =	$for_lateral_transfer->createTextRun('department:');

 $for_lateral_transfer->createText($recommendation_portal->c_department );
$objBold->getFont()->setBold(true);

		$coverWorkSheet->setCellValue('I20',$for_lateral_transfer);
	$coverWorkSheet->setCellValue('H20','              ✓' );
	$coverWorkSheet->getStyle('I20')->applyFromArray(
   array(
     
              'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )

    )
)->getAlignment()->setWrapText(true); 
}
if(!empty($recommendation_portal->salary_increase)){
$objBold =	$objRichText->createTextRun('Salary:');

 $objRichText->createText($recommendation_portal->salary);
$objBold->getFont()->setBold(true);


		$coverWorkSheet->setCellValue('I22',$objRichText);
	$coverWorkSheet->setCellValue('H22','✓' );
}


$coverWorkSheet->setCellValue('G6', 'regularization  ');
$coverWorkSheet->setCellValue('G8', 'promotion');
$coverWorkSheet->setCellValue('G10', 'demotion  ');
$coverWorkSheet->setCellValue('G12', 'retain in existing position  ');
$coverWorkSheet->setCellValue('G14', 'extend probationary period  ');


$coverWorkSheet->setCellValue('G16', 'contract renewal  ');
$coverWorkSheet->setCellValue('G18', 'end of contract   ');
$coverWorkSheet->setCellValue('G20', 'for lateral transfer     ');
$coverWorkSheet->setCellValue('G22', 'salary increase     ');

$BStyle = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_THIN
    )
  )
);
$coverWorkSheet->getStyle('G4:I22')->applyFromArray($BStyle);

$coverWorkSheet->getColumnDimension('A')->setWidth('20'); // fixes size
$coverWorkSheet->getColumnDimension('B')->setWidth('50'); // fixes size
$coverWorkSheet->getColumnDimension('G')->setWidth('50'); // fixes size
$coverWorkSheet->getColumnDimension('H')->setWidth('20'); // fixes size
$coverWorkSheet->getColumnDimension('I')->setWidth('50'); // fixes size

$coverWorkSheet->getStyle('A4:B4') ->getAlignment()->setWrapText(true); // wrap
$coverWorkSheet->getStyle('A:B')->applyFromArray(
array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    )
);

$coverWorkSheet->getStyle('A:B')->applyFromArray(
array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        ),
    )
);
$row=6;
//$MyAscGeneralForm = $this->report_pms_model->GetAscGeneralForms();//ascending gen form

$row=5;

$finaltotal = 0;
$weight = 0;
foreach($fscore as $g){
	$col=0;
	$coverWorkSheet->setCellValue($columnarray[$col].$row, $g->form_title);
	$col++;
	$coverWorkSheet->setCellValue($columnarray[$col].$row, $g->weight);
	$col++;
		$coverWorkSheet->setCellValue($columnarray[$col].$row, $g->part_rating);
		$col++;
			$coverWorkSheet->setCellValue($columnarray[$col].$row, $g->total_rating);


		$row++;



		$finaltotal += $g->total_rating;
		$weight +=$g->weight;

	$coverWorkSheet->getStyle('A'.$row.':B'.$row.'') ->getAlignment()->setWrapText(true);


	$row=$row+1;
}

$coverWorkSheet->getStyle("A$row:D$row")->applyFromArray($BStyle);
$coverWorkSheet->setCellValue($columnarray[$col].$row, $finaltotal);
$coverWorkSheet->getStyle( 'B'.$row )->getFont()->setBold( true );
		$coverWorkSheet->setCellValue('B'.$row, $weight);
		$coverWorkSheet->getStyle( 'A'.$row )->getFont()->setBold( true );
		$coverWorkSheet->setCellValue('A'.$row, 'FINAL RATING');



$coverWorkSheet->setTitle('Cover & Instructions');
$coverWorkSheet->getStyle('G4')->applyFromArray(
   array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'A4C639')
        ),
              'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )

    )
);
$coverWorkSheet->getStyle('A3:D3')->applyFromArray(
 array(
        'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,
            'color' => array('rgb' => 'A4C639')
        ),
              'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )

    )
);
$coverWorkSheet->getStyle('A4:D4')->applyFromArray(
 array(
       
              'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )

    )
);








// ==End Cover & instructions.
			
	$style = array(
        'alignment' => array(
            'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
               'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
        )
    );

    $activeSheet->getDefaultStyle()->applyFromArray($style);

 			foreach($MyGeneralForm as $m){
 				 $i=$i+1;
 				 $objWorkSheet = $objPHPExcel->createSheet($i); //Setting index when creating
 				 $form_part_id=$m->fid;
 				 $form_part=$m->form_part;
 				 $form_title=$m->form_title;
 				 $form_instruction=$m->form_instruction;
 				 
		                $objWorkSheet->setCellValue('A1', 'Part: '.$form_part.'');
		                $objWorkSheet->setCellValue('B1', $form_title);
		                $row=3;

		                $objWorkSheet->setCellValue('A3', 'Instructions');
		                $row=4;
		                $objWorkSheet->setCellValue('C4', $form_instruction);

		                // $row=6;

		                $objWorkSheet->setCellValue('A5', 'Score');
		                $objWorkSheet->setCellValue('B5', 'Score Equivalent');
		                $objWorkSheet->setCellValue('C5', 'Score Guide');

		                $row=7;

 				 $ScoreRate=$this->report_pms_model->GetScoreRate($form_part_id);

					$styleArray = array(
					  'borders' => array(
					    'allborders' => array(
					      'style' => PHPExcel_Style_Border::BORDER_THIN
					    )
					  ),
					  'fill' => array(
            'type' => PHPExcel_Style_Fill::FILL_SOLID,  
            'color' => array('rgb' => 'A4C639')
        ),
         'alignment' => array(
       'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
       'vertical' => PHPExcel_Style_Alignment::VERTICAL_CENTER,
   ) 
					); 



 				 if(!empty($ScoreRate)){
		                foreach($ScoreRate as $idata){
		                    $col=0;
		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->score);    
		                    $col++;
		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->score_equivalent);
		                    $col++;
		                    $objWorkSheet->setCellValue($columnarray[$col].$row, $idata->scoring_guide);
		                    $row++;

		                }
 				 }else{

 				 }

 				 $row=$row+1;
 				 		$scoring_posLoc="A$row";
 				 		$scoring_areaLoc="B$row";
 				 		$scoring_detailsLoc="C$row";
 				 		$scoring_weighTLoc="D$row";
 				 		$scoring_scoreLoc="E$row";
 				 		$scoring_ratingLoc="F$row";
 				 		

		                $objWorkSheet->setCellValue($scoring_posLoc, 'Position');
		                $objWorkSheet->setCellValue($scoring_areaLoc, 'Area');
		                $objWorkSheet->setCellValue($scoring_detailsLoc, 'Details');
		                $objWorkSheet->setCellValue($scoring_weighTLoc, 'Weight');
		                 $objWorkSheet->setCellValue($scoring_scoreLoc, 'Score/Level');
		                  $objWorkSheet->setCellValue($scoring_ratingLoc, 'Rating/Weighted score');

		                $objWorkSheet->getStyle($scoring_posLoc.':'.$scoring_ratingLoc)->applyFromArray($styleArray);

		        $ScoreCriteria=$this->report_pms_model->get_criteria($q,$form_part_id);
		        $ScoreCriteriaGeneral=$this->report_pms_model->GetScoreCriteriaGeneral($form_part_id);
		       	$row=$row+1;
		 
		       	$final = 0;
		       	$weights = 0;
		        if(!empty($ScoreCriteria)){
		       

		                foreach($ScoreCriteria['result'] as $idata){
		                  
		                    $objWorkSheet->setCellValue('A'.$row, $idata->position);    
		                   		          
   							$objWorkSheet->setCellValue('B'.$row, $idata->area);
		                   
		             		$ws = $this->report_pms_model->criteira_s($idata->cid);
		             		foreach($ws as $ws){
		                    $objWorkSheet->setCellValue('C'.$row, $ws->description);
		                  
		         
		                    $objWorkSheet->setCellValue('D'.$row, $ws->weight);
		                   
		              		
		                    $objWorkSheet->setCellValue('E'.$row, $ws->score);
		                    
		          
		                    $objWorkSheet->setCellValue('F'.$row, $ws->rating);
		             
		             	  	$row++;

		             	}	
		                	
		                 
		              
		                  
		                    $weights += $ws->weight;
		                    $final += $ws->rating;
		                }
		                $objWorkSheet->mergeCells('A15:A16');
		                $objWorkSheet->setCellValue('D'.$row,$weights);
		                $objWorkSheet->getStyle("A$row:F$row")->applyFromArray($BStyle);
		                $objWorkSheet->setCellValue('F'.$row,$final);
		             		$objWorkSheet->setCellValue('C'.$row, 'TOTAL AND RATING ' );
		        }else{

		        }

				// border & autosize
				foreach(range('A','C') as $v){
				$objWorkSheet->getStyle(''.$v.'3:'.$v.'3')->applyFromArray($styleArray);
				$objWorkSheet->getStyle(''.$v.'5:'.$v.'5')->applyFromArray($styleArray);
	
				$objWorkSheet->getStyle('C4:D999')->getAlignment()->setWrapText(true); 
				}
				// $objWorkSheet->getStyle('A3:C3')->applyFromArray($styleArray);
				unset($styleArray);

				// $objWorkSheet->getColumnDimension('A')->setAutoSize(true); //autosize
				$objWorkSheet->getColumnDimension('C')->setWidth('100'); // fixes size
				$objWorkSheet->getColumnDimension('B')->setWidth('20'); // fixes size
				$objWorkSheet->getColumnDimension('A')->setWidth('20'); // fixes size
				$objWorkSheet->getColumnDimension('D')->setWidth('20'); // fixes size
				$objWorkSheet->getColumnDimension('E')->setWidth('20'); // fixes size
				$objWorkSheet->getColumnDimension('F')->setWidth('20'); // fixes size

				$objWorkSheet->getStyle('C4:D5') ->getAlignment()->setWrapText(true); // wrap
 			
 				$objWorkSheet->setTitle($m->form_title);
 			}


   
 
		// $styleArray = array(
		//   'borders' => array(
		//     'allborders' => array(
		//       'style' => PHPExcel_Style_Border::BORDER_DOUBLE
		//     )
		//   )
		// );  

		// $objPHPExcel->getActiveSheet()->getStyle('A3:C3')->applyFromArray($styleArray);
		// unset($styleArray);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth('50');
		// $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setAutoSize(true);
		// $objPHPExcel->getActiveSheet()->getStyle('C6:C7') ->getAlignment()->setWrapText(true); 


        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="filename.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit; 



}


public function testExcelStyle(){

$objPHPExcel = new PHPExcel();
$objPHPExcel->setActiveSheetIndex(0);
$objPHPExcel->getActiveSheet()->setTitle('Example');

$objPHPExcel->getActiveSheet()->setCellValue('A1','Text 1Text 1Text 1Text 1Text 1Text 1');
$objPHPExcel->getActiveSheet()->setCellValue('A2','Text 3');
$objPHPExcel->getActiveSheet()->setCellValue('B1','Text 2');
$objPHPExcel->getActiveSheet()->setCellValue('B2','Text 4');
$objPHPExcel->getActiveSheet()->setCellValue('C1','Text 4Text 4Text 4Text 4Text 4Text 4Text 4Text 4Text 4Text 4Text 4Text 4Text 4');

$styleArray = array(
  'borders' => array(
    'allborders' => array(
      'style' => PHPExcel_Style_Border::BORDER_DOUBLE
    )
  )
);

$objPHPExcel->getActiveSheet()->getStyle('A1:B2')->applyFromArray($styleArray);
unset($styleArray);
// $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth('90');
$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize(true);
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setAutoSize(true);


        header('Content-Type: application/vnd.ms-excel'); //mime type
        header('Content-Disposition: attachment;filename="textExcelStyle.xls"'); //tell browser what's the file name
        header('Cache-Control: max-age=0'); //no cache

					
		$objWriter = IOFactory::createWriter($objPHPExcel, 'Excel2007');
		$objWriter->save('php://output');
		exit; 

}

}	
