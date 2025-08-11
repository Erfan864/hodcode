<?php get_header(); ?>
<div id="page" class="site">
    <main id="main" class="site-main">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                the_title('<h2>', '</h2>');
                the_content();
            }
        } else {
            echo '<p>No content found.</p>';
        }
        ?>
    </main>
</div>
<?php get_footer(); ?>