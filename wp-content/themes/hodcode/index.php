<?php get_header(); ?>
<div id="page" class="site">
    <main id="main" class="site-main">
        <?php
        $terms = get_terms([
            'taxonomy' => 'product_category',
            'hide_empty' => false,
        ]);
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                the_title('<h2>', '</h2>');
                // the_content();
                the_excerpt();
                the_post_thumbnail('medium');
            }
        } else {
            echo '<p>No content found.</p>';
        }
        ?>
    </main>
</div>
<?php get_footer(); ?>