<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php session_start(); ?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8;"/>
<?php
$curl = "https://tw.rter.info/capi.php";
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $curl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$result = curl_exec($ch);				
$result = json_decode($result);
//print_r($result);
curl_close($ch);
?>
<script type="text/javascript">
function change_lang(b)
{   
   $('iframe.goog-te-menu-frame').contents().find('a').each(function () {
      var a = $(this);              
      if ($.trim(a.text()).indexOf(b) != -1)
      {a[0].click();}
   });
}  

function window_1()
{   
   // alert(1);
   var w = document.getElementById("window_1");
   if (w.style.display == "none") {
        w.style.display = "block";
    } else {
        w.style.display = "none";
    }
}

var lang_word;
var dollar_word;

function lang_dollar_1(a)
{   
   var a1 = document.getElementById("lang_1");
   var a2 = document.getElementById("lang_2");
   var a3 = document.getElementById("lang_3");
   var a4 = document.getElementById("lang_4");
   
   a1.style.backgroundColor="#663300";
   a2.style.backgroundColor="#663300";
   a3.style.backgroundColor="#663300";
   a4.style.backgroundColor="#663300";
   
   lang_word=a;
   if(a=="中文(繁體)")
   {a1.style.backgroundColor="#00FF00";}
   else if(a=="中文(簡體)")
   {a2.style.backgroundColor="#00FF00";}
   else if(a=="英文")
   {a3.style.backgroundColor="#00FF00";}
   else if(a=="日文")
   {a4.style.backgroundColor="#00FF00";}
} 

function lang_dollar_2(a)
{   
   var a1 = document.getElementById("dollar_1");
   var a2 = document.getElementById("dollar_2");
   var a3 = document.getElementById("dollar_3");
   var a4 = document.getElementById("dollar_4");
   
   a1.style.backgroundColor="#663300";
   a2.style.backgroundColor="#663300";
   a3.style.backgroundColor="#663300";
   a4.style.backgroundColor="#663300";
   
   dollar_word=a;
   if(a=="zh-TW")
   {a1.style.backgroundColor="#00FF00";}
   else if(a=="zh-CN")
   {a2.style.backgroundColor="#00FF00";}
   else if(a=="en")
   {a3.style.backgroundColor="#00FF00";}
   else if(a=="ja")
   {a4.style.backgroundColor="#00FF00";}
} 

function lang_dollar_3()
{
   var w = document.getElementById("window_1");
   var money_1 = 90;
   var money_2 = 150;
   var twd='<?php echo $result->USDTWD->Exrate;?>'
   var cny='<?php echo $result->USDCNY->Exrate;?>'
   var usd='<?php echo $result->USD->Exrate;?>'
   var jpy='<?php echo $result->USDJPY->Exrate;?>'
   var eur='<?php echo $result->USDEUR->Exrate;?>'
   var idr='<?php echo $result->USDIDR->Exrate;?>'
   var dollar=1;
   // alert(dollar_word);
  
   money_1=money_1/twd;
   money_2=money_2/twd;
   
   if(dollar_word=="zh-TW")
   {dollar=twd;}    
   else if(dollar_word=="zh-CN")
   {dollar=cny;}
   else if(dollar_word=="en")
   {dollar=usd;}
   else if(dollar_word=="ja")
   {dollar=jpy;}
   else if(dollar_word=="eur")
   {dollar=eur;}
   else if(dollar_word=="idr")
   {dollar=idr;}
   
   money_1=Math.round(money_1*dollar);
   money_2=Math.round(money_2*dollar);
   
   
   // w.style.display = "none";
   // document.getElementById("money_1").innerHTML = "佛"+money_1+"元";
   // document.getElementById("money_2").innerHTML = "故事"+money_2+"元";   
   change_lang(lang_word);
   
   // var form = document.getElementById("form");
   // with(form)
   // {
      $.ajax({
         type: "POST",
         url: "c_1.php",
         data: {dollar:dollar_word}
      });
   // }
   window.location.href="c.php?dollar="+dollar_word;

}
</script>
<link href="menu.css" rel="stylesheet"/>
<title>旅遊網</title>
</head>
<body style="margin:0;background-color:#ccffcc;">
    
<table border="0" width="100%" cellpadding="0" cellspacing="0">
   <tr>
      <td align="center" style="background-color:#663300">
         <div id="menu">
            <ul>
               <li style="width:200px;">
                  <a href="../buddha_1/buddha_1_west_1_1.php">水果</a>
                  <ul style="width:200px;">
	             <li style="width:200px;"><a href="../buddha_1/buddha_1_west_1_1.php">蘋果</a></li>
                     <li style="width:200px;"><a href="../buddha_1/buddha_1_west_2_1.php">香蕉</a></li>
                  </ul>
               </li>
               <li style="width:200px;">
                  <a href="#">語言</a>
                  <ul style="width:200px;">
	             <li style="width:200px;"><a onClick="change_lang('中文(繁體)')" href="#" style="width:200px;">中文(繁體)</a></li>
                     <li style="width:200px;"><a onClick="change_lang('中文(簡體)')" href="#" style="width:200px;">中文(簡體)</a></li>
                     <li style="width:200px;"><a onClick="change_lang('英文')" href="#" style="width:200px;">英文</a></li>
                     <li style="width:200px;"><a onClick="change_lang('日文')" href="#" style="width:200px;">日文</a></li>
                     <li style="width:200px;"><a onClick="change_lang('韓文')" href="#" style="width:200px;">韓文</a></li>
                     <li style="width:200px;"><a onClick="change_lang('瑞典文')" href="#" style="width:200px;">瑞典文</a></li>
                  </ul>
               </li>  
               <li style="width:200px;">
                  <a href="#">貨幣</a>
                  <ul style="width:200px;">
	  <li style="width:200px;"><a href="c.php?dollar=zh-TW">台幣</a></li>
                     <li style="width:200px;"><a href="c.php?dollar=zh-CN">人民幣</a></li>
                     <li style="width:200px;"><a href="c.php?dollar=en">美幣</a></li>
                     <li style="width:200px;"><a href="c.php?dollar=ja">日幣</a></li>
                     <li style="width:200px;"><a href="c.php?dollar=eur">歐元</a></li>
                     <li style="width:200px;"><a href="c.php?dollar=idr">印尼盾</a></li>
                  </ul>
               </li>
               <li style="width:200px;">
                  <a href="#" onclick="window_1()">視窗</a>                  
               </li> 
            </ul> 
         </div>
      </td>
   </tr> 
</table> 
    
<style>    
.goog-te-banner-frame.skiptranslate {
 display: none!important;
} 
body { top: 0px!important; }
.goog-tooltip {
 display: none!important;
}
.goog-tooltip:hover {
 display: none!important;
}
.goog-text-highlight {
 background-color: transparent!important;
 border: none!important; 
 box-shadow: none!important;
}
</style>  
    
<form class="form-horizontal" name="form" id="form" method="post" action="relation_user_1.php" style="margin:0;">

<script src="element.js?cb=googleTranslateElementInit"></script> 
<div id="google_translate_element" style="visibility:hidden;height:0px"></div>

<script>
    function googleTranslateElementInit() {
        new google.translate.TranslateElement({
		    layout: google.translate.TranslateElement.InlineLayout.HORIZONTAL
        }, 'google_translate_element');
    }
    googleTranslateElementInit()
</script>
<script type="text/javascript" src="jquery-1.4.2.min.js"></script>
<?php
$money_1=90;
$money_2=150;
$money_1=$money_1/($result->USDTWD->Exrate);
$money_2=$money_2/($result->USDTWD->Exrate);

$dollar="zh-TW";
if(isset($_GET['dollar']) and !empty($_GET['dollar']))
{
   $_SESSION['dollar']=($_GET['dollar'])?"zh-TW":$_GET['dollar'];  
   $dollar=$_GET['dollar'];
}

if($dollar=="zh-TW" or $dollar==null)
{$dollar=$result->USDTWD->Exrate;} 
else if($dollar=="zh-CN")
{$dollar=$result->USDCNY->Exrate;}
else if($dollar=="en")
{$dollar=$result->USD->Exrate;}
else if($dollar=="ja")
{$dollar=$result->USDJPY->Exrate;}
else if($dollar=="eur")
{$dollar=$result->USDEUR->Exrate;}
else if($dollar=="idr")
{$dollar=$result->USDIDR->Exrate;}

$money_1=$money_1*$dollar;
$money_2=$money_2*$dollar;

echo "佛".round($money_1)."元<br/>";
echo "故事".round($money_2)."元<br/>";
?>
<div id="money_1"></div>
<div id="money_2"></div>
 
 
<div id="window_1" style="text-align: center;width:100%;display:none;">
<table border="0" cellpadding="0" cellspacing="0" style="background-color:#663300" align="center">
   <tr align="center">
      <td width="200" id="lang_1"><a onClick="lang_dollar_1('中文(繁體)')" href="#" style="color:#ffffff">中文(繁體)</a></td>
      <td width="200" id="lang_2"><a onClick="lang_dollar_1('中文(簡體)')" href="#" style="color:#ffffff">中文(簡體)</a></td>
      <td width="200" id="lang_3"><a onClick="lang_dollar_1('英文')" href="#" style="color:#ffffff">英文</a></td>
      <td width="200" id="lang_4"><a onClick="lang_dollar_1('日文')" href="#" style="color:#ffffff">日文</a></td>
   </tr>  
   <tr align="center">
      <td width="200" id="dollar_1"><a onClick="lang_dollar_2('zh-TW')" href="#" style="color:#ffffff">台幣</a></td>   
      <td width="200" id="dollar_2"><a onClick="lang_dollar_2('zh-CN')" href="#" style="color:#ffffff">人民幣</a></td>
      <td width="200" id="dollar_3"><a onClick="lang_dollar_2('en')" href="#" style="color:#ffffff">美幣</a></td>
      <td width="200" id="dollar_4"><a onClick="lang_dollar_2('ja')" href="#" style="color:#ffffff">日幣</a></td>
   </tr>
   <tr align="center">
      <td colspan="4"><a onClick="lang_dollar_3()" href="#" style="color:#ffffff">確定</a></td>
   </tr> 
</table> 
</div>   
</form>    
</body>
</html>
