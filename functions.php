<?php
// 1ページ当たりに表示する写真の数
$POSTPERPAGE = my_get_post_per_page();

function my_theme_setup()
{
  // すべてのアイキャッチ画像の有効化
  add_theme_support('post-thumbnails');
  // ブロック用CSSを有効化する
  add_theme_support('wp-block-styles');
  // 埋め込み要素のレスポンシブスタイルを適用
  add_theme_support('respnsive-embeds');
  // 幅広・全幅のスタイルに適応させる
  add_theme_support('align-wide');

  // 高さ360px 幅360pxの新しい画像サイズを定義
  add_image_size('custom-360x360', 360, 360, true);
  add_image_size('custom-2000x2000', 2000, 2000, false);
}
add_action('after_setup_theme', 'my_theme_setup');

// テーマカスタマイザーの追加
function my_customize($wp_customize)
{
  $wp_customize->add_panel(
    'my_panel',
    array(
      'title'    => '写真まみれカスタマイズ',
      'priority' => 1,
    )
  );

  $wp_customize->add_section(
    'my_section',
    array(
      'title'    => '投稿の設定',
      'panel'    => 'my_panel',
      'priority' => 1,
    )
  );

  // 1ページあたりに表示する写真数
  $wp_customize->add_setting(
    'my_post_per_page',
    array(
      'default'           => 16,
      'sanitize_callback' => 'absint',
      'transport'         => 'postMessage',
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'post_per_page',
      array(
        'label'       => '1ページあたりの写真数',
        'section'     => 'my_section',
        'settings'    => 'my_post_per_page',
        'priority'    => 1,
        'type'        => 'number',
        'input_attrs' => array(
          'min'  => 1,
          'step' => 1,
        ),
      )
    )
  );

  // 写真表示アニメーションの間隔 =====================================================
  $wp_customize->add_setting(
    'my_photo_delay',
    array(
      'default'           => 300,
      'sanitize_callback' => 'absint',
      'transport'         => 'postMessage',
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'photo_delay',
      array(
        'label'       => '写真表示アニメーションの間隔',
        'section'     => 'my_section',
        'settings'    => 'my_photo_delay',
        'priority'    => 1,
        'type'        => 'number',
        'input_attrs' => array(
          'min'  => 100,
          'step' => 100,
        ),
      )
    )
  );

  // 写真表示アニメーションの時間  =====================================================
  $wp_customize->add_setting(
    'my_photo_interval',
    array(
      'default'           => 500,
      'sanitize_callback' => 'absint',
      'transport'         => 'postMessage',
    )
  );
  $wp_customize->add_control(
    new WP_Customize_Control(
      $wp_customize,
      'photo_interval',
      array(
        'label'       => '写真表示アニメーションの時間 ',
        'section'     => 'my_section',
        'settings'    => 'my_photo_interval',
        'priority'    => 1,
        'type'        => 'number',
        'input_attrs' => array(
          'min'  => 100,
          'step' => 100,
        ),
      )
    )
  );
}
add_action('customize_register', 'my_customize');

function my_get_post_per_page()
{
  return (int) get_theme_mod('my_post_per_page', 16);
}
function my_get_photo_delay()
{
  return (int) get_theme_mod('my_photo_delay', 300);
}
function my_get_photo_interval()
{
  return (int) get_theme_mod('my_photo_interval', 500);
}

// body_classに固定ページのスラッグを追加
function pagename_class($classes = '')
{
  if (is_page()) {
    $page = get_page(get_the_ID());
    $classes[] = 'page-' . $page->post_name;
  }
  return $classes;
}
add_filter('body_class', 'pagename_class');

// reset.cssとstyle.cssをテーマに読み込む
function theme_enqueue_styles()
{
  $random_version = rand();
  wp_enqueue_style('reset', get_template_directory_uri() . '/css/reset.css', array(), null);
  wp_enqueue_style('style', get_template_directory_uri() . '/css/style.css', array(), $random_version);
  wp_enqueue_script('my-theme-script', get_template_directory_uri() . '/js/script.js', array(), $random_version, array('in_footer' => true, 'strategy' => 'defer',));
}
add_action('wp_enqueue_scripts', 'theme_enqueue_styles');

// 余計なサイズの画像を作らない設定
function disable_image_sizes($new_sizes)
{
  unset($new_sizes['thumbnail']);
  unset($new_sizes['medium']);
  unset($new_sizes['large']);
  unset($new_sizes['medium_large']);
  unset($new_sizes['1536x1536']);
  unset($new_sizes['2048x2048']);
  return $new_sizes;
}
add_filter('intermediate_image_sizes_advanced', 'disable_image_sizes');
add_filter('big_image_size_threshold', '__return_false');

// 投稿一覧(管理画面)にアイキャッチ画像のカラムを追加＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝＝
// カラムを追加
function add_posts_columns_thumbnail($columns)
{
  $columns = array_slice($columns, 0, 1, true)
    + array('thumbnail' => 'アイキャッチ')
    + array_slice($columns, 1, null, true);
  return $columns;
}
add_filter('manage_posts_columns', 'add_posts_columns_thumbnail');

// アイキャッチ画像を表示
function add_posts_columns_thumbnail_row($column_name, $post_id)
{
  if ($column_name == 'thumbnail') {
    if (has_post_thumbnail($post_id)) {
      echo get_the_post_thumbnail($post_id, array(160, 160));
    } else {
      echo '—';
    }
  }
}
add_action('manage_posts_custom_column', 'add_posts_columns_thumbnail_row', 10, 2);

// サムネイル用にカラムのスタイル調整（任意）
function posts_columns_thumbnail_style()
{
  echo '<style>
    .column-thumbnail { width: 160px; text-align: center; }
    .column-thumbnail img { max-width: 160px; height: auto; }
  </style>';
}
add_action('admin_head', 'posts_columns_thumbnail_style');

function custom_search_query($query)
{
  global $POSTPERPAGE;
  if (!is_admin() && $query->is_main_query()) {
    // 写真の表示数を設定
    $query->set('posts_per_page', $POSTPERPAGE);
    if ($query->is_search() || ($query->is_tag())) {
      // 検索結果またはタグアーカイブ
      $paged = get_query_var('paged') ? get_query_var('paged') : 1;
      // タグによる絞り込み検索を適切に処理
      $selected_tags = array();
      if (isset($_GET['filter_tag'])) {
        if (is_array($_GET['filter_tag'])) {
          foreach ($_GET['filter_tag'] as $tag_slug) {
            if (!empty($tag_slug)) {
              $selected_tags[] = sanitize_title($tag_slug);
            }
          }
        } elseif (!empty($_GET['filter_tag'])) {
          $selected_tags[] = sanitize_title($_GET['filter_tag']);
        }
      }
      $query->set('post_type', 'post');
      $query->set('paged', $paged);
      $query->set('s', '');
      if (!empty($selected_tags)) {
        $condition = $_GET['condition'];
        if ($condition == 'or') {
          $query->set('tag_slug__in', $selected_tags);
        } else {
          $query->set('tag_slug__and', $selected_tags);
        }
      }
    }
  }
}
add_action('pre_get_posts', 'custom_search_query');
