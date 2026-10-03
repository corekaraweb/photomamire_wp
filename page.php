<?php get_header(); ?>
<main>
  <div class="container">
    <div class="contents">
      <div class="contents_inner">
        <div class="photolist single">
          <div class="entry_body">
            <?php
            if (have_posts()): while (have_posts()): the_post();
            ?>
            <?php the_content();?>
            <?php
              endwhile;
            endif;
            ?>
        </div>
      </div>
    </div>
  </div>
</main>
<?php get_footer(); ?>