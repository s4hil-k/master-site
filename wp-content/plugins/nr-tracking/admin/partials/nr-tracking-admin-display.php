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

        <h2><?php echo esc_html( get_admin_page_title() ); ?></h2>



    <form method="post" name="add_scripts" action="options.php">

    <?php
        //Grab all options
        $options = get_option($this->plugin_name);

        // codes
        $gtm_container = $options['gtm_container'];
        $bing_code = $options['bing_code'];
        $nr_tr_local_schema = $options['nr_tr_local_schema'];
    ?>

    <?php
        settings_fields($this->plugin_name);
        do_settings_sections($this->plugin_name);
    ?>

    <div class="row">
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

    <div class="col s12 m8">
        <div class="card" style="max-width: none">
        <div class="card-content">
            <p>Add Local Schema</p>
                        <legend class="screen-reader-text"><span><?php _e('Add Local Schema', $this->plugin_name); ?></span></legend>
                        <textarea class="regular-text" id="<?php echo $this->plugin_name; ?>-nr_tr_local_schema" name="<?php echo $this->plugin_name; ?>[nr_tr_local_schema]" style="width:100%;" rows="20"><?php if(!empty($nr_tr_local_schema)) echo $nr_tr_local_schema; ?></textarea>
        </div>
        </div>
    </div>

  </div>
           
       

                        
 
    


        <?php submit_button('Save all changes', 'primary','submit', TRUE); ?>

    </form>

</div>
