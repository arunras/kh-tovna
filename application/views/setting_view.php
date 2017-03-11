<?php $currentMethod = $this->uri->segment(2);?>
<div id="setting">
	<div class="navigate">
		<a href="<?php echo site_url('setting/general')?>" class="<?php if($currentMethod=='general' || $currentMethod=="") echo 'selected'?>" title="Change your private">General</a>
		<a href="<?php echo site_url('setting/profile')?>" class="<?php if($currentMethod=='profile') echo 'selected'?>">My Profile</a>
		<a href="<?php echo site_url('setting/email')?>" class="<?php if($currentMethod=='email') echo 'selected'?>">Change Email</a>
	</div>
	<div class="content">
	<!-- 
		<div class="val-error">
		<?php echo validation_errors(); ?>
		</div>
	 -->
		<?php if($currentMethod=="general"){
			echo form_open();
			echo form_checkbox('public', 'Public', TRUE); 
			echo form_label('Public','public') . "</br>";
			echo form_checkbox('show_email', 'Show Email', TRUE);
			echo form_label('Show Email','show_email') . "</br>";
			echo form_checkbox('show_unfriend', 'Show Unfriend', False);
			echo form_label('Show Unfriend','show_unfriend');
			echo br(1);
			echo form_submit('general_save','Save');
			echo form_close();
		?>
		<?php }
			else if($currentMethod=="profile"){
			$attributes = array(
				'id' 	=> 'profile-save',
				'name' 	=> 'profile-save',		
			);
			echo form_open(site_url('setting/profile'), $attributes);
			$data = array(
				'type' 	=> 'text',
				'name'	=> 'first-name',
				'id' 	=> 'first-name',
				'value' => $userinfo->firstname,
				'style' => 'width: 300px;',
			);
			$data1 = array(
				'type' 	=> 'text',
				'name' 	=> 'last-name',
				'id' => 'last-name',
				'value' => $userinfo->lastname,
				'style' => 'width: 300px;',
			);
			$data2 = array(
				'type' 	=> 'password',
				'name' 	=> 'old-password',
				'id' 	=> 'old-password',
				'style' => 'width: 300px;',
			);
			$data3 = array(
				'type' 	=>	'password',
				'name' 	=> 	'new-password',
				'id'	=>	'new-password',
				'style'	=> 	'width: 300px;', 	
			);
			$data4 = array(
					'type' 	=>	'password',
					'name' 	=> 	'confirm-password',
					'id'	=>	'confirm-password',
					'style'	=> 	'width: 300px;',
			);
			//echo "<p>You can just change only the First name Or Last name by edit it and click button save.</p>";
			echo "<table id='tblsetting'>";
			echo "<tr><td colspan=2><span style='color: #528CC5; font-size: 14px;'>To change First name and Last name, please fill and then press save button.</span></td></tr>";
			echo "<tr><td>&nbsp;</td><td class='val-error'>" . validation_errors() . "</td></tr>";
			echo "<tr><td>".form_label('First Name', 'first-name')."</td>";
			echo "<td>".form_input($data)."</td></tr>";
			
			echo "<tr><td>".form_label('Last Name', 'last-name')."</td>";
			echo "<td>".form_input($data1)."</td></tr>";
			echo "<tr><td colspan=2 ><span style='color: #528CC5; font-size: 14px; line-height: 23px;'>-------------------------------------------------------------------------------------------------------------------
			If you want to change the password, please enter the old password(current password), enter the new password and enter the confirm password and then press the button save. We will send notification to your email after you change.</span></td></tr>";
			
			echo "<tr><td>".form_label('Old Password', 'old-password')."</td>";
			echo "<td>".form_input($data2)."</td></tr>";
			
			echo "<tr><td>".form_label('New Password', 'new-password')."</td>";
			echo "<td>".form_input($data3)."</td></tr>";
			
			echo "<tr><td>".form_label('Confirm Password', 'confirm-password')."</td>";
			echo "<td>".form_input($data4)."</td></tr>";
			
			echo "<tr><td>&nbsp;</td><td id='profile-button-save'><input type='image' value='' /></td></tr>";
			echo "</table>";
			echo form_close();
		?>
		
		<?php }
			else if($currentMethod=='email'){
				echo "<div class='email-content'>";
					$attributes = array(
						'id' 	=> 'email-save',
						'name' 	=> 'email-save',
					);
					echo form_open(site_url('setting/email'), $attributes);
					$data = array(
							'type' 	=> 'text',
							'name' 	=> 'email',
							'id' 	=> 'email',
							'value'	=> $email,
							'style' => 'width: 300px;',
					);
					echo "<table id='tblsetting'>";
					echo "<tr><td colspan=2><span style='color: #528CC5; font-size: 14px;line-height: 23px;'>Your current email is \"". $email ."\". We will send notification to your email after you change.</span></td></tr>";
					echo "<tr><td>&nbsp;</td><td class='val-error'>" . validation_errors() . "</td></tr>";
					echo "<tr><td>".form_label('Email', 'email')."</td>";
					echo "<td>".form_input($data)."</td></tr>";
					echo "<tr><td>&nbsp;</td><td id='email-button-save'><input type='image' value='' /></td></tr>";
					//echo "<tr><td>&nbsp;</td><td id='email-button-save'><a href='#'></a></td></tr>";
					echo "</table>";
					echo form_close();
				echo "</div>";
		?>
		<?php } ?>
	</div>
</div>