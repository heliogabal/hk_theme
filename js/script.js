/**
 * @file
 * A JavaScript file for the theme.
 *
 * In order for this JavaScript to be loaded on pages, see the instructions in
 * the README.txt next to this file.
 */


// JavaScript should be made compatible with libraries other than jQuery by
// wrapping it with an "anonymous closure". See:
// - http://drupal.org/node/1446420
// - http://www.adequatelygood.com/2010/3/JavaScript-Module-Pattern-In-Depth
(function ($, Drupal, window, document, undefined) {

// (function ($) {
//   Drupal.behaviors.BearScripts = {
//     attach: function (context, settings) {

      //$('#content select.form-select').select2();
      //$(":file").filestyle({buttonText: "Find file"});
      // if ($('#navigation .block-menu').length) {
      //   $('#navigation .block-menu').prepend('<input type="checkbox" id="button"><label for="button" onclick>Menu</label>');
      // }
      // if ($('#navigation .menu-block-wrapper').length) {
      //   $('#navigation .menu-block-wrapper').prepend('<input type="checkbox" id="button"><label for="button" onclick>Menu</label>');
      // }




      //$('.equalheight').eqHeight();

//     }
//   }
// }(jQuery));

(function ($) {
  Drupal.behaviors.ResponsiveScripts = {
    attach: function (context, settings) {

      $('.cm-row, .column').selectorQuery({
        'widthStops': [340, 680],
        'classPrefix': 'max-'
      });

    }
  }
}(jQuery));

 (function($) {
     Drupal.behaviors.leafletMap = {
         attach: function(context, settings) {
//    /* RH Kartensuche */
      // $('.view-karten', context).once(function(){
      //   $( ".front #views-exposed-form-karten-map-page" ).dialog({
      //       height: "auto",
      //       width: "600",
      //       resizable: "false",
      //       closeOnEscape: "true",
      //       hide: { effect: "explode", duration: "1000" },
      //       position: { my: "center bottom", at: "center bottom", offset: "-170 -100", collision: "fit flip", of: ".view-karten" }
      //     });
      //   });

//         $( 'a[href="/kaufen"]' ).click(function(e) {
//                   $( ".front #views-exposed-form-karte-block" ).dialog( "open" );
//                   e.preventDefault();
//                 });
         $( 'a[title="Suchen"]').click(function(e) {
                   $( "#block-views-exp-karten-map_page,#block-views-exp-karten-kaufen,#block-views-exp-karten-mieten" ).toggle();
                   e.preventDefault();
                 });

               }
     }

 })(jQuery);
/*(function ($) {
  Drupal.behaviors.leafletZoomTo = {
    attach: function (context, settings) {
      $(document).bind('leaflet.feature', function(e, lFeature, feature) {
        lFeature.on('click', function(e) {
          var lMap = Drupal.settings.leaflet[0].lMap;
          lMap.setView(e.latlng,16);
        })
      });

    }
  }
})(jQuery);*/
(function ($) {
  Drupal.behaviors.ServiceMenu = {
    attach: function (context, settings) {

    $('a.menu__link[title="+49 30 780 870 80"]').tooltip();
    }
  }
})(jQuery);

})(jQuery, Drupal, this, this.document);
