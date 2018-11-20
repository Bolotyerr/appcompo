jQuery(document).ready(function() {

    
        var wplc_check_cookie_id;
        var wplc_check_cookie_stage;
        var wplc_check_hide_cookie;
        var wplc_user_auto_refresh = "";
        var wplc_user_await_admin_requester = "";

        wplc_check_cookie_id = jQuery.cookie('wplc_cid');
        wplc_check_cookie_stage = jQuery.cookie('wplc_stage');
        wplc_check_hide_cookie = jQuery.cookie('wplc_hide');


        function wplc_relay_user_stage(stage,cid) {
            
            if (!wplc_al) { return null; }
            
            if (cid.length) {
                var data = {
                        action: 'wplc_relay_stage',
                        security: wplc_nonce,
                        stage: stage,
                        cid: cid
                };
            } else {
                var data = {
                        action: 'wplc_relay_stage',
                        security: wplc_nonce,
                        stage: stage
                };
            }
            jQuery.post(wplc_ajaxurl, data, function(response) {
                
                    //console.log("wplc_relay_stage");
                    // set timer to see if admin is requesting a chat (8 seconds is best, not too much, not too little)
                    wplc_user_await_admin_requester = setInterval(function (){wplc_user_await_admin_request(wplc_check_cookie_id);}, 8000);
                    
                    
                    if (stage == 1) { // inform admin that user sees chat window
                        jQuery.cookie('wplc_cid', response, { expires: 1, path: '/' });
                        jQuery.cookie('wplc_stage', 1, { expires: 1, path: '/' });
                        jQuery.cookie('wplc_name', 'user', { expires: 1, path: '/' });
                        jQuery.cookie('wplc_email', 'not set', { expires: 1, path: '/' });
                        wplc_check_cookie_id = response;
                        wplc_check_cookie_stage = 1;
                        

                    }
            });
        }
        
        
        /* take to pro version */
        function wplc_user_await_admin_request(cid) {
            var data = {
                action: 'wplc_user_await_admin_request',
                security: wplc_nonce,
                cid: cid
            };
            jQuery.post(wplc_ajaxurl, data, function(response) {
                //console.log("wplc_user_await_admin_request");
                if (response == "6") {
                 clearInterval(wplc_user_await_admin_requester);
                 
                 // admin wants to chat with user, show chat window. set name and email to temp
                 jQuery("#wp-live-chat-1").show();
                 jQuery("#wp-live-chat-close").show();
                 jQuery("#wp-live-chat-2").hide();
                 jQuery("#wp-live-chat-3").hide();
                 jQuery("#wp-live-chat-4").show();
                 jQuery("#wplc_chatmsg").focus();
                 jQuery("#wplc_cid").val(cid);
                 jQuery("#wplc_name").val('You');
                 jQuery("#wplc_email").val('notset');
                 wplc_user_waiting = setInterval(function (){wplc_user_await_session(cid);}, 5000);
                 
                 var data = {
                    action: 'wplc_user_notify_admin_window_open',
                    security: wplc_nonce,
                    cid: cid
                };
                jQuery.post(wplc_ajaxurl, data, function(response) {
                    //console.log("wplc_user_notify_admin_window_open");
                    /* do nothing */
                });
                 
                }
            });
        }        




        /* close chat window */
        jQuery("#wp-live-chat-close").live("click", function() {
            jQuery("#wp-live-chat-1").show();
            jQuery("#wp-live-chat-1").css('cursor', 'pointer');

            jQuery("#wp-live-chat-2").hide();
            jQuery("#wp-live-chat-3").hide();
            jQuery("#wp-live-chat-4").hide();
            jQuery("#wp-live-chat-close").hide();
            jQuery.cookie('wplc_hide', "yes", { expires: 1, path: '/' });
            
            
            
            var data = {
                action: 'wplc_user_close_chat',
                security: wplc_nonce,
                cid: wplc_check_cookie_id
            };
            jQuery.post(wplc_ajaxurl, data, function(response) {
                    //console.log("wplc_user_close_chat");
            });            
        });
        
        
        
        jQuery("#wp-live-chat-1").live("click", function() {
            //jQuery("#wp-live-chat-1").hide();
            jQuery("#wp-live-chat-1").css('cursor', 'default');
            jQuery.cookie('wplc_hide', "");
            jQuery("#wp-live-chat-close").show();

            if (!wplc_al) { 
                jQuery("#wp-live-chat-2").show();

            } else { 
                wplc_check_cookie_stage = jQuery.cookie('wplc_stage');
                if (wplc_check_cookie_stage == "3") {


                    jQuery("#wp-live-chat-4").show();
                     jQuery("#wplc_chatmsg").focus();
                    jQuery("#wp-live-chat-2").hide();
                }
                else {
                    jQuery("#wp-live-chat-2").show();
                }
            }
            
            
        });

        var wplc_user_waiting = null;

        jQuery("#wplc_start_chat_btn").live("click", function() {
            var wplc_name = jQuery("#wplc_name").val();
            var wplc_email = jQuery("#wplc_email").val();
            if (wplc_name.length <= 0) { alert("Please enter your name"); return false; }
            if (wplc_email.length <= 0) { alert("Please enter your email address"); return false; }

            jQuery("#wp-live-chat-2").hide();
            jQuery("#wp-live-chat-3").show();

            wplc_check_cookie_id = jQuery.cookie('wplc_cid');
            
            var wplc_chat_session_id;
            if (typeof wplc_check_cookie_id != "undefined" || wplc_check_cookie_id != null) { // we've alreasdy recorded a cookie for this person
                var data = {
                        action: 'wplc_start_chat',
                        security: wplc_nonce,
                        name: wplc_name,
                        email: wplc_email,
                        cid: wplc_check_cookie_id 
                };
            } else { // no cookie recorded yet for this visitor
                var data = {
                        action: 'wplc_start_chat',
                        security: wplc_nonce,
                        name: wplc_name,
                        email: wplc_email 
                };
            }
            jQuery.post(wplc_ajaxurl, data, function(response) {
                    //console.log("wplc_start_chat");
                    wplc_chat_session_id = response;
                    wplc_user_waiting = setInterval(function (){wplc_user_await_session(wplc_chat_session_id);}, 5000);

            });
        });

        jQuery("#wplc_na_msg_btn").live("click", function() {
            var wplc_name = jQuery("#wplc_name").val();
            var wplc_email = jQuery("#wplc_email").val();
            var wplc_msg = jQuery("#wplc_message").val();
            if (wplc_name.length <= 0) { alert("Please enter your name"); return false; }
            if (wplc_email.length <= 0) { alert("Please enter your email address"); return false; }
            if (wplc_msg.length <= 0) { alert("Please enter a message"); return false; }
            jQuery("#wplc_message_div").html(wplc_offline_msg);

            wplc_check_cookie_id = jQuery.cookie('wplc_cid');
            var data = {
                    action: 'wplc_user_send_offline_message',
                    security: wplc_nonce,
                    cid: wplc_check_cookie_id,
                    name: wplc_name,
                    email: wplc_email,
                    msg: wplc_msg
            };
            jQuery.post(wplc_ajaxurl, data, function(response) {
                    //console.log("wplc_user_send_offline_message");
                    jQuery("#wplc_message_div").html(wplc_offline_msg3);

            });
        });



        function wplc_user_await_session(cid) {
            var data = {
                    action: 'wplc_user_awaiting_chat',
                    security: wplc_nonce,
                    id: cid
            };
            jQuery.post(wplc_ajaxurl, data, function(response) {
                //console.log("wplc_user_awaiting_chat");
                //alert("chat status"+response);
                if (response == "3") {
                    clearInterval(wplc_user_waiting);
                    var wplc_name = jQuery("#wplc_name").val();
                    jQuery("#wplc_cid").val(cid)
                    jQuery("#wp-live-chat-3").hide();
                    jQuery("#wp-live-chat-4").show();
                    jQuery("#wplc_chatmsg").focus();
                    clearInterval(wplc_user_await_admin_requester);
                    // chat is now active
                    jQuery.cookie('wplc_cid', cid, { expires: 1, path: '/' });
                    jQuery.cookie('wplc_name', wplc_name, { expires: 1, path: '/' });
                    jQuery.cookie('wplc_stage', 3, { expires: 1, path: '/' });
                    wplc_user_auto_refresh = setInterval(function (){wpcl_user_auto_update_chat_box(cid);}, 3500);

                };
            });
            return;
        }
        jQuery("#wplc_chatmsg").keyup(function(event){
            if(event.keyCode == 13){
                jQuery("#wplc_send_msg").click();
            }
        });

        jQuery("#wplc_send_msg").live("click", function() {
            var wplc_cid = jQuery("#wplc_cid").val();
            var wplc_chat = jQuery("#wplc_chatmsg").val();
            var wplc_name = jQuery("#wplc_name").val();
            if (typeof wplc_name == "undefined" || wplc_name == null || wplc_name == "") {
                wplc_name = jQuery.cookie('wplc_name');
            }
            jQuery("#wplc_chatmsg").val('');
            jQuery("#wplc_chatbox").append("<strong>"+wplc_name+"</strong>: "+wplc_chat+"<br />");
            var height = jQuery('#wplc_chatbox')[0].scrollHeight;
            jQuery('#wplc_chatbox').scrollTop(height);

            var data = {
                    action: 'wplc_user_send_msg',
                    security: wplc_nonce,
                    cid: wplc_cid,
                    msg: wplc_chat
            };
            jQuery.post(wplc_ajaxurl, data, function(response) {
                    //console.log("wplc_user_send_msg");
            });

        });
        
        function wpcl_user_auto_update_chat_box(cid) {
            var data = {
                    action: 'wplc_update_user_chat_boxes',
                    cid: cid,
                    security: wplc_nonce
            };
            jQuery.post(wplc_ajaxurl, data, function(response) {
                //console.log("wplc_update_user_chat_boxes");
                jQuery("#wplc_chatbox").append(response);
                var height = jQuery('#wplc_chatbox')[0].scrollHeight;
                jQuery('#wplc_chatbox').scrollTop(height);

            });

        }                

        
        // user pushed the X button, dont show chat window
        if (wplc_check_hide_cookie == "yes") {
            jQuery("#wp-live-chat-1").show();
            jQuery("#wp-live-chat-2").hide();
            jQuery("#wp-live-chat-3").hide();
            jQuery("#wp-live-chat-4").hide();
        } else {


            // First time visitor has visited the site, show chat window and set cookie
            if (typeof wplc_check_cookie_id == "undefined" || wplc_check_cookie_id == null) {
                wplc_dc = setTimeout(function (){jQuery("#wp-live-chat").css({ "display" : "block" }); wplc_relay_user_stage(1,''); }, wplc_delay);
            }
            // user has been here before, show different chat windows depending on which stage of the chat funnel he/she was in
            else { 
            
                jQuery("#wplc_cid").val(wplc_check_cookie_id);
                
                // user just viewing a page // user hasnt chatted before but has a cookie set (stage 1)
                if (wplc_check_cookie_stage == 1) { 
                
                    jQuery("#wp-live-chat-1").show();
                    jQuery("#wp-live-chat").css({ "display" : "block" });
                    wplc_relay_user_stage(2,wplc_check_cookie_id);
                    
                }
                // user has chatted before, restore chat window
                else { 
                
                   if (!wplc_al) { 
                                        
                    jQuery("#wp-live-chat-1").show();
                    jQuery("#wp-live-chat-close").hide();            
                    jQuery("#wp-live-chat-2").hide();
                    jQuery("#wp-live-chat-3").hide();
                    jQuery("#wp-live-chat-4").hide();           
                   } else {
                    
                    
                    jQuery("#wp-live-chat-1").show();
                    

                    jQuery("#wp-live-chat-2").hide();
                    jQuery("#wp-live-chat-3").hide();
                    jQuery("#wp-live-chat-4").hide();
                    jQuery("#wp-live-chat-react").show();

                    jQuery("#wp-live-chat").css({ "display" : "block" });

                        var data = {
                                action: 'wplc_user_reactivate_chat',
                                security: wplc_nonce,
                                cid: wplc_check_cookie_id
                        };
                        
                        jQuery.post(wplc_ajaxurl, data, function(response) {
                            //console.log("wplc_user_reactivate_chat");
                            jQuery("#wp-live-chat-react").hide();
                            jQuery("#wp-live-chat-4").show();
                            jQuery("#wp-live-chat-close").show();
                            jQuery("#wplc_chatmsg").focus();
                            jQuery("#wplc_chatbox").append(response);
                            var height = jQuery('#wplc_chatbox')[0].scrollHeight;
                            jQuery('#wplc_chatbox').scrollTop(height);

                            wplc_user_auto_refresh = setInterval(function (){wpcl_user_auto_update_chat_box(wplc_check_cookie_id);}, 3500);
                        });
                   }
               }
                    
                
                }
                
        }

    });