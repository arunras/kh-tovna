<!-- <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=true"></script>  -->
<script type="text/javascript" src="<?php echo base_url();?>js/map_create.js"></script>
<?php echo form_open_multipart(site_url("card/saveCard"),array('id'=>'form_createcard')); ?>

<div id="card-wrap">
	<div id="card-wrap-header"><h2><a href="#" onclick="return close_me()"><?php echo img(base_url()."images/btn_close.png"); ?></a></h2></div>
	
	<div id="card-wrap-middle">
		<div id="card-top">
			<div id="card-top-left">
		<script>
        	$(function() {
            	$( "#date" ).datepicker();
        	});
    	</script>
				<div class="card-top-date">
					<?php
						$data = array(
							'name' => 'date',
							'type' => 'text',	
							'id' => 'date',
							'placeholder' => 'Select Date',
							'readonly' => 'true'
						);
						echo form_input($data);
					?>
				</div>
				<div class="card-top-place">
					<?php
						$data1 = array(
							'name' => 'title',
							'type' => 'text',
							'id' => 'place',
							'placeholder' => 'What are you doing here?',	
						);
						echo form_input($data1);
					?>
				</div>
				
				<div class="card-top-btn">
					<div class="btn-top">
						<a href="#" class="btn-eat"><input name="eat" id="eat" type="hidden" value="OFF" /></a>
						<a href="#" class="btn-event"><input name="event" id="event" type="hidden" value="OFF" /></a>
						<a href="#" class="btn-stay"><input name="stay" id="stay" type="hidden" value="OFF" /></a>
					</div>
					<div class="btn-bottom">
						<a href="#" class="btn-beauty"><input name="beauty" id="beauty" type="hidden" value="OFF" /></a>
						<a href="#" class="btn-travel"><input name="travel" id="travel" type="hidden" value="OFF" /></a>
						<a href="#" class="btn-purchase"><input name="purchase" id="purchase" type="hidden" value="OFF" /></a>
						<a href="#" class="btn-etc"><input name="etc" id="etc" type="hidden" value="OFF" /></a>
					</div>
				</div>
				<div class="card-top-textarea">
					<?php 
						$data2 = array(
								'name' => 'description',
								'type' => 'textarea',
								'id' => 'description',
								'rows' => '5',
								'cols' => '30',
								'placeholder' => 'Description..',
						);
						echo form_textarea($data2);
					?>
				</div>
				<div class="card-top-addphoto">
					<a href="#" id="btn_addFiles">
						<?php 
							$image_properties = array(
								'src' => base_url().'images/btn_add_photo.png'		
							);
							echo img($image_properties);
						?>
					</a>		
				</div>
				<div class="card-top-fileupload">
					<div class="file-row">
					<?php
						$data = array(
							'type' => 'file',
							'name' => 'upload0',
							'multiple' => 'multiple',
							'class' => 'userfiles'
						); 
						echo form_upload($data);
						$data1 = array(
							'src' => base_url().'images/recicle_bin.png',		
						);
						//echo "<a href='#' id = 'delFile' style='margin-left: 8px;'>".img($data1) . "</a>";
					?>
					<input type="hidden" name="numFiles" id="numFiles" value="1" />
					</div>
				</div>
			</div>
			<div id="card-top-right">
				<div class="card-top-map">
					<div id="imap">
						Map					
					</div>
					<div class="place-name">
					<?php 
						$data = array(
								'name' => 'place-name',
								'type' => 'text',
								'id' => 'place-name',
								'placeholder' => 'What is the name of this place?'
						);
						echo form_input($data);
					?>
					</div>
					<div class="map-value">
					<?php
						$currenturl = array(
								'name' => 'currenturl',
								'type' => 'hidden',
								'id' => 'currenturl',
								'value' => $this->input->post('currenturl')."?q=saved"
						);
						echo form_input($currenturl);
					
						$latitude = array(
								'name' => 'latitude',
								'type' => 'hidden',
								'id' => 'ilatitude',
								'placeholder' => 'latitude'
						);
						echo form_input($latitude);
						$longitude = array(
								'name' => 'longitude',
								'type' => 'hidden',
								'id' => 'ilongitude',
								'placeholder' => 'longitude'
						);
						echo form_input($longitude);
						$city = array(
								'name' => 'city',
								'type' => 'hidden',
								'id' => 'icity',
								'placeholder' => 'city'
						);
						echo form_input($city);
						$country = array(
								'name' => 'country',
								'type' => 'hidden',
								'id' => 'icountry',
								'placeholder' => 'country'
						);
						echo form_input($country);
						$address = array(
								'name' => 'address',
								'type' => 'text',
								'id' => 'iaddress',
								'placeholder' => 'address',
								'size' => '62',
								'disabled' => 'disabled'
						);
						echo form_input($address);
					?>
					</div>
				</div>
			</div>
		
		</div>
		<div id="card-bottom">
			<div class="card-bottom-checkbox">
				<?php 
					echo form_checkbox('private', 'Private', FALSE); 
					echo form_label('Private','private');
				?>
				<span style="color: #8c8c8c; font-size: 14px;">(your card will be visible to others)</span>
			</div>
			<div class="card-bottom-btn">
				<a href="#" class="btn-save"></a>
				<a href="#" onclick='return close_me()' class="btn-cancel"></a>
			</div>
		</div>
	</div>
	
	<div id="card-wrap-bottom">
	
	</div>
</div>
<?php			
	echo form_close();
?>
<script type="text/javascript">
var base_url = location.protocol + "//" + location.host;
//google.maps.event.addDomListener(window, 'load', initialize);
$(document).ready(function(){
	$('#btn_addFiles').click(function(e){
		e.preventDefault();
		
		$(".card-top-fileupload").append(
				'<div class="file-row"><input type="file" class="userfiles" multiple="multiple" value="" name="upload1"><a href="#" id="delFile" style="margin-left: 8px;" ><img src="' + base_url + '/images/recicle_bin.png"></a></div>');
		rearrange();
	});

	$('.file-row a').live('click', function(e){
		e.preventDefault();
		$(this).parent().remove();
		rearrange();
	});
	
	$(".btn-etc input").val("ON");
	$('.card-top-btn a.btn-etc').css('background-image','url("'+ base_url +'/images/btn_etc_ON.png")');
	initialize();
});
function close_me(){
	$('#pop-create-card').fadeOut(500);
	$('#mask').hide();
	return false;
}

function rearrange(){
	$('#numFiles').val($('.userfiles').length);
	for(var i=0;i<$('.userfiles').length;i++){
		$('.userfiles')[i].name="upload" + i;
	}
}

</script>