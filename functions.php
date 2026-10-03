<?php
// 1ページ当たりに表示する写真の数
$POSTPERPAGE = 24;
// 写真表示のインターバル
$PHOTOINTERVAL = 500;
// 写真を表示させるアニメーション時間
$PHOTODURATION = 400;
$PHOTODURATION_CSS = '0.4s';

// すべてのアイキャッチ画像の有効化
add_theme_support('post-thumbnails');
// ブロック用CSSを有効化する
add_theme_support('wp-block-styles');
// 埋め込み要素のレスポンシブスタイルを適用
add_theme_support('respnsive-embeds');
// 幅広・全幅のスタイルに適応させる
add_theme_support('align-wide');

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

// 高さ360px 幅360pxの新しい画像サイズを定義
add_image_size('custom-360x360', 360, 360, true);
add_image_size('custom-2000x2000', 2000, 2000, false);

// すべてのアイキャッチ画像の有効化
add_theme_support('post-thumbnails');

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
  if ((!is_admin() && $query->is_main_query()) && (($query->is_search()) || ($query->is_tag()))) {
    global $POSTPERPAGE;
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
    $query->set('posts_per_page', $POSTPERPAGE);
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
add_action('pre_get_posts', 'custom_search_query');
