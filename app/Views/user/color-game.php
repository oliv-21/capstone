<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside  Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">
</head>


<body>
  <div class="wrapper d-flex">
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
        <a href="<?= base_url('student-classes'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url('student-progress-report'); ?>" class="nav-link d-flex align-items-center  ">
          <i class="fas fa-chart-line me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url('student-guardiansetup'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-users me-4 fa-lg fa-fw text-secondary"></i> Guardian Setup
        </a>
        <a href="<?= base_url('student-attendance'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Attendance
        </a>
        
        <a href="<?= base_url('student-interactive-learning'); ?>" class="nav-link d-flex align-items-center active">
          <i class="fa-solid fa-chalkboard me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a>
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
            <h5 class="text-primary m-0 ms-3 ">Interactive Learning</h5>
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
                  <?php if ($hasUnread): ?>
                      <!-- Red dot only -->
                      <span class="position-absolute top-0 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
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
                  <a class="dropdown-item text-danger" href="<?= base_url(); ?>login">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>
            <!-- Page Content -->
      <!-- MAIN (Learn Colors Game) -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y:auto;">
        <div class="container-fluid text-center">
          <div class="d-flex justify-content-between align-items-end mb-3 game-top">
            <div class="text-start">
              <a href="<?= base_url(); ?>student-interactive-learning" class="btn btn-link text-decoration-none text-dark "><i class="fa-solid fa-arrow-left me-2"></i> Back to Games</a>
              <h3 class="fw-bold mb-1 text-primary">Learn Colors — Name the Colors!</h3>
              <div class="small-note">Click colors to hear their names. Explore the rainbow!</div>
            </div>

            <div class="controls-row d-flex gap-3 me-5 ">
              <button class="btn btn-primary" id="colorsHint">Say All</button>
            </div>
          </div>

          <section id="colors" class="game" aria-hidden="false" style="display:block; margin-top:18px;">
            <div class="topbar" style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:12px;">
              <div style="display:flex; gap:12px; align-items:center;">
              </div>
            </div>
            <div class="colors-grid" id="colorsGrid" style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
              <!-- Colors populated by JS -->
            </div>
          </section>
        </div>
      </main>
    </div>
  </div>

  <!-- Sidebar Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

  <script>
    const colors = [
      {name: 'Red', hex: '#ff0000', emoji: '🔴'},
      {name: 'Blue', hex: '#0000ff', emoji: '🔵'},
      {name: 'Green', hex: '#00ff00', emoji: '🟢'},
      {name: 'Yellow', hex: '#ffff00', emoji: '🟡'},
      {name: 'Orange', hex: '#ffa500', emoji: '🟠'},
      {name: 'Purple', hex: '#800080', emoji: '🟣'},
      {name: 'Pink', hex: '#ffc0cb', emoji: '🩷'},
      {name: 'Black', hex: '#000000', emoji: '⚫'},
      {name: 'White', hex: '#ffffff', emoji: '⚪'},
      {name: 'Brown', hex: '#8B4513', emoji: '🟤'}
    ];

    const colorsGrid = document.getElementById('colorsGrid');

    function speak(text){
      try {
        const utterance = new SpeechSynthesisUtterance(text);
        utterance.rate = 0.9;
        utterance.pitch = 1.1;
        speechSynthesis.cancel();
        speechSynthesis.speak(utterance);
      } catch(e) {
        console.warn('Speech not supported', e);
      }
    }

    function playTone(freq = 880, duration = 0.12) {
      try {
        const ctx = new (window.AudioContext || window.webkitAudioContext)();
        const osc = ctx.createOscillator();
        const gain = ctx.createGain();
        osc.type = 'sine';
        osc.frequency.value = freq;
        osc.connect(gain);
        gain.connect(ctx.destination);
        gain.gain.setValueAtTime(0.0001, ctx.currentTime);
        gain.gain.exponentialRampToValueAtTime(0.2, ctx.currentTime + 0.02);
        osc.start();
        gain.gain.exponentialRampToValueAtTime(0.0001, ctx.currentTime + duration);
        setTimeout(() => {
          osc.stop();
          ctx.close();
        }, duration * 1000 + 50);
      } catch(e) { /* ignore */ }
    }

    function successChime() {
      playTone(880,0.09);
      setTimeout(() => playTone(1200,0.08), 80);
    }

    function spawnConfetti(x = window.innerWidth / 2, y = window.innerHeight / 3, count = 14) {
      // Simple DOM-based confetti using colored divs (no external library needed)
      for (let i = 0; i < count; i++) {
        const confetti = document.createElement('div');
        confetti.style.position = 'fixed';
        confetti.style.left = x + 'px';
        confetti.style.top = y + 'px';
        confetti.style.width = '8px';
        confetti.style.height = '8px';
        confetti.style.backgroundColor = `hsl(${Math.random() * 360}, 100%, 50%)`;
        confetti.style.pointerEvents = 'none';
        confetti.style.zIndex = '9999';
        confetti.style.borderRadius = '50%';
        document.body.appendChild(confetti);

        // Animate with GSAP (or fallback to CSS)
        if (typeof gsap !== 'undefined') {
          gsap.to(confetti, {
            x: (Math.random() - 0.5) * 400,
            y: Math.random() * 400 + 200,
            rotation: Math.random() * 720,
            opacity: 0,
            scale: 0,
            duration: 2 + Math.random() * 1,
            ease: 'power2.out',
            onComplete: () => confetti.remove()
          });
        } else {
          // Fallback CSS animation
          confetti.style.transition = 'all 2s ease-out';
          confetti.style.transform = `translate(${ (Math.random() - 0.5) * 400 }px, ${Math.random() * 400 + 200}px) rotate(${Math.random() * 720}deg) scale(0)`;
          confetti.style.opacity = '0';
          setTimeout(() => confetti.remove(), 2000);
        }
      }
    }


    // Populate colors grid and setup click listeners
    colors.forEach(c => {
      const card = document.createElement('div');
      card.className = 'color-card';
      card.style.background = '#fff';
      card.style.borderRadius = '12px';
      card.style.padding = '12px';
      card.style.display = 'flex';
      card.style.flexDirection = 'column';
      card.style.alignItems = 'center';
      card.style.justifyContent = 'center';
      card.style.cursor = 'pointer';
      card.style.boxShadow = '0 8px 18px rgba(0,0,0,0.06)';
      card.style.transition = 'transform 0.2s ease';

      const colorDiv = document.createElement('div');
      colorDiv.className = 'color-circle';
      colorDiv.style.width = '60px';
      colorDiv.style.height = '60px';
      colorDiv.style.borderRadius = '50%';
      colorDiv.style.backgroundColor = c.hex;
      colorDiv.style.marginBottom = '8px';
      colorDiv.style.border = '3px solid #ddd'; // Subtle border for visibility

      const nameDiv = document.createElement('div');
      nameDiv.style.fontWeight = '700';
      nameDiv.textContent = c.name;

      card.appendChild(colorDiv);
      card.appendChild(nameDiv);

      card.addEventListener('click', () => {
        // Animate color circle bounce (now works with GSAP included)
        if (typeof gsap !== 'undefined') {
          gsap.fromTo(colorDiv, { y: -10, scale: 0.9 }, { y: 0, scale: 1.05, duration: 0.45, ease: 'bounce.out' });
        }
        speak(c.name);
        successChime();
        spawnConfetti(); // Now implements actual confetti
      });

      colorsGrid.appendChild(card);
    });

    // Say all colors in sequence on "Say All" button click
    document.getElementById('colorsHint').addEventListener('click', () => {
      colors.forEach((c, i) => {
        setTimeout(() => {
          const colorDiv = colorsGrid.children[i].querySelector('.color-circle');
          if (typeof gsap !== 'undefined') {
            gsap.fromTo(colorDiv, { scale: 0.8 }, { scale: 1.05, duration: 0.35 });
          }
          speak(c.name);
        }, i * 1200); // 1.2 second interval for a relaxed pace
      });
    });
  </script>
</body>

</html>
