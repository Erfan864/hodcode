<?php get_header(); ?>

<div id="page" class="site">
    <main id="main" class="site-main">
        <div class="max-w-screen-lg my-8 mx-auto text-gray-600">
            <ul class="flex flex-wrap gap-2">
                <?php
                $current_term = get_queried_object();
                $default_classes = 'px-3 py-2 rounded-full border bg-white border-gray-600 hover:bg-[#67a2fa] hover:border-[#67a2fa] hover:text-white';
                $active_classes = 'px-3 py-2 rounded-full border border-[#428eff] bg-[#428eff] text-white';
                $all_products_link = get_post_type_archive_link('product');
                if ($all_products_link) {
                    $all_products_class = (is_post_type_archive('product')) ? $active_classes : $default_classes;
                    echo '<a class="' . esc_attr($all_products_class) . '" href="' . esc_url($all_products_link) . '"><li>همه محصولات</li></a>';
                }
                $product_categories = get_terms([
                    'taxonomy'   => 'product_category',
                    'hide_empty' => true,
                ]);

                if (!empty($product_categories) && !is_wp_error($product_categories)) {
                    foreach ($product_categories as $category) {
                        $term_link = get_term_link($category);
                        if (!is_wp_error($term_link)) {
                            $category_class = (isset($current_term->term_id) && $current_term->term_id === $category->term_id) ? $active_classes : $default_classes;
                            echo '<a class="' . esc_attr($category_class) . '" href="' . esc_url($term_link) . '"><li>' . esc_html($category->name) . '</li></a>';
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <div class="max-w-screen-lg my-8 mx-6 lg:mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            if (have_posts()) {
                while (have_posts()) {
                    the_post();
                    $price = get_post_meta(get_the_ID(), 'price', true);
                    $finalPrice = get_post_meta(get_the_ID(), 'final_price', true);
            ?>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['class' => 'w-full object-cover rounded-md mb-4']); ?>
                        </a>
                        <div>
                            <h3 class="text-sm font-bold"><?php the_title(); ?></h3>
                        </div>
                        <div class="text-xs text-gray-600 my-4 font-base">
                            <?php
                            $terms = get_the_terms(get_the_ID(), 'product_category');
                            if ($terms && !is_wp_error($terms)) :
                                foreach ($terms as $term) {
                                    $term_link = get_term_link($term);
                                    $term_name = $term->name;
                            ?>
                                    <a href="<?= esc_url($term_link) ?>"><?= esc_html($term_name) ?></a>
                            <?php
                                }
                            endif;
                            ?>
                        </div>
                        <div class="flex flex-row text-xs">
                            <?php
                            if (!empty($price) && !empty($finalPrice) && (int)$price > (int)$finalPrice) {
                                $discount = ((int)$price - (int)$finalPrice) / (int)$price * 100;
                            ?>
                                <span class="flex-none rounded-xl bg-red-600 text-white px-2 py-1">
                                    <?= convert_to_persian_number(round($discount)) ?>%
                                </span>
                            <?php } ?>
                            <div class="flex flex-1 justify-end items-center gap-2">
                                <span class="text-gray-500 line-through">
                                    <?php if (!empty($price) && !empty($finalPrice) && (int)$price > (int)$finalPrice) { ?>
                                        <?= convert_to_persian_number(number_format((int)$price)); ?>
                                    <?php } ?>
                                </span>
                                <span><?= convert_to_persian_number(number_format((int)$finalPrice)); ?></span>
                                <span>تومان</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-1 *:flex-1 *:text-center mt-4 items-center font-base text-sm">
                            <a href="<?php the_permalink(); ?>" class="inline-block bg-[#7092c5] text-white px-4 py-2 rounded">
                                افزودن به سبد
                            </a>
                            <a href="<?php the_permalink(); ?>" class="inline-block bg-[#edeeef] text-[#436070] px-4 py-2 rounded">
                                مشاهده جزئیات
                            </a>
                        </div>
                    </div>
            <?php
                }
            } else {
                echo '<p>No products found.</p>';
            }
            ?>
        </div>

        <div class="max-w-screen-lg my-8 mx-auto text-gray-600">
            <ul class="flex justify-center gap-2">

                <?php
                global $wp_query;
                $pagination_args = array(
                    'base'      => str_replace(999999999, '%#%', esc_url(get_pagenum_link(999999999))),
                    'format'    => '?paged=%#%',
                    'current'   => max(1, get_query_var('paged')),
                    'total'     => $wp_query->max_num_pages,
                    'prev_text' => 'قبل',
                    'next_text' => 'بعد',
                    'mid_size'  => 2,
                );
                echo paginate_links($pagination_args);
                ?>
            </ul>
        </div>

    </main>
</div>
<?php get_footer(); ?>