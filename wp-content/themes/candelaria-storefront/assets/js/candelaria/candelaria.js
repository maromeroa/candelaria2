(function($){
  $("#submenu-mobile-version").click(function(event){
    if($("#mobile-version-sidemenu").attr("show")!='true'){
      $("#mobile-version-sidemenu").slideDown();
      $("#mobile-version-sidemenu").attr("show",'true')
    }
    else{
      $("#mobile-version-sidemenu").slideUp();
      $("#mobile-version-sidemenu").attr("show",'false')
    }

    event.preventDefault();
  })
})(jQuery)
