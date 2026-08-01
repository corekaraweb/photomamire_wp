<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Cache-Control" content="no-cache">
  <link rel="icon" href="<?php echo get_template_directory_uri(); ?>/favicon.png">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Noto+Sans+JP:wght@100..900&family=RocknRoll+One&display=swap" rel="stylesheet">
  <?php wp_head(); ?>
  <script src="<?php echo get_template_directory_uri() ?>/js/script.js" defer></script>
</head>

<body <?php body_class(); ?>>
  <header class="header">
    <div class="header_inner">
      <h1 class="title"><a href="<?php echo home_url(); ?>/">写真まみれ</a></h1>
    </div>
  </header>
  <nav class="global_nav">
    <div class="button" id="sidebar-btn"><img style="" src="<?php echo get_template_directory_uri(); ?>/images/Walkingburger.svg"></div>
  </nav>
  <div id="sidebar" class="sidebar">
    <div class="sidebar_inner">
      <h3 class="sidebar_title">メニュー</h3>
      <ul class="sidebar_menu">
        <li><a href="<?php echo home_url(); ?>/profile/">プロフィール</a></li>
        <li><a href="<?php echo home_url(); ?>/privacy/">プライバシーポリシー</a></li>
        <li><a href="<?php echo home_url(); ?>/contact/">お問い合わせ</a></li>
      </ul>
      <h3 class="sidebar_title">タグ検索</h3>
      <div class="search">
        <form method="get" action="<?php echo home_url(); ?>/">
          <input type="hidden" name="s" value="">
          <?php
          $tags = get_tags();
          if ($tags) {
            $tag_slug = $_GET['filter_tag'] ?? '';
            $condition = $_GET['condition'] ?? 'or';
            echo '<div id="tag-checkbox-group">';
            foreach ($tags as $tag) {
              $checked = '';
              if (is_tag()) {
                $posttags = get_the_tags();
                if ($tag->slug == $posttags[0]->slug) {
                  $checked = 'checked';
                }
              }
              if ((isset($_GET['filter_tag']) && is_array($_GET['filter_tag']) && in_array($tag->slug, $_GET['filter_tag'], true)) or ($tag_slug == $tag->slug)) {
                $checked = 'checked';
              }
              echo '<label>';
              echo '<input type="checkbox" name="filter_tag[]" value="' . esc_attr($tag->slug) . '" ' . $checked . '>';
              echo esc_html($tag->name);
              echo ' (' . esc_html($tag->count) . ')';
              echo '</label>';
            }
            echo '</div>';
          }
          ?>
          <p><span>条件：</span>
            <select name="condition">
              <?php
              if ($condition == 'or') {
              ?>
                <option value="or" selected>OR検索</option>
                <option value="and">AND検索</option>
              <?php
              } else {
              ?>
                <option value="or">OR検索</option>
                <option value="and" selected>AND検索</option>
              <?php
              }
              ?>
            </select>
          </p>
          <button type="submit">検索</button>
        </form>
      </div>
    </div>
  </div>