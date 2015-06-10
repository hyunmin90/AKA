		<div class="container admin-container">
		    <div class="row">
		    	<div class="col-xs-12">
		    		
			    	<h3>Register New Partner</h3>
			    	<br>
				</div>
		    </div>

		    <div class="row" style="margin-top:30px;">
		    	<form class="form-horizontal" role="form" method="post" id="fm">
		    	<!-- Name -->
		    	<div class="col-xs-12">
		    	
				<div class="form-group ">
					<label class="col-xs-2 control-label" >Name:</label>
					<div class="col-xs-6">
						<input class="form-control" type="text" name="name" id="name">
					</div>
				</div>
			</div>

			<!-- Image -->
			<div class="col-xs-12">
				<div class="form-group ">
					<label class="col-xs-2 control-label" >Image:</label>
					<div class="col-xs-6">
						<input class="form-control" type="file" name="image" id="image">
					</div>
				</div>

			</div>

			<!-- Admin Info -->
			<div class="col-xs-12">
				<div class="form-group ">
					<label class="col-xs-2 control-label" >Admin Info:</label>
					<div class="col-xs-3">
						<label for="name">ID</label>
						<input type="text" class="form-control" name="admin_id" id="admin_id">
						<label for="inputfile">PW</label>
						<input type="password" class="form-control" name="password" id="password">
					</div>
				</div>
			</div>

			<!-- Category -->
			<div class="col-xs-12">
				<div class="form-group ">
					<label class="col-xs-2 control-label" >Category:</label>
					<div class="col-xs-10">
						<?php foreach ($categories as $value) {
						    	$orig_cate = $value->cate;
						    	$cate = $value->cate;

						    	if($cate == 'freewriting') $cate = 'life writing';
						    ?>
						    <label class="checkbox-inline">
							  	<input type="checkbox" id="category" name="category[]" value="<?php echo $orig_cate; ?>"><?php echo strtoupper($cate); ?>
							</label>				    
						    <?php } ?>
					</div>
				</div>
			</div>

			<!-- Active Date -->
			<div class="col-xs-12">
				<div class="form-group ">
					<label class="col-xs-2 control-label" >Active Date:</label>
					<div class="col-xs-5">
					  
						  <div class="form-group ">
						    <label class="col-xs-2 control-label" >Start:</label>
						    <div class="col-xs-8">
						      <input class="form-control" type="date" name="start" id="start">
						    </div>
						  </div>

					</div>
					<div class="col-xs-5">
					  
						  <div class="form-group ">
						    <label class="col-xs-2 control-label" >Due:</label>
						    <div class="col-xs-8">
						      <input class="form-control" type="date" name="close" id="close">
						    </div>
						  </div>

					</div>
				</div>
			</div>

			<!-- Product -->
			<div class="col-xs-12">
				<div class="form-group ">
					<label class="col-xs-2 control-label" >Product:</label>
					<div class="col-xs-6">
						<?php foreach ($products as $value) {

							$id = $value->id;
			    				$kind = $value->kind;
			    			?>
			    			<label class="checkbox-inline">
			    			<input type="radio" name="product" id="product" value="<?php echo $id;?>" checked> <?php echo $kind; ?>
					</label>				    
				    <?php } ?>
		
					</div>
				</div>
			</div>

			<!-- Word Limit -->
			<div class="col-xs-12">
				<div class="form-group ">
					<label class="col-xs-2 control-label" >Word Limit:</label>
					<div class="col-xs-6">
						<input class="form-control" type="text" name="word_limit" id="word_limit">
					</div>
				</div>
			</div>

			<!-- No. of Coupons -->
			<div class="col-xs-12">
				<div class="form-group ">
					<label class="col-xs-2 control-label" >No. of Coupons:</label>
					<div class="col-xs-6">
						<input class="form-control" type="text" name="send_limit" id="send_limit">
					</div>
				</div>
			</div>

			<!-- Activated Pages -->
			<div class="col-xs-12">
				<div class="form-group ">
					<label class="col-xs-2 control-label" >Activated Pages:</label>
					<div class="col-xs-10">
						<label class="checkbox-inline">
							<input type="checkbox" id="active_page" name="active_page[]" value="1" checked>Coupon
						</label>
						<label class="checkbox-inline">
							<input type="checkbox" id="active_page" name="active_page[]" value="2">User
						</label>
					</div>
				</div>
			</div>
			</form>

		    <div class="row" style="margin-bottom:150px;">  
			    <div class="col-xs-12">	    	
			  		<div class="col-xs-6">
			      		<button class="btn btn-primary pull-right" id="cancel" style="margin-right:5px;">&nbsp;&nbsp;Cancel&nbsp;&nbsp;</button>
			      	</div>
			      	<div class="col-xs-6">
			      		<button class="btn btn-danger pull-left" id="submit" >&nbsp;&nbsp;&nbsp;Save&nbsp;&nbsp;&nbsp;</button>
			  		</div>
			    </div>
			</div>	
			
		</div>
	</body>
</html>

<script>
  var str = "";

  $( "select" ).change(function() {
    str = '';
    $( "select#product option:selected" ).each(function() {
      str += $( this ).text() + "";
    });        
    
    if(str == 'premium'){
      $('input[value="testprep"]').attr('disabled',true);      
      $('input[value="freewriting"]').attr('disabled',true);

      $('input[value="testprep"]').prop('checked',false);
      $('input[value="freewriting"]').prop('checked',false);
      
    }else{
      $('input[value="testprep"]').attr('disabled',false);
      $('input[value="freewriting"]').attr('disabled',false);
    }
  }).trigger( "change" );

  $('#submit').click(function() {
  	//alert("aaaaaaa");
    name = $('input#name').val();
    
    admin_id = $('input#admin_id').val();
    password = $('input#password').val();
    product_id = $('#product').val();
    start = $('input#start').val();
    close = $('input#close').val();
    word_limit = $('input#word_limit').val();
    send_limit = $('input#send_limit').val();

//alert(name + ": " + name.length);
    cates = $("input[id=category]:checked").map(function () {return this.value;}).get().join(",");
//alert(cates);
    activated = $("input[id=active_page]:checked").map(function () {return this.value;}).get().join(",");   
//alert(activated);

    if(name.length == 0)
    {
      alert('Please input a name.');
      $('input#name').focus();
      return false;
    }
    else if(admin_id.length == 0)
    {
      alert("Please fill in the Admin ID.");
      $('input#admin_id').focus();
      return false;
    }   
    else if(password.length == 0)
    {
      alert("Please fill in the Admin Password.");
      $('input#password').focus();
      return false;
    }   
    else if(word_limit.length == 0)
    {
      alert("Please input Word Limit.");
      $('input#word_limit').focus();
      return false;
    }                
    else if(cates.length == 0)
    {
      alert("Please select at least one category.");
      return false;
    }
    else if(activated.length == 0)
    {
      alert("Please select at least one activated pages.");
      return false;
    }
    else if(start.length == 0)
    {
      alert("Please set a Start Date.");
      $('#start').focus();
      return false;
    }    
    else if(close.length == 0)
    {
      alert("Please set a Due date.");
      $('#close').focus();
      return false;
    }    
    else if(word_limit.length == 0)
    {
      alert("Please input Word Limit.");
      $('#word_limit').focus();
      return false;
    }                         
    else if(!$.isNumeric(word_limit))
    {
      alert("숫자만 입력해 주세요.");//isNumeric
      $('#word_limit').focus();
      return false;
    }    
    else if(send_limit.length == 0)
    {
      alert("Please input No. of Coupons.");
      $('#send_limit').focus();
      return false;
    }                         
    else if(!$.isNumeric(send_limit))
    {
      alert("숫자만 입력해 주세요.");//isNumeric
      $('#send_limit').focus();
      return false;
    }
    else
    {
        save = confirm('Do you register new partner?');

        if(save)
        {
        	$('form#fm').attr({action:'/admin/b2b/insert_partner'}).submit(); 
        }            
    }    
  }) // Create coupon end.

  $('#cancel').click(function(){
  	//alert("bbbbbbb");
    window.location.href = '/admin/b2b';
    //window.location.href = 'http://localhost/admin/b2b';

  })

  </script>