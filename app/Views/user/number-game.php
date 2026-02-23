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
        
        <a href="<?= base_url('student-interactive-learning'); ?>" class="nav-link d-flex align-items-center active ">
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
                <li class="dropdown-item-text d-flex align-items-center mt-2">
                  <a href="<?= base_url('/guardian/dashboard/' . esc($student->parent_id)) ?>">
                        <img src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>" alt="Parent"
                            class="rounded-circle border border-2 me-2" width="25" height="25">
                        <span> (Parent)</span>
                  </a>
                </li>
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
            <!-- Page Content -->
      <!-- MAIN (Count the Numbers Game) -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y:auto;">
        <div class="container-fluid text-center">
          <div class="d-flex justify-content-between align-items-end mb-3 game-top">
            <div class="text-start">
              <a href="<?= base_url(); ?>student-interactive-learning" class="btn btn-link text-decoration-none text-dark "><i class="fa-solid fa-arrow-left me-2"></i> Back to Games</a>
              <h3 class="fw-bold mb-1 text-primary">Count the Numbers — Learn to Count!</h3>
              <div class="small-note">Click numbers to hear their names. Count along with the sequence!</div>
            </div>

            <div class="controls-row d-flex gap-3 me-5 ">
              <button class="btn btn-primary" id="numbersHint">Count All</button>
            </div>
          </div>

          <section id="numbers" class="game" aria-hidden="false" style="display:block; margin-top:18px;">
            <div class="topbar" style="display:flex; align-items:center; justify-content:space-between; gap:12px; margin-bottom:12px;">
              <div style="display:flex; gap:12px; align-items:center;">
              </div>
            </div>
            <div class="numbers-grid" id="numbersGrid" style="display:grid; grid-template-columns:repeat(3,1fr); gap:12px;">
              <!-- Numbers populated by JS -->
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
    const numbers = [
      {value: 1, display: '1', name: 'One'},
      {value: 2, display: '2', name: 'Two'},
      {value: 3, display: '3', name: 'Three'},
      {value: 4, display: '4', name: 'Four'},
      {value: 5, display: '5', name: 'Five'},
      {value: 6, display: '6', name: 'Six'},
      {value: 7, display: '7', name: 'Seven'},
      {value: 8, display: '8', name: 'Eight'},
      {value: 9, display: '9', name: 'Nine'},
      {value: 10, display: '10', name: 'Ten'}
    ];

    const numbersGrid = document.getElementById('numbersGrid');

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


    // Populate numbers grid and setup click listeners
    numbers.forEach(n => {
      const card = document.createElement('div');
      card.className = 'number-card';
      // Bright gradient based on #ff6b6b
      card.style.background = `linear-gradient(135deg, #ff6b6b, #ff8787)`; 
      card.style.borderRadius = '20px';
      card.style.padding = '15px';
      card.style.display = 'flex';
      card.style.flexDirection = 'column';
      card.style.alignItems = 'center';
      card.style.justifyContent = 'center';
      card.style.cursor = 'pointer';
      card.style.boxShadow = '0 12px 20px rgba(0,0,0,0.15)';
      card.style.transition = 'all 0.2s ease';
      card.style.position = 'relative';
      card.style.overflow = 'hidden';

      // Add playful background circles
      for (let i = 0; i < 3; i++) {
        const circle = document.createElement('div');
        circle.style.position = 'absolute';
        circle.style.width = `${20 + Math.random() * 30}px`;
        circle.style.height = circle.style.width;
        circle.style.backgroundColor = `rgba(255,255,255,${0.2 + Math.random() * 0.2})`;
        circle.style.borderRadius = '50%';
        circle.style.top = `${Math.random() * 80}%`;
        circle.style.left = `${Math.random() * 80}%`;
        circle.style.pointerEvents = 'none';
        card.appendChild(circle);
      }

      const displayDiv = document.createElement('div');
      displayDiv.className = 'number-display';
      displayDiv.style.fontSize = '50px';
      displayDiv.style.fontWeight = 'bold';
      displayDiv.style.color = '#fff'; // white on gradient
      displayDiv.textContent = n.display;

      const nameDiv = document.createElement('div');
      nameDiv.style.marginTop = '10px';
      nameDiv.style.fontWeight = '700';
      nameDiv.style.fontSize = '18px';
      nameDiv.style.color = '#fff';
      nameDiv.textContent = n.name;

      card.appendChild(displayDiv);
      card.appendChild(nameDiv);

      // Hover effect
      card.addEventListener('mouseenter', () => {
        gsap.to(card, { scale: 1.02, boxShadow: '0 16px 28px rgba(0,0,0,0.25)', duration: 0.2 });
      });
      card.addEventListener('mouseleave', () => {
        gsap.to(card, { scale: 1, boxShadow: '0 12px 20px rgba(0,0,0,0.15)', duration: 0.2 });
      });

      card.addEventListener('click', () => {
        // Animate number bounce
        if (typeof gsap !== 'undefined') {
          gsap.fromTo(displayDiv, { y: -15, scale: 0.9 }, { y: 0, scale: 1.1, duration: 0.5, ease: 'bounce.out' });
        }
        speak(n.name);
        successChime();
        spawnConfetti();
      });

      numbersGrid.appendChild(card);
    });


    // Count all numbers in sequence on "Count All" button click
    document.getElementById('numbersHint').addEventListener('click', () => {
      numbers.forEach((n, i) => {
        setTimeout(() => {
          const displayDiv = numbersGrid.children[i].querySelector('.number-display');
          if (typeof gsap !== 'undefined') {
            gsap.fromTo(displayDiv, { scale: 0.8 }, { scale: 1.05, duration: 0.35 });
          }
          speak(n.name);
        }, i * 1000); // 1 second interval for counting rhythm
      });
    });
  </script>
</body>

</html>
