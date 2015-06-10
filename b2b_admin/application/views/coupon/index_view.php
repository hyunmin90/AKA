<div class="container coupon-list-top-margin">
   <!-- Coupon Usage -->
    <!-- col-md-10 -->
    <div class="col-xs-12">
      <div id="col-name">
        <div class="col-xs-3">Maximum Coupon</div>
        <div class="col-xs-3">Issued Coupon</div>
        <div class="col-xs-3">Used Coupon</div>
        <div class="col-xs-3">Unused Coupon</div>
      </div>
      <div id="col-value">
        <div id="maximum" class="col-xs-3"><?=$send_limit?></div>
        <div id="total" class="col-xs-3"><h4 id="total" ></h4></div>
        <div id="used" class="col-xs-3"><h4 id="used" > </h4></div>
        <div id="unused"class="col-xs-3"><h4 id="unused" ></h4></div>
      </div>
    </div>
    <!-- col-md-10 end -->
    <div class="row">
      <div class="col-xs-12">
        <a href="/coupon/create_assignment" class="btn btn-primary pull-right">Create New Assignment</a>
      </div>
    </div>
    <br>
  <div class="row">
    <div class="col-xs-12">      
      <!-- Nav tabs -->      
      <ul class="nav nav-tabs" role="tablist">
        <li class="active"><a href="#work" id="work_list" role="tab" data-toggle="tab">On-going</a></li>
        <li><a href="#close"  id="close_list" role="tab" data-toggle="tab">Closed</a></li>          
      </ul>
      <!-- Tab panes -->
      <div class="tab-content assignment-table">
        <div class="tab-pane active font-black" id="work">
          <table class="table">
           <thead>
              <tr>
                <th style="width:50px;">No.</th>
                <th class="text-center" style="width:186px;">Name</th>
                <th class="text-center" style="width:250px;">Description</th>
                <th class="text-center">Product</th>
                <th class="text-center" style="
    width: 9rem;">Start</th>
                <th class="text-center"style="
    width: 9rem;">Close</th>
                <th></th>
              </tr>
            </thead>
            <tbody id="work_body" style="cursor: pointer;">
              <!-- Ajax call -->
            </tbody>  
          </table>   
        </div>
        <div class="tab-pane font-black" id="close" >
          <table class="table">
           <thead>
              <tr>
                <th style="width:50px;">No.</th>
                <th class="text-center" style="width:186px;">Name</th>
                <th class="text-center" style="width:250px;">Description</th>
                <th class="text-center">Product</th>
                <th class="text-center">Start</th>
                <th class="text-center">Close</th><th></th>
              </tr>
            </thead>
            <tbody id="close_body" style="cursor: pointer;">
              <!-- Ajax call -->
            </tbody>  
          </table>  
          <br>
        </div><!-- Close tap-pane end. -->
        <!-- Form -->
        <form id="coupon_form" action="/coupon/assignment" method="POST">
          <input type="hidden" name="event_id" id="event_id" value="">          
        </form>  
        <!-- Form end. -->    
      </div> <!-- Tap-content end. -->
    </div> <!-- col-xs-12 end. -->
  </div> <!-- row end. -->
  <hr>
</div> <!-- container end. -->