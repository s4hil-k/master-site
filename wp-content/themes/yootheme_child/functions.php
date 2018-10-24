<?php 
// ob_clean();
// ob_start();
//..remove emoji-release.min.js
remove_action('wp_head', 'print_emoji_detection_script', 7);
remove_action('wp_print_styles', 'print_emoji_styles');

//...Dequeue jQuery migrate
function cedaro_dequeue_jquery_migrate( $scripts ) {
	if ( ! is_admin() && ! empty( $scripts->registered['jquery'] ) ) {
		$jquery_dependencies = $scripts->registered['jquery']->deps;
		$scripts->registered['jquery']->deps = array_diff( $jquery_dependencies, array( 'jquery-migrate' ) );
	}
}
add_action( 'wp_default_scripts', 'cedaro_dequeue_jquery_migrate' );


//...Dequeue wp-embed
function my_deregister_scripts(){
  wp_deregister_script( 'wp-embed' );
}
add_action( 'wp_footer', 'my_deregister_scripts' );


//...Add SiteNavigation Schema

add_action( 'wp_footer', 'echo_siteNavigation_schema' );
function echo_siteNavigation_schema() {
    $menus = get_registered_nav_menus();

$menuLocations = get_nav_menu_locations(); // Get our nav locations (set in our theme, usually functions.php)
 // This returns an array of menu locations ([LOCATION_NAME] = MENU_ID);

$menuID = $menuLocations['navbar']; // Get the *primary* menu ID

$primaryNav = wp_get_nav_menu_items($menuID); // Get the array of wp objects, the nav items for our queried location.

    echo '<script type="application/ld+json">
{
  "@context": "http://schema.org",
  

"@graph" : [
  ';

  

  foreach ( $primaryNav as $navItem ) {

 if ($primaryNav[0]->title != $navItem->title)
{
echo ",\n";

}
 echo '{"@type": "SiteNavigationElement","name": "'.$navItem->title.'"';
  echo ',"url": "'.$navItem->url.'"}';

}

echo '

]
}

</script>';
}

//...Add Google Icons
// function add_google_icons()
// {
//  echo '<link href="https://fonts.googleapis.com/icon?family=Material+Icons"
//       rel="stylesheet">';
// }


//add_action( 'wp_footer', 'add_google_icons' );


//...Add Breadcumb Schema

function add_breadcrumb_schema()
{
if ( function_exists('yoast_breadcrumb') ) {
yoast_breadcrumb('
<p id="breadcrumbs" class="uk-hidden">','</p>
');
}
}

add_action( 'wp_footer', 'add_breadcrumb_schema' );


function has_my_cookie()
{
    if (!is_admin() && !is_front_page()){
        if ( !isset($_COOKIE["nrdevsites_logged_in"])) {
            wp_redirect( '/error.php?dev='.get_site_url());
            echo "<meta http-equiv=\"refresh\" content=\"0;url=/error.php?dev=".get_site_url()."\" />";
            exit;
        }
    }
}
add_action('wp_head', 'has_my_cookie');

function override_mce_options($initArray) {
    $opts = '*[*]';
    $initArray['valid_elements'] = $opts;
    $initArray['extended_valid_elements'] = $opts;
    return $initArray;
}
add_filter('wp-before-tinymce-init', 'override_mce_options');
?>
