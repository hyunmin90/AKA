<div class="container">
  
  <div class="row coupon-list-top-margin">
  	
    <!-- col-md-12 -->
    <div class="col-md-12">
  		<div class="col-md-4">
	   		<a id="totalModal" data-toggle="modal" data-target="#myModal" href="#"><h4 id="total" >Total Coupon : </h4></a>        
  		</div>	
  		<div class="col-md-4">
  			<h4 id="used" >Used Coupon : </h4>
  		</div>	
  		<div class="col-md-4">
  			<h4 id="unused" >Unused Coupon : </h4>
  		</div>	
    </div> 
    <!-- col-md-12 end. -->
  </div>  
  
  <div class="row coupon-top-margin">
    <!-- col-md-12 -->
    <div class="col-md-12">
      <div class="progress">
        <div class="progress-bar progress-bar-success" id="progress" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width: 0%">
          <span class="sr-only">0% Complete (success)</span>
        </div>
      </div>
    </div>
    <!-- col-md-12 end. -->
  </div> 
  
  <div class="row coupon-top-margin">
    
    <div class="col-md-12">
      <div class="col-md-2">
        <h4>Category : </h4>
      </div>
    
      <?php
      
      if($data['get_event_data']['testprep'] == 'Y')
      {
        echo '<div class="col-md-2"><h4><span class="label label-success cate-laber">Testprep</span></h4></div>';
      }
      
      if ($data['get_event_data']['academic'] == 'Y') 
      {
        echo '<div class="col-md-2"><h4><span class="label label-primary cate-laber">Academic</span></h4></div>';
      }
      
      if ($data['get_event_data']['admission'] == 'Y') 
      {
        echo '<div class="col-md-2"><h4><span class="label label-info cate-laber">Admission</span></h4></div>';
      }
      
      if ($data['get_event_data']['lifewriting'] == 'Y') 
      {
        echo '<div class="col-md-2"><h4><span class="label label-warning cate-laber">Life writing</span></h4></div>';
      }

      ?>
      <div class="col-md-2">
        <h4>Word limit : <?php echo $data['get_event_data']['words_limit'];?></h4>
      </div>
    </div>

  </div>
  
  <div class="row coupon-top-margin">
  	
    <div class="col-md-12">
      <?php if($data['result_date_diff'] == 0){ ?>
      <h4 class="text-center" style="color:red;">종료된 이벤트 입니다.</h4>
      <? } ?>
      <h4 id="available_coupon">사용가능한 쿠폰수 : </h5>
  		<textarea class="form-control" rows="6" id="emails" placeholder=" insert emails" style="resize: none;" <?php if($data['result_date_diff'] == 0) echo 'disabled';?>></textarea>
  		<br><br>
  		<button class="btn btn-danger pull-right" id="coupon_submit" disabled>Send Coupon</button>
  	</div>
  </div>

  <div class="row coupon-top-margin coupon-bottom-margin">
  	<div class="col-md-12">
  		<p><span style="font-size:18px;">중복된 E-email</span> (중복된 E-mail은 이미 같은 이벤트에서 쿠폰을 보낸 메일을 뜻합니다.)</p>
      <p id="exist"></p>
  	</div>
  </div>  

  <!-- Modal -->
  <!-- Button trigger modal --> 
  
  <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
          <h4 class="modal-title" id="myModalLabel">전체 쿠폰</h4>
        </div>
        <div class="modal-body">
          <table class="table">
            <thead>
              <tr>
                <th style="width:50px;">No.</th>
                <th class="text-center" style="width:200px;">E-mail</th>
                <th class="text-center" style="width:200px;">Active</th>
              </tr>
            </thead>

            <tbody id="modal_table" class="text-center">
              <!-- Ajax -->
            </tbody>
          </table>
        </div>        
      </div>
    </div>
  </div>

  <hr>
</div> <!-- /container -->   

