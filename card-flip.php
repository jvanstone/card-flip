<?php
/**
 * Plugin Name: Card-Flip
 * Description: Creates a Gallery Index of your posts as a card flip.
 * Version: 1.0
 * Author: Vanstone Online | Jason Vanstone
 * Author URI: https://vanstoneonline.com
 *
 */



//Set thumbnail size
add_image_size( 'gallery-index', 200, 200, array('center','center')); 

//Load Style Sheet for the Card Flip
function wpse_load_plugin_css() {
    $plugin_url = plugin_dir_url( __FILE__ );
    wp_enqueue_style( 'card-flip', $plugin_url . 'css/card-flip.css' );
}
add_action( 'wp_enqueue_scripts', 'wpse_load_plugin_css' );

//Function to call all the posts and turn it into a card flip. 

if( !function_exists('wpb_card_flip') ) {
function wpb_card_flip() { 

    ob_start();
    $true='true';
    $args = array(
        'posts_per_page'   => -1,
        'orderby'          => 'date',
        'order'            => 'ASC',
    );
    $the_query = new WP_Query($args);
    //Bulk Add HTML to the Function.
    ob_start();
    ?>
    
   <div id="gallery-index"> 
    <?php
    if ( $the_query->have_posts() ) : 
        while ( $the_query->have_posts() ) : $the_query->the_post(); 
        setup_postdata( $post );  ?>
        <div class="gallery-item">
        <?php the_content(); ?>
            <article class="card">
            <div class="card--front">
                <?php if ( has_post_thumbnail()) : ?>
                <a href="<?php the_permalink(); ?>" alt="<?php the_title_attribute(); ?>">
                <?php the_post_thumbnail('gallery-index',array('class' => 'card__img')); ?>
                </a>
                <?php endif; ?>
            </div>
            <div class="card--back">
                <h2 class="card__title"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h2>
                <?php the_content(); ?>
            </div>
            </article>
        </div>
        <?php endwhile; 
       wp_reset_postdata(); ?>
        
    <?php else : ?>
        <p><?php _e( 'Sorry, no posts matched your criteria.' ); ?></p>
    <?php endif;
    ?>
    </div> <!-- End Gallery -->
    <?php 

    return ob_get_clean();
    } 
// register shortcode
}
add_shortcode('card_flip', 'wpb_card_flip'); 
 ?>