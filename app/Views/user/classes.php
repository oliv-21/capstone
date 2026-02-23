<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="assets/css/user.css">
   <style>
    /* Custom styles for previews */
    .preview-media {
      height: 200px;
      object-fit: cover;
      width: 100%;
    }
    .video-preview {
      background: #f8f9fa;
      border-radius: 0.375rem 0.375rem 0 0;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 200px;
      color: #6c757d;
      font-size: 4rem;
    }
    .video-preview video {
      width: 100%;
      height: 100%;
      object-fit: cover;
    }
    .file-icon {
      font-size: 4rem;
      color: #6c757d;
    }
    .youtube-thumbnail {
      position: relative;
      background-size: cover;
      background-position: center;
    }
    .youtube-thumbnail::after {
      content: '\f04b';
      font-family: 'Font Awesome 6 Free';
      font-weight: 900;
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      color: white;
      font-size: 3rem;
      text-shadow: 0 0 10px rgba(0,0,0,0.5);
      z-index: 1;
    }
  </style>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url('student-dashboard'); ?>" class="nav-link d-flex align-items-center ">         
          <i class="fas fa-star me-4 fa-lg fa-fw text-secondary"></i> Highlight
        </a>
        <a href="<?= base_url('student-classes'); ?>" class="nav-link d-flex align-items-center active">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
         <a href="<?= base_url('student-progress-report'); ?>" class="nav-link d-flex align-items-center  ">
          <i class="fas fa-chart-line me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url('student-guardiansetup'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-users me-4 fa-lg fa-fw text-secondary"></i> Guardian Setup
        </a>
        <a href="<?= base_url('student-attendance'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Attendance
        </a>
        
        <!-- <a href="<?= base_url('student-interactive-learning'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fa-solid fa-chalkboard me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a> -->
      </div>
      <div class="mt-auto mb-3">
          <hr>
          <span class="fw-bold text-secondary small ms-1">Parent</span>
          <ul class="list-unstyled ms-1 mt-2">
                <a  class="text-decoration-none" href="<?= base_url('/guardian/dashboard/' . esc($student->parent_id)) ?>">
                      <img src="<?= base_url('public/assets/profilepic/' . esc($parentData->parentProfilepic)) ?>" alt="Parent"
                          class="rounded-circle border border-2 me-2" width="25" height="25">
                    <span class="text-primary fw-bold"><?= esc($parentData->parentfull_name) ?></span>
                </a>
          </ul>
      </div>
    </nav>

    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          <div class="text-primary m-0 ms-3 d-none d-md-block">
            <h5 class="text-primary m-0 ms-3 ">Materials</h5>
          </div>
           <?php 
            $hasUnread = false;
            if (!empty($notification)) {
                foreach ($notification as $n) {
                    if ($n['is_read'] == 0) {
                        $hasUnread = true;
                        break; 
                    }
                }
            }
            ?>

          <div class="d-flex align-items-center ms-auto py-1">
            <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
                <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                  <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                  <?php if ($unread_announcement > 0): ?>
                <span id="notifBadge"
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unread_announcement ?>
                </span>
                <?php endif; ?>
                </a>
               <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown" style="width: 350px; max-height:320px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li><hr class="dropdown-divider"></li>

                <?php if (!empty($notification)): ?>
                    <?php foreach ($notification as $n): ?>
                      <li class="px-3 py-2 small">
                        <strong><?= esc($n['title']) ?></strong><br>
                        <span class="text-muted"><?= esc($n['message']) ?></span>
                      </li>
                    <?php endforeach; ?>
                <?php else: ?>
                    <li class="px-3 py-2 small text-muted">No new notifications</li>
                <?php endif; ?>
              </ul>
            </div> 
            

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                 id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                 <img  src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>"  alt="Profile Picture"
                    class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($student->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('student-profile'); ?>"><i class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>
                
                <li><hr class="dropdown-divider"></li>
                <li>
                  <form action="<?= base_url('logout') ?>" method="post" class="d-inline">
                      <?= csrf_field() ?>
                      <button type="submit" class="dropdown-item text-danger">
                          <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                      </button>
                  </form>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">        

        <?php if (!empty($classroom)): ?>

            <?php 
            // Group classroom items by date
            $groupedMaterials = [];
            foreach ($classroom as $item) {
                $date = date('F j, Y', strtotime($item['created_at'] ?? date('Y-m-d')));
                $groupedMaterials[$date][] = $item;
            }
            ?>

            <?php foreach ($groupedMaterials as $date => $items): ?>
                <!-- Date Header -->
                <div  class='border-bottom border-2 mb-3 mt-4'>
                  <h5 class="fw-bold text-primary "> <i class="fas fa-book me-2 fa-lg fa-fw text-secondary"></i><?= $date ?></h5>
                </div>

                <div class="row g-4">
                    <?php foreach ($items as $i => $item): ?>
                        <?php 
                        $fileExt = isset($item['file']) ? strtolower(pathinfo($item['file'], PATHINFO_EXTENSION)) : '';
                        $isExternalLink = isset($item['file']) && preg_match('/^https?:\/\//i', $item['file']);
                        $isLocalFile = !$isExternalLink;
                        $fullFileUrl = $isLocalFile ? base_url('public/assets/uploadedfile/' . $item['file']) : $item['file'];
                        $isDocument = in_array($fileExt, ['pdf', 'doc', 'docx', 'txt']);
                        $isImage = in_array($fileExt, ['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg']);
                        $isVideo = in_array($fileExt, ['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm']);
                        $isYouTube = $isExternalLink && (strpos($item['file'], 'youtube.com') !== false || strpos($item['file'], 'youtu.be') !== false);
                        $youtubeThumbnail = '';
                        if ($isYouTube) {
                            $videoId = '';
                            if (strpos($item['file'], 'v=') !== false) {
                                $videoId = explode('v=', $item['file'])[1];
                                $videoId = explode('&', $videoId)[0];
                            } elseif (strpos($item['file'], 'youtu.be/') !== false) {
                                $videoId = explode('youtu.be/', $item['file'])[1];
                                $videoId = explode('?', $videoId)[0];
                            }
                            $youtubeThumbnail = "https://img.youtube.com/vi/{$videoId}/0.jpg";
                        }
                        ?>
                        <div class="col-12 col-md-6 col-lg-3 g-4"> <!-- 4 per row on large screens -->
                            <div class="card h-100 shadow-sm">
                                <!-- Preview Section -->
                                <div class="card-img-top position-relative overflow-hidden" style="height: 200px;">
                                    <?php if ($isImage && $isLocalFile): ?>
                                        <img src="<?= $fullFileUrl; ?>" alt="<?= esc($item['title']); ?>" class="preview-media w-100 h-100" style="object-fit: cover;" loading="lazy">
                                    <?php elseif ($isVideo && $isLocalFile): ?>
                                        <video preload="metadata" muted loop class="preview-media w-100 h-100" style="object-fit: cover;">
                                            <source src="<?= $fullFileUrl; ?>" type="video/<?= $fileExt; ?>">
                                        </video>
                                    <?php elseif ($isYouTube): ?>
                                        <div class="youtube-thumbnail w-100 h-100 d-flex align-items-center justify-content-center" 
                                            style="background-image: url('<?= $youtubeThumbnail; ?>'); background-size: cover; background-position: center; cursor:pointer;"
                                            data-bs-toggle="modal" data-bs-target="#viewModal" 
                                            data-src="<?= esc($item['file']); ?>" data-type="<?= $fileExt; ?>">
                                        </div>
                                    <?php elseif ($isDocument): ?>
                                        <div class="d-flex align-items-center justify-content-center w-100 h-100">
                                            <i class="fas fa-file-pdf file-icon <?= $fileExt === 'pdf' ? 'text-danger' : 'text-secondary'; ?> fa-3x"></i>
                                        </div>
                                    <?php else: ?>
                                        <div class="d-flex align-items-center justify-content-center w-100 h-100">
                                            <i class="fas fa-file file-icon fa-3x"></i>
                                        </div>
                                    <?php endif; ?>
                                </div>

                                <div class="card-header bg-light">
                                    <h6 class="card-title mb-0">#<?= $i + 1 ?> - <?= esc($item['title']); ?></h6>
                                </div>
                                <div class="card-body">
                                    
                                    <p class="card-text"><strong>Type:</strong> <?= strtoupper($fileExt ?: 'LINK'); ?></p>
                                    <?php if (!empty($item['description'])): ?>
                                        <p class="card-text"><strong>Description:</strong> <?= esc($item['description']); ?></p>
                                    <?php endif; ?>
                                </div>
                                <div class="card-footer bg-light">
                                    <?php if ($isDocument): ?>
                                        <a href="<?= $fullFileUrl; ?>" class="btn btn-sm btn-primary w-100" target="_blank">Download</a>
                                    <?php else: ?>
                                        <button class="btn btn-sm btn-primary w-100" data-bs-toggle="modal" data-bs-target="#viewModal" 
                                                data-src="<?= esc($item['file']); ?>" data-type="<?= $fileExt; ?>">Play / View</button>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>

                    <?php endforeach; ?>
                </div>
            <?php endforeach; ?>

        <?php else: ?>
            <div class="col-12">
                <div class="card shadow-sm text-center">
                    <div class="card-body">
                        <p class="text-muted mb-0">No materials uploaded yet.</p>
                    </div>
                </div>
            </div>
        <?php endif; ?>


        <!-- View Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewModalLabel">Play Material</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body text-center p-0">
                        <div id="iframeContainer" style="display: none;">
                            <iframe id="materialFrame" width="100%" height="450" frameborder="0" allowfullscreen style="border: none;"></iframe>
                        </div>

                        <div id="videoContainer" style="display: none;">
                            <video id="videoPlayer" class="w-100" controls preload="metadata" style="max-height: 500px; width: 100%;">
                                <source id="videoSource" src="" type="">
                                Your browser does not support the video tag.
                            </video>
                        </div>

                        <div id="imageContainer" style="display: none;">
                            <img id="imageViewer" src="" alt="Material Image" class="img-fluid" style="max-height: 500px; max-width: 100%;">
                        </div>

                        <div id="fallbackContainer" style="display: none; padding: 2rem;">
                            <p class="text-muted">This material cannot be previewed directly. <a id="downloadLink" href="#" target="_blank" class="text-primary">Download or Open File</a></p>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <a id="downloadBtn" href="" class="btn btn-primary" target="_blank">Download File</a>
                    </div>
                </div>
            </div>
        </div>

      </main>
      
    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/user.js"></script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
  const viewModal = document.getElementById('viewModal');
  const iframeContainer = document.getElementById('iframeContainer');
  const videoContainer = document.getElementById('videoContainer');
  const imageContainer = document.getElementById('imageContainer');
  const fallbackContainer = document.getElementById('fallbackContainer');
  const materialFrame = document.getElementById('materialFrame');
  const videoPlayer = document.getElementById('videoPlayer');
  const videoSource = document.getElementById('videoSource');
  const imageViewer = document.getElementById('imageViewer');
  const downloadBtn = document.getElementById('downloadBtn');
  const downloadLink = document.getElementById('downloadLink');

  // Hide all containers initially
  function hideAllContainers() {
    iframeContainer.style.display = 'none';
    videoContainer.style.display = 'none';
    imageContainer.style.display = 'none';
    fallbackContainer.style.display = 'none';
  }

  viewModal.addEventListener('show.bs.modal', function(event) {
    const button = event.relatedTarget;
    const src = button.getAttribute('data-src');
    const fileType = button.getAttribute('data-type') || ''; // Extension from PHP
    const isExternalLink = /^https?:\/\//i.test(src); // Check if it's a URL
    const fullUrl = isExternalLink ? src : '<?= base_url('public/assets/uploadedfile/'); ?>' + src;

    // Set download link (always available)
    downloadBtn.href = fullUrl;
    downloadBtn.textContent = isExternalLink ? 'Open Link' : 'Download File';
    downloadLink.href = fullUrl;
    downloadLink.textContent = isExternalLink ? 'Open Link' : 'Download File';

    hideAllContainers();

    if (isExternalLink) {
      // Handle external links (YouTube, Google Drive, etc.)
      let embedSrc = src;
      if (src.includes('youtube.com/watch?v=') || src.includes('youtu.be/')) {
        // Improved YouTube embed handling to fix "refuse to connect" errors
        let videoId = '';
        if (src.includes('youtu.be/')) {
          videoId = src.split('youtu.be/')[1].split('?')[0];
        } else {
          videoId = src.split('v=')[1]?.split('&')[0];
        }
        if (videoId) {
          // Use embed URL with safe parameters: no related videos, modest branding, no autoplay (to avoid policy blocks)
          embedSrc = `https://www.youtube.com/embed/${videoId}?rel=0&modestbranding=1&autoplay=0&enablejsapi=1&origin=${encodeURIComponent(window.location.origin)}`;
        } else {
          // Fallback if ID extraction fails
          console.error('Could not extract YouTube video ID from:', src);
          fallbackContainer.style.display = 'block';
          return;
        }
      } else if (src.includes('drive.google.com')) {
        // Google Drive embed (basic; ensure the file is publicly shared)
        embedSrc = src.replace('/open?id=', '/preview') + '?embedded=true';
      } else if (src.includes('vimeo.com')) {
        // Vimeo embed (if needed)
        const videoId = src.split('/').pop();
        embedSrc = `https://player.vimeo.com/video/${videoId}?autoplay=0`;
      }
      // For other links, use iframe directly (with sandbox for security if needed)
      materialFrame.src = embedSrc;
      iframeContainer.style.display = 'block';
    } else {
      // Handle local files based on extension
      const ext = fileType.toLowerCase();
      if (['mp4', 'avi', 'mov', 'wmv', 'flv', 'webm', 'mkv'].includes(ext)) {
        // Video files
        videoSource.src = fullUrl;
        videoSource.type = `video/${ext === 'mp4' ? 'mp4' : (ext === 'webm' ? 'webm' : 'mp4')}`; // Fallback MIME type
        videoPlayer.load();
        videoContainer.style.display = 'block';
      } else if (['jpg', 'jpeg', 'png', 'gif', 'bmp', 'svg', 'webp'].includes(ext)) {
        // Image files
        imageViewer.src = fullUrl;
        imageContainer.style.display = 'block';
      } else {
        // Fallback for other local files (e.g., audio, unknown, or non-previewable)
        fallbackContainer.style.display = 'block';
      }
    }
  });

  viewModal.addEventListener('hidden.bs.modal', function() {
    // Clean up to prevent memory leaks and stop playback
    materialFrame.src = '';
    videoSource.src = '';
    if (videoPlayer) {
      videoPlayer.pause(); // Stop video if playing
      videoPlayer.load();
    }
    if (imageViewer) {
      imageViewer.src = '';
    }
    hideAllContainers();
  });

  // Optional: Handle video errors (e.g., if local video fails to load)
  if (videoPlayer) {
    videoPlayer.addEventListener('error', function(e) {
      console.error('Video load error:', e);
      fallbackContainer.style.display = 'block';
      videoContainer.style.display = 'none';
    });
  }

  // Optional: Handle iframe load errors (e.g., YouTube privacy issues)
  if (materialFrame) {
    materialFrame.addEventListener('error', function(e) {
      console.error('Iframe load error (possibly YouTube privacy):', e);
      fallbackContainer.innerHTML = '<p class="text-muted">This content cannot be embedded due to privacy settings. <a id="downloadLink" href="#" target="_blank" class="text-primary">Open in New Tab</a></p>';
      fallbackContainer.style.display = 'block';
      iframeContainer.style.display = 'none';
    });
  }
});

</script>


</body>

</html>