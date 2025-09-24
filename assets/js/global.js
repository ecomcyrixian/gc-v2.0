jQuery(document).ready(function($) {
  
    /* on scroll */
    var topOfOthDiv = $('#header-cont').offset().top;
    $(window).scroll(function() {
        if($(window).scrollTop() > topOfOthDiv) { 
            console.log('true');
            $('#header-cont').addClass('scroll');
        } else {
            console.log('false');
            $('#header-cont').removeClass('scroll');
        }
    });
       
    // click event for hamburger menu
    function debounce(func, delay) {
        let timeout;
        return function(...args) {
            const context = this;
            clearTimeout(timeout);
            timeout = setTimeout(() => func.apply(context, args), delay);
        };
    }
    const myDebouncedFunction = debounce(() => {
        jQuery('#header-cont').toggleClass('active');
        //jQuery('#mobile-nav').toggleClass('active');

        $("#mobile-nav").slideToggle("fast");
        
      
    }, 300); // Adjust delay as needed
    document.getElementById('mobile-menu').addEventListener('click', myDebouncedFunction);

});


      
    