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
  $variables['path_to_bear_skin'] = drupal_get_path('theme', 'bear_skin');
}

/**
 * Implements theme_links().
 * Enables sub-menu item display for main menu.
 */
function hk_theme_links($variables) {
  if (array_key_exists('id', $variables['attributes']) && $variables['attributes']['id'] == 'nav') {
    $pid = variable_get('menu_main_links_source', 'nav');
    $tree = menu_tree($pid);
    return drupal_render($tree);
  }
  return theme_links($variables);
}

/**
 * Implements template_preprocess_page().
 */
function hk_theme_preprocess_page(&$vars) {
  $vars['user_menu'] =  theme('links', array('links' => menu_navigation_links('user-menu'), 'attributes' => array('class '=> array('links', 'site-menu'))));
}

/***********************
Let's load some CSS on specific targets - uncomment to use
************************/

// function hk_theme_preprocess_node(&$vars) {
//   // Add JS & CSS by node type
//   if( $vars['type'] == 'page') {
//     //drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }

//   // Add JS & CSS to the front page
//   if ($vars['is_front']) {
//     drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }

//   // Add JS & CSS by node ID
//   if (drupal_get_path_alias("node/{$vars['#node']->nid}") == 'your-node-id') {
//     //drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }
// }
// function hk_theme_preprocess_page(&$vars) {
//   // Add JS & CSS by node type
//   if (isset($vars['node']) && $vars['node']->type == 'page') {
//     //drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }
//   // Add JS & CSS by node ID
//   if (isset($vars['node']) && $vars['node']->nid == '1') {
//     //drupal_add_js(path_to_theme(). '/js/supercool_scripts.js');
//     //drupal_add_css(path_to_theme(). '/css/supercool_sheet.css');
//   }
// }

// Hide active language in language switcher block
function hk_theme_links__locale_block($variables) {
  global $language;
  unset($variables['links'][$language->language]);
  return theme('links', $variables);
}

// Set exposed filter labels as translatable -any- option because better exposed filter is not i18n
function hk_theme_form_views_exposed_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'views_exposed_form' && $form_state['view']->name == 'karten') {
    $form['bezirk']['#options']['All'] = t('borough');
    $form['preis']['#options']['All'] = t('price');
    $form['preis_group']['#options']['All'] = t('price');
    $form['zimmer']['#options']['All'] = t('rooms');
    $form['kategorie']['#options']['All'] = t('buy');
    $form['flaeche']['#options']['All'] = t('surface area');
    // and so on.
  }
}

/*function hk_theme_leaflet_map_info_alter(&$maps) {
  $maps['karte']['minZoom'] = 8;

}*/

/**
 * Implements hook_ctools_plugin_post_alter().
 */
function hk_theme_ctools_plugin_post_alter(&$plugin, &$info) {
  // Workaround to render facet blocks last, this actually sets all block
  // to render last.
  if ('content_types' == $plugin['plugin type'] && 'block' == $plugin['name']) {
    $plugin['render last'] = TRUE;
  }
}