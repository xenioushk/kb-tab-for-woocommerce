<?php
namespace BKBRKB\Helpers;

/**
 * Class for plugin helpers.
 *
 * @package BKBRKB
 */
class RkbHelpers {

    /**
     * Display safe HTML content.
     *
     * @param string $content The content to be displayed.
     *
     * @return string The sanitized content.
     */
    public static function display_safe_html( $content = '' ) {
        $allowed_html = [
            'a'      => [
                'href'   => [],
                'target' => [],
            ],
            'strong' => [],
            'em'     => [],
            'br'     => [],
            'p'      => [],
        ];

        return wp_kses( $content, $allowed_html );
    }

    /**
     * Check if the user can access the content.
     *
     * @param int $post_id Post ID.
     *
     * @return int 1 if user can access, 0 otherwise.
     */
    public static function can_user_access( $post_id ) {

        // Check if the post ID is valid.
        if ( empty( $post_id ) ) {
            return 0;
        }

        // Get All List of Allowed User set by the admin.
        $allowed_roles = get_post_meta( $post_id, 'bkb_rkb_user_roles', true );

        $default_role = 'administrator';

        if ( ! empty( $allowed_roles ) ) {

            $isAdminRoleExists = array_search( $default_role, $allowed_roles, true );

            if ( $isAdminRoleExists === false ) {
                $allowed_roles[] = $default_role;
            }
		} else {
            $allowed_roles = [ $default_role ];
        }

        // Get current user info.
        $current_user      = wp_get_current_user();
        $current_user_role = ( isset( $current_user->roles[0] ) ) ? $current_user->roles[0] : '';

        // Checking user role can able to access the content or not.
        // If user role can access the content then we change post access value in to 1 and return it.

        $access_status = ( ! empty( $current_user_role ) && in_array( $current_user_role, $allowed_roles, true ) ) ? 1 : 0;

        return $access_status;
    }


    /**
     * Get excluded posts based on the taxonomy type.
     *
     * @param string $bkb_tax_type The taxonomy type (category or tags).
     *
     * @return array The array of excluded posts.
     */
    public static function bkb_rkb_get_excluded_posts( $bkb_tax_type = 'category' ) {

        global $bkb_data;

        $bkb_rkb_get_excluded_posts = [];

        if ( isset( $bkb_data['bkb_rkb_all_kb_display_status'] ) && $bkb_data['bkb_rkb_all_kb_display_status'] == 'on' ) {

            return $bkb_rkb_get_excluded_posts;
        } else {

            global $wp_query;
            $current_queried_object = $wp_query->get_queried_object();
            $category_slug          = $current_queried_object->slug;

            $args = [
                'post_status'         => 'publish',
                'post_type'           => 'bwl_kb',
                'ignore_sticky_posts' => 1,
                'posts_per_page'      => -1,
            ];

            if ( $bkb_tax_type == 'tags' ) {
                $args['bkb_tags'] = $category_slug;
            } else {
                $args['bkb_category'] = $category_slug;
            }

            $args['meta_query'] = [
                [
                    'key'     => 'bkb_rkb_status',
                    'compare' => '=',
                    'value'   => '1',
                ],
            ];

            $loop = new WP_Query( $args );

            if ( count( $loop->posts ) > 0 ) {

                foreach ( $loop->posts as $posts ) {

                    $bkb_rkb_get_excluded_posts[] = $posts->ID;
                }
            }

            wp_reset_query();
        }

        return $bkb_rkb_get_excluded_posts;
    }
}
