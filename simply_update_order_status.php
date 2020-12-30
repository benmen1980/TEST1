<?php
/**
 * @package     PriorityAPI
 * @author      Roy <roy@simplyCT.co.il>
 * @copyright   2021 SimplyCT
 *
 * @wordpress-plugin
 * Plugin Name: Simply Update Order Status
 * Plugin URI: http://www.simplyCt.co.il
 * Description: Simply Update the order status
 * Version: 1.0
 * Author: SimplyCT
 * Author URI: http://www.simplyCt.co.il
 * Licence: GPLv2
 * Text Domain: simply
 * Domain Path: languages
 *
 */




// short code to update order status
function simply_update_status_form() {
    ob_start();
    ?>
    <!-- Dropdown -->

    <form method = "post">
        <table>
            <tr>
                <td><label><?php _e('Choose Customer','woocommerce'); ?></label></td>
                <td>
                    <select name="customer" id='selUser' style='width: 200px;'>
                        <option value = ""><?php _e('Please select a customer','woocommerce'); ?></option>
                        <?php
                        global $post;
                        $args = array(
                            'numberposts' => -1,
                            'post_type'   => 'customers'
                        );
                        $posts = get_posts($args);
                        foreach( $posts as $post ) : setup_postdata($post); ?>
                            <option value="<?php echo $post->ID; ?>"><?php the_title(); ?></option>
                        <?php endforeach; ?>
                    </select>
                    <!--input type='button'  value='Seleted option' id='but_read'-->

                    <br/>
                    <div id='result'></div>
                </td>
            </tr>
            <tr>
                <td><label><?php _e('Choose Order','woocommerce'); ?></label></td>
                <td><input type="text" name="order"></td>
            </tr>
            <tr>
                <td><input type="submit" name="simply_update_status"></td>
            </tr>
        </table>
    </form>
    <?php
    if ( isset( $_POST['simply_update_status'] ) && !empty($_POST['customer'] && !empty($_POST['order']))) {
        // update the status
        $customer_id = $_POST['customer'];
        $order_id    = $_POST['order'];
        $order = wc_get_order( $order_id );
        if(!$order){
            _e('Order does not exists','woocommerce');
            //return;
        }else {
            $order_user_id = $order->user_id;
            $user_meta = get_user_meta($order_user_id);
            $user_customer = get_user_meta($order_user_id, 'user_customer', true);
        }
        if($customer_id == $user_customer) {
            // here goes the order status update

        }else {
            _e('The Order does not belongs to the customer','woocommerce');
        }
    }else{
        // or add notice
        _e('Please choose a customer and a valid order number','woocommerce');
    }
    return ob_get_clean();
}
add_action( 'init', function(){

    add_shortcode( 'simply_update_order_status', 'simply_update_status_form' );
} );
add_action('wp_enqueue_scripts','simply_plugin_scripts');
function simply_plugin_scripts(){
    wp_enqueue_script('select2',plugin_dir_url( __FILE__ ).'select2/dist/js/select2.min.js',array ( 'jquery' ), 1.1,false);
    wp_enqueue_script('select2_main',plugin_dir_url( __FILE__ ).'main.js',array ( 'jquery' ), 1.1,false);
    wp_enqueue_style('select2_style',plugin_dir_url( __FILE__ ).'select2/dist/css/select2.min.css',[],null,'');


}
