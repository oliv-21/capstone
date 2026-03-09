<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Materials</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="assets/img/logoicon.png" rel="icon" />
  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
</head>
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
      color: #7d6c6cff;
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

<body>
  <div class="wrapper d-flex">
    <!-- Sidebar -->
    <nav id="teacherSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img id="schoolLogo" src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span id="schoolName" class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url(); ?>teacher-dashboard" class="nav-link d-flex align-items-center ">
          <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i> Dashboard
        </a>
        <a href="<?= base_url(); ?>teacher-students" class="nav-link d-flex align-items-center">
          <i class="fas fa-chalkboard-teacher me-4 fa-lg fa-fw text-secondary"></i> Enrolled Students
        </a>
        <a href="<?= base_url(); ?>teacher-grades" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url(); ?>teacher-materials" class="nav-link d-flex align-items-center active">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url(); ?>teacher-annoucement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcements
        </a>
        <a href="<?= base_url(); ?>teacher-interactive-learning" class="nav-link d-flex align-items-center ">
          <i class="fas fa-layer-group me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a>
      </div>
    </nav>

    <!-- Main Content -->
    <div class="main col-md-10">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4 p-1">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>

          <div class="d-flex align-items-center ms-auto py-1">
            <!-- Notification Dropdown -->
             <select id="school_year" class="form-select">

              <?php foreach ($yearsRecord as $r): ?>
                <option value="<?= $r['id'] ?>" 
                  <?= ($r['id'] == $selectedOpeningId) ? 'selected' : '' ?>>
                  <?= $r['school_year'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            
            <?php
            $unreadCount = 0;
            if (!empty($notification)) {
                foreach ($notification as $n) {
                    if ($n['is_read'] == 0) {
                        $unreadCount++;
                    }
                }
            }
            ?>
            <!-- Notification Dropdown -->


            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false"
                onclick="markAsRead(<?= esc($teacher['user_id']) ?>)">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <?php if ($unreadCount > 0): ?>
                <span id="notifBadge"
                  class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unreadCount ?>
                </span>
                <?php endif; ?>
              </a>

              <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown"
                style="width: 350px; max-height:320px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li>
                  <hr class="dropdown-divider">
                </li>
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




            <div class="me-3 position-relative border-start border-2 ps-3">
              <a href="<?= base_url(); ?>teacher-chats" class="text-decoration-none text-primary">
                <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
              </a>
            </div>
            <!-- Profile Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($profilepic)) ?>" alt="Profile Image" class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
                
               <span class="fw-bold ms-2"><?= esc($teacher['lastname']) ?></span>

              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('teacherProfile-info'); ?>"><i class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile Info</a></li>
                <li><a class="dropdown-item" href="<?= base_url('teacherProfile'); ?>"><i class='fa-solid fa-lock me-3 mb-3 text-primary mt-2'></i>forget Password</a></li>
                <li>  <a class="dropdown-item text-danger" href="<?= base_url(); ?>login">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <!-- Page Content -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <h2 class="mb-4 text-primary">Materials / Assignments</h2>

        <!-- Upload Button -->
        <div class="mb-3">
          <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#uploadMaterialModal">
            <i class="fa-solid fa-upload me-2"></i>Upload Material
          </button>
        </div>

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

            <div class="row g-3">
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
                

                <div class="col-12 col-md-6 col-lg-3 g-4"> <!-- 4 per row on lg -->
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
                        <div class="youtube-thumbnail w-100 h-100 d-flex align-items-center justify-content-center" style="background-image: url('<?= $youtubeThumbnail; ?>'); background-size: cover; background-position: center;">
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
                      <div class="d-flex gap-2">
                        <?php if ($isDocument): ?>
                          <a href="<?= $fullFileUrl; ?>" class="btn btn-sm btn-primary flex-fill" target="_blank">Download</a>
                        <?php else: ?>
                          <button class="btn btn-sm btn-primary flex-fill" data-bs-toggle="modal" data-bs-target="#viewModal" 
                                  data-src="<?= esc($item['file']); ?>" data-type="<?= $fileExt; ?>">Play / View</button>
                        <?php endif; ?>
                        <button type="button"
                                class="btn btn-sm btn-danger"
                                onclick="confirmDelete('<?= addslashes(esc($item['title'])); ?>', '<?= base_url('teacher/deleteMaterial/' . $item['id']); ?>')">
                          <i class="fas fa-trash me-1"></i> Delete
                        </button>
                      </div>
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

        <!-- Upload Material Modal -->
        <div class="modal fade" id="uploadMaterialModal" tabindex="-1" aria-labelledby="uploadMaterialModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <form id="uploadForm" method="post" action="<?= base_url(); ?>uploadClassRoom" enctype="multipart/form-data" >
                <div class="modal-header">
                  <h5 class="modal-title" id="uploadMaterialModalLabel">Upload Material</h5>
                  <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                  <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text"  name="title" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <!-- <label class="form-label">Class</label> -->
                    <input type="text" hidden name="classLevel" value="<?= esc($teacher['teacher_department']) ?>" class="form-control" readonly>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Description</label>
                    <input type="text"  name="description" class="form-control" required>
                  </div>
                  <div class="mb-3">
                    <label class="form-label">Upload Type</label>
                    <select id="uploadType" class="form-select" name="uploadType" required>
                      <option value="">Select Type</option>
                      <option value="file">File</option>
                      <option value="link">Link</option>
                    </select>
                  </div>

                  <div class="mb-3" id="fileInput" style="display:none;">
                    <label class="form-label">Choose File</label>
                    <input type="file" name="filename" class="form-control">
                  </div>

                  <div class="mb-3" id="linkInput" style="display:none;">
                    <label class="form-label">Paste Link (YouTube, Google Drive, etc.)</label>
                    <input type="url" name="link" class="form-control" placeholder="https://example.com">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-primary">Upload</button>
                  <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                </div>
              </form>
            </div>
          </div>
        </div>
      </main>


    </div>
  </div>
        <!-- View Material Modal -->
        <div class="modal fade" id="viewModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title">Play Material</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <iframe id="materialFrame" width="100%" height="450" frameborder="0" allowfullscreen></iframe>
              </div>
            </div>
          </div>
        </div>


  <!-- Sidebar Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>
  <script>
  document.getElementById('uploadType').addEventListener('change', function() {
    const type = this.value;
    document.getElementById('fileInput').style.display = (type === 'file') ? 'block' : 'none';
    document.getElementById('linkInput').style.display = (type === 'link') ? 'block' : 'none';
  });
</script>
<script>
const viewModal = document.getElementById('viewModal');
const materialFrame = document.getElementById('materialFrame');

viewModal.addEventListener('show.bs.modal', function (event) {
  const button = event.relatedTarget;
  const src = button.getAttribute('data-src');

  // Handle YouTube links
  let embedSrc = src;
  if (src.includes('youtube.com/watch?v=')) {
    const videoId = src.split('v=')[1];
    embedSrc = `https://www.youtube.com/embed/${videoId}`;
  }

  materialFrame.src = embedSrc;
});

viewModal.addEventListener('hidden.bs.modal', function () {
  materialFrame.src = ''; // Stop playback when closed
});


function confirmDelete(title, deleteUrl) {
  Swal.fire({
    title: 'Are you sure?',
    text: `Do you really want to delete "${title}"? This action cannot be undone.`,
    icon: 'warning',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    cancelButtonColor: '#3085d6',
    confirmButtonText: 'Yes, delete it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      window.location.href = deleteUrl;
    }
  });
}

document.addEventListener("DOMContentLoaded", function() {
    <?php if(session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Sorry',
            text: '<?= session()->getFlashdata('error'); ?>',
            confirmButtonColor: '#d33'
        });
    <?php endif; ?>

    <?php if(session()->getFlashdata('success')): ?>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: '<?= session()->getFlashdata('success'); ?>',
            confirmButtonColor: '#3085d6'
        });
    <?php endif; ?>
});
document.getElementById('uploadForm').addEventListener('submit', function(e) {
  e.preventDefault(); // prevent default form submission

  Swal.fire({
    title: 'Are you sure?',
    text: "Do you want to upload this material?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#3085d6',
    cancelButtonColor: '#d33',
    confirmButtonText: 'Yes, upload it!',
    cancelButtonText: 'Cancel'
  }).then((result) => {
    if (result.isConfirmed) {
      this.submit(); // submit the form if confirmed
    }
  });
});
document.getElementById('school_year').addEventListener('change', function () {
      let selectedId = this.value;

      if (!selectedId) return; // ignore placeholder

      fetch("<?= base_url('/set-opening-id'); ?>", {
          method: "POST",
          headers: {
              "Content-Type": "application/x-www-form-urlencoded"
          },
          body: "id=" + selectedId
      })
      .then(response => response.json())
      .then(data => {
          if (data.status === 'success') {
              location.reload();
          }
      });
  });



</script>
</body>
</html>
