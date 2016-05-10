<?php  
/*
Plugin Name: 署名设置插件
Plugin URI: http://www.tencent.com/
Description: 在文章最下面显示姓名，地址和标语信息。
Version: 1.0.0
Author: Tencent
Author URI: http://www.tencent.com/
License: GPL
*/

register_activation_hook( __FILE__, 'display_copyright_install');   
register_deactivation_hook( __FILE__, 'display_copyright_remove' );  

function display_copyright_install() {  
    add_option("name_text", "My Name", '', 'yes');  
    add_option("address_text", "Tencent Building, Shenzhen, China", 'yes');
    add_option("slogan_text", "Work hard, Play harder", 'yes');
}

function display_copyright_remove() {  
    delete_option('name_text');  
    delete_option('address_text');
    delete_option('slogan_text');
}

if( is_admin() ) {
    add_action('admin_menu', 'display_bottom_text_setting_menu');
}

function display_bottom_text_setting_menu() {
    add_options_page('Set Copyright', '设置署名', 'administrator','display_bottom_text', 'display_bottom_text_html_page');
}

function display_bottom_text_html_page() {
    ?>
    <div>  
        <form method="post" action="options.php">  
            <?php  ?>  
            <?php wp_nonce_field('update-options'); ?>  

            <h2>名字</h2>  
            <p>  
                <textarea  
                    name="name_text" 
                    id="name_text" 
                    cols="40" 
                    rows="6"><?php echo get_option('name_text'); ?></textarea>  
            </p>  

            <h2>地址</h2>
            <p>  
                <textarea  
                    name="address_text" 
                    id="address_text" 
                    cols="40" 
                    rows="6"><?php echo get_option('address_text'); ?></textarea>  
            </p>  

            <h2>标语</h2>
            <p>  
                <textarea  
                    name="slogan_text" 
                    id="slogan_text" 
                    cols="40" 
                    rows="6"><?php echo get_option('slogan_text'); ?></textarea>  
            </p>  

            <p>  
                <input type="hidden" name="action" value="update" />  
                <input type="hidden" name="page_options" value="name_text" />  
 
                <input type="submit" value="Save" class="button-primary" />  
            </p>  
        </form>  
    </div>  
<?php  
}  

add_filter( 'the_content',  'display_bottom_text' );  

function display_bottom_text( $content ) {  
    if( is_home() )  {
        $content = $content . get_option('name_text'); 
        $content = $content . '<br/>'; 
        $content = $content . get_option('address_text'); 
        $content = $content . '<br/>'; 
        $content = $content . get_option('slogan_text'); 
    }
 
    return $content;  
}  
?>