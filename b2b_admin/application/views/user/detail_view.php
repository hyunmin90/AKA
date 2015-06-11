<div class="container coupon-list-top-margin detailview">

  <div class="row">
    
    <div class="col-xs-12">
      
      <h3 class="text-left"><b><?php echo $data[0]['name'] . " (" . $data[0]['email'] . ")"; ?></b></h3>
      

      <table class="table table-hover coupon-top-margin">
           <thead>
              <tr>
                <th class="text-center" style="width:50px;">No.</th>
                <th class="text-center" style="width:200px;">Name</th>
                <th class="text-center">Start</th>
                <th class="text-center">Due</th>
                <th class="text-center" style="width:80px;">Status</th>
                <th class="text-center" style="width:80px;">Submission Date</th>
                <th class="text-center" style="width:80px;">Submission Status</th>
                <th class="text-center" style="width:150px;">Viewer Page</th>
              </tr>
            </thead>
            <tbody id="close_body" class='detail_body'>
              <?php
              foreach ($data as $key => $value) 
              {
              ?>
                <tr>
                  <td class="text-center"><?php echo $key+1; ?></td>
                  <td class="text-center"><?php echo $value['summary']; ?></td>
                  <td class="text-center"><?php echo $value['start_date']; ?></td>
                  <td class="text-center"><?php echo $value['close_date']; ?></td>
                  <td class="text-center"><?php if ($value['active'] == '0') {echo "<span class='unsubmitted'></span>Unsubmitted";} else { echo "<span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span>Submitted";} ?></td>
                  <td class="text-center"><?php echo $value['active_date']; ?></td>
                  <td class="text-center"><?php if ($value['active'] == '0') {echo "--";} else if ($value['wrinting_status'] == '0') { echo "On-Going";} else { echo "<span class='glyphicon glyphicon-ok-circle' aria-hidden='true'></span>Done";} ?></td>
                  <td class="text-center">
                    <?php if(!empty($value['upload_file'])) { echo '<a href="http://admin.edgewritings.com/download/decodeFile/'.$value['writing_id'].'/'.$value['upload_file'].'" class="btn btn-primary btn-sm" >Original</a>';} ?>

                    <?php if(!empty($value['file'])) { echo '<a href="http://admin.edgewritings.com/download/decodeFile/'.$value['writing_id'].'/'.$value['upload_file'].'" class="btn btn-success btn-sm" >Edited</a>';} ?>
                    <!--
                    <button type="button" class="btn btn-primary btn-sm" id="update">Original</button> <button type="button" class="btn btn-success btn-sm" id="update">Edited</button>-->
                  </td>
                </tr>
              <?php } ?>
            </tbody>  
          </table>      

    </div> <!-- col-md-12 end. -->

  </div> <!-- row end. -->
  <hr>
</div> <!-- container end. -->
  </body>
</html>

<script>

  $('#page').click(function(){
    var id = $(this).attr('rowid');
    alert(id);

    window.location.href = '/user/detail/'+id;

  });

  </script>

