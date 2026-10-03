<?php
$thumbnail_url = '';
$taghtml = '';
$postid = get_the_ID();
if (has_post_thumbnail()) {
  $thumbnail_url = get_the_post_thumbnail_url($postid, 'custom-2000x2000');
  //$thumbnail_url = get_template_directory_uri(  ) . '/images/default_noimage.png';
} else {
  $thumbnail_url = get_template_directory_uri() . '/images/default_noimage.png';
}
$tags = get_the_tags($postid);
if ($tags) {
  foreach ($tags as $tag) {
    $taghtml .=  "<span class='tag'>";
    $taghtml .=  "<a class='tag_link'href='" . esc_url(get_tag_link($tag)) . "'>" . "#" . esc_html($tag->name) . '</a>';
    $taghtml .=  "</span>";
  }
}
?>
<div class="entry">
  <div class="entry_inner">
    <a href="<?php the_permalink(); ?>">
      <img data-url="<?php echo get_permalink(); ?>" data-title="<?php echo esc_attr(get_the_title()); ?>" data-date="<?php echo esc_attr(get_the_time('y.m.d')); ?>" style="object-fit:cover;" src="<?php echo esc_attr($thumbnail_url); ?>" data-taghtml="<?php echo esc_attr($taghtml); ?>">
    </a>
    <div class="entry_body">
      <p><?php the_title(); ?> (<?php the_time('y.m.d'); ?>) </p>
    </div>
  </div>
</div>