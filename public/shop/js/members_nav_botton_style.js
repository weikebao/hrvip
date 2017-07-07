$('.header li,.m_left li').each(function(){
    if(($(this).find('a').attr('href'))==window.location.pathname){
        $(this).addClass('ac');
        // alert($(this).find('a').attr('href'));
    }
    // alert($(this).find('a').attr('href'));
    // alert(window.location.pathname);
}); 