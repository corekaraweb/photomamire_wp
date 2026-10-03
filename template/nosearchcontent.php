<div class="entry_body nosearch">
  <h2>条件に合う写真が見つかりませんでした。</h2>
  <?php
  // GETメソッドで設定されているtag_slug一覧を取得
  $taglist = 'タグ：';
  $tag_html = '';
  if (isset($_GET['filter_tag']) && is_array($_GET['filter_tag'])) {
    $tag_names = array();
    $tag_html = '';
    foreach ($_GET['filter_tag'] as $slug) {
      $tag = get_term_by('slug', $slug, 'post_tag');
      if ($tag && !is_wp_error($tag)) {
        $tag_html .= '<span>#' . $tag->name . '</span>';
        $tag_names[] = $tag->name;
      } else {
        $tag_html .= '<span>#' . $slug . '</span>';
        $tag_names[] = urldecode($slug); // fallback in case not found
      }
    }
    $taglist = $tag_html;
  } elseif (isset($_GET['filter_tag'])) { // 万が一単一値で渡ってきた場合
    $tag_slug = urldecode($_GET['filter_tag']);
    $tag = get_term_by('slug', $tag_slug, 'post_tag');
    $taglist .= $tag->name;
    $tag_html .= '<span>#'  . $tag->name . '</span>';
  }
  ?>
  <div class="condition">
    <p>タグ：<?php echo $taglist; ?> に合う写真が見つかりませんでした。</p>
  </div>
  <div class="search">
    <h3>条件を変えて再度検索する。</h3>
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
          // タグ
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
  <h3>最新の写真6件</h3>
  <div class="recent_entries">
    <?php
    $paged = get_query_var('paged') ? get_query_var('paged') : 1;
    $args = array(
      'post_type' => 'post',
      'posts_per_page' => 6,
      'paged' => $paged,
    );
    $myposts = new WP_Query($args);
    if ($myposts->have_posts()): while ($myposts->have_posts()): $myposts->the_post();
        $thumbnail_url = '';
        $postid = get_the_ID();
        if (has_post_thumbnail()) {
          $thumbnail_url = get_the_post_thumbnail_url($postid, 'custom-2000x2000');
        } else {
          $thumbnail_url = get_template_directory_uri() . '/images/default_noimage.png';
        }
    ?>
        <div class="recent">
          <div class="recent_inner">
            <a href="<?php the_permalink(); ?>">
              <img src="<?php echo esc_attr($thumbnail_url); ?>">
            </a>
            <p><?php the_title(); ?> (<?php the_time('y.m.d'); ?>) </p>
          </div>
        </div>
    <?php
      endwhile;
    endif;
    ?>
  </div>
</div>