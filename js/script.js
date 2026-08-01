(function () {
  // 初期化
  let lastY = 0;
  let entryHeight;
  let entriesElement;
  let entries;
  let tops;

  // 慣性スクロール用の状態
  let velocity = 50;
  let animating = false;
  const friction = 0.9; // 1に近いほど慣性が長く続く
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

  // 画面幅に応じてカラム数を返す関数
  const getColumnCount = () => (window.innerWidth <= 1024 ? 1.0 : 2.0); // 画面幅が1024px以下なら1（ワンカラム）

  // ページロード時の初期化
  const init = () => {
    entriesElement = document.querySelector('.entries');
    entries = document.querySelectorAll('.entries .entry');

    if (entriesElement) {
      entriesHeight = entriesElement.offsetHeight;
    }

    entries.forEach((entry) => {
      entryHeight = entry.clientHeight;
      entry.style.top = -entryHeight + entriesHeight / 2.0 + 'px';
    });
    // もともとのtop値を保存
    tops = Array.from(entries).map((entry) => {
      // top値の初期値
      const topVal = parseInt(entry.style.top || getComputedStyle(entry).top || '0', 10) || 0;
      return topVal;
    });
  };

  const getTopBounds = () => {
    if (!entriesElement || entries.length === 0) {
      return {
        maxTop: 0,
        minTop: 0,
      };
    }
    let totalEntriesHeight = 0;
    let maxScroll;
    entries.forEach((entry) => {
      totalEntriesHeight += entry.offsetHeight / getColumnCount();
    });
    maxScroll = Math.max(0, totalEntriesHeight - 300);

    return {
      maxTop: -entryHeight + entriesHeight / 2.0,
      minTop: -(maxScroll / 2.0),
    };
  };

  const clampLastY = (maxTop, minTop) => {
    if (!tops || tops.length === 0) return;

    let minLastY = -Infinity;
    let maxLastY = Infinity;

    tops.forEach((baseTop) => {
      minLastY = Math.max(minLastY, baseTop - maxTop);
      maxLastY = Math.min(maxLastY, baseTop - minTop);
    });

    if (minLastY > maxLastY) {
      lastY = 0;
      return;
    }

    if (lastY < minLastY) {
      lastY = minLastY;
    } else if (lastY > maxLastY) {
      lastY = maxLastY;
    }
  };
  const applyPositions = () => {
    init();
    const { maxTop, minTop } = getTopBounds();
    clampLastY(maxTop, minTop);
    entries.forEach((entry, idx) => {
      let newTop = tops[idx] - lastY;
      if (newTop > maxTop) {
        newTop = maxTop;
      } else if (newTop < minTop) {
        newTop = minTop;
      }
      entry.style.top = newTop + 'px';
    });
  };
  const stepInertia = () => {
    lastY += velocity;
    velocity *= friction;
    applyPositions();

    if (Math.abs(velocity) > 0.5) {
      requestAnimationFrame(stepInertia);
    } else {
      velocity = 0;
      animating = false;
    }
  };
  const addInertiaDelta = (delta) => {
    // 逆方向入力は、境界で溜まった慣性をリセットして即応させる
    if (velocity !== 0 && Math.sign(delta) !== Math.sign(velocity)) {
      velocity = 0;
    }
    velocity += delta;
    velocity = Math.max(-maxVelocity, Math.min(maxVelocity, velocity));
    if (!animating) {
      animating = true;
      requestAnimationFrame(stepInertia);
    }
  };

  init();

  //==============================================================================================
  // Windowロード
  window.addEventListener('load', () => {
    // サムネイルの位置調整
    addInertiaDelta(0);

    // サムネイル一覧フェードイン
    let entriesIn = document.querySelectorAll('.entries .entry .entry_inner');
    let i = 0;
    entriesIn.forEach((entry) => {
      i++;
      const keyframes = {
        opacity: [0, 1],
        transform: ['translateY(50px)', 'translateY(0px)'],
      };
      const options = {
        duration: 500,
        delay: i * 300,
        fill: 'forwards',
      };
      entry.animate(keyframes, options);
    });
  });

  //==============================================================================================
  // スクロールによるデフォルト動作の抑止
  window.addEventListener('scroll', (e) => {
    //e.preventDefault();
  });

  //==============================================================================================
  // マウスホイール
  window.addEventListener(
    'wheel',
    (e) => {
      //e.preventDefault();
      addInertiaDelta(e.deltaY);
    },
    { passive: false }
  );

  //==============================================================================================
  // キー入力
  window.addEventListener('keydown', function (e) {
    const activeEl = document.activeElement;
    if (activeEl && (activeEl.tagName === 'INPUT' || activeEl.tagName === 'TEXTAREA' || activeEl.tagName === 'SELECT' || activeEl.isContentEditable)) {
      return;
    }
    const key = e.key;
    switch (key) {
      case 'ArrowUp':
        e.preventDefault();
        addInertiaDelta(-30);
        break;
      case 'PageUp':
        e.preventDefault();
        addInertiaDelta(-120);
        break;
      case 'ArrowDown':
        e.preventDefault();
        addInertiaDelta(30);
        break;
      case 'PageDown':
        e.preventDefault();
        addInertiaDelta(120);
        break;
      default:
        break;
    }
  });

  //==============================================================================================
  // スマホタッチスタート
  window.addEventListener(
    'touchstart',
    (e) => {
      startX = e.touches[0].pageX;
      startY = e.touches[0].pageY;
      endX = startX;
      endY = startY;
      lastSwipeDeltaY = 0;
    },
    { passive: true }
  );

  //==============================================================================================
  // スマホタッチムーブ
  window.addEventListener(
    'touchmove',
    (e) => {
      endX = e.touches[0].pageX;
      endY = e.touches[0].pageY;
      lastSwipeDeltaY = startY - endY;
    },
    { passive: true }
  );

  //==============================================================================================
  // スマホタッチエンド
  window.addEventListener('touchend', () => {
    const distanceX = Math.abs(endX - startX);
    const distanceY = Math.abs(endY - startY);

    // 上下スワイプ時のみ、wheel と同じ慣性処理を適用
    if (distanceY > distanceX && distanceY > minimumDistance) {
      const inertiaDelta = Math.abs(lastSwipeDeltaY) > 0 ? lastSwipeDeltaY : startY - endY;
      addInertiaDelta(inertiaDelta);
    }
  });

  //==============================================================================================
  // .entry a をクリックしたときのイベントリスナー
  document.querySelectorAll('.entry a').forEach((anchor) => {
    anchor.addEventListener('click', (e) => {
      e.preventDefault();

      // 例: オーバーレイに画像とタイトルを表示する場合
      let overlay = document.getElementById('overlay');
      if (overlay) {
        const currentAnchor = e.currentTarget;
        if (!(currentAnchor instanceof HTMLAnchorElement)) {
          return;
        }

        let imgSrc = currentAnchor.querySelector('img') ? currentAnchor.querySelector('img').src : '';
        let overlayImg = overlay.querySelector('.photo_inner img');
        let overlayTags = overlay.querySelector('.photo_inner .taglist');
        let overlayUrl = overlay.querySelector('.photo_inner .single');

        let imgElem = currentAnchor.querySelector('img');

        // img要素からdata属性を取得
        let dataurl = imgElem ? imgElem.getAttribute('data-url') : '';
        let datatagtxt = imgElem ? imgElem.getAttribute('data-taghtml') : '';
        datatagtxt = datatagtxt.replaceAll('&lt;', '<');
        datatagtxt = datatagtxt.replaceAll('&gt;', '>');

        if (overlayImg && imgSrc && overlayTags) {
          overlayImg.src = imgSrc;
          overlayUrl.href = dataurl;
          overlayTags.innerHTML = datatagtxt;
        }
        overlay.classList.add('is-open');
      }
    });
  });
  //==============================================================================================
  // 画面全体クリック
  document.addEventListener('click', (e) => {
    const overlay = document.getElementById('overlay');
    if (!overlay || !overlay.contains(e.target)) {
      return;
    }
    const photoInner = overlay.querySelector('.photo_inner');
    if (photoInner && (photoInner === e.target || photoInner.contains(e.target))) {
      return;
    }
    overlay.classList.remove('is-open');
  });

  const sidebarBtn = document.querySelector('#sidebar-btn');
  const sidebar = document.querySelector('#sidebar');

  sidebarBtn.addEventListener('click', (e) => {
    const isOpen = sidebarBtn.classList.contains('is-open');
    if (isOpen) {
      sidebar.style.height = '0svh';
      sidebarBtn.classList.remove('is-open');
    } else {
      sidebar.style.height = '100svh';
      sidebarBtn.classList.add('is-open');
    }
  });
})();
