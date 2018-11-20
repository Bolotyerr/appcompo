<?php


  //include the main class file
  require_once("admin-page-class/admin-page-class.php");
  
  
  /**
   * configure your admin page
   */
  $config = array(    
		'menu'=> 'settings',             //sub page to settings page
		'page_title' => __('Scroll Menu Admin','apc'),       //The name of this page 
		'capability' => 'edit_themes',         // The capability needed to view the page 
		'option_group' => 'scrollmenu_options',       //the name of the option to create in the database
		'id' => 'scroll_menu_page',            // meta box id, unique per page
		'fields' => array(),            // list of fields (can be added by field arrays)
		'local_images' => false,          // Use local or hosted images (meta box images for add/remove)
		'use_with_theme' => false          //change path if used with theme set to true, false for a plugin or anything else for a custom path(default false).
  );  
  
  /**
   * Initiate your admin page
   */
  $options_panel = new BF_Admin_Page_Class($config);
  $options_panel->OpenTabs_container('');
  
  /**
   * define your admin page tabs listing
   */
  $options_panel->TabsListing(array(
    'links' => array(
    'migscroll_options' =>  __('General Options','apc'),
    )
  ));
  
  $post_percents = array('0%','1%', '2%', '3%', '4%', '5%', '6%', '7%', '8%', '9%', '10%', '11%', '12%', '13%', '14%', '15%', '16%', '17%', '18%', '19%', '20%', '21%', '22%', '23%', '24%', '25%', '26%', '27%', '28%', '29%', '30%', '31%', '32%', '33%', '34%', '35%', '36%', '37%', '38%', '39%', '40%', '41%', '42%', '43%', '44%', '45%', '46%', '47%', '48%', '49%', '50%', '51%', '52%', '53%', '54%', '55%', '56%', '57%', '58%', '59%', '60%', '61%', '62%', '63%', '64%', '65%', '66%', '67%', '68%', '69%', '70%', '71%', '72%', '73%', '74%', '75%', '76%', '77%', '78%', '79%', '80%', '81%', '82%', '83%', '84%', '85%', '86%', '87%', '88%', '89%', '90%', '91%', '92%', '93%', '94%', '95%', '96%', '97%', '98%', '99%', '100%');
  
  $options_panel->OpenTab('migscroll_options');
  
  	$options_panel->addSelect('scroll_top_position',$post_percents,array('name'=> __('Top Position ','apc'), 'std'=> array('10%'), 'desc' => __('Distance from the top side of the screen','apc')));
	
  	$options_panel->addSelect('scroll_right_position',$post_percents,array('name'=> __('Right Position ','apc'), 'std'=> array('0%'), 'desc' => __('Distance from the right side of the screen','apc')));
	
	$options_panel->addSelect('scroll_fontsize',array('50%'=>'50%','75%'=>'75%','100%'=>'100%','125%'=>'125%','150%'=>'150%'),array('name'=> __('Text Size ','apc'), 'std'=> array('100%'), 'desc' => __('Text Size','apc')));
   
   $options_panel->addSelect('scroll_style',array('None'=>'None','One'=>'One','Two'=>'Two','Three'=>'Three'),array('name'=> __('Button style ','apc'), 'std'=> array('None'), 'desc' => __('Select the buttons style','apc')));
   
   $options_panel->addSelect('scroll_scrollable',array('yes' => 'yes', 'no' => 'no'),array('name'=> __('Scrollable','apc'), 'std'=> array('yes'), 'desc' => __('Scrollable or fixed position buttons','apc')));
   
  $options_panel->CloseTab();


  