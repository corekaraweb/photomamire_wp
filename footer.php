<?php
global $max_page;
global $total_count;
$taglist = '';
if (is_search()) {
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
    // $taglist .= implode(', ', $tag_names);
    $taglist = $tag_html;
  } elseif (isset($_GET['filter_tag'])) { // 万が一単一値で渡ってきた場合
    $tag_slug = urldecode($_GET['filter_tag']);
    $tag = get_term_by('slug', $tag_slug, 'post_tag');
    $taglist .= $tag->name;
    $tag_html .= '<span>#'  . $tag->name . '</span>';
  }
}
if (is_tag()) {
  $tag = get_queried_object();
  if ($tag && isset($tag->name)) {
    $taglist = 'タグ：<span>' . $tag->name . '</span>';
  }
}
?>
<div class="pagenavi">
  <?php
  if (is_home() || is_search() || is_tag()) {
    if ($taglist !== 'タグ：') {
      echo '<p>全：' . $total_count . "写真<div class='taglist'>" . $taglist . "</div>";
    } else {
      echo '<p>全：' . $total_count . "写真";
    }
  }
  ?>
  <?php
  global $myposts;
  if (function_exists('wp_pagenavi')):
    if (is_home()) {
      wp_pagenavi(array('query' => $myposts));
    } else {
      wp_pagenavi();
    }
  endif;
  ?>
</div>
<div id="overlay">
  <div class="inner">
    <div class="photo">
      <div class="photo_inner">
        <div class="top">
          <p class="title"></p>
        </div>
        <a class="single" href=""><img src="" alt=""></a>
        <div class="bottom">
          <div class="taglist"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php wp_footer(); ?>
</body>

</html>