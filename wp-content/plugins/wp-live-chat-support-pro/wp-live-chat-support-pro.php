<?php
/*
Plugin Name: WP Live Chat Support Pro
Plugin URI: http://www.wp-livechat.com
Description: The Pro version of the easiest to use website live chat plugin. Let your visitors chat with you and increase sales conversion rates with WP Live Chat. No third party connection required!
Version: 2.1
Author: WP Live Chat
Author URI: http://www.wp-livechat.com
*/


/*
 * 2.1
 * More precise functionality to handle if you are online or offline
 * Fixed a bug that recorded visitors when offline
 * Neatened up some code
 * Fixed some small bugs
 * 
 * 2.0
 * Added "not available" functionality. Allows the visitor to leave a message when the admin is offline.
 * You can now get notified via email if someone is trying to start a chat with you.
 * Better front-end UI.
 *
 *
 * Coming soon to v2.1
 * Standard relpies (built in responses plus the ability for you to add your own)
 * Integrate with Google Analytics for event tracking
 * 
 */


error_reporting(E_ERROR);
global $wplc_pro_version;
$wplc_pro_version = "2.1";

add_action('wp_ajax_wplc_update_admin_visitor', 'wplc_action_pro_callback');


add_action('wp_ajax_wplc_user_await_admin_request', 'wplc_action_pro_callback');
add_action('wp_ajax_nopriv_wplc_user_await_admin_request', 'wplc_action_pro_callback');
add_action('wp_ajax_wplc_user_notify_admin_window_open', 'wplc_action_pro_callback');
add_action('wp_ajax_nopriv_wplc_user_notify_admin_window_open', 'wplc_action_pro_callback');
add_action('wp_ajax_wpcl_admin_auto_check_for_user_window_opened', 'wplc_action_pro_callback');
add_action('wp_ajax_nopriv_wpcl_admin_auto_check_for_user_window_opened', 'wplc_action_pro_callbackdraw');
add_action('wp_ajax_wplc_user_send_offline_message', 'wplc_action_pro_callback');
add_action('wp_ajax_nopriv_wplc_user_send_offline_message', 'wplc_action_pro_callback');

add_action('wp_head','wplc_pro_user_top_js');



register_activation_hook( __FILE__, 'wplc_pro_activate' );
add_action('init', 'wplc_register_pro_version');

function wplc_register_pro_version() {
// pro version register
    
}


function wplc_action_pro_callback() {
        global $wpdb;
        global $wplc_tblname_chats;
        $check = check_ajax_referer( 'wplc', 'security' );

        if ($check == 1) {
           
            if ($_POST['action'] == "wplc_update_admin_visitor") {
                wplc_list_visitors();
            }
            
            if ($_POST['action'] == "wplc_user_await_admin_request") {
                echo wplc_return_chat_status($_POST['cid']);
            }
            if ($_POST['action'] == "wplc_user_notify_admin_window_open") {
                echo wplc_change_chat_status($_POST['cid'],3);
            }
            if ($_POST['action'] == "wpcl_admin_auto_check_for_user_window_opened") {
                echo wplc_return_chat_status($_POST['cid']);
            }
            if ($_POST['action'] == "wplc_user_send_offline_message") {
                wplc_send_offline_message($_POST['name'],$_POST['email'],$_POST['msg'],$_POST['cid']);
            }
        }
        
	die(); // this is required to return a proper result

}


function wplc_pro_activate() {
    if (!get_option("WPLC_PRO_SETTINGS")) {
        $wplc_current_user = wp_get_current_user();
        $wplc_pic = "http://www.gravatar.com/avatar/".md5($wplc_current_user->user_email);
        add_option('WPLC_PRO_SETTINGS',array(
            "wplc_chat_name" => "Admin", 
            "wplc_chat_pic" => $wplc_pic, 
            "wplc_chat_logo" => "", 
            "wplc_chat_delay" => "10", 
            "wplc_pro_fst1" => "Questions?", 
            "wplc_pro_fst2" => "Chat with us", 
            "wplc_pro_fst3" => "Start live chat",
            "wplc_pro_sst1" => "Start Chat",
            "wplc_pro_sst2" => "Connecting. Please be patient...",
            "wplc_pro_tst1" => "Reactivating your previous chat...",
            "wplc_pro_na" => "Chat offline. Leave a message",
            "wplc_pro_intro" => "Hello. Please input your details so that I may help you.",
            "wplc_pro_offline1" => "We are currently offline. Please leave a message and we'll get back to you shortly.",
            "wplc_pro_offline2" => "Sending message...",
            "wplc_pro_offline3" => "Thank you for your message. We will be in contact soon.",
            "wplc_user_enter" => "Press ENTER to send your message",
            "wplc_user_welcome_chat" => "Welcome. How may I help you?",
            "wplc_pro_chat_notification" => "no"
            
            ));
        echo "done";
    }
    //delete_option('WPLC_PRO_SETTINGS');
    
}
function wplc_send_offline_message($name,$email,$msg,$cid) {
    $subject = "WP Live Chat Support - Offline Message from $name";
    $msg = "Name: $name \nEmail: $email\nMessage: $msg\n\nVia WP Live Chat Support";
    wp_mail(get_settings('admin_email'), $subject, $msg);
    
}
function wplc_return_from_name() {
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
    return $wplc_pro_settings['wplc_chat_name'];
}

function wplc_settings_page_pro($area) {
    
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
    if ($wplc_pro_settings['wplc_pro_chat_notification'] == "yes") { $wplc_pro_chat_notification = "CHECKED"; } else { }


    switch($area) {
        case 'chat_name':
            return
                "
                <tr>
                    <td width='200' valign='top'>".__("Name ","wplivechat").":</td>
                    <td>
                        <input id='wplc_pro_name' name='wplc_pro_name' type='text' size='50' maxlength='50' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_chat_name'])."' />
                    </td>
                </tr>
                ";
            break;
        case 'chat_pic':
            $wplc_current_user = wp_get_current_user();
            $wplc_current_picture = $wplc_pro_settings['wplc_chat_pic'];
            return
                "
                <tr>
                    <td width='200' valign='top'>".__("Picture","wplivechat").":</td>
                    <td>
                        <span id=\"wplc_pic_area\"><img src='$wplc_current_picture' /></span> <input id=\"wplc_upload_pic\" name=\"wplc_upload_pic\" type='hidden' size='35' class='regular-text' maxlength='700' value='".$wplc_current_picture."'/> <input id=\"wplc_btn_upload_pic\" name=\"wplc_btn_upload_pic\" type=\"button\" value=\"".__("Upload Image","wplivechat")."\" /> 
                        
                    </td>
                </tr>
                ";
            break;
        case 'chat_delay':
            return
                "
                <tr>
                    <td width='200' valign='top'>".__("Chat Delay (seconds)","wplivechat").":</td>
                    <td>
                        <input id='wplc_pro_delay' name='wplc_pro_delay' type='text' size='50' maxlength='4' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_chat_delay'])."' /> (how long it takes for your chat window to pop up)
                    </td>
                </tr>
                ";
            break;
        case 'chat_email_on_chat':
            return
                "
                <tr>
                    <td width='200' valign='top'>".__("Chat notifications","wplivechat").":</td>
                    <td>
                        <input id='wplc_pro_chat_notification' name='wplc_pro_chat_notification' type='checkbox' value='yes' $wplc_pro_chat_notification />
                        ".__("Alert me via email as soon as someone wants to chat","wplivechat")."
                    </td>
                </tr>
                ";
            break;
        case 'chat_logo':
            $wplc_current_logo = $wplc_pro_settings['wplc_chat_logo'];
            return
                "
                <tr>
                    <td width='200' valign='top'>".__("Logo","wplivechat").":</td>
                    <td>
                        <span id=\"wplc_logo_area\"><img src='$wplc_current_logo' /></span> <input id=\"wplc_upload_logo\" name=\"wplc_upload_logo\" type='hidden' size='35' class='regular-text' maxlength='700' value='".$wplc_current_logo."'/> <input id=\"wplc_btn_upload_logo\" name=\"wplc_btn_upload_logo\" type=\"button\" value=\"".__("Upload Logo","wplivechat")."\" /> 
                        
                    </td>
                </tr>
                ";
            break;
        case 'wplc_chat_window_text1':
            return
                "
                    

                <tr>
                    <td width='200' valign='top'>".__("First Section Text","wplivechat").":</td>
                    <td>
                        <input id='wplc_pro_fst1' name='wplc_pro_fst1' type='text' size='50' maxlength='50' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_fst1'])."' /> <br />
                        <input id='wplc_pro_fst2' name='wplc_pro_fst2' type='text' size='50' maxlength='50' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_fst2'])."' /> <br />
                            
                        
                    </td>
                </tr>
                <tr>
                    <td width='200' valign='top'>".__("Intro Text","wplivechat").":</td>
                    <td>
                        <input id='wplc_pro_intro' name='wplc_pro_intro' type='text' size='50' maxlength='150' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_intro'])."' /> <br />
                    </td>
                </tr>
                <tr>
                    <td width='200' valign='top'>".__("Second Section Text","wplivechat").":</td>
                    <td>
                        <input id='wplc_pro_sst1' name='wplc_pro_sst1' type='text' size='50' maxlength='30' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_sst1'])."' /> <br />
                        <input id='wplc_pro_sst2' name='wplc_pro_sst2' type='text' size='50' maxlength='70' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_sst2'])."' /> <br />
                    </td>
                </tr>
                <tr>
                    <td width='200' valign='top'>".__("Reactivate Chat Section Text","wplivechat").":</td>
                    <td>
                        <input id='wplc_pro_tst1' name='wplc_pro_tst1' type='text' size='50' maxlength='50' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_tst1'])."' /> <br />
                            
                        
                    </td>
                </tr>
                <tr>
                    <td width='200' valign='top'>".__("User chat welcome","wplivechat").":</td>
                    <td>
                        <input id='wplc_user_welcome_chat' name='wplc_user_welcome_chat' type='text' size='50' maxlength='150' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_user_welcome_chat'])."' /> <br />
                            
                        
                    </td>
                </tr>
                <tr>
                    <td width='200' valign='top'>".__("Offline Chat Box Title","wplivechat").":</td>
                    <td>
                        <input id='wplc_pro_na' name='wplc_pro_na' type='text' size='50' maxlength='50' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_na'])."' /> <br />
                            
                        
                    </td>
                </tr>
                <tr>
                    <td width='200' valign='top'>".__("Offline Text Fields","wplivechat").":</td>
                    <td>
                        <input id='wplc_pro_offline1' name='wplc_pro_offline1' type='text' size='50' maxlength='150' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_offline1'])."' /> <br />
                        <input id='wplc_pro_offline2' name='wplc_pro_offline2' type='text' size='50' maxlength='50' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_offline2'])."' /> <br />
                        <input id='wplc_pro_offline3' name='wplc_pro_offline3' type='text' size='50' maxlength='150' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_pro_offline3'])."' /> <br />
                            
                        
                    </td>
                </tr>
                <tr>
                    <td width='200' valign='top'>".__("Other text","wplivechat").":</td>
                    <td>
                        <input id='wplc_user_enter' name='wplc_user_enter' type='text' size='50' maxlength='150' class='regular-text' value='".stripslashes($wplc_pro_settings['wplc_user_enter'])."' /> This text is shown above the user chat input field<br />
                            
                        
                    </td>
                </tr>
                ";
            break;
            
        default:
            return "";
            break;
        
    }
    
   

    
}

function wplc_admin_scripts() {
    wp_enqueue_script('media-upload');
    wp_enqueue_script('thickbox');
    
   wp_register_script('my-wplc-upload', WP_PLUGIN_URL.'/'.plugin_basename(dirname(__FILE__)).'/js/upload.js', array('jquery','media-upload','thickbox'));
   wp_enqueue_script('my-wplc-upload');

}
function wplc_admin_styles() {
    wp_enqueue_style('thickbox');
}


function wplc_pro_admin_display_history() {
    global $wpdb;
    global $wplc_tblname_chats;

    $results = $wpdb->get_results(
	"
	SELECT *
	FROM $wplc_tblname_chats
        WHERE `status` = 1
        ORDER BY `timestamp` DESC
	"
    );
    echo "
        

      <table class=\"wp-list-table widefat fixed \" cellspacing=\"0\">
	<thead>
	<tr>
		<th scope='col' id='wplc_id_colum' class='manage-column column-id sortable desc'  style=''><span>".__("Date","wplivechat")."</span></th>
                <th scope='col' id='wplc_name_colum' class='manage-column column-name_title sortable desc'  style=''><span>".__("Name","wplivechat")."</span></th>
                <th scope='col' id='wplc_email_colum' class='manage-column column-email' style=\"\">".__("Email","wplivechat")."</th>
                <th scope='col' id='wplc_url_colum' class='manage-column column-url' style=\"\">".__("URL","wplivechat")."</th>
                <th scope='col' id='wplc_status_colum' class='manage-column column-status'  style=\"\">".__("Status","wplivechat")."</th>
                <th scope='col' id='wplc_action_colum' class='manage-column column-action sortable desc'  style=\"\"><span>".__("Action","wplivechat")."</span></th>
        </tr>
	</thead>
        <tbody id=\"the-list\" class='list:wp_list_text_link'>
        ";
    if (!$results) {
        echo "<tr><td></td><td>".__("No chats available at the moment","wplivechat")."</td></tr>";
    }
    else {
        foreach ($results as $result) {
             unset($trstyle);
             unset($actions);

            
            $url = admin_url( 'admin.php?page=wplivechat-menu&action=history&cid='.$result->id);
            $actions = "<a href='$url' title='View Chat History' id=''>View Chat History</a>";
            $trstyle = "style='height:30px;'";

            

            echo "<tr id=\"record_".$result->id."\" $trstyle>";
            echo "<td class='chat_id column-chat_d'>".$result->timestamp."</td>";
            echo "<td class='chat_name column_chat_name' id='chat_name_".$result->id."'><img src=\"http://www.gravatar.com/avatar/".md5($result->email)."?s=40\" /> ".$result->name."</td>";
            echo "<td class='chat_email column_chat_email' id='chat_email_".$result->id."'><a href='mailto:".$result->email."' title='Email ".".$result->email."."'>".$result->email."</a></td>";
            echo "<td class='chat_name column_chat_url' id='chat_url_".$result->id."'>".$result->url."</td>";
            echo "<td class='chat_status column_chat_status' id='chat_status_".$result->id."'><strong>".wplc_return_status($result->status)."</strong></td>";
            echo "<td class='chat_action column-chat_action' id='chat_action_".$result->id."'>$actions</td>";
            echo "</tr>";


        }
    }
    echo "</table>";
        
}

function wplc_admin_pro_view_chat_history($cid) {
    wplc_pro_draw_chat_area($cid);
}


if (isset($_GET['page']) && $_GET['page'] == 'wplivechat-menu-settings') {
    
    add_action('admin_print_scripts', 'wplc_admin_scripts');
    add_action('admin_print_styles', 'wplc_admin_styles');

}

function wplc_pro_output_box() {
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");
    
    $wplc_is_admin_logged_in = get_transient("wplc_is_admin_logged_in"); // check if admin is logged in
    
    
    if ($wplc_is_admin_logged_in == 1) {
        $wplc_tl_msg = "<strong>".stripslashes($wplc_pro_settings['wplc_pro_fst1'])."</strong> ".stripslashes($wplc_pro_settings['wplc_pro_fst2']);
    } else {
        $wplc_tl_msg = "<span class='wplc_offline'>".stripslashes($wplc_pro_settings['wplc_pro_na'])."</span>";
    }
    
?>    


        <div id="wp-live-chat-close" style="display:none;"></div>
        <div id="wp-live-chat-1">
           
            <?php echo $wplc_tl_msg; ?>
            
        </div>
        <div id="wp-live-chat-2" style="display:none;">
            <?php
            if ($wplc_is_admin_logged_in == 1) {  // admin is logged in
            ?>
            <div id="wp-live-chat-2-info">
                <img src="<?php echo $wplc_pro_settings['wplc_chat_pic']; ?>?s=40" id="wp-live-chat-2-img"/> <?php echo stripslashes($wplc_pro_settings['wplc_pro_intro']); ?>
            </div>

            <table>
                <tr>
                    <td><?php _e("Name","wplivechat"); ?></td>
                    <td><input type="text" name="wplc_name" id="wplc_name" value="" /></td>
                </tr>
                <tr>
                    <td><?php _e("Email","wplivechat"); ?></td>
                    <td><input type="text" name="wplc_email" id="wplc_email" value="" /></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input id="wplc_start_chat_btn" type="button" value="Start Chat" /></td>
                </tr>
            </table>
            
            
            <?php 
            
                } else {  // admin logged out
            
            ?>
            <div id="wp-live-chat-2-info">
                <img src="<?php echo $wplc_pro_settings['wplc_chat_pic']; ?>?s=40" id="wp-live-chat-2-img"/> <?php echo stripslashes($wplc_pro_settings['wplc_pro_offline1']); ?>
            </div>
            <div id="wplc_message_div" style="display:block; padding:10px; margin-left:10px;">
            <?php _e("Name","wplivechat"); ?><br />
            <input type="text" name="wplc_name" id="wplc_name" value="" style="height:20px; padding:0; width:200px;" /> <br /><br />
                
            <?php _e("Email","wplivechat"); ?><br />
            <input type="text" name="wplc_email" id="wplc_email" value="" style="height:20px; padding:0; width:200px;" /> <br /><br />
                
            <?php _e("Message","wplivechat"); ?><br />
            <textarea name="wplc_message" id="wplc_message" style="width:200px;"></textarea><br /><br />
            
            <input id="wplc_na_msg_btn" type="button" value="Send message" />
            </div>
            <?php } ?>
        </div>
        <div id="wp-live-chat-3" style="display:none;">
            <p><?php echo stripslashes($wplc_pro_settings['wplc_pro_sst2']); ?></p>
        </div>
        <div id="wp-live-chat-react" style="display:none;">
        </div>
        <div id="wp-live-chat-4" style="display:none;">
            <?php if ($wplc_pro_settings['wplc_chat_logo']) { ?><div id="wplc_logo" style=""><img class="wplc_logo_class" src="<?php echo stripslashes($wplc_pro_settings['wplc_chat_logo']); ?>" style="display:block; margin-bottom:5px; margin-left:auto; margin-right:auto;" alt="<?php echo get_bloginfo( 'name' ); ?>" title="<?php echo get_bloginfo( 'name' ); ?>" /></div><?php } ?>
            <div id="wplc_chatbox">
                            <div id="wp-live-chat-2-info">
                <img src="<?php echo $wplc_pro_settings['wplc_chat_pic']; ?>?s=40" id="wp-live-chat-2-img"/> <?php echo stripslashes($wplc_pro_settings['wplc_user_welcome_chat']); ?>
            </div>

            </div>
            <p style="text-align:center; font-size:11px;"><?php echo stripslashes($wplc_pro_settings['wplc_user_enter']); ?></p>
            <p>
                <input type="text" name="wplc_chatmsg" id="wplc_chatmsg" value="" />
                <input type="hidden" name="wplc_cid" id="wplc_cid" value="" />
                <input id="wplc_send_msg" type="button" value="<?php _e("Send","wplc"); ?>" style="display:none;" /></p>
        </div>
    </div>    
<?php  
    
}
function wplc_pro_save_settings() {

    
    $wplc_pro_data['wplc_chat_name'] = attribute_escape($_POST['wplc_pro_name']);
    $wplc_pro_data['wplc_chat_pic'] = attribute_escape($_POST['wplc_upload_pic']);
    $wplc_pro_data['wplc_chat_logo'] = attribute_escape($_POST['wplc_upload_logo']);
    $wplc_pro_data['wplc_chat_delay'] = attribute_escape($_POST['wplc_pro_delay']);
    $wplc_pro_data['wplc_pro_chat_notification'] = attribute_escape($_POST['wplc_pro_chat_notification']);
    
    $wplc_pro_data['wplc_pro_na'] = attribute_escape($_POST['wplc_pro_na']);
    $wplc_pro_data['wplc_pro_fst1'] = attribute_escape($_POST['wplc_pro_fst1']);
    $wplc_pro_data['wplc_pro_fst2'] = attribute_escape($_POST['wplc_pro_fst2']);
    $wplc_pro_data['wplc_pro_fst3'] = attribute_escape($_POST['wplc_pro_fst3']);
    $wplc_pro_data['wplc_pro_sst1'] = attribute_escape($_POST['wplc_pro_sst1']);
    $wplc_pro_data['wplc_pro_sst2'] = attribute_escape($_POST['wplc_pro_sst2']);
    $wplc_pro_data['wplc_pro_tst1'] = attribute_escape($_POST['wplc_pro_tst1']);

    $wplc_pro_data['wplc_pro_offline1'] = attribute_escape($_POST['wplc_pro_offline1']);
    $wplc_pro_data['wplc_pro_offline2'] = attribute_escape($_POST['wplc_pro_offline2']);
    $wplc_pro_data['wplc_pro_offline3'] = attribute_escape($_POST['wplc_pro_offline3']);
    
    $wplc_pro_data['wplc_pro_intro'] = attribute_escape($_POST['wplc_pro_intro']);
    
    $wplc_pro_data['wplc_user_enter'] = attribute_escape($_POST['wplc_user_enter']);
    $wplc_pro_data['wplc_user_welcome_chat'] = attribute_escape($_POST['wplc_user_welcome_chat']);

    update_option('WPLC_PRO_SETTINGS', $wplc_pro_data);


}
function wplc_pro_return_delay() {
    $wplc_delay = get_option("WPLC_PRO_SETTINGS");
    return $wplc_delay['wplc_chat_delay'];
}


function wplc_list_visitors() {

    global $wpdb;
    global $wplc_tblname_chats;

    $results = $wpdb->get_results(
	"
	SELECT *
	FROM $wplc_tblname_chats
        WHERE `status` = 5
        ORDER BY `timestamp` DESC
        
	"
    );
    echo "
        

      <table class=\"wp-list-table widefat fixed \" cellspacing=\"0\">
	<thead>
	<tr>
		<th scope='col' id='wplc_id_colum' class='manage-column column-id sortable desc'  style=''><span>".__("IP","wplivechat")."</span></th>
                <th scope='col' id='wplc_name_colum' class='manage-column column-name_title sortable desc'  style=''><span>".__("Name","wplivechat")."</span></th>
                <th scope='col' id='wplc_email_colum' class='manage-column column-email' style=\"\">".__("Email","wplivechat")."</th>
                <th scope='col' id='wplc_url_colum' class='manage-column column-url' style=\"\">".__("URL","wplivechat")."</th>
                <th scope='col' id='wplc_status_colum' class='manage-column column-status'  style=\"\">".__("Status","wplivechat")."</th>
                <th scope='col' id='wplc_action_colum' class='manage-column column-action sortable desc'  style=\"\"><span>".__("Action","wplivechat")."</span></th>
        </tr>
	</thead>
        <tbody id=\"the-list\" class='list:wp_list_text_link'>
        ";
    
    if (!$results) {
        echo "<tr><td></td><td>".__("No visitors on-line at the moment","wplivechat")."</td></tr>";
    }
    else {
        foreach ($results as $result) {
             unset($trstyle);
             unset($actions);
             $wplc_c++;

            $url = admin_url( 'admin.php?page=wplivechat-menu&action=rc&cid='.$result->id);
            $actions = "<a href=\"#\" onclick=\"window.open('$url', 'mywindow".$result->id."', 'location=no,status=1,scrollbars=1,width=500,height=650');return false;\">".__("Initiate Chat","wplivechat")."</a>";
            $trstyle = "style='background-color:#FFFBE4; height:30px;'";


            echo "<tr id=\"record_".$result->id."\" $trstyle>";
            echo "<td class='chat_id column-chat_d'>".$result->ip."</td>";
            echo "<td class='chat_name column_chat_name' id='chat_name_".$result->id."'>".$result->name."</td>";
            echo "<td class='chat_email column_chat_email' id='chat_email_".$result->id."'>".$result->email."</td>";
            echo "<td class='chat_name column_chat_url' id='chat_url_".$result->id."'>".$result->url."</td>";
            echo "<td class='chat_status column_chat_status' id='chat_status_".$result->id."'><strong>".wplc_return_status($result->status)."</strong></td>";
            echo "<td class='chat_action column-chat_action' id='chat_action_".$result->id."'>$actions</td>";
            echo "</tr>";

        }
    }
    echo "</table><br /><br />";
    

}

function wplc_pro_admin_menu_layout_display() {
    
   if (!isset($_GET['action'])) {

        ?>
        <h1>Chat sessions</h1>
        <div id="wplc_sound"></div>
        <div id="wplc_admin_chat_area">
            <?php wplc_list_chats(); ?>
        </div>
        <h1>Visitors on site</h1>

        <div id="wplc_admin_visitor_area">
            <?php wplc_list_visitors(); ?>
        </div>
    <?php
    }
    else {

        if ($_GET['action'] == 'ac') {
            wplc_change_chat_status($_GET['cid'],3);
            wplc_pro_draw_chat_area($_GET['cid']);
        }
        else if ($_GET['action'] == 'history' && function_exists("wplc_register_pro_version")) {
            wplc_admin_pro_view_chat_history($_GET['cid']);
        }
        else if ($_GET['action'] == 'rc' && function_exists("wplc_register_pro_version")) {
            wplc_admin_pro_request_chat($_GET['cid']);
        }

    }
}

function wplc_admin_pro_request_chat($cid) {
    wplc_change_chat_status($cid,6); // 6 = request chat
    wplc_pro_draw_chat_area($cid);
    
    
}



function wplc_pro_draw_chat_area($cid) {

   
    
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

    foreach ($results as $result) {
        
        
        
        if ($result->status == 1) { $status = "Previous"; }
        else if ($result->status == 3) { $status = "Active"; }
        else if ($result->status == 6) { $status = "Awaiting"; }
        
        
        
        
        echo "<h2>$status Chat with ".$result->name."</h2>";
        echo "<div style='display:block; height:150px; font-size:11px;'>";
            echo "<div style='float:left; width:100px;'><img src=\"http://www.gravatar.com/avatar/".md5($result->email)."\" /></div>";
            echo "<div style='float:left; width:350px;'>";
            echo "<table>";
            echo "<tr><td>Email address</td><td><a href='mailto:".$result->email."' title='".$result->email."'>".$result->email."</a></td></tr>";
            echo "<tr><td>IP Address</td><td><a href='http://www.ip-adress.com/ip_tracer/".$result->ip."' title='Whois for ".$result->ip."'>".$result->ip."</a></td></tr>";
            echo "<tr><td>From URL</td><td>".$result->url. "  (<a href='".$result->url."' target='_BLANK'>open</a>)"."</td></tr>";
            echo "<tr><td>Date</td><td>".$result->timestamp."</td></tr>";
            echo "</table><br />";
            echo "</div>";
        echo "</div>";

        if ($result->status == 6) {
            echo "<strong>".__("Attempting to open the chat window... Please be patient.","wplivechat")."</strong>";
        }
                
        if ($result->status != 6) {
            echo "
            <div id='admin_chat_box'>
                <div id='admin_chat_box_area_".$result->id."' style='height:200px; width:290px; border:1px solid #ccc; overflow:auto;'>".wplc_return_chat_messages($cid)."</div>
                <p>
            ";
        }
        
        if ($result->status == 3) {
        echo "
                <p style=\"text-align:left; font-size:11px;\">Press ENTER to send your message</p>
                <input type='text' name='wplc_admin_chatmsg' id='wplc_admin_chatmsg' value='' style=\"border:1px solid #666; width:290px;\" />
                <input id='wplc_admin_cid' type='hidden' value='".$_GET['cid']."' />
                <input id='wplc_admin_send_msg' type='button' value='".__("Send","wplc")."' style=\"display:none;\" />
                    </p>
            </div>
            ";
        }
        
        if ($result->status == 3) {
            //echo wplc_return_admin_chat_javascript($_GET['cid']);
        }
        
    }
}

function wplc_return_pro_admin_chat_javascript($cid) {
        $ajax_nonce = wp_create_nonce("wplc");
        
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            
            var wplc_ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
            
            jQuery("#wplc_admin_chatmsg").focus();
            
            
            <?php if ($_GET['action'] == 'rc') { ?>
                wpcl_admin_auto_check_for_user_window_opened_checker = setInterval(function (){wpcl_admin_auto_check_for_user_window_opened(<?php echo $cid; ?>);}, 2000);
                function wpcl_admin_auto_check_for_user_window_opened(cid) {
                    var data = {
                            action: 'wpcl_admin_auto_check_for_user_window_opened',
                            cid: cid,
                            security: '<?php echo $ajax_nonce; ?>'
                    };
                    jQuery.post(wplc_ajaxurl, data, function(response) {
                        
                        //console.log("wpcl_admin_auto_check_for_user_window_opened");
                        var wplc_is_window_open = response;
                        if (wplc_is_window_open == "3") { 
                            clearInterval(wpcl_admin_auto_check_for_user_window_opened_checker);
                            <?php $url = admin_url( 'admin.php?page=wplivechat-menu&action=ac&cid='.$cid); ?>
                            window.location.replace('<?php echo $url; ?>');
                            
                        }

                    });
                }
            
            <?php } else { ?>            
            
            
            if (jQuery('#wplc_admin_cid').length){
                var wplc_cid = jQuery("#wplc_admin_cid").val();
                var height = jQuery('#admin_chat_box_area_'+wplc_cid)[0].scrollHeight;
                jQuery('#admin_chat_box_area_'+wplc_cid).scrollTop(height);
            }

            jQuery(".wplc_admin_accept").live("click", function() {
                var cid = jQuery(this).attr("cid");
                
                var data = {
                        action: 'wplc_admin_accept_chat',
                        cid: cid,
                        security: '<?php echo $ajax_nonce; ?>'
                };
                jQuery.post(wplc_ajaxurl, data, function(response) {
                    //console.log("wplc_admin_accept_chat");
                    wplc_refresh_chat_boxes[cid] = setInterval(function (){wpcl_admin_update_chat_box(cid);}, 3000);
                    jQuery("#admin_chat_box_"+cid).show();
                });
            });

            jQuery("#wplc_admin_chatmsg").keyup(function(event){
                if(event.keyCode == 13){
                    jQuery("#wplc_admin_send_msg").click();
                }
            });

            jQuery("#wplc_admin_send_msg").live("click", function() {
                var wplc_cid = jQuery("#wplc_admin_cid").val();
                var wplc_chat = jQuery("#wplc_admin_chatmsg").val();
                var wplc_name = "<?php echo wplc_return_from_name(); ?>";
                jQuery("#wplc_admin_chatmsg").val('');
                
                
                jQuery("#admin_chat_box_area_"+wplc_cid).append("<strong>"+wplc_name+"</strong>: "+wplc_chat+"<br />");
                var height = jQuery('#admin_chat_box_area_'+wplc_cid)[0].scrollHeight;
                jQuery('#admin_chat_box_area_'+wplc_cid).scrollTop(height);
                

                var data = {
                        action: 'wplc_admin_send_msg',
                        security: '<?php echo $ajax_nonce; ?>',
                        cid: wplc_cid,
                        msg: wplc_chat
                };
                jQuery.post(wplc_ajaxurl, data, function(response) {
                        //console.log("wplc_admin_send_msg");
                        
                        /* do nothing
                        jQuery("#admin_chat_box_area_"+wplc_cid).html(response);
                        var height = jQuery('#admin_chat_box_area_'+wplc_cid)[0].scrollHeight;
                        jQuery('#admin_chat_box_area_'+wplc_cid).scrollTop(height);
                        */
                });


            });            
            
            
            wplc_auto_refresh = setInterval(function (){wpcl_admin_auto_update_chat_box(<?php echo $cid; ?>);}, 3500);
            function wpcl_admin_auto_update_chat_box(cid) {
                
                var data = {
                        action: 'wplc_update_admin_chat_boxes',
                        cid: <?php echo $cid; ?>,
                        security: '<?php echo $ajax_nonce; ?>'
                };
                jQuery.post(wplc_ajaxurl, data, function(response) {
                    //console.log("wplc_update_admin_chat_boxes");
                    //alert(response);
                    //jQuery("#admin_chat_box_area_"+cid).html(response);
                    jQuery("#admin_chat_box_area_"+cid).append(response);
                    var height = jQuery('#admin_chat_box_area_'+cid)[0].scrollHeight;
                    jQuery('#admin_chat_box_area_'+cid).scrollTop(height);
                });

            }

             
            
            wplc_auto_check_status_of_chat = setInterval(function (){wpcl_admin_auto_check_status_of_chat(<?php echo $cid; ?>);}, 5000);
            var chat_status = 3;
            function wpcl_admin_auto_check_status_of_chat(cid) {
                
                var data = {
                        action: 'wplc_update_admin_return_chat_status',
                        cid: <?php echo $cid; ?>,
                        security: '<?php echo $ajax_nonce; ?>'
                };
                jQuery.post(wplc_ajaxurl, data, function(response) {
                    //console.log("wplc_update_admin_return_chat_status");
                    if (chat_status != response) {
                    chat_status = response;
                        if (chat_status == "1") { 
                            //clearInterval(wplc_auto_check_status_of_chat);
                            //clearInterval(wplc_auto_refresh);
                            jQuery("#admin_chat_box_area_"+cid).append("<em><?php _e("User has minimized the chat window","wplivechat"); ?></em><br />");
                            var height = jQuery('#admin_chat_box_area_'+cid)[0].scrollHeight;
                            jQuery('#admin_chat_box_area_'+cid).scrollTop(height);
                            
                        }
                    }
                    
                });

            }
            <?php } ?>
        });
    </script>
    <?php
}

function wplc_pro_admin_javascript() {
    $ajax_nonce = wp_create_nonce("wplc");
    ?>
    <script type="text/javascript">
        jQuery(document).ready(function() {
            var wplc_ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';

            var wplc_autoLoad = null;
            var wplc_refresh_chat_area = null;
            var wplc_refresh_status = null;
            
            


            wplc_refresh_chat_area = setInterval(function (){wpcl_admin_update_chats();}, 4000);
            function wpcl_admin_update_chats(cid) {
                var data = {
                        action: 'wplc_update_admin_chat',
                        security: '<?php echo $ajax_nonce; ?>'
                };
                jQuery.post(wplc_ajaxurl, data, function(response) {
                        //console.log("wplc_update_admin_chat");
                        jQuery("#wplc_admin_chat_area").html(response);
                        if (response.indexOf("pending") >= 0) {
                            document.getElementById("wplc_sound").innerHTML="<embed src='<?php echo plugins_url('/beep-2.mp3', __FILE__); ?>' hidden=true autostart=true loop=false>";
                        }
                            
                        
                });
            }

            
            wplc_refresh_v_area = setInterval(function (){wpcl_admin_update_visitors();}, 4000);
            function wpcl_admin_update_visitors() {
                var data = {
                        action: 'wplc_update_admin_visitor',
                        security: '<?php echo $ajax_nonce; ?>'
                };
                jQuery.post(wplc_ajaxurl, data, function(response) {
                        //console.log("wplc_update_admin_visitor");
                        jQuery("#wplc_admin_visitor_area").html(response);
                });
            }
            

            wplc_refresh_status = setInterval(function (){wplc_update_statuses();}, 10000);
            function wplc_update_statuses() {
                var data = {
                        action: 'wplc_update_admin_status',
                        security: '<?php echo $ajax_nonce; ?>'
                };
                jQuery.post(wplc_ajaxurl, data, function(response) {
                    //console.log("wplc_update_admin_status");
                    //alert(response);
                });
            };


        });



    </script>
    <?php
}
function wplc_pro_user_top_js() {
    $ajax_nonce = wp_create_nonce("wplc");
    $wplc_settings = get_option("WPLC_SETTINGS");
    wp_register_script( 'wplc-user-jquery-cookie', plugins_url('/js/jquery-cookie.js', __FILE__) );
    wp_enqueue_script( 'wplc-user-jquery-cookie' );

?>

    <script type="text/javascript">
    

    
        var wplc_ajaxurl = '<?php echo admin_url( 'admin-ajax.php' ); ?>';
        var wplc_nonce = '<?php echo $ajax_nonce; ?>';
        var wplc_delay = '<?php echo wplc_pro_return_delay(); ?>000';
        var wplc_offline_msg = '<?php $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS"); echo stripslashes($wplc_pro_settings['wplc_pro_offline2']); ?>';
        var wplc_offline_msg3 = '<?php $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS"); echo stripslashes($wplc_pro_settings['wplc_pro_offline3']); ?>';
        
    <?php
        $wplc_is_admin_logged_in = get_transient("wplc_is_admin_logged_in"); // check if admin is logged in
        if ($wplc_is_admin_logged_in == 1) {
    ?>
    var wplc_al = true;
    <?php } else { ?>
    var wplc_al = false;
    <?php } ?>    
    </script>
    <?php     
}

function wplc_pro_draw_user_box() {
    
    wp_register_script( 'wplc-user-script', plugins_url('/js/wplc_u.js', __FILE__) );
    wp_enqueue_script( 'wplc-user-script' );
    
    wplc_output_box();
   

}
function wplc_pro_notify_via_email() {
    $wplc_pro_settings = get_option("WPLC_PRO_SETTINGS");   
    $chat_noti = $wplc_pro_settings['wplc_pro_chat_notification'];
    
    if ($chat_noti == "yes") {
        $subject = "Someone wants to chat with you on ".get_bloginfo('name');
        $msg = "Someone wants to chat with you on ".get_bloginfo('name')."\n\nLog in: ".wp_login_url()."";
        wp_mail(get_settings('admin_email'), $subject, $msg);
    }
    
    return true;
    
}

