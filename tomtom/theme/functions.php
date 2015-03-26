<?php
/**
 * Theme related functions. 
 *
 */

/**
 * Get title for the webpage by concatenating page specific title with site-wide title.
 *
 * @param string $title for this page.
 * @return string/null wether the favicon is defined or not.
 */
function get_title($title) {
  global $tomtom;
  return $title . (isset($tomtom['title_append']) ? $tomtom['title_append'] : null);
}

// Function for navbar
function get_navbar($menu) {
  $html = "<nav class='{$menu['class']}'>\n";
  foreach($menu['items'] as $item) {
    $selected = $menu['callback_selected']($item['url']) ? " class='selected' " : null;
    $html .= "<a{$selected} href='{$item['url']}' title='{$item['title']}'>{$item['text']}</a>\n";
  }
  $html .= "</nav>\n";
  return $html;
}