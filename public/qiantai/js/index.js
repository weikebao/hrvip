$(function(){
//	二级显示
	$(".list_2").children("a").mouseenter(function(){
		$("#list2").fadeIn();
	});
	$(".list_2").mouseleave(function(){
		$("#list2").stop().hide();
	});
//	三级显示类
//	$(".xt1").mouseenter(function(){
//		$(this).siblings().find(".list3").hide();
//		$(this).find(".list3").show();
//	});
//	三级显示
	$(".xt1").children("a").mouseenter(function(){
		$(this).parent().siblings().find(".list3").hide();
		$(this).next().show();
	});
	$(".xt1").mouseleave(function(){
		$(".list3").stop().hide();
	});
	
	
//	底部二维码
	$(".second").mouseenter(function(){
		$(this).find(".code").stop().fadeTo(300,1);
		$(this).find("dl").stop().fadeTo(300,0);
	}).mouseleave(function(){
		$(this).find("dl").stop().fadeTo(300,1);
		$(".code").stop().fadeTo(300,0);
	});
	
//图片轮播
    	var $timer;
        var $index = 0;
        //自动轮播
        $timer = setInterval(fade, 2000);

        function fade(){
            $index++;
            if ($index == 3) {
                $index = 0;
            }
            $('.banner_main>li').eq($index).stop().fadeIn(300).siblings('li').stop().fadeOut(300);
            $('.box_btn>li').eq($index).stop().fadeTo(300, 0.8).siblings('li').stop().fadeTo(300, 0.3);
        }
        //焦点切换
        $('.box_btn>li:first').css('opacity', '0.8');
        $('.box_btn>li').mouseover(function () {
            $index = $(this).index();
            $(this).stop().fadeTo(300, 0.8).siblings('li').stop().fadeTo(300, 0.3);
            $('.banner_main>li').eq($(this).index()).stop().fadeIn(300).siblings('li').stop().fadeOut(300);
        })

        $('#banner').hover(function () {
            clearInterval($timer);
            $('#prev,#next').stop().fadeIn(200);

        }, function () {
            $('#prev,#next').stop().fadeOut(200);
            $timer = setInterval(fade, 2000);
        })
        
        //左右切换
        $('#prev').click(function () {
            $index--;
            if($index==-1){
                $index=2;
            }
            $('.banner_main>li').eq($index).stop().fadeIn(300).siblings('li').stop().fadeOut(300);
            $('.box_btn>li').eq($index).stop().fadeTo(300, 0.8).siblings('li').stop().fadeTo(300, 0.3);
        })
        $('#next').click(function () {
            $index++;
            if($index==3){
                $index=0;
            }
            $('.banner_main>li').eq($index).stop().fadeIn(300).siblings('li').stop().fadeOut(300);
            $('.box_btn>li').eq($index).stop().fadeTo(300, 0.8).siblings('li').stop().fadeTo(300, 0.3);
        })
//返回顶部
    $(window).scroll(function () {
		var scrollTop = $(this).scrollTop();
	    if (scrollTop > 600) {
	        $(".back").show();
	    }else{
	    	$(".back").hide();
	    };
	});
	$('.back').click(function () {
	    $('html,body').stop().animate({
	        scrollTop: 0
	    }, 500)
	});
//鼠标经过放大1
    $(".big").each(function(){
    	$(this).hover(function(){
	        $(this).stop().animate({
	            width:308*1.2,
	            height:203*1.2,
	            left:-308/10,
	            top:-203/10
	            //left:img.offset().left/2+"px",
	            //top:img.offset().top/2+"px"
	        });
	    },function(){
	    	$(this).stop().animate({
	            width:308,
	            height:203,
	            left:0,
	            top:0
	            //left:img.offset().left/2+"px",
	            //top:img.offset().top/2+"px"
	        });
	    });
    });
//鼠标经过放大2
    $(".big1").each(function(){
    	$(this).hover(function(){
	        $(this).stop().animate({
	            width:324*1.2,
	            height:272*1.2,
	            left:-324/10,
	            top:-272/10
	            //left:img.offset().left/2+"px",
	            //top:img.offset().top/2+"px"
	        });
	    },function(){
	    	$(this).stop().animate({
	            width:324,
	            height:272,
	            left:0,
	            top:0
	            //left:img.offset().left/2+"px",
	            //top:img.offset().top/2+"px"
	        });
	    });
    });
//鼠标经过图片变暗
	$(".model_img").mouseover(function(){
		$(this).next().show();
	})
	$(".model").mouseout(function(){
		$(this).hide();
	});
});
