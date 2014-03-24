$(".footer, .push").height($(".footer").height()+"px");
$(".wrapper").css({'margin-bottom':(-1*$(".footer").height())+"px"});
window.onresize = function(){
    $(".footer, .push").height($(".footer").height()+"px");
    $(".wrapper").css({'margin-bottom':(-1*$(".footer").height())+"px"});
}