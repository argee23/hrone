<br><br>
<div class="col-md-12">
    <?php echo $message;?>
</div>
<div class="content-body" style="background-color: #D7EFF7;">
<div class="col-lg-12" style="padding-top: 20px;">

<div class="box box-solid" >
           
            <!-- /.box-header -->
            <div class="box-body">
             <ol class="breadcrumb">
              <h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i><b><n id="title">
                    <label id="code">COMPANY CODE OF DISCIPLINE</label><label id="pol" style="display: none;">DOWNLOADABLE COMPANY POLICY</label></n></b>
                  <a class="btn btn-success pull-right btn-xs" style="cursor: pointer;" onclick="view_downloadable('<?php echo $this->session->userdata('company_id');?>')" >Downloadable Policies</a>
                  <a class="btn btn-danger pull-right btn-xs" onclick="location.reload();" style="margin-right:10px;"  >View Company Policy</a>

                          <?php  
                              if($checker_company_policy=='true' || $checker_company_policy=='true_updated'){ ?>
                              <ol class="breadcrumb">
                                <center>
                                  <button class="btn btn-default" onclick="acknowledge();">
                                      <span class="blink">
                                          <b>Click to Acknowledge that you fully read the <?php if($checker_company_policy=='true_updated'){ echo "updated "; }?>company policy</b>
                                      </span>
                                  </button> 
                               </center>
                              </ol>
                          <?php } else{}?>
                     
              </h4>
             </ol> 
            <div class="col-md-12" style="margin-top: 10px;" id="main_action">
             

              <div class="col-md-12">
                

              <?php if(!empty($policy)){ foreach($policy as $p)
                {
                   $disobedience = $this->company_policy_model->get_disobedience_details($p->cod_id);

                   $n = intval($p->numbering);
                   $res = '';
                   $roman_numerals = array(
                    'M'  => 1000,
                    'CM' => 900,
                    'D'  => 500,
                    'CD' => 400,
                    'C'  => 100,
                    'XC' => 90,
                    'L'  => 50,
                    'XL' => 40,
                    'X'  => 10,
                    'IX' => 9,
                    'V'  => 5,
                    'IV' => 4,
                    'I'  => 1);
                  foreach ($roman_numerals as $roman => $number) 
                  {
                      /*** divide to get  matches ***/
                      $matches = intval($n / $number);
                      /*** assign the roman char * $matches ***/
                      $res .= str_repeat($roman, $matches);
               
                      /*** substract from the number ***/
                      $n = $n % $number;
                  }?>
                 
                     <div class="box box-solid" >
                      <div class="box-header with-border bg-lighten-4"><center><h3 class="box-title"><b><?php echo $res."</br></br> </b>".$p->title;?></h3></center></div>
                        <div class="box-body">
                          <di class="col-md-12">

                            <div class="col-md-1"></div>
                            <div class="col-md-10"> <h5><?php echo $p->description;?></h5></div>
                            <div class="col-md-1"></div>
                          </di>
                          <div class="col-md-12">
                            <div class="col-md-1"></div>
                              <div class="col-md-10">
                               <?php 
                                 $i=1; foreach($disobedience as $dd)
                                  {
                                   $details = $this->company_policy_model->get_punishments($dd->cod_disob_id,$p->cod_id);?>

                                  <script type="text/javascript">
                                    $(function () {
                                    $('#disobedience'+<?php echo $dd->cod_disob_id;?>).DataTable({
                                      "pageLength": -1,
                                      "pagingType" : "simple",
                                      "paging": false,
                                      "lengthChange": true,
                                      "searching": false,
                                      "ordering": false,
                                      "info": true,
                                      "autoWidth": true
                                    });
                                  });
                                  </script>
                                     <table class="table table-hover" id="disobedience<?php echo $dd->cod_disob_id;?>">
                                        <thead>
                                           <tr class="success">
                                            <th colspan="4"><center><?php echo $dd->disob_title;?></center></th>
                                         </tr>
                                          <tr>
                                            <th><center>ID</center></th>
                                            <th><center>Disobedience</center></th>
                                            <th><center>No of days</center></th>
                                            <th><center>NO. OF DISOBEDIENCE SUSPENSION/PUNISHMENT</center></th>
                                         </tr>
                                        </thead>
                                        <tbody>   
                                        <?php foreach($details as $d){?>
                                          <tr>
                                            <td><center><?php echo $d->pun_id;?></center></td>
                                            <td><center><?php echo $d->disob;?></center></td>
                                            <td><center><?php echo $d->num_days;?></center></td>
                                            <td><center><?php echo $d->punish;?></center></td>
                                          </tr>   
                                        <?php } ?>
                                        </tbody>
                                     </table>
                                  <?php }
                               ?>
                              
                              </div>
                            <div class="col-md-1"></div>

                          </di>
                        </div>
                    </div>
                  <?php } } else{
                    $policy = $this->company_policy_model->get_downloadable($this->session->userdata('company_id'));
                  ?>


                    <table class="table table-hover" id="policy">
                      <thead>
                        <tr class="danger">
                            <th><center>ID</center></th>
                            <th><center>Numbering</center></th>
                            <th><center>Title</center></th>
                            <th><center>Description</center></th>
                            <th><center>Filename</center></th>
                            <th><center>Action</center></th>
                        </tr>
                      </thead>
                      <tbody>
                        <?php foreach($policy as $p){?>
                          <tr>
                              <td><center><?php echo $p->id;?></center></td>
                              <td><center><?php echo $p->numbering;?></center></td>
                              <td><center><?php echo $p->file_name;?></center></td>
                              <td><center><?php echo $p->file_description;?></center></td>
                              <td><center><?php echo $p->filename;?></center></td>
                              <td><center><a href="<?php echo base_url(); ?>app/downloadable_company_policy/download_forms/<?php echo $p->filename; ?>" title="Download File" ><i class="fa fa-download"></i> </a></center></td>
                          </tr> 
                        <?php } ?>                      
                      </tbody>
                  </table>


                  <?php } ?>
              </div>

            </div>
            </div>
            <!-- /.box-body -->
           
          </div>


</div>
</div>

     <div id="modal" class="modal fade" role="dialog">
       <div class="modal-dialog">
           <div class="modal-content modal-lg">
           </div>
        </div>
    </div>

<style type="text/css">
 .blink{
          
          font-family: cursive;
          animation: blink 2s linear infinite;
        }
   
              
        @keyframes blink{
        0%{opacity: 0;}
        50%{opacity: .5;}
        100%{opacity: 1;}
    }      
        

  #title
  {
     letter-spacing: 2px;
  }

  .modal {
  }
  .vertical-alignment-helper {
      display:table;
      height: 100%;
      width: 120%;

  }
  .vertical-align-center {
      /* To center vertically */
      display: table-cell;
      vertical-align: left;

  }
  .modal-content {
      /* Bootstrap sets the size of the modal in the modal-dialog class, we need to inherit it */
   /*   width:inherit;
      height:inherit;*/
      /* To center horizontally */
      margin: 0 auto;
      margin-left:-60px;
  }
</style>
<script type="text/javascript">
   $(function () {
        $('#policy').DataTable({
          "pageLength": 6,
          "pagingType" : "simple",
          "paging": true,
          "lengthChange": true,
          "searching": true,
          "ordering": true,
          "info": true,
          "autoWidth": true
        });
      });
    

   function view_downloadable(company)
   {

       if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
              document.getElementById("main_action").innerHTML=xmlhttp2.responseText;
               $("#downloadable").DataTable({
                        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]]             
                        });
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/company_policy/get_downloadable/"+company,false);
        xmlhttp2.send();
   }


   function acknowledge()
   {

    var result = confirm("Are you sure you already read the company policy?");
      if(result == true)
      {
    if (window.XMLHttpRequest)
          {
          xmlhttp2=new XMLHttpRequest();
          }
        else
          {// code for IE6, IE5
          xmlhttp2=new ActiveXObject("Microsoft.XMLHTTP");
          }
        xmlhttp2.onreadystatechange=function()
          {
          if (xmlhttp2.readyState==4 && xmlhttp2.status==200)
            {
             location.reload();
            }
          }
        xmlhttp2.open("GET","<?php echo base_url();?>employee_portal/company_policy/acknowledge_company_policy/",false);
        xmlhttp2.send();
      }
   }
</script>
 