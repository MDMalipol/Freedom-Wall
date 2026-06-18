<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/Wall.css') }}">
  <title>NU Laguna FW</title>
</head>

<body>
  <header>
    <div class="header-container">
      <h1 class="header-title">NU Laguna Freedom Wall</h1>
      <a href="{{ route('login') }}" class="admin-btn">
        <svg class="admin-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
          <path d="M12 2C13.1 2 14 2.9 14 4C14 5.1 13.1 6 12 6C10.9 6 10 5.1 10 4C10 2.9 10.9 2 12 2ZM21 9V7L15 1H5C3.89 1 3 1.89 3 3V7H1V9H3V15H1V17H3V21C3 22.11 3.89 23 5 23H19C20.11 23 21 22.11 21 21V17H23V15H21V9H23ZM19 21H5V19H19V21ZM19 17H5V15H19V17ZM19 13H5V11H19V13ZM19 9H5V7H19V9ZM19 5H5V3H19V5Z"/>
        </svg>
        <span>Admin</span>
      </a>
    </div>
  </header>

  <div class="intro-panel">
    <a href="{{ route('post') }}" class="button-link" id="main-post-btn">
      <button type="button">Share a Post</button>
    </a>
    <p class="note">You can post anything freely. No login needed.</p>
  </div>

  <!-- Floating Side Button -->
  <a href="{{ route('post') }}" id="side-post-btn"
    style="display:none; position:fixed; right:30px; bottom:30px; z-index:9999;">
    <button type="button" class="fab-btn">
      <span class="visually-hidden">Go to Form-Post</span>
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-pencil-square"
        viewBox="0 0 16 16">
        <path d="M15.502 1.94a.5.5 0 0 1 0 .706l-1 1a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647.646-.647a.5.5 0 0 1 .708 0z" />
        <path d="M13.5 3.207L6 10.707V13h2.293l7.5-7.5-2.293-2.293zm1.5 1.5L14.293 5.5 10.5 9.293V10.5h1.207l3.793-3.793z" />
        <path fill-rule="evenodd" d="M1 13.5V2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v1h-1V2H2v11h11v-1h1v1a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z" />
      </svg>
    </button>
  </a>

  <main class="wall-feed">
    @if ($contents->isEmpty())
      <div class="empty-state">No posts yet. Be the first to share something.</div>
    @else
      @php $hasAccepted = false; @endphp
      <div class="posts-grid">
        @foreach ($contents as $content)
          @if ($content->Status == 'accepted')
            @php
              $hasAccepted = true;
              $mediaArray = is_array($content->media)
                ? $content->media
                : (json_decode($content->media, true) ?? []);

              $mediaItems = [];
              foreach ($mediaArray as $m) {
                  $ext = strtolower(pathinfo($m, PATHINFO_EXTENSION));
                  $type = $ext === 'mp4' ? 'video' : 'image';
                  $rel = 'storage/' . $m;
                  $url = file_exists(public_path($rel)) ? asset($rel) : asset('images/placeholder.png');
                  $mediaItems[] = ['url' => $url, 'type' => $type];
              }
              $cover = $mediaItems[0] ?? null;
            @endphp

            <article class="post-card"
              data-name="{{ $content->name ?? 'Anonymous' }}"
              data-title="{{ $content->title ?? '' }}"
              data-body="{{ $content->body }}"
              data-media="{{ json_encode($mediaItems) }}"
              tabindex="0" role="button" aria-label="Open post">

              @if ($cover)
                <div class="post-card__media">
                  @if ($cover['type'] === 'video')
                    <video src="{{ $cover['url'] }}" muted playsinline preload="metadata"></video>
                    <span class="media-badge">▶ Video</span>
                  @else
                    <img src="{{ $cover['url'] }}" alt="Post media" loading="lazy">
                  @endif
                  @if (count($mediaItems) > 1)
                    <span class="media-count">+{{ count($mediaItems) - 1 }}</span>
                  @endif
                  <span class="post-card__overlay">View post</span>
                </div>
              @else
                <div class="post-card__media post-card__media--text">
                  <p>{{ \Illuminate\Support\Str::limit($content->body, 120) }}</p>
                  <span class="post-card__overlay">View post</span>
                </div>
              @endif

              <div class="post-card__body">
                @if (!empty($content->title))
                  <h3 class="post-card__title">{{ $content->title }}</h3>
                @endif
                <p class="post-card__excerpt">{{ \Illuminate\Support\Str::limit($content->body, 90) }}</p>
                <div class="post-card__author">
                  <span class="avatar">{{ strtoupper(substr($content->name ?? 'A', 0, 1)) }}</span>
                  <span>By {{ $content->name ?? 'Anonymous' }}</span>
                </div>
              </div>
            </article>
          @endif
        @endforeach
      </div>

      @if (!$hasAccepted)
        <div class="empty-state">No posts yet. Be the first to share something.</div>
      @endif

      @if ($nullStatusCount > 0)
        <div class="review-banner">Some posts are being reviewed.</div>
      @endif
    @endif
  </main>

  <!-- Post Modal -->
  <div class="post-modal" id="postModal" aria-hidden="true">
    <div class="post-modal__backdrop" data-close></div>
    <div class="post-modal__dialog" role="dialog" aria-modal="true">
      <button class="post-modal__close" data-close aria-label="Close">&times;</button>
      <div class="post-modal__media" id="modalMedia"></div>
      <div class="post-modal__content">
        <div class="post-modal__author">
          <span class="avatar" id="modalAvatar">A</span>
          <span id="modalName">Anonymous</span>
        </div>
        <h2 class="post-modal__title" id="modalTitle"></h2>
        <p class="post-modal__body" id="modalBody"></p>
      </div>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      // Floating button visibility
      const mainBtn = document.getElementById('main-post-btn');
      const sideBtn = document.getElementById('side-post-btn');
      function checkButtonVisibility() {
        if (!mainBtn || !sideBtn) return;
        const rect = mainBtn.getBoundingClientRect();
        sideBtn.style.display = (rect.bottom < 0 || rect.top > window.innerHeight) ? 'block' : 'none';
      }
      window.addEventListener('scroll', checkButtonVisibility);
      window.addEventListener('resize', checkButtonVisibility);
      checkButtonVisibility();

      // Modal logic
      const modal = document.getElementById('postModal');
      const modalMedia = document.getElementById('modalMedia');
      const modalName = document.getElementById('modalName');
      const modalAvatar = document.getElementById('modalAvatar');
      const modalTitle = document.getElementById('modalTitle');
      const modalBody = document.getElementById('modalBody');

      function openModal(card) {
        const name = card.dataset.name || 'Anonymous';
        const title = card.dataset.title || '';
        const body = card.dataset.body || '';
        let media = [];
        try { media = JSON.parse(card.dataset.media || '[]'); } catch (e) { media = []; }

        modalName.textContent = name;
        modalAvatar.textContent = (name.trim()[0] || 'A').toUpperCase();
        modalTitle.textContent = title;
        modalTitle.style.display = title ? 'block' : 'none';
        modalBody.textContent = body;

        modalMedia.innerHTML = '';
        if (media.length === 0) {
          modalMedia.style.display = 'none';
        } else {
          modalMedia.style.display = 'flex';
          media.forEach(function (m) {
            if (m.type === 'video') {
              const v = document.createElement('video');
              v.src = m.url;
              v.controls = true;
              v.playsInline = true;
              modalMedia.appendChild(v);
            } else {
              const img = document.createElement('img');
              img.src = m.url;
              img.alt = 'Post media';
              modalMedia.appendChild(img);
            }
          });
        }

        modal.classList.add('is-open');
        modal.setAttribute('aria-hidden', 'false');
        document.body.style.overflow = 'hidden';
      }

      function closeModal() {
        modal.classList.remove('is-open');
        modal.setAttribute('aria-hidden', 'true');
        document.body.style.overflow = '';
        modalMedia.innerHTML = '';
      }

      document.querySelectorAll('.post-card').forEach(function (card) {
        card.addEventListener('click', function () { openModal(card); });
        card.addEventListener('keydown', function (e) {
          if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); openModal(card); }
        });
      });

      modal.querySelectorAll('[data-close]').forEach(function (el) {
        el.addEventListener('click', closeModal);
      });
      document.addEventListener('keydown', function (e) {
        if (e.key === 'Escape' && modal.classList.contains('is-open')) closeModal();
      });
    });
  </script>

</body>
</html>
