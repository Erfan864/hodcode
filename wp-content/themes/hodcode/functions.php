<?php
function hodcode_enqueue_styles()
{
  wp_enqueue_style(
    'hodcode-style',
    get_stylesheet_uri(),
  );
  wp_enqueue_style('mytheme-fonts', get_template_directory_uri() . '/style.css', array(), null);
  wp_enqueue_style(
    'google-fonts',
    'https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@24,400,0,0&icon_names=shopping_cart',
    array(),
    null
  );
  wp_enqueue_style(
    'remixicon',
    'https://cdn.jsdelivr.net/npm/remixicon@4.2.0/fonts/remixicon.css',
    array(),
    '4.2.0'
  );
  wp_enqueue_script(
    'tailwind',
    get_template_directory_uri() . '/assets/script/tailwind.js',
    array(),
    '1.0.0',
    true
  );
}
add_action('wp_enqueue_scripts', 'hodcode_enqueue_styles');

add_action(
  "after_setup_theme",
  function () {
    register_nav_menus([
      "header-right" => "Header menu right",
      "header-left" => "Header menu left",
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
  add_theme_support('title-tag');
});

add_action('init', function () {
  register_post_type('product', [
    'labels'                => [
      'name'                  => 'محصولات',
      'singular_name'         => 'محصول',
      'menu_name'             => 'محصولات',
      'add_new_item'          => 'افزودن محصول جدید',
      'edit_item'             => 'ویرایش محصول',
    ],
    'public'                => true,
    'has_archive'           => true,
    'rewrite'               => array('slug' => 'products'),
    'supports'              => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
  ]);
  register_taxonomy('product_category', ['product'], [
    'hierarchical'      => true,
    'labels'            => [
      'name'          => 'دسته‌بندی',
      'singular_name' => 'Product Category'
    ],
    'rewrite'           => ['slug' => 'product-category'],
    'show_in_rest' => true,
  ]);
});

function hodcode_add_custom_field($fieldName, $postType, $title)
{
  add_action('add_meta_boxes', function () use ($fieldName, $postType, $title) {
    add_meta_box(
      $fieldName . '_box',
      $title,
      function ($post) use ($fieldName) {
        $value = get_post_meta($post->ID, $fieldName, true);
        wp_nonce_field($fieldName . '_nonce', $fieldName . '_nonce_field');
        echo '<input type="text" style="width:100%"
         name="' . esc_attr($fieldName) . '" value="' . esc_attr($value) . '">';
      },
      $postType,
      'normal',
      'default'
    );
  });

  add_action('save_post', function ($post_id) use ($fieldName) {
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST[$fieldName . '_nonce_field'])) return;
    if (!wp_verify_nonce($_POST[$fieldName . '_nonce_field'], $fieldName . '_nonce')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    if (isset($_POST[$fieldName])) {
      $san = sanitize_text_field(wp_unslash($_POST[$fieldName]));
      update_post_meta($post_id, $fieldName, $san);
    } else {
      delete_post_meta($post_id, $fieldName);
    }
  });
}

hodcode_add_custom_field('price', 'product', 'قیمت');
hodcode_add_custom_field('final_price', 'product', 'قیمت نهایی');

global $custom_detailes_fields;
$custom_detailes_fields = [
  'sensor_type'                => 'نوع حسگر',
  'sensor_disconnection'       => 'قطع حسگر',
  'ear_placement'              => 'نوع گوشی',
  'connection_type'            => 'نوع اتصال',
  'headphone_type'             => 'نوع هدفون، هدست و هندزفری',
  'noise_canceling_capability' => 'قابلیت نویز کنسلینگ',
  'performance_range'          => 'محدوده عملکرد',
  'frequency_response'          => 'پاسخ فرکانسی',
  'accompanying_items'          => 'اقلام همراه',
  'suitable_for'          => 'مناسب برای',
];

add_action('init', function () use ($custom_detailes_fields) {
  $post_type = 'product';
  foreach ($custom_detailes_fields as $field_name => $field_label) {
    hodcode_add_custom_field($field_name, $post_type, $field_label);
  }
}, 20);

add_action('pre_get_posts', function ($query) {
  if ($query->is_home() && $query->is_main_query() && !is_admin()) {
    $query->set('post_type', 'product');
  }
});

function convert_to_persian_number($number)
{
  $persian_digits = array('۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹');
  $english_digits = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
  $number = str_replace($english_digits, $persian_digits, $number);
  return $number;
}
