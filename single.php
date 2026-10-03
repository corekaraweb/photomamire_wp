<?php get_header(); ?>
<main>
  <div class="container">
    <div class="contents">
      <div class="contents_inner">
        <div class="photolist single">
          <div class="entry_body">
            <?php
            $thumbnail_url = '';
            $full_url = '';
            if (has_post_thumbnail()) {
              $thumbnail_url = get_the_post_thumbnail_url(get_the_ID(), 'custom-2000x2000');
              $thumbnail_id = get_post_thumbnail_id();
              $full_url = get_the_post_thumbnail_url(get_the_ID(), 'full');
            }
            if (have_posts()): while (have_posts()): the_post();
            ?>
                <div class="meta">
                  <h2 class="title"><?php the_title(); ?></h2>
                  <p class="date">（投稿日：<?php the_time('Y.m.d'); ?>）</p>
                </div>
                <?php
                $img_orientation = '';
                if ($thumbnail_url) {
                  $img_info = getimagesize($thumbnail_url);
                  if ($img_info && isset($img_info[0], $img_info[1])) {
                    $img_width = $img_info[0];
                    $img_height = $img_info[1];
                    if ($img_width > $img_height) { ?>
                      <div class="img landscape">
                        <img src="<?php echo esc_attr($thumbnail_url); ?>">
                      </div>
                    <?php
                    } elseif ($img_height > $img_width) { ?>
                      <div class="img portrait">
                        <img src="<?php echo esc_attr($thumbnail_url); ?>">
                      </div>
                <?php }
                  }
                } ?>
                <?php

                $exif = exif_read_data($full_url, 'IFD0', true);
                $exif_model = '不明';
                $exif_date = '不明';
                $exif_height = '不明';
                $exif_width = '不明';
                $exif_shibori = '不明';
                $exif_roshutsu = '不明';
                $exif_hosei = '不明';
                $exif_iso  = '不明';
                $exif_shyouten = '不明';
                if (isset($exif["IFD0"]["Model"])) { //配列キーに値が存在するか確認します
                  $exif_model = $exif["IFD0"]["Model"] ?: "不明"; // カメラモデル
                }
                if (isset($exif["EXIF"]["DateTimeOriginal"])) { //配列キーに値が存在するか確認します
                  $exif_date = $exif["EXIF"]["DateTimeOriginal"] ?: "不明"; // 撮影日時
                }
                if (isset($exif["COMPUTED"]["Height"])) { //配列キーに値が存在するか確認します
                  $exif_height = $exif["COMPUTED"]["Height"] . ' px' ?: "不明"; //写真の高さ
                }
                if (isset($exif["COMPUTED"]["Width"])) { //配列キーに値が存在するか確認します
                  $exif_width = $exif["COMPUTED"]["Width"] . ' px' ?: "不明";  //写真の横幅
                }
                if (isset($exif["COMPUTED"]["ApertureFNumber"])) { //配列キーに値が存在するか確認します
                  $exif_shibori = $exif["COMPUTED"]["ApertureFNumber"] ?: "不明"; // F値
                }
                if (isset($exif["EXIF"]["ExposureTime"])) { //配列キーに値が存在するか確認します
                  $exif_roshutsu = $exif["EXIF"]["ExposureTime"] ?: "不明"; // 露出時間（シャッタースピード）
                }
                if (isset($exif["EXIF"]["ExposureBiasValue"])) { //配列キーに値が存在するか確認します
                  $exif_hosei = $exif["EXIF"]["ExposureBiasValue"] ?: "不明"; // 露出補正
                }
                if (isset($exif["EXIF"]["ISOSpeedRatings"])) { //配列キーに値が存在するか確認します
                  $exif_iso = $exif["EXIF"]["ISOSpeedRatings"] ?: "不明"; // ISO
                }
                if (isset($exif["EXIF"]["FocalLengthIn35mmFilm"])) { //配列キーに値が存在するか確認します
                  $exif_shyouten = $exif["EXIF"]["FocalLengthIn35mmFilm"] . ' mm'; // 焦点距離
                }

                ?>
                <div class="photo_detail">
                  <div class="photo_info">
                    <h2>撮影情報</h2>
                    <table class="photoinfo">
                      <tr>
                        <th>カメラモデル</th>
                        <td><?php echo $exif_model; ?></td>
                      </tr>
                      <tr>
                        <th>撮影日時</th>
                        <td><?php echo $exif_date; ?></td>
                      </tr>
                      <tr>
                        <th>写真の横幅</th>
                        <td><?php echo $exif_width; ?></td>
                      </tr>
                      <tr>
                        <th>写真の高さ</th>
                        <td><?php echo $exif_height; ?></td>
                      </tr>
                      <tr>
                        <th>F値</th>
                        <td><?php echo $exif_shibori; ?></td>
                      </tr>
                      <tr>
                        <th>シャッタースピード</th>
                        <td><?php echo $exif_roshutsu; ?></td>
                      </tr>
                      <tr>
                        <th>露出補正</th>
                        <td><?php echo $exif_hosei  ?></td>
                      </tr>
                      <tr>
                        <th>ISO感度</th>
                        <td><?php echo $exif_iso; ?></td>
                      </tr>
                      <tr>
                        <th>焦点距離</th>
                        <td><?php echo $exif_shyouten; ?></td>
                      </tr>
                    </table>
                  </div>
                  <div class="photo_comment">
                    <h2>AIコメント</h2>
                    <?php 
                    $thumbnail_description = get_post( $thumbnail_id )->post_content;
                    echo $thumbnail_description;
                    ?>
                  </div>
                </div>
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