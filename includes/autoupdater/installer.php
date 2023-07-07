<?php

add_action("wp_ajax_bkbm_kbtfw_installation_counter", "bkbmKbtfwAddInstallationData");
add_action("wp_ajax_nopriv_bkbm_kbtfw_installation_counter", "bkbmKbtfwAddInstallationData");

function bkbmKbtfwApiUrl()
{
  $baseUrl = get_home_url();
  if (strpos($baseUrl, "localhost/dev.plugin/bkbm") != false) {
    return "http://localhost/bwl_api/";
  } elseif (strpos($baseUrl, "staging.bluewindlab.com") != false) {
    return "https://staging.bluewindlab.com/bwl_api/";
  } else {
    return "https://api.bluewindlab.net/";
  }
}

function bkbmKbtfwAddInstallationData()
{
  $apiURL = bkbmKbtfwApiUrl();
  $site_url = get_site_url();
  $product_id = $_REQUEST['product_id']; // change the id
  $ip = $_SERVER['REMOTE_ADDR'];
  $requestUrl = $apiURL . "wp-json/bwlapi/v1/installation/count?product_id=$product_id&site=$site_url&referer=$ip";

  $output = wp_remote_get($requestUrl);
  $output_decode = json_decode($output['body'], true);

  if (isset($output_decode['status']) && $output_decode['status'] == 1) {

    update_option('bkbm_kbtfw_installation', '1'); // change the tag

    $data = [
      'status' => $output_decode['status']
    ];
  } else {
    $data = [
      'status' => $output_decode['status']
    ];
  }

  echo json_encode($data);

  die();
}
