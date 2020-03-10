<div class="row">
<div class="col-md-7">

<div class="box box-warning">
<div class="panel panel-warning">

  <div class="panel-heading"><strong>  <?php echo $user_define_fields->udf_label; ?></strong></div>

    <div class="box-body">
    <div class="panel panel-warning">
    <br>

	      <div class="row">

	        <div class="col-md-12">
          <div class="form-group">
            <div class="col-sm-4">
            <p>Field name</p>
            </div>
            <div class="col-sm-7">
              <label>
                  <label><?php echo $user_define_fields->udf_label; ?></label>
              </label>
            </div>
          </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Field type</p>
              </div>
              <div class="col-sm-7">
                <label><?php echo $user_define_fields->udf_type; ?></label>
              </div>
            </div>
          </div>

          <?php if($user_define_fields->udf_type != 'Selectbox' && $user_define_fields->udf_type != 'Datepicker'){?>
          <div class="col-md-12">
            <div class="form-group" >
              <div class="col-sm-4">
              <p>Accept value</p>
              </div>
              <div class="col-sm-7">
                <label><?php echo $user_define_fields->udf_accept_value; ?></label>
              </div>
            </div>
          </div>
          <?php } ?>

          <?php if($user_define_fields->udf_type != 'Selectbox' && $user_define_fields->udf_type != 'Datepicker'){?>
          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Max length</p>
              </div>
              <div class="col-sm-7">
                <label><?php echo $user_define_fields->udf_max_length; ?></label>
              </div>
            </div>
          </div>
          <?php } ?>

          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Allow not null</p>
              </div>
              <div class="col-sm-7">
                <label><?php echo $user_define_fields->udf_not_null; ?></label>
              </div>
            </div>
          </div>

          <div class="col-md-12">
            <div class="form-group">
              <div class="col-sm-4">
              <p>Company</p>
              </div>
              <div class="col-sm-7">
                  <label><?php echo $companyName->company_name; ?></label>
              </div>
            </div>
          </div>

      </div>

     <br>
     </div>
    </div><!-- /.box-body -->
</div>
</div>

</div>  
</div>


