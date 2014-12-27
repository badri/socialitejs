(function ($) {
"use strict";

Drupal.behaviors.socialitejs = {
  attach: function(context, settings) {
  if (settings.socialitejs.loading == 'hover'){
    $('.socialitejs').one('mouseenter', function() {
      Socialite.load($('.socialitejs').get());
    });
  }
  else {
    Socialite.load($('.socialitejs').get());
  }	
 }
};

})(jQuery);
