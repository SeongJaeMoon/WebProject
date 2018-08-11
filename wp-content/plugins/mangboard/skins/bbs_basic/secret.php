<div class="secret-style1">
	<div class="secret radius-4">
		<div class="secret-title">
			<?php
				if(mbw_get_param("secret_passwd")=="") $message		= __MM("MSG_SECRET")."<br>".__MM("MSG_PASSWD_INPUT");
				else $message		= __MM("MSG_MATCH_ERROR", "W_PASSWORD");
				echo $message;
			?>
		</div>

		<form class="secret-form" action="<?php echo mbw_get_url()?>" method="POST" id="secret_form">
			<div><input name='secret_passwd' type="password"/></div>
		</form>

		<div class="btn-box-center">
			<?php 
				echo mbw_get_btn_template(array("name"=>"Cancel","href"=>mbw_get_url(array("board_pid"=>"","mode"=>"list")),"class"=>"btn btn-default margin-right-10")); 
				echo mbw_get_btn_template(array("name"=>"OK","onclick"=>"javascript:document.getElementById('secret_form').submit();","class"=>"btn btn-default"));
			?>
		</div>
	</div>
</div>