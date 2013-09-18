<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <title>Email Register Validation</title>
</head>
<body bgcolor="#f0f0f0">
	<table border="0" width="100%" cellpadding="0" cellspacing="0" bgcolor="#f0f0f0">
		<tbody>
			<tr>
				<td align="center">
					<table border="0" width="520" cellpadding="40" cellspacing="0" bgcolor="#ffffff">
						<tbody>
							<!--HEADER-->
							<tr>
								<td align="center">
									<table border="0" width="100%" cellpadding="20" cellspacing="0" bgcolor="#ffffff">
										<tbody>
											<tr>
												<td align="center">
													<a href="http://www.impossible.com" style="text-decoration:none;border: none;"><img src="<?php echo base_url()?>assets/admin/images/logo_mail.png" alt="impossible" style="text-decoration:none;border:none;"></a>
												</td>
											</tr>
										</tbody>
									</table>

								</td>
							</tr>
							<tr>
								<td><img src="<?php echo base_url()?>assets/admin/images/fillet.png" width="420" height="1"></td>
							</tr>
							<!--end HEADER-->

							<tr>
								<td align="left">
									<!--CONTENT-->
                                    <?php if($deactivated !== TRUE) { ?> 
									<p style="line-height: 24px;"><font face="Arial" size="3" color="#999999">Welcome,</font></p><br/>
									<p style="line-height: 24px;"><font face="Arial" size="3" color="#999999">You've just joined the <a href="http://www.impossible.com" style="color:#999999;"><?=ucfirst(strtolower(WEBSITE_NAME))?></a> world.</font></p>
									<p style="line-height: 24px;"><font face="Arial" size="3" color="#999999">We'll just need you to activate your account before we get started.</font></p>
                                    <? } else {?>
                                    <p style="line-height: 24px;"><font face="Arial" size="3" color="#999999">Your account has been deactivated, please validate your email. </font></p>
                                    <? } ?>
                                    <br/>
									<a href="<?=site_url('api/users/ValidateUser/'.$email_activation_code."/". $user);?>" style="text-decoration:none; background-color:#f0644b; color:#ffffff; padding:8px;"><font face="Arial" size="3" color="#ffffff">&nbsp; Activate your account &nbsp;</font></a>
                                    
									<!--end CONTENT-->
									<br/><br/><br/>
									<!--SIGNATURE-->
									<p><font face="Arial" size="3" color="#999999">Thank you,</font><br/>
									<p><font face="Arial" size="2" color="#999999"><i>- the impossible team</i></font></p>
									<!--end SIGNATURE-->
								</td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			
			<!--FOOTER-->
			<tr>
				<td align="center">
					<table border="0" width="520" cellpadding="40" cellspacing="0">
						<tbody>
							<tr>
								<td><font face="Arial" size="1" color="#999999">find us at <a href="http://www.impossible.com" style="color:#999999;">impossible.com</a> | &copy; impossible <?php echo date("Y"); ?></font></td>
								<td><a href="#" style="text-decoration:none;border:none;"><img style="text-decoration:none;border:none;" src="<?php echo base_url()?>assets/admin/images/appstore.png" alt="app store"></a></td>
							</tr>
						</tbody>
					</table>
				</td>
			</tr>
			<!--end FOOTER-->
			
		</tbody>
	</table>

    </body>
</html>