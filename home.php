<?php get_header(); ?>
<main>
  <div class="container">
    <div class="contents">
      <div class="contents_inner">
        <div class="photolist">
          <div class="center">
            <div class="entries">
              <?php
              $paged = get_query_var('paged') ? get_query_var('paged') : 1;
              $args = array(
                'post_type' => 'post',
                'posts_per_page' => $POSTPERPAGE,
                'paged' => $paged,
              );
              $myposts = new WP_Query($args);
              $max_page = $myposts->max_num_pages;
              $total_count = $myposts->found_posts;
              if ($myposts->have_posts()): while ($myposts->have_posts()): $myposts->the_post();
              ?>
                  <?php include(locate_template('template/photocontent.php')); ?>
              <?php
                endwhile;
              endif;
              ?>
            </div>
          </div>
          <?php
          wp_reset_postdata();
          ?>
        </div>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>