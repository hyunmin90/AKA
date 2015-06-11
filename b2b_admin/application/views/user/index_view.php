<div class="container coupon-list-top-margin userindex">

  <div class="row">    
    <div class="col-xs-12">
      <table class="table table-hover coupon-top-margin">
           <thead>
              <tr>
                <th class="text-center" style="width:50px;">No.</th>
                <th class="text-center">Name</th>
                <th class="text-center" style="width:80px;">Email</th>
                <th class="text-center" style="width:200px;">Personal Page</th>
              </tr>
            </thead>
            <tbody id="close_body" class='detail_body'>
              <?php
              foreach ($data as $key => $value) 
              {
              ?>
                <tr class="tr_row" rowid="<?php echo $value['id']; ?>">
                  <td class="text-center"><?php echo $key+1; ?></td>
                  <td class="text-center"><?php echo $value['name']; ?></td>
                  <td class="text-center"><?php echo $value['email']; ?></td>
                  <td class="text-center"><button type="button" class="btn btn-primary btn-sm" id="page" rowId="<?php echo $value['id']; ?>">Page</td>
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

$('table').delegate('tr.tr_row','click',function(){
    var id = $(this).attr('rowid');

    window.location.href = '/user/detail/'+id;
  });

  </script>

