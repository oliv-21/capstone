<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Highlights</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <link href="../assets/img/logoicon.png" rel="icon" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
  
  <style>
     /* Fullscreen Modal */
    .image-modal {
      display: none;
      position: fixed;
      z-index: 2000;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0,0,0,0.8);
      justify-content: center;
      align-items: center;
      padding: 20px;
    }

    .image-modal img {
      max-width: 95%;
      max-height: 95%;
      border-radius: 10px;
      box-shadow: 0 0 20px rgba(0,0,0,0.3);
    }
  </style>

</head>

<body>
  <div class="wrapper d-flex">
    <!-- Sidebar -->
    <nav id="teacherSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img id="schoolLogo"  src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span id="schoolName" class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url(); ?>teacher-dashboard" class="nav-link d-flex align-items-center ">
          <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i> Dashboard
        </a>
        <a href="<?= base_url(); ?>teacher-students" class="nav-link d-flex align-items-center active">
          <i class="fas fa-chalkboard-teacher me-4 fa-lg fa-fw text-secondary"></i> Enrolled Students
        </a>
        <a href="<?= base_url(); ?>teacher-grades" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url(); ?>teacher-materials" class="nav-link d-flex align-items-center">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url(); ?>teacher-annoucement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcements
        </a>
        <a href="<?= base_url(); ?>teacher-interactive-learning" class="nav-link d-flex align-items-center">
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
            <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <!-- <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">2</span> -->
              </a>
              <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" aria-labelledby="notifDropdown"
                style="width: 350px; max-height:320px;">
                <li class="dropdown-header fw-bold">Notifications</li>
                <li><hr class="dropdown-divider"></li>
                <li class="px-3 py-2 small">
                  <strong>New Assignment</strong><br>
                  <span class="text-muted">Math worksheet uploaded.</span>
                </li>
                <li class="px-3 py-2 small">
                  <strong>New Message</strong><br>
                  <span class="text-muted">Parent sent a message.</span>
                </li>
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
          <h3 class="mb-4 fw-bold text-primary">📸 Student Highlights</h3>
          <!-- ADD PHOTO CARD -->
          <div id="addCard" 
              class="d-flex justify-content-center align-items-center border border-2 border-primary rounded-4 mt-4"
              style="width:200px; height:200px; cursor:pointer;">
              <i class="fa-solid fa-plus fa-3x text-primary"></i>
          </div>
          <div id="photoContainer" class="row g-3 mt-3"></div>



          <?php if (!empty($highlight)): ?>

              <?php 
                  // GROUP HIGHLIGHTS BY DATE
                  $grouped = [];

                  foreach ($highlight as $photo) {
                      $date = date("F j, Y", strtotime($photo['created_at']));
                      $grouped[$date][] = $photo;
                  }

                  // SORT NEWEST → OLDEST
                  uksort($grouped, function($a, $b) {
                      return strtotime($b) - strtotime($a);
                  });
              ?>

              <?php foreach ($grouped as $date => $photos): ?>

                  <!-- DATE HEADER -->
                  <div  class='border-bottom border-2 mb-3 mt-4'>
                    <h5 class="fw-bold text-primary ">📸 <?= $date ?></h5>
                  </div>

                  <!-- PHOTO GROUP -->
                  <div class="row g-3 ">

                      <?php foreach ($photos as $photo): ?>
                          <div class="col-6 col-md-3"> <!-- 2 per row on small screens, 4 per row on md+ screens -->
                              <div class="card shadow-sm rounded-4 h-100">
                                  <img 
                                      src="<?= base_url('public/assets/highlight/' . esc($photo['photo'])) ?>" 
                                      class="card-img-top rounded-3" 
                                      onclick="openImageModal(this.src)"
                                      style="height: 250px; object-fit: cover; width: 100%;">
                                  <div class="card-body p-2">
                                      <p class="small mb-0">
                                          <?= esc($photo['comment']) ?: 'No comment' ?>
                                      </p>
                                  </div>
                                  <button class="btn btn-sm btn-danger position-absolute top-0 end-0 m-1"
                                onclick="deletePhoto('<?= esc($photo['id']) ?>', this)">🗑️</button>
                              </div>
                          </div>
                      <?php endforeach; ?>

                  </div>



              <?php endforeach; ?>

          <?php else: ?>

              <p class="text-muted">No highlights uploaded yet.</p>

          <?php endif; ?>
          <div id="photoContainer" class="row g-3 mt-3"></div>


          

          <!-- MODAL -->
          <div class="modal fade" id="photoModal" tabindex="-1" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                  <div class="modal-content rounded-4">

                      <div class="modal-header">
                          <h5 class="modal-title">Add Photo</h5>
                          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                      </div>

                      <div class="modal-body">
                          <div class="text-center mb-3">
                              <video id="video" width="240" height="180" autoplay 
                                  playsinline class="border rounded-3 d-none"></video>

                              <canvas id="canvas" width="240" height="180" 
                                  class="border rounded-3 d-none"></canvas>

                              <img id="previewImg" width="240" height="180" 
                                  class="border rounded-3 d-none" />
                          </div>

                          <div class="d-flex justify-content-center gap-2 mb-3">
                              <button id="startCameraBtn" class="btn btn-outline-primary btn-sm">📷 Camera</button>
                              <input type="file" id="fileInput" accept="image/*" 
                                    class="form-control form-control-sm w-auto">
                              <button id="captureBtn" class="btn btn-primary btn-sm d-none">Capture</button>
                          </div>

                          <input type="hidden" name="userID" id="userID" 
                                value="<?= esc($student->admission_id) ?>">

                          <textarea id="commentInput" class="form-control" rows="2" 
                              placeholder="Optional comment..."></textarea>
                      </div>

                      <div class="modal-footer">
                          <button class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                          <button id="savePhotoBtn" class="btn btn-primary">Save</button>
                          <button id="resetBtn" class="btn btn-warning">Reset</button>
                      </div>

                  </div>
              </div>
          </div>
            <!-- FULLSCREEN IMAGE MODAL -->
          <div id="imageModal" class="image-modal" onclick="closeImageModal()">
            <img id="modalImage">
          </div>


      </main>


      
    </div>
  </div>

  <!-- Sidebar Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <!-- same HTML layout mo sa itaas hanggang dulo ng body -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
  const addCard = document.getElementById('addCard');
  const modal = new bootstrap.Modal(document.getElementById('photoModal'));
  const video = document.getElementById('video');
  const canvas = document.getElementById('canvas');
  const previewImg = document.getElementById('previewImg');
  const startCameraBtn = document.getElementById('startCameraBtn');
  const fileInput = document.getElementById('fileInput');
  const captureBtn = document.getElementById('captureBtn');
  const savePhotoBtn = document.getElementById('savePhotoBtn');
  const commentInput = document.getElementById('commentInput');
  const photoContainer = document.getElementById('photoContainer');
  const userID = document.getElementById('userID'); // ✅ Get hidden input
  let stream;
  let imageData = '';
  let currentObjectURL = ''; // To store the object URL for cleanup

  // Open modal
  addCard.addEventListener('click', () => {
    modal.show();
  });

  // Start camera
  startCameraBtn.addEventListener('click', async () => {
    try {
      stream = await navigator.mediaDevices.getUserMedia({ video: true });
      video.srcObject = stream;
      video.classList.remove('d-none');
      captureBtn.classList.remove('d-none');
      previewImg.classList.add('d-none');
      canvas.classList.add('d-none');
    } catch (err) {
      alert('Camera not available.');
    }
  });

  // Capture image
  let capturedFile = null; // store converted file

  captureBtn.addEventListener('click', () => {
    const ctx = canvas.getContext('2d');
    canvas.classList.remove('d-none');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    // Convert canvas to base64
    imageData = canvas.toDataURL('image/png');
    previewImg.src = imageData;
    previewImg.classList.remove('d-none');
    video.classList.add('d-none');
    captureBtn.classList.add('d-none');
    if (stream) stream.getTracks().forEach(track => track.stop());

    // ✅ Convert base64 → File
    fetch(imageData)
      .then(res => res.blob())
      .then(blob => {
        capturedFile = new File([blob], `photo_${Date.now()}.png`, { type: 'image/png' });
        // Create object URL for immediate use
        currentObjectURL = URL.createObjectURL(capturedFile);
      });
  });

  // Upload from file
  fileInput.addEventListener('change', (e) => {
    const file = e.target.files[0];
    if (file) {
      // Create object URL immediately for preview
      currentObjectURL = URL.createObjectURL(file);
      previewImg.src = currentObjectURL;
      previewImg.classList.remove('d-none');
      video.classList.add('d-none');
      canvas.classList.add('d-none');

      // Also set imageData for consistency (optional, since we use object URL now)
      const reader = new FileReader();
      reader.onload = (event) => {
        imageData = event.target.result;
      };
      reader.readAsDataURL(file);
    }
  });

  // Save to backend with SweetAlert confirmation
  savePhotoBtn.addEventListener('click', async () => {
    const comment = commentInput.value.trim();
    const formData = new FormData();
    const userId = userID.value;

    // Use captured file OR uploaded file
    const fileToSend = capturedFile || fileInput.files[0];

    if (!fileToSend) {
      alert('Please capture or upload a photo first.');
      return;
    }

    // Show SweetAlert confirmation
    Swal.fire({
      title: 'Are you sure?',
      text: 'Do you want to save this photo?',
      icon: 'question',
      showCancelButton: true,
      confirmButtonText: 'Yes, save it!',
      cancelButtonText: 'No, cancel'
    }).then(async (result) => {
      if (result.isConfirmed) {
        // Disable button to prevent spamming
        savePhotoBtn.disabled = true;
        savePhotoBtn.textContent = 'Saving...';

        formData.append('image', fileToSend);
        formData.append('comment', comment);
        formData.append('userID', userId);

        try {
          const response = await fetch('<?= base_url("photo-wall/save") ?>', {
            method: 'POST',
            body: formData
          });

          // Check if response is ok (status 200-299)
          if (!response.ok) {
            throw new Error(`HTTP error! status: ${response.status}`);
          }

          // Try to parse JSON
          const result = await response.json();

          if (result.status === 'success') {
            // Check if photoContainer exists before inserting
              if (photoContainer) {
    const newCard = document.createElement('div');
    newCard.className = "card p-2 shadow-sm rounded-4";
    newCard.style.width = "200px";

    const cacheBuster = '?t=' + Date.now();

    newCard.innerHTML = `
      <img src="${result.path}${cacheBuster}" 
           class="card-img-top rounded-3" 
           style="height:140px; object-fit:cover;" 
           onclick="openImageModal('${result.path}')">
      ${comment ? `<p class="small mt-2 text-center">${comment}</p>` : ''}
    `;

    // ⭐ ALWAYS SHOW IMMEDIATELY
    photoContainer.insertBefore(newCard, photoContainer.firstChild);
    window.location.reload();
}else {
                console.warn('photoContainer element not found.');
              }

            // Success alert
            Swal.fire({
              title: 'Success!',
              text: 'Photo saved successfully.',
              icon: 'success',
              timer: 2000,
              showConfirmButton: false
            });
          } else {
            // Server returned error status
            Swal.fire({
              title: 'Error',
              text: 'Error saving image: ' + (result.message || 'Unknown error'),
              icon: 'error'
            });
          }
        } catch (error) {
          // Catch network errors, JSON parsing errors, etc.
          console.error('Error:', error); // For debugging
          Swal.fire({
            title: 'Error',
            text: 'An error occurred while saving the image: ' + error.message,
            icon: 'error'
          });
        } finally {
          // Re-enable button
          savePhotoBtn.disabled = false;
          savePhotoBtn.textContent = 'Save Photo';
        }

        // Reset modal
        capturedFile = null;
        commentInput.value = '';
        fileInput.value = '';
        previewImg.classList.add('d-none');
        // Revoke object URL to free memory
        if (currentObjectURL) {
          URL.revokeObjectURL(currentObjectURL);
          currentObjectURL = '';
        }
        modal.hide();
      }
    });
  });

  // Reset modal content
  document.getElementById('resetBtn').addEventListener('click', () => {
    const video = document.getElementById('video');
    const canvas = document.getElementById('canvas');
    const previewImg = document.getElementById('previewImg');
    const fileInput = document.getElementById('fileInput');
    const commentInput = document.getElementById('commentInput');
    const captureBtn = document.getElementById('captureBtn');

    // Stop camera stream if running
    if (stream) {
      stream.getTracks().forEach(track => track.stop());
      stream = null;
    }

    // Clear all input fields
    fileInput.value = '';
    commentInput.value = '';
    capturedFile = null;
    // Revoke object URL if exists
    if (currentObjectURL) {
      URL.revokeObjectURL(currentObjectURL);
      currentObjectURL = '';
    }

    // Hide preview and show nothing
    video.classList.add('d-none');
    canvas.classList.add('d-none');
    previewImg.classList.add('d-none');
    captureBtn.classList.add('d-none');
  });
  async function deletePhoto(photoId, btn) {
    const confirmed = await Swal.fire({
        title: 'Are you sure?',
        text: 'This photo will be deleted permanently!',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    });

    if (confirmed.isConfirmed) {
        try {
            const response = await fetch('<?= base_url("photo-wall/delete") ?>', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ id: photoId })
            });

            const result = await response.json();

            if (result.status === 'success') {
                // Remove card from DOM
                btn.closest('.card').remove();

                Swal.fire({
                    title: 'Deleted!',
                    text: 'The photo has been deleted.',
                    icon: 'success',
                    timer: 1500,
                    showConfirmButton: false
                });
            } else {
                Swal.fire('Error', result.message || 'Failed to delete photo.', 'error');
            }
        } catch (err) {
            console.error(err);
            Swal.fire('Error', 'An error occurred while deleting.', 'error');
        }
    }
}





  
</script>
<script>
  function openImageModal(src) {
    document.getElementById("modalImage").src = src;
    document.getElementById("imageModal").style.display = "flex";
  }

  function closeImageModal() {
    document.getElementById("imageModal").style.display = "none";
  }
</script>


</body>
</html>
