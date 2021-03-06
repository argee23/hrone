<div class="box box-success">
  <div class="panel panel-info">
    <div class="col-md-12"><br>
      <ol class="breadcrumb"><h4 class="text-danger" style="font-weight: bold;"><i class="fa fa-bars"></i>Payroll Settings | Add New System Policy</h4></ol>
        <div style="height:295px;">
          <div class="col-md-12">
            <div class="panel panel-success">
              <div class="panel-heading"><strong><center>ADD Policy</strong></center>
               </div>
               <div class="panel-body" id="main_result">
                   <div class="col-md-12">
                   <div class="col-md-2">
                    <label>Policy Title :</label>
                   </div>
                   <div class="col-md-10">
                    
                    <input type="text" name="add_policy" id="add_policy" class="form-control" placeholder="Input Policy Title">
                   </div>
                    <div class="col-md-2"  >
                    <label>Field Type :</label>
                   </div>
                   <div class="col-md-10" style="padding-top: 10px;">
                    <input type="radio" name="field" id="single_field" class="field" value="single_field" onclick="input_type(this.value);"> &nbsp;Single Field &nbsp;
                    <input type="radio" name="field" id="emp_class" class="field" value="employment_classification" onclick="input_type(this.value);">&nbsp; With Employment and Classifications &nbsp;
                    <input type="radio" name="field" id="pay_period" class="field" value="payroll_period" onclick="input_type(this.value);"> &nbsp; With Payroll Period &nbsp;
                    <input type="hidden" id="field_datas">
                   </div>
                    <div class="col-md-2"  >
                    <label>Input Type :</label>
                   </div>
                   <div class="col-md-10" style="padding-top: 10px;">
                        <select class="form-control" id="input_type" onchange="input_format(this.value);">
                        </select>
                   </div>

                    <div class="col-md-2"  >
                    <label>Input Format :</label>
                   </div>
                   <div class="col-md-10" style="padding-top: 10px;" id="input_format">
                   <input type="text" class="form-control">
                   </div>
                   </div>
                   <div class="col-md-12" style="padding-top: 10px;">
                   <div class="box box-danger"></div>
                   <button class="btn btn-success col-md-2 pull-right" onclick="save_system_policy();">Save</button>
                   </div>
               </div>
          </div>
        </div>
      </div>
    </div>
    <div class="btn-group-vertical btn-block"> </div> 
  </div>             
</div>
