=== Prjcts ===

Contributors: mttconti
Tags: projects, works, portfolio, custom post type, custom taxonomy
Requires at least: 5.0
Tested up to: 6.6
Requires PHP: 7.0
Stable tag: 1.0.2
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Effortlessly create a custom post type to organize projects with custom categories and flexible URL settings, perfect for WordPress theme developers.


== Description ==

"Prjcts" is the ideal plugin for WordPress theme developers who want to integrate a simple custom post type to organize and showcase projects. It’s perfect for implementing portfolios in themes designed for creatives, photographers, artists, and more.

= Key Features: =

* Custom Post Type: Easily create and manage individual projects, perfect for portfolios, case studies, and galleries.
* Custom Categories: Organize projects with tailored categories for intuitive navigation.
* Flexible URLs: Customize project archive and taxonomy URLs to optimize SEO and enhance user experience.
* Optimized Performance: Developed following WordPress best practices for smooth integration.

= Benefits for Theme Developers: =

* Time-Saving: Rapid implementation of a custom post type to organize and showcase projects without coding from scratch.
* Flexibility: Offer clients the power to organize their work professionally.


== Usage ==

There are several ways to display Custom Post Types (CPT) and custom taxonomies in a WordPress theme. Here are some basic examples:

* Single Template (single-prjcts.php): When you create a CPT, you can create a specific template to display individual posts of that type by using a single-{post_type}.php file.
* Archive Template (archive-prjcts.php): To display a list of all posts of a particular CPT, you can create an archive-{post_type}.php file.
* Custom Taxonomy Template (taxonomy-prjcts_category.php): To display terms of a custom taxonomy associated with the CPT, you can create a file like taxonomy-{taxonomy}.php, where 'prjcts_category' is the name of the taxonomy.
* You can use WP_Query to create custom queries anywhere in your theme. For example, if you want to display posts from a CPT on a specific page, you can create a new query:

    `
    <?php

    &#36;args = array(
        'post_type' => 'prjcts',
        'posts_per_page' => 10,
    );

    &#36;the_query = new WP_Query(&#36;args);

    if (&#36;the_query->have_posts()) :
        while (&#36;the_query->have_posts()) : &#36;the_query->the_post();

            // YOUR MARKUP HERE

        endwhile;
        wp_reset_postdata();
    else :
        echo 'No posts found';
    endif;

    ?>
    `


== Installation ==

= Automatic Installation (Recommended) =

1. Log in to your WordPress dashboard.
2. Navigate to "Plugins" > "Add New".
3. In the search field, type "Prjcts".
4. Once you've found the plugin, click "Install Now".
5. After installation, click "Activate" to enable the plugin on your site.

= Manual Installation =

1. Download the plugin zip file from the WordPress plugin repository or from where you've made it available.
2. Log in to your WordPress dashboard.
3. Navigate to "Plugins" > "Add New".
4. Click the "Upload Plugin" button at the top of the page.
5. Choose the downloaded zip file and click "Install Now".
6. Once installation is complete, click "Activate".

= Post-Installation Setup =

Navigate to "Projects" in your WordPress dashboard menu to start adding new projects. To customize plugin settings, go to "Projects" > "Settings" in the dashboard, here you can modify the slugs for your project archive page and custom taxonomy


== Changelog ==

= 1.0.2 =
* Fixed a text error in the readme.txt file

= 1.0.1 =
* Initial release