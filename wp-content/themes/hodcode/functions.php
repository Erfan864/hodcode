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
  add_theme_support('title-tag');
});

/* function create_product_post_type()
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
add_action('init', 'create_product_post_type'); */
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
    // checks
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
    if (!isset($_POST[$fieldName . '_nonce_field'])) return;
    if (!wp_verify_nonce($_POST[$fieldName . '_nonce_field'], $fieldName . '_nonce')) return;
    if (!current_user_can('edit_post', $post_id)) return;
    // save
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

add_action('pre_get_posts', function ($query) {
  if ($query->is_home() && $query->is_main_query() && !is_admin()) {
    $query->set('post_type', 'product');
  }
});