
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd"> 
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
	<title>Fontagro</title>
	
</head>
<body>
<style type="text/css">
		body { width: 100% !important; background-color: #cecfd1;}
		/* Based on The MailChimp Reset INLINE: Yes. */  
		/* Client-specific Styles */
		#outlook a {padding:0;} /* Force Outlook to provide a "view in browser" menu link. */
		body{width:100% !important; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%; margin:0; padding:0;} 
		/* Prevent Webkit and Windows Mobile platforms from changing default font sizes.*/ 
		.ExternalClass {width:100%;} /* Force Hotmail to display emails at full width */  
		.ExternalClass, .ExternalClass p, .ExternalClass span, .ExternalClass font, .ExternalClass td, .ExternalClass div {line-height: 100%;}
		/* Forces Hotmail to display normal line spacing. */ 
		#backgroundTable {margin:0; padding:0; width:100% !important; line-height: 100% !important;}
		/* End reset */

		table{
			table-layout: fixed;
			}
		img {outline:none; text-decoration:none; -ms-interpolation-mode: bicubic;} 
		a img {border:none;} 
		.image_fix {display:block;}
		img.full {width:100% !important; height:auto !important;}
		img.responsive {max-width:100% !important; height:auto !important; width:auto; margin:0 auto;}
		/* Yahoo paragraph fix
		Bring inline: Yes. */
		p {margin: 0;}
		.column{
			width:50% !important;}
		a, a:visited, a:link, a:active, a[href]{
			color:#66cdcc;
			text-decoration:none;
			}
		a:hover, a[href]:hover{
			color:#08436b;
			text-decoration:underline;
			}
		a.white, a.white:visited, a.white:link, a.white:active, a.white[href], .footerbrc a, .footerbrc a:link, .footerbrc a:visited, .footerbrc a:active, .footerbrc a[href]{
			color:#fefffa !important;
			text-decoration:none;
			}
		a.white strong, .footerbrc a strong{
			color:#fefffa !important;
			}
		a.white:hover, .footerbrc a:hover, .footerbrc a[href]:hover{
			color:#fefffa !important;
			text-decoration:underline;
			}
		a.action, a.action:visited, a.action:link, a.action:active, a.action[href]{
			background-color:#66cdcc  !important; 
			color:#fefffa !important; 
			font-size:14px; 
			text-transform:uppercase; padding: 20px 25px; 
			display:inline-block; 
			text-decoration: none;
			}
		a.action:hover{
			background-color:#08436b !important; 
			}
		/* Hotmail header color reset
		Bring inline: Yes. */
		h1, h2, h3, h4, h5, h6 {color: #08436b !important;}


		/***************************************************
		****************************************************
		MOBILE TARGETING
		****************************************************
		***************************************************/
		@media (min-width: 481px) {
				.fulltable{
					max-width:600px;
					width:100%;
					}
				.column{
					width:50% !important;
				}
			}
		@media (max-width: 599px) {
			.fulltable{
				width:100% !important;
				}
				img{
					padding: 0px 0 !important;
					}
		}
		@media (max-width: 420px) {
			body{width:100% !important; min-width:100% !important;}
			table[id="emailContainer"]{width:100% !important; max-width:420px !important;}
		}
	</style>
<table width="100%" border="0" cellpadding="0" cellspacing="0" id="backgroundTable" style="table-layout: fixed;">
	<tr>
		<td valign="top" bgcolor="#cecfd1"> 
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="font-family:Arial, Helvetica, sans-serif; font-size:14px; max-width:600px !important; margin:0 auto;" id="emailContainer" class="fulltable">
			<tr>
				<td height="30" valign="top">&nbsp;</td>
			</tr>
			<tr>
			  <td valign="top" bgcolor="#ffffff"><table width="100%" border="0" cellspacing="0" cellpadding="0">

			      <tr>
			        <td colspan="3"><table width="100%" border="0" cellspacing="15" cellpadding="0">
			        
			            <tr>
			              <td width="30">&nbsp;</td>
			              <td align="center"><a href="https://www.fontagro.org" target="_blank"><img src="https://www.fontagro.org/wp-content/themes/fontagro/_/img/logo.png" alt="Fontagro" width="105" height="115" title="Fontagro" style="display:inline-block; border:0; vertical-align:top;"/></a></td>
			              <td width="30" align="center">&nbsp;</td>
			            </tr>
			         
			        </table>
			          </td>
		          </tr>
		        
		      </table></td>
		  </tr>
			
			
			<tr>
			  <td valign="top" bgcolor="#ecf0f1">
              
              <table width="100%" border="0" align="left" cellpadding="0" cellspacing="0"  style="min-width: 200px !important;">
			    <tr>
			      <td bgcolor="#fff" style="color:#5c7376; line-height:22px; font-size:14px; font-family:Arial, Helvetica, sans-serif;  border-bottom:1px dashed #f5f7f7;">
                  <table width="100%" border="0" cellspacing="0" cellpadding="30">
                  
                      <tr>
                        <td align="center" style="color:#5c7376; line-height:22px; font-size:14px; font-family:Arial, Helvetica, sans-serif; text-align:center" >
							<?if(!empty($titulo_cuerpo)):?>
							<h2 style="color:#08436b; line-height:28px; font-size:28px; font-family:Arial, Helvetica, sans-serif; text-align:center; margin:20px 0 10px; padding:0;">
								<?=$titulo_cuerpo?>
							</h2>
							<?endif?>
							<p <?=empty($titulo_cuerpo)? 'style="text-align:left"':''?> >
								<strong><?=$subtitulo?> </strong>
								<br><br>
								<?=$contenido?> 
								<br>	
							</p>
							<br /><br />
							<?if(!empty($url)):?>
							<a href="<?=$url?>" class="action" style="background-color:#66cdcc; color:#fefffa; font-size:14px; text-transform:uppercase; padding: 10px 25px; display:inline-block; text-decoration: none; ">
								<strong style="color:#fefffa !important;"><?=$url_accion?></strong>
							</a>
							<?endif?>
							<?if(!empty($url_aclaracion)):?>
							<p class="small" ><br /><?=$url_aclaracion?>: <br/><span style="font-size:9px"><?=$url?></span></p>
							<?endif?>
                        </td>
                    </tr>
                      <tr>
                        <td align="center" bgcolor="#eeeeee" style="color:#5c7376; line-height:22px; font-size:14px; font-family:Arial, Helvetica, sans-serif; text-align:center" >
                        	<p><strong>FONTAGRO</strong><br>
								1300 New York Avenue NW, Stop W0502 Washington, DC 20577
							</p>
                        </td>
                    </tr>
     		      </table></td>
		        </tr>
		      </table>
              </td>
		  </tr>
			<tr>
			  <td valign="top" bgcolor="#08436b"><table width="100%" border="0" cellspacing="0" cellpadding="0">
			    <tr>
			      <td align="center">
		            <table width="100%" border="0" cellspacing="0" cellpadding="0">
		              <tr>
		                <td align="center"><table width="100%" border="0" cellspacing="0" cellpadding="0">
		                  <tr>
		                    <td height="48" align="center" bgcolor="#dddddd" style="color:#fefffa; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:0px; padding:0;">
								<a href="https://www.youtube.com/user/fontagro" target="_blank"><img src="http://fontagro.org/mail/youtube.png" width="47" height="48" alt="" style="display:inline-block; border:0; vertical-align:top;"/></a>
								<a href="https://www.linkedin.com/company/fontagro/" target="_blank"><img src="http://fontagro.org/mail/linkedin.png" width="47" height="48" alt="" style="display:inline-block; border:0; vertical-align:top;"/></a>
								<a href="https://twitter.com/fontagrodigital" target="_blank"><img src="http://fontagro.org/mail/twitter.png" width="47" height="48" alt="" style="display:inline-block; border:0; vertical-align:top;"/></a>
								<!--<a href="https://vimeo.com/user44891219" target="_blank"><img src="http://fontagro.org/mail/vimeo.png" width="47" height="48" alt="" style="display:inline-block; border:0; vertical-align:top;"/></a>-->
							</td>
	                      </tr>
		                  <tr>
		                    <td class="footerbrc" height="80" align="center" valign="middle" style="color:#fefffa; font-family:Arial, Helvetica, sans-serif; font-size:12px; line-height:0px; padding:22;">
								<a href="http://www.fontagro.org" target="_blank" class="white" style="color:#fefffa !important;"><strong style="font-weight:normal; color:#fefffa !important;">www.fontagro.org</strong></a> - 
								<a href="mailto:fontagro@iadb.org" target="_blank" class="white" style="color:#fefffa !important;"><strong style="font-weight:normal; color:#fefffa !important;">fontagro@iadb.org</strong></a>
							
							</td>
	                      </tr>
	                    </table></td>
	                  </tr>
	                </table></td>
		        </tr>
		      </table></td>
		  </tr>
			<tr>
			  <td height="30" align="center" valign="top">&nbsp;</td>
		  </tr>
			
		</table>
		</td>
  </tr>
</table>  

</body>
</html>