<style type="text/css">
  h2 {
  text-align: center;
}

table caption {
  padding: .5em 0;
}

@media screen and (max-width: 767px) {
  table caption {
    border-bottom: 1px solid #ddd;
  }
}

.p {
  text-align: center;
  padding-top: 140px;
  font-size: 14px;
}
</style>


<h2>Responsive Table with Bootstrap</h2>

<div class="container">
  <div class="row">
    <div class="col-xs-12">
      <div class="table-responsive">
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th width="15%">Date</th>
              <th width="20%">No.of Hours</th>
              <th width="30%">Overtime</th>
              <th width="30%">Filed Forms</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>
        <table class="table table-bordered table-hover">
          <thead>
            <tr>
              <th width="15%">january</th>
              <th width="20%">Day</th>
              <th width="30%">Overtime</th>
              <th width="30%">Shift Time</th>
            </tr>
          </thead>
        </table>                

              </td>
              <td>Spanish (official), English, Italian, German, French</td>
              <td>41,803,125</td>
              <td>31.3</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td colspan="5" class="text-center">Data retrieved from <a href="http://www.infoplease.com/ipa/A0855611.html" target="_blank">infoplease</a> and <a href="http://www.worldometers.info/world-population/population-by-country/" target="_blank">worldometers</a>.</td>
            </tr>
          </tfoot>
        </table>
      </div><!--end of .table-responsive-->
    </div>
  </div>
</div>

