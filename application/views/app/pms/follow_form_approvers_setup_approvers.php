  <style type="text/css">
        .menu .accordion-heading {  position: relative; }
.menu .accordion-heading .edit {
    position: absolute;
    top: 8px;
    right: 30px; 
}
.menu .area { border-left: 4px solid #f38787; }
.menu .equipamento { border-left: 4px solid #65c465; }
.menu .ponto { border-left: 4px solid #98b3fa; }
.menu .collapse.in { overflow: visible; }


.accordion{margin-bottom:20px;}
.accordion-group{margin-bottom:2px;border:1px solid #e5e5e5;-webkit-border-radius:4px;-moz-border-radius:4px;border-radius:4px;}
.accordion-heading{border-bottom:0;}
.accordion-heading .accordion-toggle{display:block;padding:8px 15px;}
.accordion-toggle{cursor:pointer;}
.accordion-inner{padding:9px 15px;border-top:1px solid #e5e5e5;}
      </style>
<div class="container">
  <div class="row">
    <div class="col-md-10">
          <div class="menu">
              <?php  foreach($get_department as $get_department){  ?>
                <div class="accordion">
                    <!-- Áreas -->
                    <div class="accordion-group">
                        <!-- Área -->
                        <div class="accordion-heading area">
                            <a class="accordion-toggle" data-toggle="collapse" href="#<?php echo $get_department->department_id ?>"><?php echo $get_department->department_id; ?></a>
                        </div><!-- /Área -->
            
                        <div class="accordion-body collapse" id="<?php echo $get_department->department_id; ?>">
                            <div class="accordion-inner">
                                <div class="accordion" id="equipamento1">
                                    <!-- Equipamentos -->
                   <?php $load_section=  $this->pms_model->load_section($get_department->department_id); foreach($load_section as $load_section){ ?> 
                                    <div class="accordion-group">
                                        <div class="accordion-heading equipamento">
                                          
                                            <a class="accordion-toggle" data-parent="#equipamento1-1" data-toggle="collapse" href="#s<?php echo $load_section->section_id ?>"><?php  echo $load_section->section_id; ?></a>
                                          <?php $a =  $this->pms_model->load_approver($get_department->department_id,$load_section->section_id,$company);  ?>
                                        </div><!-- Pontos -->
            
                                        <div class="accordion-body collapse" id="s<?php echo $load_section->section_id; ?>">
                                            <div class="accordion-inner">
                                                  
                                                     <table class="table">
                                                                      <tbody> 
                                                                        <thead>
                                                                            <th>Name</th>
                                                                            <th>Classification</th>
                                                                            <th>Location</th>
                                                                            <th>Section</th>
                                                                            <th>Level</th>
  

                                                                        </thead>
                                                              
                                                                  <?php $qw = array(); foreach($a as $a){

                                                                        if(!in_array($a->approver,$qw)){

                                                                        
                                                                    ?>
                                                               
                                                                      <tr>
                                                                    <td style="font-size: 12px;"><i class="icon-chevron-right"></i><?php echo $a->fullname?></td><td><?php echo $a->classification ?></td>
                                                                    <td><?php echo $a->location_name; ?></td><td><?php echo $a->section_name ?></td>
                                                                    <td><?php if($a->approval_level == 1){
                                                                             $c = 'st';
                                                                      }elseif($a->approval_level == 2){
                                                                      $c = 'nd';
                                                                    }elseif($a->approval_level == 3){
                                                                      $c == 'rd';
                                                                    }else{
                                                                      $c = 'th';} 

                                                                      echo $a->approval_level.$c;?></td>
                                                                    
                                                                    </tr>
                                                               
                                                                  <?php } array_push($qw,$a->approver); } ?>
                                                                     </tbody>
                                                                    </table>
            
                                                              
                                                
                                            </div>
                                        </div><!-- /Pontos -->
                                    </div><!-- /Equipamentos -->
                                  <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div><!-- /accordion -->
                <?php } ?>
                
               
    
            </div> 
    </div>
  </div>
</div>


