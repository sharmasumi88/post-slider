<?php
/**
 * Plugin Name: Post Slider
 * Plugin URI: https://sumitsharma.xyz
 * Description: This plugin is use to show latest posts and display them as a rotating carousel.
 * Version: 1.0
 * Author: Sumit Sharma
 * Author URI: https://sumitsharma.xyz
 **/
?>
<?php
/************************** ShortCode to show Post Slider ***************************/


function add_style_script()
{

    wp_register_script( 'get-script', plugins_url('assets/owl.carousel.js', __FILE__), array(), '1.0.0', 'all' );
    wp_register_script( 'get-slider-script', plugins_url('assets/slider.js', __FILE__), array(), '1.0.0', 'all' );
    wp_register_style( 'get-style', plugins_url('assets/owl.carousel.css', __FILE__), array(), '1.0.0', 'all' );

}

add_action('wp_enqueue_scripts', 'add_style_script');


function posts_slider($atts=null){
    $wp_atts = shortcode_atts([
        'cat' => -1,
        'type'=> 'post'
    ], $atts);

    $cat = explode(',',$wp_atts['cat']);
    $args = array(
        'post_type'   => $wp_atts['type'],
        'post_status' => 'publish',
        'cat'=> $cat,
        'posts_per_page'=>10
    );

    $query = new WP_Query($args);
    if( $query->have_posts()): ?>
       <?php
        wp_enqueue_style( 'get-style' );
        wp_enqueue_script( 'get-script' );
        wp_enqueue_script( 'get-slider-script' );
        ?>

<div class="owl-carousel owl-theme">
       <?php while( $query->have_posts()): $query->the_post();

            { ?>

            <div class="item">
                <div class="card">
                    <img class="card-img-top" src="<?php if(get_the_post_thumbnail_url()) { echo get_the_post_thumbnail_url(); }else{  ?>https://www.greenandvibrant.com/sites/default/files/field/image/Decorative-Areca-palm-near-white-brick-wall.jpg<?php } ?>" alt="<?php the_title(); ?>">
                    <div class="card-body">
                        <h4 class="card-title"><?php the_title(); ?></h4>
                        <p class="card-text"><?php echo wp_trim_words(get_the_content(),'20','null'); ?></p>
                        <a href="<?php echo get_the_permalink(); ?>" class="btn btn-primary stretched-link" target="_blank">Read more..</a>
                    </div>
                </div>

            </div>

            <?php }

        endwhile; ?>
</div>
   <?php else:
    endif;

    wp_reset_postdata();
}

add_shortcode('my-carousel', 'posts_slider');

?>