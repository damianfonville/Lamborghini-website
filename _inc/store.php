<h1>Store</h1>
<script>
$(document).ready(function(){
if(window.location.hash) {

var hash = window.location.hash.substring(1);
$(".zoek").val(hash);
$.ajax({url:"storezoek.php?q="+hash,success:function(result){
    $(".artikelen").html(result);
	artikelen = result;
  }});
}
var artikelen = $(".artikelen").html();
$(".zoek").keyup(function(){
$(".artikelen").html(artikelen+"<div style=\"position:absolute;top:0;left:0;right:0;bottom:0;background:rgba(0,0,0,0.7)\"><center><br/><br/><br/><img width=\"50px;\" src=\"_img/load.gif\"></center></div>");

  var q = $(this).val();
  window.location.hash = q;
$.ajax({url:"storezoek.php?q="+q,success:function(result){
    $(".artikelen").html(result);
	artikelen = result;
  }});
  
}); 

});
</script>
Zoeken: <input type="text" class="zoek" />
<br />
<br />
<div class="artikelen">
<?php include("storezoek.php"); ?>
</div>