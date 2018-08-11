<?php
/*
  Plugin Name: WP Live Chat Support
  Plugin URI: http://www.wp-livechat.com
  Description: The easiest to use website live chat plugin. Let your visitors chat with you and increase sales conversion rates with WP Live Chat Support.
  Version: 8.0.14
  Author: WP-LiveChat
  Author URI: http://www.wp-livechat.com
  Text Domain: wplivechat
  Domain Path: /languages
*/

/**
 * 
 * 8.0.14 - 2018-07-19 - Low priority
 * Removed 'let' from wplc_server.js file (Adds Safari compatibility)
 * Fixed issues with Google Analytics integration when using our servers
 * Fixed issues with chat box styling with classic theme and GDPR module enabled
 * Fixed issues with Contact From Ready integration styling with modern theme
 * Fixed issues with Slack integration extension
 * Bulgarian Translation Added (Thank you Emil Genchev!)
 * Fixed erroneous display of set_time_limit and safe_mode warnings
 * Fixed a big that lead to the deletion of sessions and not messages when a chat was marked for deletion
 * Improved security in the chat history code
 * Added better styling support for smaller width devices (<500px)
 * Updated Swedish translation files
 * Added Arabic translation files
 * Fixed the duplicate message history loading in the history area
 * Fixed core framework issues with Voice Note system
 * Fixed an issue where invalid query selectors would break the 'Open chat via' functionality
 * Fixed an issue with username encoding
 * Fixed issue with surveys showing after chat end
 * Fixed an issue with classic theme display when anchored to left/right positions
 * Added auto transcript mailing to frontend end chat button, and REST API
 * Added an 'incomplete' class when GDPR checkbox is not ticket, to draw attention to this input field
 * Tested Multi-Site compatibility
 * Updated all PO/MO files with updated sources
 * Added default GDPR translations for DE, FR, ES, and IT languages (Using Google Translate)
 * 
 * 8.0.13 - 2018-06-06 - Medium priority
 * Fix chat delay not working for first visit and offline
 * Optimize images
 * Mootools compatibility
 * Fix new chat request email notifications when Pro is active
 * 
 * 8.0.12 - 2018-05-29 - High priority
 * Fixed a bug which caused the chat box not to display on some sites
 * Fixed minor styling issues
 *
 * 8.0.11 - 2018-05-28 - High priority
 * Fixed a bug that caused a fatal error on PHP 5.3 and below
 *
 * 8.0.10 - 2018-05-25 - Medium priority
 * Resyncs files for GDPR modules to load correctly
 *
 * 8.0.09 - 2018-05-25 - High priority
 * Added GDPR Compliance
 * Added GDPR Options
 * Added GDPR Admin page
 *
 * 8.0.08 - 2018-05-14 - High priority
 * XSS vulnerability fixes thanks to Riccardo Ten cate
 * Fixed REST Storage Issue
 * Add pagination to History, Missed Chats and Offline Messages admin pages
 * Fix for Disable Emojis setting not displaying when Pro is active
 * Fix for timestamp not displaying correctly
 * Fix for WP Rocket comaptibility
 * Fix for chat box not popping up for returning visitors that had previously minimized
 *
 * 8.0.07 - 2018-03-23 - Low priority
 * Fixed a "direct user to page" bug
 *
 * 8.0.06 - 2018-03-23 - High priority
 * XSS vulnerability fixes thanks to https://www.gubello.me/blog/
 * Fixed a chat width styling bug on the front end
 *
 * 8.0.05 - 2018-03-09 - Medium priority
 * Chat minimize is now respected
 * GIF integration support (Giphy, Tenor)
 * Fixed get correct rest api endpoint urls
 * Fixed chat box header not respecting Use WordPress name instead option
 * Fixes CSS issue in dashboard with the action column
 * Fixes chat history styling
 * Mac style fix (front end)
 * Email transcript integrated
 *
 * 8.0.04 - 2018-02-12 - Low priority
 * Allowed strings from the front end to be translated
 * Fixed the iPhone Safari display bug (zooming in to the chat box)
 * Added support for the agent to detect and connect to the closest chat server
 *
 * 8.0.03 - 2018-01-30 - Medium priority
 * Fixed a CSS bug
 * Corrected a bug with the default theme not being set correctly.
 *
 * 8.0.02 - 2018-01-29 - Medium priority
 * Fixed a PHP warning
 * Modified rest_url filter to no longer use anonymous function
 * Fixed styling conflicts between our settings and other pages in WordPress admin
 * Fixed issues with file uploads (Bleeper core)
 * Fixed hints in settings area
 * Fixed links in chat bubbles not being clearly visible
 * Fixed assets loading on all admin pages when option is disabled
 * Fixed the bug that caused issues if your folder name was not wp-live-chat-support
 * Fixed issue where inactive chat status is not removed when new message from that chat is received
 * Welcome page styling fixed
 *
 * 8.0.01 - 2018-01-24 - High priority
 * Massive improvements to the performance of the plugin
 * New, modern dashboard
 * The dashboard can now be added to all admin pages
 * Dynamic visitor filtering
 * Improved REST API Security
 * OS identification
 * Better Browser identification
 * Mobile/desktop identification
 * Country identification (API)
 * Inline link handling
 * Security patches
 * Gutenberg support
 * Full WPML Support
 * Showcase user's timezone
 * Emoticons
 * New API endpoints
 * Refactor JS code – backend and frontend to make use of events
 * Store messages using sessionStorage to avoid unnecessary DB calls
 * Better polling system for visitor tracking
 * Better history UI
 *
 *
 * 7.1.02 - 2017-06-21 - Low priority
 * Fixed a compat issue between pro and basic with regards to the agent social profiles
 * Fixed undefined variables when using social profiles, a bio and tag line
 * Fixed a bug that caused some messages to not get recorded
 *
 * 7.1.01 - 2017-06-18 - Low priority
 * Small bug fix for agent profiles
 *
 * 7.1.00 - 2017-06-18 - Medium priority
 * Modernised the live chat box
 * Fixed a bug that caused the wrong agent name to show up in the "typing" element after a chat was transferred
 * Other minor bug fixes
 * Added better support for caching systems (style sheets now have a version tag)
 * Added additional support for the new features of the Cloud server
 * Replaced all appropriate references of get_option('siteurl'); with site_url(); to embrace SSL where needed
 * Images are now preloaded on the front end for a better user experience
 * Fixed a fatal error found on some installations (https://github.com/CodeCabin/wp-live-chat-support/issues/329)
 * Fixed a bug that cause the "Retry chat" to not work with the modern chat box
 * Fixed a bug with the missed chat functionality - when an agent missed the chat, the chat ID would change and the agent would not be able to communicate with the visitor
 * Fixed a bug with the listing of all missed chats
 * Fixed a bug that sent pings to the node server when it was not necessary, causing an overload of the node server
 * Fixed a bug that did not allow you to view the chat history of a missed chat
 * Fixed a bug that caused the 'display name' and 'display avatar' to behave erratically
 * Fixed a bug that caused the time and date display functionality to behave erratically
 * Fixed a bug that caused a JavaScript error on the admin chat dashboard when a single visitor leaves the site
 * Fixed a bug that caused the chat widow to appear before the chat circle when engaged in a chat and moving from page to page
 * The visitor can now restart any chat that has been ended by an agent
 * You can now customize the text "The chat has been ended by the operator"
 * Fixed a bug that caused duplicate loading of messages
 * When using a custom element to open the chat window, that element now has a cursor pointer styled to it by default
 * Fixed a bug that incorrectly fired off ajax events when minimizing or maximizing the offline message box
 * Fixed a bug that caused the offline message box to show up incorrectly after being dragged
 * Fixed a bug that caused "maximize" notifications to not get sent through to agents when using the Node server
 * Fixed a bug that did not allow single missed chats to be deleted
 * Fixed a bug that caused the text input field to continually be focused on thereby causing issues
 *
 * 7.0.08 - 2017-05-21 - Low priority
 * Fixed the powered by link
 * Added supporting code for new extensions
 *
 * 7.0.07 - 2017-05-15 - Medium priority
 * You can now change the text of the offline message button
 * You can now change the text of the close chat button
 * Added a notification to the chat dashboard to help agents identify if the chat box is not showing up on the front end, and provide a reason
 * Added ability to set a default visitor name
 * Added ability to choose which user fields are required (name, email or both)
 * Added visual aid when new message is sent and chat is minimized (user's side)
 * Fixed a security issue in the back end (thank you JPCERT Coordination Center (https://www.jpcert.or.jp/english/))
 * Fixed a bug that caused a sound to be played on every page load of a visitor
 * Fixed a bug that stopped a user from sending a message when the admin initiated a chat
 * Fixed the bug that showed the incorrect icon for IE
 * Fixed a bug that caused empty button without remove/delete icon in Missed Chats
 * Fixed a bug that caused attached images to not display correctly
 * Fixed a bug that caused notifications to show up in the front end when the agent is testing a chat with him or herself
 * Fixed a bug that caused the visitor count to flash when the visitor count had not changed
 *
 * 7.0.06 -2017-03-13 - Low Priority
 * Enhancement: 'Open Chat' button changes to 'Chat Accepted' once a chat is active
 * Bug Fix: Compatibility bug fix for decryption in the Pro version
 *
 * 7.0.05 - 2017-03-01 - Low priority
 * Fixed broken links on the plugins page
 *
 * 7.0.04 - 2017-02-15 - Medium Priority
 * Fixed a bug that caused messages to be returned encoded after refreshing the page
 * Fixed a bug that caused the incorrect agent name to be used in the chat window
 * Fixed a bug that caused the 'No Answer' text to not save and show in the chat window
 *
 *
 * 7.0.03 - 2017-02-06 - Medium Priority
 * Fixed a bug that caused the name of the agent to disappear after refreshing the page
 * Fixed a bug that caused the agent name to display twice in the chat window
 *
 * 7.0.02 - 2017-01-26 - High priority
 * PHPMailer vulnerability patch (removed our version of PHPMailer and are now using WP's built-in version)
 * Added the ability for plugin users to subscribe to our mailing list
 *
 * 7.0.01 - 2017-01-03 - Medium priority
 * Fixed a bug that caused the chat to disappear after being opened for some users
 * Changes made to the language files
 * PHPMailer has been updated to the latest version
 *
 * 7.0.00 - 2016-12-14 - Medium priority
 * Major performance improvements - 300% reduction in DB calls
 * Node Server Integration (Experimental)
 * Users no longer have to wait for an agent to answer a chat, they can start typing immediately
 * Users can send a request a new chat if a chat times out or an agent doesnt answer
 * Changed tabs in the settings page to be vertical
 * Removed deprecated functions
 * JavaScript errors fixed when using IE
 * Ability to enable a powered by link on the chat
 * Ability to enable/disable the visitor name and/or gravatar
 * Chat history page columns styling fixes
 * Ability to show the date and/or time in the chat window
 * Styling improvements made to the settings page
 * Ability to redirect to a thank you page after the chat has ended
 * You can now start a new chat after refreshing the page instead of waiting 24 hours
 * Fixed a bug that caused an error in the dashboard when using the PHP cloud server
 * Fixed the styling within the admin chat window to suit the theme chosen
 * Fixed a bug that caused duplicate loading of messages when the user started typing before the admin chat screen was open
 * Integrated with Contact Form Ready to allow for custom forms to be used for the offline message form
 * Google Analytics Integration
 * Ability to change the subject of the offline message
 * Ability to add custom CSS and JavaScript in the settings page
 *
 * 6.2.11 - 2016-10-27 - Medium Priority
 * Fixed a bug that caused issues with the User JS file when being minified
 * Fixed a bug that caused the 'Congratulations' message to never clear when using the Cloud Server
 * Fixed a bug that caused new TLD's to return invalid when starting a new chat
 * Fixed a variety of strings that were using the incorrect text domain
 * Italian translation updated - Thank you Angelo Giammarresi
 * HTML is now rendered in the Input replacement field of the Classic chat window
 *
 * 6.2.10 - 2016-10-18 - High priority for IE users
 * IE bug fix - fixed the bug that stopped the chat window from opening when clicking on it
 * Fixed the bug that caused user messages to not be sent on some websites due to non-unique function names being used in the md5.js file
 * Translations
 *   Italian translation updated - thank you Angelo Giammarresi and Eta Entropy and Denny Biasiolli
 *   Estonian translation added - thank you Joonas Kessel
 *   Chinese translation updated - thank you Wan Kit
 *   Missing translation strings added in all languages
 *
 * 6.2.09 - 2016-09-15 - High priority for cloud users
 * Further cloud server bug fixes
 *
 * 6.2.08 - 2016-09-15 - High priority for cloud users
 * Fixed a bug that caused no visitors to be displayed when using the cloud server
 *
 * 6.2.07 - 2016-09-15 - Medium priority
 * Fixed a bug that caused a fatal error on older PHP version
 *
 * 6.2.06 - 2016-09-14 - Medium Priority
 * Added Rest API functionality (Accept chat, end chat, get messages, send message, get sessions)
 * Added 'Device' type logging to live chat dashboard area.
 * Minified User Side JavaScript
 * Added Connection Handling (User), which will now retry to establish connection upon fail
 * Added Connection Handling (Admin), which will retry to establish connection upon fail
 * Fixed a PHP warning on the feedback page
 * Fixed a bug where offline strings weren't translating when localization option was checked
 *
 * 6.2.05 - 2016-08-19 - Medium priority
 * Added compatibility for Pro triggers
 * Added Classic Theme's Hovercard (Will only show with triggers)
 * Fixed a bug which prevented the online/offline mode to affect the 'start chat' button
 * Fixed Responsive issues with modern theme
 * Ability to delete individual Missed Chats
 * Ability to delete individual Chats from History
 * Minor Styling Conflicts Resolved
 * Fixed the bug that caused "start chat" to be added to the button in the live chat box when offline
 * Fixed a bug that showed slashes when apostrophes were used
 * Added various filters/actions for use in Pro
 * Added ability to open chat box using an elements ID/Class (Click/Hover)
 *
 * 6.2.04 - 2016-08-01 - High priority
 * Security patches in the offline message storing function (securify.nl/advisory/SFY20190709/stored_cross_site_scripting_vulnerability_in_wp_live_chat_support_wordpress_plugin.html)
 *
 * 6.2.03 - 2016-07-19 - Low priority
 * Italian translation updated - thank you Angelo Giammarresi
 * Fixed Danish translation bug
 * Minor UI fixes
 * Edge browser bug fix when opening chats
 *
 * 6.2.02 - 2016-07-11 - High priority
 * XSS Security patch - Thank you Han Sahin!
 *
 * 6.2.01 - 2016-07-07 - Low priority
 * Surveys/Polls added - you can now add a survey/poll to your chat box either before or after a chat session
 *
 * 6.2.00 - 2016-06-10 - High priority
 * Cloud server bug fix
 * Offline messages bug fix
 * Internet explorer and Edge browser bug fix which caused the chat to not display
 * Fixed the bug that stopped email addresses such as "name@domain.tld" from validating
 * Advanced options to control the long poll variables
 * Support added for many new pro features
 *
 * 6.1.02 - 2016-04-13 - Low Priority
 * Tested on WordPress 4.5
 * Fixed a bug that sent offline messages to the wrong email address
 *
 * 6.1.01 - 2016-04-07 - Low Priority
 * You can now delete inidividual offline messages from your history
 * Code improvements done to the way scripts are loaded when displaying the chat
 * Fixed a bug that returned an undefined index when recording a visitors IP address
 * Fixed a bug that displayed chat messages over the logo
 * Code improvement - A visitors name will display if filled out automatically, instead of 'Guest'
 * WHOIS for IP Address now opens in a new window
 * Fixed a bug that caused issues when downloading the chat history containing non UTF-8 characters
 * Fixed a bug that displayed the incorrect Gravatar images in the chat messages
 * Translations:
 *  - German Updated (Thank you Benjamin Schindler)
 *  - Brazilian Portuguese Updated (Thank you Luis Simioni)
 *  - Farsi Added(Thank you Maisam)
 *  - Norwegian Updated (Thank you Ole Petter Holthe-Berg)
 *  - Croatian Added(Thank you Petar Garzina)
 *  - Italian Updated (Thank you Angelo Giammarresi)
 *  - Danish Updated (Thank you Kasper Jensen)
 *  - Spanish Updated (Thank you Olivier Gantois)
 *  - French Updated (Thank you Olivier Gantois)
 *
 * 6.1.00 - 2016-03-18 - Medium priority
 * Fixed a bug that caused the chat agent to be nullified if you saved the settings
 * NEW: Introduced a new modern theme
 * Fixed the bug that caused the chat box to not open again if you minimized it while in chat
 * Fixed a style bug on the admin chat box
 * Performance improvements for the basic version - there are no longer regular longpoll requests when using the basic version. Long polling only starts once a chat has been started
 * Fixed a styling bug in the settings page
 * Longpoll requests no longer run when you're offline - this will introduce significant performance imporvements
 * We have removed the "X" on the chat box and it will now only show up when there is an active chat on the user's side. This avoids the confusion when the user presses "X" and the chat hides for 24 hours.
 * Images of the chat agent and user now show up correctly in the chat box
 * Fixed a bug that added slashes to apostrophes in the chat window
 * Fixed a bug that caused an error when trying to load the chat box when a banned user visited the site
 * Fixed a bug that still displayed the offline message window even if the setting was set to false
 *
 * 6.0.07 - 2016-03-11 - High priority
 * Bug fix - agent status was lost when saving settings
 *
 * 6.0.06 - 2016-03-04 - Medium priority
 * More stable fix for the menu item bug that has been experienced lately
 *
 * 6.0.05 - 2016-02-23 - Medium priority
 * Fixed the bug that caused the menu item to not display for some users
 *
 * 6.0.04 - 2016-02-16 - Low priority
 * Offline message bug fix with the cloud server extension
 * Choose when online bug fix
 * Agent bug fix
 * Styling adjustment for viewpots of 481px and below
 * All content now loaded and pushed via SSL links
 *
 * 6.0.03 - 2016-02-04 - Low priority
 * Fixed a bug that caused a warning if an incorrect IP address was in the banned IP address field
 * Offline messaging bug fixed
 *
 * 6.0.02 - 2016-02-03 - Low priority
 * Added a new filter to fix a bug with WP Live Chat Support - Advanced Chat Box Control Extension
 *
 * 6.0.01 - 2016-02-02 - High priority
 * Crucial bug fix that stopped the live chat from working in some instances
 * New filter to fix the bug with the WP Live Chat Choose When Online bug
 *
 * 6.0.00 -2016-01-26 - Freedom of Speech Update - Medium Priority
 * New functionality
 *  Unlimited simultaneous chats now available
 *  Offline messages are now available
 * Many new filters added
 * jQuery.cookie updated to version 2.1
 *
 * 5.0.14 - 2016-01-13 - High priority
 * Bug fix: When activating WP Live Chat Support, a table is created with a shared MySQL column name which caused issues on some servers. The column name has been changed
 *
 * 5.0.13 - 2016-01-05 - High priority
 * UTF8 encoding bug fixed
 *
 * 5.0.12 - 2016-01-04 - Low priority
 * Tested with WP 4.4
 *
 * 5.0.11 - 2015-10-14 - Low priority
 * Translation string changes
 *
 * 5.0.10 - 2015-10-12 - Low priority
 * Updates to the extension page
 *
 * 5.0.9
 * New hook: wplc_hook_admin_menu_layout - Target the area above the normal menu layout
 * Style bug fix with the "DATA" section of the live chat dashboard
 *
 * 5.0.8
 * Introduced new hooks:
 *  wplc_hook_admin_visitor_info_display_before - Allows you to add HTML at the beginning of the vistior details DIV in the live chat window
 *  wplc_hook_admin_visitor_info_display_after - Allows you to add HTML at the end of the vistior details DIV in the live chat window
 *  wplc_hook_admin_javascript_chat - Allows you to add Javascript enqueues at the end of the javascript section of the live chat window
 *  wplc_hook_admin_settings_main_settings_after - Allows you to add more options to the main chat settings table in the settings page, after the first main table
 *  wplc_hook_admin_settings_save - Hook into the save settings head section. i.e. where we handle POST data from the live chat settings page
 *
 * 5.0.7 - 2015-10-06 - Low priority
 * Added a live chat extension page
 * Corrected internationalization
 *
 * 5.0.6 - 2015-09-17 - Low priority
 * You can now choose to disable the sound that is played when a new live chat message is received
 * Fixed a bug that caused some live chat settings to revert back to default when updating the plugin
 *
 * 5.0.5 - 2015-09-09 - Low Priority
 * Fixed a bug that displayed an error message to update the live chat plugin while using the latest version (Pro)
 * Fixed a bug where the mobile detect class would only work if the Pro was enabled
 * Fixed a bug where the live chat window would move to the bottom left of the page when being minimized
 * You can now see the visitors IP address on the Live Chat dashboard
 * Alert message removed when a user was made a live chat agent on the settings page (Pro)
 * Fixed a bug that would prevent the user from typing if they had a previous live chat session (Pro)
 *
 * 5.0.4 - 2015-08-06 - Medium priority
 * WP Live Chat Support is now compatible with all caching plugins
 * Fixed a bug that set the wrong permissions for the default agent
 * Fixed the bug that shows the status of undefined if the user minimized the chat
 *
 *
 * 5.0.3 - 2015-08-05 - High Priority
 * Small bug fix
 *
 * 5.0.2 - 2015-08-05 - High Priority
 * Fixed a bug that caused a fatal error
 *
 * 5.0.1 - 2015-08-05 - Medium Priority
 * Refactored the code so that the live chat box will show up even if there is a JS error from another plugin or theme
 * Live chat box styling fixes: top image padding; centered the "conneting, please be patient" message and added padding
 * The live chat long poll connection will not automatically reinitialize if the connection times out or returns a 5xx error
 *
 * 5.0.0 - 2015-07-29 - Doppio update - Medium Priority
 * New, modern chat dashboard
 * Better user handling (chat long polling)
 * Added a welcome page to the live chat dashboard
 * The live hat dashboard is now fully responsive
 * You are now able to see who is a new visitor and who is a returning visitor
 * Bug fixes in the javascript that handles the live chat controls
 * Fixed the bug that stopped the chats from timing out after a certain amount of time
 *
 * 4.4.4 - 2015-07-20 - Low Priority
 * Bug Fix: Big fixed that would cause the live chat to timeout during a conversation
 *
 * 4.4.3 - 2015-07-16 - Low Priority
 * Bug Fix: Ajax URL undefined in some versions of WordPress
 * Improvement: Warning messages limited to the Settings page only
 *
 * 4.4.2 - 2015-07-13 - Low Priority
 * Improvement: Gravatar images will load on sites using SSL without any issues
 * Improvement: Hungarian live chat translation file name fixed
 * Improvement: Styling improvements on the live chat dashboard
 * New Translations:
 *  Turkish (Thank you Yavuz Aksu)
 *
 * 4.4.1 - 2015-07-08 - Critical Priority
 * Major security update. Please ensure you update to this version to eliminate previous vulnerabilities.
 *
 * 4.3.5 Espresso - 2015-07-03 - Low Priority
 * Enhancement: Provision made for live chat encryption in the Pro version (compatibility)
 * Updated Translations:
 *  Hungarian (Thank you Andor Molnar)
 *
 * 4.3.4 Ristretto - 2015-06-26 - Low Priority
 * Improvement: 404 errors for images in admin panel fixed
 * Translation Fix: Mistakes fixed in German Translation file.
 *
 * 4.3.3 2015-06-11 - Low Priority
 * Security enhancements
 * New Translations:
 *  Polish (Thank you Sebastian Kajzer)
 *
 * 4.3.2 2015-05-28 - Medium Priority
 * Bug Fix: Fixed PHP error
 *
 * 4.3.1 2015-05-22 - Low Priority
 * New Translations:
 *  Finnish (Thank you Arttu Piipponen)
 *
 * Translations Updated:
 *  French (Thank you Marcello Cavalucci)
 *  Dutch (Thank you Niek Groot Bleumink)
 *
 * Bug Fix: Exclude Functionality (Pro)
 *
 * 4.3.0 2015-04-13 - Low Priority
 * Enhancement: Animations settings have been moved to the 'Styling' tab.
 * New Feature: Blocked User functionality has been moved to the Free version
 * Enhancement: All descriptions have been put into tooltips for a cleaner page
 * New Feature: Functionality added in to handle Chat Experience Ratings (Premium Add-on)
 *
 * 4.2.12 2015-03-24 - Low Priority
 * Bug Fix: Warning to update showing erroneously
 *
 * 4.2.11 2015-03-23 - Low Priority
 * Bug Fix: Bug in the banned user functionality
 * Enhancement: Stying improvement on the Live Chat dashboard
 * Enhancement: Strings are handled better for localization plugins (Pro)
 * Updated Translation Files:
 *  Spanish (Thank you Ana Ayelen Martinez)
 *
 * 4.2.10 2015-03-16 - Low Priority
 * Bug Fix: Mobile Detect class caused Fatal error on some websites
 * Bug Fix: PHP Errors when editing user page
 * Bug Fix: Including and Excluding the chat window caused issues on some websites
 * Bug Fix: Online/Offline Toggle Switch did not work in some browsers (Pro)
 * New Feature: You can now Ban visitors from chatting with you based on IP Address (Pro)
 * New Feature: You can now choose if you want users to make themselves an agent (Pro)
 * Bug Fix: Chat window would not hide when selecting the option to not accept offline messages (Pro)
 * Enhancement: Support page added
 * Updated Translations:
 *  French (Thank you Marcello Cavallucci)
 * New Translations added:
 *  Norwegian (Thank you Robert Nilsen)
 *  Hungarian (Thank you GInception)
 *  Indonesian (Thank you Andrie Willyanta)
 *
 * 4.2.9 2015-02-18 - Low Priority
 * New Feature: You can now choose to record your visitors IP address or not
 * New Feature: You can now send an offline message to more than one email address (Pro)
 * New Feature: You can now specify if you want to be online or not (Pro)
 *
 * 4.2.8 2015-02-12 - Low Priority
 * New Feature: You can now apply an animation to the chat window on page load
 * New Feature: You can now choose from 5 colour schemes for the chat window
 * Enhancement: Aesthetic Improvement to list of agents (Pro)
 * Code Improvement: PHP error fixed
 * Updated Translations:
 *  German (Thank you Dennis Klinger)
 *
 * 4.2.7 2015-02-10 - Low Priority
 * New Live Chat Translation added:
 *  Greek (Thank you Peter Stavropoulos)
 *
 * 4.2.6 2015-01-29 - Low Priority
 * New feature: Live Chat dashboard has a new layout and design
 * Code Improvement: jQuery Cookie updated to the latest version
 * Code Improvement: More Live Chat strings are now translatable
 * New Live Chat Translation added:
 *  Spanish (Thank you Ana Ayel�n Mart�nez)
 *
 *
 * 4.2.5 2015-01-21 - Low Priority
 * New Feature: You can now view any live chats you have missed
 * New Pro Feature: You can record offline messages when live chat is not online
 * Code Improvements: Labels added to buttons
 * Code Improvements: PHP Errors fixed
 *
 * Updated Translations:
 *  Italian (Thank You Angelo Giammarresi)
 *
 * 4.2.4 2014-12-17 - Low Priority
 * New feature: The chat window can be hidden when offline (Pro only)
 * New feature: Desktop notifications added
 * Bug fix: Email address gave false validation error when not required.
 *
 * Translations Added:
 * Dutch (Thank you Elsy Aelvoet)
 *
 *
 * 4.2.3 2014-12-11 - Low Priority
 * Updated Translations:
 * French (Thank you Marcello Cavallucci)
 * Italian (Thank You Angelo Giammarresi)
 *
 * 4.2.2 2014-12-10 - Low Priority
 * New feature: You can now toggle between displaying or hiding the users name in your Live Chat messages
 * New feature: You can now choose to display the Live Chat window to all or only registered users
 * New feature: A user image will now display in the Live Chat message
 * Code Improvement: jQuery UI CSS is loaded from a local source
 * Bug Fix: Only Admin users can make users Live Chat agents
 *
 * Translations added:
 * Mongolian (Thank you Monica Batuskh)
 * Romanian (Thank you Sergiu Balaes)
 * Czech (Thank you Pavel Cvejn)
 * Danish (Thank you Mikkel Jeppesen Juhl)
 *
 * Updated Translations:
 * German (Thank you Dennis Klinger)
 *
 * 4.2.1 2014-11-24 - High Priority
 * Bug Fix: PHP Error on agent side in chat window
 *
 *
 * 4.2.0 2014-11-20 - Medium priority
 * Chat UI Improvements
 * Small bug fixes
 *
 * 4.1.10 2014-10-29 - Low priority
 * Code Improvements: (Checks for DONOTCACHE)
 * New Pro Feature: You can now include or exclude the chat window on certain pages
 *
 * 4.1.9 2014-10-10 - Low priority
 * Bug fix: Mobile Detect class caused an error if it existed in another plugin or theme. A check has been put in place.
 *
 * 4.1.8 2014-10-08 - Low priority
 * New feature: There is now an option if you do not require the user to input their name and email address before sending a chat request
 * New feature: Logged in users do not have to enter their details prior to sending the chat request.
 * New feature: Turn the chat on/off on a mobile device (smart phone and tablets)
 *
 * 4.1.7 2014-10-06 - Low priority
 * Bug fix: sound was not played when user received a message from the admin
 * Internationalization update
 * New WP Live Chat Support Translation added:
 *  * Swedish (Thank You Tobias Sernhede)
 *  * French (Thank You Marcello Cavallucci)
 *
 *
 * 4.1.6
 * Code improvements (JavaScript errors fixed in IE)
 * New WP Live Chat Support Translations Added:
 *  * Slovakian (Thank You Dana Kadarova)
 *  * German (Thank You Dennis Klingr)
 *  * Hebrew (Thank You David Cohen)
 *
 * 4.1.5
 * Code improvements (PHP warnings - set_time_limit caused warnings on some hosts)
 *
 * 4.1.4
 * Significant performance improvements
 * Brazilian translation added - thank you Gustavo Silva
 *
 * 4.1.3
 * Code improvements (PHP warnings)
 *
 * 4.1.2
 * DB bug fix
 *
 * 4.1.1
 * Significant performance improvements
 * Live chat window will now only show in one window (if user has multiple tabs open on your site)
 * You can now see the browser of the live chat user
 * Improved the UI of the backend
 * Bug fixes
 *
 * 4.1.0
 * New feature: You can now show the chat box on the left or right
 * Vulnerability fix (JS injections). Thank you Patrik @ www.it-securityguard.com
 * Fixed 403 bug when saving settings
 * Fixed Ajax Time out error (Lowered From 90 to 28)
 * Fixed IE8 bug
 * Added option to auto pop up chat window
 * Added Italian language files. Thanks to Davide
 *
 */

//error_reporting(E_ERROR);
global $wplc_version;
global $wplc_p_version;
global $wplc_tblname;
global $wpdb;
global $wplc_tblname_chats;
global $wplc_tblname_msgs;
global $wplc_tblname_offline_msgs;

/**
 * This stores the admin chat data once so that we do not need to keep sourcing it via the WP DB or Cloud DB
 */
global $admin_chat_data;
$admin_chat_data = false;

global $debug_start;

$wplc_tblname_offline_msgs = $wpdb->prefix . "wplc_offline_messages";
$wplc_tblname_chats = $wpdb->prefix . "wplc_chat_sessions";
$wplc_tblname_msgs = $wpdb->prefix . "wplc_chat_msgs";
$wplc_version = "8.0.14";

define('WPLC_BASIC_PLUGIN_DIR', dirname(__FILE__));
define('WPLC_BASIC_PLUGIN_URL', plugins_url( '/', __FILE__ ) );
define('WPLC_PLUGIN', plugin_basename( __FILE__ ) );
global $wplc_basic_plugin_url;
$wplc_basic_plugin_url = WPLC_BASIC_PLUGIN_URL;


global $wplc_pro_version;
$wplc_ver = str_replace('.', '', $wplc_pro_version);
$checker = intval($wplc_ver);
if (function_exists("wplc_pro_version_control") && $checker < 6000) { } else {
    require_once (plugin_dir_path(__FILE__) . "ajax_new.php");
}

require_once (plugin_dir_path(__FILE__) . "functions.php");
require_once (plugin_dir_path(__FILE__) . "includes/deprecated.php");
require_once (plugin_dir_path(__FILE__) . "includes/surveys.php");
require_once (plugin_dir_path(__FILE__) . "includes/notification_control.php");
require_once (plugin_dir_path(__FILE__) . "includes/modal_control.php");
require_once (plugin_dir_path(__FILE__) . "modules/documentation_suggestions.php");
require_once (plugin_dir_path(__FILE__) . "modules/offline_messages_custom_fields.php");
require_once (plugin_dir_path(__FILE__) . "modules/google_analytics.php");
require_once (plugin_dir_path(__FILE__) . "modules/api/wplc-api.php");
require_once (plugin_dir_path(__FILE__) . "modules/beta_features.php");
require_once (plugin_dir_path(__FILE__) . "modules/node_server.php");
require_once (plugin_dir_path(__FILE__) . "modules/module_gif.php");
require_once (plugin_dir_path(__FILE__) . "includes/update_control.class.php");
require_once (plugin_dir_path(__FILE__) . "modules/webhooks_manager.php");
require_once (plugin_dir_path(__FILE__) . "modules/privacy.php");

// Gutenberg Blocks
require_once (plugin_dir_path(__FILE__) . "includes/blocks/wplc-chat-box/index.php");
require_once (plugin_dir_path(__FILE__) . "includes/blocks/wplc-inline-chat-box/index.php");

// Shortcodes
require_once (plugin_dir_path(__FILE__) . "includes/shortcodes.php");

add_action( 'wp_ajax_wplc_admin_set_transient', 'wplc_action_callback' );
add_action( 'wp_ajax_wplc_admin_remove_transient', 'wplc_action_callback' );
add_action( 'wp_ajax_wplc_hide_ftt', 'wplc_action_callback' );
add_action( 'wp_ajax_nopriv_wplc_user_send_offline_message', 'wplc_action_callback' );
add_action( 'wp_ajax_wplc_user_send_offline_message', 'wplc_action_callback' );
add_action( 'wp_ajax_delete_offline_message', 'wplc_action_callback' );
add_action( 'wp_ajax_wplc_a2a_dismiss', 'wplc_action_callback' );
add_action( 'init', 'wplc_version_control' );
add_action( "activated_plugin", "wplc_redirect_on_activate" );
add_action( 'wp_footer', 'wplc_display_box' );
add_action( 'init', 'wplc_init' );



if (function_exists('wplc_head_pro')) {
    add_action('admin_init', 'wplc_head_pro');
} else {
    add_action('admin_init', 'wplc_head_basic');
}

add_action('wp_enqueue_scripts', 'wplc_add_user_stylesheet');
add_action('admin_enqueue_scripts', 'wplc_add_admin_stylesheet');

if (function_exists('wplc_admin_menu_pro')) {
    add_action('admin_menu', 'wplc_admin_menu_pro');
} else {
    add_action('admin_menu', 'wplc_admin_menu', 4);
}
add_action('admin_head', 'wplc_superadmin_javascript');
register_activation_hook(__FILE__, 'wplc_activate');


function wplc_basic_check() {
    // check if basic exists if pro is installed
}

function wplc_init() {
    $plugin_dir = basename(dirname(__FILE__)) . "/languages/";
    load_plugin_textdomain('wplivechat', false, $plugin_dir);


}


/**
 * Redirect the user to the welcome page on plugin activate
 * @param  string $plugin
 * @return void
 */
function wplc_redirect_on_activate( $plugin ) {

	if( $plugin == plugin_basename( __FILE__ ) ) {
		if (get_option("WPLC_V8_FIRST_TIME") == true) {
	    	update_option("WPLC_V8_FIRST_TIME",false);
	    	// clean the output header and redirect the user
	    	@ob_flush();
			@ob_end_flush();
			@ob_end_clean();
	    	exit( wp_redirect( admin_url( 'admin.php?page=wplivechat-menu&action=welcome' ) ) );
	    }
	}
}


add_action( 'admin_init', 'wplc_redirect_on_activate' );



function wplc_version_control() {

    global $wplc_version;


    $current_version = get_option("wplc_current_version");
    if (!isset($current_version) || $current_version != $wplc_version) {

    	$wplc_settings = get_option( 'WPLC_SETTINGS' );

    	/**
    	 * Are we updating from a version before version 8?
    	 * If yes, set NODE to enabled
    	 */
    	if ( isset( $current_version ) ) {
    		$main_ver = intval( $current_version[0] );
    		if ( $main_ver < 8 ) {
    			if ( $wplc_settings ) {
    				$wplc_settings['wplc_use_node_server'] = 1;

    				update_option( "WPLC_V8_FIRST_TIME", true );

    			}
    		}

    	}


        $admins = get_role('administrator');
        if( $admins !== null ) {
        	$admins->add_cap('wplc_ma_agent');
        }

        $uid = get_current_user_id();
        update_user_meta($uid, 'wplc_ma_agent', 1);
        update_user_meta($uid, "wplc_chat_agent_online", time());

        /*$wplc_super_admins = get_super_admins();

        foreach( $wplc_super_admins as $super_admin ){

          $user = get_user_by( 'login', $super_admin );

          $wplc_super_admin_id = $user->ID;

          update_user_meta( $wplc_super_admin_id, 'wplc_ma_agent', 1);
          update_user_meta( $wplc_super_admin_id, "wplc_chat_agent_online", time());

          break;

        }
        */


        /* add caps to admin */
        if (current_user_can('manage_options')) {
            global $user_ID;
            $user = new WP_User($user_ID);
            foreach ($user->roles as $urole) {
                if ($urole == "administrator") {
                    $admins = get_role('administrator');
                    $admins->add_cap('edit_wplc_quick_response');
                    $admins->add_cap('edit_wplc_quick_response');
                    $admins->add_cap('edit_other_wplc_quick_response');
                    $admins->add_cap('publish_wplc_quick_response');
                    $admins->add_cap('read_wplc_quick_response');
                    $admins->add_cap('read_private_wplc_quick_response');
                    $admins->add_cap('delete_wplc_quick_response');
                }
            }
        }



	    if (!isset($wplc_settings['wplc_pro_na'])) { $wplc_settings["wplc_pro_na"] = __("Chat offline. Leave a message", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_intro'])) { $wplc_settings["wplc_pro_intro"] = __("Hello. Please input your details so that I may help you.", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_offline1'])) { $wplc_settings["wplc_pro_offline1"] = __("We are currently offline. Please leave a message and we'll get back to you shortly.", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_offline2'])) { $wplc_settings["wplc_pro_offline2"] =  __("Sending message...", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_offline3'])) { $wplc_settings["wplc_pro_offline3"] = __("Thank you for your message. We will be in contact soon.", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_offline_btn']) || (isset($wplc_settings['wplc_pro_offline_btn']) && $wplc_settings['wplc_pro_offline_btn'] == "")) { $wplc_settings["wplc_pro_offline_btn"] = __("Leave a message", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_offline_btn_send']) || (isset($wplc_settings['wplc_pro_offline_btn_send']) && $wplc_settings['wplc_pro_offline_btn_send'] == "")) { $wplc_settings["wplc_pro_offline_btn_send"] = __("Send message", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_fst1'])) { $wplc_settings["wplc_pro_fst1"] = __("Questions?", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_fst2'])) { $wplc_settings["wplc_pro_fst2"] = __("Chat with us", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_fst3'])) { $wplc_settings["wplc_pro_fst3"] = __("Start live chat", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_sst1'])) { $wplc_settings["wplc_pro_sst1"] = __("Start Chat", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_sst1_survey'])) { $wplc_settings["wplc_pro_sst1_survey"] = __("Or chat to an agent now", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_sst1e_survey'])) { $wplc_settings["wplc_pro_sst1e_survey"] = __("Chat ended", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_sst2'])) { $wplc_settings["wplc_pro_sst2"] = __("Connecting. Please be patient...", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_pro_tst1'])) { $wplc_settings["wplc_pro_tst1"] = __("Reactivating your previous chat...", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_user_welcome_chat'])) { $wplc_settings["wplc_user_welcome_chat"] = __("Welcome. How may I help you?", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_welcome_msg'])) { $wplc_settings['wplc_welcome_msg'] = __("Please standby for an agent. While you wait for the agent you may type your message.","wplivechat"); }
	    if (!isset($wplc_settings['wplc_user_enter'])) { $wplc_settings["wplc_user_enter"] = __("Press ENTER to send your message", "wplivechat"); }
	    if (!isset($wplc_settings['wplc_close_btn_text'])) { $wplc_settings["wplc_close_btn_text"] = __("close", "wplivechat"); }


        if (!isset($wplc_settings['wplc_powered_by_link'])) { $wplc_settings["wplc_powered_by_link"] = "0"; }



        /* users who are updating will stay on the  existing theme */
        if (get_option("WPLC_V8_FIRST_TIME")) {} else {
          if (!isset($wplc_settings['wplc_newtheme'])) { $wplc_settings["wplc_newtheme"] = "theme-2"; }
        }


        if (!isset($wplc_settings['wplc_settings_color1'])) { $wplc_settings["wplc_settings_color1"] = "ED832F"; }
        if (!isset($wplc_settings['wplc_settings_color2'])) { $wplc_settings["wplc_settings_color2"] = "FFFFFF"; }
        if (!isset($wplc_settings['wplc_settings_color3'])) { $wplc_settings["wplc_settings_color3"] = "EEEEEE"; }
        if (!isset($wplc_settings['wplc_settings_color4'])) { $wplc_settings["wplc_settings_color4"] = "666666"; }



        if (!isset($wplc_settings['wplc_settings_align'])) { $wplc_settings["wplc_settings_align"] = 2; }

        if (!isset($wplc_settings['wplc_settings_enabled'])) { $wplc_settings["wplc_settings_enabled"] = 1; }

        if (!isset($wplc_settings['wplc_settings_fill'])) { $wplc_settings["wplc_settings_fill"] = "ed832f"; }

        if (!isset($wplc_settings['wplc_settings_font'])) { $wplc_settings["wplc_settings_font"] = "FFFFFF"; }

        if (!isset($wplc_settings['wplc_preferred_gif_provider'])) { $wplc_settings["wplc_preferred_gif_provider"] = 1; }
        if (!isset($wplc_settings['wplc_giphy_api_key'])) { $wplc_settings["wplc_giphy_api_key"] = ""; }
        if (!isset($wplc_settings['wplc_tenor_api_key'])) { $wplc_settings["wplc_tenor_api_key"] = ""; }

        wplc_handle_db();
        update_option("wplc_current_version", $wplc_version);


        if (!isset($wplc_settings['wplc_require_user_info'])) { $wplc_settings['wplc_require_user_info'] = "1"; }
	    if (!isset($wplc_settings['wplc_user_default_visitor_name'])) {
		    $wplc_default_visitor_name = __( "Guest", "wplivechat" );
		    $wplc_settings['wplc_user_default_visitor_name'] = $wplc_default_visitor_name;
	    }
        if (!isset($wplc_settings['wplc_loggedin_user_info'])) { $wplc_settings['wplc_loggedin_user_info'] = "1"; }
        if (!isset($wplc_settings['wplc_user_alternative_text'])) {
            $wplc_alt_text = __("Please click \'Start Chat\' to initiate a chat with an agent", "wplivechat");
            $wplc_settings['wplc_user_alternative_text'] = $wplc_alt_text;
        }
        if (!isset($wplc_settings['wplc_enabled_on_mobile'])) { $wplc_settings['wplc_enabled_on_mobile'] = "1"; }
        if(!isset($wplc_settings['wplc_record_ip_address'])){ $wplc_settings['wplc_record_ip_address'] = "0"; }
        if(!isset($wplc_settings['wplc_enable_msg_sound'])){ $wplc_settings['wplc_enable_msg_sound'] = "1"; }
	    if(!isset($wplc_settings['wplc_enable_font_awesome'])){ $wplc_settings['wplc_enable_font_awesome'] = "1"; }
	    if(!isset($wplc_settings['wplc_using_localization_plugin'])){ $wplc_settings['wplc_using_localization_plugin'] = 0; }

	    $wplc_settings = apply_filters('wplc_update_settings_between_versions_hook', $wplc_settings); //Added in 8.0.09

        update_option("WPLC_SETTINGS", $wplc_settings);

        do_action("wplc_update_hook");
    }



}

add_action("wplc_hook_set_transient","wplc_hook_control_set_transient",10);
function wplc_hook_control_set_transient() {
  $should_set_transient = apply_filters("wplc_filter_control_set_transient",true);
  if ($should_set_transient) {
    set_transient("wplc_is_admin_logged_in", "1", 70);
  }
}

add_action("wplc_hook_remove_transient","wplc_hook_control_remove_transient",10);
function wplc_hook_control_remove_transient() {
  delete_transient('wplc_is_admin_logged_in');
}

function wplc_action_callback() {
    global $wpdb;
    global $wplc_tblname_chats;
    $check = check_ajax_referer('wplc', 'security');

    if ($check == 1) {

		if( $_POST['action'] == 'wplc_a2a_dismiss' ){
			$uid = get_current_user_id();
    		update_user_meta($uid, 'wplc_a2a_upsell', 1);
		}

    	if( $_POST['action'] == 'delete_offline_message' ){

    		global $wplc_tblname_offline_msgs;

    		$mid = sanitize_text_field( $_POST['mid'] );

    		$sql = "DELETE FROM `$wplc_tblname_offline_msgs` WHERE `id` = '$mid'";
    		$query = $wpdb->Query($sql);

    		if( $query ){

    			echo 1;

    		}

    	}

        if ($_POST['action'] == "wplc_user_send_offline_message") {
            if(function_exists('wplc_send_offline_msg')){ wplc_send_offline_msg($_POST['name'], $_POST['email'], $_POST['msg'], $_POST['cid']); }
            if(function_exists('wplc_store_offline_message')){ wplc_store_offline_message($_POST['name'], $_POST['email'], $_POST['msg']); }
            do_action("wplc_hook_offline_message",array(
              "cid"=>$_POST['cid'],
              "name"=>$_POST['name'],
              "email"=>$_POST['email'],
              "url"=>get_site_url(),
              "msg"=>$_POST['msg']
              )
            );
        }
        if ($_POST['action'] == "wplc_admin_set_transient") {
            do_action("wplc_hook_set_transient");

        }
        if ($_POST['action'] == "wplc_admin_remove_transient") {
            do_action("wplc_hook_remove_transient");

        }
        if ($_POST['action'] == 'wplc_hide_ftt') {
            update_option("WPLC_FIRST_TIME_TUTORIAL",true);
        }
        do_action("wplc_hook_action_callback");
    }
    die(); // this is required to return a proper result
}



/**
 * Decide who gets to see the various main menus (left navigation)
 * @return array
 * @since  6.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
add_filter("wplc_ma_filter_menu_control","wplc_filter_control_menu_control",10,1);
function wplc_filter_control_menu_control() {
    $array = array(
      0 => 'read', /* main menu */
      1 => 'read', /* settings */
      2 => 'read', /* history */
      3 => 'read', /* missed chats */
      4 => 'read', /* offline messages */
      5 => 'read', /* feedback */
      6 => 'read' /* surveys */
      );
    return $array;
}

function wplc_admin_menu() {

    $cap = apply_filters("wplc_ma_filter_menu_control",array());
    if ( get_option("wplc_seen_surveys") ) { $survey_new = ""; } else { $survey_new = ' <span class="update-plugins"><span class="plugin-count">New</span></span>'; }

    $wplc_current_user = get_current_user_id();

    /* If user is either an agent or an admin, access the page. */
    if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true ) || current_user_can("wplc_ma_agent")){
      $wplc_mainpage = add_menu_page('WP Live Chat', __('Live Chat', 'wplivechat'), $cap[0], 'wplivechat-menu', 'wplc_admin_menu_layout', 'dashicons-format-chat');
      add_submenu_page('wplivechat-menu', __('Settings', 'wplivechat'), __('Settings', 'wplivechat'), $cap[1], 'wplivechat-menu-settings', 'wplc_admin_settings_layout');
      add_submenu_page('wplivechat-menu', __('Surveys', 'wplivechat'), __('Surveys', 'wplivechat'). $survey_new, $cap[2], 'wplivechat-menu-survey', 'wplc_admin_survey_layout');
    }

    //Only if pro is not active
    if(!function_exists("wplc_pro_reporting_page")){
    	add_submenu_page('wplivechat-menu', __('Reporting', 'wplivechat'), __('Reporting', 'edit_posts') . ' <span class="update-plugins"><span class="plugin-count">Pro</span></span>', $cap[0], 'wplc-basic-reporting', 'wplc_basic_reporting_page');
    }


    //Only if pro is not active
    if(!function_exists("wplc_pro_triggers_page")){
    	add_submenu_page('wplivechat-menu', __('Triggers', 'wplivechat'), __('Triggers', 'edit_posts') . ' <span class="update-plugins"><span class="plugin-count">Pro</span></span>', $cap[0], 'wplc-basic-triggers', 'wplc_basic_triggers_page');
    }

    /* only if user is both an agent and an admin that has the cap assigned, can they access these pages */
    if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true ) && current_user_can("wplc_ma_agent")){

      add_submenu_page('wplivechat-menu', __('History', 'wplivechat'), __('History', 'wplivechat'), $cap[2], 'wplivechat-menu-history', 'wplc_admin_history_layout');
      add_submenu_page('wplivechat-menu', __('Missed Chats', 'wplivechat'), __('Missed Chats', 'wplivechat'), $cap[3], 'wplivechat-menu-missed-chats', 'wplc_admin_missed_chats');

      /* TO DO
      Add a hook here so that the other plugins can add to the menu
      Also make sure the function below is controled differently as the pro will not longer exist
      */

      if (function_exists("wplc_admin_menu_pro")) {
        global $wplc_pro_version;
        if (intval(str_replace(".","",$wplc_pro_version)) <= 5100) {
          /* do nothing as they have the pro active and their version of the pro makes use of offline messages */

        } else {
            add_submenu_page('wplivechat-menu', __('Offline Messages', 'wplivechat'), __('Offline Messages', 'wplivechat'), $cap[4], 'wplivechat-menu-offline-messages', 'wplc_admin_offline_messages');
        }
      } else {
            add_submenu_page('wplivechat-menu', __('Offline Messages', 'wplivechat'), __('Offline Messages', 'wplivechat'), $cap[4], 'wplivechat-menu-offline-messages', 'wplc_admin_offline_messages');

      }
      do_action("wplc_hook_menu_mid",$cap);


      add_submenu_page('wplivechat-menu', __('Support', 'wplivechat'), __('Support', 'wplivechat'), 'manage_options', 'wplivechat-menu-support-page', 'wplc_support_menu');
      add_submenu_page('wplivechat-menu', __('Extensions', 'wplivechat'), __('Extensions', 'wplivechat'), 'manage_options', 'wplivechat-menu-extensions-page', 'wplc_extensions_menu');
    }
    do_action("wplc_hook_menu");
}


add_action("wplc_hook_menu","wplc_hook_control_menu");
function wplc_hook_control_menu() {
  $check = apply_filters("wplc_filter_menu_api",0);
  if ($check > 0) {
      add_submenu_page('wplivechat-menu', __('API Keys', 'wplivechat'), __('API Keys', 'wplivechat'), 'manage_options', 'wplivechat-menu-api-keys-page', 'wplc_api_keys_menu');
   }
}


function wplc_api_keys_menu() {
  $page_content = "<h1>".__("Premium Extension API Keys","wplivechat")."</h3>";
  $page_content .= "<p>".__("To find and manage your premium API keys, please visit your <a target='_BLANK' href='https://wp-livechat.com/my-account/'>my account</a> page.","")."</p>";

  $page_content .= "<hr />";
  $page_content = apply_filters("wplc_filter_api_page",$page_content);


  echo $page_content;
}


add_action("wp_head","wplc_load_user_js",0);


function wplc_load_user_js () {
    if (!is_admin()) {
        if (in_array($GLOBALS['pagenow'], array('wp-login.php', 'wp-register.php'))) {
             return false;
        }


        if(function_exists('wplc_display_chat_contents')){
            $display_contents = wplc_display_chat_contents();
        } else {
            $display_contents = 1;
        }

        if(function_exists('wplc_is_user_banned_basic')){
            $user_banned = wplc_is_user_banned_basic();
        } else {
            $user_banned = 0;
        }
        $display_contents = apply_filters("wplc_filter_display_contents",$display_contents);

        if($display_contents && $user_banned == 0){

            /* do not show if pro is outdated */
            global $wplc_pro_version;
            if (isset($wplc_pro_version)) {
                $float_version = floatval($wplc_pro_version);
                if ($float_version < 4 || $wplc_pro_version == "4.1.0" || $wplc_pro_version == "4.1.1") {
                    return;
                }
            }

            $wplc_settings = get_option("WPLC_SETTINGS");
            if (!class_exists('Mobile_Detect')) {
                require_once (plugin_dir_path(__FILE__) . 'includes/Mobile_Detect.php');
            }
            $wplc_detect_device = new Mobile_Detect;
            $wplc_is_mobile = $wplc_detect_device->isMobile();

            if ($wplc_is_mobile && isset($wplc_settings['wplc_enabled_on_mobile']) && $wplc_settings['wplc_enabled_on_mobile'] == '0') {
                return;
            }

            if (function_exists("wplc_register_pro_version")) {
                if (function_exists('wplc_basic_hide_chat_when_offline')) {
                    $wplc_hide_chat = wplc_basic_hide_chat_when_offline();
                    if (!$wplc_hide_chat) {
                        if (function_exists("wplc_push_js_to_front_pro")) {
                            wplc_push_js_to_front_pro();
                        }
                    }
                } else {
                    if (function_exists("wplc_push_js_to_front_pro")) {
                        wplc_push_js_to_front_pro();
                    }
                }
            } else {
                wplc_push_js_to_front_basic();
            }
        }
    }





}

function wplc_push_js_to_front_basic() {
    global $wplc_is_mobile;
    global $wplc_version;

	wp_register_script('wplc-user-jquery-cookie', plugins_url('/js/jquery-cookie.js', __FILE__), array('jquery'),false, false);
	wp_enqueue_script('wplc-user-jquery-cookie');

    wp_enqueue_script('jquery');

    $wplc_settings = get_option("WPLC_SETTINGS");
	$wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");
	$wplc_ga_enabled = get_option("WPLC_GA_SETTINGS");

    if (isset($wplc_settings['wplc_display_to_loggedin_only']) && $wplc_settings['wplc_display_to_loggedin_only'] == 1) {
        /* Only show to users that are logged in */
        if (!is_user_logged_in()) {
            return;
        }
    }

    /* is the chat enabled? */
    if ($wplc_settings["wplc_settings_enabled"] == 2) { return; }

    wp_register_script('wplc-md5', plugins_url('/js/md5.js', __FILE__),array('wplc-user-script'),$wplc_version);
    wp_enqueue_script('wplc-md5');
    if (isset($wplc_settings['wplc_display_name']) && $wplc_settings['wplc_display_name'] == 1) {
        $wplc_display = 'display';
    } else {
        $wplc_display = 'hide';
    }


    if (isset($wplc_settings['wplc_enable_msg_sound']) && intval($wplc_settings['wplc_enable_msg_sound']) == 1) { $wplc_ding = '1'; } else { $wplc_ding = '0'; }

    $ajax_nonce = wp_create_nonce("wplc");
    if (!function_exists("wplc_register_pro_version")) {
        $ajaxurl = admin_url('admin-ajax.php');
        $wplc_ajaxurl = $ajaxurl;
    }


	wp_register_script('wplc-server-script', plugins_url('/js/wplc_server.js', __FILE__), array('jquery'), $wplc_version);
 	wp_enqueue_script('wplc-server-script');

 	wp_localize_script( 'wplc-server-script', 'wplc_datetime_format', array(
 		'date_format' => get_option( 'date_format' ),
		'time_format' => get_option( 'time_format' ),
	) );

 	if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1){
    	wp_localize_script('wplc-server-script', 'wplc_use_node_server', "true");

    	$wplc_node_token = get_option("wplc_node_server_secret_token");
    	if(!$wplc_node_token){
	    	if(function_exists("wplc_node_server_token_regenerate")){
		        wplc_node_server_token_regenerate();
		        $wplc_node_token = get_option("wplc_node_server_secret_token");
		    }
		}
    	wp_localize_script('wplc-server-script', 'bleeper_api_key', $wplc_node_token);



	 	$wplc_end_point_override = get_option("wplc_end_point_override");
	    if($wplc_end_point_override !== false && $wplc_end_point_override !== ""){
	    	$bleeper_url = $wplc_end_point_override; //Use the override URL
	    } else {
	    	$bleeper_url = BLEEPER_NODE_SERVER_URL;
	    }
		//wp_register_script('wplc-node-server-script', trailingslashit( $bleeper_url ) . "socket.io/socket.io.js", array('jquery'), $wplc_version);
		wp_register_script('wplc-node-server-script', "https://bleeper.io/app/assets/js/vendor/socket.io/socket.io.slim.js", array('jquery'), $wplc_version);


		//wp_register_script('wplc-node-server-script', 'http://localhost:3000/socket.io/socket.io.js', array('jquery'), $wplc_version);
 		wp_enqueue_script('wplc-node-server-script');
 		wp_register_script('wplc-user-events-script', plugins_url('/js/wplc_u_node_events.js', __FILE__),array('jquery', 'wplc-server-script'),$wplc_version);

 		wp_localize_script('wplc-server-script', 'bleeper_override_upload_url', rest_url( 'wp_live_chat_support/v1/remote_upload' ) );

 		/** DEPRECATED BY GDPR */
 		/*if(isset($wplc_settings['wplc_record_ip_address']) && $wplc_settings['wplc_record_ip_address'] == 1) {
             $ip_address = false;
            if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') { $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR']; } else { $ip_address = $_SERVER['REMOTE_ADDR']; }

            if($ip_address !== false){
                wp_localize_script('wplc-server-script', 'bleeper_user_ip_address', $ip_address);
            }
        }*/

		$wplc_server_location = get_option( "wplc_server_location" );
		$wplc_server_location = apply_filters('wplc_node_server_default_selection_override', $wplc_server_location, $wplc_settings);

        if( $wplc_server_location !== false && $wplc_server_location !== "" && $wplc_server_location !== "auto" ){
        	if ( $wplc_server_location === "us1") { $wplc_server_location = "0"; }
        	else if ( $wplc_server_location === "us2") { $wplc_server_location = "3"; }
        	else if ( $wplc_server_location === "eu1") { $wplc_server_location = "1"; }
        	else if ( $wplc_server_location === "eu2") { $wplc_server_location = "2"; }
        	else { $wplc_server_location = "0"; }
        	wp_localize_script( 'wplc-server-script', 'bleeper_server_location', $wplc_server_location );
        }


        $wplc_end_point_override = get_option("wplc_end_point_override");
        if($wplc_end_point_override !== false && $wplc_end_point_override !== ""){
        	wp_localize_script( 'wplc-server-script', 'bleeper_end_point_override', $wplc_end_point_override );
        }
        //For node verification
        if(function_exists("wplc_pro_activate")){
            wp_localize_script('wplc-server-script', 'bleeper_pro_auth', get_option('wp-live-chat-support-pro_key', "false"));
        } else {
            wp_localize_script('wplc-server-script', 'bleeper_pro_auth', 'false');
        }



 		//Emoji Libs
		if(empty($wplc_settings['wplc_disable_emojis'])) {
			//wp_register_script('wplc-user-js-emoji', "https://bleeper.io/app/assets/wdt-emoji/emoji.min.js", array("wplc-server-script", "wplc-server-script"), $wplc_version, false);
			//wp_enqueue_script('wplc-user-js-emoji');
			//wp_register_script('wplc-user-js-emoji-bundle', "https://bleeper.io/app/assets/wdt-emoji/wdt-emoji-bundle.min.js", array("wplc-server-script", "wplc-server-script", "wplc-user-js-emoji"), $wplc_version, false);
			//wp_enqueue_script('wplc-user-js-emoji-bundle');

			wp_register_script('wplc-user-js-emoji-concat', "https://bleeper.io/app/assets/wdt-emoji/wdt-emoji-concat.min.js", array("wplc-server-script", "wplc-server-script"), $wplc_version, false);
			wp_enqueue_script('wplc-user-js-emoji-concat');

			wp_register_style( 'wplc-admin-style-emoji', "https://bleeper.io/app/assets/wdt-emoji/wdt-emoji-bundle.css", false, $wplc_version );
			wp_enqueue_style( 'wplc-admin-style-emoji' );
		}

    } else {
    	/* not using the node server, load traditional event handler JS */
    	wp_register_script('wplc-user-events-script', plugins_url('/js/wplc_u_events.js', __FILE__),array('jquery', 'wplc-server-script'),$wplc_version);
    }




    wp_register_script('wplc-user-script', plugins_url('/js/wplc_u.js', __FILE__),array('jquery', 'wplc-server-script'),$wplc_version);


    /**
     * No longer in use as of 6.2.11 as using the minified file causes issues on sites that are minified.
     * @deprecated 6.2.11
     */
    // wp_register_script('wplc-user-script', plugins_url('/js/wplc_u.min.js', __FILE__),array('jquery'),$wplc_version);

    wp_enqueue_script('wplc-user-script');
    wp_enqueue_script('wplc-user-events-script');

    if (isset($wplc_settings['wplc_newtheme'])) { $wplc_newtheme = $wplc_settings['wplc_newtheme']; } else { $wplc_newtheme = "theme-2"; }
    if (isset($wplc_newtheme)) {
      if($wplc_newtheme == 'theme-1') {
        wp_register_script('wplc-theme-classic', plugins_url('/js/themes/classic.js', __FILE__),array('wplc-user-script'),$wplc_version);
        wp_enqueue_script('wplc-theme-classic');

      }
      else if($wplc_newtheme == 'theme-2') {
        wp_register_script('wplc-theme-modern', plugins_url('/js/themes/modern.js', __FILE__),array('wplc-user-script'),$wplc_version);
        wp_enqueue_script('wplc-theme-modern');

      }
    } else {
        wp_register_script('wplc-theme-classic', plugins_url('/js/themes/classic.js', __FILE__),array('wplc-user-script'),$wplc_version);
        wp_enqueue_script('wplc-theme-classic');
    }

    $ajax_url = admin_url('admin-ajax.php');
    $home_ajax_url = $ajax_url;

    $wplc_ajax_url = apply_filters("wplc_filter_ajax_url",$ajax_url);
    wp_localize_script('wplc-admin-chat-js', 'wplc_ajaxurl', $wplc_ajax_url);
    wp_localize_script('wplc-ma-js', 'wplc_home_ajaxurl', $home_ajax_url);

	//Added rest security nonces
    if(class_exists("WP_REST_Request")) {
        wp_localize_script('wplc-user-script', 'wplc_restapi_enabled', '1');
        wp_localize_script('wplc-user-script', 'wplc_restapi_token', get_option('wplc_api_secret_token'));
        wp_localize_script('wplc-user-script', 'wplc_restapi_endpoint', rest_url('wp_live_chat_support/v1'));
        wp_localize_script('wplc-user-script', 'wplc_restapi_nonce', wp_create_nonce( 'wp_rest' ));
    } else {
        wp_localize_script('wplc-user-script', 'wplc_restapi_enabled', '0');
        wp_localize_script('wplc-user-script', 'wplc_restapi_nonce', "false");
    }


    if (isset($wplc_ga_enabled['wplc_enable_ga']) && $wplc_ga_enabled['wplc_enable_ga'] == '1') {
    	wp_localize_script('wplc-user-script', 'wplc_enable_ga', '1');
    }

	$wplc_ding_file = apply_filters( 'wplc_filter_message_sound', '' );
    if ( ! empty( $wplc_ding_file ) ) {
	    wp_localize_script( 'wplc-user-script', 'bleeper_message_override', $wplc_ding_file );
    }

    $wplc_detect_device = new Mobile_Detect;
    $wplc_is_mobile = $wplc_detect_device->isMobile() ? 'true' : 'false';
    wp_localize_script('wplc-user-script', 'wplc_is_mobile', $wplc_is_mobile);


    wp_localize_script('wplc-user-script', 'wplc_ajaxurl', $wplc_ajax_url);
    wp_localize_script('wplc-user-script', 'wplc_ajaxurl_site', admin_url('admin-ajax.php'));
    wp_localize_script('wplc-user-script', 'wplc_nonce', $ajax_nonce);
    wp_localize_script('wplc-user-script', 'wplc_plugin_url', WPLC_BASIC_PLUGIN_URL);

    $wplc_display = false;

    $wplc_images = apply_filters( 'wplc_get_images_to_preload', array(), $wplc_acbc_data );
    wp_localize_script( 'wplc-user-script', 'wplc_preload_images', $wplc_images );




	if( isset($wplc_settings['wplc_show_name']) && $wplc_settings['wplc_show_name'] == '1' ){ $wplc_show_name = true; } else { $wplc_show_name = false; }
    if( isset($wplc_settings['wplc_show_avatar']) && $wplc_settings['wplc_show_avatar'] ){ $wplc_show_avatar = true; } else { $wplc_show_avatar = false; }
	if( isset($wplc_settings['wplc_show_date']) && $wplc_settings['wplc_show_date'] == '1' ){ $wplc_show_date = true; } else { $wplc_show_date = false; }
	if( isset($wplc_settings['wplc_show_time']) && $wplc_settings['wplc_show_time'] == '1' ){ $wplc_show_time = true; } else { $wplc_show_time = false; }

 	$wplc_chat_detail = array( 'name' => $wplc_show_name, 'avatar' => $wplc_show_avatar, 'date' => $wplc_show_date, 'time' => $wplc_show_time );



	if( $wplc_display !== FALSE && $wplc_display !== 'hide'  ){
		wp_localize_script('wplc-user-script', 'wplc_display_name', $wplc_display);
	} else {
		wp_localize_script( 'wplc-user-script', 'wplc_show_chat_detail', $wplc_chat_detail );
	}



    /**
     * Create a JS object for all Agent ID's and Gravatar MD5's
     */
    $user_array = get_users(array(
        'meta_key' => 'wplc_ma_agent',
    ));

    $a_array = array();
    if ($user_array) {
        foreach ($user_array as $user) {
        	$a_array[$user->ID] = array();
        	$a_array[$user->ID]['name'] = apply_filters( "wplc_decide_agents_name", $user->display_name, $wplc_acbc_data );
        	$a_array[$user->ID]['md5'] = md5( $user->user_email );
        }
    }
	wp_localize_script('wplc-user-script', 'wplc_agent_data', $a_array);


	$wplc_error_messages = array(
        'valid_name'     => __( "Please enter your name", "wplivechat" ),
        'valid_email'     => __( "Please enter your email address", "wplivechat" ),
        'server_connection_lost' => __("Connection to server lost. Please reload this page. Error: ", "wplivechat"),
        'chat_ended_by_operator' => ( empty( $wplc_settings['wplc_text_chat_ended'] ) ) ? __("The chat has been ended by the operator.", "wplivechat") : esc_attr( $wplc_settings['wplc_text_chat_ended'] ) ,
        'empty_message' => __( "Please enter a message", "wplivechat" ),
        'disconnected_message' => __("Disconnected, attempting to reconnect...", "wplivechat"),
    );

    $wplc_error_messages = apply_filters( "wplc_user_error_messages_filter", $wplc_error_messages );

    wp_localize_script('wplc-user-script', 'wplc_error_messages', $wplc_error_messages);
    wp_localize_script('wplc-user-script', 'wplc_enable_ding', $wplc_ding);
    $wplc_run_override = "0";
    $wplc_run_override = apply_filters("wplc_filter_run_override",$wplc_run_override);
    wp_localize_script('wplc-user-script', 'wplc_filter_run_override', $wplc_run_override);

    if (!isset($wplc_settings['wplc_pro_offline1'])) { $wplc_settings["wplc_pro_offline1"] = __("We are currently offline. Please leave a message and we'll get back to you shortly.", "wplivechat"); }
    if (!isset($wplc_settings['wplc_pro_offline2'])) { $wplc_settings["wplc_pro_offline2"] =  __("Sending message...", "wplivechat"); }
    if (!isset($wplc_settings['wplc_pro_offline3'])) { $wplc_settings["wplc_pro_offline3"] = __("Thank you for your message. We will be in contact soon.", "wplivechat"); }


    wp_localize_script('wplc-user-script', 'wplc_offline_msg', __(stripslashes($wplc_settings['wplc_pro_offline2']), 'wplivechat'));
    wp_localize_script('wplc-user-script', 'wplc_offline_msg3',__(stripslashes($wplc_settings['wplc_pro_offline3']), 'wplivechat'));
    wp_localize_script('wplc-user-script', 'wplc_welcome_msg', __(stripslashes($wplc_settings['wplc_welcome_msg']), 'wplivechat'));
 	wp_localize_script('wplc-user-script', 'wplc_pro_sst1', __(stripslashes($wplc_settings['wplc_pro_sst1']), 'wplivechat') );
 	wp_localize_script('wplc-user-script', 'wplc_pro_offline_btn_send', __(stripslashes($wplc_settings['wplc_pro_offline_btn_send']), 'wplivechat') );
 	wp_localize_script('wplc-user-script', 'wplc_user_default_visitor_name', __(stripslashes($wplc_settings['wplc_user_default_visitor_name']), 'wplivechat') );

    if( isset( $wplc_acbc_data['wplc_use_wp_name'] ) && $wplc_acbc_data['wplc_use_wp_name'] == '1' ){
    	if( isset( $_COOKIE['wplc_cid'] ) ){
    		$chat_data = wplc_get_chat_data( $_COOKIE['wplc_cid'] );
	        if ( isset($chat_data->agent_id ) ) {
		        $user_info = get_userdata( intval( $chat_data->agent_id ) );
	        	if( $user_info ){
		        	$agent = $user_info->display_name;
				} else {
		        	$agent = "agent";
		        }
		    } else {
		    	$agent = 'agent';
		    }
    	} else {
    		$agent = 'agent';
    	}

    } else {
        if (!empty($wplc_acbc_data['wplc_chat_name'])) {
            $agent = $wplc_acbc_data['wplc_chat_name'];
        } else {
            $agent = 'agent';
        }
    }
    wp_localize_script('wplc-user-script', 'wplc_localized_string_is_typing', $agent . __(" is typing...","wplivechat"));
    wp_localize_script('wplc-user-script', 'wplc_localized_string_is_typing_single', __(" is typing...","wplivechat"));

    $bleeper_string_array = array(
    	__(" has joined.","wplivechat"),
    	__(" has left.","wplivechat"),
    	__(" has ended the chat.", "wplivechat"),
    	__(" has disconnected.", "wplivechat"),
    	__("(edited)", "wplivechat"),
    	__("Type here","wplivechat")
    );

	wp_localize_script('wplc-user-script', 'bleeper_localized_strings', $bleeper_string_array );

    if( isset( $wplc_settings['wplc_elem_trigger_id'] ) && trim( $wplc_settings['wplc_elem_trigger_id'] ) !== "" ) {
    	if( isset( $wplc_settings['wplc_elem_trigger_action'] ) ){
    		wp_localize_script( 'wplc-user-script', 'wplc_elem_trigger_action', stripslashes( $wplc_settings['wplc_elem_trigger_action'] ) );
    	}
    	if( isset( $wplc_settings['wplc_elem_trigger_type'] ) ){
    		wp_localize_script( 'wplc-user-script', 'wplc_elem_trigger_type', stripslashes( $wplc_settings['wplc_elem_trigger_type'] ) );
    	}
    	wp_localize_script( 'wplc-user-script', 'wplc_elem_trigger_id', stripslashes( $wplc_settings['wplc_elem_trigger_id'] ) );
    }

    $extra_data_array = array("object_switch" => true);
    $extra_data_array = apply_filters("wplc_filter_front_js_extra_data",$extra_data_array);
    wp_localize_script('wplc-user-script', 'wplc_extra_data',$extra_data_array);


    if (isset($_COOKIE['wplc_email']) && $_COOKIE['wplc_email'] != "") { $wplc_user_gravatar = sanitize_text_field(md5(strtolower(trim($_COOKIE['wplc_email'])))); } else {$wplc_user_gravatar = ""; }

    if ($wplc_user_gravatar != "") { $wplc_grav_image = "<img src='//www.gravatar.com/avatar/$wplc_user_gravatar?s=30' class='wplc-user-message-avatar' />";} else { $wplc_grav_image = "";}

	if ( ! empty( $wplc_grav_image ) ) {
		wp_localize_script('wplc-user-script', 'wplc_gravatar_image', $wplc_grav_image);
    }

    $wplc_hide_chat = "";
    if (get_option('WPLC_HIDE_CHAT') == TRUE) { $wplc_hide_chat = "yes"; } else { $wplc_hide_chat = null; }
    wp_localize_script('wplc-user-script', 'wplc_hide_chat', $wplc_hide_chat);

    if(isset($wplc_settings['wplc_redirect_to_thank_you_page']) && isset($wplc_settings['wplc_redirect_thank_you_url']) && $wplc_settings['wplc_redirect_thank_you_url'] !== "" && $wplc_settings['wplc_redirect_thank_you_url'] !== " "){
    	wp_localize_script('wplc-user-script', 'wplc_redirect_thank_you', urldecode($wplc_settings['wplc_redirect_thank_you_url']));
    }

    wp_enqueue_script('jquery-ui-core',false,array('wplc-user-script'),false,false);
    wp_enqueue_script('jquery-ui-draggable',false,array('wplc-user-script'),false,false);

    do_action("wplc_hook_push_js_to_front");

}
if (function_exists('wplc_pro_user_top_js')) {
    add_action('wp_head', 'wplc_pro_user_top_js');

} else {
    add_action('wp_head', 'wplc_user_top_js');

}



/**
 * Add to the array to determine which images need to be preloaded via JS on the front end.
 *
 * @param  array $images Array of images to be preloaded
 * @return array
 */
add_filter( "wplc_get_images_to_preload", "wplc_filter_control_get_images_to_preload", 10, 2 );
function wplc_filter_control_get_images_to_preload( $images, $wplc_acbc_data ) {
	$icon = plugins_url('images/iconRetina.png', __FILE__);
	$close_icon = plugins_url('images/iconCloseRetina.png', __FILE__);
	array_push( $images, $icon );
	array_push( $images, $close_icon );
	return $images;
}



function wplc_user_top_js() {

    if(function_exists('wplc_display_chat_contents')){
        $display_contents = wplc_display_chat_contents();
    } else {
        $display_contents = 1;
    }
    if($display_contents >= 1){
        /*echo "<!-- DEFINING DO NOT CACHE -->";
        if (!defined('DONOTCACHEPAGE')) {
            define('DONOTCACHEPAGE', true);
        }
        if (!defined('DONOTCACHEDB')) {
            define('DONOTCACHEDB', true);
        }
        */
        $ajax_nonce = wp_create_nonce("wplc");
        $wplc_settings = get_option("WPLC_SETTINGS");
        $ajax_url = admin_url('admin-ajax.php');
        $wplc_ajax_url = apply_filters("wplc_filter_ajax_url",$ajax_url);
        ?>

        <script type="text/javascript">
        <?php if (!function_exists("wplc_register_pro_version")) { ?>
            var wplc_ajaxurl = '<?php echo $wplc_ajax_url; ?>';
        <?php } ?>
            var wplc_nonce = '<?php echo $ajax_nonce; ?>';
        </script>




        <?php

        $wplc_settings = get_option('WPLC_SETTINGS');
        if (isset($wplc_settings['wplc_theme'])) { $wplc_theme = $wplc_settings['wplc_theme']; } else { $wplc_theme = "theme-default"; }
        if (isset($wplc_theme)) {

          if($wplc_theme == 'theme-6') {
            /* custom */

            if (isset($wplc_settings["wplc_settings_color1"])) { $wplc_settings_color1 = $wplc_settings["wplc_settings_color1"]; } else { $wplc_settings_color1 = "ED832F"; }
            if (isset($wplc_settings["wplc_settings_color2"])) { $wplc_settings_color2 = $wplc_settings["wplc_settings_color2"]; } else { $wplc_settings_color2 = "FFFFFF"; }
            if (isset($wplc_settings["wplc_settings_color3"])) { $wplc_settings_color3 = $wplc_settings["wplc_settings_color3"]; } else { $wplc_settings_color3 = "EEEEEE"; }
            if (isset($wplc_settings["wplc_settings_color4"])) { $wplc_settings_color4 = $wplc_settings["wplc_settings_color4"]; } else { $wplc_settings_color4 = "666666"; }


            ?>
            <style>
              .wplc-color-1 { color: #<?php echo $wplc_settings_color1; ?> !important; }
              .wplc-color-2 { color: #<?php echo $wplc_settings_color2; ?> !important; }
              .wplc-color-3 { color: #<?php echo $wplc_settings_color3; ?> !important; }
              .wplc-color-4 { color: #<?php echo $wplc_settings_color4; ?> !important; }
              .wplc-color-bg-1 { background-color: #<?php echo $wplc_settings_color1; ?> !important; }
              .wplc-color-bg-2 { background-color: #<?php echo $wplc_settings_color2; ?> !important; }
              .wplc-color-bg-3 { background-color: #<?php echo $wplc_settings_color3; ?> !important; }
              .wplc-color-bg-4 { background-color: #<?php echo $wplc_settings_color4; ?> !important; }
              .wplc-color-border-1 { border-color: #<?php echo $wplc_settings_color1; ?> !important; }
              .wplc-color-border-2 { border-color: #<?php echo $wplc_settings_color2; ?> !important; }
              .wplc-color-border-3 { border-color: #<?php echo $wplc_settings_color3; ?> !important; }
              .wplc-color-border-4 { border-color: #<?php echo $wplc_settings_color4; ?> !important; }
              .wplc-color-border-1:before { border-color: transparent #<?php echo $wplc_settings_color1; ?> !important; }
              .wplc-color-border-2:before { border-color: transparent #<?php echo $wplc_settings_color2; ?> !important; }
              .wplc-color-border-3:before { border-color: transparent #<?php echo $wplc_settings_color3; ?> !important; }
              .wplc-color-border-4:before { border-color: transparent #<?php echo $wplc_settings_color4; ?> !important; }
            </style>

            <?php


          }
        }


    }
}




/**
 * Detect if the user is using blocked in the live chat settings 'blocked IP' section
 * @return void
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_hook_control_banned_users() {
    if (function_exists('wplc_is_user_banned_basic')){
        $user_banned = wplc_is_user_banned_basic();
    } else {
        $user_banned = 0;
    }
    if ($user_banned) {
      remove_action("wplc_hook_output_box_body","wplc_hook_control_show_chat_box");
      remove_action("wplc_hook_output_box_footer","wplc_action_control_hook_output_box_footer");
    }
}

/**
 * Detect if the user is using a mobile phone or not and decides to show the chat box depending on the admins settings
 * @return void
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_hook_control_check_mobile() {
  $wplc_settings = get_option("WPLC_SETTINGS");

  $draw_box = false;

  if (!class_exists('Mobile_Detect')) {
      require_once (plugin_dir_path(__FILE__) . 'includes/Mobile_Detect.php');
  }

  $wplc_detect_device = new Mobile_Detect;
  $wplc_is_mobile = $wplc_detect_device->isMobile();

  if ($wplc_is_mobile && !isset($wplc_settings['wplc_enabled_on_mobile']) && $wplc_settings['wplc_enabled_on_mobile'] != 1) {
      return "";
  }

  if (function_exists('wplc_basic_hide_chat_when_offline')) {
      $wplc_hide_chat = wplc_basic_hide_chat_when_offline();
      if (!$wplc_hide_chat) {
          $draw_box = true;
      }
  } else {
      $draw_box = true;
  }
  if (!$draw_box) {
      remove_action("wplc_hook_output_box_body","wplc_hook_control_show_chat_box");
      remove_action("wplc_hook_output_box_footer","wplc_action_control_hook_output_box_footer");
  }

}


add_action("wplc_hook_output_box_footer","wplc_action_control_hook_output_box_footer",10,1);
function wplc_action_control_hook_output_box_footer() {
  /* nothing here */
}

/**
 * Decides whether or not to show the chat box based on the main setting in the settings page
 * @return void
 * @since  6.0.00
 */
function wplc_hook_control_is_chat_enabled() {
  $wplc_settings = get_option("WPLC_SETTINGS");
  if ($wplc_settings["wplc_settings_enabled"] == 2) {
      remove_action("wplc_hook_output_box_body","wplc_hook_control_show_chat_box");
      remove_action("wplc_hook_output_box_footer","wplc_action_control_hook_output_box_footer");
  }
}

/**
 * Backwards compatibility for the control of the chat box
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan - nick@codecabin.co.za
 */
function wplc_hook_control_show_chat_box($cid) {
  if (function_exists("wplc_pro_version_control")) {
    global $wplc_pro_version;
    if (intval(str_replace(".","",$wplc_pro_version)) < 5100) {

      echo wplc_output_box_ajax();

    } else {
      echo wplc_output_box_ajax_new($cid);
    }
  } else {
    echo wplc_output_box_ajax_new($cid);

  }

}

/* basic */
add_action("wplc_hook_output_box_header","wplc_hook_control_banned_users");
add_action("wplc_hook_output_box_header","wplc_hook_control_check_mobile");
add_action("wplc_hook_output_box_header","wplc_hook_control_is_chat_enabled");

add_action("wplc_hook_output_box_body","wplc_hook_control_show_chat_box",10,1);

/**
 * Build the chat box
 * @return void
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_output_box_5100($cid = null) {
   wplc_string_check();
   do_action("wplc_hook_output_box_header",$cid);
   do_action("wplc_hook_output_box_body",$cid);
   do_action("wplc_hook_output_box_footer",$cid);
}



/**
 * Filter to control the top MAIN DIV of the chat box
 * @param  array   $wplc_settings Live chat settings array
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_live_chat_box_html_main_div_top($wplc_settings,$logged_in,$wplc_using_locale) {
    $ret_msg = "";
   $wplc_class = "";
//   $wplc_settings = get_option("WPLC_SETTINGS");

    if ($wplc_settings["wplc_settings_align"] == 1) {
        $original_pos = "bottom_left";
    } else if ($wplc_settings["wplc_settings_align"] == 2) {
        $original_pos = "bottom_right";
    } else if ($wplc_settings["wplc_settings_align"] == 3) {
        $original_pos = "left";
        $wplc_class = "wplc_left";
    } else if ($wplc_settings["wplc_settings_align"] == 4) {
        $original_pos = "right";
        $wplc_class = "wplc_right";
    }


    $animations = wplc_return_animations_basic();
    if ($animations) {
      isset($animations['animation']) ? $wplc_animation = $animations['animation'] : $wplc_animation = 'animation-4';
      isset($animations['starting_point']) ? $wplc_starting_point = $animations['starting_point'] : $wplc_starting_point = 'display: none;';
      isset($animations['box_align']) ? $wplc_box_align = $animations['box_align'] : $wplc_box_align = '';
    }
    else {

      if ($wplc_settings["wplc_settings_align"] == 1) {
          $original_pos = "bottom_left";
          $wplc_box_align = "left:20px; bottom:0px;";
      } else if ($wplc_settings["wplc_settings_align"] == 2) {
          $original_pos = "bottom_right";
          $wplc_box_align = "right:20px; bottom:0px;";
      } else if ($wplc_settings["wplc_settings_align"] == 3) {
          $original_pos = "left";
          $wplc_box_align = "left:0; bottom:100px;";
          $wplc_class = "wplc_left";
      } else if ($wplc_settings["wplc_settings_align"] == 4) {
          $original_pos = "right";
          $wplc_box_align = "right:0; bottom:100px;";
          $wplc_class = "wplc_right";
      }
    }


  $wplc_extra_attr = apply_filters("wplc_filter_chat_header_extra_attr","");
  if (isset($wplc_settings['wplc_newtheme'])) { $wplc_newtheme = $wplc_settings['wplc_newtheme']; } else { $wplc_newtheme = "theme-2"; }
  if (isset($wplc_newtheme)) {
    if($wplc_newtheme == 'theme-1') { $wplc_theme_type = "classic"; }
    else if($wplc_newtheme == 'theme-2') { $wplc_theme_type = "modern"; }
    else { $wplc_theme_type = "modern"; }
  }

  if(!isset($wplc_settings['wplc_newtheme'])){ $wplc_settings['wplc_newtheme'] = "theme-2"; }
  if (isset($wplc_settings['wplc_newtheme']) && $wplc_settings['wplc_newtheme'] == "theme-2") {
  	$hovercard_content = "<div class='wplc_hovercard_content_left'>".apply_filters("wplc_filter_modern_theme_hovercard_content_left","")."</div><div class='wplc_hovercard_content_right'>".apply_filters("wplc_filter_live_chat_box_html_1st_layer",wplc_filter_control_live_chat_box_html_1st_layer($wplc_settings,$logged_in,$wplc_using_locale,'wplc-color-4'))."</div>";
  	$hovercard_content = apply_filters("wplc_filter_hovercard_content", $hovercard_content);

    $ret_msg .= "<div id='wplc_hovercard' style='display:none' class='".$wplc_theme_type."'>";
    //$ret_msg .= "<div id='wplc_hovercard_min' class='wplc_button_standard wplc-color-border-1 wplc-color-bg-1'>".stripslashes( $wplc_settings['wplc_close_btn_text'] )."</div>";
    $ret_msg .= "<div id='wplc_hovercard_content'>".apply_filters("wplc_filter_live_chat_box_pre_layer1","").$hovercard_content."</div>";
    $ret_msg .= "<div id='wplc_hovercard_bottom'>".apply_filters("wplc_filter_hovercard_bottom_before","").apply_filters("wplc_filter_live_chat_box_hover_html_start_chat_button","",$wplc_settings,$logged_in,$wplc_using_locale)."</div>";
    $ret_msg .= "</div>";

  } else if (isset($wplc_settings['wplc_newtheme']) && $wplc_settings['wplc_newtheme'] == "theme-1"){
  	$hovercard_content = "<div class='wplc_hovercard_content_right'>".apply_filters("wplc_filter_live_chat_box_html_1st_layer",wplc_filter_control_live_chat_box_html_1st_layer($wplc_settings,$logged_in,$wplc_using_locale, "wplc-color-2"))."</div>";
  	$hovercard_content = apply_filters("wplc_filter_hovercard_content", $hovercard_content);

    $ret_msg .= "<div id='wplc_hovercard' style='display:none' class='".$wplc_theme_type."'>";
    //$ret_msg .= "<div id='wplc_hovercard_min' class='wplc_button_standard wplc-color-border-1 wplc-color-bg-1'>".__("close", "wplivechat")."</div>";
    $ret_msg .= "<div id='wplc_hovercard_content'>".apply_filters("wplc_filter_live_chat_box_pre_layer1","").$hovercard_content."</div>";
    $ret_msg .= "<div id='wplc_hovercard_bottom'>".apply_filters("wplc_filter_hovercard_bottom_before","").apply_filters("wplc_filter_live_chat_box_hover_html_start_chat_button","",$wplc_settings,$logged_in,$wplc_using_locale)."</div>";
    $ret_msg .= "</div>";
  }

  $ret_msg .= "<div id=\"wp-live-chat\" wplc_animation=\"".$wplc_animation."\" style=\"".$wplc_starting_point." ".$wplc_box_align.";\" class=\"".$wplc_theme_type." ".$wplc_class." wplc_close\" original_pos=\"".$original_pos."\" ".$wplc_extra_attr." > ";
  return $ret_msg;
}



add_filter("wplc_filter_modern_theme_hovercard_content_left","wplc_filter_control_modern_theme_hovercard_content_left",10,1);
function wplc_filter_control_modern_theme_hovercard_content_left($msg) {

  $msg .= "<div class='wplc_left_logo' style='background:url(".plugins_url('images/iconmicro.png', __FILE__).") no-repeat; background-size: cover;'></div>";
  $msg = apply_filters("wplc_filter_microicon",$msg);
  return $msg;
}

/**
 * Filter to control the top HEADER DIV of the chat box
 * @param  array   $wplc_settings Live chat settings array
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_live_chat_box_html_header_div_top($wplc_settings) {

  $ret_msg = "";

  $current_theme = isset($wplc_settings['wplc_newtheme']) ? $wplc_settings['wplc_newtheme'] : "theme-2";
  if($current_theme === "theme-1"){
  	$ret_msg .= apply_filters("wplc_filter_chat_header_above","", $wplc_settings); //Ratings/Social Icon Filter
  }

  $ret_msg .= "<div id=\"wp-live-chat-header\" class='wplc-color-bg-1 wplc-color-2'>";
  $ret_msg .= apply_filters("wplc_filter_chat_header_under","",$wplc_settings);
  return $ret_msg;
}


add_filter("wplc_filter_chat_header_under","wplc_filter_control_chat_header_under",1,2);
function wplc_filter_control_chat_header_under($ret_msg,$wplc_settings) {
	$current_theme = isset($wplc_settings['wplc_newtheme']) ? $wplc_settings['wplc_newtheme'] : "theme-2";
	if($current_theme === "theme-2"){

		if (function_exists("wplc_acbc_filter_control_chat_header_under")) {
		  remove_filter("wplc_filter_chat_header_under","wplc_acbc_filter_control_chat_header_under");
		}
	}

	return $ret_msg;

}



/**
 * Filter to control the user details section - custom fields coming soon
 * @param  array   $wplc_settings Live chat settings array
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_live_chat_box_html_ask_user_detail($wplc_settings) {
  $ret_msg = "";
  if (isset($wplc_settings['wplc_loggedin_user_info']) && $wplc_settings['wplc_loggedin_user_info'] == 1) {
      $wplc_use_loggedin_user_details = 1;
  } else {
      $wplc_use_loggedin_user_details = 0;
  }

	if (isset($wplc_settings['wplc_require_user_info']) && ( $wplc_settings['wplc_require_user_info'] == 1 || $wplc_settings['wplc_require_user_info'] == 'name' )) {
		$wplc_ask_user_details = 1;
	} else {
		$wplc_ask_user_details = 0;
	}

  $wplc_loggedin_user_name = "";
  $wplc_loggedin_user_email = "";

  if ($wplc_use_loggedin_user_details == 1 && is_user_logged_in()) {
      global $current_user;

      if ($current_user->data != null) {
          //Logged in. Get name and email
          $wplc_loggedin_user_name = $current_user->user_nicename;
          $wplc_loggedin_user_email = $current_user->user_email;
      }
  } else {
	  if ( $wplc_ask_user_details == 0 ) {
		  $wplc_loggedin_user_name = stripslashes( $wplc_settings['wplc_user_default_visitor_name'] );
	  }
  }

  if (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 1) {
	  //Ask the user to enter name and email

	  $ret_msg .= "<input type=\"text\" name=\"wplc_name\" id=\"wplc_name\" value='" . $wplc_loggedin_user_name . "' placeholder=\"" . __( "Name", "wplivechat" ) . "\" />";
	  $ret_msg .= "<input type=\"text\" name=\"wplc_email\" id=\"wplc_email\" wplc_hide=\"0\" value=\"" . $wplc_loggedin_user_email . "\" placeholder=\"" . __( "Email", "wplivechat" ) . "\"  />";
	  $ret_msg .= apply_filters( "wplc_start_chat_user_form_after_filter", "" );

  } elseif (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 'email') {
	  /*$ret_msg .= "<div style=\"padding: 7px; text-align: center;\">";
	  if (isset($wplc_settings['wplc_user_alternative_text'])) {
		  $ret_msg .= html_entity_decode( stripslashes($wplc_settings['wplc_user_alternative_text']) );
	  }
	  $ret_msg .= '</div>';*/

	  $wplc_random_user_number = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
	  if ($wplc_loggedin_user_name != '') { $wplc_lin = $wplc_loggedin_user_name; } else {  $wplc_lin = 'user' . $wplc_random_user_number; }
	  $ret_msg .= "<input type=\"hidden\" name=\"wplc_name\" id=\"wplc_name\" value=\"".$wplc_lin."\" />";
	  $ret_msg .= "<input type=\"text\" name=\"wplc_email\" id=\"wplc_email\" wplc_hide=\"0\" value=\"" . $wplc_loggedin_user_email . "\" placeholder=\"" . __( "Email", "wplivechat" ) . "\"  />";
	  $ret_msg .= apply_filters("wplc_start_chat_user_form_after_filter", "");
  } elseif (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 'name') {
	  /*
	  $ret_msg .= "<div style=\"padding: 7px; text-align: center;\">";
	  if (isset($wplc_settings['wplc_user_alternative_text'])) {
		  $ret_msg .= html_entity_decode( stripslashes($wplc_settings['wplc_user_alternative_text']) );
	  }
	  $ret_msg .= '</div>';*/

	  $wplc_random_user_number = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
	  if ($wplc_loggedin_user_email != '' && $wplc_loggedin_user_email != null) { $wplc_lie = $wplc_loggedin_user_email; } else { $wplc_lie = $wplc_random_user_number . '@' . $wplc_random_user_number . '.com'; }
	  $ret_msg .= "<input type=\"text\" name=\"wplc_name\" id=\"wplc_name\" value='" . $wplc_loggedin_user_name . "' placeholder=\"" . __( "Name", "wplivechat" ) . "\" />";
	  $ret_msg .= "<input type=\"hidden\" name=\"wplc_email\" id=\"wplc_email\" wplc_hide=\"1\" value=\"".$wplc_lie."\" />";
	  $ret_msg .= apply_filters("wplc_start_chat_user_form_after_filter", "");
  } else {
      //Dont ask the user

      $ret_msg .= "<div style=\"padding: 7px; text-align: center;\">";
      if (isset($wplc_settings['wplc_user_alternative_text'])) {
          $ret_msg .= html_entity_decode( stripslashes($wplc_settings['wplc_user_alternative_text']) );
      }
      $ret_msg .= '</div>';

      $wplc_random_user_number = rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9) . rand(0, 9);
      //$wplc_loggedin_user_email = $wplc_random_user_number."@".$wplc_random_user_number.".com";
      if ($wplc_loggedin_user_name != '') { $wplc_lin = $wplc_loggedin_user_name; } else {  $wplc_lin = 'user' . $wplc_random_user_number; }
      if ($wplc_loggedin_user_email != '' && $wplc_loggedin_user_email != null) { $wplc_lie = $wplc_loggedin_user_email; } else { $wplc_lie = $wplc_random_user_number . '@' . $wplc_random_user_number . '.com'; }
      $ret_msg .= "<input type=\"hidden\" name=\"wplc_name\" id=\"wplc_name\" value=\"".$wplc_lin."\" />";
      $ret_msg .= "<input type=\"hidden\" name=\"wplc_email\" id=\"wplc_email\" wplc_hide=\"1\" value=\"".$wplc_lie."\" />";
      $ret_msg .= apply_filters("wplc_start_chat_user_form_after_filter", "");
  }
  return $ret_msg;
}


/**
 * Filter to control the start chat button
 * @param  array   $wplc_settings Live chat settings array
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_live_chat_box_html_start_chat_button($wplc_settings,$wplc_using_locale ) {
    $wplc_sst_1 = __('Start chat', 'wplivechat');
    if (!isset($wplc_settings['wplc_pro_sst1']) || $wplc_settings['wplc_pro_sst1'] == "") { $wplc_settings['wplc_pro_sst1'] = $wplc_sst_1; }
    $text = ($wplc_using_locale ? $wplc_sst_1 : stripslashes($wplc_settings['wplc_pro_sst1']));
    $custom_attr = apply_filters('wplc_start_button_custom_attributes_filter', "", $wplc_settings);
  	return "<button id=\"wplc_start_chat_btn\" type=\"button\" class='wplc-color-bg-1 wplc-color-2' $custom_attr>$text</button>";
}




/**
 * Filter to control the hover card start chat button
 * @param  array   $wplc_settings Live chat settings array
 * @return string
 * @since  6.1.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
add_filter("wplc_filter_live_chat_box_hover_html_start_chat_button","wplc_filter_control_live_chat_box_html_hovercard_chat_button",10,4);
function wplc_filter_control_live_chat_box_html_hovercard_chat_button($content,$wplc_settings,$logged_in,$wplc_using_locale ) {
    if ($logged_in) {
      $wplc_sst_1 = __('Start chat', 'wplivechat');

      if (!isset($wplc_settings['wplc_pro_sst1']) || $wplc_settings['wplc_pro_sst1'] == "") { $wplc_settings['wplc_pro_sst1'] = $wplc_sst_1; }
      $text = ($wplc_using_locale ? $wplc_sst_1 : stripslashes($wplc_settings['wplc_pro_sst1']));
      return "<button id=\"speeching_button\" type=\"button\"  class='wplc-color-bg-1 wplc-color-2'>$text</button>";
    } else {
      $wplc_sst_1 = stripslashes($wplc_settings['wplc_pro_offline_btn']);
      return "<button id=\"speeching_button\" type=\"button\"  class='wplc-color-bg-1 wplc-color-2'>$wplc_sst_1</button>";

    }
}

/**
 * Filter to control the offline message button
 * @param  array   $wplc_settings Live chat settings array
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_live_chat_box_html_send_offline_message_button($wplc_settings) {
$wplc_settings = get_option('WPLC_SETTINGS');
if (isset($wplc_settings['wplc_theme'])) { $wplc_theme = $wplc_settings['wplc_theme']; } else { }

  if (isset($wplc_theme)) {
    if($wplc_theme == 'theme-1') {
        $wplc_settings_fill = "#DB0000";
        $wplc_settings_font = "#FFFFFF";
    } else if ($wplc_theme == 'theme-2'){
        $wplc_settings_fill = "#000000";
        $wplc_settings_font = "#FFFFFF";
    } else if ($wplc_theme == 'theme-3'){
        $wplc_settings_fill = "#DB30B3";
        $wplc_settings_font = "#FFFFFF";
    } else if ($wplc_theme == 'theme-4'){
        $wplc_settings_fill = "#1A14DB";
        $wplc_settings_font = "#F7FF0F";
    } else if ($wplc_theme == 'theme-5'){
        $wplc_settings_fill = "#3DCC13";
        $wplc_settings_font = "#FF0808";
    } else if ($wplc_theme == 'theme-6'){
        if ($wplc_settings["wplc_settings_fill"]) {
            $wplc_settings_fill = "#" . $wplc_settings["wplc_settings_fill"];
        } else {
            $wplc_settings_fill = "#ec832d";
        }
        if ($wplc_settings["wplc_settings_font"]) {
            $wplc_settings_font = "#" . $wplc_settings["wplc_settings_font"];
        } else {
            $wplc_settings_font = "#FFFFFF";
        }
    } else {
        if ($wplc_settings["wplc_settings_fill"]) {
            $wplc_settings_fill = "#" . $wplc_settings["wplc_settings_fill"];
        } else {
            $wplc_settings_fill = "#ec832d";
        }
        if ($wplc_settings["wplc_settings_font"]) {
            $wplc_settings_font = "#" . $wplc_settings["wplc_settings_font"];
        } else {
            $wplc_settings_font = "#FFFFFF";
        }
    }
    } else {
    if ($wplc_settings["wplc_settings_fill"]) {
        $wplc_settings_fill = "#" . $wplc_settings["wplc_settings_fill"];
    } else {
        $wplc_settings_fill = "#ec832d";
    }
    if ($wplc_settings["wplc_settings_font"]) {
        $wplc_settings_font = "#" . $wplc_settings["wplc_settings_font"];
    } else {
        $wplc_settings_font = "#FFFFFF";
    }
  }
  $custom_attr = apply_filters('wplc_offline_message_button_custom_attributes_filter', "", $wplc_settings);
  $ret_msg = "<input id=\"wplc_na_msg_btn\" type=\"button\" value=\"".stripslashes($wplc_settings['wplc_pro_offline_btn_send'])."\" style=\"background: ".$wplc_settings_fill." !important; background-color: ".$wplc_settings_fill." !important; color: ".$wplc_settings_font." !important;\" $custom_attr/>";
  return $ret_msg;
}



/**
 * Filter to control the 2nd layer of the chat window (online/offline)
 * @param  array   $wplc_settings Live chat settings array
 * @param  bool    $logged_in     Is the user logged in or not
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_live_chat_box_html_2nd_layer($wplc_settings,$logged_in,$wplc_using_locale, $cid) {

    if ($logged_in) {
      $wplc_intro = __('Hello. Please input your details so that I may help you.', 'wplivechat');
      if (!isset($wplc_settings['wplc_pro_intro']) || $wplc_settings['wplc_pro_intro'] == "") { $wplc_settings['wplc_pro_intro'] = $wplc_intro; }
      $text = ($wplc_using_locale ? $wplc_intro : stripslashes($wplc_settings['wplc_pro_intro']));

      $ret_msg = "<div id=\"wp-live-chat-2-inner\">";
      $ret_msg .= " <div id=\"wp-live-chat-2-info\" class='wplc-color-4'>";
      $ret_msg .= apply_filters("wplc_filter_intro_text_heading", $text, $wplc_settings);
      $ret_msg .= " </div>";
      $ret_msg .= apply_filters("wplc_filter_live_chat_box_html_ask_user_details",wplc_filter_control_live_chat_box_html_ask_user_detail($wplc_settings));
      $ret_msg .= apply_filters("wplc_filter_live_chat_box_html_start_chat_button",wplc_filter_control_live_chat_box_html_start_chat_button($wplc_settings,$wplc_using_locale ), $cid);
      $ret_msg .= "</div>";
    } else {
	    if ( isset( $wplc_settings['wplc_loggedin_user_info'] ) && $wplc_settings['wplc_loggedin_user_info'] == 1 ) {
		    $wplc_use_loggedin_user_details = 1;
	    } else {
		    $wplc_use_loggedin_user_details = 0;
	    }

	    $wplc_loggedin_user_name  = '';
	    $wplc_loggedin_user_email = '';

	    if ( $wplc_use_loggedin_user_details == 1 ) {
		    global $current_user;

		    if ( $current_user->data != null ) {
			    if ( is_user_logged_in() ) {
				    //Logged in. Get name and email
				    $wplc_loggedin_user_name = $current_user->user_nicename;
				    $wplc_loggedin_user_email = $current_user->user_email;
			    } else {
				    $wplc_loggedin_user_name = stripslashes( $wplc_settings['wplc_user_default_visitor_name'] );
			    }
		    }
	    } else {
		    $wplc_loggedin_user_name  = '';
		    $wplc_loggedin_user_email = '';
	    }

      /* admin not logged in, show offline messages */
      $wplc_offline = __("We are currently offline. Please leave a message and we'll get back to you shortly.", "wplivechat");
      $text = ($wplc_using_locale ? $wplc_offline : stripslashes($wplc_settings['wplc_pro_offline1']));

      $ret_msg = "<div id=\"wp-live-chat-2-info\" class=\"wplc-color-bg-1 wplc-color-2\">";
      $ret_msg .= $text;
      $ret_msg .= "</div>";
      $ret_msg .= "<div id=\"wplc_message_div\">";
      $ret_msg .= "<input type=\"text\" name=\"wplc_name\" id=\"wplc_name\" value=\"$wplc_loggedin_user_name\" placeholder=\"".__("Name", "wplivechat")."\" />";
      $ret_msg .= "<input type=\"text\" name=\"wplc_email\" id=\"wplc_email\" value=\"$wplc_loggedin_user_email\"  placeholder=\"".__("Email", "wplivechat")."\" />";
      $ret_msg .= "<textarea name=\"wplc_message\" id=\"wplc_message\" placeholder=\"".__("Message", "wplivechat")."\"></textarea>";

      if(isset($_SERVER['HTTP_X_FORWARDED_FOR']) && $_SERVER['HTTP_X_FORWARDED_FOR'] != '') {
          $ip_address = $_SERVER['HTTP_X_FORWARDED_FOR'];
      } else {
          $ip_address = $_SERVER['REMOTE_ADDR'];
      }

      /** DEPRECATED BY GDPR */
      /*if(isset($wplc_settings['wplc_record_ip_address']) && $wplc_settings['wplc_record_ip_address'] == 1) { $offline_ip_address = $ip_address; } else { $offline_ip_address = ""; }*/

      $offline_ip_address = "";

      $ret_msg .= "<input type=\"hidden\" name=\"wplc_ip_address\" id=\"wplc_ip_address\" value=\"".$offline_ip_address."\" />";
      $ret_msg .= "<input type=\"hidden\" name=\"wplc_domain_offline\" id=\"wplc_domain_offline\" value=\"".site_url()."\" />";
      $ret_msg .= apply_filters("wplc_filter_live_chat_box_html_send_offline_message_button",wplc_filter_control_live_chat_box_html_send_offline_message_button($wplc_settings));
      $ret_msg .= "</div>";



    }
    $data = array(
    	'ret_msg' => $ret_msg,
    	'wplc_settings' => $wplc_settings,
    	'logged_in' => $logged_in,
    	'wplc_using_locale' => $wplc_using_locale
	);


    $ret_msg = apply_filters( "wplc_filter_2nd_layer_modify" , $data );
	if( is_array( $ret_msg ) ){
		/* if nothing uses this filter is comes back as an array, so return the original message in that array */
        return $ret_msg['ret_msg'];
    } else {
        return $ret_msg;
    }
}

/**
 * Filter to control the 3rd layer of the chat window
 * @param  array $wplc_settings live chat settings array
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_live_chat_box_html_3rd_layer($wplc_settings,$wplc_using_locale) {

  $wplc_sst_2 = __('Connecting. Please be patient...', 'wplivechat');
  if (!isset($wplc_settings['wplc_pro_sst2']) || $wplc_settings['wplc_pro_sst2'] == "") { $wplc_settings['wplc_pro_sst2'] = $wplc_sst_2; }
  $text = ($wplc_using_locale ? $wplc_sst_2 : stripslashes($wplc_settings['wplc_pro_sst2']));

  $ret_msg = "<p class=''wplc-color-4>".$text."</p>";
  return $ret_msg;
}

add_filter("wplc_filter_intro_text_heading", "wplc_filter_control_intro_text_heading", 10, 2);
/**
 * Filters intro text
*/
function wplc_filter_control_intro_text_heading($content, $wplc_settings){

	if (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 1) {

  	} elseif (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 'email') {

  	} elseif (isset($wplc_settings['wplc_require_user_info']) && $wplc_settings['wplc_require_user_info'] == 'name') {

  	} else {
     	$content = "";
  	}

	return $content;
}


add_filter("wplc_filter_live_chat_box_above_main_div","wplc_filter_control_live_chat_box_above_main_div",10,3);
function wplc_filter_control_live_chat_box_above_main_div( $msg, $wplc_settings, $cid ) {
  if(!isset($wplc_settings['wplc_newtheme'])){ $wplc_settings['wplc_newtheme'] = "theme-2"; }
  if (isset($wplc_settings['wplc_newtheme']) && $wplc_settings['wplc_newtheme'] == "theme-2") {

  	$agent_info = '';
  	$cbox_header_bg = '';
  	$agent_tagline = '';
  	$agent_bio = '';

  	$a_twitter = '';
  	$a_linkedin = '';
  	$a_facebook = '';
  	$a_website = '';
  	$social_links = '';
  	$agent_string = '';

  	if(isset($wplc_settings['wplc_use_node_server']) && intval($wplc_settings['wplc_use_node_server']) == 1) {} else {
	  	if ( $cid ) {
	  		$cid = wplc_return_chat_id_by_rel($cid);
			$chat_data = wplc_get_chat_data( $cid );

			if ( isset( $chat_data->agent_id ) ) {
				$agent_id = intval( $chat_data->agent_id );
			} else {
				$agent_id = get_current_user_id();
			}

			if ( $agent_id ) {

		        $wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");
		        $user_info = get_userdata( $agent_id );


		        if( isset( $wplc_acbc_data['wplc_use_wp_name'] ) && $wplc_acbc_data['wplc_use_wp_name'] == '1' ){

		            $agent = $user_info->display_name;
		        } else {
		            if (!empty($wplc_acbc_data['wplc_chat_name'])) {
		                $agent = $wplc_acbc_data['wplc_chat_name'];
		            } else {
		                $agent = 'Admin';
		            }
		        }
		        $cbox_header_bg = "style='background-image:url(https://www.gravatar.com/avatar/".md5($user_info->user_email)."?s=380); no-repeat; cover;'";

				$extra = apply_filters( "wplc_filter_further_live_chat_box_above_main_div", '', $wplc_settings, $cid, $chat_data, $agent );

				$agent_string = '
				<p style="text-align:center;">
					<img class="img-thumbnail img-circle wplc_thumb32 wplc_agent_involved" style="max-width:inherit;" id="agent_grav_'.$agent_id.'" title="'.$agent.'" src="https://www.gravatar.com/avatar/'.md5($user_info->user_email).'?s=60" /><br />
					<span class="wplc_agent_name wplc-color-2">'.$agent.'</span>
					'.$extra.'
					<span class="bleeper_pullup down"><i class="fa fa-angle-up"></i></span>
				</p>';

			}
	  	}

	}

    $msg .= "<div id='wplc_chatbox_header_bg' ".$cbox_header_bg."><div id='wplc_chatbox_header' class='wplc-color-bg-1 wplc-color-4'><div class='wplc_agent_info'>".$agent_string."</div></div></div>";

  }
  return $msg;
}

/**
 * Filter to control the 4th layer of the chat window
 * @param  array $wplc_settings live chat settings array
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_live_chat_box_html_4th_layer($wplc_settings,$wplc_using_locale, $cid ) {
  $wplc_enter = __('Connecting. Please be patient...', 'wplivechat');
  if (!isset($wplc_settings['wplc_user_enter']) || $wplc_settings['wplc_user_enter'] == "") { $wplc_settings['wplc_pro_sst2'] = $wplc_enter; }
  $text = ($wplc_using_locale ? $wplc_enter : stripslashes($wplc_settings['wplc_user_enter']));

  $wplc_welcome = __('Welcome. How may I help you?', 'wplivechat');
  if (!isset($wplc_settings['wplc_user_welcome_chat']) || $wplc_settings['wplc_user_welcome_chat'] == "") { $wplc_settings['wplc_user_welcome_chat'] = $wplc_welcome; }
  $text2 = ($wplc_using_locale ? $wplc_welcome : stripslashes($wplc_settings['wplc_user_welcome_chat']));





  $ret_msg = "";
  if(!isset($wplc_settings['wplc_newtheme'])){ $wplc_settings['wplc_newtheme'] = "theme-2"; }
  if (isset($wplc_settings['wplc_newtheme']) && $wplc_settings['wplc_newtheme'] == 'theme-1') {
  	$ret_msg .= apply_filters("wplc_filter_typing_control_div","");
  }

  $ret_msg .= apply_filters("wplc_filter_inner_live_chat_box_4th_layer","", $wplc_settings);

  $ret_msg .= "<div id=\"wplc_sound_update\" style=\"height:0; width:0; display:none; border:0;\"></div>";

  $ret_msg .= apply_filters("wplc_filter_live_chat_box_above_main_div","",$wplc_settings, $cid);


  $ret_msg .= "<div id=\"wplc_chatbox\">";
//  $ret_msg .= "<span class='wplc-admin-message'>";
//  $ret_msg .= $text2;
//  $ret_msg .= "</span>";
//  $ret_msg .= "<br />";
//  $ret_msg .= "<div class='wplc-clear-float-message'></div>";
  $ret_msg .= "</div>";

  $ret_msg .= "<div id='bleeper_chat_ended' style='display:none;'></div>";
  $ret_msg .= "<div id='wplc_user_message_div'>";

  $ret_msg .= "<p id='wplc_msg_notice'>".$text."</p>";

  //Editor Controls
  $ret_msg .= apply_filters("wplc_filter_chat_text_editor","");

  $ret_msg .= "<p>";
  $placeholder = __('Type here','wplivechat');
  $ret_msg .= "<textarea type=\"text\" name=\"wplc_chatmsg\" id=\"wplc_chatmsg\" placeholder=\"".$placeholder."\" onclick=\"jQuery(this).select();\" class='wdt-emoji-bundle-enabled'></textarea>";
  if(!isset($wplc_settings['wplc_newtheme'])){ $wplc_settings['wplc_newtheme'] = "theme-2"; }
  if (isset($wplc_settings['wplc_newtheme']) && $wplc_settings['wplc_newtheme'] == 'theme-2') {
  	$ret_msg .= apply_filters("wplc_filter_typing_control_div_theme_2","");
  }

  //Upload Controls
  $ret_msg .= apply_filters("wplc_filter_chat_upload","");

  $ret_msg .= "<input type=\"hidden\" name=\"wplc_cid\" id=\"wplc_cid\" value=\"\" />";
  $ret_msg .= "<input id=\"wplc_send_msg\" type=\"button\" value=\"".__("Send", "wplivechat")."\" style=\"display:none;\" />";
  $ret_msg .= "</p>";

  $ret_msg .= function_exists("wplc_emoji_selector_div") ? wplc_emoji_selector_div() : "";

  $current_theme = isset($wplc_settings['wplc_newtheme']) ? $wplc_settings['wplc_newtheme'] : "theme-2";
  if($current_theme === "theme-2"){
  	$ret_msg .= apply_filters("wplc_filter_chat_4th_layer_below_input","", $wplc_settings); //Ratings/Social Icon Filter
  }

  $ret_msg .= "</div>";
  $ret_msg .= "</div>";
  return $ret_msg;
}

/**
 * Filter to control the 1st layer of the chat window
 * @param  array $wplc_settings        live chat settings array
 * @param  bool  $logged_in            Is the admin logged in or not
 * @param  bool  $wplc_using_locale    Are they using a localization plugin
 * @return string
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
function wplc_filter_control_live_chat_box_html_1st_layer($wplc_settings,$logged_in,$wplc_using_locale, $class_override = false) {

  $ret_msg = "<div id='wplc_first_message'>";

  if(!isset($wplc_settings['wplc_newtheme'])){ $wplc_settings['wplc_newtheme'] = "theme-2"; }

  if ($logged_in) {
    $wplc_fst_1 = __('Questions?', 'wplivechat');
    $wplc_fst_2 = __('Chat with us', 'wplivechat');
    if (isset($wplc_settings['wplc_newtheme']) && $wplc_settings['wplc_newtheme'] == "theme-2") {
      $coltheme = "wplc-color-4";
    } else {
      $coltheme = "wplc-color-2";
    }

    if($class_override){
    	//Override color class
    	$coltheme = $class_override;
    }

    $wplc_tl_msg = "<div class='$coltheme'><strong>" . ($wplc_using_locale ? $wplc_fst_1 : stripslashes($wplc_settings['wplc_pro_fst1'])) . "</strong> " . ( $wplc_using_locale ? $wplc_fst_2 : stripslashes($wplc_settings['wplc_pro_fst2'])) ."</div>";

    $ret_msg .= $wplc_tl_msg;
  } else {


    $wplc_na = __('Chat offline. Leave a message', 'wplivechat');
    $wplc_tl_msg = "<span class='wplc_offline'>" . ($wplc_using_locale ? $wplc_na : stripslashes($wplc_settings['wplc_pro_na'])) . "</span>";
    $ret_msg .= $wplc_tl_msg;
  }
  $ret_msg .= "</div>";



  return $ret_msg;

}

/**
 * Build the initiate teaser
 * @return void
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 */
add_filter( 'wplc_filter_list_chats_actions', 'wplc_initiate_chat_button', 12, 3);
function wplc_initiate_chat_button($actions,$result,$post_data) {


    if(intval($result->status) == 5 ){
      $actions = "<a href=\"javascript:void(0);\" id=\"wplc_initiate_chat\" class=\"wplc_initiate_chat button button-secondary\">".__("Initiate Chat","wplivechat")."</a>";
    }
  return $actions;
}


add_filter("wplc_loggedin_filter","wplc_filter_control_loggedin",10,1);
function wplc_filter_control_loggedin($logged_in) {
    $wplc_is_admin_logged_in = get_transient("wplc_is_admin_logged_in");

    if (!function_exists("wplc_register_pro_version") && $wplc_is_admin_logged_in != 1) {
        $logged_in = false;
    } else {
        $logged_in = true;
    }

    $logged_in_checks = apply_filters("wplc_filter_is_admin_logged_in",array());

    /* if we are logged in ANYWHERE, set this to true */
    foreach($logged_in_checks as $key => $val) {
      if ($val) { $logged_in = true; break; }
    }
    $logged_in_via_app = false;
    if (isset($logged_in_checks['app']) && $logged_in_checks['app'] == true) { $logged_in_via_app = true; }

    $logged_in = apply_filters("wplc_final_loggedin_control",$logged_in,$logged_in_via_app);

    /* admin is using the basic version and is logged in */
    if ($wplc_is_admin_logged_in) { $logged_in = true; }

    return $logged_in;
}

function wplc_shortenurl($url) {
	if ( strlen($url) > 45) {
		return substr($url, 0, 30)."[...]".substr($url, -15);
	} else {
		return $url;
	}
}


/**
 * The function that builds the chat box
 * @since  6.0.00
 * @author  Nick Duncan <nick@codecabin.co.za>
 * @return JSON encoded HTML
 */
function wplc_output_box_ajax_new($cid = null) {


        $ret_msg = array();
        $logged_in = false;

        $wplc_settings = get_option("WPLC_SETTINGS");

        if(isset($wplc_settings['wplc_using_localization_plugin']) && $wplc_settings['wplc_using_localization_plugin'] == 1){ $wplc_using_locale = true; } else { $wplc_using_locale = false; }


        $logged_in = apply_filters("wplc_loggedin_filter",false);

        $ret_msg['cbox'] = apply_filters("wplc_theme_control",$wplc_settings,$logged_in,$wplc_using_locale,$cid);

        $ret_msg['online'] = $logged_in;

        global $wplc_pro_version;
        $wplc_ver = str_replace('.', '', $wplc_pro_version);
        $checker = intval($wplc_ver);

        if ($cid !== null && $cid !== '') {
        	$ret_msg['cid'] = $cid;
        	$chat_data = wplc_get_chat_data( $cid );
        	wplc_record_chat_notification('user_loaded',$cid,array('uri' => $_SERVER['HTTP_REFERER'], 'chat_data' => $chat_data ));



	        if ( !isset($chat_data) || !$chat_data->agent_id ) {
	            $ret_msg['type'] = 'new';
	        } else {
	        	$ret_msg['type'] = 'returning';

	        	if(isset($wplc_settings['wplc_use_node_server']) && intval($wplc_settings['wplc_use_node_server']) == 1) {
	        		//This is using node, we shouldn't generate the header data as part of the chat box.
	        		//We will do this dynamically on the front end

	        		//var_dump("NOPEEE");

	        	} else {
		        	/* build the AGENT DATA array */
			        $wplc_acbc_data = get_option("WPLC_ACBC_SETTINGS");
			        $user_info = get_userdata( intval( $chat_data->agent_id ) );

			        $agent_tagline = '';
			        $agent_bio = '';
			        $a_twitter = '';
			        $a_linkedin = '';
			        $a_facebook = '';
			        $a_website = '';
			        $social_links = '';

			        if( isset( $wplc_acbc_data['wplc_use_wp_name'] ) && $wplc_acbc_data['wplc_use_wp_name'] == '1' ){

			            $agent = $user_info->display_name;
			        } else {
			            if (!empty($wplc_acbc_data['wplc_chat_name'])) {
			                $agent = $wplc_acbc_data['wplc_chat_name'];
			            } else {
			                $agent = 'Admin';
			            }
			        }

			        if( !isset( $data ) ){ $data = false; }

			        $agent_tagline = apply_filters( "wplc_filter_agent_data_agent_tagline", $agent_tagline, $cid, $chat_data, $agent, $wplc_acbc_data, $user_info, $data );
	                $agent_bio = apply_filters( "wplc_filter_agent_data_agent_bio", $agent_bio, $cid, $chat_data, $agent, $wplc_acbc_data, $user_info, $data );
	                $social_links = apply_filters( "wplc_filter_agent_data_social_links", $social_links, $cid, $chat_data, $agent, $wplc_acbc_data, $user_info, $data);

		        	$ret_msg['agent_data'] = array(
			                'email' => md5($user_info->user_email),
			                'name' => $agent,
			                'aid' => $user_info->ID,
			                'agent_tagline' => $agent_tagline,
			                'agent_bio' => $agent_bio,
			                "social_links" => $social_links
			            );
		        }

	        }


        } else {
        	$ret_msg['type'] = 'new';
        }


        if (function_exists("wplc_pro_version_control")) {
          if ($checker < 6000) {
            /* backwards compatibilitty for the old pro version */
            return json_encode($ret_msg['cbox']);
          } else {
            return json_encode($ret_msg);
          }

        } else {
          return json_encode($ret_msg);
        }






}
function wplc_return_default_theme($wplc_settings,$logged_in,$wplc_using_locale,$cid) {
	$ret_msg = apply_filters("wplc_filter_live_chat_box_html_main_div_top",wplc_filter_control_live_chat_box_html_main_div_top($wplc_settings,$logged_in,$wplc_using_locale));
    $ret_msg .= "<div class=\"wp-live-chat-wraper\">";
    $ret_msg .= 	"<div id='bleeper_bell' class='wplc-color-bg-1 wplc-color-2' style='display:none;'><i class='fa fa-bell'></i></div>";
    $ret_msg .=   apply_filters("wplc_filter_live_chat_box_html_header_div_top",wplc_filter_control_live_chat_box_html_header_div_top($wplc_settings));
    $ret_msg .= " <i id=\"wp-live-chat-minimize\" class=\"fa fa-minus wplc-color-bg-2 wplc-color-1\" style=\"display:none;\"></i>";
    $ret_msg .= " <i id=\"wp-live-chat-close\" class=\"fa fa-times\" style=\"display:none;\" ></i>";
    $ret_msg .= " <div id=\"wp-live-chat-1\" >";
    $ret_msg .=     apply_filters("wplc_filter_live_chat_box_html_1st_layer",wplc_filter_control_live_chat_box_html_1st_layer($wplc_settings,$logged_in,$wplc_using_locale,'wplc-color-2'));
    $ret_msg .= " </div>";
	$ret_msg .= '<div id="wplc-chat-alert" class="wplc-chat-alert wplc-chat-alert--' . $wplc_settings["wplc_theme"] . '"></div>';
	$ret_msg .= " </div>";
    $ret_msg .= " <div id=\"wp-live-chat-2\" style=\"display:none;\">";
    $ret_msg .= 	apply_filters("wplc_filter_live_chat_box_survey","");
    $ret_msg .=     apply_filters("wplc_filter_live_chat_box_html_2nd_layer",wplc_filter_control_live_chat_box_html_2nd_layer($wplc_settings,$logged_in,$wplc_using_locale,$cid), $cid);
    $ret_msg .= " </div>";
    $ret_msg .= " <div id=\"wp-live-chat-3\" style=\"display:none;\">";
    $ret_msg .=     apply_filters("wplc_filter_live_chat_box_html_3rd_layer",wplc_filter_control_live_chat_box_html_3rd_layer($wplc_settings,$wplc_using_locale));
    $ret_msg .= " </div>";
    $ret_msg .= " <div id=\"wp-live-chat-react\" style=\"display:none;\">";
    $ret_msg .= "   <p>".__("Reactivating your previous chat...", "wplivechat")."</p>";
    $ret_msg .= " </div>";
    $ret_msg .= " <div id=\"wplc-extra-div\" style=\"display:none;\">";
    $ret_msg .=     apply_filters("wplc_filter_wplc_extra_div","",$wplc_settings,$wplc_using_locale);
    $ret_msg .= "</div>";
    $ret_msg .= "</div>";
    $ret_msg .= " <div id=\"wp-live-chat-4\" style=\"display:none;\">";
    $ret_msg .=     apply_filters("wplc_filter_live_chat_box_html_4th_layer",wplc_filter_control_live_chat_box_html_4th_layer($wplc_settings,$wplc_using_locale, $cid));
    $ret_msg .= "</div>";
    return $ret_msg;
}


add_filter("wplc_theme_control","wplc_theme_control_function",10,4);
function wplc_theme_control_function($wplc_settings,$logged_in,$wplc_using_locale, $cid) {

  if (!$wplc_settings) { return ""; }
  if (isset($wplc_settings['wplc_newtheme'])) { $wplc_newtheme = $wplc_settings['wplc_newtheme']; } else { $wplc_newtheme = "theme-2"; }

  $default_theme = wplc_return_default_theme($wplc_settings,$logged_in,$wplc_using_locale, $cid);
  if (isset($wplc_newtheme)) {







    if($wplc_newtheme == 'theme-1') {
      $ret_msg = $default_theme;

    }
    else if($wplc_newtheme == 'theme-2') {
    $ret_msg = apply_filters("wplc_filter_live_chat_box_html_main_div_top",wplc_filter_control_live_chat_box_html_main_div_top($wplc_settings,$logged_in,$wplc_using_locale));
    $ret_msg .= "<div class=\"wp-live-chat-wraper\">";
    $ret_msg .= 	"<div id='bleeper_bell' class='wplc-color-bg-1  wplc-color-2' style='display:none;'><i class='fa fa-bell'></i></div>";
    $ret_msg .=   apply_filters("wplc_filter_live_chat_box_html_header_div_top",wplc_filter_control_live_chat_box_html_header_div_top($wplc_settings));
    $ret_msg .= " </div>";
	$ret_msg .= '<div id="wplc-chat-alert" class="wplc-chat-alert wplc-chat-alert--' . $wplc_settings["wplc_theme"] . '"></div>';
	$ret_msg .= " <div id=\"wp-live-chat-2\" style=\"display:none;\">";
    $ret_msg .= " 	<i id=\"wp-live-chat-minimize\" class=\"fa fa-minus wplc-color-bg-2 wplc-color-1\" style=\"display:none;\" ></i>";
    $ret_msg .= " 	<i id=\"wp-live-chat-close\" class=\"fa fa-times\" style=\"display:none;\" ></i>";
    $ret_msg .= " 	<div id=\"wplc-extra-div\" style=\"display:none;\">";
    $ret_msg .=     	apply_filters("wplc_filter_wplc_extra_div","",$wplc_settings,$wplc_using_locale);
    $ret_msg .= "	</div>";
    $ret_msg .= " 	<div id='wp-live-chat-inner-container'>";
    $ret_msg .= " 		<div id='wp-live-chat-inner'>";
    $ret_msg .= "   		<div id=\"wp-live-chat-1\" class=\"wplc-color-2 wplc-color-bg-1\" >";
    $ret_msg .=       			apply_filters("wplc_filter_live_chat_box_html_1st_layer",wplc_filter_control_live_chat_box_html_1st_layer($wplc_settings,$logged_in,$wplc_using_locale,'wplc-color-2'));
    $ret_msg .= "   		</div>";
    $ret_msg .=     		apply_filters("wplc_filter_live_chat_box_html_2nd_layer",wplc_filter_control_live_chat_box_html_2nd_layer($wplc_settings,$logged_in,$wplc_using_locale, $cid), $cid);
    $ret_msg .= " 		</div>";
    $ret_msg .= " 		<div id=\"wp-live-chat-react\" style=\"display:none;\">";
    $ret_msg .= "   		<p>".__("Reactivating your previous chat...", "wplivechat")."</p>";
    $ret_msg .= " 		</div>";
    $ret_msg .= " 	</div>";
    $ret_msg .= "   <div id=\"wp-live-chat-3\" style=\"display:none;\">";
    $ret_msg .=     	apply_filters("wplc_filter_live_chat_box_html_3rd_layer",wplc_filter_control_live_chat_box_html_3rd_layer($wplc_settings,$wplc_using_locale));
    $ret_msg .= "   </div>";
    $ret_msg .= " </div>";
    $ret_msg .= "   <div id=\"wp-live-chat-4\" style=\"display:none;\">";
    $ret_msg .=       apply_filters("wplc_filter_live_chat_box_html_4th_layer",wplc_filter_control_live_chat_box_html_4th_layer($wplc_settings,$wplc_using_locale, $cid));
    $ret_msg .= "   </div>";

    $ret_msg .= "</div>";

    } else {
      $ret_msg = $default_theme;
    }
  } else {
    $ret_msg = $default_theme;
  }

  return $ret_msg;
}


/**
 * THIS FUNCTION ONLY RUNS IF THE PRO VERSION IS LESS THAN 5.0.1
 * The new method is being handled with ajax
 * @return void
 */
function wplc_display_box() {

    global $wplc_pro_version;
    $wplc_ver = str_replace('.', '', $wplc_pro_version);
    $checker = intval($wplc_ver);

    if (function_exists("wplc_pro_version_control") && ($checker <= 501 || $checker == 4410)) {
        /* prior to latest pro version with ajax handling */

        if(function_exists('wplc_display_chat_contents')){
            $display_contents = wplc_display_chat_contents();
        } else {
            $display_contents = 1;
        }

        if(function_exists('wplc_is_user_banned_basic')){
            $user_banned = wplc_is_user_banned_basic();
        } else {
            $user_banned = 0;
        }
        if($display_contents && $user_banned == 0){
            $wplc_is_admin_logged_in = get_transient("wplc_is_admin_logged_in");
            if ($wplc_is_admin_logged_in != 1) {
                echo "<!-- wplc a-n-c -->";
            }

            /* do not show if pro is outdated */
            global $wplc_pro_version;
            if (isset($wplc_pro_version)) {
                $float_version = floatval($wplc_pro_version);
                if ($float_version < 4 || $wplc_pro_version == "4.1.0" || $wplc_pro_version == "4.1.1") {
                    return;
                }
            }

            if (function_exists("wplc_register_pro_version")) {
                $wplc_settings = get_option("WPLC_SETTINGS");
                if (!class_exists('Mobile_Detect')) {
                    require_once (plugin_dir_path(__FILE__) . 'includes/Mobile_Detect.php');
                }
                $wplc_detect_device = new Mobile_Detect;
                $wplc_is_mobile = $wplc_detect_device->isMobile();
                if ($wplc_is_mobile && !isset($wplc_settings['wplc_enabled_on_mobile']) && $wplc_settings['wplc_enabled_on_mobile'] != 1) {
                    return;
                }
                if (function_exists('wplc_basic_hide_chat_when_offline')) {
                    $wplc_hide_chat = wplc_basic_hide_chat_when_offline();
                    if (!$wplc_hide_chat) {
                        wplc_pro_draw_user_box();
                    }
                } else {
                    wplc_pro_draw_user_box();
                }
            } else {
                wplc_draw_user_box();
            }
        }
    }
}
function wplc_display_box_ajax() {

    if(function_exists('wplc_display_chat_contents')){
        $display_contents = wplc_display_chat_contents();
    } else {
        $display_contents = 1;
    }

    if(function_exists('wplc_is_user_banned')){
        $user_banned = wplc_is_user_banned();
    } else if (function_exists('wplc_is_user_banned')){
        $user_banned = wplc_is_user_banned_basic();
    } else {
        $user_banned = 0;
    }
    if($display_contents && $user_banned == 0){
        $wplc_is_admin_logged_in = get_transient("wplc_is_admin_logged_in");
        if ($wplc_is_admin_logged_in != 1) {
            return "";
        }

        /* do not show if pro is outdated */
        global $wplc_pro_version;
        if (isset($wplc_pro_version)) {
            $float_version = floatval($wplc_pro_version);
            if ($float_version < 4 || $wplc_pro_version == "4.1.0" || $wplc_pro_version == "4.1.1") {
                return;
            }
        }

        if (function_exists("wplc_register_pro_version")) {
            $wplc_settings = get_option("WPLC_SETTINGS");
            if (!class_exists('Mobile_Detect')) {
                require_once (plugin_dir_path(__FILE__) . 'includes/Mobile_Detect.php');
            }
            $wplc_detect_device = new Mobile_Detect;
            $wplc_is_mobile = $wplc_detect_device->isMobile();
            if ($wplc_is_mobile && !isset($wplc_settings['wplc_enabled_on_mobile']) && $wplc_settings['wplc_enabled_on_mobile'] != 1) {
                return;
            }
            if (function_exists('wplc_basic_hide_chat_when_offline')) {
                $wplc_hide_chat = wplc_basic_hide_chat_when_offline();
                if (!$wplc_hide_chat) {
                    wplc_pro_draw_user_box();
                }
            } else {
                wplc_pro_draw_user_box();
            }
        } else {
            wplc_draw_user_box();
        }
    }
}

function wplc_admin_display_chat($cid) {
    global $wpdb;
    global $wplc_tblname_msgs;
    $results = $wpdb->get_results(
        "
        SELECT *
        FROM $wplc_tblname_msgs
        WHERE `chat_sess_id` = '$cid'
        ORDER BY `timestamp` DESC
        LIMIT 0, 100
        "
    );
    foreach ($results as $result) {
        $from = $result->msgfrom;
        $msg = stripslashes($result->msg);
        $msg_hist .= "$from: $msg<br />";
    }
    echo $msg_hist;
}

function wplc_admin_accept_chat($cid) {
    $user_ID = get_current_user_id();
    wplc_change_chat_status(sanitize_text_field($cid), 3,$user_ID);
    return true;
}

add_action('admin_head', 'wplc_update_chat_statuses');


//add_action("wplc_hook_superadmin_head","wplc_hook_control_superadmin_head",10);
// Deprecated as this as now been added to wplc_heartbeat.js
function wplc_hook_control_superadmin_head() {
  $wplc_current_user = get_current_user_id();

  if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true )) {
    $ajax_nonce = wp_create_nonce("wplc");
    ?>
      <script type="text/javascript">
          jQuery(document).ready(function () {


              var wplc_set_transient = null;

              wplc_set_transient = setInterval(function () {
                  wpcl_admin_set_transient();
              }, 60000);
              wpcl_admin_set_transient();
              function wpcl_admin_set_transient() {
                  var data = {
                      action: 'wplc_admin_set_transient',
                      security: '<?php echo $ajax_nonce; ?>'

                  };
                  jQuery.post(ajaxurl, data, function (response) {

                  });
              }

          });
      </script>
    <?php
  }
}


function wplc_superadmin_javascript() {
    $wplc_settings = get_option("WPLC_SETTINGS");

    if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1 && (!isset($_GET['action']) || $_GET['action'] !== "history") ){

    	//Using node, remote scripts please
		if ( isset( $wplc_settings['wplc_enable_all_admin_pages'] ) && $wplc_settings['wplc_enable_all_admin_pages'] === '1' ) {
			/* Run admin JS on all admin pages */
			if ( isset( $_GET['action'] ) && $_GET['action'] == "history" ) {  }else {
           		wplc_admin_remote_dashboard_scripts($wplc_settings);
			}
		} else {
			/* Only run admin JS on the chat dashboard page */
			if ( isset( $_GET['page'] ) && $_GET['page'] === 'wplivechat-menu' && !isset( $_GET['action'] ) ) {
            	wplc_admin_remote_dashboard_scripts($wplc_settings);
			}
		}

        if( isset( $_GET['page'] ) && $_GET['page'] === "wplivechat-menu-offline-messages"){
            wplc_admin_output_js();
        }
    } else {
	    do_action("wplc_hook_superadmin_head");

		if ( isset( $_GET['page'] ) && isset( $_GET['action'] ) && $_GET['page'] == "wplivechat-menu" && ( $_GET['action'] != 'welcome' && $_GET['action'] != 'credits'  ) ) {
			/* admin chat box page */
	        if (function_exists("wplc_register_pro_version")) {
	            wplc_return_pro_admin_chat_javascript(sanitize_text_field($_GET['cid']));
	        } else {

	        	/** set the global chat data here so we dont need to keep getting it from the DB or Cloud server */
	        	global $admin_chat_data;
	        	$admin_chat_data = wplc_get_chat_data($_GET['cid'], __LINE__);
	        	
	            wplc_return_admin_chat_javascript(sanitize_text_field($_GET['cid']));


	        }
	        do_action("wplc_hook_admin_javascript_chat");
	 	} else {
			/* load this on every other admin page */
	        if (function_exists("wplc_register_pro_version")) {
	            wplc_pro_admin_javascript();
	        } else {
	            wplc_admin_javascript();
	        }
	        do_action("wplc_hook_admin_javascript");
	 	}


	    ?>
	    <script type="text/javascript">


	        function wplc_desktop_notification() {
	            if (typeof Notification !== 'undefined') {
	                if (!Notification) {
	                    return;
	                }
	                if (Notification.permission !== "granted")
	                    Notification.requestPermission();

	                var wplc_desktop_notification = new Notification('<?php _e('New chat received', 'wplivechat'); ?>', {
	                    icon: wplc_notification_icon_url,
	                    body: "<?php _e("A new chat has been received. Please go the 'Live Chat' page to accept the chat", "wplivechat"); ?>"
	                });
	                //Notification.close()
	            }
	        }

	    </script>
    	<?php

    }
}

function old_wplc_superadmin_javascript() {

    if (isset($_GET['page']) && ($_GET['page'] == 'wplivechat-menu' || $_GET['page'] == 'wplivechat-menu-settings' || $_GET['page'] == 'wplivechat-menu-offline-messages' || $_GET['page'] == 'wplc-pro-custom-fields' ) ) {

        if (!isset($_GET['action'])) {
            if (function_exists("wplc_register_pro_version")) {
                wplc_pro_admin_javascript();
            } else {
                wplc_admin_javascript();
            }
            do_action("wplc_hook_admin_javascript");
        } // main page
        else if ( isset($_GET['action']) && ( $_GET['action'] != 'welcome' && $_GET['action'] != 'credits' && $_GET['action'] != 'history'  ) ) {
            if (function_exists("wplc_register_pro_version")) {
                wplc_return_pro_admin_chat_javascript(sanitize_text_field($_GET['cid']));
            } else {

            	/** set the global chat data here so we dont need to keep getting it from the DB or Cloud server */
            	global $admin_chat_data;
            	$admin_chat_data = wplc_get_chat_data($_GET['cid'], __LINE__);

                wplc_return_admin_chat_javascript(sanitize_text_field($_GET['cid']));


            }
            do_action("wplc_hook_admin_javascript_chat");
        }
    }


    do_action("wplc_hook_superadmin_head");

    ?>
    <script type="text/javascript">


        function wplc_desktop_notification() {
            if (typeof Notification !== 'undefined') {
                if (!Notification) {
                    return;
                }
                if (Notification.permission !== "granted")
                    Notification.requestPermission();

                var wplc_desktop_notification = new Notification('<?php _e('New chat received', 'wplivechat'); ?>', {
                    icon: wplc_notification_icon_url,
                    body: "<?php _e("A new chat has been received. Please go the 'Live Chat' page to accept the chat", "wplivechat"); ?>"
                });
                //Notification.close()
            }
        }

    </script>
    <?php
}


/**
 * Admin JS set up
 * @return void
 * @since  6.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
function wplc_admin_javascript() {

	$wplc_settings = get_option("WPLC_SETTINGS");
	if ( isset( $wplc_settings['wplc_enable_all_admin_pages'] ) && $wplc_settings['wplc_enable_all_admin_pages'] === '1' ) {
		/* Run admin JS on all admin pages */
		if ( isset( $_GET['action'] ) && $_GET['action'] == "history" ) { return; }
		else {
			wplc_admin_output_js();
		}
	} else {
		/* Only run admin JS on the chat dashboard page */
		if ( isset( $_GET['page'] ) && $_GET['page'] === 'wplivechat-menu' && !isset( $_GET['action'] ) ) {
			wplc_admin_output_js();
		}
	}







}

/**
 * Outputs the admin JS on to the relevant pages, controlled by wplc_admin_javascript();
 *
 * @return void
 * @since  7.1.00
 * @author Nick Duncan
 */
function wplc_admin_output_js() {
    $continue = apply_filters( "wplc_version_check_continue", true );
    if ($continue === true) {


		$ajax_nonce = wp_create_nonce("wplc");
	    global $wplc_version;

	    $wplc_current_user = get_current_user_id();
	    if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true )) {

	      wp_register_script('wplc-admin-js', plugins_url('js/wplc_u_admin.js', __FILE__), false, $wplc_version, false);
	      wp_enqueue_script('wplc-admin-js');
	      $not_icon = plugins_url('/images/wplc_notification_icon.png', __FILE__);

	      $wplc_wav_file = plugins_url('/ring.wav', __FILE__);
	      $wplc_wav_file = apply_filters("wplc_filter_wav_file",$wplc_wav_file);
	      wp_localize_script('wplc-admin-js', 'wplc_wav_file', $wplc_wav_file);

	      wp_localize_script('wplc-admin-js', 'wplc_ajax_nonce', $ajax_nonce);

	      wp_localize_script('wplc-admin-js', 'wplc_notification_icon', $not_icon);

	      $extra_data = apply_filters("wplc_filter_admin_javascript",array());
	      wp_localize_script('wplc-admin-js', 'wplc_extra_data', $extra_data);

	      $ajax_url = admin_url('admin-ajax.php');
	      $wplc_ajax_url = apply_filters("wplc_filter_ajax_url",$ajax_url);
	      wp_localize_script('wplc-admin-js', 'wplc_ajaxurl', $wplc_ajax_url);
	      wp_localize_script('wplc-admin-js', 'wplc_ajaxurl_home', admin_url( 'admin-ajax.php' ) );

	      $wpc_ma_js_strings = array(
	          'remove_agent' => __('Remove', 'wplivechat'),
	          'nonce' => wp_create_nonce("wplc"),
	          'user_id' => get_current_user_id(),
	          'typing_string' => __('Typing...', 'wplivechat')

	      );
	      wp_localize_script('wplc-admin-js', 'wplc_admin_strings', $wpc_ma_js_strings);

	    }
	}
}

function wplc_admin_menu_layout() {

    do_action("wplc_hook_admin_menu_layout");
    if (function_exists("wplc_register_pro_version")) {
        global $wplc_pro_version;
        if (floatval($wplc_pro_version) < 4 || $wplc_pro_version == "4.1.0" || $wplc_pro_version == "4.1.1") {
            ?>
            <div class='error below-h1'>

                <p><?php _e("Dear Pro User", "wplivechat") ?><br /></p>
                <p><?php _e("You are using an outdated version of <strong>WP Live Chat Support Pro</strong>. Please", "wplivechat") ?> <a href="https://wp-livechat.com/get-updated-version/" target=\"_BLANK\"><?php _e("update to at least version", "wplivechat") ?> 4.0</a> <?php _e("to ensure all functionality is in working order", "wplivechat") ?>.</p>
                <p><strong><?php _e("You're live chat box on your website has been temporarily disabled until the Pro plugin has been updated. This is to ensure a smooth and hassle-free user experience for both yourself and your visitors.", "wplivechat") ?></strong></p>
                <p><?php _e("You can update your plugin <a href='./update-core.php'>here</a>, <a href='./plugins.php'>here</a> or <a href='https://wp-livechat.com/get-updated-version/' target='_BLANK'>here</a>.", "wplivechat") ?></strong></p>
                <p><?php _e("If you are having difficulty updating the plugin, please contact", "wplivechat") ?> nick@wp-livechat.com</p>

            </div>
            <?php
        }
        $wplc_ver = str_replace('.', '', $wplc_pro_version);
        $wplc_ver = intval($wplc_ver);
        if ($wplc_ver < 501) {
            ?>
            <div class='error below-h1'>

                <p><?php _e("Dear Pro User", "wplivechat") ?><br /></p>
                <p><?php _e("You are using an outdated version of <strong>WP Live Chat Support Pro</strong>.", "wplivechat") ?></p>
                <p>
                    <strong><?php _e("Please update to the latest version of WP Live Chat Support Pro", 'wplivechat'); ?>
                        <a href="https://wp-livechat.com/get-updated-version/" target=\"_BLANK\"> <?php _e("Version 5.0.1", "wplivechat"); ?></a>
                        <?php _e("to ensure everything is working correctly.", "wplivechat"); ?>
                    </strong>
                </p>
                <p><?php _e("You can update your plugin <a href='./update-core.php'>here</a>, <a href='./plugins.php'>here</a> or <a href='https://wp-livechat.com/get-updated-version/' target='_BLANK'>here</a>.", "wplivechat") ?></strong></p>
                <p><?php _e("If you are having difficulty updating the plugin, please contact", "wplivechat") ?> nick@wp-livechat.com</p>

            </div>
            <?php
        }
    }
    if ( ( get_option("WPLC_V8_FIRST_TIME") == true && !class_exists("APC_Object_Cache") ) || ( isset( $_GET['action'] ) && ( $_GET['action'] == 'welcome' || $_GET['action'] == 'credits' ) ) ){
        include 'includes/welcome_page.php';
        update_option('WPLC_V8_FIRST_TIME', false);
    } else {

        update_option('WPLC_V8_FIRST_TIME', false);
        $wplc_settings = get_option("WPLC_SETTINGS");
        if ( isset( $wplc_settings['wplc_use_node_server'] ) && $wplc_settings['wplc_use_node_server'] == 1 ) {
            //Node in use, load remote dashboard
            if ( $_GET['page'] === 'wplivechat-menu') {
                wplc_admin_dashboard_layout_node('dashboard');

                if( isset($_GET['action']) ){
                    wplc_admin_menu_layout_display();
                }
            } else {
                // we'll control this in admin_footer
                //wplc_admin_dashboard_layout_node('other');
            }

        } else {
            if (function_exists("wplc_register_pro_version")) {
                wplc_pro_admin_menu_layout_display();
            } else {
                wplc_admin_menu_layout_display();
            }
        }
    }
}



function wplc_first_time_tutorial() {
    if (!get_option('WPLC_FIRST_TIME_TUTORIAL')) {

        global $wplc_basic_plugin_url;
        ?>


        <div id="wplcftt" style='margin-top:30px; margin-bottom:20px; width: 65%; background-color: #FFF; box-shadow: 1px 1px 3px #ccc; display:block; padding:10px; text-align:center; margin-left:auto; margin-right:auto;'>
            <img src='<?php echo $wplc_basic_plugin_url; ?>/images/wplc_notification_icon.png' width="130" align="center" />
            <h1 style='font-weight: 300; font-size: 50px; line-height: 50px;'><strong style="color: #ec822c;"><?php _e("Congratulations","wplivechat"); ?></strong></h1>
            <h2><strong><?php _e("You are now accepting live chat requests on your site.","wplivechat"); ?></strong></h2>
            <p><?php _e("The live chat box has automatically been enabled on your website.","wplivechat"); ?></p>
            <p><?php _e("Chat notifications will start appearing once visitors send a request.","wplivechat"); ?></p>
            <p><?php _e("You may <a href='?page=wplivechat-menu-settings' target='_BLANK'>modify your chat box settings here.","wplivechat"); ?></a></p>
            <p><?php _e("Experiencing issues?","wplivechat"); ?> <a href="https://wp-livechat.com/documentation/troubleshooting/" target="_BLANK" title=""><?php _e("Visit our troubleshooting section.","wplivechat"); ?></a></p>

            <p><button id="wplc_close_ftt" class="button button-secondary"><?php _e("Hide","wplivechat"); ?></button></p>

        </div>

    <?php }
}


/**
 * Control the content below the visitor count
 * @return void
 * @since  6.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
add_filter("wplc_filter_chat_dahsboard_visitors_online_bottom","wplc_filter_control_chat_dashboard_visitors_online_bottom",10);
function wplc_filter_control_chat_dashboard_visitors_online_bottom($text) {
  $text = "<hr />";
  $text .= "<p class='wplc-agent-info' id='wplc-agent-info'>";
  $text .= "  <span class='wplc_agents_online'>1</span>";
  $text .= "  <a href='javascript:void(0);'>".__("Agent(s) online","wplivechat")."</a>";
  $text .= "</p>";
  return $text;
}


add_action("wplc_hook_chat_dashboard_bottom","wplc_hook_control_chat_dashboard_bottom",10);
/**
 * Decides whether or not to show the available extensions for this area.
 * @return void
 * @since  6.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
function wplc_hook_control_chat_dashboard_bottom() {
  echo "<p id='wplc_footer_message' style='display:none;'>";
  ?>
  <?php _e("With the Pro add-on of WP Live Chat Support, you can", "wplivechat"); ?>
  <a href="http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=initiate1" title="<?php _e("see who's online and initiate chats", "wplivechat"); ?>" target=\"_BLANK\">
     <?php _e("initiate chats", "wplivechat"); ?>
  </a> <?php _e("with your online visitors with the click of a button.", "wplivechat"); ?>
  <a href="http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=initiate2" title="<?php _e("Buy the Pro add-on now.", "wplivechat"); ?>" target=\"_BLANK\">
     <strong>
         <?php _e("Buy the Pro add-on now.", "wplivechat"); ?>
     </strong>
  </a>
  <?php
  echo "</p>";



}


function wplc_admin_menu_layout_display() {

    $wplc_current_user = get_current_user_id();

    if( get_user_meta( $wplc_current_user, 'wplc_ma_agent', true ) ){
    /*
      -- modified in in 6.0.04 --

      if(current_user_can('wplc_ma_agent') || current_user_can('manage_options')){
     */
        do_action("wplc_hook_admin_menu_layout_display_top");

        wplc_stats("chat_dashboard");

        global $wplc_basic_plugin_url;
        if (!isset($_GET['action'])) {
            ?>
        <style>
          #wplc-support-tabs a.wplc-support-link {
            background: url('<?php echo $wplc_basic_plugin_url; ?>/images/support.png');
            right: 0px;
            top: 250px;
            height: 108px;
            width: 45px;
            margin: 0;
            padding: 0;
            position: fixed;
            z-index: 9999;
            display:block;
          }
        </style>
        	<div class='wplc_network_issue' style='display:none;'>

        	</div>

            <div id="wplc-support-tabs">
                <a class="wplc-support-link wplc-rotate" href="?page=wplivechat-menu-support-page"></a>
            </div>
            <div class='wplc_page_title'>
            	<img src='<?php echo WPLC_BASIC_PLUGIN_URL; ?>images/wplc-logo.png' class='wplc-logo' />
                <?php wplc_first_time_tutorial(); ?>
				<?php do_action("wplc_hook_chat_dashboard_above"); ?>

                <p><?php _e("Please note: This window must be open in order to receive new chat notifications.", "wplivechat"); ?></p>
            </div>

            <?php
	            $continue = apply_filters( "wplc_version_check_continue", true );
	            if ($continue !== true) {

	             echo "<hr />";
	             echo "<center>";
	             echo "<h1>".$continue."</h1>";
	             echo "<p>".sprintf( __( 'Need help? <a href="%s" target="_BLANK">contact us</a>.', 'wplivechat'),'https://wp-livechat.com/contact-us/')."</p>";
	             echo "</center>";


	            } else {

            ?>


            <div id="wplc_sound"></div>

            <div id="wplc_admin_chat_holder">
                <div id='wplc_admin_chat_info_new'>
                    <div class='wplc_chat_vis_count_box'>
                        <?php do_action("wplc_hook_chat_dahsboard_visitors_online_top"); ?>
                        <span class='wplc_vis_online'>0</span>
                        <span style='text-transform:uppercase;'>
                            <?php _e("Visitors online","wplivechat"); ?>
                        </span>
                        <?php echo apply_filters("wplc_filter_chat_dahsboard_visitors_online_bottom",""); ?>


                    </div>

                    <?php do_action("wplc_after_chat_visitor_count_hook"); ?>

                </div>

                <div id="wplc_admin_chat_area_new">
                    <div style="display:block;padding:10px;">
                    <ul class='wplc_chat_ul_header'>
                        <li><span class='wplc_header_vh wplc_headerspan_v'><?php _e("Visitor","wplivechat"); ?></span></li>
                        <li><span class='wplc_header_vh wplc_headerspan_t'><?php _e("Time","wplivechat"); ?></span></li>
                        <li><span class='wplc_header_vh wplc_headerspan_nr'><?php _e("Type","wplivechat"); ?></span></li>
                        <li><span class='wplc_header_vh wplc_headerspan_dev'><?php _e("Device","wplivechat"); ?></span></li>
                        <li><span class='wplc_header_vh wplc_headerspan_d'><?php _e("Data","wplivechat"); ?></span></li>
                        <li><span class='wplc_header_vh wplc_headerspan_s'><?php _e("Status","wplivechat"); ?></span></li>
                        <li><span class='wplc_header_vh wplc_headerspan_a'><?php _e("Action","wplivechat"); ?></span></li>
                    </ul>
                    <ul id='wplc_chat_ul'>
                    </ul>
                    <br />
                    <hr />
                    <?php do_action("wplc_hook_chat_dashboard_bottom"); ?>

                    </div>

                </div>
            </div>
            <?php } ?>




            <?php
        } else {
            if (isset($_GET['aid'])) { $aid = $_GET['aid']; } else { $aid = null; }
            do_action("wplc_hook_admin_menu_layout_display_1",$_GET['action'],$_GET['cid'],$aid);

            if (!is_null($aid)) {
                do_action("wplc_hook_update_agent_id",$_GET['cid'],$aid);
            }

            do_action("wplc_hook_admin_menu_layout_display_1",$_GET['action'],$_GET['cid'],$aid);

            if ($_GET['action'] == 'ac') {
                do_action('wplc_hook_accept_chat',$_GET,$aid);
            }
            do_action("wplc_hook_admin_menu_layout_display",$_GET['action'],$_GET['cid'],$aid);
        }
    } else {
      ?>

      <h1><?php _e("Chat Dashboard","wplivechat"); ?></h1>
      <div id="welcome-panel" class="welcome-panel">
        <div class="welcome-panel-content">
          <h2><?php _e("Oh no!","wplivechat"); ?></h2>
          <p class="about-description">
            <?php _e(
            "You do not have access to this page as <strong>you are not a chat agent</strong>.",
            "wplivechat"
            ); ?>
          </p>
          <p>Users with access to this page are as follows:</p>
          <p>
            <?php
             $user_array = get_users(array(
                'meta_key' => 'wplc_ma_agent',
            ));
             echo "<ol>";
            if ($user_array) {
              foreach ($user_array as $user) {
                echo "<li> ".$user->display_name . " (ID: ".$user->ID.")</li>";
              }
            }
             echo "</ol>";
            ?>
          </p>
        </div>
      </div>
      <?php
    }
}

add_action("wplc_hook_change_status_on_answer","wplc_hook_control_change_status_on_answer",10,2);
function wplc_hook_control_change_status_on_answer($get_data, $chat_data = false) {

  $user_ID = get_current_user_id();
  wplc_change_chat_status(sanitize_text_field($get_data['cid']), 3,$user_ID );
  wplc_record_chat_notification("joined",$get_data['cid'],array("aid"=>$user_ID));
}


add_action('wplc_hook_accept_chat','wplc_hook_control_accept_chat',10,2);
function wplc_hook_control_accept_chat($get_data,$aid) {

	global $admin_chat_data;

	if (!$admin_chat_data) {
		$chat_data = wplc_get_chat_data($get_data['cid'], __LINE__);
	} else {
		if (isset($admin_chat_data->id) && intval($admin_chat_data->id) === intval($get_data['cid'])) {
			$chat_data = $admin_chat_data;
		} else {
			/* chat ID's dont match, get the data for the correct chat ID */
			$chat_data = wplc_get_chat_data($get_data['cid'], __LINE__);
		}
	}





	do_action("wplc_hook_accept_chat_url",$get_data, $chat_data);

  	do_action("wplc_hook_change_status_on_answer",$get_data, $chat_data);


	if (function_exists("wplc_register_pro_version")) {
		/* backwards compatibility */
		wplc_pro_draw_chat_area(sanitize_text_field($get_data['cid']));
	} else {
		do_action("wplc_hook_draw_chat_area",$get_data, $chat_data);

	}


}

/**
* Hook to accept chat
*
* @since        7.1.00
* @param
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za)
*
*/
add_action( 'wplc_hook_accept_chat_url' , 'wplc_b_hook_control_accept_chat_url', 5, 2);
remove_action( 'wplc_hook_accept_chat_url' , 'wplc_ma_hook_control_accept_chat_url', 10, 2); /* remove the older Pro hook as this was moved now to the basic version in 7.1.00 */
function wplc_b_hook_control_accept_chat_url($get_data, $chat_data = false) {
    if (!isset($get_data['agent_id'])) {
    	/* free version */
        wplc_b_update_agent_id(sanitize_text_field($get_data['cid']), get_current_user_id());
    } else {
        wplc_b_update_agent_id(sanitize_text_field($get_data['cid']), sanitize_text_field($get_data['agent_id']));
    }

}

/**
* Assign the chat to the agent
*
* Replaces the same function of a different name in the older pro version
*
* @since        7.1.00
* @param
* @return       void
* @author       Nick Duncan (nick@codecabin.co.za)
*
*/
function wplc_b_update_agent_id($cid, $aid){
    global $wpdb;
    global $wplc_tblname_chats;
    $sql = "SELECT * FROM `$wplc_tblname_chats` WHERE `id` = '$cid' LIMIT 1";
    $result = $wpdb->get_row($sql);
    if ($result) {
	    if(intval($result->status) != 3){
	        $update = "UPDATE `$wplc_tblname_chats` SET `agent_id` = '$aid' WHERE `id` = '$cid' LIMIT 1";
	        $wpdb->query($update);
	    }
	}
}



add_action("wplc_hook_chat_dashboard_bottom","wplc_hook_control_app_chat_dashboard_bottom",10);
function wplc_hook_control_app_chat_dashboard_bottom() {
	//echo "<p>Tired of logging in to accept chats? Use our <a href='https://wp-livechat.com/extensions/mobile-desktop-app-extension/?utm_source=plugin&utm_medium=plugin&utm_campaign=main_app' target='_BLANK'>Android app</a> or <a href='https://wp-livechat.com/extensions/mobile-desktop-app-extension/?utm_source=plugin&utm_medium=plugin&utm_campaign=main_desktop' target='_BLANK'>desktop app</a> to monitor visitors, accept and initiate chats.</p>";
}

add_action("wplc_hook_draw_chat_area","wplc_hook_control_draw_chat_area",10,2);
function wplc_hook_control_draw_chat_area($get_data, $chat_data = false) {

  wplc_draw_chat_area(sanitize_text_field($get_data['cid']), $chat_data);
}

function wplc_draw_chat_area($cid, $chat_data = false) {

    global $wpdb;
    global $wplc_tblname_chats;

    $results = $wpdb->get_results(
            "
        SELECT *
        FROM $wplc_tblname_chats
        WHERE `id` = '$cid'
        LIMIT 1
        "
    );
    if ($results) { } else {  $results[0] = null; } /* if chat ID doesnt exist, create the variable anyway to avoid an error. Hopefully the Chat ID exists on the server..! */


    $result = apply_filters("wplc_filter_chat_area_data", $results[0], $cid);


    ?>
    <style>

        .wplc-clear-float-message{
            clear: both;
        }

        .rating{
            background-color: lightgray;
            width: 80px;
            padding: 2px;
            border-radius: 4px;
            text-align: center;
            color: white;
            display: inline-block;
            float: right;
        }

        .rating-bad {
            background-color: #AF0B0B !important;
        }

        .rating-good {
            background-color: #368437 !important;
        }


    </style>
    <?php

      $user_data = maybe_unserialize($result->ip);
      $user_ip = isset($user_data['ip']) ? $user_data['ip'] : 'Unknown';
      $browser = isset($user_data['user_agent']) ? wplc_return_browser_string($user_data['user_agent']) : "Unknown";
      $browser_image = wplc_return_browser_image($browser, "16");


      global $wplc_basic_plugin_url;
      if ($result->status == 1) {
          $status = __("Previous", "wplivechat");
      } else {
          $status = __("Active", "wplivechat");
      }

      if($user_ip == ""){
          $user_ip = __('IP Address not recorded', 'wplivechat');
      } else {
          $user_ip = "<a href='http://www.ip-adress.com/ip_tracer/" . $user_ip . "' title='".__('Whois for' ,'wplivechat')." ".$user_ip."' target='_BLANK'>".$user_ip."</a>";
      }

	echo "<h2>$status " . __( 'Chat with', 'wplivechat' ) . " " . sanitize_text_field($result->name) . "</h2>";
	if ( isset( $_GET['action'] ) && 'history' === $_GET['action'] ) {
		echo "<span class='wplc-history__date'><strong>" . __( 'Starting Time:', 'wplivechat' ) . "</strong>" . date( 'Y-m-d H:i:s', current_time( strtotime( $result->timestamp ) ) ) . "</span>";
		echo "<span class='wplc-history__date wplc-history__date-end'><strong>" . __( 'Ending Time:', 'wplivechat' ) . "</strong>" . date( 'Y-m-d H:i:s', current_time( strtotime( $result->last_active_timestamp ) ) ) . "</span>";
	}
      echo "<style>#adminmenuwrap { display:none; } #adminmenuback { display:none; } #wpadminbar { display:none; } #wpfooter { display:none; } .update-nag { display:none; }</style>";

      echo "<div class=\"end_chat_div\">";

      do_action("wplc_admin_chat_area_before_end_chat_button", $result);

      echo "<a href=\"javascript:void(0);\" class=\"wplc_admin_close_chat button\" id=\"wplc_admin_close_chat\">" . __("End chat", "wplivechat") . "</a>";

      do_action("wplc_admin_chat_area_after_end_chat_button", $result);

      echo "</div>";

      do_action("wplc_add_js_admin_chat_area", $cid, $chat_data);

      echo "<div id='admin_chat_box'>";

      $result->continue = true;

      do_action("wplc_hook_wplc_draw_chat_area",$result);

      if (!$result->continue) { return; }

      echo"<div class='admin_chat_box'><div class='admin_chat_box_inner' id='admin_chat_box_area_" . $result->id . "'>".apply_filters( "wplc_chat_box_draw_chat_box_inner", "", $cid)."</div><div class='admin_chat_box_inner_bottom'>" . wplc_return_chat_response_box($cid, $result) . "</div>";


      echo "</div>";
      echo "<div class='admin_visitor_info'>";
      do_action("wplc_hook_admin_visitor_info_display_before",$cid);


      echo "  <div style='float:left; width:100px;'><img src=\"//www.gravatar.com/avatar/" . md5($result->email) . "\" class=\"admin_chat_img\" /></div>";
      echo "  <div style='float:left;'>";

      echo "      <div class='admin_visitor_info_box1'>";
      echo "          <span class='admin_chat_name'>" . sanitize_text_field($result->name) . "</span>";
      echo "          <span class='admin_chat_email'>" . sanitize_text_field($result->email) . "</span>";
      echo "      </div>";
      echo "  </div>";

      echo "  <div class='admin_visitor_advanced_info'>";
      echo "      <strong>" . __("Site Info", "wplivechat") . "</strong>";
      echo "      <hr />";
      echo "      <span class='part1'>" . __("Chat initiated on:", "wplivechat") . "</span> <span class='part2'>" . esc_url($result->url) . "</span>";
      echo "  </div>";

      echo "  <div class='admin_visitor_advanced_info'>";
      echo "      <strong>" . __("Advanced Info", "wplivechat") . "</strong>";
      echo "      <hr />";
      echo "      <span class='part1'>" . __("Browser:", "wplivechat") . "</span><span class='part2'> $browser <img src='" . $wplc_basic_plugin_url . "/images/$browser_image' alt='$browser' title='$browser' /><br />";
      echo "      <span class='part1'>" . __("IP Address:", "wplivechat") . "</span><span class='part2'> ".sanitize_text_field($user_ip);
      echo "  </div>";
	  echo "<hr />";

      echo (apply_filters("wplc_filter_advanced_info","", sanitize_text_field($result->id), sanitize_text_field($result->name), $result));

      echo "  <div id=\"wplc_sound_update\"></div>";

      echo "<div class='wplc_bottom_chat_info_container'>";
      echo "<h3>".__("Add-ons","wplivechat")."</h3>";
      do_action("wplc_hook_admin_visitor_info_display_after",$cid);
      echo "<a href='".admin_url('admin.php?page=wplivechat-menu-extensions-page')."' class='button button-primary' target='_BLANK'>".__("Get more add-ons","wplivechat")."</a>";
      echo "</div>";

      echo "</div>";

      if ($result->status != 1) {

          do_action("wplc_hook_admin_below_chat_box",$result);
      }

}


add_action("wplc_hook_admin_below_chat_box","wplc_hook_control_admin_below_chat_box",10);
function wplc_hook_control_admin_below_chat_box() {
    echo "<div class='admin_chat_quick_controls'>";
    echo "  <p style=\"text-align:left; font-size:11px;\">" . __('Press ENTER to send your message', 'wplivechat') . "</p>";
    echo "  " . __("Assign Quick Response", "wplivechat") . " <select name='wplc_macros_select' class='wplc_macros_select' disabled><option>" . __('Select', 'wplivechat') . "</option></select> <a href='https://wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=quick_resposnes' title='" . __('Add Quick Responses to your Live Chat', 'wplivechat') . "' target='_BLANK'>" . __("Pro version only", "wplivechat") . "</a>";
    echo "  </div>";
    echo "</div>";

}

function wplc_return_chat_response_box($cid, $chat_data = false) {

    $ret = "<div class=\"chat_response_box\">";
    $ret .= apply_filters("wplc_filter_typing_control_div","");
    $ret .= "<input type='text' name='wplc_admin_chatmsg' id='wplc_admin_chatmsg' value='' placeholder='" . __("type here...", "wplivechat") . "' />";

    $ret .= apply_filters("wplc_filter_chat_upload","");
    $ret .= (!function_exists("nifty_text_edit_div") ? apply_filters("wplc_filter_chat_text_editor_upsell","") : apply_filters("wplc_filter_chat_text_editor",""));

    $ret .= "<input id='wplc_admin_cid' type='hidden' value='$cid' />";
    $ret .= "<input id='wplc_admin_send_msg' type='button' value='" . __("Send", "wplivechat") . "' style=\"display:none;\" />";
    $ret .= "</div>";
    return $ret;
}

function wplc_return_admin_chat_javascript($cid) {
    $ajax_nonce = wp_create_nonce("wplc");
    global $wplc_version;

    $wplc_settings = get_option("WPLC_SETTINGS");

    wp_register_script('wplc-admin-chat-server', plugins_url('js/wplc_server.js', __FILE__), false, $wplc_version, false);
    wp_enqueue_script('wplc-admin-chat-server');

	wp_localize_script( 'wplc-admin-chat-server', 'wplc_datetime_format', array(
		'date_format' => get_option( 'date_format' ),
		'time_format' => get_option( 'time_format' ),
	) );

    global $admin_chat_data;
    if (!$admin_chat_data) {
    	$cdata = wplc_get_chat_data($cid, __LINE__);
    } else {
    	/* copy the stored admin chat data variable - more efficient */
    	$cdata = $admin_chat_data;
    }

	$other = maybe_unserialize($cdata->other);

    if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1){
		if (isset($other['socket']) && ($other['socket'] == true || $other['socket'] == "true")) {
			if ( isset( $_GET['action'] ) && $_GET['action'] === 'history') {
				wp_localize_script('wplc-admin-chat-server', 'wplc_use_node_server', "false");
			} else {
				wp_localize_script('wplc-admin-chat-server', 'wplc_use_node_server', "true");
				wp_localize_script('wplc-admin-chat-server', 'wplc_localized_string_is_typing_single', __(" is typing...","wplivechat"));
			}

    		$wplc_node_token = get_option("wplc_node_server_secret_token");
	    	if(!$wplc_node_token){
		    	if(function_exists("wplc_node_server_token_regenerate")){
			        wplc_node_server_token_regenerate();
			        $wplc_node_token = get_option("wplc_node_server_secret_token");
			    }
			}
	    	wp_localize_script('wplc-admin-chat-server', 'bleeper_api_key', $wplc_node_token);
		}
    }

    /**
     * Create a JS object for all Agent ID's and Gravatar MD5's
     */
    $user_array = get_users(array(
        'meta_key' => 'wplc_ma_agent',
    ));

    $a_array = array();
    if ($user_array) {
        foreach ($user_array as $user) {
        	$a_array[$user->ID] = array();
        	$a_array[$user->ID]['name'] = $user->display_name;
        	$a_array[$user->ID]['md5'] = md5( $user->user_email );
        }
    }
	wp_localize_script('wplc-admin-chat-server', 'wplc_agent_data', $a_array);

    /**
     * Get the CURRENT agent's data
     */
    if(isset($_GET['aid'])){
    	$agent_data = get_user_by('ID', intval($_GET['aid']));
    	wp_localize_script('wplc-admin-chat-server', 'wplc_admin_agent_name', $agent_data->display_name);
    	wp_localize_script('wplc-admin-chat-server', 'wplc_admin_agent_email', md5($agent_data->user_email));
 	} else {
 		$agent_data = get_user_by('ID', intval(get_current_user_id()));
    	wp_localize_script('wplc-admin-chat-server', 'wplc_admin_agent_name', $agent_data->display_name);
    	wp_localize_script('wplc-admin-chat-server', 'wplc_admin_agent_email', md5($agent_data->user_email));
 	}


	wp_register_script('wplc-admin-chat-js', plugins_url('js/wplc_u_admin_chat.js', __FILE__), array('wplc-admin-chat-server'), $wplc_version, false);
	wp_enqueue_script('wplc-admin-chat-js');


    global $wplc_pro_version;
    $wplc_ver = str_replace('.', '', $wplc_pro_version);
    $checker = intval($wplc_ver);
    if (isset($wplc_settings['wplc_theme'])) { $wplc_theme = $wplc_settings['wplc_theme']; } else { $wplc_theme = "theme-default"; }

    if ( (isset($wplc_theme) && $checker >= 6000 ) || (! function_exists("wplc_pro_version_control") ) )  {
      if($wplc_theme == 'theme-default') {
        wp_register_style('wplc-theme-palette-default', plugins_url('/css/themes/theme-default.css', __FILE__), array(), $wplc_version);
        wp_enqueue_style('wplc-theme-palette-default');

      }
      else if($wplc_theme == 'theme-1') {
        wp_register_style('wplc-theme-palette-1', plugins_url('/css/themes/theme-1.css', __FILE__), array(), $wplc_version);
        wp_enqueue_style('wplc-theme-palette-1');

      }
      else if($wplc_theme == 'theme-2') {
        wp_register_style('wplc-theme-palette-2', plugins_url('/css/themes/theme-2.css', __FILE__), array(), $wplc_version);
        wp_enqueue_style('wplc-theme-palette-2');

      }
      else if($wplc_theme == 'theme-3') {
        wp_register_style('wplc-theme-palette-3', plugins_url('/css/themes/theme-3.css', __FILE__), array(), $wplc_version);
        wp_enqueue_style('wplc-theme-palette-3');

      }
      else if($wplc_theme == 'theme-4') {
        wp_register_style('wplc-theme-palette-4', plugins_url('/css/themes/theme-4.css', __FILE__), array(), $wplc_version);
        wp_enqueue_style('wplc-theme-palette-4');

      }
      else if($wplc_theme == 'theme-5') {
        wp_register_style('wplc-theme-palette-5', plugins_url('/css/themes/theme-5.css', __FILE__), array(), $wplc_version);
        wp_enqueue_style('wplc-theme-palette-5');

      }
      else if($wplc_theme == 'theme-6') {
        /* custom */
        /* handled elsewhere */



      }
  	}
	$wplc_settings = get_option("WPLC_SETTINGS");
	$wplc_user_data = get_user_by( 'id', get_current_user_id() );

	if (isset($cdata->agent_id)) {
		$wplc_agent_data = get_user_by( 'id', intval( $cdata->agent_id ) );
	}


	if( isset($wplc_settings['wplc_show_name']) && $wplc_settings['wplc_show_name'] == '1' ){ $wplc_show_name = true; } else { $wplc_show_name = false; }
    if( isset($wplc_settings['wplc_show_avatar']) && $wplc_settings['wplc_show_avatar'] ){ $wplc_show_avatar = true; } else { $wplc_show_avatar = false; }
	if( isset($wplc_settings['wplc_show_date']) && $wplc_settings['wplc_show_date'] == '1' ){ $wplc_show_date = true; } else { $wplc_show_date = false; }
	if( isset($wplc_settings['wplc_show_time']) && $wplc_settings['wplc_show_time'] == '1' ){ $wplc_show_time = true; } else { $wplc_show_time = false; }

 	$wplc_chat_detail = array( 'name' => $wplc_show_name, 'avatar' => $wplc_show_avatar, 'date' => $wplc_show_date, 'time' => $wplc_show_time );


	wp_enqueue_script('wplc-admin-chat-js');
	wp_localize_script( 'wplc-admin-chat-js', 'wplc_show_chat_detail', $wplc_chat_detail );



	if (!empty( $wplc_agent_data ) ) {
		wp_localize_script( 'wplc-admin-chat-js', 'wplc_agent_name', $wplc_agent_data->display_name );
        wp_localize_script( 'wplc-admin-chat-js', 'wplc_agent_email', md5( $wplc_agent_data->user_email ) );
	} else {
		wp_localize_script( 'wplc-admin-chat-js', 'wplc_agent_name', ' ' );
		wp_localize_script( 'wplc-admin-chat-js', 'wplc_agent_email', ' ' );
	}

    wp_localize_script('wplc-admin-chat-js', 'wplc_chat_name', $cdata->name);
    wp_localize_script('wplc-admin-chat-js', 'wplc_chat_email', md5($cdata->email));

    if(class_exists("WP_REST_Request")) {
	    wp_localize_script('wplc-admin-chat-js', 'wplc_restapi_enabled', '1');
	    wp_localize_script('wplc-admin-chat-js', 'wplc_restapi_token', get_option('wplc_api_secret_token'));
		wp_localize_script('wplc-admin-chat-js', 'wplc_restapi_endpoint', rest_url('wp_live_chat_support/v1'));
        } else {
    	wp_localize_script('wplc-admin-chat-js', 'wplc_restapi_enabled', '0');
    }


    if (function_exists("wplc_pro_get_admin_picture")) {
      $src = wplc_pro_get_admin_picture();
      if ($src) {
          $image = "<img src=" . $src . " width='20px' id='wp-live-chat-2-img'/>";
      } else {
        $image = " ";
      }
    } else {
      $image = " ";
    }
    $admin_pic = $image;
    wp_localize_script('wplc-admin-chat-js', 'wplc_localized_string_is_typing', __("is typing...","wplivechat"));
    wp_localize_script('wplc-user-script', 'wplc_localized_string_admin_name', apply_filters( 'wplc_filter_admin_name', 'Admin' ) );
    wp_localize_script('wplc-admin-chat-js', 'wplc_ajax_nonce', $ajax_nonce);
    wp_localize_script('wplc-admin-chat-js', 'admin_pic', $admin_pic);

    $wplc_ding_file = plugins_url('/ding.mp3', __FILE__);
    $wplc_ding_file = apply_filters( 'wplc_filter_message_sound', $wplc_ding_file );
    wp_localize_script('wplc-admin-chat-js', 'wplc_ding_file', $wplc_ding_file);

    $extra_data = apply_filters("wplc_filter_admin_javascript",array());
    wp_localize_script('wplc-admin-chat-js', 'wplc_extra_data', $extra_data);

    if (isset($wplc_settings['wplc_display_name']) && $wplc_settings['wplc_display_name'] == 1) {
        $display_name = 'display';
    } else {
        $display_name = 'hide';
    }
    if (isset($wplc_settings['wplc_enable_msg_sound']) && intval($wplc_settings['wplc_enable_msg_sound']) == 1) {
        $enable_ding = '1';
    } else {
        $enable_ding = '0';
    }
    if (isset($_COOKIE['wplc_email']) && $_COOKIE['wplc_email'] != "") {
        $wplc_user_email_address = sanitize_text_field($_COOKIE['wplc_email']);
    } else {
        $wplc_user_email_address = " ";
    }

    wp_localize_script('wplc-admin-chat-js', 'wplc_name', $display_name);
    wp_localize_script('wplc-admin-chat-js', 'wplc_enable_ding', $enable_ding);

    $ajax_url = admin_url('admin-ajax.php');
	$home_ajax_url = $ajax_url;

    $wplc_ajax_url = apply_filters("wplc_filter_ajax_url",$ajax_url);
    wp_localize_script('wplc-admin-chat-js', 'wplc_ajaxurl', $wplc_ajax_url);
    wp_localize_script('wplc-admin-chat-js', 'wplc_home_ajaxurl', $home_ajax_url);



    $wplc_url = admin_url('admin.php?page=wplivechat-menu&action=ac&cid=' . $cid);
    wp_localize_script('wplc-admin-chat-js', 'wplc_url', $wplc_url);


    $wplc_string1 = __("User has opened the chat window", "wplivechat");
    $wplc_string2 = __("User has minimized the chat window", "wplivechat");
    $wplc_string3 = __("User has maximized the chat window", "wplivechat");
    $wplc_string4 = __("The chat has been ended", "wplivechat");
    wp_localize_script('wplc-admin-chat-js', 'wplc_string1', $wplc_string1);
    wp_localize_script('wplc-admin-chat-js', 'wplc_string2', $wplc_string2);
    wp_localize_script('wplc-admin-chat-js', 'wplc_string3', $wplc_string3);
    wp_localize_script('wplc-admin-chat-js', 'wplc_string4', $wplc_string4);
    wp_localize_script('wplc-admin-chat-js', 'wplc_cid', $cid);


    do_action("wplc_hook_admin_chatbox_javascript");

}

function wplc_activate() {
    wplc_handle_db();
    if (!get_option("WPLC_SETTINGS")) {
        $wplc_alt_text = __("Please click \'Start Chat\' to initiate a chat with an agent", "wplivechat");
	    $wplc_default_visitor_name = __( "Guest", "wplivechat" );
	    $wplc_admin_email = get_option('admin_email');

        $wplc_default_settings_array = array(
            "wplc_settings_align" => "2",
            "wplc_settings_enabled" => "1",
            "wplc_powered_by_link" => "0",
            "wplc_settings_fill" => "ed832f",
            "wplc_settings_font" => "FFFFFF",
            "wplc_settings_color1" => "ED832F",
            "wplc_settings_color2" => "FFFFFF",
            "wplc_settings_color3" => "EEEEEE",
            "wplc_settings_color4" => "666666",
            "wplc_theme" => "theme-default",
            "wplc_newtheme" => "theme-2",
            "wplc_require_user_info" => '1',
            "wplc_loggedin_user_info" => '1',
            "wplc_user_alternative_text" => $wplc_alt_text,
            "wplc_user_default_visitor_name" => $wplc_default_visitor_name,
            "wplc_enabled_on_mobile" => '1',
            "wplc_display_name" => '1',
            "wplc_record_ip_address" => '0',
            "wplc_pro_chat_email_address" => $wplc_admin_email,
            "wplc_pro_fst1" => __("Questions?", "wplivechat"),
            "wplc_pro_fst2" => __("Chat with us", "wplivechat"),
            "wplc_pro_fst3" => __("Start live chat", "wplivechat"),
            "wplc_pro_sst1" => __("Start Chat", "wplivechat"),
            "wplc_pro_sst1_survey" => __("Or chat to an agent now", "wplivechat"),
            "wplc_pro_sst1e_survey" => __("Chat ended", "wplivechat"),
            "wplc_pro_sst2" => __("Connecting. Please be patient...", "wplivechat"),
            "wplc_pro_tst1" => __("Reactivating your previous chat...", "wplivechat"),
            "wplc_pro_na" => __("Chat offline. Leave a message", "wplivechat"),
            "wplc_pro_intro" => __("Hello. Please input your details so that I may help you.", "wplivechat"),
            "wplc_pro_offline1" => __("We are currently offline. Please leave a message and we'll get back to you shortly.", "wplivechat"),
            "wplc_pro_offline2" => __("Sending message...", "wplivechat"),
            "wplc_pro_offline3" => __("Thank you for your message. We will be in contact soon.", "wplivechat"),
            "wplc_pro_offline_btn" => __("Leave a message", "wplivechat"),
            "wplc_pro_offline_btn_send" => __("Send message", "wplivechat"),
            "wplc_user_enter" => __("Press ENTER to send your message", "wplivechat"),
            "wplc_text_chat_ended" => __("The chat has been ended by the operator.", "wplivechat"),
            "wplc_close_btn_text" => __("close", "wplivechat"),
            "wplc_user_welcome_chat" => __("Welcome. How may I help you?", "wplivechat"),
            'wplc_welcome_msg' => __("Please standby for an agent. While you wait for the agent you may type your message.","wplivechat")

        );

		//Added V8: Default Settings array filter
		$wplc_default_settings_array = apply_filters("wplc_activate_default_settings_array", $wplc_default_settings_array);

        add_option('WPLC_SETTINGS', $wplc_default_settings_array);
    }






    $admins = get_role('administrator');
    if( $admins !== null ) { $admins->add_cap('wplc_ma_agent'); }


    $uid = get_current_user_id();
    update_user_meta($uid, 'wplc_ma_agent', 1);
    update_user_meta($uid, "wplc_chat_agent_online", time());

    add_option("WPLC_HIDE_CHAT", "true");


    do_action("wplc_activate_hook");
}



function wplc_handle_db() {
    global $wpdb;
    global $wplc_version;
    global $wplc_tblname_chats;
    global $wplc_tblname_msgs;
    global $wplc_tblname_offline_msgs;

    $sql = "
        CREATE TABLE " . $wplc_tblname_chats . " (
          id int(11) NOT NULL AUTO_INCREMENT,
          timestamp datetime NOT NULL,
          name varchar(700) NOT NULL,
          email varchar(700) NOT NULL,
          ip varchar(700) NOT NULL,
          status int(11) NOT NULL,
          session varchar(100) NOT NULL,
          url varchar(700) NOT NULL,
          last_active_timestamp datetime NOT NULL,
          agent_id INT(11) NOT NULL,
          other LONGTEXT NOT NULL,
          rel varchar(40) NOT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);




    $sql = '
        CREATE TABLE ' . $wplc_tblname_msgs . ' (
          id int(11) NOT NULL AUTO_INCREMENT,
          chat_sess_id int(11) NOT NULL,
          msgfrom varchar(150) CHARACTER SET utf8 NOT NULL,
          msg LONGTEXT CHARACTER SET utf8 NOT NULL,
          timestamp datetime NOT NULL,
          status INT(3) NOT NULL,
          originates INT(3) NOT NULL,
          other LONGTEXT NOT NULL,
          rel varchar(40) NOT NULL,
          afrom INT(10) NOT NULL,
          ato INT(10) NOT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ';

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    @dbDelta($sql);

    /* check for previous versions containing 'from' instead of 'msgfrom' */
    $results = $wpdb->get_results("DESC $wplc_tblname_msgs");
    $founded = 0;
    foreach ($results as $row ) {
        if ($row->Field == "from") {
            $founded++;
        }
    }

    if ($founded>0) { $wpdb->query("ALTER TABLE ".$wplc_tblname_msgs." CHANGE `from` `msgfrom` varchar(150)"); }


    $sql2 = "
        CREATE TABLE " . $wplc_tblname_offline_msgs . " (
          id int(11) NOT NULL AUTO_INCREMENT,
          timestamp datetime NOT NULL,
          name varchar(700) NOT NULL,
          email varchar(700) NOT NULL,
          message varchar(700) NOT NULL,
          ip varchar(700) NOT NULL,
          user_agent varchar(700) NOT NULL,
          PRIMARY KEY  (id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;
    ";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    @dbDelta($sql2);

    add_option("wplc_db_version", $wplc_version);
    update_option("wplc_db_version", $wplc_version);
}

function wplc_add_user_stylesheet() {
	global $wplc_version;
    if(function_exists('wplc_display_chat_contents')){
        $show_chat_contents = wplc_display_chat_contents();
    } else {
        $show_chat_contents = 1;
    }
    if($show_chat_contents >= 1){
	    $wplc_settings = get_option( 'WPLC_SETTINGS' );
	    if ( isset( $wplc_settings ) && isset( $wplc_settings['wplc_enable_font_awesome'] ) && '1' === $wplc_settings['wplc_enable_font_awesome'] ) {
		    wp_register_style( 'wplc-font-awesome', plugins_url( '/css/font-awesome.min.css', __FILE__ ) );

		    wp_enqueue_style( 'wplc-font-awesome' );
	    }
        wp_register_style('wplc-style', plugins_url('/css/wplcstyle.css', __FILE__), array(), $wplc_version);
        wp_enqueue_style('wplc-style');

        if( isset( $wplc_settings['wplc_elem_trigger_id'] ) && trim( $wplc_settings['wplc_elem_trigger_id'] ) !== "" ) {
	    	if( isset( $wplc_settings['wplc_elem_trigger_type'] ) ){
	    		if ( $wplc_settings['wplc_elem_trigger_type'] === "0" ) {
	    			/* class */
	    			$wplc_elem_style_prefix = ".";
	    		} else {
	    			/* ID */
	    			$wplc_elem_style_prefix = "#";
	    		}
	    	}

	        $wplc_elem_inline_style = $wplc_elem_style_prefix.stripslashes( $wplc_settings['wplc_elem_trigger_id'] ).":hover { cursor:pointer; }";
	        wp_add_inline_style( 'wplc-style', stripslashes( $wplc_elem_inline_style ) );
	    }

		// Serve the icon up over HTTPS if needs be
		//$icon = plugins_url('images/chaticon.png', __FILE__);
		$icon = plugins_url('images/iconRetina.png', __FILE__);
		$close_icon = plugins_url('images/iconCloseRetina.png', __FILE__);


		if ( isset( $wplc_settings['wplc_settings_bg'] ) ) {
			if ( $wplc_settings['wplc_settings_bg']  == "0" ) { $bg = false; } else { $bg = esc_attr( $wplc_settings['wplc_settings_bg'] ); }
		} else { $bg = "cloudy.jpg"; }
		if ($bg) {
			$bg = plugins_url('images/bg/'.$bg, __FILE__);
			$bg_string = "#wp-live-chat-4 { background:url('$bg') repeat; background-size: cover; }";
		} else { $bg_string = "#wp-live-chat-4 { background-color: #fff; }"; }

		if( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] ){ $icon = preg_replace('/^http:\/\//', 'https:\/\/', $icon); }
		if( isset( $_SERVER['HTTPS'] ) && $_SERVER['HTTPS'] ){ $close_icon = preg_replace('/^http:\/\//', 'https:\/\/', $close_icon); }
		$icon = apply_filters("wplc_filter_chaticon",$icon);

		$close_icon = apply_filters("wplc_filter_chaticon_close",$close_icon);

		$wplc_elem_inline_style = "#wp-live-chat-header { background:url('$icon') no-repeat; background-size: cover; }  #wp-live-chat-header.active { background:url('$close_icon') no-repeat; background-size: cover; } $bg_string";
		wp_add_inline_style( 'wplc-style', stripslashes( $wplc_elem_inline_style ) );



        global $wplc_pro_version;
        $wplc_ver = str_replace('.', '', $wplc_pro_version);
        $checker = intval($wplc_ver);

        if (function_exists("wplc_pro_version_control") && $checker < 6000) {
          /* old pro version backwards compatibility */
          wp_register_style('wplc-style-pro', plugins_url('/css/wplcstyle_old.css', __FILE__));
          wp_enqueue_style('wplc-style-pro');


        }



        $wplc_settings = get_option('WPLC_SETTINGS');
        if (isset($wplc_settings['wplc_theme'])) { $wplc_theme = $wplc_settings['wplc_theme']; } else { $wplc_theme = "theme-default"; }

        if ( (isset($wplc_theme) && $checker >= 6000 ) || (! function_exists("wplc_pro_version_control") ) )  {
          if($wplc_theme == 'theme-default') {
            wp_register_style('wplc-theme-palette-default', plugins_url('/css/themes/theme-default.css', __FILE__), array(), $wplc_version);
            wp_enqueue_style('wplc-theme-palette-default');

          }
          else if($wplc_theme == 'theme-1') {
            wp_register_style('wplc-theme-palette-1', plugins_url('/css/themes/theme-1.css', __FILE__), array(), $wplc_version);
            wp_enqueue_style('wplc-theme-palette-1');

          }
          else if($wplc_theme == 'theme-2') {
            wp_register_style('wplc-theme-palette-2', plugins_url('/css/themes/theme-2.css', __FILE__), array(), $wplc_version);
            wp_enqueue_style('wplc-theme-palette-2');

          }
          else if($wplc_theme == 'theme-3') {
            wp_register_style('wplc-theme-palette-3', plugins_url('/css/themes/theme-3.css', __FILE__), array(), $wplc_version);
            wp_enqueue_style('wplc-theme-palette-3');

          }
          else if($wplc_theme == 'theme-4') {
            wp_register_style('wplc-theme-palette-4', plugins_url('/css/themes/theme-4.css', __FILE__), array(), $wplc_version);
            wp_enqueue_style('wplc-theme-palette-4');

          }
          else if($wplc_theme == 'theme-5') {
            wp_register_style('wplc-theme-palette-5', plugins_url('/css/themes/theme-5.css', __FILE__), array(), $wplc_version);
            wp_enqueue_style('wplc-theme-palette-5');

          }
          else if($wplc_theme == 'theme-6') {
            /* custom */
            /* handled elsewhere */



          }





          if (isset($wplc_settings['wplc_newtheme'])) { $wplc_newtheme = $wplc_settings['wplc_newtheme']; } else { $wplc_newtheme = "theme-2"; }
          if (isset($wplc_newtheme)) {
            if($wplc_newtheme == 'theme-1') {
              wp_register_style('wplc-theme-classic', plugins_url('/css/themes/classic.css', __FILE__), array(), $wplc_version);
              wp_enqueue_style('wplc-theme-classic');

            }
            else if($wplc_newtheme == 'theme-2') {
              wp_register_style('wplc-theme-modern', plugins_url('/css/themes/modern.css', __FILE__), array(), $wplc_version);
              wp_enqueue_style('wplc-theme-modern');

            }
          }

          if ($wplc_settings["wplc_settings_align"] == 1) {
              wp_register_style('wplc-theme-position', plugins_url('/css/themes/position-bottom-left.css', __FILE__), array(), $wplc_version);
              wp_enqueue_style('wplc-theme-position');
          } else if ($wplc_settings["wplc_settings_align"] == 2) {
              wp_register_style('wplc-theme-position', plugins_url('/css/themes/position-bottom-right.css', __FILE__), array(), $wplc_version);
              wp_enqueue_style('wplc-theme-position');
          } else if ($wplc_settings["wplc_settings_align"] == 3) {
              wp_register_style('wplc-theme-position', plugins_url('/css/themes/position-left.css', __FILE__), array(), $wplc_version);
              wp_enqueue_style('wplc-theme-position');
          } else if ($wplc_settings["wplc_settings_align"] == 4) {
              wp_register_style('wplc-theme-position', plugins_url('/css/themes/position-right.css', __FILE__), array(), $wplc_version);
              wp_enqueue_style('wplc-theme-position');
          } else {
              wp_register_style('wplc-theme-position', plugins_url('/css/themes/position-bottom-right.css', __FILE__), array(), $wplc_version);
              wp_enqueue_style('wplc-theme-position');
          }

        }

        // Gutenberg template styles - user
        wp_register_style( 'wplc-gutenberg-template-styles-user', plugins_url( '/includes/blocks/wplc-chat-box/wplc_gutenberg_template_styles.css', __FILE__ ) );
        wp_enqueue_style( 'wplc-gutenberg-template-styles-user' );

        // GIF integration styles - user
        wp_register_style( 'wplc-gif-integration-user', plugins_url( '/css/wplc_gif_integration.css', __FILE__ ) );
        wp_enqueue_style( 'wplc-gif-integration-user' );
    }
    if(function_exists('wplc_ce_activate')){
        if(function_exists('wplc_ce_load_user_styles')){
            wplc_ce_load_user_styles();
        }
    }
}


add_action( 'init', 'wplc_online_check_script', 10 );
/**
 * Load the JS that allows us to integrate into the WP Heartbeat
 * @return void
 */
function wplc_online_check_script() {
	global $wplc_version;
    if (esc_attr( get_the_author_meta( 'wplc_ma_agent', get_current_user_id() ) ) == "1"){
    	$ajax_nonce = wp_create_nonce("wplc");
	    wp_register_script( 'wplc-heartbeat', plugins_url( 'js/wplc_heartbeat.js', __FILE__ ), array( 'jquery' ), $wplc_version, true );
	    wp_enqueue_script( 'wplc-heartbeat' );
		wp_localize_script( 'wplc-heartbeat', 'wplc_transient_nonce', $ajax_nonce );

		$wplc_ajax_url = apply_filters("wplc_filter_ajax_url", admin_url('admin-ajax.php'));
		wp_localize_script('wplc-heartbeat', 'wplc_ajaxurl', $wplc_ajax_url);
	}
}

/**
 * Heartbeat integrations
 *
 */
add_filter( 'heartbeat_received', 'wplc_heartbeat_receive', 10, 2 );
add_filter( 'heartbeat_nopriv_received', 'wplc_heartbeat_receive', 10, 2 );
function wplc_heartbeat_receive( $response, $data ) {
	if ( $data['client'] == 'wplc_heartbeat' ) {
	    if (esc_attr( get_the_author_meta( 'wplc_ma_agent', get_current_user_id() ) ) == "1"){
	        update_user_meta(get_current_user_id(), "wplc_chat_agent_online", time());
	        wplc_hook_control_set_transient();
	    }
	}
	return $response;
}



/**
 * Loads the admin stylesheets for the chat dashboard and settings pages
 * @return void
 */
function wplc_add_admin_stylesheet() {
	global $wplc_version;

	wp_register_style( 'wplc-ace-styles', plugins_url( '/css/ace.css', __FILE__ ) );
	wp_enqueue_style( 'wplc-ace-styles' );

	wp_register_style( 'wplc-fontawesome-iconpicker', plugins_url( '/css/fontawesome-iconpicker.css', __FILE__ ) );
	wp_enqueue_style( 'wplc-fontawesome-iconpicker' );

	$wplc_settings = get_option("WPLC_SETTINGS");
    if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1 && (!isset($_GET['action']) || $_GET['action'] !== "history") ){
    	//if(isset($_GET['page']) && $_GET['page'] == 'wplivechat-menu'){
	    	//Using node, remote styles please
	    	//Using node, remote scripts please
			if ( isset( $wplc_settings['wplc_enable_all_admin_pages'] ) && $wplc_settings['wplc_enable_all_admin_pages'] === '1' ) {
				/* Run admin JS on all admin pages */
           		wplc_admin_remote_dashboard_styles();
			} else {
				/* Only run admin JS on the chat dashboard page */
				if ( isset( $_GET['page'] ) && $_GET['page'] === 'wplivechat-menu' && !isset( $_GET['action'] ) ) {
	    			wplc_admin_remote_dashboard_styles();
				}
			}

	    	wp_register_style( 'wplc-admin-remote-addition-styles', plugins_url( '/css/remote_dash_styles.css', __FILE__ ), array(), $wplc_version );
			wp_enqueue_style( 'wplc-admin-remote-addition-styles' );

		//}
    }
	//Special new check to see if we need to add the node history styling
    if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1 && isset($_GET['action']) && $_GET['action'] == 'history'){
        wp_register_style( 'wplc-admin-node-history-styles', plugins_url( '/css/node_history_styles.css', __FILE__ ) );
        wp_enqueue_style( 'wplc-admin-node-history-styles' );
    }

    if (isset($_GET['page']) && $_GET['page'] == 'wplivechat-menu' && isset($_GET['action']) && ($_GET['action'] == "ac" || $_GET['action'] == "history" ) ) {
        wp_register_style('wplc-admin-chat-box-style', plugins_url('/css/admin-chat-box-style.css', __FILE__ ), false, $wplc_version );
        wp_enqueue_style('wplc-admin-chat-box-style');
    }

    wp_register_style( 'wplc-font-awesome', plugins_url('css/font-awesome.min.css', __FILE__ ), false, $wplc_version );
    wp_enqueue_style( 'wplc-font-awesome' );

	if (isset($_GET['page']) && ($_GET['page'] == 'wplivechat-menu' ||  $_GET['page'] == 'wplivechat-menu-api-keys-page' ||  $_GET['page'] == 'wplivechat-menu-extensions-page' || $_GET['page'] == 'wplivechat-menu-settings' || $_GET['page'] == 'wplivechat-menu-offline-messages' || $_GET['page'] == 'wplivechat-menu-history' || $_GET['page'] == 'wplivechat-menu-missed-chats')) {
        wp_register_style( 'wplc-jquery-ui', plugins_url( '/css/jquery-ui.css', __FILE__ ), false, $wplc_version );
        wp_enqueue_style( 'wplc-jquery-ui' );

        wp_enqueue_script( 'jquery-ui-core' );
        wp_enqueue_script( 'jquery-effects-core' );

        // Gutenberg template styles - admin
        wp_register_style( 'wplc-gutenberg-template-styles', plugins_url( '/includes/blocks/wplc-chat-box/wplc_gutenberg_template_styles.css', __FILE__ ) );
        wp_enqueue_style( 'wplc-gutenberg-template-styles' );

        wp_register_style( 'wplc-admin-styles', plugins_url( '/css/admin_styles.css', __FILE__ ), false, $wplc_version );
        wp_enqueue_style( 'wplc-admin-styles' );

        // Old admin chat style
		if ((!isset($wplc_settings['wplc_use_node_server'])) || ($wplc_settings['wplc_use_node_server'] != 1)) {
            wp_register_style( 'wplc-chat-style', plugins_url( '/css/chat-style.css', __FILE__ ), false, $wplc_version );
            wp_enqueue_style( 'wplc-chat-style' );

        // New admin chat style
        } else if (isset($wplc_settings['wplc_use_node_server']) && ($wplc_settings['wplc_use_node_server'] == 1)) {
            wp_register_style( 'wplc-admin-chat-style', plugins_url( '/css/admin-chat-style.css', __FILE__ ), false, $wplc_version );
            wp_enqueue_style( 'wplc-admin-chat-style' );
        }
    }

    // Gif Integration styles - admin
    wp_register_style( 'wplc-gif-integration', plugins_url( '/css/wplc_gif_integration.css', __FILE__ ) );
    wp_enqueue_style( 'wplc-gif-integration' );

    // This loads the chat styling on all admin pages as we are using the popout dashboard
    if ( isset( $wplc_settings['wplc_use_node_server'] ) && ( $wplc_settings['wplc_use_node_server'] == 1 ) && ( isset( $wplc_settings['wplc_enable_all_admin_pages'] ) && $wplc_settings['wplc_enable_all_admin_pages'] === '1') ) {

        wp_register_style( 'wplc-admin-chat-style', plugins_url( '/css/admin-chat-style.css', __FILE__ ), false, $wplc_version );
        wp_enqueue_style( 'wplc-admin-chat-style' );
    }

    if (isset($_GET['page']) && $_GET['page'] == "wplivechat-menu-support-page") {
        wp_register_style('fontawesome', plugins_url('css/font-awesome.min.css', __FILE__ ), false, $wplc_version );
        wp_enqueue_style('fontawesome');
        wp_register_style('wplc-support-page-css', plugins_url('css/support-css.css', __FILE__ ), false, $wplc_version );
        wp_enqueue_style('wplc-support-page-css');
    }

    if(isset($_GET['immersive_mode'])){
		wp_add_inline_style( 'wplc-admin-style', "#wpcontent { margin-left: 0px !important;} #wpadminbar, #wpfooter, #adminmenumain {display: none !important;}" );
	}
}

if (isset($_GET['page']) && $_GET['page'] == 'wplivechat-menu-settings') {
    add_action('admin_print_scripts', 'wplc_admin_scripts_basic');
}

/**
 * Loads the admin scripts for the chat dashboard and settings pages
 * @return void
 */
function wplc_admin_scripts_basic() {

$gutenberg_default_html = '<!-- Default HTML -->
<div class="wplc_block">
	<span class="wplc_block_logo">{wplc_logo}</span>
	<span class="wplc_block_text">{wplc_text}</span>
	<span class="wplc_block_icon">{wplc_icon}</span>
</div>';

    if (isset($_GET['page']) && $_GET['page'] == "wplivechat-menu-settings") {
        wp_enqueue_script('jquery');
        wp_enqueue_script('jquery-ui-core');
        wp_enqueue_script('jquery-ui-tooltip');
        wp_register_script('my-wplc-color', plugins_url('js/jscolor.js', __FILE__), false, '1.4.1', false);
        wp_enqueue_script('my-wplc-color');
        wp_enqueue_script('jquery-ui-tabs');
        wp_register_script('my-wplc-tabs', plugins_url('js/wplc_tabs.js', __FILE__), array('jquery-ui-core'), '', true);
        wp_enqueue_script('my-wplc-tabs');
        wp_enqueue_media();
        wp_register_script('wplc-fontawesome-iconpicker', plugins_url('js/fontawesome-iconpicker.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('wplc-fontawesome-iconpicker');
        wp_register_script('wplc-gutenberg', plugins_url('js/wplc_gutenberg.js', __FILE__), array('jquery'), '', true);
        wp_enqueue_script('wplc-gutenberg');
        wp_localize_script( 'wplc-gutenberg', 'default_html', $gutenberg_default_html );
    }
}

/**
 * Loads basic version's settings page
 * @return void
 */
function wplc_admin_settings_layout() {
    wplc_settings_page_basic();
}

add_action("wplc_hook_history_draw_area","wplc_hook_control_history_draw_area",10,1);
/**
 * Display normal history page
 * @param  int   $cid Chat ID
 * @return void
 * @since  6.1.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
function wplc_hook_control_history_draw_area($cid) {
    wplc_draw_chat_area($cid);
}

/**
 * What to display for the chat history
 * @param  int   $cid Chat ID
 * @return void
 * @since  6.1.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
function wplc_admin_view_chat_history($cid) {
  do_action("wplc_hook_history_draw_area",$cid);
}


add_action( 'wplc_hook_admin_menu_layout_display' , 'wplc_hook_control_history_get_control', 1, 3);
/**
 * Control history GET calls
 * @param  string $action The GET action
 * @param  int    $cid    The chat id
 * @param  int    $aid    AID
 * @return void
 * @since  6.1.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
function wplc_hook_control_history_get_control($action,$cid,$aid) {

  if ($action == 'history') {
      wplc_admin_view_chat_history(sanitize_text_field($cid));
  } else if ($action == 'download_history'){

  	  //Moved into the init hook as of version 6.0.01 due to different functionality

      //wplc_admin_download_history(sanitize_text_field($_GET['type']), sanitize_text_field($cid));
  }


}


add_action("wplc_hook_chat_history","wplc_hook_control_chat_history");
/**
 * Renders the chat history content
 * @return string
 */
function wplc_hook_control_chat_history() {

	if (is_admin()) {

	    global $wpdb;
	    global $wplc_tblname_chats;
	    global $wplc_tblname_msgs;

	    if(isset($_GET['wplc_action']) && $_GET['wplc_action'] == 'remove_cid'){
	        if(isset($_GET['cid'])){
	            if(isset($_GET['wplc_confirm'])){
	                //Confirmed - delete
	                $delete_sql = "
	                    DELETE FROM $wplc_tblname_chats
	                    WHERE `id` = '".intval($_GET['cid'])."'                  
	                    ";
					$delete_messages = "
	                    DELETE FROM $wplc_tblname_msgs
	                    WHERE `chat_sess_id` = '".intval($_GET['cid'])."'                  
	                    ";

	                $wplc_was_error = false;

	                $wpdb->query($delete_sql);
	                if ($wpdb->last_error) { $wplc_was_error = true; }
	                $wpdb->query($delete_messages);
	                if ($wpdb->last_error) { $wplc_was_error = true; }

	                if ($wplc_was_error) {
	                    echo "<div class='update-nag' style='margin-top: 0px;margin-bottom: 5px;'>
	                        ".__("Error: Could not delete chat", "wplivechat")."<br>
	                      </div>";
	                } else {
	                     echo "<div class='update-nag' style='margin-top: 0px;margin-bottom: 5px;border-color:#67d552;'>
	                        ".__("Chat Deleted", "wplivechat")."<br>
	                      </div>";
	                }

	            } else {
	                //Prompt
	                echo "<div class='update-nag' style='margin-top: 0px;margin-bottom: 5px;'>
	                        ".__("Are you sure you would like to delete this chat?", "wplivechat")."<br>
	                        <a class='button' href='?page=wplivechat-menu-history&wplc_action=remove_cid&cid=".sanitize_text_field( $_GET['cid'] )."&wplc_confirm=1''>".__("Yes", "wplivechat")."</a> <a class='button' href='?page=wplivechat-menu-history'>".__("No", "wplivechat")."</a>
	                      </div>";
	            }
	        }
	    }

		$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
		$limit = 20; // number of rows in page
		$offset = ( $pagenum - 1 ) * $limit;
		$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM $wplc_tblname_chats" );
		$num_of_pages = ceil( $total / $limit );

		$results = $wpdb->get_results(
	            "
	        SELECT *
	        FROM $wplc_tblname_chats
	        WHERE `name` NOT LIKE 'agent-to-agent chat'
	        ORDER BY `timestamp` DESC
	        LIMIT $limit OFFSET $offset
	      "
	    );
	    echo "
	       <form method=\"post\" >
	        <input type=\"submit\" value=\"".__('Delete History', 'wplivechat')."\" class='button' name=\"wplc-delete-chat-history\" /><br /><br />
	       </form>

	      <table class=\"wp-list-table wplc_list_table widefat fixed \" cellspacing=\"0\">
	  <thead>
	  <tr>
	    <th scope='col' id='wplc_id_colum' class='manage-column column-id sortable desc'  style=''><span>" . __("Date", "wplivechat") . "</span></th>
	                <th scope='col' id='wplc_name_colum' class='manage-column column-name_title sortable desc'  style=''><span>" . __("Name", "wplivechat") . "</span></th>
	                <th scope='col' id='wplc_email_colum' class='manage-column column-email' style=\"\">" . __("Email", "wplivechat") . "</th>
	                <th scope='col' id='wplc_url_colum' class='manage-column column-url' style=\"\">" . __("URL", "wplivechat") . "</th>
	                <th scope='col' id='wplc_status_colum' class='manage-column column-status'  style=\"\">" . __("Status", "wplivechat") . "</th>
	                <th scope='col' id='wplc_action_colum' class='manage-column column-action sortable desc'  style=\"\"><span>" . __("Action", "wplivechat") . "</span></th>
	        </tr>
	  </thead>
	        <tbody id=\"the-list\" class='list:wp_list_text_link'>
	        ";
	    if (!$results) {
	        echo "<tr><td></td><td>" . __("No chats available at the moment", "wplivechat") . "</td></tr>";
	    } else {
	        foreach ($results as $result) {
	            unset($trstyle);
	            unset($actions);

	            $tcid = sanitize_text_field( $result->id );


	            $url = admin_url('admin.php?page=wplivechat-menu&action=history&cid=' . $tcid);
	            $url2 = admin_url('admin.php?page=wplivechat-menu&action=download_history&type=csv&cid=' . $tcid);
	            $url3 = "?page=wplivechat-menu-history&wplc_action=remove_cid&cid=" . $tcid;
	            $actions = "
	                <a href='$url' class='button' title='".__('View Chat History', 'wplivechat')."' target='_BLANK' id=''><i class='fa fa-eye'></i></a> <a href='$url2' class='button' title='".__('Download Chat History', 'wplivechat')."' target='_BLANK' id=''><i class='fa fa-download'></i></a> <a href='$url3' class='button'><i class='fa fa-trash-o'></i></a>      
	                ";
	            $trstyle = "style='height:30px;'";

	            echo "<tr id=\"record_" . $tcid . "\" $trstyle>";
	            echo "<td class='chat_id column-chat_d'>" . date("Y-m-d H:i:s", current_time( strtotime( $result->timestamp ) ) ) . "</td>";
	            echo "<td class='chat_name column_chat_name' id='chat_name_" . $tcid . "'><img src=\"//www.gravatar.com/avatar/" . md5($result->email) . "?s=40\" /> " . sanitize_text_field($result->name) . "</td>";
	            echo "<td class='chat_email column_chat_email' id='chat_email_" . $tcid . "'><a href='mailto:" . sanitize_text_field($result->email) . "' title='Email " . ".$result->email." . "'>" . sanitize_text_field ($result->email) . "</a></td>";
	            echo "<td class='chat_name column_chat_url' id='chat_url_" . $tcid . "'>" . esc_url($result->url) . "</td>";
	            echo "<td class='chat_status column_chat_status' id='chat_status_" . $tcid . "'><strong>" . wplc_return_status($result->status) . "</strong></td>";
	            echo "<td class='chat_action column-chat_action' id='chat_action_" . $tcid . "'>$actions</td>";
	            echo "</tr>";
	        }
	    }
	    echo "</table>";

		$page_links = paginate_links( array(
			'base' => add_query_arg( 'pagenum', '%#%' ),
			'format' => '',
			'prev_text' => __( '&laquo;', 'wplivechat' ),
			'next_text' => __( '&raquo;', 'wplivechat' ),
			'total' => $num_of_pages,
			'current' => $pagenum
		) );

		if ( $page_links ) {
			echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0;float:none;text-align:center;">' . $page_links . '</div></div>';
		}
	}


}

/**
 * Loads the chat history layout to accommodate basic/pro versions
 * @return string
 */
function wplc_admin_history_layout() {
    wplc_stats("history");
    echo"<div class=\"wrap wplc_wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>" . __("WP Live Chat History", "wplivechat") . "</h2>";

    do_action("wplc_before_history_table_hook");

    if(function_exists("wplc_ce_activate")){
        wplc_ce_admin_display_history();
    } else if (function_exists("wplc_register_pro_version")) {
        wplc_pro_admin_display_history();
    } else {
      do_action("wplc_hook_chat_history");
    }
}


add_action("wplc_hook_chat_missed","wplc_hook_control_missed_chats",10);
/**
 * Loads missed chats contents
 * @return string
 */
function wplc_hook_control_missed_chats() {
  if (function_exists('wplc_admin_display_missed_chats')) { wplc_admin_display_missed_chats(); }
}

/**
 * Loads the missed chats page wrapper
 * @return string
 */
function wplc_admin_missed_chats() {
    wplc_stats("missed");
    echo "<div class=\"wrap wplc_wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>" . __("WP Live Chat Missed Chats", "wplivechat") . "</h2>";
    do_action("wplc_hook_chat_missed");
}

add_action("wplc_hook_offline_messages_display","wplc_hook_control_offline_messages_display",10);
/**
 * Loads the offline messages page contents
 * @return string
 */
function wplc_hook_control_offline_messages_display() {
    if (function_exists("wplc_admin_display_offline_messages_new")) { wplc_admin_display_offline_messages_new(); } else {
    if (function_exists("wplc_register_pro_version")) {
        if (function_exists('wplc_pro_admin_display_offline_messages')) {
            wplc_pro_admin_display_offline_messages();
        } else {
            echo "<div class='updated'><p>" . __('Please update to the latest version of WP Live Chat Support Pro to start recording any offline messages.', 'wplivechat') . "</p></div>";
        }
    } else {
        echo "<br /><br >" . _('This option is only available in the ', 'wplivechat') . "<a href=\"http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=history1\" title=\"" . __("Pro Add-on", "wplivechat") . "\" target=\"_BLANK\">" . __('Pro Add-on', 'wplivechat') . "</a> of WP Live Chat. <a href=\"http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=missed_chats2\" title=\"" . __("Pro Add-on", "wplivechat") . "\" target=\"_BLANK\"></a>";
    }
  }

}

/**
 * Control who should see the offline messages
 * @return void
 */
function wplc_admin_offline_messages() {
    wplc_stats("offline_messages");
    echo"<div class=\"wrap wplc_wrap\"><div id=\"icon-edit\" class=\"icon32 icon32-posts-post\"><br></div><h2>" . __("WP Live Chat Offline Messages", "wplivechat") . "</h2>";
    do_action("wplc_hook_offline_messages_display");
}

/**
 * Output the offline messages in an HTML table
 * @return void
 */
function wplc_admin_display_offline_messages_new() {

    global $wpdb;
    global $wplc_tblname_offline_msgs;

    echo "
        <table class=\"wp-list-table wplc_list_table widefat \" cellspacing=\"0\">
            <thead>
                <tr>
                    <th class='manage-column column-id'><span>" . __("Date", "wplivechat") . "</span></th>
                    <th scope='col' id='wplc_name_colum' class='manage-column column-id'><span>" . __("Name", "wplivechat") . "</span></th>
                    <th scope='col' id='wplc_email_colum' class='manage-column column-id'>" . __("Email", "wplivechat") . "</th>
                    <th scope='col' id='wplc_message_colum' class='manage-column column-id'>" . __("Message", "wplivechat") . "</th>
                    <th scope='col' id='wplc_message_colum' class='manage-column column-id'>" . __("Actions", "wplivechat") . "</th>
                </tr>
            </thead>
            <tbody id=\"the-list\" class='list:wp_list_text_link'>";

	$pagenum = isset( $_GET['pagenum'] ) ? absint( $_GET['pagenum'] ) : 1;
	$limit = 20; // number of rows in page
	$offset = ( $pagenum - 1 ) * $limit;
	$total = $wpdb->get_var( "SELECT COUNT(`id`) FROM $wplc_tblname_offline_msgs" );
	$num_of_pages = ceil( $total / $limit );

    $sql = "SELECT * FROM $wplc_tblname_offline_msgs ORDER BY `timestamp` DESC LIMIT $limit OFFSET $offset";

    $results = $wpdb->get_results($sql);

    if (!$results) {
        echo "<tr><td></td><td>" . __("You have not received any offline messages.", "wplivechat") . "</td></tr>";
    } else {
        foreach ($results as $result) {
            echo "<tr id=\"record_" . $result->id . "\">";
            echo "<td class='chat_id column-chat_d'>" . $result->timestamp . "</td>";
            echo "<td class='chat_name column_chat_name' id='chat_name_" . $result->id . "'><img src=\"//www.gravatar.com/avatar/" . md5($result->email) . "?s=30\" /> " . $result->name . "</td>";
            echo "<td class='chat_email column_chat_email' id='chat_email_" . $result->id . "'><a href='mailto:" . $result->email . "' title='Email " . ".$result->email." . "'>" . $result->email . "</a></td>";
            echo "<td class='chat_name column_chat_url' id='chat_url_" . $result->id . "'>" . nl2br($result->message) . "</td>";
            echo "<td class='chat_name column_chat_delete'><button class='button wplc_delete_message' title='".__('Delete Message', 'wplivechat')."' class='wplc_delete_message' mid='".$result->id."'><i class='fa fa-times'></i></button></td>";
            echo "</tr>";
        }
    }

    echo "
            </tbody>
        </table>";

	$page_links = paginate_links( array(
		'base' => add_query_arg( 'pagenum', '%#%' ),
		'format' => '',
		'prev_text' => __( '&laquo;', 'wplivechat' ),
		'next_text' => __( '&raquo;', 'wplivechat' ),
		'total' => $num_of_pages,
		'current' => $pagenum
	) );

	if ( $page_links ) {
		echo '<div class="tablenav"><div class="tablenav-pages" style="margin: 1em 0;float:none;text-align:center;">' . $page_links . '</div></div>';
	}
}

/**
 * Loads the basic/pro version's settings pages
 * @return string
 */
function wplc_settings_page_basic() {
    if (function_exists("wplc_register_pro_version")) {
        wplc_settings_page_pro();
    } else {
        include 'includes/settings_page.php';
    }
}

/**
 * Updates chat statistics
 * @param  string $sec Specify which array key of the stats you'd like access to
 * @return void
 */
function wplc_stats($sec) {
    $wplc_stats = get_option("wplc_stats");
    if ($wplc_stats) {
        if (isset($wplc_stats[$sec]["views"])) {
            $wplc_stats[$sec]["views"] = $wplc_stats[$sec]["views"] + 1;
            $wplc_stats[$sec]["last_accessed"] = date("Y-m-d H:i:s");
        } else {
            $wplc_stats[$sec]["views"] = 1;
            $wplc_stats[$sec]["last_accessed"] = date("Y-m-d H:i:s");
            $wplc_stats[$sec]["first_accessed"] = date("Y-m-d H:i:s");
        }


    } else {

        $wplc_stats[$sec]["views"] = 1;
        $wplc_stats[$sec]["last_accessed"] = date("Y-m-d H:i:s");
        $wplc_stats[$sec]["first_accessed"] = date("Y-m-d H:i:s");


    }
    update_option("wplc_stats",$wplc_stats);

}


add_action("wplc_hook_head","wplc_hook_control_head");
/**
 * Deletes the chat history on submission of POST
 * @return bool
 */
function wplc_hook_control_head() {
    if (isset($_POST['wplc-delete-chat-history'])) {
        wplc_del_history();
    }
}

/**
 * Deletes all chat history
 * @return bool
 */
function wplc_del_history(){
    global $wpdb;
    global $wplc_tblname_chats;
    $wpdb->query("TRUNCATE TABLE $wplc_tblname_chats");
}

add_filter("wplc_filter_chat_header_extra_attr","wplc_filter_control_chat_header_extra_attr",10,1);
/**
 * Controls if the chat window should popup or not
 * @param  array $wplc_extra_attr Extra chat data passed
 * @return string
 */
function wplc_filter_control_chat_header_extra_attr($wplc_extra_attr) {
    $wplc_acbc_data = get_option("WPLC_SETTINGS");
    if (isset($wplc_acbc_data['wplc_auto_pop_up'])) { $extr_string = $wplc_acbc_data['wplc_auto_pop_up']; $wplc_extra_attr .= " wplc-auto-pop-up=\"".$extr_string."\""; }

    return $wplc_extra_attr;
}

/**
 * Admin side headers used to save settings
 * @return string
 */
function wplc_head_basic() {
    global $wpdb;

    do_action("wplc_hook_head");


    if (isset($_POST['wplc_save_settings'])) {

        do_action("wplc_hook_admin_settings_save");
        if (isset($_POST['wplc_settings_align'])) { $wplc_data['wplc_settings_align'] = esc_attr($_POST['wplc_settings_align']); }
        if (isset($_POST['wplc_settings_bg'])) { $wplc_data['wplc_settings_bg'] = esc_attr($_POST['wplc_settings_bg']); }
        if (isset($_POST['wplc_environment'])) { $wplc_data['wplc_environment'] = esc_attr($_POST['wplc_environment']); }
        if (isset($_POST['wplc_settings_fill'])) { $wplc_data['wplc_settings_fill'] = esc_attr($_POST['wplc_settings_fill']); }
        if (isset($_POST['wplc_settings_font'])) { $wplc_data['wplc_settings_font'] = esc_attr($_POST['wplc_settings_font']); }

        if (isset($_POST['wplc_settings_color1'])) { $wplc_data['wplc_settings_color1'] = esc_attr($_POST['wplc_settings_color1']); /* backwards compatibility for pro */ $wplc_data['wplc_settings_fill'] = esc_attr($_POST['wplc_settings_color1']); }
        if (isset($_POST['wplc_settings_color2'])) { $wplc_data['wplc_settings_color2'] = esc_attr($_POST['wplc_settings_color2']); /* backwards compatibility for pro */ $wplc_data['wplc_settings_font'] = esc_attr($_POST['wplc_settings_color2']); }
        if (isset($_POST['wplc_settings_color3'])) { $wplc_data['wplc_settings_color3'] = esc_attr($_POST['wplc_settings_color3']); }
        if (isset($_POST['wplc_settings_color4'])) { $wplc_data['wplc_settings_color4'] = esc_attr($_POST['wplc_settings_color4']); }

        if (isset($_POST['wplc_settings_enabled'])) { $wplc_data['wplc_settings_enabled'] = esc_attr($_POST['wplc_settings_enabled']); }
        if (isset($_POST['wplc_powered_by_link'])) { $wplc_data['wplc_powered_by_link'] = esc_attr($_POST['wplc_powered_by_link']); }
        if (isset($_POST['wplc_auto_pop_up'])) { $wplc_data['wplc_auto_pop_up'] = esc_attr($_POST['wplc_auto_pop_up']); }
        if (isset($_POST['wplc_require_user_info'])) { $wplc_data['wplc_require_user_info'] = esc_attr($_POST['wplc_require_user_info']); } else { $wplc_data['wplc_require_user_info'] = "0";  }
	    if (isset($_POST['wplc_user_default_visitor_name']) && $_POST['wplc_user_default_visitor_name'] != '') { $wplc_data['wplc_user_default_visitor_name'] = esc_attr($_POST['wplc_user_default_visitor_name']); } else { $wplc_data['wplc_user_default_visitor_name'] = __("Guest", "wplivechat"); }
	    if (isset($_POST['wplc_loggedin_user_info'])) { $wplc_data['wplc_loggedin_user_info'] = esc_attr($_POST['wplc_loggedin_user_info']); } else {  $wplc_data['wplc_loggedin_user_info'] = "0"; }
        if (isset($_POST['wplc_user_alternative_text']) && $_POST['wplc_user_alternative_text'] != '') { $wplc_data['wplc_user_alternative_text'] = esc_attr($_POST['wplc_user_alternative_text']); } else { $wplc_data['wplc_user_alternative_text'] = __("Please click 'Start Chat' to initiate a chat with an agent", "wplivechat"); }
        if (isset($_POST['wplc_enabled_on_mobile'])) { $wplc_data['wplc_enabled_on_mobile'] = esc_attr($_POST['wplc_enabled_on_mobile']); } else {  $wplc_data['wplc_enabled_on_mobile'] = "0"; }
        if (isset($_POST['wplc_display_name'])) { $wplc_data['wplc_display_name'] = esc_attr($_POST['wplc_display_name']); }
        if (isset($_POST['wplc_display_to_loggedin_only'])) { $wplc_data['wplc_display_to_loggedin_only'] = esc_attr($_POST['wplc_display_to_loggedin_only']); }

        if (isset($_POST['wplc_redirect_to_thank_you_page'])) { $wplc_data['wplc_redirect_to_thank_you_page'] = esc_attr($_POST['wplc_redirect_to_thank_you_page']); }
        if (isset($_POST['wplc_redirect_thank_you_url'])) { $wplc_data['wplc_redirect_thank_you_url'] = urlencode(str_replace("https:", "", str_replace("http:", "", $_POST['wplc_redirect_thank_you_url']) ) ); }

        if (isset($_POST['wplc_is_gif_integration_enabled'] )){ $wplc_data['wplc_is_gif_integration_enabled'] = esc_attr($_POST['wplc_is_gif_integration_enabled']); }
        if (isset($_POST['wplc_preferred_gif_provider'])) { $wplc_data['wplc_preferred_gif_provider'] = esc_attr($_POST['wplc_preferred_gif_provider']); }
        if (isset($_POST['wplc_giphy_api_key'])) { $wplc_data['wplc_giphy_api_key'] = esc_attr($_POST['wplc_giphy_api_key']); }
        if (isset($_POST['wplc_tenor_api_key'])) { $wplc_data['wplc_tenor_api_key'] = esc_attr($_POST['wplc_tenor_api_key']); }

		$wplc_data['wplc_disable_emojis'] = !empty($_POST['wplc_disable_emojis']);

		/** DEPRECATED BY GDPR */
        /*if(isset($_POST['wplc_record_ip_address'])){ $wplc_data['wplc_record_ip_address'] = esc_attr($_POST['wplc_record_ip_address']); } else { $wplc_data['wplc_record_ip_address'] = "0"; }*/

        $wplc_data['wplc_record_ip_address'] = "0";

        if(isset($_POST['wplc_enable_msg_sound'])){ $wplc_data['wplc_enable_msg_sound'] = esc_attr($_POST['wplc_enable_msg_sound']); } else { $wplc_data['wplc_enable_msg_sound'] = "0"; }

        if(isset($_POST['wplc_enable_visitor_sound'])){ $wplc_data['wplc_enable_visitor_sound'] = esc_attr($_POST['wplc_enable_visitor_sound']); } else { $wplc_data['wplc_enable_visitor_sound'] = "0"; }


	    if(isset($_POST['wplc_enable_font_awesome'])){ $wplc_data['wplc_enable_font_awesome'] = esc_attr($_POST['wplc_enable_font_awesome']); } else { $wplc_data['wplc_enable_font_awesome'] = "0"; }
	    if(isset($_POST['wplc_enable_all_admin_pages'])){ $wplc_data['wplc_enable_all_admin_pages'] = esc_attr($_POST['wplc_enable_all_admin_pages']); } else { $wplc_data['wplc_enable_all_admin_pages'] = "0"; }

        if (isset($_POST['wplc_pro_na'])) { $wplc_data['wplc_pro_na'] = esc_attr($_POST['wplc_pro_na']); }
        if (isset($_POST['wplc_hide_when_offline'])) { $wplc_data['wplc_hide_when_offline'] = esc_attr($_POST['wplc_hide_when_offline']); }
        if (isset($_POST['wplc_pro_chat_email_address'])) { $wplc_data['wplc_pro_chat_email_address'] = esc_attr($_POST['wplc_pro_chat_email_address']); }

        if (isset($_POST['wplc_pro_chat_email_offline_subject'])) { $wplc_data['wplc_pro_chat_email_offline_subject'] = esc_attr($_POST['wplc_pro_chat_email_offline_subject']); }

        if (isset($_POST['wplc_pro_offline1'])) { $wplc_data['wplc_pro_offline1'] = esc_attr($_POST['wplc_pro_offline1']); }
        if (isset($_POST['wplc_pro_offline2'])) { $wplc_data['wplc_pro_offline2'] = esc_attr($_POST['wplc_pro_offline2']); }
        if (isset($_POST['wplc_pro_offline3'])) { $wplc_data['wplc_pro_offline3'] = esc_attr($_POST['wplc_pro_offline3']); }
	    if (isset($_POST['wplc_pro_offline_btn'])) { $wplc_data['wplc_pro_offline_btn'] = esc_attr($_POST['wplc_pro_offline_btn']); }
	    if (isset($_POST['wplc_pro_offline_btn_send'])) { $wplc_data['wplc_pro_offline_btn_send'] = esc_attr($_POST['wplc_pro_offline_btn_send']); }
	    if (isset($_POST['wplc_using_localization_plugin'])){ $wplc_data['wplc_using_localization_plugin'] = esc_attr($_POST['wplc_using_localization_plugin']); }


        if (isset($_POST['wplc_pro_fst1'])) { $wplc_data['wplc_pro_fst1'] = esc_attr($_POST['wplc_pro_fst1']); }
        if (isset($_POST['wplc_pro_fst2'])) { $wplc_data['wplc_pro_fst2'] = esc_attr($_POST['wplc_pro_fst2']); }
        if (isset($_POST['wplc_pro_fst3'])) { $wplc_data['wplc_pro_fst3'] = esc_attr($_POST['wplc_pro_fst3']); }
        if (isset($_POST['wplc_pro_sst1'])) { $wplc_data['wplc_pro_sst1'] = esc_attr($_POST['wplc_pro_sst1']); }
        if (isset($_POST['wplc_pro_sst1_survey'])) { $wplc_data['wplc_pro_sst1_survey'] = esc_attr($_POST['wplc_pro_sst1_survey']); }
        if (isset($_POST['wplc_pro_sst1e_survey'])) { $wplc_data['wplc_pro_sst1e_survey'] = esc_attr($_POST['wplc_pro_sst1e_survey']); }
        if (isset($_POST['wplc_pro_sst2'])) { $wplc_data['wplc_pro_sst2'] = esc_attr($_POST['wplc_pro_sst2']); }
        if (isset($_POST['wplc_pro_tst1'])) { $wplc_data['wplc_pro_tst1'] = esc_attr($_POST['wplc_pro_tst1']); }
        if (isset($_POST['wplc_pro_intro'])) { $wplc_data['wplc_pro_intro'] = esc_attr($_POST['wplc_pro_intro']); }
        if (isset($_POST['wplc_user_enter'])) { $wplc_data['wplc_user_enter'] = esc_attr($_POST['wplc_user_enter']); }
        if (isset($_POST['wplc_text_chat_ended'])) { $wplc_data['wplc_text_chat_ended'] = esc_attr($_POST['wplc_text_chat_ended']); }
        if (isset($_POST['wplc_close_btn_text'])) { $wplc_data['wplc_close_btn_text'] = esc_attr($_POST['wplc_close_btn_text']); }
        if (isset($_POST['wplc_user_welcome_chat'])) { $wplc_data['wplc_user_welcome_chat'] = esc_attr($_POST['wplc_user_welcome_chat']); }
        if (isset($_POST['wplc_welcome_msg'])) { $wplc_data['wplc_welcome_msg'] = esc_attr($_POST['wplc_welcome_msg']); }


        if(isset($_POST['wplc_animation'])){ $wplc_data['wplc_animation'] = esc_attr($_POST['wplc_animation']); }
        if(isset($_POST['wplc_theme'])){ $wplc_data['wplc_theme'] = esc_attr($_POST['wplc_theme']); }
        if(isset($_POST['wplc_newtheme'])){ $wplc_data['wplc_newtheme'] = esc_attr($_POST['wplc_newtheme']); }

        if(isset($_POST['wplc_elem_trigger_action'])){ $wplc_data['wplc_elem_trigger_action'] = esc_attr($_POST['wplc_elem_trigger_action']); } else{ $wplc_data['wplc_elem_trigger_action'] = "0"; }
        if(isset($_POST['wplc_elem_trigger_type'])){ $wplc_data['wplc_elem_trigger_type'] = esc_attr($_POST['wplc_elem_trigger_type']); } else { $wplc_data['wplc_elem_trigger_type'] = "0";}
        if(isset($_POST['wplc_elem_trigger_id'])){ $wplc_data['wplc_elem_trigger_id'] = esc_attr($_POST['wplc_elem_trigger_id']); } else { $wplc_data['wplc_elem_trigger_id'] = ""; }

        if(isset($_POST['wplc_agent_select']) && $_POST['wplc_agent_select'] != "") {
            $user_array = get_users(array(
                'meta_key' => 'wplc_ma_agent',
            ));
            if ($user_array) {
                foreach ($user_array as $user) {
                    $uid = $user->ID;
                    $wplc_ma_user = new WP_User( $uid );
                    $wplc_ma_user->remove_cap( 'wplc_ma_agent' );
                    delete_user_meta($uid, "wplc_ma_agent");
                    delete_user_meta($uid, "wplc_chat_agent_online");
                }
            }


            $uid = intval($_POST['wplc_agent_select']);
            $wplc_ma_user = new WP_User( $uid );
            $wplc_ma_user->add_cap( 'wplc_ma_agent' );
            update_user_meta($uid, "wplc_ma_agent", 1);
            update_user_meta($uid, "wplc_chat_agent_online", time());

        }


        if(isset($_POST['wplc_ban_users_ip'])){
            $wplc_banned_ip_addresses = explode('<br />', nl2br(sanitize_text_field($_POST['wplc_ban_users_ip'])));
            foreach($wplc_banned_ip_addresses as $key => $value) {
                $data[$key] = trim($value);
            }
            $wplc_banned_ip_addresses = maybe_serialize($data);

            update_option('WPLC_BANNED_IP_ADDRESSES', $wplc_banned_ip_addresses);
        }

        if( isset( $_POST['wplc_show_date'] ) ){ $wplc_data['wplc_show_date'] = '1'; } else { $wplc_data['wplc_show_date'] = '0'; }
        if( isset( $_POST['wplc_show_time'] ) ){ $wplc_data['wplc_show_time'] = '1'; } else { $wplc_data['wplc_show_time'] = '0'; }

        if( isset( $_POST['wplc_show_name'] ) ){ $wplc_data['wplc_show_name'] = '1'; } else { $wplc_data['wplc_show_name'] = '0'; }
        if( isset( $_POST['wplc_show_avatar'] ) ){ $wplc_data['wplc_show_avatar'] = '1'; } else { $wplc_data['wplc_show_avatar'] = '0'; }
        $wplc_data = apply_filters("wplc_settings_save_filter_hook", $wplc_data);

        if (isset($_POST['wplc_user_no_answer'])) { $wplc_data["wplc_user_no_answer"] = esc_attr($_POST['wplc_user_no_answer']); } else { $wplc_data["wplc_user_no_answer"] = __("There is No Answer. Please Try Again Later.", "wplivechat"); }

        update_option('WPLC_SETTINGS', $wplc_data);
        if (isset($_POST['wplc_hide_chat'])) {
            update_option("WPLC_HIDE_CHAT", true);
        } else {
          update_option("WPLC_HIDE_CHAT", false);
        }


        $wplc_advanced_settings = array();
        if (isset($_POST['wplc_iterations'])) { $wplc_advanced_settings['wplc_iterations'] = esc_attr($_POST['wplc_iterations']); }
		if (isset($_POST['wplc_delay_between_loops'])) { $wplc_advanced_settings['wplc_delay_between_loops'] = esc_attr($_POST['wplc_delay_between_loops']); }
		update_option("wplc_advanced_settings",$wplc_advanced_settings);


        update_option('wplc_mail_type', $_POST['wplc_mail_type']);
        update_option('wplc_mail_host', $_POST['wplc_mail_host']);
        update_option('wplc_mail_port', $_POST['wplc_mail_port']);
        update_option('wplc_mail_username', $_POST['wplc_mail_username']);
        update_option('wplc_mail_password', $_POST['wplc_mail_password']);


        add_action( 'admin_notices', 'wplc_save_settings_action' );
    }
    if (isset($_POST['action']) && $_POST['action'] == "wplc_submit_find_us") {
        if (function_exists('curl_version')) {
            $request_url = "http://www.wp-livechat.com/apif/rec.php";
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $request_url);
            curl_setopt($ch, CURLOPT_POST, 1);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $_POST);
            curl_setopt($ch, CURLOPT_REFERER, $_SERVER['HTTP_HOST']);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            $output = curl_exec($ch);
            curl_close($ch);
        }
        echo "<div class=\"updated\"><p>" . __("Thank You for your feedback!", "wplivechat") . "</p></div>";
        @wp_redirect( admin_url("/admin.php?page=wplivechat-menu&override=1") );
    }
    if( isset( $_GET['override'] ) && $_GET['override'] == '1' ){
    	update_option( "WPLC_V8_FIRST_TIME", false);
    }
}

function wplc_save_settings_action() { ?>
    <div class='notice notice-success updated wplc_settings_save_notice'>
		<?php _e("Your settings have been saved.", "wplivechat"); ?>
    </div>
<?php }

add_action('wp_logout', 'wplc_logout');
/**
 * Deletes the chat transient when a user logs out
 * @return bool
 */
function wplc_logout() {
    delete_transient('wplc_is_admin_logged_in');
}

/**
 * Returns the home page of the user's side
 * @return string
 */
function wplc_get_home_path() {
    $home = get_option('home');
    $siteurl = site_url();
    if (!empty($home) && 0 !== strcasecmp($home, $siteurl)) {
        $wp_path_rel_to_home = str_ireplace($home, '', $siteurl); /* $siteurl - $home */
        $pos = strripos(str_replace('\\', '/', $_SERVER['SCRIPT_FILENAME']), trailingslashit($wp_path_rel_to_home));
        $home_path = substr($_SERVER['SCRIPT_FILENAME'], 0, $pos);
        $home_path = trailingslashit($home_path);
    } else {
        $home_path = ABSPATH;
    }
    return str_replace('\\', '/', $home_path);
}

/**
 * Error checks used to ensure the user's resources meet the plugin's requirements
 */
if(isset($_GET['page']) && $_GET['page'] == 'wplivechat-menu-settings'){
    if(is_admin()){
    	
    	// Only show these warning messages to Legacy users as they will be affected, not Node users.
    	$wplc_settings = get_option("WPLC_SETTINGS");
    	if (isset( $wplc_settings['wplc_use_node_server'] ) && intval( $wplc_settings['wplc_use_node_server'] ) == 1 ) { } else {

	        $wplc_error_count = 0;
	        $wplc_admin_warnings = "<div class='error'>";
	        if(!function_exists('set_time_limit')){
	            $wplc_admin_warnings .= "
	                <p>".__("WPLC: set_time_limit() is not enabled on this server. You may experience issues while using WP Live Chat Support as a result of this. Please get in contact your host to get this function enabled.", "wplivechat")."</p>
	            ";
	            $wplc_error_count++;
	        }
	        if(ini_get('safe_mode')){
	            $wplc_admin_warnings .= "
	                <p>".__("WPLC: Safe mode is enabled on this server. You may experience issues while using WP Live Chat Support as a result of this. Please contact your host to get safe mode disabled.", "wplivechat")."</p>
	            ";
	            $wplc_error_count++;
	        }
	        $wplc_admin_warnings .= "</div>";
	        if($wplc_error_count > 0){
	            echo $wplc_admin_warnings;
	        }
	    }
    }
}

/**
 * Loads the contents of the extensions menu item
 * @return string
 */
function wplc_extensions_menu() {

    if (isset($_GET['type']) && $_GET['type'] == "additional") {
        $additional = "nav-tab-active";
        $normal = "";
    } else {
        $normal = "nav-tab-active";
        $additional = "";
    }

?>
    <h2 class="nav-tab-wrapper">
        <a href="admin.php?page=wplivechat-menu-extensions-page" title="<?php _e("Add-ons","wplivechat"); ?>" class="nav-tab <?php echo $normal; ?>"><?php _e("Add-ons","wplivechat"); ?></a><a href="admin.php?page=wplivechat-menu-extensions-page&type=additional" title="<?php _e("Suggested Plugins","wplivechat"); ?>" class="nav-tab  <?php echo $additional; ?>"><?php _e("Suggested Plugins","wplivechat"); ?></a>
<span style='float: right; bottom:-5px; position: relative;'><img src='<?php echo plugins_url('/images/codecabin.png', __FILE__); ?>' style="height:15px;" /></span>
    </h2>
    <div id="tab_container">


    <?php
    if (isset($_GET['type']) && $_GET['type'] == "additional") {
    ?>

    <div class="wplc-extension wplc-plugin">
        <h3 class="wplc-extension-title"><?php _e("Sola Support Tickets","wplivechat"); ?></h3>
        <a href="https://wordpress.org/plugins/sola-support-tickets/" title="<?php _e("Sola Support Tickets","wplivechat"); ?>" target="_BLANK">
            <img width="320" src="<?php echo plugins_url('/images/plugin2.jpg', __FILE__); ?>" class="attachment-showcase wp-post-image" alt="<?php _e("Sola Support Tickets","wplivechat"); ?>" title="<?php _e("Sola Support Tickets","wplivechat"); ?>">
        </a>
        <p></p>
        <p><?php _e("The easiest to use Help Desk & Support Ticket plugin. Create a support help desk quickly and easily with Sola Support Tickets.","wplivechat"); ?></p>
        <p></p>
        <a href="https://wordpress.org/plugins/sola-support-tickets/" title="<?php _e("Sola Support Tickets","wplivechat"); ?>" class="button-secondary" target="_BLANK"><?php _e("Get this Plugin","wplivechat"); ?></a>
    </div>

    <div class="wplc-extension wplc-plugin">
        <h3 class="wplc-extension-title"><?php _e("Nifty Newsletters","wplivechat"); ?></h3>
        <a href="https://wordpress.org/plugins/sola-newsletters/" title="<?php _e("Nifty Newsletters","wplivechat"); ?>" target="_BLANK">
            <img width="320" src="<?php echo plugins_url('/images/plugin1.jpg', __FILE__); ?>" class="attachment-showcase wp-post-image" alt="<?php _e("Nifty Newsletters","wplivechat"); ?>" title="<?php _e("Nifty Newsletters","wplivechat"); ?>">
        </a>
        <p></p>
        <p><?php _e("Create and send newsletters, automatic post notifications and autoresponders that are modern and beautiful with Nifty Newsletters.","wplivechat"); ?></p>
        <p></p>
        <a href="https://wordpress.org/plugins/sola-newsletters/" title="<?php _e("Nifty Newsletters","wplivechat"); ?>" class="button-secondary" target="_BLANK"><?php _e("Get this Plugin","wplivechat"); ?></a>
    </div>


    <?php } else {
        $filter1 = "all";
        $filter2 = "all";

        if (isset($_GET['filter1'])) { $filter1 = $_GET['filter1']; }
        if (isset($_GET['filter2'])) { $filter2 = $_GET['filter2']; }

        $style_strong = 'style="font-weight:bold;"';
        $style_normal = 'style="font-weight:normal;"';

        $filter1_all_style = $style_normal;
        $filter1_free_style = $style_normal;
        $filter1_paid_style = $style_normal;
        $filter2_both_style = $style_normal;
        $filter2_free_style = $style_normal;
        $filter2_pro_style = $style_normal;

        if ($filter1 == "all") { $filter1_all_style = $style_strong; }
        else if ($filter1 == "free") { $filter1_free_style = $style_strong; }
        else if ($filter1 == "paid") { $filter1_paid_style = $style_strong; }
        else { $filter1_all_style = $style_strong; }
        if ($filter2 == "all") { $filter2_both_style = $style_strong; }
        else if ($filter2 == "free") { $filter2_free_style = $style_strong; }
        else if ($filter2 == "pro") { $filter2_pro_style = $style_strong; }
        else { $filter2_both_style = $style_strong; }


        echo "<p><div style='display:block; overflow:auto; clear:both;'>";
        echo "<strong>".__("Price:","wplivechat")."</strong> ";
        echo "<a href='admin.php?page=wplivechat-menu-extensions-page&filter1=all&filter2=".$filter2."' $filter1_all_style>".__("All","wplivechat")."</a> |";
        echo "<a href='admin.php?page=wplivechat-menu-extensions-page&filter1=free&filter2=".$filter2."' $filter1_free_style>".__("Free","wplivechat")."</a> |";
        echo "<a href='admin.php?page=wplivechat-menu-extensions-page&filter1=paid&filter2=".$filter2."' $filter1_paid_style>".__("Paid","wplivechat")."</a>";
        echo "</div></p>";
        echo "<p><div style='display:block; overflow:auto; clear:both;'>";
        echo "<strong>".__("For:","wplivechat")."</strong> ";
        echo "<a href='admin.php?page=wplivechat-menu-extensions-page&filter2=all&filter1=".$filter1."' $filter2_both_style>".__("Both","wplivechat")."</a> |";
        echo "<a href='admin.php?page=wplivechat-menu-extensions-page&filter2=free&filter1=".$filter1."' $filter2_free_style>".__("Free version","wplivechat")."</a> |";
        echo "<a href='admin.php?page=wplivechat-menu-extensions-page&filter2=pro&filter1=".$filter1."' $filter2_pro_style>".__("Pro version","wplivechat")."</a>";
        echo "</div></p>";


        $response = wp_remote_post( "https://ccplugins.co/api-wplc-extensions", array(
                'method' => 'POST',
                'body' => array(
                    'action' => 'extensions',
                    'filter1' => $filter1,
                    'filter2' => $filter2
                )
            )
        );
	    if(is_array($response) && isset($response['body'])){
		    $data = json_decode($response['body']);
		    global $wplc_version;
		    $wplc_version = str_replace(",","",$wplc_version);
		    if ($data) {
			    $output = "";
			    foreach ($data as $extension) {
				    if (!isset($extension->fromversion)) { $extension->fromversion = 0; }
				    if (intval($wplc_version) >= intval($extension->fromversion)) {
					    $output .= '<div class="wplc-extension">';
					    $output .= '<h3 class="wplc-extension-title">'.$extension->title.'</h3>';
					    $output .= '<a href="'.$extension->link.'" title="'.$extension->title.'" target="_BLANK">';
					    $output .= '<img width="320" height="200" src="'.$extension->image.'" class="attachment-showcase wp-post-image" alt="'.$extension->title.'" title="'.$extension->title.'">';
					    $output .= '</a>';
					    $output .= '<p></p>';
					    $output .= '<p><div class="wplc-extension-label-box">';
					    $output .= '</div></p>';
					    $output .= '<p>'.$extension->description.'</p>';
					    if ($extension->slug != false && is_plugin_active($extension->slug."/".$extension->slug.".php")) {
						    $button = '<a href="javascriot:void(0);" title="" disabled class="button-secondary">'.__("Already installed","wplivechat").'</a>';
					    } else {
						    $button = '<a href="'.$extension->link.'" title="'.$extension->title.'" class="button-secondary" target="_BLANK">'.$extension->button_text.'</a>';
					    }
					    $output .= $button;
					    $output .= '</div>';
				    }
			    }
			    echo $output;
		    }

	    }
    ?>



    <?php } ?>

    </div>
    <?php
}

/**
 * Loads the contents of the support menu item
 * @return string
 */
function wplc_support_menu() {
        wplc_stats("support");
?>
    <h1><?php _e("WP Live Chat Support","wplivechat"); ?></h1>
    <div class="wplc_row">
        <div class='wplc_row_col' style='background-color:#FFF;'>
            <h2><i class="fa fa-book fa-2x"></i> <?php _e("Documentation","wplivechat"); ?></h2>
            <hr />
            <p><?php _e("Getting started? Read through some of these articles to help you along your way.","wplivechat"); ?></p>
            <p><strong><?php _e("Documentation:","wplivechat"); ?></strong></p>
            <ul>
                <li><a href='https://wp-livechat.com/documentation/minimum-system-requirements/' target='_BLANK' title='<?php _e("Minimum System Requirements","wplivechat"); ?>'><?php _e("Minimum System Requirements","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/documentation/do-i-have-to-be-logged-into-the-dashboard-to-chat-with-visitors/' target='_BLANK' title='<?php _e("Do I have to be logged into the dashboard to chat with visitors?","wplivechat"); ?>'><?php _e("Do I have to be logged into the dashboard to chat with visitors?","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/documentation/what-are-quick-responses/' target='_BLANK' title='<?php _e("What are Quick Responses?","wplivechat"); ?>'><?php _e("What are Quick Responses?","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/documentation/troubleshooting/is-this-plugin-multi-site-friendly/' target='_BLANK' title='<?php _e("Can I use this plugin on my multi-site?","wplivechat"); ?>'><?php _e("Can I use this plugin on my multi-site?","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/documentation/how-do-i-disable-apc-object-cache/' target='_BLANK' title='<?php _e("How do I disable APC Object Cache?","wplivechat"); ?>'><?php _e("How do I disable APC Object Cache?","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/documentation/do-you-have-a-mobile-app/' target='_BLANK' title='<?php _e("Do you have a mobile app?","wplivechat"); ?>'><?php _e("Do you have a mobile app?","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/documentation/how-do-i-check-for-javascript-errors-on-my-site/' target='_BLANK' title='<?php _e("How do I check for JavaScript errors on my site?","wplivechat"); ?>'><?php _e("How do I check for JavaScript errors on my site?","wplivechat"); ?></a></li>
            </ul>
        </div>
        <div class='wplc_row_col' style='background-color:#FFF;'>
            <h2><i class="fa fa-exclamation-circle fa-2x"></i> <?php _e("Troubleshooting","wplivechat"); ?></h2>
            <hr />
            <p><?php _e("WP Live Chat Support  has a diverse and wide range of features which may, from time to time, run into conflicts with the thousands of themes and other plugins on the market.", "wplivechat"); ?></p>
            <p><strong><?php _e("Common issues:","wplivechat"); ?></strong></p>
            <ul>
                <li><a href='https://wp-livechat.com/documentation/troubleshooting/the-chat-box-doesnt-show-up/' target='_BLANK' title='<?php _e("The chat box doesnt show up","wplivechat"); ?>'><?php _e("The chat box doesnt show up","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/documentation/the-chat-window-disappears-when-i-logout-or-go-offline/' target='_BLANK' title='<?php _e("The chat window disappears when I logout or go offline","wplivechat"); ?>'><?php _e("The chat window disappears when I logout or go offline","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/this-chat-has-already-been-answered-please-close-the-chat-window/' target='_BLANK' title='<?php _e("This chat has already been answered. Please close the chat window","wplivechat"); ?>'><?php _e("This chat has already been answered. Please close the chat window","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/messages-only-show-when-i-refresh-the-chat-window/' target='_BLANK' title='<?php _e("Messages only show when I refresh the chat window","wplivechat"); ?>'><?php _e("Messages only show when I refresh the chat window","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/documentation/im-not-getting-any-notifications-of-a-new-chat/' target='_BLANK' title='<?php _e("I'm not getting any notifications of a new chat","wplivechat"); ?>'><?php _e("I'm not getting any notifications of a new chat","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/the-chat-window-never-goes-offline/' target='_BLANK' title='<?php _e("The chat window never goes offline","wplivechat"); ?>'><?php _e("The chat window never goes offline","wplivechat"); ?></a></li>
            </ul>
        </div>
        <div class='wplc_row_col' style='background-color:#FFF;'>
            <h2><i class="fa fa-bullhorn fa-2x"></i> <?php _e("Support","wplivechat"); ?></h2>
            <hr />
            <p><?php _e("Still need help? Use one of these links below.","wplivechat"); ?></p>
            <ul>
                <li><a href='https://wp-livechat.com/support/' target='_BLANK' title='<?php _e("Support desk","wplivechat"); ?>'><?php _e("Support desk","wplivechat"); ?></a></li>
                <li><a href='https://wp-livechat.com/contact-us/' target='_BLANK' title='<?php _e("Contact us","wplivechat"); ?>'><?php _e("Contact us","wplivechat"); ?></a></li>
            </ul>
        </div>
    </div>
<?php
}
if (!function_exists("wplc_ic_initiate_chat_button")) {
    add_action('admin_enqueue_scripts', 'wp_button_pointers_load_scripts');
}
/**
 * Displays the pointers on teh live chat dashboard for the initiate chat functionality
 * @param  string $hook returns the page name we're on
 * @return string       contents ofthe pointers and their scripts
 */
function wp_button_pointers_load_scripts($hook) {
	$wplcrun = false;
	global $wplc_version;

	$wplc_settings = get_option("WPLC_SETTINGS");
	if ( isset( $wplc_settings['wplc_enable_all_admin_pages'] ) && $wplc_settings['wplc_enable_all_admin_pages'] === '1' ) {
		/* Run admin JS on all admin pages */
		$wplcrun = true;


	} else {

		if( $hook === 'toplevel_page_wplivechat-menu') { $wplcrun = true; } // stop if we are not on the right page
	}


	if ( $wplcrun ) {




	    $pointer_localize_strings = array(
	    "initiate" => "<h3>".__("Initiate Chats","wplivechat")."</h3><p>".__("With the Pro add-on of WP Live Chat Support, you can", "wplivechat")." <a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=initiate1_pointer' title='".__("see who's online and initiate chats", "wplivechat")."' target=\"_BLANK\">".__("initiate chats", "wplivechat")."</a> ".__("with your online visitors with the click of a button.", "wplivechat")." <br /><br /><a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=initiate2_pointer' title='".__("Buy the Pro add-on now (once off payment).", "wplivechat")."' target=\"_BLANK\"><strong>".__("Buy the Pro add-on now (once off payment).", "wplivechat")."</strong></a></p>",
	    "chats" => "<h3>".__("Multiple Chats","wplivechat")."</h3><p>".__("With the Pro add-on of WP Live Chat Support, you can", "wplivechat")." <a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=morechats1_pointer' title='".__("accept and handle multiple chats.", "wplivechat")."' target=\"_BLANK\">".__("accept and handle multiple chats.", "wplivechat")."</a><br /><br /><a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=morechats2_pointer' title='".__("Buy the Pro add-on now (once off payment).", "wplivechat")."' target=\"_BLANK\"><strong>".__("Buy the Pro add-on now (once off payment).", "wplivechat")."</strong></a></p>",
	    "agent_info" => "<h3>".__("Add unlimited agents","wplivechat")."</h3><p><a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=unlimited_agents1_pointer' title='".__("Add unlimited agents", "wplivechat")."' target=\"_BLANK\">".__("Add unlimited agents", "wplivechat")."</a> ".__(" with the Pro add-on of WP Live Chat Support","wplivechat")." "."<a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=unlimited_agents2_pointer' target='_BLANK'>".__("(once off payment).","wplivechat")."</a></p>",
	    "transfer" => "<h3>".__("Transfer Chats","wplivechat")."</h3><p><a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=transfer1_pointer' title='".__("Transfer Chats", "wplivechat")."' target=\"_BLANK\">".__("Transfer Chats", "wplivechat")."</a> ".__(" with the Pro add-on of WP Live Chat Support","wplivechat")." "."<a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=transfer2_pointer' target='_BLANK'>".__("(once off payment).","wplivechat")."</a></p>",
	    "direct_to_page" => "<h3>".__("Direct User To Page","wplivechat")."</h3><p><a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=direct_to_page_1' title='".__("Transfer Chats", "wplivechat")."' target=\"_BLANK\">".__("Direct User To Page", "wplivechat")."</a> ".__(" with the Pro add-on of WP Live Chat Support","wplivechat")." "."<a href='http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=direct_to_page_2' target='_BLANK'>".__("(once off payment).","wplivechat")."</a></p>"
	    );


	    wp_enqueue_style( 'wp-pointer' );
	    wp_enqueue_script( 'wp-pointer' );
	    wp_register_script('wplc-user-admin-pointer', plugins_url('/js/wplc-admin-pointers.js', __FILE__), array('wp-pointer'), $wplc_version);
	    wp_enqueue_script('wplc-user-admin-pointer');
	    wp_localize_script('wplc-user-admin-pointer', 'pointer_localize_strings', $pointer_localize_strings);
	}

}

add_filter( 'admin_footer_text', 'wplc_footer_mod' );
/**
 * Adds the WP Live Chat Support & CODECABIN_ footer contents to the relevant pages
 * @param  string $footer_text current footer text available to us
 * @return string              footer contents with our branding in it
 */
function wplc_footer_mod( $footer_text ) {
    if (isset($_GET['page']) && ($_GET['page'] == 'wplivechat-menu' ||  $_GET['page'] == 'wplivechat-menu-extensions-page' || $_GET['page'] == 'wplivechat-menu-settings' || $_GET['page'] == 'wplivechat-menu-offline-messages' || $_GET['page'] == 'wplivechat-menu-history')) {
        $footer_text_mod = sprintf( __( 'Thank you for using <a href="%1$s" target="_blank">WP Live Chat Support</a>! Please <a href="%2$s" target="_blank">rate us</a> on <a href="%2$s" target="_blank">WordPress.org</a>', 'wplivechat' ),
            'https://wp-livechat.com/?utm_source=plugin&utm_medium=link&utm_campaign=footer',
            'https://wordpress.org/support/view/plugin-reviews/wp-live-chat-support?filter=5#postform'
        );

        return str_replace( '</span>', '', $footer_text ) . ' | ' . $footer_text_mod . ' | ' . __('WP Live Chat Support is a product of','wplivechat') . ' <a target="_BLANK" href="http://codecabin.co.za/?utm_source=livechat&utm_medium=link&utm_campaign=footer" border="0"><img src="'.plugins_url('/images/codecabin.png', __FILE__).'" style="height:10px;"/></span></a>';
    } else {
        return $footer_text;
    }

}

add_filter("wplc_filter_admin_long_poll_chat_loop_iteration","wplc_filter_control_wplc_admin_long_poll_chat_iteration", 1, 3);
/**
 * Alters the admin's long poll chat iteration
 * @param  array $array     current chat data available to us
 * @param  array $post_data current post data available to us
 * @param  int 	 $i         count for each chat available
 * @return array            additional contents added to the chat data
 */
function wplc_filter_control_wplc_admin_long_poll_chat_iteration($array,$post_data,$i) {
  if(isset($post_data['action_2']) && $post_data['action_2'] == "wplc_long_poll_check_user_opened_chat"){
      $chat_status = wplc_return_chat_status(sanitize_text_field($post_data['cid']));
      if(intval($chat_status) == 3){
          $array['action'] = "wplc_user_open_chat";
      }
  } else {

  	  if ($post_data['first_run'] === "true") {
  	  	/* get the chat messages for the first run */
  	  	$array['chat_history'] = wplc_return_chat_messages($post_data['cid'], false, true, false, false, 'array', false);
  	  	$array['action'] = "wplc_chat_history";

  	  } else {

	      $new_chat_status = wplc_return_chat_status(sanitize_text_field($post_data['cid']));
	      if($new_chat_status != $post_data['chat_status']){
	          $array['chat_status'] = $new_chat_status;
	          $array['action'] = "wplc_update_chat_status";
	      }
	      $new_chat_message = wplc_return_admin_chat_messages(sanitize_text_field($post_data['cid']));

	      if($new_chat_message){

	          $array['chat_message'] = $new_chat_message;
	          $array['action'] = "wplc_new_chat_message";
	      }
	  }
  }

  return $array;
}


add_action("wplc_hook_agents_settings","wplc_hook_control_agents_settings", 10);
/**
 * Loads the contents of the chat agents in the settings page
 * @return string
 */
function wplc_hook_control_agents_settings() {
  $user_array = get_users(array(
        'meta_key' => 'wplc_ma_agent',
    ));

    echo "<h3>".__('Current Users that are Chat Agents', 'wplivechat')."</h3>";
    $wplc_agents = "<div class='wplc_agent_container'><ul>";

    if ($user_array) {
        foreach ($user_array as $user) {

            $wplc_agents .= "<li id=\"wplc_agent_li_".$user->ID."\">";
            $wplc_agents .= "<p><img src=\"//www.gravatar.com/avatar/" . md5($user->user_email) . "?s=80&d=mm\" /></p>";
             $check = get_user_meta($user->ID,"wplc_chat_agent_online");
            if ($check) {
                $wplc_agents .= "<span class='wplc_status_box wplc_type_returning'>".__("Online","wplivechat")."</span>";
            }
            $default_agent_id = $user->ID;
            $default_agent_user = $user->display_name;
            $wplc_agents .= "<h3>" . $user->display_name . "</h3>";

            $wplc_agents .= "<small>" . $user->user_email . "</small>";




            $wplc_agents .= "</li>";
        }
    }
    echo $wplc_agents;
    $temp_line = "<select name='wplc_agent_select' id='wplc_agent_select'><option value=''>".__("Select","wplivechat")."</option>";

    $blogusers = get_users( array( 'role' => 'administrator', 'fields' => array( 'display_name','id','user_email' ) ) );
    if ($blogusers) {
      foreach ( $blogusers as $user ) {
          $is_agent = get_user_meta(esc_html( $user->id ), 'wplc_ma_agent', true);
          $temp_line2 = '<option id="wplc_selected_agent_'. esc_html( $user->id ) .'" value="' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . ' ('.__('Administrator','wplivechat').')</option>';
          if(!$is_agent){ $temp_line .= $temp_line2; }
      }
    }

    $blogusers = get_users( array( 'role' => 'editor', 'fields' => array( 'display_name','id','user_email' ) ) );
    if ($blogusers) {
      foreach ( $blogusers as $user ) {
          $is_agent = get_user_meta(esc_html( $user->id ), 'wplc_ma_agent', true);
          $temp_line2 = '<option id="wplc_selected_agent_'. esc_html( $user->id ) .'" value="' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . ' ('.__('Editor','wplivechat').')</option>';
          if(!$is_agent){ $temp_line .= $temp_line2; }
      }
    }

    $blogusers = get_users( array( 'role' => 'author', 'fields' => array( 'display_name','id','user_email' ) ) );
    if ($blogusers) {
      foreach ( $blogusers as $user ) {
          $is_agent = get_user_meta(esc_html( $user->id ), 'wplc_ma_agent', true);
          $temp_line2 = '<option id="wplc_selected_agent_'. esc_html( $user->id ) .'" value="' . esc_html( $user->id ) . '">' . esc_html( $user->display_name ) . ' ('.__('Author','wplivechat').')</option>';
          if(!$is_agent){ $temp_line .= $temp_line2; }
      }
    }

    $temp_line .= "</select> ";
    ?>


      <li style='width:150px;' id='wplc_add_new_agent_box'>
        <p><i class='fa fa-plus-circle fa-4x' style='color:#ccc;' ></i></p>
        <h3><?php _e("Add New Agent","wplivechat"); ?></h3>
        <p><button class='button button-secondary' id='wplc_add_agent' disabled style=><?php _e("Add Agent","wplivechat"); ?></button></p>
        <p style='font-size:0.8em'><?php _e("Add as many agents as you need with the ","wplivechat") ?> <a href="https://wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=multipleAgents" target="_BLANK"><?php _e("Pro version.", "wplivechat") ?></a></p>
    </li>
</ul>
<?php
  $agent_text = sprintf( __( 'Change the default chat agent from <strong>%1$s</strong> to ', 'wplivechat' ),
      $default_agent_user

  );
  echo $agent_text.$temp_line;
?>

</div>

  <hr/>
<?php
}

/**
 * Returns chat data specific to a chat ID
 * @param  int 		$cid  Chat ID
 * @param  string 	$line Line number the function is called on
 * @return array    	  Contents of the chat based on the ID provided
 */
function wplc_get_chat_data($cid,$line = false) {
	$result = apply_filters("wplc_filter_get_chat_data",null,$cid);
	return $result;
}

add_filter( "wplc_filter_get_chat_data", "wplc_get_local_chat_data", 10, 2 );
function wplc_get_local_chat_data($result, $cid) {
  	global $wpdb;
  	global $wplc_tblname_chats;

  	$sql = "SELECT * FROM $wplc_tblname_chats WHERE `id` = '".intval($cid)."' LIMIT 1";
  	$results = $wpdb->get_results($sql);
  	if (isset($results[0])) { $result = $results[0]; } else {  $result = null; }

  	return $result;

}

/**
 * Returns chat messages specific to a chat ID
 * @param  int 		$cid  Chat ID
 * @return array 		  Chat messages based on the ID provided
 */
function wplc_get_chat_messages($cid, $only_read_messages = false, $wplc_settings = false) {
  global $wpdb;
  global $wplc_tblname_msgs;

  if (!$wplc_settings) {
      $wplc_settings = get_option("WPLC_SETTINGS");
  }

  /**
   * Identify if the user is using the node server and if they are, display all messages. Otherwise display read only messages (non-node users)
   */
  if (isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == '1') {

          $sql = "
            SELECT * FROM (
                SELECT *
                FROM $wplc_tblname_msgs
                WHERE `chat_sess_id` = '$cid'
                ORDER BY `timestamp` DESC LIMIT 100
            ) sub 
            ORDER BY `timestamp` ASC
            ";
    } else {
        if ($only_read_messages) {
        // only show read messages
              $sql =
                "
                SELECT * FROM (
                    SELECT *
                    FROM $wplc_tblname_msgs
                    WHERE `chat_sess_id` = '$cid' AND `status` = 1
                    ORDER BY `timestamp` DESC LIMIT 100
                ) sub 
                ORDER BY `timestamp` ASC
                ";
        } else {
            $sql =
                "
                SELECT * FROM (
                    SELECT *
                    FROM $wplc_tblname_msgs
                    WHERE `chat_sess_id` = '$cid'
                    ORDER BY `timestamp` DESC LIMIT 100
                ) sub 
                ORDER BY `timestamp` ASC
                ";
        }

    }
    $results = $wpdb->get_results($sql);

  if (isset($results[0])) {  } else {  $results = null; }
  $results = apply_filters("wplc_filter_get_chat_messages",$results,$cid);

  if ($results == "null") {
    return false;
  } else {
    return $results;
  }
}

/**
 * Validates extension API keys
 * @param  string 	$page_content Current page contents in the extensions page
 * @param  array 	$data         Extension data such as name and slug
 * @return string                 Updated extensions page contents
 */
function wplc_build_api_check($page_content, $data) {
        $link = "#";
        $image = "https://ccplugins.co/api-wplc-extensions/images/add-on0.jpg";
        if ($data['string'] == "Multiple Agents") {
          $link = "";
          $image = "https://ccplugins.co/api-wplc-extensions/images/Agents-Small.jpg";
        }
        if ($data['string'] == "Cloud Server") {
          $link = "";
          $image = "https://ccplugins.co/api-wplc-extensions/images/Cloud-Small.jpg";
        }
        if ($data['string'] == "Advanced Chat Box Control") {
          $link = "https://wp-livechat.com/extensions/advanced-chat-control/";
          $image = "https://ccplugins.co/api-wplc-extensions/images/AdvancedChatBox-Small.jpg";
        }
        if ($data['string'] == "Choose When Online") {
          $link = "";
          $image = "https://ccplugins.co/api-wplc-extensions/images/ChooseOnline-Small.jpg";
        }
        if ($data['string'] == "Encryption") {
          $link = "";
          $image = "https://ccplugins.co/api-wplc-extensions/images/Encryption-Small.jpg";
        }
        if ($data['string'] == "Mobile and Desktop App") {
          $link = "";
          $image = "https://ccplugins.co/api-wplc-extensions/images/MobileDesktop-Small.jpg";
        }
        if ($data['string'] == "Initiate Chats") {
          $link = "";
          $image = "https://ccplugins.co/api-wplc-extensions/images/InitiateChat-Small.jpg";
        }
        if ($data['string'] == "Include Exclude Pages") {
          $link = "";
          $image = "https://ccplugins.co/api-wplc-extensions/images/IncludeAndExclude-Small.jpg";
        }


        if ($data['string'] == "WP Live Chat Support Pro") {
          $link = "";
          $image = "https://ccplugins.co/api-wplc-extensions/images/add-on0.jpg";
        }


        $page_content .= '<div class="wplc-extension" style="height:480px;">';
        $page_content .= '<a href="'.$link.'" title="'.$data['string'].'" target="_BLANK" style=" text-decoration:none;"><h3 class="wplc-extension-title" style="text-decoration:none;">'.$data['string'].'</h3></a>';
        $page_content .= '<img width="320" height="200" src="'.$image.'" alt="'.$data['string'].'" title="'.$data['string'].'">';
        $page_content .= '<p>'.__('API Key','wplivechat').'<br />';
        $page_content .= "        <form name='".$data['form_name']."' action='' method='POST'>";
        $page_content .= "            <input type='text' name='".$data['option_name']."' id='".$data['option_name']."' value='".get_option($data['option_name'])."' style='width: 250px;'/>";
        $page_content .= "            <input type='submit' name='".$data['button']."' id='".$data['button']."' value='".__("Verify","wplivechat")."' />";
        $page_content .= "        </form>";
        $page_content .= '</p>';
        $page_content .= '<p>'.__('Status: ','wplivechat');
        if (isset($data['data']['status']) && $data['data']['status'] == "OK") {
            update_option($data['is_valid'], 1);
            $page_content .= "<span style='color: white; font-weight: bold; background-color: green; border-radius: 5px; padding: 3px;'>". __('Valid', 'wplivechat') . '</span>';
            $page_content .= '<a href="https://wp-livechat.com/my-account/" title="'.__('Manage this extension','wplivechat').'" class="button-secondary" target="_BLANK">'.__('Manage this extension','wplivechat').'</a>';
        } else {
            update_option($data['is_valid'], 0);
            $page_content .= "<span style='color: white; font-weight: bold; background-color: red; border-radius: 5px; padding: 3px;'>" . __('Invalid', 'wplivechat') . '</span>';
            $page_content .= '<a href="https://wp-livechat.com/my-account/" title="'.__('Manage this extension','wplivechat').'" class="button-secondary" target="_BLANK">'.__('Manage this extension','wplivechat').'</a>';
        }
        $page_content .= '</p>';
        $page_content .= '<div style="dispaly:block; width:100%; height:100px; overflow:auto;">';
        if (isset($data['data']['domains']) && !empty($data['data']['domains'])) {
            $page_content .= '<span><strong>'.__("Linked Domains","wplivechat").'</strong></span><ol>';
            foreach ($data['data']['domains'] as $domain) {
                $page_content .= '<li>'.$domain.'</li>';
            }
            $page_content .= '</ol>';
        } else {
            $page_content .= '              <span>'.$data['data']['message'].'</span>';

        }
        $page_content .= '</div>';

        $page_content .= '</div>';




        return $page_content;
}



add_filter("wplc_filter_relevant_extensions_main","wplc_filter_control_relevant_extensions_main_proe");
/**
 * Loads additional extension data for the Pro version
 * @param  string $text Current extensions page content
 * @return string       Extensions page content with Pro version extension data
 */
function wplc_filter_control_relevant_extensions_main_proe($text) {
  if (function_exists("wplc_hook_control_intiate_check")) { return $text; }

  $rel_name = __("Pro Add-on","wplivechat");
  $rel_image = "https://ccplugins.co/api-wplc-extensions/images/add-on0.jpg";
  $rel_link = "http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=relevant_pro";
  $text .= '<div class="wplc-extension relevant_extension">';
  $text .= '<a href="'.$rel_link.'" title="'.$rel_name.'" target="_BLANK" style="float:left;">';
  $text .= '<img src="'.$rel_image.'" class="attachment-showcase wp-post-image" alt="'.$rel_name.'" title="'.$rel_name.'" >';
  $text .= '</a>';
  $text .= '<div class="float:left; padding-left:10px;">';
  $text .= '<h3 class="wplc-extension-title">'.$rel_name.'</h3>';
  $text .= '<p>'.__("Get unlimited agents, initiate chats, advanced chat box control, encryption and more with the Pro add-on.","wplivechat").'</p>';
  $text .= '</div>';
  $text .= '<a href="'.$rel_link.'" title="'.$rel_name.'" class="button-secondary" target="_BLANK">'.__("Get this extension","wplivechat").'</a>';
  $text .= '</div>';

  return $text;
}


add_filter("wplc_filter_relevant_extensions_main","wplc_filter_control_relevant_extensions_main_mobile");
/**
 * Loads additional extension data for the Mobile & Desktop App Extension
 * @param  string $text Current extensions page content
 * @return string       Extensions page content with Mobile & Desktop App extension data
 */
function wplc_filter_control_relevant_extensions_main_mobile($text) {
  if (function_exists("wplc_mobile_check_if_logged_in")) { return $text; }

  $rel_name = __("Mobile & Desktop App","wplivechat");
  $rel_image = "https://ccplugins.co/api-wplc-extensions/images/MobileDesktop-Icon.jpg";
  $rel_link = "https://wp-livechat.com/extensions/mobile-desktop-app-extension/?utm_source=plugin&amp;utm_medium=link&amp;utm_campaign=relevant_mobile";
  $text .= '<div class="wplc-extension relevant_extension">';
  $text .= '<a href="'.$rel_link.'" title="'.$rel_name.'" target="_BLANK" style="float:left;">';
  $text .= '<img src="'.$rel_image.'" class="attachment-showcase wp-post-image" alt="'.$rel_name.'" title="'.$rel_name.'" >';
  $text .= '</a>';
  $text .= '<div class="float:left; padding-left:10px;">';
  $text .= '<h3 class="wplc-extension-title">'.$rel_name.'</h3>';
  $text .= '<p>'.__("Answer chats directly from your mobile phone or desktop with our mobile app and desktop client","wplivechat").'</p>';
  $text .= '</div>';
  $text .= '<a href="'.$rel_link.'" title="'.$rel_name.'" class="button-secondary" target="_BLANK">'.__("Get this extension","wplivechat").'</a>';
  $text .= '</div>';

  return $text;
}


add_filter("wplc_filter_relevant_extensions_chatbox","wplc_filter_control_relevant_extensions_chatbox_proe");
/**
 * Loads additional extension data for the Pro version - alternative option
 * @param  string $text Current extensions page content
 * @return string       Extensions page content with Pro version extension data
 */
function wplc_filter_control_relevant_extensions_chatbox_proe($text) {
  if (function_exists("wplc_hook_control_intiate_check")) { return $text; }

  $rel_name = __("Pro Add-on","wplivechat");
  $rel_image = "https://ccplugins.co/api-wplc-extensions/images/add-on0.jpg";
  $rel_link = "http://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=relevant_pro_chatbox";
  $text .= '<div class="wplc-extension relevant_extension">';
  $text .= '<a href="'.$rel_link.'" title="'.$rel_name.'" target="_BLANK" style="float:left;">';
  $text .= '<img src="'.$rel_image.'" class="attachment-showcase wp-post-image" alt="'.$rel_name.'" title="'.$rel_name.'" >';
  $text .= '</a>';
  $text .= '<div class="float:left; padding-left:10px;">';
  $text .= '<h3 class="wplc-extension-title">'.$rel_name.'</h3>';
  $text .= '<p>'.__("Get unlimited agents, initiate chats, advanced chat box control, encryption and more with the Pro add-on.","wplivechat").'</p>';
  $text .= '</div>';
  $text .= '<a href="'.$rel_link.'" title="'.$rel_name.'" class="button-secondary" target="_BLANK">'.__("Get this extension","wplivechat").'</a>';
  $text .= '</div>';

  return $text;
}

/**
 * Add to the chat box settings page
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
add_action('wplc_hook_admin_settings_chat_box_settings_after','wplc_hook_control_settings_page_relevant_extensions_acbc',9);
function wplc_hook_control_settings_page_relevant_extensions_acbc() {
    $check = apply_filters("wplc_filter_relevant_extensions_chatbox","");
    if ($check != "") {
      echo "<hr />";
      echo "<div style='padding:1%; width:98%; display:block; overflow:auto;'>";
      echo "<div class='display:block; font-weight:bold;'><strong>".__("Relevant Extensions",'wplivechat')."</strong><br /><br /></div>";
      echo "";
      echo $check;
      echo "";
      echo "";
      echo "</div>";
    }
}

/**
 * Add to the chat box settings page
 * @return void
 * @since  1.0.00
 * @author Nick Duncan <nick@codecabin.co.za>
 */
add_action('wplc_hook_admin_settings_main_settings_after','wplc_hook_control_settings_page_relevant_extensions_main',9);
function wplc_hook_control_settings_page_relevant_extensions_main() {
    $check = apply_filters("wplc_filter_relevant_extensions_main","");
    if ($check != "") {
      echo "<hr />";
      echo "<div style='padding:1%; width:98%; display:block; overflow:auto;'>";
      echo "<div class='display:block; font-weight:bold;'><strong>".__("Relevant Extensions",'wplivechat')."</strong><br /><br /></div>";
      echo "";
      echo $check;
      echo "";
      echo "";
      echo "</div>";
    }
}



add_filter("wplc_filter_hovercard_bottom_before","wplc_filter_control_hovercard_bottom_before_pro",5,1);
/**
 * Adds a powered by link to the hovercard
 * @param  string 	$content 	current chat content of the hover card
 * @return string          		chat content with the powered by link
 * @deprecated 7.0.0 			rebuilt unknowingly
 */
function wplc_filter_control_hovercard_bottom_before_pro($content) {
	$wplc_settings = get_option("WPLC_SETTINGS");
	if(isset($wplc_settings["wplc_powered_by_link"]) && $wplc_settings["wplc_powered_by_link"] == 0){

	} else if(!isset($wplc_settings["wplc_powered_by_link"])) {

	} else{
		$content .= "<a title='".__("Powered By WP Live Chat Support", "wplivechat")."' target='_blank' rel='nofollow' href='https://wp-livechat.com/?utm_source=poweredby&utm_medium=click&utm_campaign=".esc_html(site_url())."' class='wplc_powered_by_link'>".__("Powered By WP Live Chat Support", "wplivechat")."</a>";
	}
	return $content;
}



add_action('admin_init', 'wplc_admin_download_new_chat_history');
/**
 * Downloads the chat history and adds it to a CSV file
 * @return file
 */
function wplc_admin_download_new_chat_history(){
	if(!is_user_logged_in() || !get_user_meta(get_current_user_id(), 'wplc_ma_agent', true) ){
	    return;
	}

	if (isset($_GET['action']) && $_GET['action'] == "download_history") {

        global $wpdb;

        $chat_id = sanitize_text_field( $_GET['cid'] );
        $fileName = 'live_chat_history_'.$chat_id.'.csv';

        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header('Content-Description: File Transfer');
        header("Content-type: text/csv");
        header("Content-Disposition: attachment; filename={$fileName}");
        header("Expires: 0");
        header("Pragma: public");

        $fh = @fopen( 'php://output', 'w' );

        global $wpdb;
	    global $wplc_tblname_msgs;

	    $results = $wpdb->get_results(
	        "
	        SELECT *
	        FROM $wplc_tblname_msgs
	        WHERE `chat_sess_id` = '$chat_id'
	        ORDER BY `timestamp` ASC
	        LIMIT 0, 100
	        "
	    );

	    $fields[] = array(
	        'id' => __('Chat ID', 'wplivechat'),
	        'msgfrom' => __('From', 'wplivechat'),
	        'msg' => __('Message', 'wplivechat'),
	        'time' => __('Timestamp', 'wplivechat'),
	        'orig' => __('Origin', 'wplivechat'),
	    );

	    foreach ($results as $result => $key) {
	        if($key->originates == 2){
	            $user = __('user', 'wplivechat');
	        } else {
	            $user = __('agent', 'wplivechat');
	        }

	        $fields[] = array(
	            'id' => $key->chat_sess_id,
	            'msgfrom' => $key->msgfrom,
	            'msg' => apply_filters("wplc_filter_message_control_out",$key->msg),
	            'time' => $key->timestamp,
	            'orig' => $user,
	        );
	    }

        foreach($fields as $field){
	    	fputcsv($fh, $field, ",", '"');
	    }
        // Close the file
        fclose($fh);
        // Make sure nothing else is sent, our file is done
        exit;

    }
}
/**
 * Retrieves the data to start downloadling the chat history
 * @param  string $type Chat history output type
 * @param  string $cid  Chat ID
 * @return void
 */
function wplc_admin_download_history($type, $cid){
  	if(!is_user_logged_in() || !get_user_meta(get_current_user_id(), 'wplc_ma_agent', true) ){
	    return;
	}

    global $wpdb;
    global $wplc_tblname_msgs;

    $results = $wpdb->get_results(
        "
        SELECT *
        FROM $wplc_tblname_msgs
        WHERE `chat_sess_id` = '$cid'
        ORDER BY `timestamp` ASC
        LIMIT 0, 100
        "
    );

    $fields[] = array(
        'id' => __('Chat ID', 'wplivechat'),
        'msgfrom' => __('From', 'wplivechat'),
        'msg' => __('Message', 'wplivechat'),
        'time' => __('Timestamp', 'wplivechat'),
        'orig' => __('Origin', 'wplivechat'),
    );

    foreach ($results as $result => $key) {
        if($key->originates == 2){
            $user = __('user', 'wplivechat');
        } else {
            $user = __('agent', 'wplivechat');
        }

        $fields[] = array(
            'id' => $key->chat_sess_id,
            'msgfrom' => $key->msgfrom,
            'msg' => apply_filters("wplc_filter_message_control_out",$key->msg),
            'time' => $key->timestamp,
            'orig' => $user,
        );
    }

    ob_end_clean();

    wplc_convert_to_csv_new($fields, 'live_chat_history_'.$cid.'.csv', ',');

    exit();
}

/**
 * Converts contents into a CSV file
 * @param  string $in  Contents of file
 * @param  string $out Output of file
 * @param  string $del Delimiter for content
 * @return void
 */
function wplc_convert_to_csv_new($in, $out, $del){

    $f = fopen('php://memory', 'w');

    foreach ($in as $line) {
        wplc_fputcsv_eol_new($f, $line, $del, "\r\n");
    }

    fseek($f, 0);

    header('Content-Type: application/csv');

    header('Content-Disposition: attachement; filename="' . $out . '";');

    fpassthru($f);
}
/**
 * Parses content to add to a CSV file
 * @param  string $fp    The open file
 * @param  string $array The content to be added to the file
 * @param  string $del   Delimiter to use in the file
 * @param  string $eol   Content to be written to the file
 * @return void
 */
function wplc_fputcsv_eol_new($fp, $array, $del, $eol) {
  fputcsv($fp, $array,$del);
  if("\n\r" != $eol && 0 === fseek($fp, -1, SEEK_CUR)) {
    fwrite($fp, $eol);
  }
}

/**
 * Adds an API key notice in the plugin's page
 * @return string
 */
function wplc_plugin_row_invalid_api() {
  echo '<tr class="active"><td>&nbsp;</td><td colspan="2" style="color:red;">
    &nbsp; &nbsp; '.__('Your API Key is Invalid. You are not eligible for future updates. Please enter your API key <a href="admin.php?page=wplivechat-menu-api-keys-page">here</a>.','wplivechat').'
    </td></tr>';
}

/**
 * Hides the chat when offline
 * @return int Incremented number if any agents have logged in
 */
function wplc_basic_hide_chat_when_offline(){
    $wplc_settings = get_option("WPLC_SETTINGS");

    $hide_chat = 0;
    if (isset($wplc_settings['wplc_hide_when_offline']) && $wplc_settings['wplc_hide_when_offline'] == 1) {
        /* Hide the window when its offline */
        $logged_in = apply_filters("wplc_loggedin_filter",false);
        if (!$logged_in) {
            $hide_chat++;
        }
    } else {
        $hide_chat = 0;
    }
    return $hide_chat;
}

/**
 * Checks all strings that are added to the chat window
 * @return void
 */
function wplc_string_check() {
  $wplc_settings = get_option("WPLC_SETTINGS");

	if (!isset($wplc_settings['wplc_pro_na'])) { $wplc_settings["wplc_pro_na"] = __("Chat offline. Leave a message", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_intro'])) { $wplc_settings["wplc_pro_intro"] = __("Hello. Please input your details so that I may help you.", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_offline1'])) { $wplc_settings["wplc_pro_offline1"] = __("We are currently offline. Please leave a message and we'll get back to you shortly.", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_offline2'])) { $wplc_settings["wplc_pro_offline2"] =  __("Sending message...", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_offline3'])) { $wplc_settings["wplc_pro_offline3"] = __("Thank you for your message. We will be in contact soon.", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_offline_btn']) || (isset($wplc_settings['wplc_pro_offline_btn']) && $wplc_settings['wplc_pro_offline_btn'] == "")) { $wplc_settings["wplc_pro_offline_btn"] = __("Leave a message", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_offline_btn_send']) || (isset($wplc_settings['wplc_pro_offline_btn_send']) && $wplc_settings['wplc_pro_offline_btn_send'] == "")) { $wplc_settings["wplc_pro_offline_btn_send"] = __("Send message", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_fst1'])) { $wplc_settings["wplc_pro_fst1"] = __("Questions?", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_fst2'])) { $wplc_settings["wplc_pro_fst2"] = __("Chat with us", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_fst3'])) { $wplc_settings["wplc_pro_fst3"] = __("Start live chat", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_sst1'])) { $wplc_settings["wplc_pro_sst1"] = __("Start Chat", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_sst1_survey'])) { $wplc_settings["wplc_pro_sst1_survey"] = __("Or chat to an agent now", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_sst1e_survey'])) { $wplc_settings["wplc_pro_sst1e_survey"] = __("Chat ended", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_sst2'])) { $wplc_settings["wplc_pro_sst2"] = __("Connecting. Please be patient...", "wplivechat"); }
	if (!isset($wplc_settings['wplc_pro_tst1'])) { $wplc_settings["wplc_pro_tst1"] = __("Reactivating your previous chat...", "wplivechat"); }
	if (!isset($wplc_settings['wplc_user_welcome_chat'])) { $wplc_settings["wplc_user_welcome_chat"] = __("Welcome. How may I help you?", "wplivechat"); }
	if (!isset($wplc_settings['wplc_welcome_msg'])) { $wplc_settings['wplc_welcome_msg'] = __("Please standby for an agent. While you wait for the agent you may type your message.","wplivechat"); }
	if (!isset($wplc_settings['wplc_user_enter'])) { $wplc_settings["wplc_user_enter"] = __("Press ENTER to send your message", "wplivechat"); }
	if (!isset($wplc_settings['wplc_close_btn_text'])) { $wplc_settings["wplc_close_btn_text"] = __("close", "wplivechat"); }

  update_option("WPLC_SETTINGS",$wplc_settings);

}

add_filter("wplc_filter_chat_text_editor_upsell","nifty_text_edit_upsell",1,1);
/**
 * Used to upsell the advanced text editor in the chat
 * @param  string $msg Current text in the chat window
 * @return string      Additional content added for upselling purposes
 */
function nifty_text_edit_upsell($msg){
	if(!function_exists("nifty_text_edit_div")  && !function_exists("wplc_pro_activate")){
		//Only show this if in admin area and is not PRO
		$msg .= "<div id='nifty_text_editor_holder' class='wplc_faded_upsell'>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-bold' id='nifty_tedit_b'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-italic' id='nifty_tedit_i'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-underline' id='nifty_tedit_u'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-strikethrough' id='nifty_tedit_strike'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-square' id='nifty_tedit_mark'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-subscript' id='nifty_tedit_sub'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-superscript' id='nifty_tedit_sup'></i>";
	    $msg .=   "<i class='nifty_tedit_icon fa fa-link' id='nifty_tedit_link'></i>";
	    $msg .=   "<i class='nifty_tedit_icon'><a target='_BLANK' href='https://wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=text_editor'>Pro version only</a></i>";
	    $msg .= "</div>";
	}
	return $msg;
}

add_filter("wplc_filter_advanced_info","nifty_rating_advanced_info_upsell",1,4);
/**
 * Chat experience ratings upselling page
 * @param  string 	$msg  	current chat window contents
 * @param  int 		$cid  	chat ID
 * @param  string 	$name 	User's name
 * @return string       	current chat window contents with the experience rating content appended
 */
function nifty_rating_advanced_info_upsell($msg, $cid, $name, $chat_data){
	if(!function_exists("nifty_rating_advanced_info_control") && is_admin() && !function_exists("wplc_pro_activate")){
		$msg .= "<div class='admin_visitor_advanced_info admin_agent_rating wplc_faded_upsell'>
	                <strong>" . __("Experience Rating", "wplivechat") . "</strong>
	                <div class='rating'><a target='_BLANK' href='https://wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=experience_ratings'>Pro only</a></div>
	            </div>";
    }
	return $msg;
}

add_filter("wplc_filter_typing_control_div","wplc_basic_filter_control_return_chat_response_box_before",2,1);
function wplc_basic_filter_control_return_chat_response_box_before($string) {
    remove_filter("wplc_filter_typing_control_div","wplc_pro_filter_control_return_chat_response_box_before");
    $string = $string. "<div class='typing_indicator wplc-color-2 wplc-color-bg-1'></div>";

    return $string;
}
add_filter("wplc_filter_typing_control_div_theme_2","wplc_basic_filter_control_return_chat_response_box_before_theme2",2,1);
function wplc_basic_filter_control_return_chat_response_box_before_theme2($string) {
    remove_filter("wplc_filter_typing_control_div_theme_2","wplc_pro_filter_control_return_chat_response_box_before_theme2");
    $string = $string. "<div class='typing_indicator wplc-color-2 wplc-color-bg-1'></div>";

    return $string;
}


add_action("wplc_hook_admin_settings_main_settings_after","wplc_hook_control_admin_settings_chat_box_settings_after",2);
/**
 * Adds the settings to allow the user to change their server environment variables
 * @return sring */
function wplc_hook_control_admin_settings_chat_box_settings_after() {

	$wplc_settings = get_option("WPLC_SETTINGS");
    if (isset($wplc_settings["wplc_environment"])) { $wplc_environment[intval($wplc_settings["wplc_environment"])] = "SELECTED"; }

	?>
	<h4><?php _e("Advanced settings", "wplivechat") ?></h4>
	<table class='wp-list-table wplc_list_table widefat fixed striped pages' width='700'>

          <?php do_action("wplc_advanced_settings_above_performance", $wplc_settings); ?>
      </table>
      <p>&nbsp;</p>
	<table class='wp-list-table wplc_list_table widefat fixed striped pages' width='700'>

          <tr>
          	<td colspan='2'>
          		<p><em><small><?php _e("Only change these settings if you are experiencing performance issues.","wplivechat"); ?></small></em></p>
          	</td>
          </tr>
          </tr>
          <?php do_action("wplc_advanced_settings_settings"); ?>
          <tr>
              <td valign='top'>
                  <?php _e("What type of environment are you on?","wplivechat"); ?>
              </td>
              <td valign='top'>
                  <select name='wplc_environment' id='wplc_environment'>
                    <option value='1' <?php if (isset($wplc_environment[1])) { echo $wplc_environment[1]; } ?>><?php _e("Shared hosting - low level plan","wplivechat"); ?></option>
                    <option value='2' <?php if (isset($wplc_environment[2])) { echo $wplc_environment[2]; } ?>><?php _e("Shared hosting - normal plan","wplivechat"); ?></option>
                    <option value='3' <?php if (isset($wplc_environment[3])) { echo $wplc_environment[3]; } ?>><?php _e("VPS","wplivechat"); ?></option>
                    <option value='4' <?php if (isset($wplc_environment[4])) { echo $wplc_environment[4]; } ?>><?php _e("Dedicated server","wplivechat"); ?></option>
                  </select>
              </td>
          </tr>
          <tr>
              <td valign='top'>
                  <?php _e("Long poll setup","wplivechat"); ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Only change these if you are an experienced developer or if you have received these figures from the Code Cabin Support team.", "wplivechat") ?>"></i>
              </td>
              <td valign='top'>
                <?php
                  $wplc_advanced_settings = get_option("wplc_advanced_settings");
                  ?>
                  <table>
                    <tr>
                      <td><?php _e("Iterations","wplivechat"); ?></td>
                      <td><input id="wplc_iterations" name="wplc_iterations" type="number" max='200' min='10'  value="<?php if (isset($wplc_advanced_settings['wplc_iterations'])) { echo $wplc_advanced_settings['wplc_iterations']; } else { echo '55'; } ?>" /></td>
                    </tr>
                    <tr>
                      <td><?php _e("Sleep between iterations","wplivechat"); ?></td>
                      <td>
                        <input id="wplc_delay_between_loops" name="wplc_delay_between_loops" type="number" max='1000000' min='25000'  value="<?php if (isset($wplc_advanced_settings['wplc_delay_between_loops'])) { echo $wplc_advanced_settings['wplc_delay_between_loops']; } else { echo '500000'; } ?>" />
                        <small><em><?php _e("microseconds","wplivechat"); ?></em></small>
                      </td>
                    </tr>
                  </table>

              </td>
          </tr>

      </table>
  <?php
}
/**
 * Basic version's reporting page
 * @return string
 */
function wplc_basic_reporting_page(){

	$content = "<div class='wrap wplc_wrap'>";
    $content .= "<h2>".__('WP Live Chat Support Reporting', 'wp-livechat')." (beta) </h2>";
	$content .= "<table class=\"wp-list-table wplc_list_table widefat fixed form-table\" cellspacing=\"0\" style='width:98%'>";
	$content .= 	"<tr>";
	$content .= 		"<td style='width:35%; vertical-align:top;'>";
	$content .= 			"<img class='reporting_img_main' style='width:99%; height:auto; padding:2px; border:1px lightgray solid;box-shadow: 3px 3px 2px -2px #999;-webkit-box-shadow: 3px 3px 2px -2px #999;-moz-box-shadow: 3px 3px 2px -2px #999;-o-box-shadow: 3px 3px 2px -2px #999;' src='".plugins_url('/images/reporting_sample.jpg', __FILE__)."'>";
	$content .= 		"</td>";
	$content .= 		"<td style='vertical-align:top;'>";
	$content .= 			"<h3>".__('WP Live Chat Support Reporting', 'wp-livechat')."</h3>";
	$content .= 			"<p>".__('View comprehensive reports regarding your chat and agent activity.', 'wp-livechat')."</p>";


	$content .= 			"<br><p><strong>".__('Reports', 'wp-livechat').":</strong></p>";
	$content .= 			"<ul style='list-style: inherit;margin-left: 22px;'>";
	$content .= 				"<li>".__('Chat statistics', 'wp-livechat')."</li>";
	$content .= 				"<li>".__('Popular pages', 'wp-livechat')."</li>";
	$content .= 				"<li>".__('ROI reporting and tracking (identify which agents produce the most sales)', 'wp-livechat')."</li>";
	$content .= 				"<li>".__('User experience ratings (identify which agents produce the happiest customers)', 'wp-livechat')."</li>";
	$content .= 			"</ul>";

	if (function_exists("wplc_pro_activate")) {
		global $wplc_pro_version;
        if (intval(str_replace(".","",$wplc_pro_version)) < 6300) {
	  		$content .= "<p>In order to use reporting, please ensure you are using the latest Pro version (version 6.3.00 or newer).</p>";
			$content .=  "<br><a title='Update Now' href='./update-core.php' style='width: 200px;height: 58px;text-align: center;line-height: 56px;font-size: 18px;' class='button button-primary'>".__("Update now" ,"wplivechat")."</a>";
        }
	} else {
		$content .= 			"<p>".__('Get all this and more in the ', 'wp-livechat')."<a href='https://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=reporting' target='_BLANK'>".__("Pro add-on", "wplivechat")."</a></p>";
		$content .= 			"<br><a title='Upgrade Now' href='https://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=reporting' style='width: 200px;height: 58px;text-align: center;line-height: 56px;font-size: 18px;' class='button button-primary'  target='_BLANK'>".__("Upgrade Now" ,"wplivechat")."</a>";
	}
	$content .= 		"</td>";
	$content .= 	"</tr>";
	$content .= "</table>";
    $content .= "</div>";
    echo $content;

}
/**
 * Basic version's triggers page - used to upsell the feature
 * @return string
 */
function wplc_basic_triggers_page(){
	$content = "<div class='wrap wplc_wrap'>";
    $content .= "<h2>".__('WP Live Chat Support Triggers', 'wp-livechat')." (beta) </h2>";
    $content .= "<script>
    				var isOn = true;
    				jQuery(function(){
    					jQuery(document).ready(function(){
    						setInterval(function(){
    							if(isOn){
    								jQuery('.trigger_img_main').fadeOut('fast', function(){
    									jQuery('.trigger_img_sec').fadeIn('slow');
    									jQuery('.trigger_img_sec').fadeIn('slow');
    								});
    							} else {
    								jQuery('.trigger_img_sec').fadeOut('fast');
    								jQuery('.trigger_img_sec').fadeOut('fast', function(){
    									jQuery('.trigger_img_main').fadeIn('slow');
    								});
    							}
    							isOn = !isOn;
    						}, 5000);
    					});
    				});
    			</script>";

	$content .= "<table class=\"wp-list-table wplc_list_table widefat fixed form-table\" cellspacing=\"0\" style='width:98%'>";
	$content .= 	"<tr>";
	$content .= 		"<td style='width:35%; vertical-align:top;'>";
	$content .= 			"<img class='trigger_img_main' style='width:99%; height:auto; padding:2px; border:1px lightgray solid;box-shadow: 3px 3px 2px -2px #999;-webkit-box-shadow: 3px 3px 2px -2px #999;-moz-box-shadow: 3px 3px 2px -2px #999;-o-box-shadow: 3px 3px 2px -2px #999;' src='".plugins_url('/images/trigger_sample.jpg', __FILE__)."'>";
	$content .= 			"<img class='trigger_img_sec'style='display: none; width:49%; height:auto; border:1px lightgray solid;box-shadow: 3px 3px 2px -2px #999;-webkit-box-shadow: 3px 3px 2px -2px #999;-moz-box-shadow: 3px 3px 2px -2px #999;-o-box-shadow: 3px 3px 2px -2px #999;' src='".plugins_url('/images/trigger_sample_front.jpg', __FILE__)."'>";
	$content .= 		"</td>";
	$content .= 		"<td style='vertical-align:top;'>";
	$content .= 			"<h3>".__('WP Live Chat Support Triggers', 'wp-livechat')."</h3>";
	$content .= 			"<p>".__('Create custom data triggers when users view a certain page, spend a certain amount of time on a page, scroll past a certain point or when their mouse leaves the window.', 'wp-livechat')."</p>";


	$content .= 			"<br><p><strong>".__('Trigger Types', 'wp-livechat').":</strong></p>";
	$content .= 			"<ul style='list-style: inherit;margin-left: 22px;'>";
	$content .= 				"<li>".__('Page Trigger', 'wp-livechat')."</li>";
	$content .= 				"<li>".__('Time Trigger', 'wp-livechat')."</li>";
	$content .= 				"<li>".__('Scroll Trigger', 'wp-livechat')."</li>";
	$content .= 				"<li>".__('Page Leave Trigger', 'wp-livechat')."</li>";
	$content .= 			"</ul>";

	if (function_exists("wplc_pro_activate")) {
		global $wplc_pro_version;
        if (intval(str_replace(".","",$wplc_pro_version)) < 6200) {
	  		$content .= "<p>In order to use data triggers, please ensure you are using the latest Pro version (version 6.2.00 or newer).</p>";
			$content .=  "<br><a title='Update Now' href='./update-core.php' style='width: 200px;height: 58px;text-align: center;line-height: 56px;font-size: 18px;' class='button button-primary'>".__("Update now" ,"wplivechat")."</a>";
        }
	} else {
		$content .= 			"<p>".__('Get all this and more in the ', 'wp-livechat')."<a href='https://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=data_triggers' target='_BLANK'>".__("Pro add-on", "wplivechat")."</a></p>";
		$content .= 			"<br><a title='Upgrade Now' href='https://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=data_triggers' style='width: 200px;height: 58px;text-align: center;line-height: 56px;font-size: 18px;' class='button button-primary' target='_BLANK'>".__("Upgrade Now" ,"wplivechat")."</a>";
	}
	$content .= 		"</td>";
	$content .= 	"</tr>";
	$content .= "</table>";
    $content .= "</div>";
    echo $content;

}
/**
 * Basic version's custom fields page - used to upsell the feature
 * @return string
 */
function wplc_basic_custom_fields_page(){
	$content = "<div class='wrap wplc_wrap'>";
    $content .= "<h2>".__('WP Live Chat Support Custom Fields', 'wplivechat')."</h2>";
	$content .= "<table class=\"wp-list-table wplc_list_table widefat fixed form-table\" cellspacing=\"0\" style='width:98%'>";
	$content .= 	"<tr>";
	$content .= 		"<td style='width:35%; vertical-align:top;'>";
	$content .= 			"<img class='trigger_img_main' style='width:99%; height:auto; padding:2px; border:1px lightgray solid;box-shadow: 3px 3px 2px -2px #999;-webkit-box-shadow: 3px 3px 2px -2px #999;-moz-box-shadow: 3px 3px 2px -2px #999;-o-box-shadow: 3px 3px 2px -2px #999;' src='".plugins_url('/images/trigger_sample.jpg', __FILE__)."'>";
	$content .= 		"</td>";
	$content .= 		"<td style='vertical-align:top;'>";
	$content .= 			"<h3>".__('WP Live Chat Support Custom Fields', 'wp-livechat')."</h3>";
	$content .= 			"<p>".__('Create custom fields, allowing your visitors to enter the data you need before starting a chat.', 'wp-livechat')."</p>";
	$content .= 			"<br><p><strong>".__('Custom Field Types', 'wp-livechat').":</strong></p>";
	$content .= 			"<ul style='list-style: inherit;margin-left: 22px;'>";
	$content .= 				"<li>".__('Text Fields', 'wp-livechat')."</li>";
	$content .= 				"<li>".__('Dropdown Fields', 'wp-livechat')."</li>";
	$content .= 			"</ul>";

	if (function_exists("wplc_pro_activate")) {
		global $wplc_pro_version;
        if (intval(str_replace(".","",$wplc_pro_version)) < 7000) {
	  		$content .= "<p>In order to use custom fields, please ensure you are using the latest Pro version (version 7.0.0 or newer).</p>";
			$content .=  "<br><a title='Update Now' href='./update-core.php' style='width: 200px;height: 58px;text-align: center;line-height: 56px;font-size: 18px;' class='button button-primary'>".__("Update now" ,"wplivechat")."</a>";
        }
	} else {
		$content .= 			"<p>".__('Get all this and more in the ', 'wp-livechat')."<a href='https://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=custom_fields' target='_BLANK'>".__("Pro add-on", "wplivechat")."</a></p>";
		$content .= 			"<br><a title='Upgrade Now' href='https://www.wp-livechat.com/purchase-pro/?utm_source=plugin&utm_medium=link&utm_campaign=custom_fields' style='width: 200px;height: 58px;text-align: center;line-height: 56px;font-size: 18px;' class='button button-primary' target='_BLANK'>".__("Upgrade Now" ,"wplivechat")."</a>";
	}
	$content .= 		"</td>";
	$content .= 	"</tr>";
	$content .= "</table>";
    $content .= "</div>";
    echo $content;
}

add_action('wplc_hook_admin_settings_main_settings_after','wplc_powered_by_link_settings_page',2);
/**
 * Adds the necessary checkbox to enable/disable the 'Powered by' link
 * @return string
 */
function wplc_powered_by_link_settings_page() {
    $wplc_powered_by = get_option("WPLC_POWERED_BY");
  ?>
    <table class='form-table wp-list-table wplc_list_table widefat fixed striped pages' width='700'>
        <tr>
            <td width='350' valign='top'>
                <?php _e("Display a 'Powered by' link in the chat box", "wplivechat") ?>: <i class="fa fa-question-circle wplc_light_grey wplc_settings_tooltip" title="<?php _e("Checking this will display a 'Powered by WP Live Chat Support' caption at the bottom of your chatbox.", 'wplivechat'); ?>"></i>
            </td>
            <td>
                <input type="checkbox" value="1" name="wplc_powered_by" <?php if ( $wplc_powered_by && $wplc_powered_by == 1 ) { echo "checked"; } ?> />
            </td>
        </tr>
    </table>
    <hr>
  <?php
}

add_action( "wplc_hook_head", "wplc_powered_by_link_save_settings" );
/**
 * Saves the 'Powered by' link settings
 * @return void
 */
function wplc_powered_by_link_save_settings(){

	if( isset( $_POST['wplc_save_settings'] ) ){

			if( isset( $_POST['wplc_powered_by'] ) && $_POST['wplc_powered_by'] == '1' ){
				update_option( "WPLC_POWERED_BY", 1 );
			} else {
				update_option( "WPLC_POWERED_BY", 0 );
			}

	}

}

add_filter( "wplc_start_chat_user_form_after_filter", "wplc_powered_by_link_in_chat", 12, 2 );
/**
 * Appends the 'Powered by' link to the chat window
 * @param  string 	$string the current contents of the chat box
 * @param  int 		$cid    the current chat ID
 * @return string         	the chat contents, with the 'Powered by' link appended to it
 */
function wplc_powered_by_link_in_chat( $string ){

	$show_powered_by = get_option( "WPLC_POWERED_BY" );

	if( $show_powered_by == 1){
		$ret = "<i style='text-align: center; display: block; padding: 5px 0; font-size: 10px;'><a href='https://wp-livechat.com/?utm_source=poweredby&utm_medium=click&utm_campaign=".esc_html(site_url())."'' target='_BLANK' rel='nofollow'>".__("Powered by WP Live Chat Support", "wplivechat")."</a></i>";

	} else {

		$ret = "";

	}

	return $string . $ret;

}

add_action( "admin_enqueue_scripts", "wplc_custom_scripts_scripts" );
/**
 * Loads the Ace.js editor for the custom scripts
 * @return void
 */
function wplc_custom_scripts_scripts(){

	if( isset( $_GET['page'] ) && $_GET['page'] == 'wplivechat-menu-settings' ){

		wp_enqueue_script( "wplc-custom-script-tab-ace",'//cdnjs.cloudflare.com/ajax/libs/ace/1.2.9/ace.js', array('jquery') );

	}

}

add_filter( "wplc_filter_setting_tabs", "wplc_custom_scripts_tab" );
/**
 * Adds a tab for the custom scripts
 * @param  array $array current array that is made available to us
 * @return array        our tabs array has been added to the array
 */
function wplc_custom_scripts_tab( $array ){

	$array['custom-scripts'] = array(
		'href' 	=> '#wplc-custom-scripts',
		'icon' 	=> 'fa fa-pencil',
		'label' => __("Custom Scripts", "wplivechat")
	);

	return $array;
}

add_action( "wplc_hook_settings_page_more_tabs", "wplc_custom_scripts_content" );
/**
 * Adds the tab content to the settings page to allow the user to add custom CSS & JS
 * @return string
 */
function wplc_custom_scripts_content(){

	$wplc_custom_css = get_option( "WPLC_CUSTOM_CSS" );
	$wplc_custom_js = get_option( "WPLC_CUSTOM_JS" );

	$content = "";

	$content .= "<div id='wplc-custom-scripts'>";

	$content .= "<h2>".__("Custom Scripts", "wplivechat")."</h2>";
	$content .= "<table class='form-table'>";

	$content .= "<tr>";
	$content .= "<td width='300'>".__("Custom CSS", "wplivechat")."</td>";
	$content .= "<td><div id='wplc_custom_css_editor'></div><textarea name='wplc_custom_css' id='wplc_custom_css' style='display: none;' data-editor='css' rows='12'>".strip_tags( stripslashes( $wplc_custom_css ) )."</textarea></td>";
	$content .= "</tr>";

	$content .= "<tr>";
	$content .= "<td width='300'>".__("Custom JS", "wplivechat")."</td>";
	$content .= "<td valign='middle'><div id='wplc_custom_js_editor'></div><textarea name='wplc_custom_js' id='wplc_custom_js' style='display: none;' data-editor='javascript' rows='12'>".strip_tags( stripslashes( $wplc_custom_js ) )."</textarea></td>";
	$content .= "</tr>";

	$content .= "</table>";

	$content .= "</div>";

	echo $content;

}

add_action( "wplc_hook_head", "wplc_custom_scripts_save" );
/**
 * Saves the custom scripts into the options table
 * @return void
 */
function wplc_custom_scripts_save(){

	if( isset( $_POST['wplc_save_settings'] ) ){

		if( isset( $_POST['wplc_custom_css'] ) ){
			update_option( "WPLC_CUSTOM_CSS", nl2br( $_POST['wplc_custom_css'] ) );
		}

		if( isset( $_POST['wplc_custom_js'] ) ){
			update_option( "WPLC_CUSTOM_JS", nl2br( $_POST['wplc_custom_js'] ) );
		}

	}

}

add_action( "wp_head", "wplc_custom_scripts_frontend" );
/**
 * Display the custom scripts on the front end of the site
 * @return string
 */
function wplc_custom_scripts_frontend(){

	$wplc_custom_css = get_option( "WPLC_CUSTOM_CSS" );
	$wplc_custom_js = get_option( "WPLC_CUSTOM_JS" );

	if( $wplc_custom_css ){
		echo "<!-- WPLC Custom CSS -->";
		echo "<style>";
		echo strip_tags( stripslashes( $wplc_custom_css ) );
		echo "</style>";
	}

	if( $wplc_custom_js ){
		echo "<!-- WPLC Custom JS -->";
		echo "<script>";
		echo strip_tags( stripslashes( $wplc_custom_js ) );
		echo "</script>";
	}

}

add_filter( "wplc_offline_message_subject_filter", "wplc_change_offline_message", 10, 1 );
/**
 * Adds a filter to change the email address to the user's preference
 * @param  string $subject The default subject
 * @return string
 */
function wplc_change_offline_message( $subject ){

	$wplc_settings = get_option( "WPLC_SETTINGS");

	if( isset( $wplc_settings['wplc_pro_chat_email_offline_subject'] ) ){
		$subject = stripslashes( $wplc_settings['wplc_pro_chat_email_offline_subject'] );
	}

	return $subject;

}

function wplc_basic_version_departments(){
	echo "<div class='wrap wplc_wrap'>";
	echo sprintf( "<div class='error'><p>".__("WP Live Chat Support requires WP Live Chat Support Pro Version 7.0.0 or greater in order for departments to function as expected. Please update WP Live Chat Support %s", "wplivechat")."</p></div>", "<a href='".admin_url('update-core.php')."'>".__("here", "wplivechat")."</a>" );
	echo "</div>";

	$content = "";

	$content .= "<table class=\"wp-list-table wplc_list_table widefat fixed \" cellspacing=\"0\" style='width:98%'>";
	$content .= 	"<thead>";
  	$content .= 		"<tr>";
    $content .= 			"<th scope='col'><span>" . __("ID", "wplivechat") . "</span></th>";
    $content .= 			"<th scope='col'><span>" . __("Name", "wplivechat") . "</span></th>";
    $content .= 			"<th scope='col'><span>" . __("Action", "wplivechat") . "</span></th>";
    $content .= 		"</tr>";
  	$content .= 	"</thead>";

	$content .= "<tr><td>".__("Please update your Pro version to create a department", "wp-livechat")."</td><td></td><td></td></tr>";

  	$content .= 	"</table>";

  	echo $content;
}

add_filter( 'wplc_filter_active_chat_box_notification', 'wplc_active_chat_box_notice' );

if ( ! function_exists( "wplc_active_chat_box_notices" ) ) {
	add_action( "wplc_hook_chat_dashboard_above", "wplc_active_chat_box_notices" );
	function wplc_active_chat_box_notices() {
		$wplc_settings   = get_option( "WPLC_SETTINGS" );
		if ( $wplc_settings["wplc_settings_enabled"] == 2 ) { ?>
            <div class="wplc-chat-box-notification wplc-chat-box-notification--disabled">
                <p><?php echo sprintf( __( 'The Live Chat box is currently disabled on your website due to : <a href="%s">General Settings</a>', 'wp-livechat' ), admin_url( 'admin.php?page=wplivechat-menu-settings#tabs-1' ) ) ?></p>
            </div>
			<?php
		} else {
			//$notice = '<div class="wplc-chat-box-notification">';
			//$notice .= '<p>' . __( 'The Live Chat box is currently active', 'wp-livechat' ) . '</p>';
			//$notice .= '</div>';
			$notice = '';
			$notice = apply_filters( 'wplc_filter_active_chat_box_notice', $notice );
			echo $notice;
		}

	}
}


add_filter("wplc_filter_chat_4th_layer_below_input","nifty_chat_ratings_div_backwards_compat",2,2);
/**
 * This adds backwards compatibility to the new look and feel of the modern chat box
 *
 * The ' | ' is removed from the rating icons to fit the new look and feel
 *
 */
function nifty_chat_ratings_div_backwards_compat($msg, $wplc_setting){
	$msg = str_replace(" | ","", $msg);
    return $msg;

}

/**
 * Identifies if the chat box should show, scripts should run and the dashboard should display correctly all based on certain versions.
 *
 * i.e. This is the part where we force users to upgrade their extensions to make sure everything works correctly.
 *
 * Use with caution and always try add backwards compatibility where necessary
 *
 * @param  bool $continue
 * @return bool
 * @since  7.1.00
 * @author Nick Duncan
 */
add_filter( "wplc_version_check_continue", "wplc_filter_control_version_check_continue", 10, 1 );
function wplc_filter_control_version_check_continue( $continue ) {

	/**
	 * Check to see that we are on the cloud server 1.3.00 or newer
	 */
	if ( function_exists("wplc_cloud_load_updates") ) {
		global $wplc_cloud_version;
		$float_version = intval( str_replace(".", "", $wplc_cloud_version ) );
        if ($float_version < 2000) {
        	return sprintf( "Your chat has been disabled due to a version conflict. Please <a href='%s'>update your cloud extension</a> to 1.3.00 or higher.", admin_url('update-core.php') )."<br />";

        }
	}

	return $continue;

}

/*
 * Returns the WDT emoji selector
*/
function wplc_emoji_selector_div(){
	$wplc_settings = get_option("WPLC_SETTINGS");

	// NB: This causes Failed to initVars ReferenceError: wplc_show_date is not defined when uncommented and enabled
	if(!empty($wplc_settings['wplc_disable_emojis']))
		return;

	$emoji_container = "";
    if(isset($wplc_settings['wplc_use_node_server']) && $wplc_settings['wplc_use_node_server'] == 1){
	   $emoji_container = '<div class="wdt-emoji-popup">
	                        <a href="#" class="wdt-emoji-popup-mobile-closer"> &times; </a>
	                        <div class="wdt-emoji-menu-content">
	                          <div id="wdt-emoji-menu-header">
	                            <a class="wdt-emoji-tab" data-group-name="People"></a>
	                            <a class="wdt-emoji-tab" data-group-name="Nature"></a>
	                            <a class="wdt-emoji-tab" data-group-name="Foods"></a>
	                            <a class="wdt-emoji-tab" data-group-name="Activity"></a>
	                            <a class="wdt-emoji-tab" data-group-name="Places"></a>
	                            <a class="wdt-emoji-tab" data-group-name="Objects"></a>
	                            <a class="wdt-emoji-tab" data-group-name="Symbols"></a>
	                            <a class="wdt-emoji-tab" data-group-name="Flags"></a>
	                          </div>
	                          <div class="wdt-emoji-scroll-wrapper">
	                            <div id="wdt-emoji-menu-items">
	                              <input id="wdt-emoji-search" type="text" placeholder="Search">
	                              <h3 id="wdt-emoji-search-result-title">Search Results</h3>
	                              <div class="wdt-emoji-sections"></div>
	                              <div id="wdt-emoji-no-result">No emoji found</div>
	                            </div>
	                          </div>
	                          <div id="wdt-emoji-footer">
	                            <div id="wdt-emoji-preview">
	                              <span id="wdt-emoji-preview-img"></span>
	                              <div id="wdt-emoji-preview-text">
	                                <span id="wdt-emoji-preview-name"></span><br>
	                                <span id="wdt-emoji-preview-aliases"></span>
	                              </div>
	                            </div>
	                            <div id="wdt-emoji-preview-bundle">
	                              <span></span>
	                            </div>
	                            <span class="wdt-credit">WDT Emoji Bundle</span>
	                          </div>
	                        </div>
	                      </div>';
	}

    return $emoji_container;

}

add_action("wplc_hook_chat_missed","wplc_missed_chats_deprecation_notice",5);
/**
 * Displays a notice to the user that Missed Chats is being deprecated
 */
function wplc_missed_chats_deprecation_notice() {
      $output = "<div class='update-nag' style='margin-top: 0px;margin-bottom: 5px;'>";
    $output .=     "<strong>" . __("Deprecation Notice", "wplivechat") . "</strong><br>";
    $output .=     "<p>" . __("Please note, missed chat functionality is being deprecated as we will be moving to a customer oriented system in the near future. ", "wplivechat") . "</p>";
    $output .=     "<p>" . __("The new system will offer more insight into your user base while enhancing your experience when retrieving statistics and information. ", "wplivechat") . "</p>";
    $output .=     "<p>" . __("This area will remain active for the time being, however it is recommended that you prepare for this change in the near future. ", "wplivechat") . "</p>";
    $output .= "</div>";

    echo $output;
}

add_action( 'admin_notices', 'wplc_browser_notifications_admin_warning' );
/**
 * Displays browser notifications warning.
 *
 * Only displays if site is insecure (no SSL).
 */
function wplc_browser_notifications_admin_warning() {

    if ( ! is_ssl() && isset( $_GET['page'] ) && strpos( $_GET['page'], 'wplivechat' ) !== false ) {

        if ( isset( $_GET['wplc_dismiss_notice_bn'] ) && 'true' === $_GET['wplc_dismiss_notice_bn'] ) {

            update_option( 'wplc_dismiss_notice_bn', 'true' );

        }

        if ( get_option( 'wplc_dismiss_notice_bn') !== 'true' ) {

            ?>
            <div class="notice notice-warning is-dismissible">
                <p><img src="<?php echo esc_attr( plugins_url( 'images/wplc-logo.png', __FILE__ ) ); ?>" style="width:260px;height:auto;max-width:100%;"></p>
                <p><strong><?php esc_html_e( 'Browser notifications will no longer function on insecure (non-SSL) sites.', 'wplivechat' ); ?></strong></p>
                <p><?php esc_html_e( 'Please add an SSL certificate to your site to continue receiving chat notifications in your browser.', 'wplivechat' ); ?></p>
                <p><a href="?page=<?php echo esc_attr( $_GET['page'] ); ?>&wplc_dismiss_notice_bn=true" id="wplc_dismiss_notice_bn" class="button"><?php esc_html_e( "Don't Show This Again", 'wplivechat' ); ?></a></p>
            </div>
            <?php

        }
    }
}

if ( function_exists( 'wplc_et_first_run_check' ) ) {
	add_action( 'admin_notices', 'wplc_transcript_admin_notice' );
}
function wplc_transcript_admin_notice() {
	printf( '<div class="notice notice-info">%1$s</div>', __( 'Please deactivate WP Live Chat Suport - Email Transcript plugin. Since WP Live Chat Support 8.0.05 there is build in support for Email Transcript.', 'wplivechat' ) );
}

add_action( 'init', 'wplc_transcript_first_run_check' );
function wplc_transcript_first_run_check() {
	if ( ! get_option( "WPLC_ET_FIRST_RUN" ) ) {
		/* set the default settings */
		$wplc_et_data['wplc_enable_transcripts']  = 1;
		$wplc_et_data['wplc_send_transcripts_to'] = 'user';
		$wplc_et_data['wplc_send_transcripts_when_chat_ends']  = 0;
		$wplc_et_data['wplc_et_email_body']       = wplc_transcript_return_default_email_body();
		$wplc_et_data['wplc_et_email_header']     = '<a title="' . get_bloginfo( 'name' ) . '" href="' . get_bloginfo( 'url' ) . '" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #FFF; font-weight: bold; text-decoration: underline;">' . get_bloginfo( 'name' ) . '</a>';

		$default_footer_text = sprintf( __( 'Thank you for chatting with us. If you have any questions, please <a href="%1$s" target="_blank" style="font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #FFF; font-weight: bold; text-decoration: underline;">contact us</a>', 'wplivechat' ),
			'mailto:' . get_bloginfo( 'admin_email' )
		);

		$wplc_et_data['wplc_et_email_footer'] = "<span style='font-family: Arial, Helvetica, sans-serif; font-size: 13px; color: #FFF; font-weight: normal;'>" . $default_footer_text . "</span>";


		update_option( 'WPLC_ET_SETTINGS', $wplc_et_data );
		update_option( "WPLC_ET_FIRST_RUN", true );
	}
}

add_action( 'wplc_hook_admin_visitor_info_display_after', 'wplc_transcript_add_admin_button' );
function wplc_transcript_add_admin_button( $cid ) {
	$wplc_et_settings        = get_option( "WPLC_ET_SETTINGS" );
	$wplc_enable_transcripts = $wplc_et_settings['wplc_enable_transcripts'];
	if ( isset( $wplc_enable_transcripts ) && $wplc_enable_transcripts == 1 ) {
		echo "<p><a href=\"javascript:void(0);\" cid='" . sanitize_text_field( $cid ) . "' class=\"wplc_admin_email_transcript button button-secondary\" id=\"wplc_admin_email_transcript\">" . __( "Email transcript to user", "wplivechat" ) . "</a></p>";
	}
}

add_action( 'wplc_hook_admin_javascript_chat', 'wplc_transcript_admin_javascript' );
function wplc_transcript_admin_javascript() {
	$wplc_et_ajax_nonce = wp_create_nonce( "wplc_et_nonce" );
	wp_register_script( 'wplc_transcript_admin', plugins_url( '/js/wplc_transcript.js', __FILE__ ), null, '', true );
	$wplc_transcript_localizations = array(
		'ajax_nonce'          => $wplc_et_ajax_nonce,
		'string_loading'      => __( "Sending transcript...", "wplivechat" ),
		'string_title'        => __( "Sending Transcript", "wplivechat" ),
		'string_close'        => __( "Close", "wplivechat" ),
		'string_chat_emailed' => __( "The chat transcript has been emailed.", "wplivechat" ),
		'string_error1'       => sprintf( __( "There was a problem emailing the chat. Please <a target='_BLANK' href='%s'>contact support</a>.", "wplivechat" ), "http://wp-livechat.com/contact-us/?utm_source=plugin&utm_medium=link&utm_campaign=error_emailing_chat" )
	);
	wp_localize_script( 'wplc_transcript_admin', 'wplc_transcript_nonce', $wplc_transcript_localizations );
	wp_enqueue_script( 'wplc_transcript_admin' );
}

add_action( 'wp_ajax_wplc_et_admin_email_transcript', 'wplc_transcript_callback' );
function wplc_transcript_callback() {
	$check = check_ajax_referer( 'wplc_et_nonce', 'security' );
	if ( $check == 1 ) {

		if ( isset( $_POST['el'] ) && $_POST['el'] === 'endChat' ) {
			$wplc_et_settings = get_option( "WPLC_ET_SETTINGS" );
			$transcript_chat_ends = $wplc_et_settings['wplc_send_transcripts_when_chat_ends'];
			if ( $transcript_chat_ends === 0 ) {
				wp_die();
			}
		}

		if ( $_POST['action'] == "wplc_et_admin_email_transcript" ) {
			if ( isset( $_POST['cid'] ) ) {
				$cid = wplc_return_chat_id_by_rel( $_POST['cid'] );
				echo json_encode( wplc_send_transcript( sanitize_text_field( $cid ) ) );
			} else {
				echo json_encode( array( "error" => "no CID" ) );
			}
			wp_die();
		}

		wp_die();
	}
	wp_die();
}

function wplc_send_transcript( $cid ) {
	if ( ! $cid ) {
		return array( "error" => "no CID", "cid" => $cid );
	}
	
	if( ! filter_var($cid, FILTER_VALIDATE_INT) ) {
        /*  We need to identify if this CID is a node CID, and if so, return the WP CID */
        $cid = wplc_return_chat_id_by_rel($cid);
    }

	$email = false;
	$wplc_et_settings = get_option( "WPLC_ET_SETTINGS" );

	$wplc_enable_transcripts = $wplc_et_settings['wplc_enable_transcripts'];
	if ( isset( $wplc_enable_transcripts ) && $wplc_enable_transcripts == 1 ) {

		if ( function_exists( "wplc_get_chat_data" ) ) {
			$cdata = wplc_get_chat_data( $cid );
			if ( $cdata ) {
				if ( $wplc_et_settings['wplc_send_transcripts_to'] === 'admin' ) {
				    $user = wp_get_current_user();
					$email = $user->user_email;
			    } else {
					$email = $cdata->email;
				}
				if ( ! $email ) {
					return array( "error" => "no email" );
				}
			} else {
				return array( "error" => "no chat data" );
			}
		} else {
			return array( "error" => "basic funtion missing" );
		}

		$headers = array( 'Content-Type: text/html; charset=UTF-8' );
		$subject = sprintf( __( 'Your chat transcript from %1$s', 'wplivechat' ),
			get_bloginfo( 'url' )
		);
		wp_mail( $email, $subject, wplc_transcript_return_chat_messages( $cid ), $headers );

	}

	return array( "success" => 1 );

}
add_action('wplc_send_transcript_hook', 'wplc_send_transcript', 10, 1);

function wplc_transcript_return_chat_messages( $cid ) {
	global $current_chat_id;
	$current_chat_id  = $cid;
	$wplc_et_settings = get_option( "WPLC_ET_SETTINGS" );
	$body             = html_entity_decode( stripslashes( $wplc_et_settings['wplc_et_email_body'] ) );

	if ( ! $body ) {
		$body = do_shortcode( wplc_transcript_return_default_email_body() );
	} else {
		$body = do_shortcode( $body );
	}

	return $body;
}

function wplc_transcript_return_default_email_body() {
	$body = '
<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01 Transitional//EN\" \"http://www.w3.org/TR/html4/loose.dtd\">		
	<html>
	
	<body>



		<table id="" border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #ec822c;">
	    <tbody>
	      <tr>
	        <td width="100%" style="padding: 30px 20px 100px 20px;">
	          <table align="center" cellpadding="0" cellspacing="0" class="" width="100%" style="border-collapse: separate; max-width:600px;">
	            <tbody>
	              <tr>
	                <td style="text-align: center; padding-bottom: 20px;">
	                  
	                  <p>[wplc_et_transcript_header_text]</p>
	                </td>
	              </tr>
	            </tbody>
	          </table>

	          <table id="" align="center" cellpadding="0" cellspacing="0" class="" width="100%" style="border-collapse: separate; max-width: 600px; font-family: Georgia, serif; font-size: 12px; color: rgb(51, 62, 72); border: 0px solid rgb(255, 255, 255); border-radius: 10px; background-color: rgb(255, 255, 255);">
	          <tbody>
	              <tr>
	                <td class="sortable-list ui-sortable" style="padding:20px;">
	                    [wplc_et_transcript]
	                </td>
	              </tr>
	            </tbody>
	          </table>

	          <table align="center" cellpadding="0" cellspacing="0" class="" width="100%" style="border-collapse: separate; max-width:100%;">
	            <tbody>
	              <tr>
	                <td style="padding:20px;">
	                  <table border="0" cellpadding="0" cellspacing="0" class="" width="100%">
	                    <tbody>
	                      <tr>
	                        <td id="" align="center">
	                         <p>[wplc_et_transcript_footer_text]</p>
	                        </td>
	                      </tr>
	                    </tbody>
	                  </table>
	                </td>
	              </tr>
	            </tbody>
	          </table>
	        </td>
	      </tr>
	    </tbody>
	  </table>


		
		</div>
	</body>
</html>
			';

	return $body;
}

add_action( 'wplc_hook_admin_settings_save', 'wplc_transcript_save_settings' );
function wplc_transcript_save_settings() {
	if ( isset( $_POST['wplc_save_settings'] ) ) {
		if ( isset( $_POST['wplc_enable_transcripts'] ) ) {
			$wplc_et_data['wplc_enable_transcripts'] = esc_attr( $_POST['wplc_enable_transcripts'] );
		} else {
			$wplc_et_data['wplc_enable_transcripts'] = 0;
		}
		if ( isset( $_POST['wplc_send_transcripts_to'] ) ) {
			$wplc_et_data['wplc_send_transcripts_to'] = esc_attr( $_POST['wplc_send_transcripts_to'] );
		} else {
			$wplc_et_data['wplc_send_transcripts_to'] = 'user';
		}
		if ( isset( $_POST['wplc_send_transcripts_when_chat_ends'] ) ) {
			$wplc_et_data['wplc_send_transcripts_when_chat_ends'] = esc_attr( $_POST['wplc_send_transcripts_when_chat_ends'] );
		} else {
			$wplc_et_data['wplc_send_transcripts_when_chat_ends'] = 0;
		}
		if ( isset( $_POST['wplc_et_email_header'] ) ) {
			$wplc_et_data['wplc_et_email_header'] = esc_attr( $_POST['wplc_et_email_header'] );
		}
		if ( isset( $_POST['wplc_et_email_footer'] ) ) {
			$wplc_et_data['wplc_et_email_footer'] = esc_attr( $_POST['wplc_et_email_footer'] );
		}
		if ( isset( $_POST['wplc_et_email_body'] ) ) {
			$wplc_et_data['wplc_et_email_body'] = esc_html( $_POST['wplc_et_email_body'] );
		}
		update_option( 'WPLC_ET_SETTINGS', $wplc_et_data );

	}
}

add_action( 'wplc_hook_admin_settings_main_settings_after', 'wplc_hook_admin_transcript_settings' );
function wplc_hook_admin_transcript_settings() {
	$wplc_et_settings = get_option( "WPLC_ET_SETTINGS" );
	echo "<hr />";
	echo "<h3>" . __( "Chat Transcript Settings", 'wplivechat' ) . "</h3>";
	echo "<table class='form-table wp-list-table widefat fixed striped pages' width='700'>";
	echo "	<tr>";
	echo "		<td width='400' valign='top'>" . __( "Enable chat transcripts:", "wplivechat" ) . "</td>";
	echo "		<td>";
	echo "			<input type=\"checkbox\" value=\"1\" name=\"wplc_enable_transcripts\" ";
	if ( isset( $wplc_et_settings['wplc_enable_transcripts'] ) && $wplc_et_settings['wplc_enable_transcripts'] == 1 ) {
		echo "checked";
	}
	echo " />";
	echo "		</td>";
	echo "	</tr>";

	echo "	<tr>";
	echo "		<td width='400' valign='top'>" . __( "Send transcripts to:", "wplivechat" ) . "</td>";
	echo "		<td>";
	echo "			<select name=\"wplc_send_transcripts_to\">";
	echo "			    <option value=\"user\" ";
	if ( isset( $wplc_et_settings['wplc_send_transcripts_to'] ) && $wplc_et_settings['wplc_send_transcripts_to'] == 'user' ) {
	    echo "selected";
    }
    echo ">" . __( "User", "wplivechat" ) . "</option>";
	echo "			    <option value=\"admin\" ";
	if ( isset( $wplc_et_settings['wplc_send_transcripts_to'] ) && $wplc_et_settings['wplc_send_transcripts_to'] == 'admin' ) {
		echo "selected";
	}
	echo ">" . __( "Admin", "wplivechat" ) . "</option>";
	echo "          </select>";
	echo "		</td>";
	echo "	</tr>";

	echo "	<tr>";
	echo "		<td width='400' valign='top'>" . __( "Send transcripts when chat ends:", "wplivechat" ) . "</td>";
	echo "		<td>";
	echo "			<input type=\"checkbox\" value=\"1\" name=\"wplc_send_transcripts_when_chat_ends\" ";
	if ( isset( $wplc_et_settings['wplc_send_transcripts_when_chat_ends'] ) && $wplc_et_settings['wplc_send_transcripts_when_chat_ends'] == 1 ) {
		echo "checked";
	}
	echo " />";
	echo "		</td>";
	echo "	</tr>";

	echo "	<tr>";
	echo "		<td width='400' valign='top'>" . __( "Email body", "wplivechat" ) . "</td>";
	echo "		<td>";
	echo "			<textarea cols='85' rows='15' name=\"wplc_et_email_body\">";
	if ( isset( $wplc_et_settings['wplc_et_email_body'] ) ) {
		echo html_entity_decode( stripslashes( $wplc_et_settings['wplc_et_email_body'] ) );
	}
	echo " </textarea>";
	echo "		</td>";
	echo "	</tr>";


	echo "	<tr>";
	echo "		<td width='400' valign='top'>" . __( "Email header", "wplivechat" ) . "</td>";
	echo "		<td>";
	echo "			<textarea cols='85' rows='5' name=\"wplc_et_email_header\">";
	if ( isset( $wplc_et_settings['wplc_et_email_header'] ) ) {
		echo stripslashes( $wplc_et_settings['wplc_et_email_header'] );
	}
	echo " </textarea>";
	echo "		</td>";
	echo "	</tr>";

	echo "	<tr>";
	echo "		<td width='400' valign='top'>" . __( "Email footer", "wplivechat" ) . "</td>";
	echo "		<td>";
	echo "			<textarea cols='85' rows='5' name=\"wplc_et_email_footer\">";
	if ( isset( $wplc_et_settings['wplc_et_email_footer'] ) ) {
		echo stripslashes( $wplc_et_settings['wplc_et_email_footer'] );
	}
	echo " </textarea>";
	echo "		</td>";
	echo "	</tr>";


	echo "</table>";
}

add_shortcode('wplc_et_transcript', 'wplc_transcript_get_transcript');
function wplc_transcript_get_transcript() {
	global $current_chat_id;
	$cid = $current_chat_id;

	if ( intval( $cid ) > 0 ) {
		return wplc_return_chat_messages( intval( $cid ), true );
	} else {
		return "0";
	}
}

add_shortcode( 'wplc_et_transcript_footer_text', 'wplc_transcript_get_footer_text' );
function wplc_transcript_get_footer_text() {
	$wplc_et_settings = get_option( "WPLC_ET_SETTINGS" );
	$wplc_et_footer   = html_entity_decode( stripslashes( $wplc_et_settings['wplc_et_email_footer'] ) );
	if ( $wplc_et_footer ) {
		return $wplc_et_footer;
	} else {
		return "";
	}
}

add_shortcode( 'wplc_et_transcript_header_text', 'wplc_transcript_get_header_text' );
function wplc_transcript_get_header_text() {
	$wplc_et_settings = get_option( "WPLC_ET_SETTINGS" );

	global $current_chat_id;
	$cid = $current_chat_id;

	$from_email = "Unknown@unknown.com";
	$from_name = "User";
	if ( intval( $cid ) > 0 ) {
		$chat_data = wplc_get_chat_data( $cid );
		if ( isset( $chat_data->email ) ) {
			$from_email = $chat_data->email;
		}
		if ( isset( $chat_data->name ) ) {
			$from_name = $chat_data->name;
		}
	}

	$wplc_et_header   = "<h3>".$from_name." (".$from_email.")"."</h3>".html_entity_decode( stripslashes( $wplc_et_settings['wplc_et_email_header'] ) );
	if ( $wplc_et_header ) {
		return $wplc_et_header;
	} else {
		return "";
	}
}
