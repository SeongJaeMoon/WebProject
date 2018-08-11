<?php
/*
 * Adds 'Rest API' tab to settings area
*/
add_filter("wplc_filter_setting_tabs","wplc_api_settings_tab_heading_doc_suggestions_basic");
function wplc_api_settings_tab_heading_doc_suggestions_basic($tab_array) {
    $tab_array['doc'] = array(
      "href" => "#tabs-doc-suggest",
      "icon" => 'fa fa-lightbulb-o',
      "label" => __("Doc Suggestions","wplivechat")
    );
    return $tab_array;
}


/*
 * Adds 'Rest API' content to settings area
*/
add_action("wplc_hook_settings_page_more_tabs","wplc_hook_settings_page_more_doc_suggestions",10);
function wplc_hook_settings_page_more_doc_suggestions() {
    ?>
		<div id="tabs-doc-suggest">
			<h3><?php _e("Documentation Suggestions", "wplivechat") ?></h3>
			<table class="form-table wp-list-table wplc_list_table widefat fixed striped pages">
				<tbody>
					<tr>
						<td width="300" valign="top">
						  <?php echo __("Enable Documentation Suggestions","wplivechat"); ?> <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="When a user sends a message the plugin will automatically detect if there are posts or pages that can be suggested to the user in order for the user to get more information about what they are asking. This is useful when the user has typed their message and is still waiting for an agent to answer their chat."></i>
						</td>
						<td valign="top">
						  <input type="checkbox" value="1" name="wplc_doc_suggestions" disabled='disabled'> 
  						</td>
	              	</tr>
					<tr>
						<td valign="top">
						   <p class='description'><?php echo sprintf(__("Upgrade to the <a href='%s' taget='_BLANK'>pro version</a> to automatically suggest relevant documentation pages on your own site while users are waiting for the agent to join the chat. As soon as the user sends a message, the system will locate relevant documents on your website and provide links to the user.","wplivechat"),"https://wp-livechat.com/purchase-pro/"); ?></p>
  						</td>
						<td valign="top">
						  
						</td>
	              	</tr>
				</tbody>
			</table>
			<br>

		</div>
		
		<?php
	

}