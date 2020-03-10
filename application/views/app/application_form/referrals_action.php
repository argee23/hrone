
                    <table class="table table-hover" id="ress">
                        <thead>
                          <tr class="danger">
                            <th style="width: 90%;">Name</th>
                            <th style="width: 10%;">Action</th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php 
                            $na = explode('milajove',$names);
                            $i=1;
                            foreach($na as $a){
                              if($a==''){} else{
                          ?>
                          <tr>
                            <td><?php echo $a;?></td>
                            <td>
                                <a style='cursor:pointer;color:red;' aria-hidden='true' data-toggle='tooltip' title='Click to Remove Name' onclick="remove_referral('<?php echo $a;?>','<?php echo $i;?>');" ><i  class="fa fa-times fa-lg  pull-left"></i></a>
                                <input type="hidden" id="n<?php echo $i;?>">
                            </td>
                          </tr>

                          <?php $i++; } }?>
                        </tbody>
                    </table>

                    <input type="hidden" id="namess" name="namess" value="<?php echo $names;?>"  style='width: 1000px;'>
                    <input type="hidden" id="allnames" name="allnames" value="<?php echo $name_orig;?>"  style='width: 1000px;'>
