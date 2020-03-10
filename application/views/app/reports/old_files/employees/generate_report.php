<div class="box box-success">
        <div class="col-md-12">
          <ul class="nav nav-tabs">
              <li><a><n class="text-danger"><b><i class="fa fa-bars text-danger"></i>Generate Reports | <?php echo $code_details->title;?></b></n></a> </li>
          </ul>
         </div>
        <div class="col-md-12" style="padding-top: 30px;" id="allaction">
            
        <?php $code = $code_details->code; 

             if($code=='E1'){?>

                <div class="col-md-3"></div>
                <div class="col-md-6">
                        
                        
                        <div class="col-md-12">
                            <label>Crystal Report</label>
                            <select class="form-control" id="crystal_report<?php echo $code;?>">
                                <option value="" selected disabled>Select Crystal Report</option>
                                <?php if(empty($crystal_report))
                                    {
                                        echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                    }
                                    foreach($crystal_report as $c){?>
                                        <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Company</label>
                            <select class="form-control" id="company<?php echo $code;?>" onchange="company_multiple('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Company</option>
                                <?php if(!empty($companyList))
                                    {
                                        echo "<option value='All' style='color:red;'>All</option>
                                              <option value='Multiple' style='color:red;'>Multiple</option>";
                                    }
                                    foreach($companyList as $comp){?>
                                        <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;display: none;" id="companymultiple<?php echo $code;?>">
                            <label>Select Multiple Company</label>
                            <?php $i=0; foreach($companyList as $comp){?>
                                   <div class="col-md-12"><input type="checkbox" class="companyclass<?php echo $code;?>" value="<?php echo $comp->company_id;?>">&nbsp;<?php echo $comp->company_name;?></div>
                            <?php $i++; } echo "<input type='hidden' value='".$i."' id='countmultiple".$code."'>"; ?>
                        </div>

                        <div class="col-md-12">
                             <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="E1_result('<?php echo $code;?>');">FILTER</button>
                        </div>
                        

                </div>
                <div class="col-md-3"></div>




        <?php } else if($code=='E2'){?>

                <div class="col-md-3"></div>
                <div class="col-md-6">
                        
                        
                        <div class="col-md-12">
                            <label>Crystal Report</label>
                            <select class="form-control" id="crystal_report<?php echo $code;?>">
                                <option value="" selected disabled>Select Crystal Report</option>
                                <?php if(empty($crystal_report))
                                    {
                                        echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                    }
                                    foreach($crystal_report as $c){?>
                                        <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Company</label>
                            <select class="form-control" id="company<?php echo $code;?>" onchange="company_division('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Company</option>
                                <?php if(empty($companyList))
                                    {
                                        echo "<option value='' >No Company Found.</option>";
                                    }
                                    foreach($companyList as $comp){?>
                                        <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                         <div class="col-md-12">
                            <label>Division</label>
                            <select class="form-control" id="division<?php echo $code;?>">
                                <option value="" selected disabled>Select Division</option>
                            </select>
                        </div>

                        
                        <div class="col-md-12">
                             <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="E2_result('<?php echo $code;?>');">FILTER</button>
                        </div>
                        

                </div>
                <div class="col-md-3"></div>


        <?php } else if($code=='E3'){?>


                <div class="col-md-3"></div>
                <div class="col-md-6">
                        
                        
                        <div class="col-md-12">
                            <label>Crystal Report</label>
                            <select class="form-control" id="crystal_report<?php echo $code;?>">
                                <option value="" selected disabled>Select Crystal Report</option>
                                <?php if(empty($crystal_report))
                                    {
                                        echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                    }
                                    foreach($crystal_report as $c){?>
                                        <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Company</label>
                            <select class="form-control" id="company<?php echo $code;?>" onchange="company_division('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Company</option>
                                <?php if(empty($companyList))
                                    {
                                        echo "<option value='' >No Company Found.</option>";
                                    }
                                    foreach($companyList as $comp){?>
                                        <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                         <div class="col-md-12">
                            <label>Division</label>
                            <select class="form-control" id="division<?php echo $code;?>" onchange="department('<?php echo $code;?>');">
                                <option value="" selected disabled>Select Division</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Department</label>
                            <select class="form-control" id="department<?php echo $code;?>">
                                <option value="" selected disabled>Select Department</option>
                            </select>
                        </div>


                        
                        <div class="col-md-12">
                             <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="E3_result('<?php echo $code;?>');">FILTER</button>
                        </div>
                        
                </div>
                <div class="col-md-3"></div>




        <?php } else if($code=='E4'){?>


                <div class="col-md-3"></div>
                <div class="col-md-6">
                        
                        
                        <div class="col-md-12">
                            <label>Crystal Report</label>
                            <select class="form-control" id="crystal_report<?php echo $code;?>">
                                <option value="" selected disabled>Select Crystal Report</option>
                                <?php if(empty($crystal_report))
                                    {
                                        echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                    }
                                    foreach($crystal_report as $c){?>
                                        <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Company</label>
                            <select class="form-control" id="company<?php echo $code;?>" onchange="company_division('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Company</option>
                                <?php if(empty($companyList))
                                    {
                                        echo "<option value='' >No Company Found.</option>";
                                    }
                                    foreach($companyList as $comp){?>
                                        <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                         <div class="col-md-12">
                            <label>Division</label>
                            <select class="form-control" id="division<?php echo $code;?>" onchange="department('<?php echo $code;?>');">
                                <option value="" selected disabled>Select Division</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Department</label>
                            <select class="form-control" id="department<?php echo $code;?>" onchange="section('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Department</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Section</label>
                            <select class="form-control" id="section<?php echo $code;?>">
                                <option value="" selected disabled>Select Section</option>
                            </select>
                        </div>

                        
                        <div class="col-md-12">
                             <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="E4_result('<?php echo $code;?>');">FILTER</button>
                        </div>
                        
                </div>
                <div class="col-md-3"></div>


        <?php } else if($code=='E5'){?>

                <div class="col-md-3"></div>
                <div class="col-md-6">
                        
                        
                         <div class="col-md-12">
                            <label>Crystal Report</label>
                            <select class="form-control" id="crystal_report<?php echo $code;?>">
                                <option value="" selected disabled>Select Crystal Report</option>
                                <?php if(empty($crystal_report))
                                    {
                                        echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                    }
                                    foreach($crystal_report as $c){?>
                                        <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Company</label>
                            <select class="form-control" id="company<?php echo $code;?>" onchange="company_division('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Company</option>
                                <?php if(empty($companyList))
                                    {
                                        echo "<option value='' >No Company Found.</option>";
                                    }
                                    foreach($companyList as $comp){?>
                                        <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                         <div class="col-md-12">
                            <label>Division</label>
                            <select class="form-control" id="division<?php echo $code;?>" onchange="department('<?php echo $code;?>');">
                                <option value="" selected disabled>Select Division</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Department</label>
                            <select class="form-control" id="department<?php echo $code;?>" onchange="section('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Department</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Section</label>
                            <select class="form-control" id="section<?php echo $code;?>" onchange="subsection('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Section</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Subsection</label>
                            <select class="form-control" id="subsection<?php echo $code;?>" >
                                <option value="" selected disabled>Select Subsection</option>
                            </select>
                        </div>

                        
                        <div class="col-md-12">
                             <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="E5_result('<?php echo $code;?>');">FILTER</button>
                        </div>
                        
                </div>
                <div class="col-md-3"></div>

        <?php } else if($code=='E6'){?>

                   <div class="col-md-3"></div>
                <div class="col-md-6">
                        
                       
                         <div class="col-md-12">
                            <label>Crystal Report</label>
                            <select class="form-control" id="crystal_report<?php echo $code;?>">
                                <option value="" selected disabled>Select Crystal Report</option>
                                <?php if(empty($crystal_report))
                                    {
                                        echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                    }
                                    foreach($crystal_report as $c){?>
                                        <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Company</label>
                            <select class="form-control" id="company<?php echo $code;?>" onchange="company_division('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Company</option>
                                <?php if(empty($companyList))
                                    {
                                        echo "<option value='' >No Company Found.</option>";
                                    }
                                    foreach($companyList as $comp){?>
                                        <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                <?php } ?>
                            </select>
                        </div>

                         <div class="col-md-12">
                            <label>Division</label>
                            <select class="form-control" id="division<?php echo $code;?>" onchange="department('<?php echo $code;?>');">
                                <option value="" selected disabled>Select Division</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Department</label>
                            <select class="form-control" id="department<?php echo $code;?>" onchange="section('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Department</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Section</label>
                            <select class="form-control" id="section<?php echo $code;?>" onchange="subsection('<?php echo $code;?>',this.value);">
                                <option value="" selected disabled>Select Section</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Subsection</label>
                            <select class="form-control" id="subsection<?php echo $code;?>" >
                                <option value="" selected disabled>Select Subsection</option>
                            </select>
                        </div>

                        <div class="col-md-12">
                            <label>Location</label>
                            <select class="form-control" id="location<?php echo $code;?>" >
                                <option value="" selected disabled>Select Location</option>
                            </select>
                        </div>
                        
                        <div class="col-md-12">
                             <button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="E6_result('<?php echo $code;?>');">FILTER</button>
                        </div>
                        
                </div>
                <div class="col-md-3"></div>

        <?php } else if($code=='E7') {?>



                <div class="col-md-1"></div>
                 <div class="col-md-10">
                       
                        <div class="col-md-6">

                                   <div class="col-md-12">
                                        <label>Crystal Report</label>
                                        <select class="form-control" id="crystal_report<?php echo $code;?>">
                                            <option value="" selected disabled>Select Crystal Report</option>
                                            <?php if(empty($crystal_report))
                                                {
                                                    echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                                }
                                                foreach($crystal_report as $c){?>
                                                    <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Division</label>
                                        <select class="form-control" id="division<?php echo $code;?>" onchange="department('<?php echo $code;?>');">
                                            <option value="" selected disabled>Select Division</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Section</label>
                                        <select class="form-control" id="section<?php echo $code;?>" onchange="subsection('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Section</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Location</label>
                                        <select class="form-control" id="location<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Location</option>
                                        </select>
                                    </div>

                        </div>

                        <div class="col-md-6">

                                    <div class="col-md-12">
                                        <label>Company</label>
                                        <select class="form-control" id="company<?php echo $code;?>" onchange="company_division('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Company</option>
                                            <?php if(empty($companyList))
                                                {
                                                    echo "<option value='' >No Company Found.</option>";
                                                }
                                                foreach($companyList as $comp){?>
                                                    <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Department</label>
                                        <select class="form-control" id="department<?php echo $code;?>" onchange="section('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Department</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Subsection</label>
                                        <select class="form-control" id="subsection<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Subsection</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Classification</label>
                                        <select class="form-control" id="classification<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Classification</option>
                                        </select>
                                    </div>
 
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12"><button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="E7_result('<?php echo $code;?>');">FILTER</button></div>
                        </div>

                 </div>
                <div class="col-md-1"></div>
                



        <?php } else if($code=='E8'){?>


                 <div class="col-md-1"></div>
                 <div class="col-md-10">
                       
                        <div class="col-md-6">

                                   <div class="col-md-12">
                                        <label>Crystal Report</label>
                                        <select class="form-control" id="crystal_report<?php echo $code;?>">
                                            <option value="" selected disabled>Select Crystal Report</option>
                                            <?php if(empty($crystal_report))
                                                {
                                                    echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                                }
                                                foreach($crystal_report as $c){?>
                                                    <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Division</label>
                                        <select class="form-control" id="division<?php echo $code;?>" onchange="department('<?php echo $code;?>');">
                                            <option value="" selected disabled>Select Division</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Section</label>
                                        <select class="form-control" id="section<?php echo $code;?>" onchange="subsection('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Section</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Location</label>
                                        <select class="form-control" id="location<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Location</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Employment</label>
                                        <select class="form-control" id="employment<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Employment</option>
                                            <option value="All" >All</option>
                                            <?php foreach($employmentList as $p){?>
                                                <option value="<?php echo $p->employment_id;?>"><?php echo $p->employment_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                        </div>

                        <div class="col-md-6">

                                    <div class="col-md-12">
                                        <label>Company</label>
                                        <select class="form-control" id="company<?php echo $code;?>" onchange="company_division('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Company</option>
                                            <?php if(empty($companyList))
                                                {
                                                    echo "<option value='' >No Company Found.</option>";
                                                }
                                                foreach($companyList as $comp){?>
                                                    <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Department</label>
                                        <select class="form-control" id="department<?php echo $code;?>" onchange="section('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Department</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Subsection</label>
                                        <select class="form-control" id="subsection<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Subsection</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Classification</label>
                                        <select class="form-control" id="classification<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Classification</option>
                                        </select>
                                    </div>
 
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12"><button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="E8_result('<?php echo $code;?>');">FILTER</button></div>
                        </div>

                 </div>
                <div class="col-md-1"></div>


        <?php } else if($code=='E19'){?>



                 <div class="col-md-1"></div>
                 <div class="col-md-10">
                       
                        <div class="col-md-6">

                                   <div class="col-md-12">
                                        <label>Crystal Report</label>
                                        <select class="form-control" id="crystal_report<?php echo $code;?>">
                                            <option value="" selected disabled>Select Crystal Report</option>
                                            <?php if(empty($crystal_report))
                                                {
                                                    echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                                }
                                                foreach($crystal_report as $c){?>
                                                    <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Division</label>
                                        <select class="form-control" id="division<?php echo $code;?>" onchange="department('<?php echo $code;?>');">
                                            <option value="" selected disabled>Select Division</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Section</label>
                                        <select class="form-control" id="section<?php echo $code;?>" onchange="subsection('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Section</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Location</label>
                                        <select class="form-control" id="location<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Location</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Employment</label>
                                        <select class="form-control" id="employment<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Employment</option>
                                            <option value="All" >All</option>
                                            <?php foreach($employmentList as $p){?>
                                                <option value="<?php echo $p->employment_id;?>"><?php echo $p->employment_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Employee Status</label>
                                        <select class="form-control" id="status<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Status</option>
                                            <option>All</option>
                                            <option value="0">Active</option>
                                            <option value="1">InActive</option>
                                        </select>
                                    </div>


                                    <div class="col-md-12">
                                        <label>Date of Employment (date range)</label>
                                    </div>
                                    <div class="col-md-1"><input type="checkbox" id="e12ra" onclick="date_checker_all('e12');"></div>
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" id="e12f">
                                    </div>
                                    <div class="col-md-1"><b>to</b></div>
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" id="e12t"> 
                                    </div>

                                  

                                    <div class="col-md-12">
                                        <label>Years of Employment</label>
                                    </div>
                                    <div class="col-md-1"><input type="checkbox"  id="e11ra" onclick="date_checker_all('e11');"></div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="e11f">
                                    </div>
                                    <div class="col-md-1"><b>to</b></div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="e11t"> 
                                    </div>


                                    <div class="col-md-12">
                                        <label>Age</label>
                                    </div>
                                    <div class="col-md-1"><input type="checkbox" id="e16ra" onclick="date_checker_all('e16');"></div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="e16f">
                                    </div>
                                    <div class="col-md-1"><b>to</b></div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="e16t"> 
                                    </div>


                                    <div class="col-md-12">
                                        <label>Religion</label>
                                        <select class="form-control" id="religion<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Religion</option>
                                            <option value="All">All</option>
                                            <?php foreach($religionList as $r)
                                                 {
                                                        echo "<option value='".$r->param_id."'>".$r->cValue."</option>";
                                                 }
                                             ?>
                                        </select>
                                    </div>

                        </div>

                        <div class="col-md-6">

                                    <div class="col-md-12">
                                        <label>Company</label>
                                        <select class="form-control" id="company<?php echo $code;?>" onchange="company_division_other('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Company</option>
                                            <?php if(empty($companyList))
                                                {
                                                    echo "<option value='' >No Company Found.</option>";
                                                }
                                                foreach($companyList as $comp){?>
                                                    <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Department</label>
                                        <select class="form-control" id="department<?php echo $code;?>" onchange="section('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Department</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Subsection</label>
                                        <select class="form-control" id="subsection<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Subsection</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Classification</label>
                                        <select class="form-control" id="classification<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Classification</option>
                                        </select>
                                    </div>

                                     <div class="col-md-12">
                                        <label>Taxcode</label>
                                        <select class="form-control" id="taxcode<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Taxcode</option>
                                            <option value="All">All</option>
                                            <?php foreach($taxcodeList as $r)
                                                    {
                                                        echo "<option value='".$r->taxcode_id."'>".$r->taxcode."</option>";
                                                    } 
                                            ?>
                                        </select>
                                    </div>


                                    <div class="col-md-12">
                                        <label>Gender</label>
                                        <select class="form-control" id="gender<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Gender</option>
                                            <option value="All">All</option>
                                            <?php foreach($genderList as $r)
                                                    {
                                                        echo "<option value='".$r->gender_id."'>".$r->gender_name."</option>";
                                                    }
                                            ?>
                                        </select>
                                    </div>

                                     <div class="col-md-12">
                                        <label>Civil Status</label>
                                        <select class="form-control" id="civilstatus<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Civil Status</option>
                                            <option value="All">All</option>
                                            <?php foreach($civilStatusList as $r)
                                                    {
                                                        echo "<option value='".$r->civil_status_id."'>".$r->civil_status."</option>";
                                                    } 
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Position</label>
                                        <select class="form-control" id="position<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Position</option>
                                            <option>All</option>
                                            <?php foreach($positionList as $r)
                                                {
                                                    echo "<option value='".$r->position_id."'>".$r->position_name."</option>";
                                                 }
                                            ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Paytype</label>
                                        <select class="form-control" id="paytype<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Paytype</option>
                                            <option value="All">All</option>
                                            <?php foreach($paytypeList as $r)
                                                    {
                                                        echo "<option value='".$r->pay_type_id."'>".$r->pay_type_name."</option>";
                                                    }
                                            ?>
                                        </select>
                                    </div>

                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12"><button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="all_result('<?php echo $code;?>');">FILTER</button></div>
                        </div>

                 </div>
                <div class="col-md-1"></div>




        <?php } else { ?>


                 <div class="col-md-1"></div>
                 <div class="col-md-10">
                       
                        <div class="col-md-6">

                                   <div class="col-md-12">
                                        <label>Crystal Report</label>
                                        <select class="form-control" id="crystal_report<?php echo $code;?>">
                                            <option value="" selected disabled>Select Crystal Report</option>
                                            <?php if(empty($crystal_report))
                                                {
                                                    echo "<option value=''>No Crystal Report found. Please add to continue.</option>";
                                                }
                                                foreach($crystal_report as $c){?>
                                                    <option value="<?php echo $c->id;?>"><?php echo $c->report_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Division</label>
                                        <select class="form-control" id="division<?php echo $code;?>" onchange="department('<?php echo $code;?>');">
                                            <option value="" selected disabled>Select Division</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Section</label>
                                        <select class="form-control" id="section<?php echo $code;?>" onchange="subsection('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Section</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Location</label>
                                        <select class="form-control" id="location<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Location</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Employment</label>
                                        <select class="form-control" id="employment<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Employment</option>
                                            <option value="All" >All</option>
                                            <?php foreach($employmentList as $p){?>
                                                <option value="<?php echo $p->employment_id;?>"><?php echo $p->employment_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                        </div>

                        <div class="col-md-6">

                                    <div class="col-md-12">
                                        <label>Company</label>
                                        <select class="form-control" id="company<?php echo $code;?>" onchange="company_division_other('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Company</option>
                                            <?php if(empty($companyList))
                                                {
                                                    echo "<option value='' >No Company Found.</option>";
                                                }
                                                foreach($companyList as $comp){?>
                                                    <option value="<?php echo $comp->company_id;?>"><?php echo $comp->company_name;?></option>
                                            <?php } ?>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Department</label>
                                        <select class="form-control" id="department<?php echo $code;?>" onchange="section('<?php echo $code;?>',this.value);">
                                            <option value="" selected disabled>Select Department</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Subsection</label>
                                        <select class="form-control" id="subsection<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Subsection</option>
                                        </select>
                                    </div>

                                    <div class="col-md-12">
                                        <label>Classification</label>
                                        <select class="form-control" id="classification<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Classification</option>
                                        </select>
                                    </div>

                            <?php if($code=='E9'){?>

                                    <div class="col-md-12">
                                        <label>Taxcode</label>
                                        <select class="form-control" id="other<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Taxcode</option>
                                            <option value="All">All</option>
                                            <?php foreach($taxcodeList as $r)
                                                    {
                                                        echo "<option value='".$r->taxcode_id."'>".$r->taxcode."</option>";
                                                    } 
                                            ?>
                                        </select>
                                    </div>


                            <?php } else if($code=='E10'){?>

                                    <div class="col-md-12">
                                        <label>Employee Status</label>
                                        <select class="form-control" id="other<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Status</option>
                                            <option>All</option>
                                            <option value="0">Active</option>
                                            <option value="1">InActive</option>
                                        </select>
                                    </div>

                            <?php } else if($code=='E11'){?>

                                    <div class="col-md-12">
                                        <label>Years of Employment</label>
                                    </div>
                                    <div class="col-md-1"><input type="checkbox"  id="other<?php echo $code;?>" onclick="date_checker('<?php echo $code;?>');"></div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="f<?php echo $code;?>">
                                    </div>
                                    <div class="col-md-1"><b>to</b></div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="t<?php echo $code;?>"> 
                                    </div>

                            <?php } else if($code=='E12'){?>

                                     <div class="col-md-12">
                                        <label>Years of Employment</label>
                                    </div>
                                    <div class="col-md-1"><input type="checkbox" id="other<?php echo $code;?>" onclick="date_checker('<?php echo $code;?>');"></div>
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" id="f<?php echo $code;?>">
                                    </div>
                                    <div class="col-md-1"><b>to</b></div>
                                    <div class="col-md-5">
                                        <input type="date" class="form-control" id="t<?php echo $code;?>"> 
                                    </div>

                            <?php } else if($code=='E13'){?>

                                    <div class="col-md-12">
                                        <label>Civil Status</label>
                                        <select class="form-control" id="other<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Civil Status</option>
                                            <option value="All">All</option>
                                            <?php foreach($civilStatusList as $r)
                                                    {
                                                        echo "<option value='".$r->civil_status_id."'>".$r->civil_status."</option>";
                                                    } 
                                            ?>
                                        </select>
                                    </div>

                            <?php } else if($code=='E14'){?>

                                    <div class="col-md-12">
                                        <label>Gender</label>
                                        <select class="form-control" id="other<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Gender</option>
                                            <option value="All">All</option>
                                            <?php foreach($genderList as $r)
                                                    {
                                                        echo "<option value='".$r->gender_id."'>".$r->gender_name."</option>";
                                                    }
                                            ?>
                                        </select>
                                    </div>

                            <?php } else if($code=='E15'){?>

                                    <div class="col-md-12">
                                        <label>POsition</label>
                                        <select class="form-control" id="other<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Position</option>
                                            <option>All</option>
                                            <?php foreach($positionList as $r)
                                                {
                                                    echo "<option value='".$r->position_id."'>".$r->position_name."</option>";
                                                 }
                                            ?>
                                        </select>
                                    </div>

                            <?php } else if($code=='E16'){?>

                                    <div class="col-md-12">
                                        <label>Age</label>
                                    </div>
                                    <div class="col-md-1"><input type="checkbox" id="other<?php echo $code;?>" onclick="date_checker('<?php echo $code;?>');"></div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="f<?php echo $code;?>">
                                    </div>
                                    <div class="col-md-1"><b>to</b></div>
                                    <div class="col-md-5">
                                        <input type="text" class="form-control" id="t<?php echo $code;?>"> 
                                    </div>

                            <?php } else if($code=='E17'){?>

                                    <div class="col-md-12">
                                        <label>Paytype</label>
                                        <select class="form-control" id="other<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Paytype</option>
                                            <option value="All">All</option>
                                            <?php foreach($paytypeList as $r)
                                                    {
                                                        echo "<option value='".$r->pay_type_id."'>".$r->pay_type_name."</option>";
                                                    }
                                            ?>
                                        </select>
                                    </div>

                            <?php } else if($code=='E18'){?>
                                     <div class="col-md-12">
                                        <label>Religion</label>
                                        <select class="form-control" id="other<?php echo $code;?>" >
                                            <option value="" selected disabled>Select Religion</option>
                                            <option value="All">All</option>
                                            <?php foreach($religionList as $r)
                                                 {
                                                        echo "<option value='".$r->param_id."'>".$r->cValue."</option>";
                                                 }
                                             ?>
                                        </select>
                                    </div>

                            <?php } ?>       
 
                        </div>

                        <div class="col-md-12">
                            <div class="col-md-12"><button class="col-md-12 btn btn-success btn-sm" style="margin-top: 10px;" onclick="Other_result('<?php echo $code;?>');">FILTER</button></div>
                        </div>

                 </div>
                <div class="col-md-1"></div>



        <?php } ?>


        </div>  

        <div class="col-md-12"  id="result<?php echo $code_details->code;?>">


        </div>

        <div class="panel panel-info">
        <div class="btn-group-vertical btn-block"> </div> 
      </div>             
</div> 