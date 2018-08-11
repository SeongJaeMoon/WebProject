<?php //global $wpgmza_global_array; ?>
<div class="wrap about-wrap">
<p>&nbsp;</p>
<h1 style='margin-right: 0;'><?php _e("Welcome to WP Live Chat Support v8","wplivechat"); ?> <div class="wplc-badge" style=' float: right; display: block; max-width: 20%; margin-left: 15%;'><img src='<?php echo WPLC_BASIC_PLUGIN_URL . "images/wplc-logo.png"; ?>' /></div></h1>

<div class="about-text"><?php _e("WP Live Chat Support is the most cost effective, feature rich, amazingly supported and most positively reviewed live chat plugin on WordPress!","wplivechat"); ?></div>

<a class="button-primary" style='padding:5px; padding-right:15px; padding-left:15px; height:inherit;' href="admin.php?page=wplivechat-menu&override=1"><?php echo __("Skip intro and start accepting chats","wplivechat"); ?></a>
<p>&nbsp;</p>

<?php
    
    if( !isset( $_GET['action'] ) ){
        $welcome_active = 'nav-tab-active';
        $credits_active = '';
    } else {
        if( $_GET['action'] == 'welcome' ){
            $welcome_active = 'nav-tab-active';
            $credits_active = '';
        } else if( $_GET['action'] == 'credits' ){
            $credits_active = 'nav-tab-active';
            $welcome_active = '';
        }
    }

?>
<h2 class="nav-tab-wrapper wp-clearfix">
    <a href="admin.php?page=wplivechat-menu&action=welcome" class="nav-tab <?php echo $welcome_active; ?>"><?php _e("Welcome","wplivechat"); ?></a>
    <a href="admin.php?page=wplivechat-menu&action=credits" class="nav-tab <?php echo $credits_active; ?>"><?php _e("Credits","wplivechat"); ?></a>

</h2>
<?php if( !isset( $_GET['action'] ) || ( isset( $_GET['action'] ) && $_GET['action'] == 'welcome' ) ){ ?>
<h2>What's new in Version 8?</h2>
<center><img src='<?php echo WPLC_BASIC_PLUGIN_URL; ?>/images/performance.png' style='width:300px;' /></center>
<div class="feature-section three-col">
    <div class="col">
        <div style='text-align: center;' ><i class="fa-4x fa fa-bolt" aria-hidden="true"></i><br/><h4><?php _e("Incredibly fast server","wplivechat"); ?></h4></div>
        
        <p style='text-align: center;'><?php _e("Use our server to handle the load and save 1000%+ on server resources!","wplivechat"); ?></p>        
    </div>    
    <div class="col">
        <div style='text-align: center;' ><i class="fa-4x fa fa-dashboard" aria-hidden="true"></i><br/><h4><?php _e("New Dashboard","wplivechat"); ?></h4></div>        
        <p style='text-align: center;'><?php _e("Handle all your chats in one area, on any admin page.","wplivechat"); ?></p>        
    </div>   
    <div class="col">
        <div style='text-align: center;' ><i class="fa-4x far fa-smile" aria-hidden="true"></i><br/><h4><?php _e("Emojis!","wplivechat"); ?></h4></div>        
        <p style='text-align: center;'><?php _e("Add a touch of your own personality with emojis!","wplivechat"); ?></p>        
    </div>
</div>

<h2>New Pro features</h2>
<div class="feature-section three-col">
    <div class="col">
        <div style='text-align: center;' ><i class="fa-4x fa fa-commenting-o" aria-hidden="true"></i><br/><h4><?php _e("Typing Preview","wplivechat"); ?></h4></div>
        
        <p style='text-align: center;'><?php _e("See what your customers are typing before they even send it!","wplivechat"); ?></p>        
    </div>
    <div class="col">
        <div style='text-align: center;' ><i class="fa-4x fa fa-users" aria-hidden="true"></i><br/><h4><?php _e("Multiple Agents Per Chat","wplivechat"); ?></h4></div>
        
        <p style='text-align: center;'><?php _e("More than one agent can join and be involved in a chat.","wplivechat"); ?></p>        
    </div>    
    <div class="col">
        <div style='text-align: center;' ><i class="fa-4x fa fa-random" aria-hidden="true"></i><br/><h4><?php _e("Agent to Agent Chat","wplivechat"); ?></h4></div>
        
        <p style='text-align: center;'><?php _e( "Chat directly to other agents on our new dashboard.","wplivechat"); ?></p>        
    </div>
</div>
<div class="feature-section three-col">
    <div class="col">
        <div style='text-align: center;' ><i class="fa-4x fa fa-eraser" aria-hidden="true"></i><br/><h4><?php _e("Edit Messages","wplivechat"); ?></h4></div>
        
        <p style='text-align: center;'><?php _e("Simply press the UP arrow or use the EDIT link to edit a message that you have already sent.","wplivechat"); ?></p>        
    </div>
    <div class="col">
        <div style='text-align: center;' ><i class="fa-4x fa fa-heartbeat" aria-hidden="true"></i><br/><h4><?php _e("Event Monitoring","wplivechat"); ?></h4></div>
        
        <p style='text-align: center;'><?php _e("Know exactly what the user is doing in real time.","wplivechat"); ?></p>        
    </div>    
    <div class="col">
        <div style='text-align: center;' ><i class="fa-4x fa fa-apple" aria-hidden="true"></i><br/><h4><?php _e("iOS app","wplivechat"); ?></h4></div>
        
        <p style='text-align: center;'><?php _e( "The new iOS app is finally here!","wplivechat"); ?></p>        
    </div>
</div>

<hr />

<div class="feature-section normal clear" >
    <div class="changelog ">
        <!--<h2 style="font-size: 25px; text-align: left;"><?php _e('How did you find us?', 'wplivechat'); ?></h2>
        <form method="post" name="wplc_find_us_form" style="font-size: 16px;">
            <div  style="text-align: left; width:275px;">
                <input type="radio" name="wplc_find_us" id="wordpress" value='repository'>
                <label for="wordpress">
                    <?php _e('WordPress.org plugin repository ', 'wplivechat'); ?>
                </label>
                <br/>
                <input type='text' placeholder="<?php _e('Search Term', 'wplivechat'); ?>" name='wplc_nl_search_term' style='margin-top:5px; margin-left: 23px; width: 100%  '>
                <br/>
                <input type="radio" name="wplc_find_us" id="search_engine" value='search_engine'>
                <label for="search_engine">
                    <?php _e('Google or other search Engine', 'wplivechat'); ?>
                </label>
                <br/>
                <input type="radio" name="wplc_find_us" id="friend" value='friend'>
                
                <label for='friend'>
                    <?php _e('Friend recommendation', 'wplivechat'); ?>
                </label>
                <br/>   
                <input type="radio" name="wplc_find_us" id='other' value='other'>
                
                <label for='other'>
                    <?php _e('Other', 'wplivechat'); ?>
                </label>
                <br/>
                
                <textarea placeholder="<?php _e('Please Explain', 'wplivechat'); ?>" style='margin-top:5px; margin-left: 23px; width: 100%' name='wplc_nl_findus_other_url'></textarea>
            </div>
            <div>
                
            </div>
            <div>
                
            </div>
            <div style='margin-top: 20px;'>
                <button name='action' value='wplc_submit_find_us' class="button-primary" style=""><?php _e('Submit', 'wplivechat'); ?></button> <a href='<?php echo admin_url("/admin.php?page=wplivechat-menu&override=1"); ?>'class="button"><?php _e('Skip', 'wplivechat'); ?></a>
            </div>
        </form> 
        <br/><br/>
        
        <hr /> -->
        
        <div class="feature-section three-col">
            <div class='col'>
                <h4><?php _e("New to WP Live Chat Support?","wplivechat"); ?></h4>
                <p><?php _e("You may want to","wp-google-maps"); ?> <a href='https://wp-livechat.com/documentation/' target='_blank' title='Documentation'><?php _e("review our documentation","wplivechat"); ?></a> <?php _e("before you get started. If you're a tech-savvy individual, you may skip this step.","wplivechat"); ?></p>
            </div>
            <div class='col'>
                <h4><?php _e("Help me!","wplivechat"); ?></h4>
                <p><?php _e("Visit our","wplivechat"); ?> <a title='Support Desk' target='_blank' href='https://wp-livechat.com/contact-us/'><?php _e("Support Desk","wplivechat"); ?></a> <?php _e("for quick and friendly help. We'll answer your request within 24hours.","wplivechat"); ?></p>
            </div>
            <div class='col'>
                <h4><?php _e("Feedback","wp-google-maps"); ?></h4>
                <p><?php _e("We need you to help us make this plugin better.","wplivechat"); ?> <a href='https://wp-livechat.com/contact-us/' title='Feedback' target='_BLANK'><?php _e("Send us your feedback","wplivechat"); ?></a> <?php _e("and we'll act on it as soon as humanly possible.","wplivechat"); ?></p>
            </div>
        </div>
        
        <a class="button-primary" style='padding:5px; padding-right:15px; padding-left:15px; height:inherit;' href="admin.php?page=wplivechat-menu&override=1"><?php echo __("OK! Let's start","wplivechat"); ?></a>

    </div>
</div>

</div>
<?php } else {
    $path = plugin_dir_path(__FILE__).'credits.php';    
    include $path;
} 
?>