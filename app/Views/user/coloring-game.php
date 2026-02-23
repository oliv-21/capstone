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

  <style>
    body { font-family: "Nunito", sans-serif; }
    .game-top { display:flex; gap:12px; align-items:center; justify-content:space-between; flex-wrap:wrap; }
    .controls-row { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
    .palette { display:flex; gap:8px; flex-wrap:wrap; align-items:center; }
    .swatch { width:40px; height:40px; border-radius:8px; border:2px solid #fff; box-shadow:0 6px 14px rgba(0,0,0,0.08); cursor:pointer; }
    .swatch.selected { outline:3px solid rgba(59,130,246,0.18); transform:scale(1.06); }
    .svg-wrap { display:flex; align-items:center; justify-content:center; padding:12px; background:#fff; border-radius:12px; box-shadow:0 8px 20px rgba(0,0,0,0.06); min-height:320px; }
    .meta { display:flex; gap:8px; align-items:center; flex-wrap:wrap; }
    #progressBar { min-width:0px; }
    #confettiCanvas { position:fixed; left:0; top:0; width:100%; height:100%; pointer-events:none; z-index:9999; }
    .small-note { font-size:0.9rem; color:#6b7280; }
    .hidden { display:none !important; }
    .selector-btn { min-width:48px; border-radius:10px; padding:8px 10px; display:inline-flex; align-items:center; justify-content:center; gap:8px; cursor:pointer; background:#fff; border:1px solid #e6eefc; }
    .selector-btn.active { box-shadow:0 8px 18px rgba(0,0,0,0.08); transform:translateY(-3px); background:linear-gradient(180deg,#fff,#f7fbff); }
    .selector-row { display:flex; gap:8px; flex-wrap:wrap; align-items:center; margin-bottom:10px; }
    .region:focus { outline: 3px solid rgba(59,130,246,0.18); }
  </style>
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
      <!-- MAIN (enhanced with simple drawings, house simplified & fish improved) -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y:auto;">
        <div class="container-fluid">
          <div class="d-flex justify-content-between align-items-start mb-3 game-top">
            <div>
              <a href="<?= base_url(); ?>student-interactive-learning" class="btn btn-link text-decoration-none text-dark "><i class="fa-solid fa-arrow-left me-2"></i> Back to Games</a>
              <h3 class="fw-bold mb-1 text-primary">Coloring Fun — Click to Fill</h3>
              <div class="small-note">Choose an object, pick a color, then click a region to color it. Progress saves automatically in this browser.</div>
            </div>

            <div class="controls-row">
              <div class="selector-row" role="tablist" aria-label="Choose drawing">
                <button class="btn selector-btn active" data-draw="house" aria-pressed="true">🏠 House</button>
                <button class="btn selector-btn" data-draw="apple" aria-pressed="false">🍎 Apple</button>
                <button class="btn selector-btn" data-draw="sun" aria-pressed="false">☀️ Sun</button>
                <button class="btn selector-btn" data-draw="flower" aria-pressed="false">🌸 Flower</button>
                <button class="btn selector-btn" data-draw="car" aria-pressed="false">🚗 Car</button>
                <button class="btn selector-btn" data-draw="fish" aria-pressed="false">🐟 Fish</button>
              </div>
            </div>
          </div>

          <div class="row g-3">
            <!-- Left: SVG area -->
            <div class="col-lg-8">
              <div class="svg-wrap">
                <div id="svgContainer" style="width:100%;max-width:720px;"></div>
              </div>

              <div class="d-flex align-items-center justify-content-between mt-2">
                <div class="small-note">Progress: <span id="progressText">0 / 0</span></div>
                <div style="width:50%;">
                  <div class="progress" style="height:12px;">
                    <div id="progressBar" class="progress-bar" role="progressbar" style="width:0%"></div>
                  </div>
                </div>
              </div>
            </div>

            <!-- Right: Palette & info -->
            <div class="col-lg-4">
              <div class="card p-3 playground-card">
                <h6 class="mb-2">Palette</h6>
                <div id="palette" class="palette mb-3" role="list"></div>

                <div class="mb-2 small-note">Selected: <span id="currentColorLabel" style="font-weight:700">#FF6B6B</span></div>

                <hr>

                <div class="mb-2">
                  <strong>Completed</strong>
                  <div id="completedNote" class="small-note">Not yet completed.</div>
                </div>

                <div class="mt-3 d-grid">
                  <div class="d-flex gap-2">
                    <button id="undoBtn" class="btn btn-outline-secondary btn-sm"><i class="fa-solid fa-rotate-left"></i> Undo</button>
                    <button id="resetBtn" class="btn btn-outline-danger btn-sm">Reset</button>
                  </div>
                  <div class="d-flex gap-2 mt-2">
                    <button id="clearSavedBtn" class="btn btn-outline-warning btn-sm">Clear Saved</button>
                    <button id="fillAllBtn" class="btn btn-primary btn-sm">Fill All</button>
                  </div>
                  <button id="saveBtn" class="btn btn-outline-primary btn-sm mt-2">Save Progress</button>
                  <button id="exportBtn" class="btn btn-outline-success btn-sm mt-2"><i class="fa-solid fa-download me-1"></i> Export PNG</button>
                </div>

                <div class="mt-3">
                  <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" id="soundToggle" checked>
                    <label class="form-check-label small-note" for="soundToggle">Sounds</label>
                  </div>
                </div>

              </div>
            </div>
          </div>

        </div>

        <canvas id="confettiCanvas" class="hidden"></canvas>
      </main>

    </div>
  </div>

  <!-- Sidebar Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>
   <script>
  (function(){
    // ---------- Drawings (simplified house and improved fish) ----------
    const drawings = {
      house: {
        title: 'House',
        svg: `
          <svg viewBox="0 0 600 420" xmlns="http://www.w3.org/2000/svg" aria-label="House">
            <rect width="600" height="420" fill="#fff"/>
            <!-- roof -->
            <polygon id="roof" class="region" data-region="roof" points="150,140 300,60 450,140" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- house body -->
            <rect id="body" class="region" data-region="body" x="170" y="140" width="260" height="180" fill="#fff" stroke="#333" stroke-width="3" rx="8"/>
            <!-- door -->
            <rect id="door" class="region" data-region="door" x="295" y="220" width="50" height="100" fill="#fff" stroke="#333" stroke-width="3" rx="4"/>
            <!-- left window -->
            <rect id="winL" class="region" data-region="winL" x="200" y="170" width="50" height="44" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- right window -->
            <rect id="winR" class="region" data-region="winR" x="350" y="170" width="50" height="44" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- chimney -->
            <rect id="chimney" class="region" data-region="chimney" x="370" y="80" width="18" height="40" fill="#fff" stroke="#333" stroke-width="3" rx="3"/>
          </svg>`
      },
      apple: {
        title: 'Apple',
        svg: `
          <svg viewBox="0 0 420 420" xmlns="http://www.w3.org/2000/svg" aria-label="Apple">
            <rect width="420" height="420" fill="#fff"/>
            <!-- apple body -->
            <path id="appleBody" class="region" data-region="appleBody" d="M210 120 C270 100 330 140 320 200 C310 260 250 300 210 320 C170 300 110 260 100 200 C90 140 150 100 210 120 Z" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- leaf -->
            <path id="leaf" class="region" data-region="leaf" d="M260 90 C300 80 320 120 280 130 C260 135 240 110 260 90 Z" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- stem -->
            <rect id="stem" class="region" data-region="stem" x="245" y="80" width="8" height="20" fill="#fff" stroke="#333" stroke-width="3" rx="2"/>
          </svg>`
      },
      sun: {
        title: 'Sun',
        svg: `
          <svg viewBox="0 0 420 420" xmlns="http://www.w3.org/2000/svg" aria-label="Sun">
            <rect width="420" height="420" fill="#fff"/>
            <!-- sun core -->
            <circle id="core" class="region" data-region="core" cx="210" cy="210" r="68" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- rays (8 simple rounded rectangles rotated) -->
            <g id="rays">
              <rect id="r1" class="region" data-region="r1" x="206" y="12" width="8" height="56" rx="4" fill="#fff" stroke="#333" stroke-width="3" transform="rotate(0 210 210)"/>
              <rect id="r2" class="region" data-region="r2" x="206" y="12" width="8" height="56" rx="4" fill="#fff" stroke="#333" stroke-width="3" transform="rotate(45 210 210)"/>
              <rect id="r3" class="region" data-region="r3" x="206" y="12" width="8" height="56" rx="4" fill="#fff" stroke="#333" stroke-width="3" transform="rotate(90 210 210)"/>
              <rect id="r4" class="region" data-region="r4" x="206" y="12" width="8" height="56" rx="4" fill="#fff" stroke="#333" stroke-width="3" transform="rotate(135 210 210)"/>
              <rect id="r5" class="region" data-region="r5" x="206" y="12" width="8" height="56" rx="4" fill="#fff" stroke="#333" stroke-width="3" transform="rotate(180 210 210)"/>
              <rect id="r6" class="region" data-region="r6" x="206" y="12" width="8" height="56" rx="4" fill="#fff" stroke="#333" stroke-width="3" transform="rotate(225 210 210)"/>
              <rect id="r7" class="region" data-region="r7" x="206" y="12" width="8" height="56" rx="4" fill="#fff" stroke="#333" stroke-width="3" transform="rotate(270 210 210)"/>
              <rect id="r8" class="region" data-region="r8" x="206" y="12" width="8" height="56" rx="4" fill="#fff" stroke="#333" stroke-width="3" transform="rotate(315 210 210)"/>
            </g>
          </svg>`
      },
      flower: {
        title: 'Flower',
        svg: `
          <svg viewBox="0 0 420 420" xmlns="http://www.w3.org/2000/svg" aria-label="Flower">
            <rect width="420" height="420" fill="#fff"/>
            <!-- petals -->
            <circle id="pet1" class="region" data-region="pet1" cx="210" cy="130" r="42" fill="#fff" stroke="#333" stroke-width="3"/>
            <circle id="pet2" class="region" data-region="pet2" cx="260" cy="180" r="42" fill="#fff" stroke="#333" stroke-width="3"/>
            <circle id="pet3" class="region" data-region="pet3" cx="230" cy="240" r="42" fill="#fff" stroke="#333" stroke-width="3"/>
            <circle id="pet4" class="region" data-region="pet4" cx="190" cy="240" r="42" fill="#fff" stroke="#333" stroke-width="3"/>
            <circle id="pet5" class="region" data-region="pet5" cx="160" cy="180" r="42" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- center -->
            <circle id="center" class="region" data-region="center" cx="210" cy="190" r="30" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- stem -->
            <rect id="stem" class="region" data-region="stem" x="204" y="220" width="12" height="140" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- grass base -->
            <ellipse id="soil" class="region" data-region="soil" cx="210" cy="380" rx="200" ry="30" fill="#fff" stroke="#333" stroke-width="0"/>
          </svg>`
      },
      car: {
        title: 'Car',
        svg: `
          <svg viewBox="0 0 700 300" xmlns="http://www.w3.org/2000/svg" aria-label="Car">
            <rect width="700" height="300" fill="#fff"/>
            <!-- car body -->
            <rect id="body" class="region" data-region="body" x="80" y="110" width="540" height="90" rx="20" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- car top -->
            <rect id="top" class="region" data-region="top" x="210" y="70" width="280" height="70" rx="15" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- windows -->
            <rect id="win" class="region" data-region="win" x="260" y="82" width="180" height="45" fill="#fff" stroke="#333" stroke-width="3"/>
            <!-- wheels -->
            <circle id="wheel1" class="region" data-region="wheel1" cx="220" cy="215" r="30" fill="#fff" stroke="#333" stroke-width="3"/>
            <circle id="wheel2" class="region" data-region="wheel2" cx="480" cy="215" r="30" fill="#fff" stroke="#333" stroke-width="3"/>
          </svg>`
      },
          fish: {
      title: 'Fish',
      svg: `
        <svg viewBox="0 0 600 360" xmlns="http://www.w3.org/2000/svg" aria-label="Fish">
          <rect width="600" height="360" fill="#fff"/>
          <!-- Body -->
          <ellipse id="body" class="region" data-region="body" cx="300" cy="180" rx="130" ry="70" fill="#fff" stroke="#333" stroke-width="3"/>
          <!-- Tail -->
          <path id="tail" class="region" data-region="tail"
            d="M170 130 Q120 160 100 120 Q90 180 100 240 Q120 200 170 230 Z"
            fill="#fff" stroke="#333" stroke-width="3"/>
          <!-- Top Fin -->
          <path id="topfin" class="region" data-region="topfin"
            d="M280 110 Q300 60 320 110 Z"
            fill="#fff" stroke="#333" stroke-width="3"/>
          <!-- Bottom Fin -->
          <path id="bottomfin" class="region" data-region="bottomfin"
            d="M280 250 Q300 290 320 250 Z"
            fill="#fff" stroke="#333" stroke-width="3"/>
          <!-- Eye -->
          <circle id="eyeWhite" class="region" data-region="eyeWhite" cx="360" cy="160" r="12" fill="#fff" stroke="#333" stroke-width="2"/>
          <circle id="eyePupil" class="region" data-region="eyePupil" cx="363" cy="160" r="5" fill="#fff" stroke="#333" stroke-width="1"/>
          <!-- Mouth -->
          <path  d="M365 200 Q380 210 395 200" fill="none" stroke="#333" stroke-width="3" stroke-linecap="round"/>
        </svg>`
    }

    };

    // palette & UI settings
    const paletteColors = [
      '#FF6B6B','#FF9AA2','#FFD66D','#FFB86B','#6BCB77','#00C2A8','#4D96FF','#7AA0FF','#A66DD4','#F06292',
      '#B07A4A','#C6CED8','#111827','#F4A261'
    ];

    // DOM refs
    const svgContainer = document.getElementById('svgContainer');
    const paletteEl = document.getElementById('palette');
    const currentColorLabel = document.getElementById('currentColorLabel');
    const progressBar = document.getElementById('progressBar');
    const progressText = document.getElementById('progressText');
    const completedNote = document.getElementById('completedNote');
    const saveBtn = document.getElementById('saveBtn');
    const resetBtn = document.getElementById('resetBtn');
    const clearSavedBtn = document.getElementById('clearSavedBtn');
    const undoBtn = document.getElementById('undoBtn');
    const soundToggle = document.getElementById('soundToggle');
    const fillAllBtn = document.getElementById('fillAllBtn');
    const exportBtn = document.getElementById('exportBtn');
    const confettiCanvas = document.getElementById('confettiCanvas');

    const selectorBtns = Array.from(document.querySelectorAll('.selector-btn'));

    // app state
    let currentDrawing = 'house';
    let currentColor = paletteColors[0];
    let regionEls = [];
    let state = {}; // region -> color
    let history = []; // undo stack
    const STORAGE_PREFIX = 'bs_coloring_v3_';
    let confettiParticles = [];

    // build palette
    function buildPalette(){
      paletteEl.innerHTML = '';
      paletteColors.forEach(hex=>{
        const b = document.createElement('button');
        b.className = 'swatch';
        b.style.background = hex;
        b.type = 'button';
        b.dataset.hex = hex;
        b.setAttribute('aria-label', hex);
        b.addEventListener('click', ()=> selectColor(hex));
        paletteEl.appendChild(b);
      });
      selectColor(currentColor);
    }
    function selectColor(hex){
      currentColor = hex;
      currentColorLabel.textContent = hex;
      document.querySelectorAll('.swatch').forEach(s=>s.classList.remove('selected'));
      const el = Array.from(paletteEl.querySelectorAll('.swatch')).find(x => x.dataset.hex === hex);
      if(el) el.classList.add('selected');
    }

    // render chosen drawing
    function renderDrawing(name){
      currentDrawing = name;
      // update selector UI
      selectorBtns.forEach(btn => {
        if(btn.dataset.draw === name) btn.classList.add('active'); else btn.classList.remove('active');
        btn.setAttribute('aria-pressed', btn.dataset.draw === name ? 'true' : 'false');
      });

      svgContainer.innerHTML = drawings[name].svg;
      const svgEl = svgContainer.querySelector('svg');
      regionEls = Array.from(svgEl.querySelectorAll('.region[data-region]'));

      // ensure default values and attach handlers
      regionEls.forEach(el=>{
        if(!el.getAttribute('data-default')) el.setAttribute('data-default', el.getAttribute('fill') || '#ffffff');
        el.setAttribute('tabindex','0');
        el.style.transition = 'transform .12s, fill .12s';
        el.addEventListener('click', ()=> applyColorToRegion(el));
        el.addEventListener('keydown', (e)=> { if(e.key==='Enter' || e.key===' ') { e.preventDefault(); applyColorToRegion(el); }});
      });

      // load saved state for this drawing
      loadState();
      updateProgress();
    }

    // storage helpers
    function storageKeyFor(name){ return STORAGE_PREFIX + name; }
    function saveStateToStorage(){ try{ localStorage.setItem(storageKeyFor(currentDrawing), JSON.stringify(state)); }catch(e){} }
    function loadState(){
      state = {};
      const raw = localStorage.getItem(storageKeyFor(currentDrawing));
      if(raw){
        try { state = JSON.parse(raw) || {}; }catch(e){ state = {}; }
      }
      regionEls.forEach(el => {
        const key = el.getAttribute('data-region');
        if(state[key]) el.setAttribute('fill', state[key]);
        else el.setAttribute('fill', el.getAttribute('data-default') || '#ffffff');
      });
      history = [];
      updateProgress();
    }
    function clearSaved(){
      localStorage.removeItem(storageKeyFor(currentDrawing));
      loadState();
    }

    // coloring actions
    function applyColorToRegion(el){
      const region = el.getAttribute('data-region');
      const prev = el.getAttribute('fill') || el.getAttribute('data-default') || '#ffffff';
      if(prev === currentColor) return;
      el.setAttribute('fill', currentColor);
      history.push({ region, prev });
      state[region] = currentColor;
      saveStateToStorage();
      playClickSound();
      el.animate([{ transform: 'scale(0.98)' }, { transform: 'scale(1)' }], { duration: 120 });
      updateProgress();
    }
    function undo(){
      const last = history.pop();
      if(!last) return;
      const el = regionEls.find(r => r.getAttribute('data-region') === last.region);
      if(el){
        el.setAttribute('fill', last.prev || el.getAttribute('data-default') || '#ffffff');
      }
      if(last.prev && last.prev !== (el.getAttribute('data-default')||'#ffffff')) state[last.region] = last.prev;
      else delete state[last.region];
      saveStateToStorage();
      updateProgress();
    }
    function resetDrawing(){
      if(!confirm('Reset this drawing?')) return;
      regionEls.forEach(el => el.setAttribute('fill', el.getAttribute('data-default') || '#ffffff'));
      state = {};
      history = [];
      saveStateToStorage();
      updateProgress();
    }
    function fillAll(){
      regionEls.forEach(el=>{
        const region = el.getAttribute('data-region');
        const prev = el.getAttribute('fill') || el.getAttribute('data-default') || '#ffffff';
        if(prev !== currentColor){
          history.push({ region, prev });
          el.setAttribute('fill', currentColor);
          state[region] = currentColor;
        }
      });
      saveStateToStorage();
      updateProgress();
    }

    // progress calculation
    function updateProgress(){
      const total = regionEls.length;
      let filled = 0;
      regionEls.forEach(el=>{
        const f = (el.getAttribute('fill')||'').trim();
        const def = (el.getAttribute('data-default')||'').trim();
        if(f && f !== def) filled++;
      });
      const percent = total ? Math.round((filled/total)*100) : 0;
      progressBar.style.width = percent + '%';
      progressBar.setAttribute('aria-valuenow', percent);
      progressText.textContent = `${filled} / ${total}`;
      if(filled === total && total > 0){
        completedNote.textContent = 'Completed! Well done 🎉';
        celebrate();
      } else {
        completedNote.textContent = 'Not yet completed.';
      }
    }

    // audio feedback
    function playClickSound(){
      if(!soundToggle.checked) return;
      try{
        const actx = new (window.AudioContext || window.webkitAudioContext)();
        const o = actx.createOscillator(); const g = actx.createGain();
        o.type='sine'; o.frequency.value=880; o.connect(g); g.connect(actx.destination);
        g.gain.setValueAtTime(0.001, actx.currentTime); g.gain.exponentialRampToValueAtTime(0.2, actx.currentTime+0.02);
        o.start(); setTimeout(()=>{ g.gain.exponentialRampToValueAtTime(0.001, actx.currentTime+0.05); o.stop(); actx.close(); }, 120);
      }catch(e){}
    }

    // celebrate: confetti + chime
    function celebrate(){
      try{
        if(soundToggle.checked){
          const actx = new (window.AudioContext || window.webkitAudioContext)();
          const o1 = actx.createOscillator(); const o2 = actx.createOscillator(); const g = actx.createGain();
          o1.frequency.value=880; o2.frequency.value=1200;
          o1.connect(g); o2.connect(g); g.connect(actx.destination);
          g.gain.setValueAtTime(0.001, actx.currentTime); g.gain.exponentialRampToValueAtTime(0.2, actx.currentTime+0.02);
          o1.start(); o2.start();
          setTimeout(()=>{ g.gain.exponentialRampToValueAtTime(0.001, actx.currentTime+0.12); o1.stop(); o2.stop(); actx.close(); }, 220);
        }
      }catch(e){}
      spawnConfetti();
    }

    // confetti (simple)
    function spawnConfetti(count=40){
      confettiCanvas.classList.remove('hidden');
      const ctx = confettiCanvas.getContext('2d');
      confettiCanvas.width = innerWidth; confettiCanvas.height = innerHeight;
      for(let i=0;i<count;i++){
        confettiParticles.push({
          x: Math.random()*confettiCanvas.width,
          y: -10 - Math.random()*200,
          vx: (Math.random()-0.5)*6,
          vy: Math.random()*4 + 2,
          r: Math.random()*8 + 6,
          color: paletteColors[Math.floor(Math.random()*paletteColors.length)],
          rot: Math.random()*360,
          vr: (Math.random()-0.5)*8
        });
      }
      if(confettiParticles.length) requestAnimationFrame(confettiLoop);
    }
    function confettiLoop(){
      const ctx = confettiCanvas.getContext('2d');
      ctx.clearRect(0,0,confettiCanvas.width, confettiCanvas.height);
      for(let i=confettiParticles.length-1;i>=0;i--){
        const p = confettiParticles[i];
        p.x += p.vx; p.y += p.vy; p.vy += 0.12; p.rot += p.vr;
        ctx.save(); ctx.translate(p.x,p.y); ctx.rotate(p.rot*Math.PI/180);
        ctx.fillStyle = p.color; ctx.fillRect(-p.r/2, -p.r/2, p.r, p.r*1.6);
        ctx.restore();
        if(p.y > confettiCanvas.height + 40) confettiParticles.splice(i,1);
      }
      if(confettiParticles.length) requestAnimationFrame(confettiLoop); else confettiCanvas.classList.add('hidden');
    }

    // export PNG
    function exportPNG(){
      const svgEl = svgContainer.querySelector('svg');
      if(!svgEl) return alert('No drawing to export.');
      const serializer = new XMLSerializer();
      const svgString = serializer.serializeToString(svgEl);
      const img = new Image();
      const svgBlob = new Blob([svgString], {type: 'image/svg+xml;charset=utf-8'});
      const url = URL.createObjectURL(svgBlob);
      img.onload = function(){
        const canvas = document.createElement('canvas');
        canvas.width = img.width; canvas.height = img.height;
        const ctx = canvas.getContext('2d');
        ctx.fillStyle = '#fff'; ctx.fillRect(0,0,canvas.width,canvas.height);
        ctx.drawImage(img,0,0);
        URL.revokeObjectURL(url);
        const png = canvas.toDataURL('image/png');
        const a = document.createElement('a');
        a.href = png; a.download = `${currentDrawing}.png`;
        document.body.appendChild(a); a.click(); a.remove();
      };
      img.src = url;
    }

    // selector wiring
    document.querySelectorAll('.selector-btn').forEach(btn => {
      btn.addEventListener('click', ()=> {
        const name = btn.dataset.draw;
        if(name) {
          renderDrawing(name);
        }
      });
    });

    // other wiring
    saveBtn.addEventListener('click', ()=> { saveStateToStorage(); saveBtn.textContent='Saved'; setTimeout(()=> saveBtn.textContent='Save Progress',900); });
    resetBtn.addEventListener('click', resetDrawing);
    clearSavedBtn.addEventListener('click', ()=> { if(confirm('Clear saved progress for this drawing?')) clearSaved(); });
    undoBtn.addEventListener('click', undo);
    fillAllBtn.addEventListener('click', ()=> { if(confirm('Fill all regions with selected color?')) fillAll(); });
    exportBtn.addEventListener('click', exportPNG);
    window.addEventListener('resize', ()=> { confettiCanvas.width = innerWidth; confettiCanvas.height = innerHeight; });

    // init
    buildPalette();
    renderDrawing(currentDrawing);

    // keyboard: palette navigation
    paletteEl.addEventListener('keydown', e=>{
      const swatches = Array.from(paletteEl.querySelectorAll('.swatch'));
      const idx = swatches.indexOf(document.activeElement);
      if(e.key === 'ArrowRight'){ e.preventDefault(); swatches[(idx+1+swatches.length)%swatches.length].focus(); }
      if(e.key === 'ArrowLeft'){ e.preventDefault(); swatches[(idx-1+swatches.length)%swatches.length].focus(); }
    });

    // expose for debug (optional)
    window._bsColoring = { renderDrawing, selectColor: (h)=>{ selectColor(h); }, state };

  })();
  </script>
</body>

</html>
