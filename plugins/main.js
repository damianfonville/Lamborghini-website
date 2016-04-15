		$(function(){
			$.stellar({
				horizontalScrolling: false,
				
			});
 
 var kkeys = [], konami = "38,38,40,40,37,39,37,39,66,65";
$(document).keydown(function(e) {
  kkeys.push( e.keyCode );
  if ( kkeys.toString().indexOf( konami ) >= 0 ){
  
$('<img/>', {
    id: 'lambo',
	src: '_img/lambo.png'
}).appendTo('body').animate({"bottom" : "0"} , 500, function(){
				$(this).animate({"left":"-600"},4000,"easeInCirc",function(){$(this).remove();});
				});
				
				
				
				kkeys = [38,38,40,40,37,39,37,39,66];
				
  }
});

$.fn.random = function()
{
    var ret = $();

    if(this.length > 0)
        ret = ret.add(this[Math.floor((Math.random() * this.length))]);

    return ret;
};

setInterval(function(){

$("header .active").removeClass("active");
$("header img").random().addClass("active");

},3000);

		});