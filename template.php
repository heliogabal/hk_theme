<?php
drupal_add_library('system','ui.dialog');
drupal_add_library('system', 'ui.tooltip');
/**
 * Implements template_preprocess_html().
 * Adds path variables.
 */
function hk_theme_preprocess_html(&$variables, $hook) {
  // Add variables and paths needed for HTML5 and responsive support.
  $variables['base_path'] = base_path();
  $variables['path_to_bear_skin'] = drupal_get_path('theme', 'hk_theme');
}

/**
 * Implements theme_links().
 * Enables sub-menu item display for main menu.
 */
function hk_theme_links($variables) {
  if (array_key_exists('id', $variables['attributes']) && $variables['attributes']['id'] == 'block-system-main-menu') {
    $pid = variable_get('menu_main_links_source', 'block-system-main-menu');
    $tree = menu_tree($pid);
    return drupal_render($tree);
  }
  return theme_links($variables);
}

/**
 * Implements template_preprocess_page().
 */
function hk_theme_preprocess_page(&$vars) {
  // $vars['user_menu'] =  theme('links', array('links' => menu_navigation_links('user-menu'), 'attributes' => array('class '=> array('links', 'site-menu'))));

  // Extra Template für Colorbox Load
  if (isset ($_GET['template']) && $_GET['template'] == 'colorbox') {
      $vars['theme_hook_suggestions'][] = 'page__colorbox';
      module_invoke('admin_menu_suppress(TRUE)');
  }
  // redirect to the buy page set for mobile devices, as the map does not work well for them.
  if (module_exists('mobile_detect')) {
    $detect = mobile_detect_get_object();
    $is_mobile = $detect->isMobile();
    $is_tablet = $detect->isTablet();
    if (drupal_is_front_page()) {
      //$GLOBALS['conf']['cache'] = FALSE;
      if ($is_mobile) {
        $redirect = '/buy';
        drupal_goto($redirect);
      }
    }
  }

}

/**
* Load modified markercluster js
*/

function hk_theme_js_alter (&$javascript) {
  $javascript[libraries_get_path('leaflet_markercluster') . '/dist/leaflet.markercluster.js']['data'] = drupal_get_path('theme',$GLOBALS['theme']) . '/js/leaflet.markercluster.js';
}

// Hide active language in language switcher block
function hk_theme_links__locale_block($variables) {
  global $language;
  unset($variables['links'][$language->language]);
  return theme('links', $variables);
}

// Set exposed filter labels as translatable -any- option because better exposed filter is not i18n
// function hk_theme_form_views_exposed_form_alter(&$form, &$form_state, $form_id) {
//   if ($form_id == 'views_exposed_form' && $form_state['view']->name == 'karten') {
//     $form['bezirk']['#options']['All'] = t('borough');
//     $form['preis']['#options']['All'] = t('price');
//     $form['preis_group']['#options']['All'] = t('price');
//     $form['zimmer']['#options']['All'] = t('rooms');
//     $form['kategorie']['#options']['All'] = t('buy');
//     $form['flaeche']['#options']['All'] = t('surface area');
//     // and so on.
//   }
// }

/**
 * Implements hook_ctools_plugin_post_alter().
 */
// function hk_theme_ctools_plugin_post_alter(&$plugin, &$info) {
//   // Workaround to render facet blocks last, this actually sets all block
//   // to render last.
//   if ('content_types' == $plugin['plugin type'] && 'block' == $plugin['name']) {
//     $plugin['render last'] = TRUE;
//   }
// }

/**
 * Implements template_preprocess_views_view_unformatted().
 */
function hk_theme_preprocess_views_view_unformatted(&$vars) {
  $view = $vars['view'];
  $content_only = array('apartment');
    if (in_array($view->name, $content_only)) {
      $vars['theme_hook_suggestions'] = array('views_view_unformatted__content_only');
    }
}
/**
* Implements hook_preprocess_HOOK
*
* Replace Object NID field with node teaser.
*/
// function hk_theme_preprocess_views_view_fields(&$vars) {
//   //dpm($vars);
//   if ($vars['view']->name == 'karten') {
//     $node = node_load($vars['row']->entity);
//     $node_view = node_view($node, 'map-popup');
//     $vars['fields']['nid_1']->content = theme('node', $node_view);
//   }
// }
/**
 * Implements hook_language_negotiation_info_alter().
 *
 * Remove the 'cache' setting from LOCALE_LANGUAGE_NEGOTIATION_BROWSER since
 * the code that utilizes this setting will in fact prevent browser negotiation.
 */
// function hk_theme_language_negotiation_info_alter(&$negotiation_info) {
//     unset($negotiation_info[LOCALE_LANGUAGE_NEGOTIATION_BROWSER]['cache']);
// }

function hk_theme_preprocess_views_view(&$vars) {
  // Get the current view info
  $view = $vars['view'];

  // Add JS/CSS based on current view display
  if ($view->current_display == 'print') {
    drupal_add_js( /* parameters */ );
    drupal_add_css(path_to_theme() . '/css/pdfprint.css');
  }
}

/**
 * Implements hook_wysiwyg_editor_settings_alter()
 *
 * @see http://docs.cksource.com/CKEditor_3.x/Howto/Enabling_SCAYT
 */
function hk_theme_wysiwyg_editor_settings_alter(&$settings, $context) {
  // The $context variable contains information about the wysiwyg profile we're using
  // In this case we just need to check that the editor being used is ckeditor
  if ($context['profile']->editor == 'ckeditor') {
    // Make Scayt enabled by default.
    $settings['scayt_autoStartup'] = 'true';
  }
}