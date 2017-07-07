/**
 * 重要的 JS
 *
 * Ding Chun
 * 2017.4.13
 * 
 */

$(function(){
    
    // 轮播
    var mySwiper = new Swiper('.swiper-container',{
        loop: true,
        // autoplay: 3000,
        pagination: '.swiper-pagination',
    });

    // 新增收货地址
    $('.add').click(function(){
        $('.newAddress').show();
    })
    $('.close, .newAddress .btn').click(function(){
        $(this).parents('.newAddress').hide();
    })
})