<?php get_header(); ?>
<div class="entries">
  <?php
  global $wp_query;
  $paged = get_query_var('paged') ? get_query_var('paged') : 1;
  $max_page = $wp_query->max_num_pages;
  if (have_posts()): while (have_posts()): the_post();
  ?>
      <?php include(locate_template('template/photocontent.php')); ?>
  <?php
    endwhile;
  endif;
  ?>
</div>
<?php

if (($paged < $max_page) && ($max_page != 1)) {
  $next_page_url = get_pagenum_link($paged + 1);
  echo '<div class="nextarea"><a id="nexturl" href="' . esc_url($next_page_url) . '">もっと見る</a></div>';
}
wp_reset_postdata();
?>
<script>
  document.getElementById('nexturl')?.addEventListener('click', function(e) {
    e.preventDefault();
    let posts_per_page = <?php echo $POSTPERPAGE; ?>;
    let url = this.getAttribute('href');
    let loading = document.getElementById('loading');
    let nextLink = document.getElementById('nexturl');
    nextLink.style.display = 'none';
    loading.style.display = '';
    fetch(url)
      .then(response => response.text())
      .then(html => {
        let parser = new DOMParser();
        let doc = parser.parseFromString(html, 'text/html');
        let newEntries = doc.querySelectorAll('.entries .entry');
        let nexturlElement = doc.getElementById('nexturl');
        let entriesContainer = document.querySelector('.entries');
        let interval = <?php echo $PHOTOINTERVAL; ?>;
        let animationDuration = <?php echo $PHOTODURATION; ?>;
        let shouldShowNextLink = false;
        let currentCount = document.querySelector('.entries').children.length;
        let currentRow = Math.ceil(currentCount / 3);
        let addCount = newEntries.length;
        let addRow = Math.ceil((currentCount + addCount) / 3) - currentRow;
        alert(addRow);
        if (nexturlElement && newEntries.length >= posts_per_page) {
          nextLink.setAttribute('href', nexturlElement.getAttribute('href'));
          shouldShowNextLink = true;
        }
        newEntries.forEach(function(entry, index) {
          let clonedEntry = entry.cloneNode(true);
          clonedEntry.classList.add('is-loading-in');
          clonedEntry.style.transitionDelay = `${index * interval}ms`;
          entriesContainer.appendChild(clonedEntry);
          requestAnimationFrame(function() {
            requestAnimationFrame(function() {
              clonedEntry.classList.remove('is-loading-in');
            });
          });
        });
        let totalAnimationTime = ((newEntries.length - 1) * interval) + animationDuration;
        const intervalId = setInterval(function() {
          if (addRow == 0) {
            clearInterval(intervalId);
            return;
          }
          window.scrollBy({
            top: 340,
            behavior: 'smooth'
          });
          --addRow;
        }, ((totalAnimationTime / newEntries.length) * 3));

        setTimeout(function() {
          loading.style.display = 'none';
          if (shouldShowNextLink) {
            nextLink.style.display = '';
          }
        }, totalAnimationTime);
      });
  });
</script>
<?php get_footer(); ?>