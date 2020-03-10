<!-- <div class="well"> -->
  <div class="box box-success">
    <div class="box-header">
      <!-- <h1>Coachella</h1> -->
    </div>
    <div class="box-body">
      <h4> Select Type of Question: </h4>
        <div class="row">
        <div class="col-md-6">
        <select class="form-control select2" name="quesType" id="quesType" style="width: 100%;" onchange="questions_sub(this.value)">
          <option selected="selected" disabled="disabled" value="0"> - Select - </option>
          <option value="1"> Qualifying Questions </option>
          <option value="2"> Hypothetical Questions </option>
          <option value="3"> Multiple Choice Questions </option>
        </select>
        </div>
        </div>
      <div id="questionBody"></div>
      
    </div>
    </div>
<!-- </div> -->


