    <div class="box box-success">
      <div class="box-header">
        <h3> Generate Employee Report</h3>
      </div>
        <div class="box-body">
          <div class="form-group" id="reportsId">
            <label for="inputEmail3" class="col-sm-2 control-label">Report Name:</label>
              <div class="col-sm-6">
                <select class="form-control" name="report_name" id="report_name" onchange="report_name()">
                  <option value="">Select Report Name</option>
                  <?php
                  foreach ($reports as $data) 
                  {
                    echo '<option value="'.$data->report_id.'">'.$data->report_name.'</option>';
                  }
                  ?>
                </select>
              </div>
            </div>

          <br><br>
          <div class="form-group">
          <h4><strong>Filter Report By:</strong></h4>
          <hr>
            <label for="company" class="col-sm-2 control-label">Company:</label>
              <div class="col-sm-4">
                <select class="form-control" id="company" onchange="company(this.value)" disabled>
                  <option value="All" selected disabled>- Select Company -</option>
                  <?php
                    foreach ($companyList as $data) 
                  {
                    echo '<option value="'.$data->company_id.'">'.$data->company_name.'</option>';
                  }
                  ?>
                </select>
              </div>
          </div>
          <div class="form-group">
            <label for="section" class="col-sm-2 control-label">Section:</label>
              <div class="col-sm-4">
                <select class="form-control" id="section" onchange="section(this.value)" disabled>
                  <option value="All" selected disabled>- Select Section -</option>
                </select>
              </div>
          </div>
          
          <div class="form-group">
            <label for="division" class="col-sm-2 control-label">Division:</label>
              <div class="col-sm-4">
                <select class="form-control" id="division" onchange="division(this.value)" disabled>
                  <option value="All" selected disabled>- Select Division -</option>
                </select>
              </div>
          </div>
          <div class="form-group">
            <label for="subsection" class="col-sm-2 control-label">Subsection:</label>
              <div class="col-sm-4">
                <select class="form-control" id="subsection" disabled>
                  <option value="All" selected disabled>- Select Subsection -</option>
                </select>
              </div>
          </div>
          <div class="form-group">
            <label for="department" class="col-sm-2 control-label">Department:</label>
              <div class="col-sm-4">
                <select class="form-control" id="department" onchange="department(this.value)" disabled>
                  <option value="All" selected disabled>- Select Department -</option>
                </select>
              </div>
          </div>
          <div class="form-group">
            <label for="classification" class="col-sm-2 control-label">Classification:</label>
              <div class="col-sm-4">
                <select class="form-control" id="classification" disabled>
                  <option value="All" selected disabled>- Select Classification -</option>
                </select>
              </div>
          </div>

          <br>
          <button id="btnFilter" type="button" class="btn btn-warning btn-xs" data-toggle="collapse" data-target="#filter" disabled><i class="fa fa-arrow-down"></i>More Filter Options</button>

          <div class="collapse" id="filter">
            <div class="form-group">
              <label for="location" class="col-sm-2 control-label">Location:</label>
                <div class="col-sm-4">
                  <select class="form-control" id="location">
                    <option value="All" selected disabled>- Select Location -</option>
                    <option value="All">All</option>
                    <?php
                      foreach($locationList as $data)
                    {
                      echo '<option value="'.$data->location_id.'">'.$data->location_name.'</option>';
                    }
                    ?>
                  </select>
                </div>
            </div>

        <div class="form-group">
          <label for="civil_status" class="col-sm-2 control-label">Civil Status:</label>
              <div class="col-sm-4">
                <select class="form-control" id="civil_status">
                  <option value="All" selected disabled>- Select Civil Status -</option>
                  <option value="All">All</option>
                  <?php
                    foreach ($civilStatusList as $data) 
                    {
                      echo '<option value="'.$data->civil_status_id.'">'.$data->civil_status.'</option>';
                    }
                  ?>
                </select>
              </div>
        </div>
        <div class="form-group">
            <label for="employment" class="col-sm-2 control-label">Employment:</label>
              <div class="col-sm-4">
                <select class="form-control" id="employment">
                  <option value="All" selected disabled>- Select Employment -</option>
                  <option value="All">All</option>
                  <?php
                  foreach ($employmentList as $data) 
                  {
                    echo '<option value="'.$data->employment_id.'">'.$data->employment_name.'</option>';
                  }
                  ?>
                </select>
              </div>
          </div>
        <div class="form-group">
          <label for="gender" class="col-sm-2 control-label">Gender:</label>
              <div class="col-sm-4">
                <select class="form-control" id="gender">
                  <option value="All" selected disabled>- Select Gender -</option>
                  <option value="All">All</option>
                  <?php
                    foreach ($genderList as $data) 
                    {
                      echo '<option value="'.$data->gender_id.'">'.$data->gender_name.'</option>';
                    }
                  ?>
                </select>
              </div>
        </div>
        <div class="form-group">
          <label for="religion" class="col-sm-2 control-label">Religion:</label>
              <div class="col-sm-4">
                <select class="form-control" id="religion">
                  <option value="All" selected disabled>- Select Religion -</option>
                  <option value="All">All</option>
                  <?php
                    foreach ($religionList as $data) 
                    {
                      echo '<option value="'.$data->param_id.'">'.$data->cValue.'</option>';
                    }
                  ?>
                </select>
              </div>
        </div>
        <div class="form-group">
          <label for="date_employed" class="col-sm-2 control-label">Date Employed:</label>
              <div class="col-sm-4">
                <select class="form-control" id="date_employed">
                  <option value="All" selected disabled>- Select Date Employed -</option>
                  <option value="All">All</option>
                  <?php
                    foreach ($date_employed as $data) 
                    {
                      echo '<option value="'.$data->date_employed.'">'.$data->date_employed.'</option>';
                    }
                  ?>
                </select>
              </div>
        </div>
        
        <div class="form-group">
          <label for="taxcode" class="col-sm-2 control-label">Tax Code:</label>
              <div class="col-sm-4">
                <select class="form-control" id="taxcode">
                  <option value="All" selected disabled>- Select Tax Code -</option>
                  <option value="All">All</option>
                  <?php
                    foreach ($taxcodeList as $data) 
                    {
                      echo '<option value="'.$data->taxcode_id.'">'.$data->taxcode.'</option>';
                    }
                  ?>
                </select>
              </div>
        </div>
        
        <div class="form-group">
          <label for="paytype" class="col-sm-2 control-label">Pay Type:</label>
              <div class="col-sm-4">
                <select class="form-control" id="paytype">
                  <option value="All" selected disabled>- Select Pay Type -</option>
                  <option value="All">All</option>
                  <?php
                    foreach ($paytypeList as $data) 
                    {
                      echo '<option value="'.$data->pay_type_id.'">'.$data->pay_type_name.'</option>';
                    }
                  ?>
                </select>
              </div>
        </div>
        
        <div class="form-group">
          <label for="status" class="col-sm-2 control-label">Employee Status:</label>
              <div class="col-sm-4">
                <select class="form-control" id="status">
                  <option value="All" selected disabled>- Select Employee Status -</option>
                  <option value="All">All</option>
                  <option value="0">Active</option>
                  <option value="1">Inactive</option>
                </select>
              </div>
        </div>

        <div class="form-group">
          <label for="age" class="col-sm-2 control-label">Age:</label>
              <div class="col-sm-2">                  
                <select class="form-control" id="age" onchange="age(this.value)">
                  <option value="All" selected disabled>- Select Age -</option>
                  <option value="All">All</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                  <option value="32">32</option>
                  <option value="33">33</option>
                  <option value="34">34</option>
                  <option value="35">35</option>
                  <option value="36">36</option>
                  <option value="37">37</option>
                  <option value="38">38</option>
                  <option value="39">39</option>
                  <option value="40">40</option>
                  <option value="41">41</option>
                  <option value="42">42</option>
                  <option value="43">43</option>
                  <option value="44">44</option>
                  <option value="45">45</option>
                  <option value="46">46</option>
                  <option value="47">47</option>
                  <option value="48">48</option>
                  <option value="49">49</option>
                  <option value="50">50</option>
                  <option value="51">51</option>
                  <option value="52">52</option>
                  <option value="53">53</option>
                  <option value="54">54</option>
                  <option value="55">55</option>
                  <option value="56">56</option>
                  <option value="57">57</option>
                  <option value="58">58</option>
                  <option value="59">59</option>
                  <option value="60">60</option>
                  <option value="61">61</option>
                  <option value="62">62</option>
                  <option value="63">63</option>
                  <option value="64">64</option>
                  <option value="65">65</option>
                  <option value="66">66</option>
                  <option value="67">67</option>
                  <option value="68">68</option>
                  <option value="69">69</option>
                  <option value="70">70</option>
                  <option value="71">71</option>
                  <option value="72">72</option>
                  <option value="73">73</option>
                  <option value="74">74</option>
                  <option value="75">75</option>
                  <option value="76">76</option>
                  <option value="77">77</option>
                  <option value="78">78</option>
                  <option value="79">79</option>
                  <option value="80">80</option>
                  <option value="81">81</option>
                  <option value="82">82</option>
                  <option value="83">83</option>
                  <option value="84">84</option>
                  <option value="85">85</option>
                  <option value="86">86</option>
                  <option value="87">87</option>
                  <option value="88">88</option>
                  <option value="89">89</option>
                  <option value="90">90</option>
                  <option value="91">91</option>
                  <option value="92">92</option>
                  <option value="93">93</option>
                  <option value="94">94</option>
                  <option value="95">95</option>
                  <option value="96">96</option>
                  <option value="97">97</option>
                  <option value="98">98</option>
                  <option value="99">99</option>
                </select>
              </div>
              <!-- <label for="age_comparator" class="col-sm-1 control-label">years old</label> -->
              <div class="col-sm-2">
                <select class="form-control" id="age_comparator" disabled>
                  <option value="All" selected>All</option>
                  <option value="eq">exact</option>
                  <option value="gt">above</option>
                  <option value="lt">below</option>
                </select>
              </div>
        </div>    

        <div class="form-group">
          <label for="years" class="col-sm-2 control-label">Years of Employment:</label>
              <div class="col-sm-2">
                <select class="form-control" id="years" onchange="years(this.value)">
                  <option value="All" selected disabled>- Select Years -</option>
                  <option value="All">All</option>
                  <option value="1">1</option>
                  <option value="2">2</option>
                  <option value="3">3</option>
                  <option value="4">4</option>
                  <option value="5">5</option>
                  <option value="6">6</option>
                  <option value="7">7</option>
                  <option value="8">8</option>
                  <option value="9">9</option>
                  <option value="10">10</option>
                  <option value="11">11</option>
                  <option value="12">12</option>
                  <option value="13">13</option>
                  <option value="14">14</option>
                  <option value="15">15</option>
                  <option value="16">16</option>
                  <option value="17">17</option>
                  <option value="18">18</option>
                  <option value="19">19</option>
                  <option value="20">20</option>
                  <option value="21">21</option>
                  <option value="22">22</option>
                  <option value="23">23</option>
                  <option value="24">24</option>
                  <option value="25">25</option>
                  <option value="26">26</option>
                  <option value="27">27</option>
                  <option value="28">28</option>
                  <option value="29">29</option>
                  <option value="30">30</option>
                  <option value="31">31</option>
                  <option value="32">32</option>
                  <option value="33">33</option>
                  <option value="34">34</option>
                  <option value="35">35</option>
                  <option value="36">36</option>
                  <option value="37">37</option>
                  <option value="38">38</option>
                  <option value="39">39</option>
                  <option value="40">40</option>
                  <option value="41">41</option>
                  <option value="42">42</option>
                  <option value="43">43</option>
                  <option value="44">44</option>
                  <option value="45">45</option>
                  <option value="46">46</option>
                  <option value="47">47</option>
                  <option value="48">48</option>
                  <option value="49">49</option>
                  <option value="50">50</option>
                  <option value="51">51</option>
                  <option value="52">52</option>
                  <option value="53">53</option>
                  <option value="54">54</option>
                  <option value="55">55</option>
                  <option value="56">56</option>
                  <option value="57">57</option>
                  <option value="58">58</option>
                  <option value="59">59</option>
                  <option value="60">60</option>
                  <option value="61">61</option>
                  <option value="62">62</option>
                  <option value="63">63</option>
                  <option value="64">64</option>
                  <option value="65">65</option>
                  <option value="66">66</option>
                  <option value="67">67</option>
                  <option value="68">68</option>
                  <option value="69">69</option>
                  <option value="70">70</option>
                  <option value="71">71</option>
                  <option value="72">72</option>
                  <option value="73">73</option>
                  <option value="74">74</option>
                  <option value="75">75</option>
                  <option value="76">76</option>
                  <option value="77">77</option>
                  <option value="78">78</option>
                  <option value="79">79</option>
                  <option value="80">80</option>
                  <option value="81">81</option>
                  <option value="82">82</option>
                  <option value="83">83</option>
                  <option value="84">84</option>
                  <option value="85">85</option>
                  <option value="86">86</option>
                  <option value="87">87</option>
                  <option value="88">88</option>
                  <option value="89">89</option>
                  <option value="90">90</option>
                  <option value="91">91</option>
                  <option value="92">92</option>
                  <option value="93">93</option>
                  <option value="94">94</option>
                  <option value="95">95</option>
                  <option value="96">96</option>
                  <option value="97">97</option>
                  <option value="98">98</option>
                  <option value="99">99</option>
                </select>
              </div>
          <!-- <label for="years_comparator" class="col-sm-1 control-label">years</label> -->
              <div class="col-sm-2">
                <select class="form-control" id="years_comparator" disabled>
                  <option value="All" selected>All</option>
                  <option value="eq">exact</option>
                  <option value="gt">above</option>
                  <option value="lt">below</option>
                </select>
              </div>
        </div>
      <br><br><br><br><br><br><br>
      </div>
      <br><br><br>
      <a type="button" id="button" class="btn btn-success btn-flat btn pull-right" title="Generate Another Report" onclick="filter_employee()"><i class="fa fa-file"></i> Generate Employee Report </a>
    </div>
  </div>
    