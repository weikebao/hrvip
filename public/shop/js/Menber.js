$(document).ready(function(){
	$(".menmberConleftText1Li-i").click(function(){
		var show = $(this).parent(".menmberConleftText1Li-show").siblings(".menmberConleftText1LiHide");
		show.fadeToggle(1000);
	})
	$(".taiyangbi-duihuan").click(function(){
		$(".taiyangbi-duihuangcg").show();
	})
	$(".taiyangbi-duihuangcg").click(function(){
		$(this).hide();
	})
	$(".tybsearch").click(function(){
	$(".searchfangdaBox").fadeToggle(1000);
	})
});