<?php


/*

Plugin Name: Prjcts
Description: Create and showcase your projects with a custom post type, categories, and flexible URL settings for your portfolio or work archive.
Version: 1.0.2
Requires at least: 5.0
Requires PHP: 7.0
Author: Matteo Conti
Author URI: https://mttconti.com
License: GNU General Public License v2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html
Text Domain: prjcts

Prjcts is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 2 of the License, or
any later version.

Prjcts is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Prjcts. If not, see http://www.gnu.org/licenses/gpl-2.0.html.

*/



if( !defined('ABSPATH') ) {
    die;
}



/* Activate/Deactivate Plugin
================================================================ */

function prjcts_activate_plugin() {

    prjcts_create_custom_post_type();
    flush_rewrite_rules();

}

function prjcts_deactivate_plugin() {

    flush_rewrite_rules();

}

register_activation_hook( __FILE__, 'prjcts_activate_plugin' );
register_deactivation_hook( __FILE__, 'prjcts_deactivate_plugin' );



/* Create Custom Post Type
================================================================ */

function prjcts_create_custom_post_type() {

    $prjcts_settings_slugs = get_option( 'prjcts_settings_slugs' ); 

    $labels = array(
        'name'                          => __( 'Projects', 'prjcts' ),
        'singular_name'                 => __( 'Project', 'prjcts' ),
        'add_new'                       => __( 'Add Project', 'prjcts' ),
        'add_new_item'                  => __( 'Add New Project' , 'prjcts' ),
        'edit_item'                     => __( 'Edit Project', 'prjcts' ),
        'new_item'                      => __( 'New Project', 'prjcts' ),
        'view_item'                     => __( 'View Project', 'prjcts' ),
        'view_items'                    => __( 'View All Projects', 'prjcts' ),
        'search_items'                  => __( 'Search Projects' , 'prjcts' ),
        'not_found'                     => __( 'No projects found', 'prjcts' ),
        'not_found_in_trash'            => __( 'No projects found in Trash', 'prjcts' ),
        'all_items'                     => __( 'All Projects', 'prjcts' ),
        'archives'                      => __( 'Project Archives', 'prjcts' ),
        'attributes'                    => __( 'Project Attributes', 'prjcts' ),
        'insert_into_item'              => __( 'Insert into project', 'prjcts' ),
        'uploaded_to_this_item'         => __( 'Uploaded to this project', 'prjcts' ),
        'filter_items_list'             => __( 'Filter projects list', 'prjcts' ),
        'items_list_navigation'         => __( 'Projects list navigation', 'prjcts' ),
        'items_list'                    => __( 'Projects list', 'prjcts' ),
        'item_published'                => __( 'Project published', 'prjcts' ),
        'item_published_privately'      => __( 'Project published privately', 'prjcts' ),
        'item_reverted_to_draft'        => __( 'Project reverted to draft', 'prjcts' ),
        'item_scheduled'                => __( 'Project scheduled', 'prjcts' ),
        'item_updated'                  => __( 'Project updated', 'prjcts' ),
        'item_link'                     => __( 'Project Link', 'prjcts' ),
        'item_link_description'         => __( 'A link to a project', 'prjcts' ),
    );

    $supports = array(
        'title',
        'editor',
        'comments',
        'revisions',
        'author',
        'excerpt',
        'page-attributes',
        'thumbnail',
        'custom-fields',
        'post-format'
    );

    $args = array(
        'labels'             => $labels,
        'public'             => true,
        'hierarchical'       => true,
        'show_in_rest'       => true,
        'menu_position'      => 20,
        'menu_icon'          => 'dashicons-portfolio',
        'supports'           => $supports,
        'taxonomies'         => array( 'prjcts_category' ),
        'has_archive'        => true,
        'rewrite'          => array( 'slug' => !empty( $prjcts_settings_slugs['prjcts_cpt_slug'] ) ? esc_attr( $prjcts_settings_slugs['prjcts_cpt_slug']) : esc_html__('projects', 'prjcts') )
    );

    register_post_type( 'prjcts', $args );

}

add_action( 'init', 'prjcts_create_custom_post_type' );



/* Create Custom Taxonomy
================================================================ */

function prjcts_create_custom_taxonomy() {

    $prjcts_settings_slugs = get_option( 'prjcts_settings_slugs' );

    $labels = array(
        'name'                          => __( 'Project Categories', 'prjcts' ),
        'singular_name'                 => __( 'Project Category', 'prjcts' ),
        'search_items'                  => __( 'Search Project Categories', 'prjcts' ),
        'all_items'                     => __( 'All Project Categories', 'prjcts' ),
        'edit_item'                     => __( 'Edit Project Category', 'prjcts' ),
        'view_item'                     => __( 'View Project Category', 'prjcts' ),
        'update_item'                   => __( 'Update Project Category', 'prjcts' ),
        'add_new_item'                  => __( 'Add New Project Category', 'prjcts' ),
        'new_item_name'                 => __( 'New Project Category Name', 'prjcts' ),
        'not_found'                     => __( 'No project categories found', 'prjcts' ),
        'not_terms'                     => __( 'No project categories', 'prjcts' ),
        'filter_by_item'                => __( 'Filter by project category', 'prjcts' ),
        'item_link'                     => __( 'Project Category Link', 'prjcts' ),
        'item_link_description'         => __( 'A link to a project category', 'prjcts' ),
    );

    $args = array(
        'labels'           => $labels,
        'public'           => true,
        'hierarchical'     => true,
        'show_in_rest'     => true,
        'rewrite'          => array( 'slug' => !empty( $prjcts_settings_slugs['prjcts_tax_slug'] ) ? esc_attr( $prjcts_settings_slugs['prjcts_tax_slug']) : esc_html__('project-category', 'prjcts') )
    );

    register_taxonomy( 'prjcts_category', 'prjcts', $args );

}

add_action( 'init', 'prjcts_create_custom_taxonomy' );



/* Create Admin Columns
================================================================ */

function prjcts_admin_create_columns( $columns ) {

    unset( $columns['comments'] );
    
    $columns['project_category'] = __('Project Category', 'prjcts');
    $columns['featured_image'] = __('Featured Image', 'prjcts');
    $columns['project_id'] = __('Project ID', 'prjcts');

    return $columns;

}

function prjcts_admin_populate_columns( $column, $post_id ) {

    switch ( $column ) {

        case 'project_category' :

            $prjcts_project_category = get_the_term_list( $post_id, 'prjcts_category', '', ' / ', '' );

            if( is_string( $prjcts_project_category ) ) {
                echo wp_kses_post($prjcts_project_category);
            } else {
                esc_html_e( 'No Project Category', 'prjcts' );
            }

            break;

        case 'featured_image' :

            $prjcts_featured_image = get_the_post_thumbnail( $post_id, array(100,100) );

            if ( has_post_thumbnail( $post_id ) )
                echo wp_kses_post($prjcts_featured_image);
            else
                esc_html_e( 'No Featured Image', 'prjcts' );

            break;

        case 'project_id' :

            echo esc_html(get_the_ID());

            break;

    }

}

add_filter( 'manage_prjcts_posts_columns', 'prjcts_admin_create_columns' );
add_action( 'manage_prjcts_posts_custom_column' , 'prjcts_admin_populate_columns', 10, 2 );



/* Create Settings Submenu Page
================================================================ */

function prjcts_add_submenu_page() { 

	add_submenu_page(
        'edit.php?post_type=prjcts',
        'Settings',
        'Settings',
        'manage_options',
        'settings',
        'prjcts_add_submenu_page_callback'
    );

}

function prjcts_add_submenu_page_callback() {

    ?>

    <div class="wrap">

        <h1><?php esc_html_e( 'Prjcts Settings', 'prjcts' ) ?></h1> 

        <?php settings_errors(); ?>

        <form method="post" action="options.php">
            <?php
                settings_fields( 'prjcts_settings' );
                do_settings_sections( 'prjcts-submenu-page' );
                submit_button();
                flush_rewrite_rules();
            ?>
        </form>
    </div>

    <?php

}

function prjcts_init_submenu_page() {

    register_setting(
        'prjcts_settings',
        'prjcts_settings_slugs',
        'prjcts_settings_sanitize'
    );

    add_settings_section(
        'prjcts_settings_slugs_section',
        '',
        '__return_null',
        'prjcts-submenu-page' 
    );

    add_settings_field(
        'prjcts_cpt_slug',
        __('Custom Post Type Slug', 'prjcts'),
        'prjcts_cpt_slug_callback',
        'prjcts-submenu-page',
        'prjcts_settings_slugs_section'
    );

    add_settings_field(
        'prjcts_tax_slug', 
        __('Custom Taxonomy Slug', 'prjcts'), 
        'prjcts_tax_slug_callback', 
        'prjcts-submenu-page', 
        'prjcts_settings_slugs_section' 
    );

}

function prjcts_settings_sanitize($input) {

    $sanitary_values = array();

    if ( isset( $input['prjcts_cpt_slug'] ) ) {
        $sanitary_values['prjcts_cpt_slug'] = sanitize_text_field( $input['prjcts_cpt_slug'] );
    }

    if ( isset( $input['prjcts_tax_slug'] ) ) {
        $sanitary_values['prjcts_tax_slug'] = sanitize_text_field( $input['prjcts_tax_slug'] );
    }

    return $sanitary_values;
    
}

function prjcts_cpt_slug_callback() {

    $prjcts_settings_slugs = get_option( 'prjcts_settings_slugs' ); 

    printf(
        '<input id="prjcts_cpt_slug" class="regular-text" type="text" name="prjcts_settings_slugs[prjcts_cpt_slug]" value="%s" placeholder="%s">',
        !empty( $prjcts_settings_slugs['prjcts_cpt_slug'] ) ? esc_attr( $prjcts_settings_slugs['prjcts_cpt_slug']) : '',
        esc_html__('projects', 'prjcts')
    );

}

function prjcts_tax_slug_callback() {

    $prjcts_settings_slugs = get_option( 'prjcts_settings_slugs' ); 

    printf(
        '<input id="prjcts_tax_slug" class="regular-text" type="text" name="prjcts_settings_slugs[prjcts_tax_slug]" value="%s" placeholder="%s">',
        !empty( $prjcts_settings_slugs['prjcts_tax_slug'] ) ? esc_attr( $prjcts_settings_slugs['prjcts_tax_slug']) : '',
        esc_html__('project-category', 'prjcts')
    );
    
}

add_action( 'admin_menu', 'prjcts_add_submenu_page' );
add_action( 'admin_init', 'prjcts_init_submenu_page' );