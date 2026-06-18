<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="{{ asset('css/custom.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/Wall.css') }}">
  <title>NU Laguna FW</title>
  
  <style>
    /* Additional styles for the admin button */
    .header-container {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      max-width: 1200px;
      margin: 0 auto;
      padding: 0 20px;
    }
    
    .header-title {
      font-size: 1.5em;
      font-weight: bold;
      color: #fbbf24;
      margin: 0;
    }
    
    .admin-btn {
      background: linear-gradient(135deg, #fbbf24 0%, #f59e0b 100%);
      color: #1e3a8a;
      border: none;
      padding: 10px 20px;
      font-size: 0.9em;
      font-weight: 600;
      border-radius: 25px;
      cursor: pointer;
      transition: all 0.3s ease;
      box-shadow: 0 4px 15px rgba(251, 191, 36, 0.3);
      text-decoration: none;
      display: inline-flex;
      align-items: center;
      gap: 8px;
      text-transform: uppercase;
      letter-spacing: 0.5px;
      position: relative;
      overflow: hidden;
    }
    
    .admin-btn::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
      transition: left 0.5s;
    }
    
    .admin-btn:hover::before {
      left: 100%;
    }
    
    .admin-btn:hover {
      background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);
      color: white;
      transform: translateY(-2px);
      box-shadow: 0 6px 20px rgba(251, 191, 36, 0.4);
      text-decoration: none;
    }
    
    .admin-btn:active {
      transform: translateY(0);
    }
    
    .admin-icon {
      width: 16px;
      height: 16px;
      fill: currentColor;
    }
    
    /* Mobile responsive adjustments */
    @media (max-width: 768px) {
      .header-container {
        padding: 0 15px;
      }
      
      .header-title {
        font-size: 1.2em;
      }
      
      .admin-btn {
        padding: 8px 16px;
        font-size: 0.8em;
        border-radius: 20px;
      }
      
      .admin-btn span {
        display: none;
      }
      
      .admin-icon {
        width: 18px;
        height: 18px;
      }
    }
    
    @media (max-width: 480px) {
      .header-title {
        font-size: 1em;
      }
      
      .admin-btn {
        padding: 6px 12px;
      }
    }
  </style>
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

  <div class="container">
    <a href="{{ route('post') }}" class="button-link" id="main-post-btn">
      <button type="button">Go to Form-Post</button>
    </a>
    <p class="note">You can post anything freely. No login needed.</p>
  </div>

  <!-- Floating Side Button -->
  <a href="{{ route('post') }}" id="side-post-btn"
    style="display:none; position:fixed; right:30px; bottom:30px; z-index:9999;">
    <button type="button" class="btn btn-primary rounded-circle shadow"
      style="width:60px; height:60px; font-size:24px;">
      <span class="visually-hidden">Go to Form-Post</span>
      <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" fill="currentColor" class="bi bi-pencil-square"
        viewBox="0 0 16 16">
        <path
          d="M15.502 1.94a.5.5 0 0 1 0 .706l-1 1a.5.5 0 0 1-.708 0l-1-1a.5.5 0 0 1 .708-.708l.646.647.646-.647a.5.5 0 0 1 .708 0z" />
        <path
          d="M13.5 3.207L6 10.707V13h2.293l7.5-7.5-2.293-2.293zm1.5 1.5L14.293 5.5 10.5 9.293V10.5h1.207l3.793-3.793z" />
        <path fill-rule="evenodd"
          d="M1 13.5V2a1 1 0 0 1 1-1h8a1 1 0 0 1 1 1v1h-1V2H2v11h11v-1h1v1a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1z" />
      </svg>
    </button>
  </a>

  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const mainBtn = document.getElementById('main-post-btn');
      const sideBtn = document.getElementById('side-post-btn');

      function checkButtonVisibility() {
        const rect = mainBtn.getBoundingClientRect();
        // If the bottom of the main button is above the viewport, show side button
        if (rect.bottom < 0 || rect.top > window.innerHeight) {
          sideBtn.style.display = 'block';
        } else {
          sideBtn.style.display = 'none';
        }
      }

      window.addEventListener('scroll', checkButtonVisibility);
      window.addEventListener('resize', checkButtonVisibility);
      checkButtonVisibility();
    });
  </script>

  <div class="container mt-4">
    @if ($contents->isEmpty())
      <div class="alert alert-warning text-center">NO POST</div>
    @else
      <div class="row">
        @php $hasAccepted = false; @endphp
        @foreach ($contents as $content)
          @if ($content->Status == 'accepted')
            <div class="col-md-6 col-lg-4 mb-4">
              <div class="card h-100 shadow-sm">
                <div class="card-body">
                  <h5 class="card-title">By {{ $content->name ?? 'Anonymous' }}</h5>
                  <h6 class="card-subtitle mb-2 text-muted">{{ $content->title ?? '' }}</h6>
                  <p class="card-text">{{ $content->body }}</p>
                </div>
                @php
                  $mediaArray = is_array($content->media)
                    ? $content->media
                    : (json_decode($content->media, true) ?? []);
                @endphp
                @if (!empty($mediaArray))
                  <div class="card-footer bg-white">
                    <div class="d-flex flex-wrap gap-2 justify-content-start">
                      @foreach ($mediaArray as $media)
                        @php $mediaPath = 'storage/' . $media; @endphp
                        @if (file_exists(public_path($mediaPath)))
                          <img src="{{ asset($mediaPath) }}" class="img-thumbnail media-thumb" alt="Media">
                        @else
                          <img src="{{ asset('images/placeholder.png') }}" class="img-thumbnail media-thumb" alt="No Image">
                        @endif
                      @endforeach
                    </div>
                  </div>
                @endif
              </div>
            </div>
          @endif
        @endforeach
          @if ($nullStatusCount > 0) 
            <div class="alert alert-warning text-center">Some Post Are Being Review</div>
          @endif
      </div>
    @endif
  </div>

</body>
</html>