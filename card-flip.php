<?php
/**
 * Plugin Name: Card-Flip
 * Description: Creates a Gallery Index of your posts as a card flip.
 * Version: 1.0
 * Author: Vanstone Online | Jason Vanstone
 * Author URI: https://vanstoneonline.com
 *
 */

//Set Card Flip Image Size
add_image_size( 'card-flip-image', 200, 200, array('center','center')); 

//Load Style Sheet for the Card Flip
function wpse_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'card-flip', $plugin_url . 'css/card-flip.css' );
}
add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css', 999 );

//Function to call all the posts and turn it into a card flip. 

if( !function_exists('vo_card_flip') ) {
function vo_card_flip() { 
    $true='true';
    //get all posts
    $args = array(
        'posts_per_page'   => -1,
        'orderby'          => 'date',
        'order'            => 'ASC',
    );
    $the_query = new WP_Query($args);
    //Bulk Add HTML to the Function.
    ob_start();
    ?>
    
   <div id="card-flip-gallery"> 
    <?php
    if ( $the_query->have_posts() ) : 
        while ( $the_query->have_posts() ) : $the_query->the_post(); 
        setup_postdata( $post );  ?>
        <div class="card-full">
            <article class="card">
                <div class="card--front">
                    <?php if ( has_post_thumbnail()) : ?>
                    <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
                    <?php the_post_thumbnail('card-flip-image',array('class' => 'card__img')); ?>
                    </a>
                    <?php endif; ?>
                </div>
                <div class="card--back">
                    <h2 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>   
                </div>
            </article>
        </div> <!--end Gallery Item -->
        <?php endwhile; 
       wp_reset_postdata(); ?>
        
    <?php else : ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif; ?>
   </div> <!-- End Gallery -->
    <?php 

    return ob_get_clean();
    } 
// register shortcode
}
add_shortcode('card-flip', 'vo_card_flip'); 
 ?>