<?php get_header(); ?>
<main>
  <div class="container">
    <div class=" contents">
      <div class="contents_inner">
        <div class="photolist">
          <div class="center">
            <?php
            global $wp_query;
            $paged = get_query_var('paged') ? get_query_var('paged') : 1;
            $max_page = $wp_query->max_num_pages;
            $total_count = $wp_query->found_posts;
            if ($wp_query->have_posts()):
              echo '<div class="entries">';
              while ($wp_query->have_posts()): $wp_query->the_post();
            ?>
                <?php include(locate_template('template/photocontent.php')); ?>
            <?php
              endwhile;
              echo "</div>";
            else:
              include(locate_template('template/nosearchcontent.php'));
            endif;
            ?>
            <?php
            wp_reset_postdata();
            ?>
          </div>
        </div>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>