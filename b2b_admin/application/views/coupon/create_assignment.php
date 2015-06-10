  <div class="container">
    <div class="row" style="margin-top:130px;">
      <div class="col-xs-12">
        <div class="col-xs-12">
          <form class="form-horizontal" role="form" method="post" id="fm">
              <!-- Name -->
              <div class="form-group ">
                <label id="name" class="col-xs-2 control-label" id="name" >Name</label>
                <div class="col-xs-8">
                  <input class="form-control" type="text" name="name" id="name">
                </div>
              </div>
              <!-- Description -->
              <div class="form-group ">
                <label class="col-xs-2 control-label" id="description" >Description</label>
                  <div class="col-xs-8">
                    <textarea class="form-control" rows="3" name="desc" id="desc"></textarea>
                  </div>
              </div>
              <!-- Message to Editor -->
              <div class="form-group ">
                <label class="col-xs-2 control-label" id="msgeditor">Message to Editor</label>
                <div class="col-xs-8">
                <textarea class="form-control" rows="3" name="message" id="message"></textarea>
                </div>
              </div>
            <!-- Category -->
              <div class="form-group ">
                <label class="col-xs-2 control-label" id="category">Category</label>
                <div class="col-xs-10">
                  <?php foreach ($categories as $value) {
                  $orig_cate = $value['cate'];
                  $cate = $value['cate'];

                  if($cate == 'freewriting') $cate = 'lifewriting';

                  if ($division_info[$cate] == 'Y')  {
                  ?>
                  <label class="checkbox-inline">
                  <input type="checkbox" id="category" name="category[]" value="<?php echo $orig_cate; ?>"><?php echo strtoupper($cate); ?>
                  </label>				    
                  <?php }  } ?>
                </div>
              </div>
            <!-- Active Date -->
              <div class="form-group ">
                <label class="col-xs-2 control-label" id="date" >Date</label>
                <label id="startlabel">start</label>
                <label id="closelabel">close</label><br>
                <div class="col-xs-3">
                  <div class="form-group ">
                    <div class="col-xs-12">
                      <form class="form-date" role="form" action="/'.$ref.'/edit" method="get">
                        <div class="form-group" id="startdatepickid">
                          <div></div>
                          <input type="hidden" name="start" id="start" >
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
                <div class="col-xs-4">
                  <div class="form-group ">
                    <div class="col-xs-8">
                      <form class="form-date" role="form" action="/'.$ref.'/edit" method="get">
                        <div class="form-group" id="duedatepickid">
                          <div></div>
                          <input type="hidden" name="close" id="close" >
                        </div>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
              <br>
              <link href="/css/bootstrap-duallistbox.css" rel="stylesheet" type="text/css" media="all">
              <script src="/js/jquery.bootstrap-duallistbox.js"></script>
              <!-- Active Date -->
              <div class="col-xs-12">
                <label class="col-xs-2 control-label" id="members">Members</label>
                  <div class="col-xs-9">
                    <select multiple="multiple" size="10" name="member" id="member" class="members">
                    <?php foreach ($members as $member) {
                    $member_id = $member['id'];
                    $member_name = $member['name'];
                    $member_email = $member['email'];
                    ?>
                    <option value="<?=$member_id?>"> <?=$member_name?> (<?=$member_email?>) </option>
                    <?php } ?>
                    </select>
                    <script>
                      var members = $('.members').bootstrapDualListbox({
                      nonSelectedListLabel: 'Student Pool',
                      selectedListLabel: 'Member',
                      preserveSelectionOnMove: 'moved',
                      moveOnSelect: false,
                      nonSelectedFilter: ''
                      });
                    </script>
                  </div>
              </div>                  
          </form>
        </div>
        <div class="row" style="margin-bottom:150px;">
          <div id="wrap-bottom" class="col-xs-12">
            <div class="col-xs-6" style="margin-top:3rem;">	    	
              <div class="col-xs-6">
                <button class="btn btn-primary pull-right" id="cancel" style="margin-right:5px;">&nbsp;&nbsp;Cancel&nbsp;&nbsp;</button>
              </div>
              <div class="col-xs-6">
                <button class="btn btn-danger pull-left" id="submit" >&nbsp;&nbsp;&nbsp;Create&nbsp;&nbsp;&nbsp;</button>
              </div>
            </div>
          </div>	
        </div>
      </div>
    </div>
    <div id="myModal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin-top:3%;">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title"><div id='modal_title'>Add Member</div></h4>
                </div>
                <div class="modal-body">
                    Name : <input type="text" name="m_name" id="m_name" size="20"> &nbsp;&nbsp; Email :  <input type="email" name="m_email" id="m_email" size="25">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary" id='modal_save'>Create</button>
                </div>
            </div>
        </div>
    </div>
  </body>
</html>



<script>
  var str = "";
  var send_limit = <?=$division_info['send_limit']?>;
  var issued_count = 0;
  
  $('#startdatepickid div').datepicker({
    todayHighlight: false
    }).on('changeDate', function(e){
      $('#start').val(e.format('yyyy-mm-dd'))
  });
  
  $('#duedatepickid div').datepicker({
    todayHighlight: false
    }).on('changeDate', function(e){
      $('#close').val(e.format('yyyy-mm-dd'))
  });
  
  $('button#add_member').click(function(){
	$("#myModal").modal('show');  
	//return false;
  });

  $('button#modal_save').click(function(){
	m_name = $('input#m_name').val();
	m_email = $('input#m_email').val();

	if(m_name.length == 0)
	{
		alert('Please input a name.');
		$('input#m_name').focus();
		return false;
	}
	else if(m_email.length == 0)
	{
		alert("Please input a email.");
		$('input#m_email').focus();
		return false;
	}

	data = {
		name : m_name,
		email : m_email
	};

	$.post('/coupon/create_b2b_user',data,function(json){              
		if(json['status'])
		{
			alert('New member is created.');
			member_id = json['data']['id'];
			//alert(json['data']['id']);
			members.append('<option value="'+ member_id +'">' + m_name + '  (' + m_email + ') </option>');
			members.bootstrapDualListbox('refresh');
			$("#myModal").modal('hide');  
		}
		else
		{
			alert(json['message']);
		}
	}); 
  });


  $('#submit').click(function() {
	name = $('input#name').val();
	desc = $('textarea#desc').val();
	message = $('textarea#message').val();
	start_date = $('input#start').val();
	close_date = $('input#close').val();

	cates = $("input[id=category]:checked").map(function () {return this.value;}).get().join(",");
	//alert(cates);
	//alert(members.elements.select2.find('option').length);


	member_list = $('[name="member"]').val();
	 if(member_list != null) {
	 	if ( send_limit < Number(issued_count)+Number(member_list.length) ) {
	 		alert('Member count exceed the maximum count.');
	 		return false;
	 	}
	 	//alert(member_list.length); 	
	 }
	

	if(name.length == 0)
	{
		alert('Please input a name.');
		$('input#name').focus();
		return false;
	}
	else if(desc.length == 0)
	{
		alert("Please fill in the Description.");
		$('textarea#desc').focus();
		return false;
	}      
	else if(message.length == 0)
	{
		alert("Please fill in the Description.");
		$('textarea#message').focus();
		return false;
	}  
	else if(cates.length == 0)
	{
		alert("Please select at least one category.");
		return false;
	}
	else if(start_date.length == 0)
	{
		alert("Please set a Start Date.");
		$('#start').focus();
		return false;
	}    
	else if(close_date.length == 0)
	{
		alert("Please set a Due date.");
		$('#close').focus();
		return false;
	}    
	else if(member_list == null)
	{
		alert("Please select at least one member.");
		return false;
	}    
	else
	{

		save = confirm('Do you create new assignment?');

		if(save)
		{
			data = {
				title : name,
				desc : desc,
				message : message,
				product_id : <?php echo $division_info["product_id"]; ?>,
				start : start_date,
				close : close_date,
				discount : <?php echo $division_info["discount"]; ?>,
				limit : <?php echo $division_info["word_limit"]; ?>,
				cates : cates,
				members : member_list,
				division_id : <?php echo $division_info["id"]; ?>,
				limitCount : members.length
			};

			$.post('/coupon/event_create',data,function(json){              
				if(json['status'])
				{
					alert('New assignment has been created successfully.');
					window.location.href = '/coupon';
				}
				else
				{
					//alert(json['result']);
					alert("fail");                 
				}
			});    
        		}
 	}    
  }); // Create coupon end.

  $('#cancel').click(function(){
	window.location.href = '/coupon';
  });

  function get_coupon_usage(){
    $.post('/coupon/get_coupon_usage',{},function(json){
      issued_count = json['data']['total'];
      //alert(send_limit + " :: " + issued_count);
    });
  }

  $(document).ready(function(){    
    get_coupon_usage();
  });



  </script>