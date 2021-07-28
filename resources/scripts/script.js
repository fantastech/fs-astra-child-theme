// import './jquery.lightbox_me.min'; // Uncomment to include jquery.lightbox_me.min.js file.
(function($){

    // Helps equalizing height of elements
    function equalizeHeights(elements){
        elements.forEach(function(elem){
            var $element = $(elem);
            if($element.length > 0){
                var maxHeight = 0;
                $element.each(function() {
                    if ($(this).outerHeight() > maxHeight) {
                        maxHeight = $(this).outerHeight();
                    }
                }).height(maxHeight);
            }
        });
    }

    // Run code when docuemnt is ready
    $(document).ready(function(){

      // Equalize height of the following elements
      var equalizeHeightElements = [
          '.row-preset-some-class .post-title',
          '.row-preset-other-class .post-summary',
      ];
      equalizeHeights(equalizeHeightElements);

      // Your JS code here.

    });

})(jQuery);
