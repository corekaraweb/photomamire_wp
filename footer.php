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
        <span class="close">×</span>
        <a class="single" href=""><img src="" alt=""></a>
        <div class="bottom">
          <div class="taglist"></div>
        </div>
      </div>
    </div>
  </div>
</div>
<script>
  // 初期化
  let lastY = 0;
  let entryHeight;
  let entriesElement;
  let entries;
  let tops;

  // 慣性スクロール用の状態
  let velocity = 70;
  let animating = false;
  const friction = 0.8; // 1に近いほど慣性が長く続く
  const maxVelocity = 100; // 一度のホイール操作で乗る最大速度

  // タップ時の誤動作を防ぐためのスワイプ時の処理を実行しない最小距離
  const minimumDistance = 30;
  // スワイプ開始時の座標
  let startX = 0;
  let startY = 0;
  // スワイプ終了時の座標
  let endX = 0;
  let endY = 0;
  // スワイプ終端で慣性に渡す直近の移動量
  let lastSwipeDeltaY = 30;
</script>
<?php wp_footer(); ?>
</body>

</html>