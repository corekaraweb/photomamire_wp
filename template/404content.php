<div class="entry_body notfound">
  <h2>お探しのページが見つかりませんでした</h2>
  <p>URLが変更されたか、記事が削除された可能性があります。お手数ですが、トップページに戻るか、サイドバーからお探しください。</p>
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
  <h3>メニュー</h3>
  <div class="txtBlock">
    <ul>
      <li><a href="<?php echo home_url(); ?>">トップページ</a></li>
      <li><a href="<?php echo home_url(); ?>/profile/">プロフィール</a></li>
      <li><a href="<?php echo home_url(); ?>/privacy/">プライバシーポリシー</a></li>
      <li><a href="<?php echo home_url(); ?>/contact/">お問い合わせ</a></li>
    </ul>
  </div>
</div>