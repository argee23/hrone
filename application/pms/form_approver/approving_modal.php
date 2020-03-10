      <style type="text/css">

.dropdownqwe {
    background:#fff;

    border-radius:4px;
    width:100px;    
}

.dropdown-menu>li>a {
    color:#428bca;

}
.dropdownqwe ul.dropdown-menu {
    border-radius:4px;
    box-shadow:none;
    margin-top:100px;
    width:190px;


}
.dropdownqwe ul>li{
    border: 1px solid #34495e;
}
.dropdownqwe ul.dropdown-menu:before {
    content: "";
    border-top: 10px solid #34495e;
    border-right: 10px solid transparent;
    border-left: 10px solid transparent;
    position: absolute;
    bottom: -10px;
    left: 50%;
    margin-left: -10px;
    z-index: 10;
}

.dropdown-menu>li>a
{
    color:#f5f5f5;
    }
    .dropdown-menu{
            
            background:#34495e;
    }
#unggoy {
box-shadow: 5px 5px 20px;
}
    .tbody {

    background: #EEEEF0; 
}
.tbody td{
  border:4px solid #fff;
}
.table-striped > tbody > tr:nth-child(2n+1) > td, .table-striped > tbody > tr:nth-child(2n+1) > th {
   background-color:#EDF7F8;

}
  </style>
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Modal Header</h4>
        <hr class="prettyline">
      </div>
      <div class="modal-body">


         <div class="row">

  <div class="col-md-12 col-sm-12">
<!--   <div class="wrimagecard wrimagecard-topimage">
          <a href="#">
          
          <div class="wrimagecard-topimage_header" style="background-color:rgba(187, 120, 36, 0.1) ">
            <span><i class="fa fa-area-chart pull-left" style="color:#BB7824;" ></i><span>
            <div class="col-md-4">
            <span id="doc_no"></span>
            <span id="full"><?php echo $name; ?></span><br>
            <span id="classification"><?php echo $classification; ?></span><br>
             <span id="pos"><?php echo $position; ?></span><br>
             <span id="dept"></span><br>
             <span id="l"></span>
         
              <input type="hidden" id="appro_level" name="appro_level">


          </div>
            <div class="col-md-4">
           
        
             
          </div>
          </div>
    


        </a>
 

      </div> -->
               <div class="row">
                      <div class="panel panel-default">
                      <div class="panel-heading"></div>
                       <div class="panel-body">
                      <div class="col-md-4 col-xs-12 col-sm-6 col-lg-4">
                       <img alt="User Pic" src="https://x1.xingassets.com/assets/frontend_minified/img/users/nobody_m.original.jpg" id="profile-image1" class="img-circle img-responsive"> 
                     
                 
                      </div>
                      <div class="col-md-8 col-xs-12 col-sm-6 col-lg-8" >
                          <div class="container" >
                            <h2> <span id="full"><?php echo $name; ?></span></h2>
                          
                          
                           
                          </div>
                           <hr>
                          <ul class="container details" >
                            <li><p><span id="classification"><?php echo $classification; ?></span></p></li>
                            <li><p> <span id="pos"><?php echo $position; ?></span></p></li>
                            <li><p><span id="pos"><?php echo $department; ?></span></p></li>
                          </ul>
                          <hr>
                          <div class="col-sm-5 col-xs-6 tital " >Date Of Appraisal :  <?php $originalDate = $get_current_appraisal_schedule->appraisal_period_type_dates;
$newDate = date("M j, Y", strtotime($originalDate)); echo $newDate; ?></div>
                      </div>
                </div>
            </div>
            </div>
   
    <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

      <?php $form= array(); foreach($forms as $forms){ ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $forms->id; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                              <?php echo $forms->form_title; ?>
                    </a>
                </h4>
            </div>
            <div id="<?php echo $forms->id; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                  <div style="border:1px solid #317A81;">
                  <table class="table table-striped">
                    <thead style="background-color: #317A81; color: #BAE2E4">
                            <th>Area</th>
                             <th>Description <div class="pull-right"  ><span style="padding-right: 30px">Weight</span> <span style="padding-right: 40px;">Score</span> <span style="padding-right: 20px;">Rating</span></div></th>

                           </thead>
                     <?php $res1= $this->pms_model->get_criteria_admin_for_approver($forms->fid,$forms->doc_no); 
                     $sq  = '';
                        foreach($res1 as $res1){?>
                          <tr><td style="text-align: center; vertical-align: middle;">
                           <b><?php echo ucfirst($res1->area); ?></b>
</td> 


<td>
  <table class="table"><?php $q = $this->pms_model->get_weight_and_description_admin($res1->cid);

      foreach($q as $q){?>

        <tr>
             <td ><?php echo $q->description?></td><td width="60px"><?php echo $q->weight.'%' ?></td>
            <input type="hidden" class="c_cid" value="<?php echo $q->id ?>">
                       <input type="hidden" id="c_employee_id" value="<?php echo $employee_id?>">
           <td width="60px" class="c_score"><?php $w = $this->pms_model->get_score($forms->doc_no,$forms->fid,'admin', $q->id); echo round($w['result']->score/$w['rows']);  ?>  </td>
           <td class="rate" width="60px">

                 <?php $ws = $this->pms_model->get_score_rate($q->weight,$w['result']->score/$w['rows'],'admin'); echo $ws; ?></td></tr><?php 
               } ?></table></td>
        </tr>
                         <?php $sq += $ws; }  
                     ?>
     
  <tfoot><tr><td colspan="4" ><u>Totals and Rating for Part <?php echo $forms->form_part; ?>:<?php 
  $sw =  $this->pms_model->get_score_equival($sq); echo '<b>'.$sw->score;  echo '<i>('.$sw->score_equivalent.')</i></b>' ?></u></td></tr>
</tfoot>
                     </table>
                   </div>
                </div>
            </div>
        </div>
        <?php   
              $form[] = array("form_title"=>$forms->form_title,"weight"=>$forms->weight,"score"=>$sw->score,"score_total"=>$forms->weight/100*$sw->score,"form_part"=>$forms->form_part);
           }?>

          <!-- ------------- tryyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy -->
      <?php foreach($forms_creator as $forms_creator){ ?>
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#<?php echo $forms_creator->fid; ?>" aria-expanded="true" aria-controls="collapseOne">
                        <i class="more-less glyphicon glyphicon-plus"></i>
                              <?php echo $forms_creator->form_title; ?>
                    </a>
                </h4>
            </div>
            <div id="<?php echo $forms_creator->fid; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                  <table class="table">

                     <?php $qwe= $this->pms_model->get_criteria_admin_for_approver1($forms_creator->fid,$forms_creator->doc_no); 

                        foreach($qwe as $qwe){?>
                          <tr><td>
                          <?php echo $qwe->area; ?>
             
                        </td><td><table class="table">
                          <?php $q = $this->pms_model->get_weight_and_description_portal($qwe->criteria_id);
                           foreach($q as $q){?>
                          <tr>
                            <td>
                              <?php echo $q->description?></td><td width="50px"><?php echo $q->weight.'%' ?></td><?php $qw = $this->pms_model->get_score_creator($forms_creator->doc_no,$q->id,'creator'); ?><td><?php echo $qw->score; ?>
                            
                        </td><td><?php echo $qw->rate ?></td></tr><?php } ?></table></td></tr>

                         <?php }
                     ?>

  <tfoot><tr><td colspan="4" ><u>Totals and Rating for Part <?php echo $forms->form_part; ?>: <?php echo '<b>'.$wr->total.'</b>' ?></u></td></tr>
</tfoot>

                     </table>
                </div>
            </div>
            <hr>
           
        </div>
        <?php } ?>
      <br>
      <hr>

      <div id="unggoy">
     <table class="table table-bordered">

      <thead> <tr class='info'>
                               <th scope="col" colspan="4">Final Rating/Summary     </th>
                            </tr><th>form part</th><th>Form title</th><th>Weight </th><th>Part rating</th><th>Total Rating</th></thead><tbody class="tbody"></thead><?php $f = 0; $se= 0; foreach($form as $key=>$val){ ?>
      <tr>
      <td class="form_part"><?php echo $form[$key]['form_part'] ?></td>
      <td class="form_title"><?php echo $form[$key]['form_title'] ?></td><td class="weight"><?php echo $form[$key]['weight'] ?>%</td>
      <td class="score"><?php echo $form[$key]['score'] ?></td>
      <td class="total"><?php echo $form[$key]['score_total'] ?></td>
    </tr>
    <?php } ?>
   </tbody><tfoot>

      <td><u><b>Final rating table : </b> 
        <?php $sw =  $this->pms_model->get_score_equival($f); echo $sw->score;  echo '<i>('.$sw->score_equivalent.')</i>' ?></u></td>
    </tfoot></table>
    </div>

    </div><!-- panel-group -->

      </div>
    </div>

      </div>
      <div class="modal-footer">
   
      <ul class="nav navbar-nav">
        <div class="btn-group dropup">
        <li class="dropdownqwe " >
          <a href="#" class="dropdown-toggle btn btn-danger "  data-toggle="dropdown">Reject  &nbsp;<span class="glyphicon glyphicon-chevron-up pull-right"></span></a>

          <ul class="dropdown-menu dropup" >
            <li><a href="#">Account Settings<input type="checkbox" name="check1" class="pull-right"></span></a><input type="text" name="" id="check1" class="form-control" style="display:none;"></li>
            <li class="divider"></li>
            <li><a href="#">User stats <input type="checkbox" name="check2" class="pull-right"></a><input type="text" name="" id="check2" class="form-control" style="display:none;"></li>
            <li class="divider"></li>
        
            <li><a href="#">Sign Out <input type="checkbox" name="check3" class="pull-right"></a><input type="text" name="" id="check3" class="form-control" style="display:none;"></li>
          </ul>
        </li> 
      </div>
      </ul>
         <button onclick="next_appro()"  class="btn btn-success pull-right">Approve</button>
      </div>
    </div>
<script type="text/javascript">
  $('input[name ="check1"]').click(function(){
        $('#check1').toggle('slow');
});
    $('input[name ="check2"]').click(function(){
        $('#check2').toggle('slow');
});
      $('input[name ="check3"]').click(function(){
        $('#check3').toggle('slow');
});
function toggleIcon(e) {
    $(e.target)
        .prev('.panel-heading')
        .find(".more-less")
        .toggleClass('glyphicon-plus glyphicon-minus');
}
$('.panel-group').on('hidden.bs.collapse', toggleIcon);
$('.panel-group').on('shown.bs.collapse', toggleIcon);

      
</script>