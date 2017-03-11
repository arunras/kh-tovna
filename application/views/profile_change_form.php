<div class="uploader-top"><a href="#" onclick="return close_upload_form()">&nbsp;</a></div>
<div class="uploader-middle">
<div class="uploader-content">
<p id="error"></p>
<form action="" enctype="multipart/form-data" method="post" id="userform" onsubmit="return ajax_upload()">
	<input id="userfile" type="file" size="45" name="userfile" class="input">
	<input type="submit" value="Upload" class="button" id="bottonUpload" />
</form>
<hr class="line"/>
		<div class="jcrop-big-image">
          <img src="<?php echo $filename?>"  id="target" />
          </div>
          <div class="jcrop-div-preview">
            <img src="<?php echo $filename?>" id="preview" class="jcrop-preview" />
          </div>
    	<form action="<?php echo base_url()?>profile/saveCropPicture" method="post" onsubmit="return checkCoords();">
			<input type="hidden" id="x" name="x" />
			<input type="hidden" id="y" name="y" />
			<input type="hidden" id="w" name="w" />
			<input type="hidden" id="h" name="h" />
			<input type="hidden" id="filename" name="filename" value="<?php echo $filename?>" />
			<input type="submit" value="Crop Image" />
		</form>
</div>
</div>
<div class="uploader-bottom"></div>
<script type="text/javascript">

    jQuery(function($){

      // Create variables (in this scope) to hold the API and image size
      var jcrop_api, boundx, boundy;
      
      $('#target').Jcrop({
        onChange: updatePreview,
        onSelect: updatePreview,
        aspectRatio: 1
      },function(){
        // Use the API to get the real image size
        var bounds = this.getBounds();
        boundx = bounds[0];
        boundy = bounds[1];
        // Store the API in the jcrop_api variable
        jcrop_api = this;
      });

      function updatePreview(c)
      {
        if (parseInt(c.w) > 0)
        {
          var rx = 100 / c.w;
          var ry = 100 / c.h;

          $('#preview').css({
            width: Math.round(rx * boundx) + 'px',
            height: Math.round(ry * boundy) + 'px',
            marginLeft: '-' + Math.round(rx * c.x) + 'px',
            marginTop: '-' + Math.round(ry * c.y) + 'px'
          });
        }
        //Update Co-ord
        $('#x').val(c.x);
		$('#y').val(c.y);
		$('#w').val(c.w);
		$('#h').val(c.h);
        
      };

    });
    function checkCoords()
	{
		if (parseInt($('#w').val())) return true;
		alert('Please select a crop region then press submit.');
		return false;
	};
  </script>