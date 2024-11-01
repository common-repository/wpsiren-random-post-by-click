<?php
/*
Plugin Name: Wpsiren Random Post by Click
Plugin URI: http://www.wpsiren.com/wpsiren-random-post-by-click
Description: Lets you add random post button in the sidebar
Author: WPSIREN
Author URI: www.wpsiren.com
Version: 1.0.3
License: GPL
*/
?>
<?php

// Register Widget

function register_WPRP_Widget(){
  register_widget('WPRP_Widget');

}

add_action('widgets_init','register_WPRP_Widget');



// RPBC Widget Class

class WPRP_Widget extends WP_Widget {  
    /** 
     * Register widget with WordPress. 
     */  
    public function __construct() {  
        parent::__construct(  
            'wprp', // Base ID  
            'WPSiren - Random Post Button', // Name  
            array( 
            'classname' => 'widget_wprp',
            'description' => __( 'Add Random Post Button', 'wpsiren.com' ) 
            
            ) // Args  
        );  
    }  
    /** 
     * Front-end display of widget. 
     * 
     * @see WP_Widget::widget() 
     * 
     * @param array $args     Widget arguments. 
     * @param array $instance Saved values from database. 
     */  
    public function widget( $args, $instance ) { 

        extract( $args );  


        $fontSize = $instance['wpsiren_wprp_font_size'];
        $lineHeight = $fontSize + ( $fontSize / 2 ) . "px";
        $borderRadius = $instance['wpsiren_wprp_button_border_radius'];
        $shwCredits = $instance['wpsiren_wprp_show_credits'];
        $shwTitle   = $instance['wpsiren_wprp_show_title'];
        $buttonText = $instance['wpsiren_wprp_button_text'];
        $buttonBgColor = $instance['wpsiren_wprp_button_bg_color'];
        $buttonFgColor = $instance['wpsiren_wprp_button_fg_color'];
        $buttonBgColorHover = $instance['wpsiren_wprp_button_bg_color_hover'];
        $buttonFgColorHover = $instance['wpsiren_wprp_button_fg_color_hover'];
        $title = apply_filters('widget_title', $instance['title'] );
        $padding = $instance['wpsiren_wprp_padding'];
        $textAlign = $instance['wpsiren_wprp_text_align'];  
        echo $before_widget;

       if($shwTitle == '1'){

        if ( ! empty( $title ) )  {
        echo $before_title . $title . $after_title;
        }

    }

  global $wpdb;

  $arr = $wpdb->get_results("SELECT ID FROM wp_posts WHERE post_type='post' and post_status='publish'
    ","ARRAY_A");
 
  $curr_id = get_the_ID();
  $numbr = array_rand($arr);

  if($arr[$numbr][ID] == $curr_id){

  $numbr = array_rand($arr);
  
  }

 $new_id = $arr[$numbr][ID];
 $postlink = get_permalink($new_id);

 echo "<div class='randompost-button'><a href='" . $postlink . "' title='" . get_the_title($new_id) . "'>" . $buttonText . "</a></div>";
 
  if($shwCredits == '1'){
            echo "<div class='wprp-credits'><a href='http://www.wpsiren.com' title='www.wpsiren.com' target='_blank'>Powered by WPSIREN</a></div>";
        }

?>


<style type="text/css">

.randompost-button{
  padding:<?php echo $padding; ?> !important;
  text-align:<?php echo $textAlign; ?> !important;
  background:<?php echo $buttonBgColor; ?>;
  color:<?php echo $buttonFgColor; ?> !important;
  font-size:<?php echo $fontSize; ?>;
  line-height:<?php echo $lineHeight; ?>;
  border-radius: <?php echo $borderRadius; ?>;
  -moz-border-radius: <?php echo $borderRadius; ?>;
  -webkit-border-radius: <?php echo $borderRadius; ?>;
  -o-border-radius: <?php echo $borderRadius; ?>;
  -ms-border-radius: <?php echo $borderRadius; ?>;

}

.randompost-button:hover{
  background:<?php echo $buttonBgColorHover; ?>;
}

.randompost-button a, .randompost-button a:link,.randompost-button a:visited,.randompost-button a:active{
  color:<?php echo $buttonFgColor; ?> !important;
}

.randompost-button a:hover{
  color:<?php echo $buttonFgColorHover; ?> !important;
}

</style>


<?php
 echo $after_widget;  



    }  
    /** 
     * Sanitize widget form values as they are saved. 
     * 
     * @see WP_Widget::update() 
     * 
     * @param array $new_instance Values just sent to be saved. 
     * @param array $old_instance Previously saved values from database. 
     * 
     * @return array Updated safe values to be saved. 
     */  
    public function update( $new_instance, $old_instance ) {  
        $instance = array();
        $instance['title'] = strip_tags($new_instance['title']);
        $instance['wpsiren_wprp_button_text'] = strip_tags($new_instance['wpsiren_wprp_button_text']);
        $instance['wpsiren_wprp_button_fg_color'] = strip_tags($new_instance['wpsiren_wprp_button_fg_color']);
        $instance['wpsiren_wprp_button_bg_color'] = strip_tags($new_instance['wpsiren_wprp_button_bg_color']);
        $instance['wpsiren_wprp_button_fg_color_hover'] = strip_tags($new_instance['wpsiren_wprp_button_fg_color_hover']);
        $instance['wpsiren_wprp_button_bg_color_hover'] = strip_tags($new_instance['wpsiren_wprp_button_bg_color_hover']);
        $instance['wpsiren_wprp_text_align'] = strip_tags($new_instance['wpsiren_wprp_text_align']);
        $instance['wpsiren_wprp_font_size'] = strip_tags($new_instance['wpsiren_wprp_font_size']);
        $instance['wpsiren_wprp_padding'] = strip_tags($new_instance['wpsiren_wprp_padding']);
        $instance['wpsiren_wprp_button_border_radius'] = strip_tags($new_instance['wpsiren_wprp_button_border_radius']);
        $instance['wpsiren_wprp_show_credits'] = (bool)($new_instance['wpsiren_wprp_show_credits']);
        $instance['wpsiren_wprp_show_title'] = (bool)($new_instance['wpsiren_wprp_show_title']);
        return $instance;  
    }  
    /** 
     * Back-end widget form. 
     * 
     * @see WP_Widget::form() 
     * 
     * @param array $instance Previously saved values from database. 
     */  
    public function form( $instance ) {  
        
    // Default Values Of Options

        if ( isset( $instance[ 'title' ] ) ) {  
            $title = $instance[ 'title' ];  
        }

        if(isset($instance['wpsiren_wprp_button_text'])) {
          $buttonText = $instance['wpsiren_wprp_button_text'];   
        }else{
            $buttonText = "Random Post";
        }

        if(isset($instance['wpsiren_wprp_button_bg_color'])){
          $buttonBgColor = $instance['wpsiren_wprp_button_bg_color'];
        }else{
          $buttonBgColor = "#373737";
        }

        if(isset($instance['wpsiren_wprp_button_fg_color'])){
          $buttonFgColor = $instance['wpsiren_wprp_button_fg_color'];
        }else{
          $buttonFgColor = "#f8f8f8";
        }


         if(isset($instance['wpsiren_wprp_button_bg_color_hover'])){
          $buttonBgColorHover = $instance['wpsiren_wprp_button_bg_color_hover'];
        }else{
          $buttonBgColorHover = "#101010";
        }

        if(isset($instance['wpsiren_wprp_button_fg_color_hover'])){
          $buttonFgColorHover = $instance['wpsiren_wprp_button_fg_color_hover'];
        }else{
          $buttonFgColorHover = "#f8f8f8";
        }

        if(isset($instance['wpsiren_wprp_button_border_radius'])){
          $borderRadius = $instance['wpsiren_wprp_button_border_radius'];

        }else{
          $borderRadius = "8px";
        }


        if(isset($instance['wpsiren_wprp_font_size'])){
          $fontSize = $instance['wpsiren_wprp_font_size'];

        }else{
          $fontSize =  "12px";
        }


        if(isset($instance['wpsiren_wprp_padding'])){
          $padding = $instance['wpsiren_wprp_padding'];
        }else{
          $padding = "20px";
        }



      ?>
 
         <p>  
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id( 'wpsiren_wprp_show_title' ); ?>" name="<?php echo $this->get_field_name( 'wpsiren_wprp_show_title' ); ?>" value="1" <?php echo ($instance['wpsiren_wprp_show_title'] == "true" ? "checked='checked'" : ""); ?> />
        <label for="<?php echo $this->get_field_id( 'wpsiren_wprp_show_title' ); ?>"><?php _e( 'Enable Title' ); ?></label>  
       </p>

        <p>  
        <label for="<?php echo $this->get_field_id( 'title' ); ?>"><?php _e( 'Title:' ); ?></label>  
        <input class="widefat" id="<?php echo $this->get_field_id( 'title' ); ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" type="text" value="<?php echo esc_attr( $title ); ?>" />  
        </p>

        <p>  
        <label for="<?php echo $this->get_field_id( 'wpsiren_wprp_button_text' ); ?>"><?php _e( 'Button Text:' ); ?></label>  
        <input class="widefat" id="<?php echo $this->get_field_id( 'wpsiren_wprp_button_text' ); ?>" name="<?php echo $this->get_field_name( 'wpsiren_wprp_button_text' ); ?>" type="text" value="<?php echo esc_attr( $buttonText ); ?>" />  
        </p>

        
        <p>  
        <label for="<?php echo $this->get_field_id( 'wpsiren_wprp_button_bg_color' ); ?>"><?php _e( 'Button Background Color:' ); ?></label>  
        <input class="widefat" id="<?php echo $this->get_field_id( 'wpsiren_wprp_button_bg_color' ); ?>" name="<?php echo $this->get_field_name( 'wpsiren_wprp_button_bg_color' ); ?>" type="text" value="<?php echo esc_attr( $buttonBgColor ); ?>" />  
        </p>


        <p>  
        <label for="<?php echo $this->get_field_id( 'wpsiren_wprp_button_fg_color' ); ?>"><?php _e( 'Button Text Color:' ); ?></label>  
        <input class="widefat" id="<?php echo $this->get_field_id( 'wpsiren_wprp_button_fg_color' ); ?>" name="<?php echo $this->get_field_name( 'wpsiren_wprp_button_fg_color' ); ?>" type="text" value="<?php echo esc_attr( $buttonFgColor ); ?>" />  
        </p>


         <p>  
        <label for="<?php echo $this->get_field_id( 'wpsiren_wprp_button_bg_color_hover' ); ?>"><?php _e( 'Button Background Color - Hover:' ); ?></label>  
        <input class="widefat" id="<?php echo $this->get_field_id( 'wpsiren_wprp_button_bg_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'wpsiren_wprp_button_bg_color_hover' ); ?>" type="text" value="<?php echo esc_attr( $buttonBgColorHover ); ?>" />  
        </p>


        <p>  
        <label for="<?php echo $this->get_field_id( 'wpsiren_wprp_button_fg_color_hover' ); ?>"><?php _e( 'Button Text Color - Hover:' ); ?></label>  
        <input class="widefat" id="<?php echo $this->get_field_id( 'wpsiren_wprp_button_fg_color_hover' ); ?>" name="<?php echo $this->get_field_name( 'wpsiren_wprp_button_fg_color_hover' ); ?>" type="text" value="<?php echo esc_attr( $buttonFgColorHover ); ?>" />  
        </p>


        <p>  
        <label for="<?php echo $this->get_field_id( 'wpsiren_wprp_button_border_radius' ); ?>"><?php _e( 'Button Border Radius:' ); ?></label>  
        <input class="widefat" id="<?php echo $this->get_field_id( 'wpsiren_wprp_button_border_radius' ); ?>" name="<?php echo $this->get_field_name( 'wpsiren_wprp_button_border_radius' ); ?>" type="text" value="<?php echo esc_attr( $borderRadius ); ?>" />  
        </p>




        <p>  
        <label for="<?php echo $this->get_field_id( 'wpsiren_wprp_font_size' ); ?>"><?php _e( 'Font Size:' ); ?></label>  
        <input class="widefat" id="<?php echo $this->get_field_id( 'wpsiren_wprp_font_size' ); ?>" name="<?php echo $this->get_field_name( 'wpsiren_wprp_font_size' ); ?>" type="text" value="<?php echo esc_attr( $fontSize ); ?>" />  
        </p>

         <p>  
        <label for="<?php echo $this->get_field_id( 'wpsiren_wprp_padding' ); ?>"><?php _e( 'Padding:' ); ?></label>  
        <input class="widefat" id="<?php echo $this->get_field_id( 'wpsiren_wprp_padding' ); ?>" name="<?php echo $this->get_field_name( 'wpsiren_wprp_padding' ); ?>" type="text" value="<?php echo esc_attr( $padding ); ?>" />  
        </p>

        <p>
        <label for="<?php echo $this->get_field_id('wpsiren_wprp_text_align'); ?>"><?php _e('Text Align:'); ?></label>
        <select class="widefat" id="<?php echo $this->get_field_id('wpsiren_wprp_text_align'); ?>" name="<?php echo $this->get_field_name('wpsiren_wprp_text_align'); ?>">
      
        <?php 

        $textalign = array("center","left","right");
        foreach($textalign as $ta){
        ?>
        
        <option class="widefat" value="<?php echo $ta; ?>" <?php if( $instance['wpsiren_wprp_text_align'] == $ta ) { echo "selected='selected'
        "; }else{ echo " "; }?>>
        <?php echo $ta; ?>
        </option>
        
        <?php

        }
        ?>
        </select></p>



        <h4 style="margin-bottom:3px">Credits</h4>
      <p style="font-size:10px">Support us </p>
       
      
      <p>  
        <input type="checkbox" class="checkbox" id="<?php echo $this->get_field_id('wpsiren_wprp_show_credits'); ?>" name="<?php echo $this->get_field_name('wpsiren_wprp_show_credits'); ?>" value="1" <?php echo ($instance['wpsiren_wprp_show_credits'] == "true" ? "checked='checked'" : ""); ?> />
        <label for="<?php echo $this->get_field_id('wpsiren_wprp_show_credits'); ?>"><?php _e( 'Enable Credits' ); ?></label>  
       </p>
       
<?php  
}  
}
?>