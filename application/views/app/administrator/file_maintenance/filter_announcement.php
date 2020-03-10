<div class="row">
  <div class="col-md-10">
    <div class="panel panel-success">
      <div class="panel-heading"><strong>Filter Announcement</strong></div>
        <div class="panel-body">

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="company">Company:</label>
                  <select class="form-control" id="filter_company" name="filter_company" onchange="filter_comp(this.value)" required>
                    <option value="" selected disabled>- Select Company -</option>
                    <option value="All">All</option>
                    <?php
                      foreach ($companyList as $data) 
                    {
                      echo '<option value="'.$data->company_id.'">'.$data->company_name.'</option>';
                    }
                    ?>
                  </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="section">Section:</label>
                  <select class="form-control" id="filter_section" name="filter_section" onchange="filter_sec(this.value)" disabled required>
                    <option value="" selected disabled>- Select Section -</option>
                  </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="division">Division:</label>
                  <select class="form-control" id="filter_division" name="filter_division" onchange="filter_div(this.value)" disabled required>
                    <option value="" selected disabled>- Select Division -</option>
                  </select>
              </div>
            </div>

            <div class="col-md-6">
              <div class="form-group">
                <label for="subsection">Subsection:</label>
                  <select class="form-control" id="filter_subsection" name="filter_subsection" disabled required>
                    <option value="" selected disabled>- Select Subsection -</option>
                  </select>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="col-md-6">
              <div class="form-group">
                <label for="department">Department:</label>
                  <select class="form-control" id="filter_department" name="filter_department" onchange="filter_dept(this.value)" disabled required>
                    <option value="" selected disabled>- Select Department -</option>
                  </select>
              </div>
            </div>

          <div class="form-group">
            <button type="button" class="btn btn-danger pull-right" onclick="announcement_company()">Back</button>
            <a type="button" id="button" class="btn btn-primary pull-right" title="Filter" onclick="view_filter_announcement()">Filter</a>
          </div>
        

        </div>
    </div>
  </div>
</div>
