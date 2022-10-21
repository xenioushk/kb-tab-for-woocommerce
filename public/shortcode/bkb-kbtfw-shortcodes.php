<?php

add_shortcode('bkb_woo_tab', 'bkb_woo_tab');
        
function bkb_woo_tab( $atts ){
 
    $id_prefix = wp_rand();
    
    extract(shortcode_atts(array(
        'post_type'     => 'bwl_kb',
        'post_ids'         => '',
        'orderby'         => 'post__in',
        'order'            => 'ASC',
        'limit'              => -1,
        'suppress_filters' => 0

    ), $atts));
    
    $output = "";
    
    global $bkb_data;
    
    $args = array(
        'post_status'       => 'publish',
        'post__in'         => explode(',', $post_ids),
        'post_type'         => $post_type,
        'orderby'             => $orderby,
        'order'                => $order,
        'posts_per_page' => $limit
    );
    
    // We are going to set a filter in here for Restriction Addon.
    $args = apply_filters('bkb_rkb_query_filter', $args);
    
    $loop = new WP_Query($args);
    
//    $kbftw_rand_id = wp_rand(); 

        if ( $loop->have_posts() ) :
            
            // Enqueue Script
            // @Since: 1.0.4
            
            wp_enqueue_script( BKBKBTFW_ADDON_PREFIX . '-bwlaccordion-plugin-script');
            wp_enqueue_script( BKBKBTFW_ADDON_PREFIX . '-custom-script');
            
            $output.='<div class="bwl_acc_container" id="bkb_woo_accordion">';
                $output.='<div class="accordion_search_container">';
                    $output.='<input type="text" class="accordion_search_input_box search_icon" value="" placeholder="Search ..."/>';
                $output.='</div>'; //<!-- end .bwl_acc_container -->
            $output.='<div class="search_result_container"></div>';//<!-- end .search_result_container -->

        while ( $loop->have_posts() ) :

                $loop->the_post(); 

                $bkb_title = get_the_title();
                $bkb_content = get_the_content();
                
                 if( has_filter("bkb_rkb_post_access") ) {
            
                    $bkb_rkb_post_access_result = apply_filters('bkb_rkb_post_access', get_the_ID());

                    if ( $bkb_rkb_post_access_result != 1 ) {
                        $bkb_content = $bkb_rkb_post_access_result;
                    }

                }
          
                $output.='<section>';
                    $output.='<h2 class="acc_title_bar"><a href="#">'.$bkb_title.'</a></h2>';
                    $output.='<div class="acc_container"><div class="block">'. do_shortcode( $bkb_content ).'</div></div>';
                $output.='</section>';
                
            endwhile;
            
            $output.='</div> <!-- end .bwl_acc_container -->';
            
        else:
            
            $output.= '<p>'.__('No Knowledge Base Post Found!', 'bwl_kb').'</p>';
        
        endif;
        
    wp_reset_query();
    
    return do_shortcode($output);
    
}