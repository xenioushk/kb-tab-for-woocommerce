<?php

$updaterBase = 'https://projects.bluewindlab.net/wpplugin/zipped/plugins/';
$pluginRemoteUpdater = $updaterBase . 'bkbm/notifier_bkbm_kbtfw.php';
new WpAutoUpdater(BKBKBTFW_ADDON_CURRENT_VERSION, $pluginRemoteUpdater, BKBKBTFW_ADDON_UPDATER_SLUG);
