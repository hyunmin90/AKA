    <div class="container admin-container">
        <div class="row">
          <div class="col-xs-12">
            
            <h3><span class="glyphicon glyphicon-user" aria-hidden="true"></span><?=$data['summary']?>
            <?php if (!$closed) { ?>
              <button type="button" class="btn btn-warning btn-sm pull-right" id="update">update</button>
            <?php } ?>
            </h3>
          </div>
        </div>
        <br>

        <div class="row" style="margin-top:-10px;">
<table class="table table-bordered">          
    <tbody>
    <tr>
      <td width="100" style="background-color:rgb(249,249,249)"><b>Product</b></td>
      <td width="200"><?=$data['product']?></td>
      <td width="120" style="background-color:rgb(249,249,249)"><b>Category</b></td>
      <td><?php 
                    $category_displayed = false;
                    foreach ($categories as $value) {
                      $cate = $value['cate'];
                      if($cate == 'freewriting') $cate = 'lifewriting';
                      if ($data[$cate] == 'Y') {
                        if ($category_displayed == true) {
                          echo " / ";
                        }
                        echo strtoupper($cate);
                        $category_displayed = true;
                      }
                    }
            ?>
      </td>
      <td width="150" style="background-color:rgb(249,249,249)"><b>Coupon Usage</b></td>
      <td><?=$coupon_count['used_count']?>/<?=$coupon_count['total']?> (<?=$coupon_count['percent']?>%)</td>
    </tr>
    <tr>
      <td width="100" style="background-color:rgb(249,249,249)"><b>Start Date</b></td>
      <td width="200"><?=$data['start_date']?></td>
      <td width="100" style="background-color:rgb(249,249,249)"><b>Due Date</b></td>
      <td width="200"><?=$data['close_date']?></td>
      <td width="100" style="background-color:rgb(249,249,249)"><b>Word Limit</b></td>
      <td width="200"><?=$data['words_limit']?></td>
    </tr>
    <tr>
      <td width="100" style="background-color:rgb(249,249,249)"><b>Description</b></td>
      <td colspan="5"><?=$data['_desc']?></td>
    </tr>
    <tr>
      <td width="100" style="background-color:rgb(249,249,249)"><b>Message to Editor</b></td>
      <td colspan="5"><?=$data['message']?></td>
    </tr>


    <tbody>
    </table>
</div>


    <br>
    <div class="row">
          <div class="col-xs-8">
            <div style="display: inline">
            <h3>Members </h3>
          </div>
          </div>
        </div>
        <hr>

        <div class="row" style="margin-top:-10px;">
          <form class="form-horizontal" role="form" method="post" id="fm">

          <!-- Image -->
          <div class="col-xs-12">
            <table class="table table-hover">
           <thead>
              <tr>
                <th style="width:50px;">Name</th>
                <th class="text-center" style="width:200px;">Email</th>
                <th class="text-center">Submission Date</th>
                <th class="text-center">Status</th>
                <th class="text-center">View Paper</th>
              </tr>
            </thead>
            <tbody id="work_body" style="cursor: pointer;">
              <?php 
                  foreach ($current_members as $member) {
               ?>
               <tr><td><?=$member['name']?></td>
                <td class="text-center"><?=$member['send_email']?></td>
                <td class="text-center"><?php if ($member['active'] == '1') {echo $member['active_date'];} else {echo "--";} ?></td>
                <td class="text-center"><?php if ($member['active'] == '1') {echo "Submited";} else if ($member['active'] == '-1') { echo "Deactivated";}  else {echo "Unsubmited";} ?></td>
                <td class="text-center">
                  <?php if(!empty($member['upload_file'])) { echo '<a href="http://admin.edgewritings.com/download/decodeFile/'.$member['writing_id'].'/'.$member['upload_file'].'" class="btn btn-primary btn-sm" >Original</a>';} ?>

                    <?php if(!empty($member['file'])) { echo '<a href="http://admin.edgewritings.com/download/decodeFile/'.$member['writing_id'].'/'.$member['upload_file'].'" class="btn btn-success btn-sm" >Edited</a>';} ?>
                    <!--

                  <?php if ($member['active'] == '1') { ?><button type="button" class="btn btn-primary btn-sm" id="update">Original</button> <button type="button" class="btn btn-success btn-sm" id="update">Edited</button><?php } ?>
                -->
              </td>
              </tr>
               <?php 
                  } 

                    ?>

            </tbody>  
          </table>   
          </div>
      
    </div>
  </body>
</html>

<script>
  var id = '<?=$data['id']?>';

  $('#update').click(function(){
    //alert("bbbbbbb");
    window.location.href = '/coupon/assignment/'+id+'/edit';
    //window.location.href = 'http://localhost/admin/b2b';

  });

  </script>
