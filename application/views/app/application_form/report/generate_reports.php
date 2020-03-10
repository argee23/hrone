
    <link href="<?php echo base_url()?>public/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="http://fonts.googleapis.com/css?family=Open+Sans:400italic,600italic,400,600" rel="stylesheet">
    <link href="<?php echo base_url()?>public/font-awesome/css/font-awesome.min.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/custom.css" rel="stylesheet">
    <link href="<?php echo base_url()?>public/AdminLTE.min.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/vex/css/vex-theme-os.css">
    <link rel="stylesheet" href="<?php echo base_url()?>public/bootstrap-select/css/bootstrap-select.min.css">
<br>
<title>Job Applications</title>
<?php require_once(APPPATH.'views/app/application_form/insert_datetime_picker.php');?>
<body>
<!-- STATUS FILTERS -->
  <div class="col-md-12">
  </div>   
   

   <div class="col-md-12" style="padding-bottom: 50px;padding-top: 20px;">
      <div class="box box-success">
        <div class="panel panel-info">
              <div class="col-md-12" id="fetch_all_result"><br>
              <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Generate Applicant Job Applications</h4></ol>
              
                <div class="col-md-12">

                    <div class="col-md-4">

                      <div>
                        <div class="col-md-12">
                          <div class="col-md-12">   
                            <label>Filter Option</label>
                            <select class="form-control" onchange="filtering(this.value);">
                                <option value="" disabled selected>Select Option</option>
                                <option value="job_applications">Job Applications </option>
                                <option value="interview_request">Interview Request</option>
                                <option value="applicant_referral">Applicant Referral</option>
                            </select>
                          </div>
                        </div>
                      </div>

                   <!--  start job applications -->
                      <div id="job_applications" style="display: none;">

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><label>Company</label>
                          <select class="form-control" name="ja_company" id="ja_company" onchange="get_job_applications_status(this.value,'ja_status');">
                                <option value="" disabled selected>Select Company</option>
                                <option value="All">All</option>
                                <?php foreach($company as $c){?>
                                    <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12">
                             <label>Date Applied (Date Range)</label><br>
                             <input type="checkbox" id="ja_daterange" onclick="get_daterange('ja_daterange','ja_datefrom','ja_dateto');">&nbsp;&nbsp;All<br>
                          </div>
                          <div class="col-md-6"><input type="date" class="form-control" id="ja_datefrom"></div>
                          <div class="col-md-6"><input type="date" class="form-control" id="ja_dateto"></div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><label>Job Application Status</label>
                          <select class="form-control" name="ja_status" id="ja_status" disabled>
                                <option value="" disabled selected>Select Status</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><label>Select Report Fields</label></div>
                            <?php $fields = $this->applicant_reports_model->get_applicant_fields('job_application'); 
                              $i=0; foreach($fields as $f){
                            ?>
                              <div class="col-md-6">
                                  <div class="col-md-12"><input type="checkbox" checked class="fields_option" value="<?php echo $f->id;?>">&nbsp;<?php echo $f->label;?></div>
                              </div>

                            <?php $i++; }  echo "<input type='hidden' id='crystal_fields' value='".$i."'>"; ?>
                         
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><button class="col-md-12 btn btn-success btn-sm" onclick="job_application_filter();">FILTER</button></div>
                        </div>

                      </div>
                   <!--  end job applications -->   
                   

                   <!--  start interview request -->  
                      <div id="interview_request" style="display: none;">

                          <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><label>Company</label>
                          <select class="form-control" id="ir_company" onchange="get_interview_request_status(this.value,'ir_process');">
                                <option value="" disabled selected>Select Company</option>
                                <option value="All">All</option>
                                <?php foreach($company as $c){?>
                                    <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12">
                             <label>Interview Date (Date Range)</label><br>
                             <input type="checkbox" id="ir_daterange" onclick="get_daterange('ir_daterange','ir_datefrom','ir_dateto');">&nbsp;&nbsp;All<br>
                          </div>
                          <div class="col-md-6"><input type="date" class="form-control" id="ir_datefrom"></div>
                          <div class="col-md-6"><input type="date" class="form-control" id='ir_dateto'></div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><label>Interview Process</label>
                          <select class="form-control" id="ir_process" disabled>
                                <option value="" disabled selected>Select Status</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><label>Interview Result</label>
                          <select class="form-control" id="ir_results" disabled>
                                <option value="" disabled selected>Select Status</option>
                                <option value="all">All</option>
                                <option value="passed">Passed</option>
                                <option value="failed">Failed</option>
                                <option value="not_attended">x</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><label>Select Report Fields</label></div>
                            <?php $fields = $this->applicant_reports_model->get_applicant_fields('interview_request'); 
                              $i=0; foreach($fields as $f){
                            ?>
                              <div class="col-md-6">
                                  <div class="col-md-12"><input type="checkbox" checked class="fields_optionn" value="<?php echo $f->id;?>">&nbsp;<?php echo $f->label;?></div>
                              </div>

                            <?php $i++; }  echo "<input type='hidden' id='crystal_fieldss' value='".$i."'>"; ?>
                         
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><button class="col-md-12 btn btn-success btn-sm" onclick="interview_request_filter();">FILTER</button></div>
                        </div>

                      </div>
                 
                 <!--  end interview request --> 

                 <!--  start applicant referral --> 

                      <div id="applicant_referral" style="display: none;">

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><label>Company</label>
                          <select class="form-control" id="ar_company" onchange="get_applicant_referral_status(this.value,'ar_job');">
                                <option value="" disabled selected>Select Company</option>
                                <?php foreach($company as $c){?>
                                    <option value="<?php echo $c->company_id;?>"><?php echo $c->company_name;?></option>
                                <?php } ?>
                            </select>
                          </div>
                        </div>
                        
                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><label>Job Applications</label>
                          <select class="form-control" id="ar_job" disabled>
                                <option value="" disabled selected>Select Status</option>
                            </select>
                          </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px;">
                          <div class="col-md-12"><button class="col-md-12 btn btn-success btn-sm" onclick="applicant_referral_filter();">FILTER</button></div>
                        </div>

                      </div>

                    </div>
                   
                    <div class="col-md-8" id="generate_results" style="overflow: scroll;">
                      <table class="table table-hover" id="resultss">
                          <thead>
                              <tr class="danger">
                                <th>Id</th>
                                <th>Position</th>
                                <th>Date Applied</th>
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                <td></td>
                                <td></td>
                                <td></td>
                              </tr>
                          </tbody>
                      </table>
                    </div>

                </div>

                <!--  end applicant referral --> 


              </div>
              <div class="btn-group-vertical btn-block"> </div>   
        </div>             
      </div> 
    </div> 
  
   

    <script src="<?php echo base_url()?>public/bootstrap-select/js/bootstrap-select.min.js"></script>
    <script src="<?php echo base_url()?>public/vex/js/vex.combined.min.js"></script>
    <script>vex.defaultOptions.className = 'vex-theme-os'</script>
    <script src="<?php echo base_url()?>public/jquery-1.12.3.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo base_url()?>public/datatables/dataTables.bootstrap.min.js"></script>
    <link rel="stylesheet" href="<?php echo base_url()?>public/datatables/dataTables.bootstrap.css">

    <link rel="stylesheet" href="<?php echo base_url()?>public/plugins/select2/select2.min.css">
    <script src="<?php echo base_url()?>public/plugins/select2/select2.full.min.js"></script>
    
    <script type="text/javascript">
         
        $(function () {
          $('#resultss').DataTable({
            "pageLength":-1,
            "pagingType" : "simple",
            "paging": true,
           lengthMenu: [[-1,1,5, 10, 15, 20, 25, 30, 35, 40], ["All",1,5, 10, 15, 20, 25, 30, 35, 40]],
            "searching": false,
            "ordering": false,
            "info": true,
            "autoWidth": false
          });
        });


        function filtering(val)
        {
        
          if(val=='job_applications')
          {
              $('#job_applications').show();
              $('#interview_request').hide();
              $('#applicant_referral').hide();
          }
          else if(val=='interview_request')
          {
              $('#interview_request').show();
              $('#applicant_referral').hide();
              $('#job_applications').hide();
          }
          else
          {
              $('#applicant_referral').show();
              $('#interview_request').hide();
              $('#job_applications').hide();
          }
        }

        function get_daterange(a,from,to)
        {
            if(document.getElementById(a).checked==true)
            {
              document.getElementById(from).disabled=true;
              document.getElementById(to).disabled=true;
            }
            else
            {
              document.getElementById(from).disabled=false;
              document.getElementById(to).disabled=false;
            }
        }

        function get_job_applications_status(val,idd)
        {
          
          if(val=='All')
          {
            document.getElementById(idd).disabled=true;
          }
          else
          {
            document.getElementById(idd).disabled=false;
             if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById(idd).innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/applicant_reports/get_job_applications_status/"+val,true);
            xmlhttp.send();

          }
            
        }

        function job_application_filter()
        {
            if(document.getElementById('ja_daterange').checked==true)
            {
              var from = 'All';
              var to = 'All';
            }
            else
            {
              var from = document.getElementById('ja_datefrom').value;
              var to = document.getElementById('ja_dateto').value;
            }

            var company = document.getElementById('ja_company').value;

            if(company=='All')
            {
               var status = 'All';
            }
            else
            {
              var status = document.getElementById('ja_status').value;
            }

            var count= document.getElementById("crystal_fields").value;
            var checks = document.getElementsByClassName("fields_option");
            var data ='';

            for (i=0;i < count; i++)
              {
                if (checks[i].checked === true)
                  {
                    data +=checks[i].value + "-";
                          
                   }
              }

            if(status=='' || company=='' || from=='' || to=='')
            {
              alert('Fill up all fields to continue');
            }
            else if(data=='')
            {
              alert('Select atleast one field to continue');
            }
            else
            {
                if (window.XMLHttpRequest)
                  {
                  xmlhttp=new XMLHttpRequest();
                  }
                else
                  {// code for IE6, IE5
                  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                  }
                xmlhttp.onreadystatechange=function()
                  {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                    document.getElementById('generate_results').innerHTML=xmlhttp.responseText;
                     $("#resultss").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/applicant_reports/job_application_results/"+status+"/"+company+"/"+from+"/"+to+"/"+data,true);
                xmlhttp.send();
            }
            
        }

        function get_interview_request_status(val,idd)
        {
          if(val=='All')
          {
            document.getElementById(idd).disabled=true;
            document.getElementById('ir_results').disabled=true;
          }
          else
          {
             document.getElementById(idd).disabled=false;
              document.getElementById('ir_results').disabled=false;
              
             if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById(idd).innerHTML=xmlhttp.responseText;
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/applicant_reports/get_interview_request_status/"+val,true);
            xmlhttp.send();

          }
        }

        function interview_request_filter()
        {
             if(document.getElementById('ir_daterange').checked==true)
            {
              var from = 'All';
              var to = 'All';
            }
            else
            {
              var from = document.getElementById('ir_datefrom').value;
              var to = document.getElementById('ir_dateto').value;
            }

            var company = document.getElementById('ir_company').value;

            if(company=='All')
            {
               var status = 'All';
               var result = 'All';
            }
            else
            {
              var status = document.getElementById('ir_process').value;
              var result = document.getElementById('ir_results').value;
            }

            var count= document.getElementById("crystal_fieldss").value;
            var checks = document.getElementsByClassName("fields_optionn");
            var data ='';

            for (i=0;i < count; i++)
              {
                if (checks[i].checked === true)
                  {
                    data +=checks[i].value + "-";
                          
                   }
              }

            if(status=='' || company=='' || from=='' || to=='' || result=='')
            {
              alert('Fill up all fields to continue');
            }
            else if(data=='')
            {
              alert('Select atleast one field to continue');
            }
            else
            {
                if (window.XMLHttpRequest)
                  {
                  xmlhttp=new XMLHttpRequest();
                  }
                else
                  {// code for IE6, IE5
                  xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
                  }
                xmlhttp.onreadystatechange=function()
                  {
                  if (xmlhttp.readyState==4 && xmlhttp.status==200)
                    { 
                    document.getElementById('generate_results').innerHTML=xmlhttp.responseText;
                     $("#resultss").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                    }
                  }
                xmlhttp.open("GET","<?php echo base_url();?>app/applicant_reports/interview_request_filter/"+status+"/"+company+"/"+from+"/"+to+"/"+data+"/"+result,true);
                xmlhttp.send();
            }
        }

        function get_applicant_referral_status(val,idd)
        {
          if(val=='All')
          {
            document.getElementById(idd).disabled=true;
          }
          else
          {
            document.getElementById(idd).disabled=false;
             if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                document.getElementById(idd).innerHTML=xmlhttp.responseText;
                
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/applicant_reports/get_applicant_referral_status/"+val,true);
            xmlhttp.send();
          }
        }

        function applicant_referral_filter()
        {
          var company = document.getElementById('ar_company').value;
          if(company=='All')
          {
            var jobs = 'All';
          }
          else
          {
            var jobs = document.getElementById('ar_job').value;
          }

         if(company=='' || jobs=='')
         {
          alert('Fill up all fields to continue');
         }
         else
         {

           if (window.XMLHttpRequest)
              {
              xmlhttp=new XMLHttpRequest();
              }
            else
              {// code for IE6, IE5
              xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
              }
            xmlhttp.onreadystatechange=function()
              {
              if (xmlhttp.readyState==4 && xmlhttp.status==200)
                { 
                  document.getElementById('generate_results').innerHTML=xmlhttp.responseText;
                     $("#resultss").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
                }
              }
            xmlhttp.open("GET","<?php echo base_url();?>app/applicant_reports/applicant_referral_filter/"+company+"/"+jobs,true);
            xmlhttp.send();
         }
        }
    </script>