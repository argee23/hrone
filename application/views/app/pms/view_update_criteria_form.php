<style type="text/css">


  

  @media(max-width: 420px){
    .infolist{font-size: 1.5em;}
  }
  .table td {
   text-align: center;   
 }

 .inputBox{
  position: relative;
  box-sizing: border-box;
  margin-bottom: 50px;
}
.inputBox .inputText{
  position: absolute;
  font-size: 24px;
  line-height: 30px;
  transition: .5s;

}
.inputBox .input{
  position: relative;
  width: 100%;
  height: 30px;
  background: transparent;
  border: none;
  outline: none;
  font-size: 16px;
  border-bottom: 1px solid rgba(0,0,0,.5);

}
.focus .inputText{
  transform: translateY(-30px);
  font-size: 17px;
  opacity: 1;
  color: #00bcd4;

}

.button{

  height: 30px;
  border: none;
  outline: none;
  background: #03A9F4;
  color: #fff;
}

.mic-info { color: #666666;font-size: 11px; }

.select2-selection__choice{
  color:black !important;
}

._select_color{
    font-size: 20px;
    padding: 10px 12px;
    font-weight: 300;
    line-height: 28px;
    border-radius: 4px;
    border: 1px solid #ccc;
    -webkit-appearance: none;
    width: 100%;
    height: auto;
    box-shadow: none;
        text-align: left;
    background-image: none;
    color: #796652;
    background: white;
}
._select_color_drop {
    margin: 0;
    padding: 0;
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    top: 99%;
    border-top: 0;
    width: 100%;
}
._select_color_drop > li {
    display: inline-block;
    padding: 7px;
    border-right: 1px solid rgba(192, 192, 192, 0.55);
    cursor: pointer;
    float: left;
}
._select_color_drop > li > .color,.btn > span.color{
    width: 25px;
    height: 25px;
    border-radius: 4px;
    float: left;
}
.btn > span.color{margin-right:10px}
.btn .caret{
    float: right;
    border-top: 7px solid;
    font-size: 28px;
    padding-top: 5px;
    vertical-align: middle;
    position: absolute;
    right: 20px;
    border-left: 5px solid transparent;
    border-right: 5px solid transparent;
    top: 20px;    
}
._select_color_drop > li > .red ,.btn._select_color > span.red{background-color: red;}
._select_color_drop > li > .green ,.btn._select_color > span.green{background-color: green;}
._select_color_drop > li > .yellow ,.btn._select_color > span.yellow{background-color: yellow;}
._select_color_drop > li > .brown ,.btn._select_color > span.brown{background-color: brown;}
._select_color_drop > li > .orange ,.btn._select_color > span.orange{background-color: orange;}
._select_color_drop > li > .pink ,.btn._select_color > span.pink{background-color: pink;}
._select_color_drop > li > .silver ,.btn._select_color > span.silver{background-color: silver;}
._select_color_drop > li > .blue ,.btn._select_color > span.blue{background-color: blue;}
._select_color_drop > li > .TEAL ,.btn._select_color > span.TEAL{background-color: #008080;}
._select_color_drop > li > .NAVY ,.btn._select_color > span.NAVY{background-color: #000080;}
._select_color_drop > li > .PURPLE ,.btn._select_color > span.PURPLE{background-color: #800080;}
._select_color_drop > li > .OLIVE ,.btn._select_color > span.OLIVE{background-color: #808000;}
._select_color_drop > li > .LIME ,.btn._select_color > span.LIME{background-color: #00FF00;}




/*select */
/*.nav {
    left:50%;
    margin-left:-150px;
    top:50px;
    position:absolute;
}
.nav>li>a:hover, .nav>li>a:focus, .nav .open>a, .nav .open>a:hover, .nav .open>a:focus {
    background:#fff;
}
.dropdown {
    background:#fff;
    border:1px solid #ccc;
    border-radius:4px;
    width:300px;    
}
.dropdown-menu>li>a {
    color:#428bca;
}
.dropdown ul.dropdown-menu {
    border-radius:4px;
    box-shadow:none;
    margin-top:20px;
    width:300px;
}
.dropdown ul.dropdown-menu:before {
    content: "";
    border-bottom: 10px solid #fff;
    border-right: 10px solid transparent;
    border-left: 10px solid transparent;
    position: absolute;
    top: -10px;
    right: 16px;
    z-index: 10;
}
.dropdown ul.dropdown-menu:after {
    content: "";
    border-bottom: 12px solid #ccc;
    border-right: 12px solid transparent;
    border-left: 12px solid transparent;
    position: absolute;
    top: -12px;
    right: 14px;
    z-index: 9;
}*/

</style>
  <ul class="nav nav-pills nav-justified" id="rowTab">

      <li><a data-toggle="tab" href="#manage_criteria"><i class="fa fa-pencil-square-o"></i>Manage Criteria</a></li>


        <li><a data-toggle="tab" href="#manage_grading_table" ><i class="fa fa-pencil-square-o"></i>Manage Grading Scale</a></li>

</ul>

<?php $s =  $this->uri->segment('4'); ?>
<?php $company_ =  $this->uri->segment('5');  ?>

<div class="tab-content">
  <div class="tab-pane"  id="manage_criteria">
    <ol>


 
                  <!-- Trigger the modal with a button -->

<!-- Trigger the modal with a button -->

<br>
 <a href="#" type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal"  data-target='#my<?php echo $s?>' ><i class="fa fa-plus"></i> Add Criteria</a> <br> <br>

 <input type="hidden" name="company_" value="<?php  echo $this->uri->segment('5');  ?>">
 <?php  $company_ =  $this->uri->segment('5');  ?>

   <div class="modal"  id="my<?php echo $s?>" role="dialog">
    <div class="modal-dialog modal-lg">
     <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Critera Form</h4>
        <hr class="prettyline">
      </div>

             <?php $form_location   = base_url()."app/pms/save_criteria_form/";?>     
<form role="form"  id="criteria_form" method="post" action="<?php echo $form_location;?>">

    <input type="hidden" name="f" value="<?php  echo $this->uri->segment('4');  ?>">
       <div class="modal-body" id="largemodal" >
         <div class="row">
          <div class="col-sm-12">
<div style="width: 100%; height: 15px; border-bottom: 1px solid #4285f4; text-align: center">
  <span style="font-size: 15px; background-color: #fff; color:black; padding: 0 10px;">
     <i>Required Fields</i><!--Padding is optional-->
  </span>
</div>
<br>

            <!-- Tab panes -->
          
           
       

                  <div class="row" >
                    
                    <div class="form-group">
                      <input type="hidden" name="idcriteria" value="<?php echo $s ?>">
                      
                      
                      <div class="col-md-6">
                        <label for="message-text">Area</label>
                        <input type="text" class="form-control" name="area_name" cid="form_title" placeholder="ex Communication


" required>
                      </div><input type="hidden" name="company_" value="<?php  echo $this->uri->segment('5');  ?>">
               <div class="col-md-6">
                        <label for="message-text">Covered</label>
                     
                        <select  name="cover" class="form-control">
                                     <option value="all" >All</option> 
                          <?php $res = $this->pms_model->position(); foreach($res as $res){?>

                            <option value="<?php echo $res->position_name ?>"><?php  echo $res->position_name;?></option>
                            
                          <?php } ?>
                        </select>
                      </div>
          
                    </div>
                  </div>
                  
                  
                  <div class="row">
                    <div class="form-group">
                      <div class="col-md-6">
                        <label for="message-text">Description</label>
                        <textarea name="description[]" id="form_description" placeholder=" ex: Every communication is positive, clear and precise, open, honest and timely without offence


" required class="form-control"></textarea>
                      </div>
                      <div class="col-md-3">
                        <label for="message-text">weight:</label>                                      
                        <div class="input-group">

                          <input required="" name="des_weight[]" type="number" step="any" class="form-control" id="recipient-name ">
                          <span class="input-group-addon">%</span></div>
                        </div>
                        <div class="col-md-3" style="margin-top:40px;">
                          <a href="#" class="addrow">Add new field</a>
                        </div>
                      </div>
                    </div>
                    <div id="app" ></div>
                    
  <br>

<div style="width: 100%; height: 15px; border-bottom: 1px solid #4285f4; text-align: center">
  <span style="font-size: 15px; background-color: #fff; color:black; padding: 0 10px;">
     <i>Optional Fields</i><!--Padding is optional-->
  </span>
</div> 
<br>
          
                    <div class="row" >
                      <div class="form-group">
                        
                       
                        <div class="col-md-6">
                          <label for="message-text">Measurement</label>
                          <input type="text" class="form-control" name="measurement"  >
                        </div>
                          <div class="col-md-6">
                          <label for="message-text">Target</label>
                          <textarea name="target" id="form_description"  class="form-control"></textarea>
                        </div>
                    
                      </div>
                    </div>
                    
                    
               
                    



        
                  <!--next vet div-->
               
                  <!-- next Shop div-->

                  <!-- next div pet trainer-->
                  
                
              </div>
            </div>       <div class="modal-footer">
              <input type="hidden" name="isEmpty" value="">
                          
            <input type="submit" class=" btn btn-primary" value="submit" id="s"  onclick="save_criteria_form('#my<?php echo $s?>','<?php echo $s?>' , '<?php echo $company_;?>' );" >


              <button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
            </div>
            </form>
          </div>
        
    
      </div><!-- Modal content-->
    </div><!-- Modal dialog-->
</ol>
  <div class="table-responsive">
    <table class="table table-bordered" id="table" >
      <thead>
        <tr class="danger"> 
           <th>Type/Specific Positions</th>
        <th nowrap>form title</th>
        <th nowrap>form description /Weight</th>
        <th>measurement</th>
        <th>target</th>
        <th>level</th>
        <th>Action</th>
      </tr>
      </thead>
      <tbody>
        <div class="card card-body" align="center" >
          <?php
          $id = $s;
          $res= $this->pms_model->manage_criteria_form($id);
          foreach ($res as $res) {   $cid = $res->criteria_id;  ?>
            
            <tr>
              <td class="<?php echo $res->criteria_id?> area_<?php echo $res->criteria_id?>"><?php echo $res->position; ?></td>
              <td class="<?php echo $res->criteria_id?> area_<?php echo $res->criteria_id?>"><?php echo $res->area; ?></td>
              <td ><?php $res2= $this->pms_model->manage_area_weight_form($cid);
              foreach($res2 as $res2){?> 
               <?php  $ids = $res2->criteria_id; ?>
                <table class="table table-bordered" id="criteria" style="table-layout:fixed;"><tbody>
                  <tr>
                    <td style="width: 100px" class="<?php echo $res->criteria_id?> description_<?php echo $res->criteria_id?>"><?php echo $res2->description; ?></td>
                    <td style="width: 50px;" class="<?php echo $res->criteria_id?> weight_<?php echo $res->criteria_id?>">
                      <?php $a=  $this->pms_model->get_weights($res2->criteria_id,$res2->id); foreach($a as $a){ ?>


                      <div class="row">   <?php echo '<b>'.$a->job_level.'</b>'; ?>
                            <div class="form-group col-md-5">

                        <input type="text" class="form-control" size="4" data-s="<?php echo $a->job_level; ?>"  name="<?php echo $res2->criteria_id.$res2->id; ?>[]"  value="<?php if(!empty($a->weight)){ echo  $a->weight;}else{ echo $res2->weight; } ?>">
                      </div>
                    </div>
                   
           
                      <?php }  ?>
                      <button class="button button-success col-md-12" onclick="submit(this,<?php echo $res->criteria_id; ?>,<?php echo $res2->criteria_id.$res2->id; ?>,<?php echo $res2->id  ?>);">save</button>
                    </td>
                  </tr>
                </tbody>
                </table><?php } ?></td>


                <td  class="<?php echo $res->criteria_id?> measurement_<?php echo $res->criteria_id?>"><?php echo $res->measurement; ?></td>
                <td  class="<?php echo $res->criteria_id?> target_<?php echo $res->criteria_id?>"><?php echo $res->target; ?></td>
                <td  class="<?php echo $res->criteria_id?> level_<?php echo $res->criteria_id?>"><?php echo $res->level; ?></td>

                        
                <td ><div class="tooltop1"> <button class="delete_criteria btn btn-danger btn-xs" data-id ="<?php echo $res->criteria_id; ?>"><span class="glyphicon glyphicon-trash"></span></button><span class="tooltiptext">delete</span></div>
                    
                 <div class="tooltop1"> <button onclick="update_criteria_form(<?php echo $s ?> ,<?php echo $res->criteria_id?> ,<?php echo $company_?>);" class="btn btn-warning btn-xs"><span class="glyphicon glyphicon-pencil"></span><span class="tooltiptext">edit</span></button></div>
                  

                </td>
              </tr>
            <?php } ?>

          </tbody>
          


        </table>

      
      </div>
</div>
<!-- sectiiiiionnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnnn -->

         <div class="tab-pane"  id="manage_grading_table">
          <ol>
      
                  <ul class="nav navbar-nav pull-right">
        <li class="dropdown">
          <button class="dropdown-toggle btn btn-link btn-xs pull-right"  data-toggle="dropdown">Copy from other form <span class="glyphicon glyphicon-copy pull-right"></span></button>
          <ul class="dropdown-menu">
            <li><a data-id="<?php echo $s ?>"  id="copy">copy  to all</a> </li>
               <li class="divider"></li> 
            <?php foreach($get_grading_scale as $get_grading_scale ){?>
            <li><a  data-id="<?php echo $get_grading_scale->fid; ?>" class="get_existed_grading"><?php echo $get_grading_scale->form_title; ?></a></li>
            <li class="divider"></li>
                  <?php  $q = $this->pms_model->get_calee($get_grading_scale->fid);foreach($q as $q){?>
            <input type="hidden" name="gid" class="neglect" value="<?php echo $q->gid; ?>">
            <input type="hidden" name="scoring_guide" class="neglect"  value="<?php echo $q->scoring_guide; ?>">
            <input type="hidden" name="score" class="neglect"  value="<?php echo $q->score; ?>">
                    <input type="hidden" name="color" class="neglect" value="<?php echo $q->color; ?>">
            <input type="hidden" name="score_equivalent" class="neglect"  value="<?php echo $q->score_equivalent; ?>">
            <input type="hidden" name="ranking" class="neglect" value="<?php echo $q->ranking; ?>">
            <input type="hidden" name="fid" id="fid" class="neglect"  value="<?php echo $s; ?>">
            <input type="hidden" name="company_" class="neglect" value="<?php echo $company_; ?>">

   
                 <?php } ?>
              <?php } ?>
    
          </ul>
        </li>
      </ul>

    <span class="pull-right">&nbsp; or </span>
    <button type="button" class="btn btn-success btn-xs pull-right" data-toggle="modal" data-target="#myModal"><i class="fa fa-plus"></i>Add New</button> 
  </ol><br><br>


<!-- Modal -->
<div id="myModal" class="modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true" >
                                                        <div class="modal-dialog modal-small">

                                                          <!-- Modal content-->
                                                          <div class="modal-content">
                                                            <div class="modal-header">
                                                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                              <h4 class="modal-title">Modal Header</h4>
                                                            </div>
                                                           <?php $s =  $this->uri->segment('4'); $form_location   = base_url()."app/pms/save_grading_table/";?>     
                                                      <form role="form"  id="form" method="post" action="<?php echo $form_location;?>">
                                                        <input type="hidden" name="fid" value="<?php  echo $this->uri->segment('4');  ?>">
                                                            <div class="modal-body">
                                                            
<!-- 
                                                      <div class="form-group">
                                                                  <label for="recipient-name">Grading Type:</label>
                                                          
                                                                      <div class="input-group">
                                                            <span class="input-group-addon">
                                                              <input  type="radio" value="1" aria-label="..." name="grading_type">
                                                            </span>
                                                            <input type="text" class="form-control" aria-label="..." disabled="" value="numbers">
                                                          </div>
                                                                    <div class="input-group">
                                                            <span class="input-group-addon">
                                                              <input name="grading_type" type="radio" aria-label="..." value="2">
                                                            </span>
                                                            <input type="text" class="form-control" aria-label="..." disabled="" value="Percentage">
                                                          </div>
                                                                </div> -->
                                                                <div class="form-group">

                                                                  <label for="message-text">Score:</label>
                                                                      <?php $g =  $this->pms_model->getgradingtype($this->uri->segment('4'));
                                                                      $grading_type = $g->grading_type;
                                                                  if($g->grading_type == '2'){?>
                                                                  <div class="input-group">
                                                                  <?php $name = 'score_name' ?>
                                                                  <input required="" name="<?php echo $name ?>" type="text" placeholder="ex 95% - 100%" class="form-control" id="recipient-name">
                                                                  <span class="input-group-addon">%</span>
                                                             
                                                                    </div>
                                                                       <?php }else{ ?>
                                                                      <input required="" name="score_name" type="number" class="form-control" placeholder="ex 1" id="recipient-name">
                                                         

                                                               <?php } ?>
                                                                </div><input type="hidden" name="company_" value="<?php  echo $this->uri->segment('5');  ?>">
                                                                 <div class="form-group">
                                                                  <select name="ranking" class="form-control"><option value="1">1 star</option><option value="2">2 star</option><option value="3">3 star</option>/<option value="4">4 star</option>s<option value="5">5 star</option><select>
                                                                </div>
                                                                 <div class="form-group">
                                                                  <label for="message-text">Score equivalent:</label>
                                                                  <input required name="equivalent" type="text" class="form-control" id="recipient-name" placeholder="ex Outstanding
">
                                                                </div> 
                                                                  <div class="form-group">
                                                                          <label>Select color:</label>
                                                                      <div class="dropdown">
                            <button class="btn _select_color dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Green<span class="caret _right"></span>
                            <span _text_display="Green" class="color green"></span></button>
                            <ul class="dropdown-menu _select_color_drop" aria-labelledby="dropdownMenu1">
                                <li><span _text_display="Green" class="color green"></span></li>
                                <li><span _text_display="Red" class="color red"></span></li>
                                <li><span _text_display="Yellow" class="color yellow"></span></li>
                                <li><span _text_display="Brown" class="color brown"></span></li>
                                <li><span _text_display="Orange" class="color orange"></span></li>
                                <li><span _text_display="Pink" class="color pink"></span></li>
                                <li><span _text_display="Silver" class="color silver"></span></li>
                                <li><span _text_display="Bule" class="color blue"></span></li>
                                <li><span _text_display="TEAL" class="color TEAL"></span></li>
                                <li><span _text_display="NAVY" class="color NAVY"></span></li>
                                <li><span _text_display="PURPLE" class="color PURPLE"></span></li>
                                <li><span _text_display="OLIVE" class="color OLIVE"></span></li>
                                <li><span _text_display="LIME" class="color LIME"></span></li>
                            <input type="hidden" name="_color" value="Green"></ul>
                        </div>
                                                                </div> 
                                                                <div class="form-group">
                                                                      <label for="message">Score guide</label>
                                                                  
                                                                      <textarea class="form-control" name="scoring_guide" id="scoring_guide" placeholder="ex Delivers beyond 95% - 100% of KPI.     
" required></textarea>
                                                            
                                                                  </div>

                                                            
                                                         

                                                      </div>
                                                           
                                                            <div class="modal-footer">
                                                               <hr class="prettyline">

                                                                  <input type="submit" class=" btn btn-primary" value="submit" onclick="save_grading_table('<?php echo $s?>' , '<?php echo $company_;?>')" >
                                                                 <button type="button" class="btn btn-default btn-icon" data-dismiss="modal"><i class="fa fa-times-circle"></i> Cancel</button>
                                                                 
                                                           </div>
                                                       </form>
                                                        </div>
                                                      </div>
               



                  </div><!-- /.btn-toolbar/M11 -->
           
          

    
    <form  id="form3" role="form" method="post" action="<?php base_url().'app/pms/save_grading_table_via_ajax'?>" >
        
   <input type="hidden" name="fid" id="fid" class="neglect"  value="<?php echo $s; ?>">

     <div class="table-responsive">
  
        <table id="grading_table" class="table table-striped">
          <thead>
            <tr class="table-info danger">
         
            <!--   <th>grading type</th> -->
              <th>ranking </th>
              <th>score</th>
              <th>score equivalent</th>
              <th>scoring guide</th>
              <th>action </th>
            </tr>
          </thead>
              
          <tbody id="listing">
            <?php   $tableid = 1; $grading_table = $this->pms_model->get_grading_table($s); foreach($grading_table as $grading_table){?>
              <tr class="table-success">
            
               
              <td><?php for ($i=0; $i < $grading_table->ranking ; $i++) { ?>
                        <i style="color:#EFAD4C;" class="fa fa-star"></i> 
             <?php } ?></td>
              <td ><?php echo $grading_table->score ?><?php if($grading_type == "2"){ echo '%';}?></td>
              <td><?php echo $grading_table->score_equivalent ?></td>
              <td ><?php echo $grading_table->scoring_guide ?></td>
              <td id="<?php echo $tableid; ?>"> <div class="tooltop1"><a onclick="view_update_grading_table(<?php echo $s; ?>,<?php echo $company_ ?> , <?php echo $grading_table->gid ?>);"><i class="fa fa-pencil-square-o fa-lg" aria-hidden="true"  style="color: green;"></i></a><span class="tooltiptext">edit</span></div>
                  &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
           <div class="tooltop1">
                <a class="delete" data-id ="<?php echo $grading_table->gid; ?>"><i class="fa fa-trash fa-lg" aria-hidden="true"  style="color: red;"></i></a><span class="tooltiptext">delete</span></div>
           
              </td>
            </tr>
              <?php $tableid++; } ?>
          </tbody>
     
        </table>
     
     </div>
 </form>
      
</div>
    </div> <!-- end of tab container -->


  <script type="text/javascript">
        



      function submit(q,ca,c,areaid){
    weight = [];
    joblevel = [];
    areai = areaid;
    alert(areai);

 $('input[name^='+c+']').each(function() {
   
     weight.push($(this).val());
     joblevel.push($(this).attr('data-s'));


});
 $.ajax({
      url: "<?php echo base_url();?>app/pms/update_weight",
      data: {weight:weight,joblevel:joblevel,c:c,areaid:areaid,ca:ca},
      type: 'post',
      success: function(data){
        alert('You successfully changed the weight');
      }
   
  


      })


    }




_colors=$('._select_color_drop li');
    for (var i = _colors.length - 1; i >= 0; i--) {
        $(_colors[i]).click(function(){
            var color_text = $(this).find('span').attr('_text_display');
            var elemnt = $(this).closest('._select_color_drop').prev();
            elemnt.find('span.color').remove();
            $(this).find('span').clone().appendTo(elemnt);
            var contents = $(elemnt).contents();
            if (contents.length > 0) {
                if (contents.get(0).nodeType == Node.TEXT_NODE) {
                    $(elemnt).html(color_text).append(contents.slice(1));
                }
            }
            if($('[name=_color]').val() == undefined){
                elemnt.next().append("<input type='hidden' name='_color' value='"+color_text+"'>");
            }else{
                $('[name=_color]').val(color_text);
            }
            
        })
    };
  </script>



