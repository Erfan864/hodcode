<?php
function hodcode_enqueue_styles()
{
  wp_enqueue_style(
    'hodcode-style', // Handle name
    get_stylesheet_uri(), // This gets style.css in the root of the theme
  );
  wp_enqueue_style('mytheme-fonts', get_template_directory_uri() . '/style.css', array(), null);
  wp_enqueue_style(
    'google-fonts',
    'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart',
    array(),
    null
  );
  wp_enqueue_script(
    'tailwind', // Handle name
    "https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4", // This gets style.css in the root of the theme

  );
}
add_action('wp_enqueue_scripts', 'hodcode_enqueue_styles');

add_action(
  "after_setup_theme",
  function () {
    register_nav_menus([
      "header-right" => "Header menu right",
      "header-left" => "Header menu left",
      // "footer" => "Footer menu",
    ]);
  }
);
add_action("init", function () {
  add_theme_support('custom-logo', array(
    'height'      => 100,
    'width'       => 100,
    'flex-height' => false,
    'flex-width'  => false,
  ));
});

add_theme_support('post-thumbnails');

add_action('after_setup_theme', function () {
  add_theme_support('post-thumbnails', array('post', 'page', 'product'));
});

function create_product_post_type()
{
  $labels = array(
    'name'                  => 'محصولات',
    'singular_name'         => 'محصول',
    'menu_name'             => 'محصولات',
    'add_new_item'          => 'افزودن محصول جدید',
    'edit_item'             => 'ویرایش محصول',
  );
  $args = array(
    'labels'                => $labels,
    'public'                => true,
    'has_archive'           => true,
    'rewrite'               => array('slug' => 'products'),
    'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
  );
  register_post_type('product', $args);
}
add_action('init', 'create_product_post_type');

function display_product_grid_shortcode()
{
  ob_start();

  $args = array(
    'post_type'      => 'product',
    'posts_per_page' => -1,
  );
  $products_query = new WP_Query($args);

  if ($products_query->have_posts()) :
?>
    <div class="max-w-screen-lg mx-auto grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
      <?php while ($products_query->have_posts()) : $products_query->the_post(); ?>
        <div class="bg-white rounded-lg shadow-md p-4">
          <a href="<?php the_permalink(); ?>">
            <?php the_post_thumbnail('medium', ['class' => 'w-full object-cover rounded-md mb-4']); ?>
          </a>
          <h3 class="text-xl font-bold"><?php the_title(); ?></h3>
          <div class="text-gray-600 my-2 font-vazir"><?php the_excerpt(); ?></div>
            <?php
            $price = get_post_meta(get_the_ID(), '_product_price', true);
            $sale_price = get_post_meta(get_the_ID(), '_product_sale_price', true);
            $discount_percent = get_post_meta(get_the_ID(), '_product_discount_percent', true);
            ?>
          <div class="flex justify-between font-vazir">
            <span class="rounded-xl bg-red-600 text-white px-2 py-1"><?= $discount_percent . '%' ?></span>
            <div>
              <span class="text-gray-500 line-through"><?= number_format($price) ?></span>
              <span><?= number_format($sale_price) ?></span>
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
      <?php endwhile; ?>
    </div>
  <?php
    wp_reset_postdata();
  else :
    echo '<p>هیچ محصولی یافت نشد.</p>';
  endif;

  return ob_get_clean();
}
add_shortcode('product_grid', 'display_product_grid_shortcode');

function my_custom_product_meta_boxes()
{
  add_meta_box(
    'product_extra_fields',       // ID
    'اطلاعات قیمت محصول',         // عنوان باکس
    'product_extra_fields_callback', // تابع نمایش
    'product',                    // پست تایپ (اگر از WooCommerce استفاده نمی‌کنی، همین 'product' یا نام CPT خودت)
    'normal',                     // موقعیت
    'high'                        // اولویت
  );
}
add_action('add_meta_boxes', 'my_custom_product_meta_boxes');

function product_extra_fields_callback($post)
{
  $price = get_post_meta($post->ID, '_product_price', true);
  $sale_price = get_post_meta($post->ID, '_product_sale_price', true);
  $discount_percent = get_post_meta($post->ID, '_product_discount_percent', true);
  ?>
  <label>قیمت:</label><br>
  <input type="number" name="product_price" value="<?php echo esc_attr($price); ?>" style="width:100%;"><br><br>

  <label>قیمت تخفیف‌خورده:</label><br>
  <input type="number" name="product_sale_price" value="<?php echo esc_attr($sale_price); ?>" style="width:100%;"><br><br>

  <label>درصد تخفیف:</label><br>
  <input type="number" name="product_discount_percent" value="<?php echo esc_attr($discount_percent); ?>" style="width:100%;"><br><br>
<?php
}

function save_product_extra_fields($post_id)
{
  if (array_key_exists('product_price', $_POST)) {
    update_post_meta($post_id, '_product_price', sanitize_text_field($_POST['product_price']));
  }
  if (array_key_exists('product_sale_price', $_POST)) {
    update_post_meta($post_id, '_product_sale_price', sanitize_text_field($_POST['product_sale_price']));
  }
  if (array_key_exists('product_discount_percent', $_POST)) {
    update_post_meta($post_id, '_product_discount_percent', sanitize_text_field($_POST['product_discount_percent']));
  }
}
add_action('save_post', 'save_product_extra_fields');