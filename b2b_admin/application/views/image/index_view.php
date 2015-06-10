<div class="container coupon-list-top-margin">

  <div class="row">    
    <div class="col-md-12">      

      <div class="text-center main">
        <h1>Image Upload</h1><br/>

        <form id="uploadimage" action="" method="post" enctype="multipart/form-data">

          <div id="image_preview">
            <img id="previewing"/>
          </div>  
          
          <div id="selectImage">
            <label>Select Your Image</label><br/>
            <input type="file" name="userfile" id="file" class="text-center" required />
            <br>
            <input type="submit" value="Upload" class="btn btn-coupon-login submit" />
          </div>

        </form>
      </div> <!-- main end. -->

      <div id="message"></div>

    </div> <!-- col-md-12 -->
  </div> <!-- row end. -->
</div> <!-- container end. -->