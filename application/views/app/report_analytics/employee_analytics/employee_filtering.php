<div class="col-md-12">
      <ul class="nav nav-tabs">
            <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>&nbsp;Generate Reports | <?php echo $code_details;?></b></n></a> </li>
      </ul>
    </div>

<div class="col-md-12">
    <div class="col-md-12" style="margin-top: 40px;">
       
        <br>

        <?php if($code=='E1')
        {?>

          <form action="<?php echo base_url()?>app/report_analytics_employees/result/<?php echo $code;?>" target="_blank" method="post" id="get_employee_count" target="_blank">

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Company:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="company<?php echo $code;?>" id="company<?php echo $code;?>" onchange="checker_company('<?php echo $code;?>',this.value);">
                      <option value="" disabled selected>Select Company</option>
                      <option style="color:red;">All</option>
                      <option style="color:red;">Multiple</option>
                      <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                      <?php } ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;display: none;" id="companymultiple<?php echo $code;?>">
                    <div class="col-md-12"><label>Select Multiple Company:</label></div>
                    <div class="col-md-12">
                        <?php $i=0; foreach ($companyList as $c) {?>
                            <div class="col-md-12">
                                <input type="checkbox" id="multiple<?php echo $c->company_id;?>" class="multiple" value="<?php echo $c->company_id;?>" onclick="get_multiple('<?php echo $code;?>');">&nbsp;<?php echo $c->company_name;?>
                            </div>
                        <?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";?>

                    </div>
                </div>

                <input type="hidden" name="final_result" id="final_result" value="" required>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Graph Type:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="graph" id="graph<?php echo $code;?>">
                            <option value="Bar">Bar Graph</option>
                            <option value="Line">Line Graph</option>
                            <option value="Area">Area Graph</option>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Color Code:</label></div>
                    <div class="col-md-12"><input type="color" name="color" id="color<?php echo $code;?>" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Analytics Title:</label></div>
                    <div class="col-md-12"><input type="text" name="title" id="title<?php echo $code;?>e" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12">
                    <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
                    </div>
                </div>

          </form>

        <?php } else if($code=='E2'){ ?>


          <form action="<?php echo base_url()?>app/report_analytics_employees/result/<?php echo $code;?>" target="_blank" method="post" id="get_employee_count" target="_blank">

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Company:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="company<?php echo $code;?>" id="company<?php echo $code;?>" onchange="get_division('<?php echo $code;?>',this.value);">
                      <option value="" disabled selected>Select Company</option>
                      <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                      <?php } ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Division:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="division<?php echo $code;?>" id="division<?php echo $code;?>" onchange="multipledivision('<?php echo $code;?>',this.value);">
                      
                      </select>
                    </div>
                </div>
                
                <div class="col-md-12"  style="margin-top: 10px;display: none;" id="multipledivision_view">
                    <div class="col-md-12"><label>Select Multiple Division:</label></div>
                    <div class="col-md-12" id="multipledivision">
                      
                    </div>
                </div>


                 <input type="hidden" name="final_result" id="final_result" value="" required>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Graph Type:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="graph" id="graph<?php echo $code;?>">
                            <option value="Bar">Bar Graph</option>
                            <option value="Line">Line Graph</option>
                            <option value="Area">Area Graph</option>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Color Code:</label></div>
                    <div class="col-md-12"><input type="color" name="color" id="color<?php echo $code;?>" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Analytics Title:</label></div>
                    <div class="col-md-12"><input type="text" name="title" id="title<?php echo $code;?>e" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12">
                    <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
                    </div>
                </div>

          </form>


        <?php } else if($code=='E3'){ ?>



          <form action="<?php echo base_url()?>app/report_analytics_employees/result/<?php echo $code;?>" target="_blank" method="post" id="get_employee_count" target="_blank">

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Company:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="company<?php echo $code;?>" id="company<?php echo $code;?>" onchange="get_division('<?php echo $code;?>',this.value);">
                      <option value="" disabled selected>Select Company</option>
                      <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                      <?php } ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Division:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="division<?php echo $code;?>" id="division<?php echo $code;?>" onchange="get_department('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>
                
                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Department:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="department<?php echo $code;?>" id="department<?php echo $code;?>" onchange="multipledepartment('<?php echo $code;?>',this.value);">
                      
                      </select>
                    </div>
                </div>

                 <div class="col-md-12"  style="margin-top: 10px;display: none;" id="multipledepartment_view">
                    <div class="col-md-12"><label>Select Multiple Department:</label></div>
                    <div class="col-md-12" id="multipledepartment">
                      
                    </div>
                </div>


                <input type="hidden" name="final_result" id="final_result" value="" required>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Graph Type:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="graph" id="graph<?php echo $code;?>">
                            <option value="Bar">Bar Graph</option>
                            <option value="Line">Line Graph</option>
                            <option value="Area">Area Graph</option>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Color Code:</label></div>
                    <div class="col-md-12"><input type="color" name="color" id="color<?php echo $code;?>" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Analytics Title:</label></div>
                    <div class="col-md-12"><input type="text" name="title" id="title<?php echo $code;?>e" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12">
                    <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
                    </div>
                </div>

          </form>


          <?php } else if($code=='E4'){?>



          <form action="<?php echo base_url()?>app/report_analytics_employees/result/<?php echo $code;?>" target="_blank" method="post" id="get_employee_count" target="_blank">

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Company:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="company<?php echo $code;?>" id="company<?php echo $code;?>" onchange="get_division('<?php echo $code;?>',this.value);">
                      <option value="" disabled selected>Select Company</option>
                      <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                      <?php } ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Division:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="division<?php echo $code;?>" id="division<?php echo $code;?>" onchange="get_department('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>
                
                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Department:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="department<?php echo $code;?>" id="department<?php echo $code;?>" onchange="get_section('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Section:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="section<?php echo $code;?>" id="section<?php echo $code;?>" onchange="multiplesection('<?php echo $code;?>',this.value);">
                      
                      </select>
                    </div>
                </div>

                 <div class="col-md-12"  style="margin-top: 10px;display: none;" id="multiplesection_view">
                    <div class="col-md-12"><label>Select Multiple Section:</label></div>
                    <div class="col-md-12" id="multiplesection">
                      
                    </div>
                </div>


                <input type="hidden" name="final_result" id="final_result" value="" required>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Graph Type:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="graph" id="graph<?php echo $code;?>">
                            <option value="Bar">Bar Graph</option>
                            <option value="Line">Line Graph</option>
                            <option value="Area">Area Graph</option>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Color Code:</label></div>
                    <div class="col-md-12"><input type="color" name="color" id="color<?php echo $code;?>" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Analytics Title:</label></div>
                    <div class="col-md-12"><input type="text" name="title" id="title<?php echo $code;?>e" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12">
                    <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
                    </div>
                </div>

          </form>


          <?php } else if($code=='E5'){?>


             <form action="<?php echo base_url()?>app/report_analytics_employees/result/<?php echo $code;?>" target="_blank" method="post" id="get_employee_count" target="_blank">

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Company:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="company<?php echo $code;?>" id="company<?php echo $code;?>" onchange="get_division('<?php echo $code;?>',this.value);">
                      <option value="" disabled selected>Select Company</option>
                      <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                      <?php } ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Division:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="division<?php echo $code;?>" id="division<?php echo $code;?>" onchange="get_department('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>
                
                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Department:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="department<?php echo $code;?>" id="department<?php echo $code;?>" onchange="get_section('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Section:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="section<?php echo $code;?>" id="section<?php echo $code;?>" onchange="get_subsection('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Subsection:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="subsection<?php echo $code;?>" id="subsection<?php echo $code;?>" onchange="multiplesubsection('<?php echo $code;?>',this.value);">
                      
                      </select>
                    </div>
                </div>

                 <div class="col-md-12"  style="margin-top: 10px;display: none;" id="multiplesubsection_view">
                    <div class="col-md-12"><label>Select Multiple Subsection:</label></div>
                    <div class="col-md-12" id="multiplesubsection">
                      
                    </div>
                </div>


                <input type="hidden" name="final_result" id="final_result" value="" required>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Graph Type:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="graph" id="graph<?php echo $code;?>">
                            <option value="Bar">Bar Graph</option>
                            <option value="Line">Line Graph</option>
                            <option value="Area">Area Graph</option>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Color Code:</label></div>
                    <div class="col-md-12"><input type="color" name="color" id="color<?php echo $code;?>" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Analytics Title:</label></div>
                    <div class="col-md-12"><input type="text" name="title" id="title<?php echo $code;?>e" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12">
                    <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
                    </div>
                </div>

          </form>

        <?php } else if($code=='E6'){?>

            <form action="<?php echo base_url()?>app/report_analytics_employees/result/<?php echo $code;?>" target="_blank" method="post" id="get_employee_count" target="_blank">

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Company:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="company<?php echo $code;?>" id="company<?php echo $code;?>" onchange="get_division('<?php echo $code;?>',this.value);">
                      <option value="" disabled selected>Select Company</option>
                      <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                      <?php } ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Division:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="division<?php echo $code;?>" id="division<?php echo $code;?>" onchange="get_department('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>
                
                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Department:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="department<?php echo $code;?>" id="department<?php echo $code;?>" onchange="get_section('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Section:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="section<?php echo $code;?>" id="section<?php echo $code;?>" onchange="get_subsection('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Subsection:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="subsection<?php echo $code;?>" id="subsection<?php echo $code;?>" >
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Location:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="location<?php echo $code;?>" id="location<?php echo $code;?>" onchange="multiplelocation('<?php echo $code;?>',this.value);">
                      
                      </select>
                    </div>
                </div>


                <div class="col-md-12"  style="margin-top: 10px;display: none;" id="multiplelocation_view">
                    <div class="col-md-12"><label>Select Multiple Location:</label></div>
                    <div class="col-md-12" id="multiplelocation">
                      
                    </div>
                </div>


                <input type="hidden" name="final_result" id="final_result" value="" required>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Graph Type:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="graph" id="graph<?php echo $code;?>">
                            <option value="Bar">Bar Graph</option>
                            <option value="Line">Line Graph</option>
                            <option value="Area">Area Graph</option>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Color Code:</label></div>
                    <div class="col-md-12"><input type="color" name="color" id="color<?php echo $code;?>" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Analytics Title:</label></div>
                    <div class="col-md-12"><input type="text" name="title" id="title<?php echo $code;?>e" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12">
                    <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
                    </div>
                </div>

          </form>


        <?php }  else if($code=='E7'){?>

          <form action="<?php echo base_url()?>app/report_analytics_employees/result/<?php echo $code;?>" target="_blank" method="post" id="get_employee_count" target="_blank">

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Company:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="company<?php echo $code;?>" id="company<?php echo $code;?>" onchange="get_division('<?php echo $code;?>',this.value);">
                      <option value="" disabled selected>Select Company</option>
                      <?php foreach($companyList as $c){?>
                        <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                      <?php } ?>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Division:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="division<?php echo $code;?>" id="division<?php echo $code;?>" onchange="get_department('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>
                
                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Department:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="department<?php echo $code;?>" id="department<?php echo $code;?>" onchange="get_section('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Section:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="section<?php echo $code;?>" id="section<?php echo $code;?>" onchange="get_subsection('<?php echo $code;?>',this.value)">
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Subsection:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="subsection<?php echo $code;?>" id="subsection<?php echo $code;?>" >
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Location:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="location<?php echo $code;?>" id="location<?php echo $code;?>" onchange="multiplelocation('<?php echo $code;?>',this.value);">
                      
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Classification:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="classification<?php echo $code;?>" id="classification<?php echo $code;?>" onchange="multipleclassification('<?php echo $code;?>',this.value);">
                      
                      </select>
                    </div>
                </div>


                <div class="col-md-12"  style="margin-top: 10px;display: none;" id="multipleclassification_view">
                    <div class="col-md-12"><label>Select Multiple Classification:</label></div>
                    <div class="col-md-12" id="multipleclassification">
                      
                    </div>
                </div>


                <input type="hidden" name="final_result" id="final_result" value="" required>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Graph Type:</label></div>
                    <div class="col-md-12">
                      <select class="form-control" name="graph" id="graph<?php echo $code;?>">
                            <option value="Bar">Bar Graph</option>
                            <option value="Line">Line Graph</option>
                            <option value="Area">Area Graph</option>
                      </select>
                    </div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Color Code:</label></div>
                    <div class="col-md-12"><input type="color" name="color" id="color<?php echo $code;?>" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12"><label>Analytics Title:</label></div>
                    <div class="col-md-12"><input type="text" name="title" id="title<?php echo $code;?>e" class="form-control" required></div>
                </div>

                <div class="col-md-12"  style="margin-top: 10px;">
                    <div class="col-md-12">
                    <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
                    </div>
                </div>

          </form>

        <?php } else if($code=='E8'){ ?>


          <form action="<?php echo base_url()?>app/report_analytics_employees/result/<?php echo $code;?>" target="_blank" method="post" id="get_employee_count" target="_blank">

                <div class="col-md-6">

                     <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Graph Type:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="graph" id="graph<?php echo $code;?>">
                                  <option value="Bar">Bar Graph</option>
                                  <option value="Line">Line Graph</option>
                                  <option value="Area">Area Graph</option>
                            </select>
                          </div>
                      </div>
                      
                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Analytics Title:</label></div>
                          <div class="col-md-12"><input type="text" name="title" id="title<?php echo $code;?>e" class="form-control" required></div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Division:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="division<?php echo $code;?>" id="division<?php echo $code;?>" onchange="get_department('<?php echo $code;?>',this.value)">
                            
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Section:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="section<?php echo $code;?>" id="section<?php echo $code;?>" onchange="get_subsection('<?php echo $code;?>',this.value)">
                            
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Location:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="location<?php echo $code;?>" id="location<?php echo $code;?>" onchange="multiplelocation('<?php echo $code;?>',this.value);">
                            
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Employment:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="employment<?php echo $code;?>" id="employment<?php echo $code;?>" onchange="multipleemployment('<?php echo $code;?>',this.value);">
                                <option value="" disabled selected>Select Employment</option>
                                <option value="All" style="color:red;">All</option>
                                <option value="Multiple" style="color:red;">Multiple</option>
                                <?php foreach($employmentList as $emp){?>
                                    <option value="<?php echo $emp->employment_id;?>"><?php echo $emp->employment_name;?></option>
                                <?php } ?>
                            </select>
                          </div>
                      </div>


                </div>


                <div class="col-md-6">

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Color Code:</label></div>
                          <div class="col-md-12"><input type="color" name="color" id="color<?php echo $code;?>" class="form-control" required></div>
                      </div>
                      
                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Company:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="company<?php echo $code;?>" id="company<?php echo $code;?>" onchange="get_division('<?php echo $code;?>',this.value);">
                            <option value="" disabled selected>Select Company</option>
                            <?php foreach($companyList as $c){?>
                              <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                            <?php } ?>
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Department:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="department<?php echo $code;?>" id="department<?php echo $code;?>" onchange="get_section('<?php echo $code;?>',this.value)">
                            
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Subsection:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="subsection<?php echo $code;?>" id="subsection<?php echo $code;?>" >
                            
                            </select>
                          </div>
                      </div>
                      
                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Classification:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="classification<?php echo $code;?>" id="classification<?php echo $code;?>">
                            
                            </select>
                          </div>
                      </div>

                  <input type="hidden" name="final_result" id="final_result" value="" required>

                </div>

                <div class="col-md-12">
                 <div class="col-md-12"  style="margin-top: 10px;display: none;" id="multipleemployment_view">
                          <div class="col-md-12"><label>Select Multiple Employment:</label></div>
                          <div class="col-md-12" id="multipleemployment">
                              <?php
                                $i=0;
                                foreach($employmentList as $f)
                                {?>
                                  
                                  <div class="col-md-12">
                                              <input type="checkbox" id="multiple<?php echo $f->employment_id;?>" class="multiple" value="<?php echo $f->employment_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->employment_name;?>
                                          </div>

                                <?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";?>
                          </div>
                      </div>
                </div>

                 <div class="col-md-12"  style="margin-top: 10px;">
                    <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
                </div>

          </form>



        <?php } else{?>


           <form action="<?php echo base_url()?>app/report_analytics_employees/result/<?php echo $code;?>" target="_blank" method="post" id="get_employee_count" target="_blank">

                <div class="col-md-6">

                     <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Graph Type:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="graph" id="graph<?php echo $code;?>">
                                  <option value="Bar">Bar Graph</option>
                                  <option value="Line">Line Graph</option>
                                  <option value="Area">Area Graph</option>
                            </select>
                          </div>
                      </div>
                      
                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Analytics Title:</label></div>
                          <div class="col-md-12"><input type="text" name="title" id="title<?php echo $code;?>e" class="form-control" required></div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Division:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="division<?php echo $code;?>" id="division<?php echo $code;?>" onchange="get_department('<?php echo $code;?>',this.value)">
                            
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Section:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="section<?php echo $code;?>" id="section<?php echo $code;?>" onchange="get_subsection('<?php echo $code;?>',this.value)">
                            
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Location:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="location<?php echo $code;?>" id="location<?php echo $code;?>" onchange="multiplelocation('<?php echo $code;?>',this.value);">
                            
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Employment:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="employment<?php echo $code;?>" id="employment<?php echo $code;?>" onchange="multipleemployment('<?php echo $code;?>',this.value);">
                                <option value="" disabled selected>Select Employment</option>
                                <option value='All' style='color:red;'>All</option>
                                <?php foreach($employmentList as $emp){?>
                                    <option value="<?php echo $emp->employment_id;?>"><?php echo $emp->employment_name;?></option>
                                <?php } ?>
                            </select>
                          </div>
                      </div>


                </div>


                <div class="col-md-6">

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Color Code:</label></div>
                          <div class="col-md-12"><input type="color" name="color" id="color<?php echo $code;?>" class="form-control" required></div>
                      </div>
                      
                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Company:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="company<?php echo $code;?>" id="company<?php echo $code;?>" onchange="get_division('<?php echo $code;?>',this.value);">
                            <option value="" disabled selected>Select Company</option>
                            <?php foreach($companyList as $c){?>
                              <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                            <?php } ?>
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Department:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="department<?php echo $code;?>" id="department<?php echo $code;?>" onchange="get_section('<?php echo $code;?>',this.value)">
                            
                            </select>
                          </div>
                      </div>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Subsection:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="subsection<?php echo $code;?>" id="subsection<?php echo $code;?>" >
                            
                            </select>
                          </div>
                      </div>
                      
                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Classification:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="classification<?php echo $code;?>" id="classification<?php echo $code;?>">
                            
                            </select>
                          </div>
                      </div>

                      <?php if($code=='E9'){?>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Taxcode:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="taxcode<?php echo $code;?>" id="taxcode<?php echo $code;?>" onchange="multipleothers('<?php echo $code;?>',this.value);">
                                <option value="" disabled selected>Select Taxcode</option>
                                <option value="All" style="color:red;">All</option>
                                <option value="Multiple" style="color:red;">Multiple</option>
                                <?php foreach($taxcodeList as $t){?>
                                    <option value="<?php echo $t->taxcode_id;?>"><?php echo $t->taxcode;?></option>
                                <?php } ?>
                            </select>
                          </div>
                      </div>

                    <?php } elseif($code=='E10'){?>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Employee Status:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="status<?php echo $code;?>" id="status<?php echo $code;?>">
                                <option value="" disabled selected>Select Status</option>
                                <option value="All" style="color:red;">All</option>
                                <option value="1">InActive</option>
                                <option value="0">Active</option>
                            </select>
                          </div>
                      </div>

                    <?php } else if($code=='E13'){?>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Civil Status:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="civilstatus<?php echo $code;?>" id="civilstatus<?php echo $code;?>" onchange="multipleothers('<?php echo $code;?>',this.value);">
                                <option value="" disabled selected>Select Civil Status</option>
                                <option value="All" style="color:red;">All</option>
                                <option value="Multiple" style="color:red;">Multiple</option>

                                <?php foreach($civilStatusList as $c)
                                {
                                  echo "<option value='".$c->civil_status_id."'>".$c->civil_status."</option>";
                                }
                                ?>
                            </select>
                          </div>
                      </div>


                    <?php } else if($code=='E14'){?>

                       <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Gender:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="gender<?php echo $code;?>" id="gender<?php echo $code;?>" onchange="multipleothers('<?php echo $code;?>',this.value);">
                                <option value="" disabled selected>Select Gender</option>
                                <option value="All" style="color:red;">All</option>
                                <option value="Multiple" style="color:red;">Multiple</option>

                                <?php foreach($genderList as $c)
                                {
                                  echo "<option value='".$c->gender_id."'>".$c->gender_name."</option>";
                                }
                                ?>
                            </select>
                          </div>
                      </div>

                    <?php } else if($code=='E15'){?>

                        <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Position:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="position<?php echo $code;?>" id="position<?php echo $code;?>" onchange="multipleothers('<?php echo $code;?>',this.value);">
                                <option value="" disabled selected>Select Position</option>
                                <option value="All" style="color:red;">All</option>
                                <option value="Multiple" style="color:red;">Multiple</option>

                                <?php foreach($positionList as $c)
                                {
                                  echo "<option value='".$c->position_id."'>".$c->position_name."</option>";
                                }
                                ?>
                            </select>
                          </div>
                      </div>


                    <?php  } else if($code=='E17'){?>

                      <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Paytype:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="paytype<?php echo $code;?>" id="paytype<?php echo $code;?>" onchange="multipleothers('<?php echo $code;?>',this.value);">
                                <option value="" disabled selected>Select Paytype</option>
                                <option value="All" style="color:red;">All</option>
                                <option value="Multiple" style="color:red;">Multiple</option>

                                <?php foreach($paytypeList_dtr as $c)
                                {
                                  echo "<option value='".$c->pay_type_id."'>".$c->pay_type_name."</option>";
                                }
                                ?>
                            </select>
                          </div>
                      </div>

                    <?php  } else if($code=='E18'){?>


                       <div class="col-md-12"  style="margin-top: 10px;">
                          <div class="col-md-12"><label>Religion:</label></div>
                          <div class="col-md-12">
                            <select class="form-control" name="religion<?php echo $code;?>" id="religion<?php echo $code;?>" onchange="multipleothers('<?php echo $code;?>',this.value);">
                                <option value="" disabled selected>Select Position</option>
                                <option value="All" style="color:red;">All</option>
                                <option value="Multiple" style="color:red;">Multiple</option>

                                <?php foreach($religionList as $c)
                                {
                                  echo "<option value='".$c->param_id."'>".$c->cValue."</option>";
                                }
                                ?>
                            </select>
                          </div>
                      </div>

                    <?php } ?>

                  <input type="hidden" name="final_result" id="final_result" value="" required>

                </div>

                <div class="col-md-12">
                 <div class="col-md-12"  style="margin-top: 10px;display: none;" id="multipleothers_view">
                          <div class="col-md-12"><label>Select Multiple Employment:</label></div>
                          <div class="col-md-12" id="multipleothers">

                          <?php if($code=='E9')
                          {
                                $i=0;
                                foreach($taxcodeList as $f)
                                {?>
                                  <div class="col-md-6">
                                              <input type="checkbox" id="multiple<?php echo $f->taxcode_id;?>" class="multiple" value="<?php echo $f->taxcode_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->taxcode;?>
                                  </div>
                                <?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";?>

                          <?php } else if($code=='E13'){ 

                                $i=0;
                                foreach($civilStatusList as $f)
                                {?>
                                  <div class="col-md-6">
                                              <input type="checkbox" id="multiple<?php echo $f->civil_status_id;?>" class="multiple" value="<?php echo $f->civil_status_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->civil_status;?>
                                  </div>
                                <?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";?>

                          <?php } else if($code=='E14'){


                                $i=0;
                                foreach($genderList as $f)
                                {?>
                                  <div class="col-md-6">
                                              <input type="checkbox" id="multiple<?php echo $f->gender_id;?>" class="multiple" value="<?php echo $f->gender_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->gender_name;?>
                                  </div>
                                <?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";?>


                          <?php } else if($code=='E15'){

                                $i=0;
                                foreach($positionList as $f)
                                {?>
                                  <div class="col-md-6">
                                              <input type="checkbox" id="multiple<?php echo $f->position_id;?>" class="multiple" value="<?php echo $f->position_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->position_name;?>
                                  </div>
                                <?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";?>


                          <?php } else if($code=='E17'){

                                $i=0;
                                foreach($paytypeList as $f)
                                {?>
                                  <div class="col-md-6">
                                              <input type="checkbox" id="multiple<?php echo $f->pay_type_id;?>" class="multiple" value="<?php echo $f->pay_type_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->pay_type_name;?>
                                  </div>
                                <?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";?>


                          <?php } else if($code=='E18'){

                                $i=0;
                                foreach($religionList as $f)
                                {?>
                                  <div class="col-md-6">
                                              <input type="checkbox" id="multiple<?php echo $f->param_id;?>" class="multiple" value="<?php echo $f->param_id;?>" onclick="get_multiple('<?php echo $code;?>','');">&nbsp;<?php echo $f->cValue;?>
                                  </div>
                                <?php $i++; } echo "<input type='hidden' id='count".$code."' value='".$i."'>";?>

                          <?php } ?>
                          </div>
                      </div>
                </div>

                 <div class="col-md-12"  style="margin-top: 10px;">
                    <button class="col-md-12 btn btn-success btn-sm">FILTER</button>
                </div>

          </form>



        <?php } ?>
    </div>
</div>