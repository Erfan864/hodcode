<?php get_header(); ?>
<div id="page" class="site">
    <main id="main" class="site-main">
        <div class="max-w-screen-lg mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
                $terms = get_terms([
                    'taxonomy' => 'product_category',
                    'hide_empty' => false,
                ]);
            if (have_posts()) {
                while (have_posts()) {
                    foreach ($terms as $term) { ?>
                        <div class="bg-white rounded-lg shadow-md p-4">
                            <a href="<?= $term->term_id ?>">
                                <?php the_post_thumbnail('medium', ['class' => 'w-full object-cover rounded-md mb-4']); ?>
                            </a>
                            <h3 class="text-xl font-bold"><?php the_title(); ?></h3>
                            <div class="text-gray-600 my-2 font-vazir"><?php the_excerpt(); ?></div>
                            <div class="flex justify-between font-vazir">
                                <span class="rounded-xl bg-red-600 text-white px-2 py-1">
                                    <?php
                                    $price = get_post_meta(get_the_ID(), 'price', true);
                                    $finalPrice = get_post_meta(get_the_ID(), 'final_price', true);
                                    echo (($price - $finalPrice) * 100) / $price
                                    ?>%</span>
                                <div>
                                    <span class="text-gray-500 line-through"><?= number_format($price) ?></span>
                                    <span><?= number_format($finalPrice) ?></span>
                                    <span>تومان</span>
                                </div>
                            </div>
                            <div class="flex gap-1 justify-between items-center font-vazir">
                                <a href="<?php the_permalink(); ?>" class="mt-4 inline-block bg-[#7092c5] text-white px-4 py-2 rounded">
                                    افزودن به سبد
                                </a>
                                <a href="<?php the_permalink(); ?>" class="mt-4 inline-block bg-[#edeeef] text-[#436070] px-4 py-2 rounded">
                                    مشاهده جزئیات
                                </a>
                            </div>
                        </div>
            <?php
                    }
                }
            } else {
                echo '<p>No content found.</p>';
            }
            ?>
        </div>
    </main>
</div>
<?php get_footer(); ?>