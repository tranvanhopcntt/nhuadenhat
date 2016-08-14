<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style type="text/css">
	body { margin:0; font-family:tahoma, Helvetica, sans-serif; background:url(images/thead.gif) repeat-x top left #E6EAEE;}
	
	table.exchange-rate { border-collapse:collapse; font-size:10px; border:1px solid #ccc}
	table.exchange-rate thead{}
	table.exchange-rate thead th{font-size:11px; font-weight:bold; color:#910C1C;}
	table.exchange-rate tbody td{font:10px Tahoma; border:1px solid #ccc; color:#008C4F;}
	table.exchange-rate tbody .mod td{color:#910C1C;}
	.exchange-rate-head{font-size:10px; color:#999; float:right; padding:3px 5px 2px 0; font-style:italic;}
	.vietcombank{color:#008C4F; font-size:11px; float:left; padding:2px 0 2px 2px; font-weight:bold;}
	.clr{clear:both;}
	
    </style>
</head>
<body>
<div class="vietcombank">Vietcombank</div>
<div class="exchange-rate-head">

<?php
    ini_set("display_errors", 1);
    $data=file_get_contents("http://www.vietcombank.com.vn/ExchangeRates/ExrateXML.aspx");
    $p = xml_parser_create();
    xml_parse_into_struct($p,$data , $xmlData);
    xml_parser_free($p);
    print $xmlData[1]['value']."<br>";
?>
 </div>
 <div class="clr"></div>
<table width="100%" class="exchange-rate" border="1" cellpadding="1" cellspacing="0">
    <thead>
    <tr bgcolor="#ECECEC">
        <th width="50%" align="center"><strong>Mã</strong></th>
        <th align="center"><strong>Tỷ giá</strong></th>
    </tr>
</thead>
<tbody>
<?php
$check=1;
for($i = 0; $i<= count($xmlData); $i++)
{
    if($xmlData[$i]['attributes']['CURRENCYCODE'] != "")
    {
?>
    <tr class="<?php if(($check%2)==0){ echo "mod";} $check++; ?>">
        <td align="center"><?php echo $xmlData[$i]['attributes']['CURRENCYCODE']; ?></td>
        <td align="right"><?php echo $xmlData[$i]['attributes']['SELL']?></td>
    </tr>
    
<?php }

} ?>
</tbody>
</table>

<!--
<p style="background: #c0c0c0">
<marquee onMouseOver="this.setAttribute('scrollamount', 0, 0);" onMouseOut="this.setAttribute('scrollamount', 6, 0);">
<?php
for($i = 0; $i<= count($xmlData); $i++)
{
    if($xmlData[$i]['attributes']['CURRENCYCODE'] != "")
    {
        echo "<b>" . $xmlData[$i]['attributes']['CURRENCYCODE'] . ": </b>" ;
        echo "<span style= 'color: blue'>" . "Mua: " . $xmlData[$i]['attributes']['BUY'] . "  </span>" ;
        echo "<span style= 'color: red'>" . " - Bán: " . $xmlData[$i]['attributes']['SELL'] . " </span>";
        echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
    }
}
?>
</marquee>
</p>-->
</body>
</hltm>