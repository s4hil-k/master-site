<?php

/*
Plugin Name: H1 Import
Description: Import &lt;H1&gt; tags. For NativeRank use only
Version: 0.1
Author: Sahil Khanna
*/

include "rapid-addon.php";

$import_addon = new RapidAddon("H1 Import", "import_addon");

$import_addon->add_field("nr_h1", "NR - H1", "text");

$import_addon->set_import_function("import_addon_run");

$import_addon->run();

function import_addon_run($post_id, $data, $import_options) {
update_post_meta($post_id, "NR - H1", $data["nr_h1"]);

}