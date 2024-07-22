<?php
if (!function_exists('getPermissionUrl')) {
  function getPermissionUrl($accessUri)
  {
    $html = '<div class="table-permission-list-wrapper">';
    $html .= '<ul>';
    foreach ($accessUri as $url) {
      if ($url == '/*') {
        $html .= '<li>Full Control</li>';
      } else {
        $urlArr = explode('/', $url);
        $action = count($urlArr) > 2 ? ucFirst($urlArr[2]) : 'View';
        $html .= '<li>' . $action . ' ' . ucFirst($urlArr[1]) . '</li>';
      }
    }
    $html .= '</ul>';
    $html .= '</div>';
    return $html;
  }
}
if (!function_exists('getRelatedList')) {
  function getRelatedList($lists)
  {
    $html = '<div class="table-permission-list-wrapper">';
    $html .= '<ul>';
    foreach ($lists as $list) {
      $html .= '<li>' . $list->name . '</li>';
    }

    $html .= '</ul>';
    $html .= '</div>';
    return $html;
  }
}
