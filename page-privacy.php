<?php
/*
Template Name: プライバシーポリシー
*/
?>
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
                <!-- wp:heading -->
                <h2 class="wp-block-heading">プライバシーポリシー</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>当サイト「写真まみれ」（以下「当サイト」）では、ご利用いただくみなさまの個人情報およびプライバシーの保護を重要なものと考え、以下のとおり方針を定めています。</p>
                <!-- /wp:paragraph -->

                <!-- wp:heading -->
                <h2 class="wp-block-heading">個人情報の取得について</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>当サイトでは、お問い合わせフォームの送信、コメントの投稿などの際に、氏名（ハンドルネーム）、メールアドレスなどの個人情報をご入力いただく場合があります。これらの情報は、ご本人の意思による送信をもって取得したものとし、それ以外の目的で無断に取得することはありません。</p>
                <!-- /wp:paragraph -->

                <!-- wp:heading {"level":3} -->
                <h3 class="wp-block-heading">利用目的</h3>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>取得した個人情報は、次の目的の範囲内で利用します。</p>
                <!-- /wp:paragraph -->

                <!-- wp:list -->
                <ul class="wp-block-list"><!-- wp:list-item -->
                  <li>お問い合わせやご依頼への返信、ご連絡のため</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>写真の掲載・削除に関するご要望への対応のため</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>コメントへの返信および管理のため</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>当サイトの運営・改善に必要な範囲での統計的な分析のため</li>
                  <!-- /wp:list-item -->
                </ul>
                <!-- /wp:list -->

                <!-- wp:heading {"level":3} -->
                <h3 class="wp-block-heading">第三者への提供</h3>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>取得した個人情報は、次の場合を除き、ご本人の同意なく第三者へ提供・開示することはありません。</p>
                <!-- /wp:paragraph -->

                <!-- wp:list -->
                <ul class="wp-block-list"><!-- wp:list-item -->
                  <li>法令に基づき開示が求められた場合</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>人の生命、身体または財産の保護のために必要があり、ご本人の同意を得ることが困難な場合</li>
                  <!-- /wp:list-item -->
                </ul>
                <!-- /wp:list -->

                <!-- wp:heading {"level":3} -->
                <h3 class="wp-block-heading">開示・訂正・削除のご請求</h3>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>ご本人から個人情報の開示、訂正、利用停止、削除のお申し出があった場合は、ご本人であることを確認のうえ、合理的な期間内に対応いたします。</p>
                <!-- /wp:paragraph -->

                <!-- wp:heading -->
                <h2 class="wp-block-heading">写真の掲載と被写体の映り込みについて</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>当サイトは風景や街並み、日常の情景を中心とした写真を掲載しています。撮影にあたっては、被写体となる方々のプライバシーおよび肖像権に十分配慮するよう努めています。</p>
                <!-- /wp:paragraph -->

                <!-- wp:heading {"level":3} -->
                <h3 class="wp-block-heading">撮影と掲載にあたっての配慮</h3>
                <!-- /wp:heading -->

                <!-- wp:list -->
                <ul class="wp-block-list"><!-- wp:list-item -->
                  <li>人物を主題として撮影する場合は、原則としてご本人の承諾を得たうえで掲載しています。</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>屋外での撮影において、通行人の方などが意図せず写り込む場合があります。個人が特定できる状態での掲載は避け、必要に応じて縮小やぼかしなどの処理を行っています。</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>表札、車両のナンバープレート、勤務先の名札など、個人の特定につながる情報が写り込んでいる場合も同様に配慮しています。</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>私有地や施設内での撮影は、管理者の許可および施設の定めるルールに従って行っています。</li>
                  <!-- /wp:list-item -->
                </ul>
                <!-- /wp:list -->

                <!-- wp:heading {"level":3} -->
                <h3 class="wp-block-heading">掲載写真の削除のご依頼</h3>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>上記の配慮を行ってもなお、ご自身やご家族が写り込んだ写真について掲載を望まれない場合があると考えています。その際は、ページ下部のお問い合わせ先までご連絡ください。</p>
                <!-- /wp:paragraph -->

                <!-- wp:list -->
                <ul class="wp-block-list"><!-- wp:list-item -->
                  <li>対象となる記事のURLと、写真内のどの部分かをお知らせいただけますと、対応がスムーズです。</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>ご連絡をいただきしだい内容を確認し、速やかに当該写真の削除、または該当箇所の修正を行います。</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>削除のご依頼にあたって、理由をお伺いすることはありません。判断に迷う内容であっても、削除を優先して対応いたします。</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>ご本人以外（ご家族、保護者の方など）からのご連絡も受け付けています。</li>
                  <!-- /wp:list-item -->
                </ul>
                <!-- /wp:list -->

                <!-- wp:heading -->
                <h2 class="wp-block-heading">アクセス解析ツールについて</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>当サイトでは、サイトの利用状況を把握するためにGoogleアナリティクスをはじめとするアクセス解析ツールを利用する場合があります。これらのツールはCookieを使用してトラフィックデータを収集しますが、収集されるデータは匿名で行われており、個人を特定するものではありません。</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph -->
                <p>Cookieの利用を望まれない場合は、お使いのブラウザの設定により無効にすることができます。</p>
                <!-- /wp:paragraph -->

                <!-- wp:heading -->
                <h2 class="wp-block-heading">広告の配信について</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>当サイトでは、第三者配信の広告サービス（Googleアドセンス、Amazonアソシエイト等）を利用する場合があります。これらの広告配信事業者は、ユーザーの興味に応じた広告を表示するためにCookieを使用することがあります。</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph -->
                <p>Cookieを無効にする方法や、パーソナライズ広告の設定については、各事業者のポリシーページをご確認ください。</p>
                <!-- /wp:paragraph -->

                <!-- wp:heading -->
                <h2 class="wp-block-heading">コメントについて</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>当サイトへのコメントは、投稿された時点で公開されます。ただし、次に該当すると判断したコメントは、管理者の裁量により削除する場合があります。</p>
                <!-- /wp:paragraph -->

                <!-- wp:list -->
                <ul class="wp-block-list"><!-- wp:list-item -->
                  <li>個人情報や特定の個人を誹謗中傷する内容を含むもの</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>公序良俗に反する内容、法令に違反する内容を含むもの</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>記事内容と関連のない宣伝を目的としたもの</li>
                  <!-- /wp:list-item -->
                </ul>
                <!-- /wp:list -->

                <!-- wp:heading -->
                <h2 class="wp-block-heading">著作権について</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>当サイトに掲載しているすべての写真および文章の著作権は、当サイトの管理者に帰属します。無断での転載、複製、加工、商用利用はご遠慮ください。</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph -->
                <p>引用の範囲を超えて利用をご希望の場合は、事前にお問い合わせください。また、当サイトの掲載内容が第三者の著作権を侵害している場合は、お手数ですがご連絡いただけますと幸いです。確認のうえ速やかに対応いたします。</p>
                <!-- /wp:paragraph -->

                <!-- wp:heading -->
                <h2 class="wp-block-heading">免責事項</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>当サイトに掲載する情報については正確性に配慮していますが、その内容の完全性を保証するものではありません。掲載情報を利用したことにより生じた損害等について、当サイトは一切の責任を負いかねます。</p>
                <!-- /wp:paragraph -->

                <!-- wp:paragraph -->
                <p>また、当サイトから外部サイトへのリンクを設置している場合がありますが、リンク先のコンテンツやサービスについて、当サイトは責任を負いません。</p>
                <!-- /wp:paragraph -->

                <!-- wp:heading -->
                <h2 class="wp-block-heading">プライバシーポリシーの変更</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>当サイトは、法令の改正や運営上の必要に応じて、本ポリシーの内容を予告なく変更する場合があります。変更後の内容は、当ページに掲載した時点から適用されるものとします。</p>
                <!-- /wp:paragraph -->

                <!-- wp:heading -->
                <h2 class="wp-block-heading">お問い合わせ先</h2>
                <!-- /wp:heading -->

                <!-- wp:paragraph -->
                <p>本ポリシーに関するご質問、写真の削除のご依頼、その他のお問い合わせは、以下よりご連絡ください。</p>
                <!-- /wp:paragraph -->

                <!-- wp:list -->
                <ul class="wp-block-list"><!-- wp:list-item -->
                  <li>サイト名：写真まみれ</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>運営者：らぐち</li>
                  <!-- /wp:list-item -->

                  <!-- wp:list-item -->
                  <li>連絡先：（jugedred@gmail.com）</li>
                  <!-- /wp:list-item -->
                </ul>
                <!-- /wp:list -->

                <!-- wp:paragraph -->
                <p>制定日：2026年8月1日 最終更新日：2026年8月1日</p>
                <!-- /wp:paragraph -->
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