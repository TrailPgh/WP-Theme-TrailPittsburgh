<?php
/*---------------------------------------------------------------------------------*/
/* Social Networks widget */
/*---------------------------------------------------------------------------------*/
class dotorg_social_networks extends WP_Widget {

	public function __construct() {
		$widget_ops = array('description' => esc_html__('This is Social Networks widget.','dotorg') );
		parent::__construct(false, esc_html__('Themnific: Social Networks','dotorg'),$widget_ops);      
	}

   function widget($args, $instance) {  
    extract( $args );
   	$title = isset( $instance['title'] ) ? esc_attr( $instance['title'] ) : '';
	?>
		<?php echo ($before_widget); ?>
        <?php if ($title) { echo($before_title) . esc_attr($title) . $after_title; } ?>
        	<?php get_template_part('/includes/uni-social'); ?>
            <div style="clear: both;"></div> 
		<?php echo($after_widget); ?>   
   <?php
   }

   function update($new_instance, $old_instance) {                
       return $new_instance;
   }

   function form($instance) {  
      	$defaults = array('title' => '');
		$instance = wp_parse_args((array) $instance, $defaults);      
   
       $title = esc_attr($instance['title']);

       ?>
       <p>
	   	   <label for="<?php echo esc_attr($this->get_field_id('title')); ?>"><?php esc_html_e('Title:','dotorg'); ?></label>
	       <input type="text" name="<?php echo esc_attr($this->get_field_name('title')); ?>"  value="<?php echo esc_attr($title); ?>" class="widefat" id="<?php echo esc_attr($this->get_field_id('title')); ?>" />
       </p>
      <?php
   }
} 

register_widget('dotorg_social_networks');
?>