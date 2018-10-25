<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://www.linkedin.com/in/s4hilk/
 * @since      1.0.0
 *
 * @package    Nr_Tracking
 * @subpackage Nr_Tracking/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->
<div class="wrap">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
          rel="stylesheet">
        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>



    <form method="post" name="add_scripts" action="options.php">
        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>
    <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // codes
        $gtm_container = $options['gtm_container'];
        $bing_code = $options['bing_code'];
        $nr_tr_local_schema = $options['nr_tr_local_schema'];
        $nr_tr_development_mode = $options['nr_tr_development_mode'];
    ?>

    <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>

    <div class="row">
        <div class="col s12">
            <h4>Tracking</h4>
        </div>
    <div class="col s12 m4">
      <div class="card">

        <div class="card-content">
                          <div class="input-field">
                        <legend class="screen-reader-text"><span><?php _e('Add GTM Container Code', $this->plugin_name); ?></span></legend>
                        <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-gtm_container" name="<?php echo $this->plugin_name; ?>[gtm_container]" value="<?php if(!empty($gtm_container)) echo $gtm_container; ?>"/>
                        <label for = "<?php echo $this->plugin_name; ?>-gtm_container">GTM Container Code</label>
                        </div>

        </div>
    
      </div>
    </div>

    <div class="col s12 m4">
      <div class="card">

        <div class="card-content">
                          <div class="input-field">
                        <legend class="screen-reader-text"><span><?php _e('Add Bing Validation code', $this->plugin_name); ?></span></legend>
                         <input type="text" class="regular-text" id="<?php echo $this->plugin_name; ?>-bing_code" name="<?php echo $this->plugin_name; ?>[bing_code]" value="<?php if(!empty($bing_code)) echo $bing_code; ?>"/>
                        <label for="<?php echo $this->plugin_name; ?>-bing_code">Add Bing Validation Code</label>
                        </div>

        </div>
    
      </div>

    </div>

        <div class="col s12">
            <hr/>
            <h4>Schema</h4>
        </div>
    <div class="col s12 m8">
        <div class="card" style="max-width: none">
        <div class="card-content">
            <p>Add Local Schema</p>
                        <legend class="screen-reader-text"><span><?php _e('Add Local Schema', $this->plugin_name); ?></span></legend>
                        <textarea class="regular-text" id="<?php echo $this->plugin_name; ?>-nr_tr_local_schema" name="<?php echo $this->plugin_name; ?>[nr_tr_local_schema]" style="width:100%;" rows="20"><?php if(!empty($nr_tr_local_schema)) echo $nr_tr_local_schema; ?></textarea>
        </div>
        </div>
    </div>

        <div class="col s12">
            <hr>
            <buttom class="waves-effect advanced-settings blue-color">Advanced Settings <i class="material-icons">
                    add
                </i></buttom>
        </div>
        <br>
        <br>
        <div class="advanced-settings-container col s12" style="display:none">
            <div class="col s12">
            <div class="col sm4 sm12">
                Development Mode
            </div>
            <div class="col sm8 sm12">
                <div class="switch">
                    <label>
                        Off
                        <input type="checkbox" name="<?= $this->plugin_name; ?>[nr_tr_development_mode]" <?php if(!empty($nr_tr_development_mode)) echo "checked"; ?> >


                        <span class="lever"></span>
                        On
                    </label>
                </div>
            </div>
            </div>
        </div>

  </div>

        <?php
        if(empty($nr_tr_development_mode)) {
            $file_path = get_stylesheet_directory()."/less/theme.nativerank.less";
            // Open the file to get existing content
            $current = file_get_contents($file_path);



            $writable = ( is_writable($file_path) ) ? TRUE : chmod($file_path, 0755);
            if ( $writable ) {
                $data_to_write = $current;
                $data_to_write = str_replace('//@import "src/custom.less"', '@import "src/custom.less"', $data_to_write);
                $data_to_write = str_replace('//DEVELOPMENT MODE', '//PRODUCTION MODE', $data_to_write);

                file_put_contents($file_path, $data_to_write);
            } else {
                echo "theme less file is not writable";
            }
        } else{
            $file_path = get_stylesheet_directory()."/less/theme.nativerank.less";
            // Open the file to get existing content
            $current = file_get_contents($file_path);



            $writable = ( is_writable($file_path) ) ? TRUE : chmod($file_path, 0755);
            if ( $writable ) {
                if(strpos($current, "PRODUCTION MODE") !== false) {
                    $data_to_write = $current;
                    $data_to_write = str_replace('@import "src/custom.less"', '//@import "src/custom.less"', $data_to_write);
                    $data_to_write = str_replace('//PRODUCTION MODE', '//DEVELOPMENT MODE', $data_to_write);

                    file_put_contents($file_path, $data_to_write);
                }
            } else {
                echo "theme less file is not writable";
            }
        }

        ?>
        <script>
            $ = function(val){
                return document.querySelector(val)
            }
            $('.advanced-settings').addEventListener('click', b => {
                if($('.advanced-settings-container').style.display != 'none'){$('.advanced-settings-container').style.display='none'} else {$('.advanced-settings-container').style.display='block'}
            } )
        </script>



    </form>

</div>
<style>
    i.material-icons{
        line-height: inherit;
        vertical-align: middle;
    }
    .advanced-settings-container{
        padding:30px!important;
        background:#fff;
        margin-top:20px!important;
    }
</style>