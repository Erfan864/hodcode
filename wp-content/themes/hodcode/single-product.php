<?php get_header(); ?>
<div id="page" class="site">
    <main id="main" class="max-w-screen-lg my-8 mx-6 lg:mx-auto flex gap-5 font-base">
        <?php
        if (have_posts()) {
            while (have_posts()) {
                the_post();
                $price = get_post_meta(get_the_ID(), 'price', true);
                $finalPrice = get_post_meta(get_the_ID(), 'final_price', true);
        ?>
                <div class="basis-1/4 h-max bg-white border border-gray-300 px-6 py-5 rounded-xl flex flex-col gap-8">
                    <?php
                    $terms = get_the_terms(get_the_ID(), 'product_category');
                    if ($terms && ! is_wp_error($terms)) :
                        $term_ids = array();
                        foreach ($terms as $term) {
                            $term_ids[] = $term->term_id;
                        }
                        $args = array(
                            'post_type'      => 'product',
                            'post__not_in'   => array(get_the_ID()),
                            'posts_per_page' => 3,
                            'tax_query'      => array(
                                array(
                                    'taxonomy' => 'product_category',
                                    'field'    => 'term_id',
                                    'terms'    => $term_ids,
                                ),
                            ),
                        );
                        $related_products_query = new WP_Query($args);
                        if ($related_products_query->have_posts()) : ?>
                            <h3 class="text-lg">محصولات مشابه</h3>
                            <ul class="flex flex-col gap-2 divide-y divide-gray-300">
                                <?php while ($related_products_query->have_posts()) : $related_products_query->the_post(); ?>
                                    <li class="py-3">
                                        <a class="flex items-center" href="<?php the_permalink(); ?>">
                                            <?= the_post_thumbnail('medium', ['class' => 'w-12 h-12 object-cover rounded-md'])?>
                                            <span class="text-sm text-gray-500">
                                                <?= the_title() ?>
                                            </span>
                                        </a>
                                    </li>
                                <?php endwhile; ?>
                            </ul>
                    <?php endif;
                        wp_reset_postdata();
                    endif;
                    ?>
                </div>
                <div class="basis-3/4 flex flex-col gap-4">
                    <a class="flex justify-center bg-white w-full rounded-2xl overflow-hidden" href="<?php the_permalink(); ?>">
                        <?php the_post_thumbnail('medium', ['class' => ' h-full object-cover rounded-md mb-4']); ?>
                    </a>
                    <div class="w-full flex flex-row font-base text-lg items-center">
                        <div><?= the_title() ?></div>
                        <div class="flex flex-1 justify-end items-center gap-2">
                            <?php
                            if (!empty($price) && !empty($finalPrice) && (int)$price > (int)$finalPrice) {
                                $discount = ((int)$price - (int)$finalPrice) / (int)$price * 100;
                            ?>
                                <span class="flex-none text-sm rounded-sm bg-[#d90000] text-white px-2.5 py-0.5">
                                    <?= convert_to_persian_number(round($discount)) ?>%
                                </span>
                            <?php } ?>
                            <span class="text-base text-gray-500 line-through">
                                <?php if (!empty($price) && !empty($finalPrice) && (int)$price > (int)$finalPrice) { ?>
                                    <?= convert_to_persian_number(number_format((int)$price)); ?>
                                <?php } ?>
                            </span>
                            <span class="text-xl font-bold"><?= convert_to_persian_number(number_format((int)$finalPrice)) ?></span>
                            <span class="text-sm text-gray-500">تومان</span>
                        </div>
                    </div>
                    <span class="font-base text-justify text-gray-500">
                        <?= the_content() ?>
                    </span>
                    <a href="<?php the_permalink(); ?>" class="w-max flex items-center gap-2 bg-[#7092c5] text-white text-center px-10 py-2 rounded-xl">
                        <i class="ri-shopping-cart-2-line text-2xl"></i>
                        افزودن به سبد
                    </a>
                    <?php
                    $all_empty = true;
                    foreach ($custom_detailes_fields as $field_name => $field_label) {
                        if (! empty(get_post_meta(get_the_ID(), $field_name, true))) {
                            $all_empty = false;
                            break;
                        }
                    }
                    if (!$all_empty) {
                    ?>
                        <div class="flex flex-col gap-4">
                            <span class="text-lg">ویژگی ها</span>
                            <ul class="list-disc pr-8 flex flex-col gap-4">
                                <?php
                                foreach ($custom_detailes_fields as $field_name => $field_label) {
                                    if (!empty(get_post_meta(get_the_ID(), $field_name, true))) {
                                ?>
                                        <li>
                                            <span class="text-gray-500"><?= $field_label ?>:</span>
                                            <span class="font-bold"><?= get_post_meta(get_the_ID(), $field_name, true); ?></span>
                                        </li>
                                <?php
                                    }
                                }
                                ?>
                            </ul>
                        </div>
                    <?php
                    }
                    ?>
                </div>
        <?php
            }
        } else {
            echo '<p>No product found.</p>';
        }
        ?>
    </main>
</div>
<?php get_footer(); ?>