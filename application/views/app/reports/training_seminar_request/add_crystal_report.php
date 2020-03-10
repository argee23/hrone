
<br><br>
<div class="col-md-12">
</div>
<div class="col-md-12">
    
    <div class="col-md-2"></div>
    <div class="col-md-8">
            
            <div class="col-md-12">
                <div class="col-md-12">
                    <div class="col-md-4">Crystal Report Type</div>
                    <div class="col-md-8">
                        <select class="form-control" id="type" name="type" onchange="get_field_list(this.value);">
                            <option value="">Select Option</option>
                            <option value="training_seminar">Training and Seminar Request</option>
                            <option value="training_seminar_attendees">Training and Seminar Request Attendees</option>
                        </select>
                    </div>
                </div>
            </div>

           <div class="col-md-12" style="margin-top: 5px;">
                <div class="col-md-12">
                    <div class="col-md-4">Report Name</div>
                    <div class="col-md-8">
                        <textarea class="form-control" rows="2" id="name"></textarea>
                        <input type="hidden" id="name_">
                    </div>
                </div>
            </div>

            <div class="col-md-12" style="margin-top: 5px;">
            <div class="col-md-12">
                    <div class="col-md-4">Description</div>
                    <div class="col-md-8">
                        <textarea class="form-control" rows="2" id="description"></textarea>
                        <input type="hidden" id="description_">
                    </div>
                </div>
            </div>
    </div>
    <div class="col-md-2"></div>
  
</div>

<div class="col-md-12" id="filed_list_id">

</div>