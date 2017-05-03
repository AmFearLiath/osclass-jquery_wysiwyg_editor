$(document).ready(function(){
    
    $(document).on("click", "ul.tabs li", function(){
        var tab_id = $(this).attr('data-tab');
        $('ul.tabs li').removeClass('current');
        $('.tab-content').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });
    
    $(document).on("click", "ul.subtabs li", function(){
        var tab_id = $(this).attr('data-tab');
        $('ul.subtabs li').removeClass('current');
        $('.subtab-content').removeClass('current');

        $(this).addClass('current');
        $("#"+tab_id).addClass('current');
    });
    
    $(document).on("click", "#jQWE_toggleHeight", function(){
        
        var normal  = $('#jQWE_heightNormal'),
            normalt = $('#height_deactivated'),
            slide   = $('#jQWE_heightSlide'),
            slidet   = $('#height_activated');
            
        if ($(this).is(":checked")) {
            normal.fadeOut("slow", function(){
                slide.fadeIn("slow");
            });
            normalt.fadeOut("slow", function(){
                slidet.fadeIn("slow");
            });    
        } else {
            slide.fadeOut("slow", function(){
                normal.fadeIn("slow");
            });
            slidet.fadeOut("slow", function(){
                normalt.fadeIn("slow");
            });    
        }
        
    });
    
    $(document).on("click", "#jQWE_allowHTML", function(){
        
        var activated     = $('#html_allowed'),
            deactivated   = $('#html_not_allowed');
            
        if ($(this).is(":checked")) {
            activated.fadeOut("slow", function(){
                deactivated.fadeIn("slow");
            });    
        } else {
            deactivated.fadeOut("slow", function(){
                activated.fadeIn("slow");
            });    
        }
        
    });
    
    $(document).on("mouseleave", ".tooltip", function() {
//        $(".tipso_bubble").hide();    
    });
    
    $(".tipso_bubble").remove();
    var tooltip = $(".tooltip").tipso({
        width: 300,
        maxWidth: 400,
        background: "#eeeeee",
        color: "#000000",
        titleBackground: "#3498db",
        titleColor: "#ffffff",
        showArrow: true,
        position: "top-right"
    });
    
});
