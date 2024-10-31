<?php
/*
Plugin Name: OTD Calendar
Version: 0.1
Plugin URI: http://shdb.info/
Description: OTD Calendar shows a simple On-This-Day calendar.
Author: gosunatxrea@gmail.com
Author URI: http://shdb.info/
*/
class OTDCalendarWidget extends WP_Widget {
    function OTDCalendarWidget() {
        parent::WP_Widget(false, $name = 'OTDCalendarWidget');	
    }

    function widget($args, $instance) {		
        extract( $args );
        $title = apply_filters('widget_title', $instance['title']);
        ?>
              <?php echo $before_widget; ?>
                  <?php if ( $title )
                        echo $before_title . $title . $after_title; ?>
<?php // ?>
<?php
	$today = getdate();
	$today_month = $today['mon'];
	$today_day = $today['mday'];
	$max = array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);

	$tmp_month = (isset($_GET['monthnum']) && preg_match('/^[0-9]./', $_GET['monthnum']) && (intval($_GET['monthnum']) > 0) && (intval($_GET['monthnum'] < 13)) ? intval($_GET['monthnum']) : $today_month);
	$tmp_day = (isset($_GET['day']) && preg_match('/^[0-9]./', $_GET['day']) && (intval($_GET['day']) > 0) && (intval($_GET['day'] <= $max[$tmp_month - 1])) ? intval($_GET['day']) : $today_day);

	$back_month = $tmp_month - 1 > 0 ? $tmp_month - 1 : 12;
	$back_day = $max[$back_month - 1] < $tmp_day ? $max[$back_month - 1] : $tmp_day;
	$back_month = ($back_month < 10 ? '0' : '') . $back_month;
	$back_day = ($back_day < 10 ? '0' : '') . $back_day;

	$for_month = $tmp_month + 1 < 13? $tmp_month + 1 : 1;
	$for_day = $max[$for_month - 1] < $tmp_day ? $max[$for_month - 1] : $tmp_day;
	$for_month = ($for_month < 10 ? '0' : '') . $for_month;
	$for_day = ($for_day < 10 ? '0' : '') . $for_day;

	$zen_day = $tmp_day - 1 > 0 ? $tmp_day - 1 : $max[$tmp_month - 1 > 0 ? $tmp_month - 2 : 11];
	$zen_month = $tmp_day - 1 > 0 ? $tmp_month  : ($tmp_month - 1 > 0 ? $tmp_month - 1 : 12);
	$zen_month = ($zen_month < 10 ? '0' : '') . $zen_month;
	$zen_day = ($zen_day < 10 ? '0' : '') . $zen_day;

	$yok_day = $tmp_day + 1 <= $max[$tmp_month - 1] ? $tmp_day + 1 : 1;
	$yok_month = $tmp_day + 1 <= $max[$tmp_month - 1] ? $tmp_month  : ($tmp_month + 1 < 13 ? $tmp_month + 1 : 1);
	$yok_month = ($yok_month < 10 ? '0' : '') . $yok_month;
	$yok_day = ($yok_day < 10 ? '0' : '') . $yok_day;
?>
	&nbsp;&nbsp;&nbsp;&nbsp;<a style="text-decoration:none" href="./?monthnum=<?php echo $back_month;?>&day=<?php echo $back_day;?>">&lt;&lt;</a>&nbsp;

	<a style="text-decoration:none" href="./?monthnum=<?php echo $zen_month;?>&day=<?php echo $zen_day;?>">&lt;</a>&nbsp;

	<a style="text-decoration:none" href="./?monthnum=<?php echo ($tmp_month < 10 ? '0' : '') . esc_html($tmp_month);?>&day=<?php echo ($tmp_day < 10 ? '0' : '') . esc_html($tmp_day);?>"><?php 
	echo esc_html($tmp_month);?>/<?php echo esc_html($tmp_day);?></a>&nbsp;

	<a style="text-decoration:none" href="./?monthnum=<?php echo $yok_month;?>&day=<?php echo $yok_day;?>">&gt;</a>&nbsp;

	<a style="text-decoration:none" href="./?monthnum=<?php echo $for_month;?>&day=<?php echo $for_day;?>">&gt;&gt;</a>
<br />
<table>
<tbody>
<tr>
<?php 
	for($i = 1; $i <= $max[$tmp_month - 1]; $i++) {

?>
		<td colspan="5" class="pad">&nbsp;&nbsp;<?php echo $i < 10 ? "&nbsp;" : '';?><a style="text-decoration:none" href="./?monthnum=<?php echo ($tmp_month < 10 ? '0' : '') . $tmp_month;?>&day=<?php echo ($i < 10 ? '0' : '') . $i;?>"><?php echo $i;?></a><?php //echo "(" . $tmp_posts->post_count . ")";?></td>
<?php 
		if($i % 7 == 0) {?></tr><tr><?php }
	
	} ?>
</tr>
</tbody>
</table>

              <?php echo $after_widget; ?>
        <?php
    }

    function update($new_instance, $old_instance) {				
        return $new_instance;
    }

    function form($instance) {				
        $title = esc_attr($instance['title']);
        ?>
            <p><label for="<?php echo $this->get_field_id('title'); ?>"><?php _e('Title:'); ?> <input class="widefat" id="<?php echo $this->get_field_id('title'); ?>" name="<?php echo $this->get_field_name('title'); ?>" type="text" value="<?php echo $title; ?>" /></label></p>
        <?php 
    }

} 


add_action('widgets_init', create_function('', 'return register_widget("OTDCalendarWidget");'));

?>
