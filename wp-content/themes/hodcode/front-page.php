<?php get_header(); ?>
<div id="page" class="site">
    <main id="main" class="site-main">
        <div class="max-w-screen-lg my-8 mx-auto text-gray-600">
            <ul class="flex gap-2">
                <li><a class="px-3 py-2 rounded-full border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">همه محصولات</a></li>
                <li><a class="px-3 py-2 rounded-full border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">دوربین</a></li>
                <li><a class="px-3 py-2 rounded-full border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">کنسول بازی</a></li>
                <li><a class="px-3 py-2 rounded-full border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">هدفون</a></li>
                <li><a class="px-3 py-2 rounded-full border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">وسایل گیمیگ</a></li>
                <li><a class="px-3 py-2 rounded-full border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">هدست</a></li>
            </ul>
        </div>
        <div class="max-w-screen-lg my-8 mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            <?php
            // Check if there are posts to display
            if (have_posts()) {
                // Start the main WordPress loop
                while (have_posts()) {
                    the_post(); // Set up the post data for the current product
                    $price = get_post_meta(get_the_ID(), 'price', true);
                    $finalPrice = get_post_meta(get_the_ID(), 'final_price', true);
            ?>
                    <div class="bg-white rounded-lg shadow-md p-4">
                        <a href="<?php the_permalink(); ?>">
                            <?php the_post_thumbnail('medium', ['class' => 'w-full object-cover rounded-md mb-4']); ?>
                        </a>
                        <h3 class=" font-bold"><?php the_title(); ?></h3>
                        <div class="text-gray-600 my-4 font-vazir"><?php the_excerpt(); ?></div>
                        <div class="flex justify-between font-vazir text-sm">
                            <?php
                            // Ensure both prices exist and the final price is lower
                            if (!empty($price) && !empty($finalPrice) && (int)$price > (int)$finalPrice) {
                                $discount = ((int)$price - (int)$finalPrice) / (int)$price * 100;
                            ?>
                                <span class="rounded-xl text-sm bg-red-600 text-white px-2 py-1">
                                    <?= round($discount) ?>%
                                </span>
                            <?php } ?>
                            <div class="flex items-center gap-2">
                                <?php if (!empty($price)) { ?>
                                    <span class="text-gray-500 line-through"><?= number_format((int)$price) ?></span>
                                <?php } ?>
                                <span><?= number_format((int)$finalPrice) ?></span>
                                <span>تومان</span>
                            </div>
                        </div>
                        <div class="flex flex-wrap gap-1 *:flex-1 *:text-center mt-4 items-center font-vazir">
                            <a href="<?php the_permalink(); ?>" class="inline-block bg-[#7092c5] text-white px-4 py-2 rounded">
                                افزودن به سبد
                            </a>
                            <a href="<?php the_permalink(); ?>" class="inline-block bg-[#edeeef] text-[#436070] px-4 py-2 rounded">
                                مشاهده جزئیات
                            </a>
                        </div>
                    </div>
            <?php
                } // End the while loop
            } else {
                echo '<p>No products found.</p>';
            }
            ?>
        </div>
        <div class="max-w-screen-lg my-8 mx-auto text-gray-600">
            <ul class="flex justify-center gap-2">
                <li><a class="px-3 py-2 rounded-xl border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">قبل</a></li>
                <li><a class="px-3 py-2 rounded-xl border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">1</a></li>
                <li><a class="px-3 py-2 rounded-xl border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">2</a></li>
                <li><a class="px-3 py-2 rounded-xl border bg-white border-gray-600 hover:bg-[#428eff] hover:border-[#428eff] hover:text-white" href="">بعد</a></li>
            </ul>
        </div>
    </main>
</div>
<?php get_footer(); ?>