<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<script src="/js/bootstrap.min.js"></script>    
<script src="/js/ie10-viewport-bug-workaround.js"></script>



<?php if($page == 'welcome') {?>
<script type="text/javascript">
    
  
$('button#sign_in').click(function(e)
{
  e.preventDefault();
  var email = $.trim($('#email').val());
  var password = $.trim($('#password').val());
  
  if(email == '')
  {
    alert('Please input email.');
    $('input#email').focus();
  }
  else if(password == '')
  {
    alert('Plaese input password.');
    $('input#password').focus();
  }  
  else
  {
    data = {
      email : email,
      password : password
    }   
    
    $.post('/login/sign_in',data, function(json){      
      if(json['status'])
      { 
        window.location.replace('/');        
      }
      else
      {
        alert(json['message']);
        $('input#password').val('');
        $('input#password').focus();          
      }
    })   
  } // Else end.
});

</script>
<?php }elseif($page =='coupon_send') {?>
<script>
var confirm_email = true;  
var event_id = "<?php echo $event_id;?>";
var total_count = '';
var send_limit = <?php echo $send_limit;?>;

$(document).ready(function(){
  datas = {event_id : event_id};
  
  $.post('/coupon/couponCount',datas,function(json){
    datas = $.parseJSON(json['datas'])    
    
    total_count = datas['data']['total'];    
    $('#total').text('Total Coupon : '+datas['data']['total']);
    $('#used').text('Used Coupon : '+datas['data']['used_count']);
    $('#unused').text('Unused Coupon : '+datas['data']['unused_count']);

    percent = (datas['data']['used_count'] * 100) / datas['data']['total'];    
    $('#progress').attr('aria-valuenow',percent);
    $('#progress').css('width',percent+'%');
    $('#progress').text(Math.round(percent)+'% Used')

    if(total_count < send_limit)
    {
      $('#coupon_submit').attr('disabled',false);
    }
    
    $('#available_coupon').text('사용가능한 쿠폰수 : '+ (parseInt(send_limit) - (parseInt(total_count))));  
  });  
});

// Ready end. //


function IsEmail(email) {
  var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}

$('#coupon_submit').click(function(){
  coupon_emails = $.trim($('textarea#emails').val());  
  split_emails = coupon_emails.split(',');      

  if(coupon_emails == '')
  {
    alert('email를 입력해 주세요.');
  }
  else 
  {

    $.each(split_emails,function(i,val){
      
      val = $.trim(val);

      if(!IsEmail(val))
      {
        alert('이메일 형식이 틀렸습니다.');
        return confirm_email = false;
      }
      else
      {
        return confirm_email = true; 
      }
    });
    
    if(confirm_email)
    {
      datas = {
                emails : coupon_emails,
                event_id : event_id
      }      

      $.post('/coupon/submit',datas,function(json){
        result = $.parseJSON(json['datas']);       

        if(result['status'] == 'true')
        {
          alert('쿠폰을 발송했습니다.');
          // redirect_page = confirm('쿠폰을 발송했습니다. 발송된 리스트를 확인하시겠습니까?');
          // if(redirect_page)
          // {
          //   window.location.replace('/');
          // }
          $('textarea#emails').val('');
        }
        else
        {
          alert('쿠폰발송에 실패 하였습니다.');
        }        

        total_count = result['data']['count_coupon']['total'];
        if(total_count < send_limit)
        {
          $('#coupon_submit').attr('disabled',false);
        }
        else
        {
          $('#coupon_submit').attr('disabled',true);
        }

        $('#total').text('Total Coupon : ' + result['data']['count_coupon']['total']);
        $('#used').text('Used Coupon : ' + result['data']['count_coupon']['used_count']);
        $('#unused').text('Unused Coupon : ' + result['data']['count_coupon']['unused_count']);
        $('#exist').text(result['data']['exist_array']);

        percent = (result['data']['count_coupon']['used_count'] * 100) / result['data']['count_coupon']['total'];
        $('#progress').attr('aria-valuenow',percent);
        $('#progress').css('width',percent+'%');
        $('#progress').text(Math.round(percent)+'% Used')

      });  // post end.
    } // if end.
  }
}); 


counter = function() {  
  emails_data = $('#emails').val();  
  comma_match = emails_data.match(/,/g);
  a_match = emails_data.match(/@/g);
  limit = send_limit;
  available_count = limit-total_count;

  if(emails_data.length == 0)
  {    
    $('#available_coupon').text('사용가능한 쿠폰수 : '+ (limit - total_count));    
    $('#coupon_submit').attr('disabled',false);
  }
  else if(a_match)
  {
    available_count = available_count - (a_match.length);    
  } 

  if(available_count < 0)
  {
    $('#available_coupon').text('사용가능한 쿠폰수 : 0');
    $('#coupon_submit').attr('disabled',true);
  }
  else
  {   
    $('#available_coupon').text('사용가능한 쿠폰수 : '+ available_count);
    $('#coupon_submit').attr('disabled',false);
  }  
  
}

$('#emails').keyup(counter);


$('#totalModal').click(function(){
  $('#modal_table').empty();  

  $.post('/coupon/total',{event_id : event_id},function(json){
    results = $.parseJSON(json['datas']);    

    $.each(results['data'],function(i,val){
      email = val['send_email'];
      active = val['active'];     
      
      if(active == '1')
      {
        active = '<p style="color:red;">TRUE</p>'
      }
      else
      {
        active = 'FALSE' 
      }

      $('#modal_table').append('<tr><td>'+(i+1)+'</td><td>'+email+'</td><td>'+active+'</td></tr>');

    })
  });
});

</script> 
 
<?php }elseif($page == 'coupon_index'){ ?>
<script>
  function get_event_list(gubun,body_id){
    $.post('/coupon/get_event_list',{gubun : gubun},function(json){
      datas = $.parseJSON(json['datas'])
      results = datas['data'];

      num = results.length;

      if(body_id == 'close_body') { 
          $('tbody#close_body').empty();
      }

      $.each(results,function(i,val){
        
        id = val['id'];
        summary = val['summary'];
        desc = val['_desc'];
        product = val['product'];
        //discount = val['discount'];
        s_date = val['start_date'];
        c_date = val['close_date'];
        // s_date = val['show_date'];
        // c_date = val['show_close_date'];

        $('tbody#'+body_id).append('<tr class="tr_row" rowid="row'+id+'">'
                                +'<td>'+num+'</td>'
                                +'<td>'+summary+'</td>'
                                +'<td>'+desc+'</td>'
                                +'<td class="text-center">'+product+'</td>'
                                +'<td class="text-center">'+s_date+'</td>'
                                +'<td class="text-center">'+c_date+'</td>'
                                +'<td class="setting"><span class="glyphicon glyphicon-search detail" rowid="row'+id+'"></span><span class="glyphicon glyphicon-cog update" rowid="row'+id+'"></span></td>'
                              +'</tr>');
        num--;
      });
    });
  }

  function get_coupon_usage(){
    $.post('/coupon/get_coupon_usage',{},function(json){
      issued_count = json['data']['total'];
      used_count = json['data']['used_count'];
      //data = $.parseJSON(json['data']);
      //alert (data);

    datas = json['data'];
    
    total_count = datas['total'];     
    $('#total').text('  '+datas['total']);
    $('#used').text('  '+datas['used_count']);
    $('#unused').text('  '+datas['unused_count']);
    });
  }

  $(document).ready(function(){    
    get_coupon_usage();
    get_event_list('>','work_body');
  });

  $('table').delegate('td>span.glyphicon.glyphicon-search.detail','click',function(){    
    this_id = $(this).attr('rowid');
    this_id = this_id.substring(3);

    window.location.href = "/coupon/assignment/"+this_id;
    //$('input#event_id').val(this_id);
    //$('form#coupon_form').submit();     
  });
  
  $('table').delegate('td>.glyphicon.glyphicon-cog.update','click',function(){    
    this_id = $(this).attr('rowid');
    this_id = this_id.substring(3);
    window.location.href = "/coupon/assignment/"+this_id+"/edit";
    //$('input#event_id').val(this_id);
    //$('form#coupon_form').submit();     
  }); 
  


  $('#close_list').click(function(){
    get_event_list('<=','close_body'); 
  });
  </script>
<?php }elseif($page == 'users') {?>
<script>

$(document).ready(function(){
  var user_count = <?php echo $user_count; ?>;  
  var active_count = <?php echo $active_count; ?>;

  percent = (active_count * 100) / user_count;    
  $('#progress').attr('aria-valuenow',percent);
  $('#progress').css('width',percent+'%');
  $('#progress').text(Math.round(percent)+'% Used')
});

</script>
<?php }elseif($page == 'image') { ?>
<script>

$(document).ready(function (e) {
  $("#uploadimage").on('submit',(function(e) {
    e.preventDefault();
    $("#message").empty();
    $('#loading').show();
    
    $.ajax({
        url: "/upload", // Url to which the request is send
        type: "POST",             // Type of request to be send, called as method
        data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false,       // The content type used when sending data to the server.
        cache: false,             // To unable request pages to be cached
        processData:false,        // To send DOMDocument or non processed data file it is set to false
        success: function(data)   // A function to be called if request succeeds
        {
          $('#loading').hide();
          $("#message").html(data);
        }
    });
  }));
});

// Function to preview image after validation
$(function() {
  
  $("#file").change(function() {
    $("#message").empty(); // To remove the previous error message
    var file = this.files[0];
    var imagefile = file.type;
    var match= ["image/jpeg","image/png","image/jpg"];
    if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
    {      
      $("#message").html("<p id='error'>Please Select A valid Image File</p>"+"<h4>Note</h4>"+"<span id='error_message'>Only jpeg, jpg and png Images type allowed</span>");
      return false;
    }
    else
    {      
      var reader = new FileReader();
      reader.onload = imageIsLoaded;
      reader.readAsDataURL(this.files[0]);
    }
  });
});

function imageIsLoaded(e) {
  $("#file").css("color","green");
  $('#image_preview').css("display", "block");
  $('#previewing').attr('src', e.target.result);
  $('#previewing').attr('width', 'auto');
  $('#previewing').attr('height', 'auto');
};

</script>
<?php }elseif($page == 'edit') { ?>
<script>
alert("");



</script>
<?php } ?>


