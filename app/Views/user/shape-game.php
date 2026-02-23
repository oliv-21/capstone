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
    .svg-wrap svg {
      width: 100%;
      height: 360px;
      background: #f9f9f9;
      border: 1px solid #ccc;
      border-radius: 6px;
    }

    .level-btn.active {
      background-color: var(--brandcolor) !important;
      color: #fff !important;
    }
    .btn-outline-primary {
      border-color: var(--brandcolor) !important;
      color: var(--brandcolor) !important;
      background-color: transparent;
  
    }

    .btn-outline-primary:hover {
      background-color: var(--brandcolor) !important;
      color: #fff !important;
    }


    .playground-card {
      border-radius: 10px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.1);
    }

    #confettiCanvas {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      pointer-events: none;
    }

    .hidden {
      display: none;
    }

    .matched-shape {
      filter: drop-shadow(0 0 6px #4caf50);
      cursor: default !important;
      opacity: 0.9;
    }
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
        <div class="container-fluid text-center">
          <div class="d-flex justify-content-between align-items-end mb-3 game-top">
            <div class="text-start">
              <a href="<?= base_url(); ?>student-interactive-learning" class="btn btn-link text-decoration-none text-dark "><i class="fa-solid fa-arrow-left me-2"></i> Back to Games</a>
              <h3 class="fw-bold mb-1 text-primary">Shape Matcher — Drag & Match!</h3>
              <div class="small-note">Drag shapes to their matching outlines. Complete all to finish!</div>
            </div>

            <div class="controls-row d-flex gap-3 me-5 ">
              <button class="btn btn-sm btn-outline-primary level-btn active" data-level="easy">Easy</button>
              <button class="btn btn-sm btn-outline-primary level-btn" data-level="medium">Medium</button>
              <button class="btn btn-sm btn-outline-primary level-btn" data-level="hard">Hard</button>
            </div>
          </div>

          <div class="row g-3">
            <div class="col-lg-8">
              <div class="svg-wrap position-relative" style="min-height:360px;">
                <svg id="gameCanvas" viewBox="0 0 600 360" xmlns="http://www.w3.org/2000/svg">
                  <rect width="600" height="360" fill="#f0f0f0" stroke="#ccc" stroke-width="2" rx="12" />
                </svg>
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

            <div class="col-lg-4">
              <div class="card p-3 playground-card">
                <div class="mb-2">
                  <strong>Completed</strong>
                  <div id="completedNote" class="small-note">Not yet completed.</div>
                </div>
                <div class="mt-3 d-grid gap-2">
                  <button id="resetBtn" class="btn btn-outline-danger btn-sm">Reset</button>
                  <button id="exportBtn" class="btn btn-outline-success btn-sm">
                    <i class="fa-solid fa-download me-1"></i> Export PNG
                  </button>
                </div>
                <canvas id="confettiCanvas" class="hidden"></canvas>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Sidebar Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>
  <script>
    (function () {
      const canvas = document.getElementById('gameCanvas');
      const progressText = document.getElementById('progressText');
      const progressBar = document.getElementById('progressBar');
      const completedNote = document.getElementById('completedNote');
      const resetBtn = document.getElementById('resetBtn');
      const exportBtn = document.getElementById('exportBtn');
      const confettiCanvas = document.getElementById('confettiCanvas');

      const levelButtons = document.querySelectorAll('.level-btn');
      let currentLevel = 'easy';
      let shapes = [];
      let targets = [];
      let matched = 0;

      const shapeTypes = ['circle', 'square', 'triangle', 'star', 'hexagon', 'pentagon'];

      function getRandomColor() {
        const colors = ['#FF6B6B', '#4ECDC4', '#556270', '#C7F464', '#FFCC5C', '#6A4C93'];
        return colors[Math.floor(Math.random() * colors.length)];
      }

      function getShapeCount(level) {
        if (level === 'easy') return 3;
        if (level === 'medium') return 4;
        if (level === 'hard') return 6;
        return 3;
      }

      function createShape(type, x, y, size, isTarget = false) {
        const ns = "http://www.w3.org/2000/svg";
        let el;

        if (type === "circle") el = document.createElementNS(ns, "circle");
        else if (type === "square") el = document.createElementNS(ns, "rect");
        else el = document.createElementNS(ns, "polygon");

        el.setAttribute("data-type", type);
        el.setAttribute("stroke", "#333");
        el.setAttribute("stroke-width", 2);
        el.style.cursor = isTarget ? "default" : "pointer";

        if (isTarget) {
          el.setAttribute("fill", "none");
          el.setAttribute("stroke", "#888");
          el.setAttribute("stroke-width", 3);
          el.setAttribute("opacity", 0.3);
        } else {
          el.setAttribute("fill", getRandomColor());
        }

        // Polygon helper function
        function pointsForPolygon(sides) {
          const pts = [];
          for (let i = 0; i < sides; i++) {
            const angle = (i * 360 / sides - 90) * Math.PI / 180;
            pts.push(`${x + size / 2 * Math.cos(angle)},${y + size / 2 * Math.sin(angle)}`);
          }
          return pts.join(" ");
        }

        if (type === "circle") {
          el.setAttribute("cx", x);
          el.setAttribute("cy", y);
          el.setAttribute("r", size / 2);
        } else if (type === "square") {
          el.setAttribute("x", x - size / 2);
          el.setAttribute("y", y - size / 2);
          el.setAttribute("width", size);
          el.setAttribute("height", size);
        } else if (type === "triangle") {
          el.setAttribute("points", pointsForPolygon(3));
        } else if (type === "star") {
          const pts = [];
          for (let i = 0; i < 5; i++) {
            const outerAngle = i * 72 * Math.PI / 180 - Math.PI / 2;
            const innerAngle = outerAngle + 36 * Math.PI / 180;
            pts.push(`${x + size / 2 * Math.cos(outerAngle)},${y + size / 2 * Math.sin(outerAngle)}`);
            pts.push(`${x + size / 4 * Math.cos(innerAngle)},${y + size / 4 * Math.sin(innerAngle)}`);
          }
          el.setAttribute("points", pts.join(" "));
        } else if (type === "pentagon") {
          el.setAttribute("points", pointsForPolygon(5));
        } else if (type === "hexagon") {
          el.setAttribute("points", pointsForPolygon(6));
        }

        return el;
      }
      function getSVGPoint(evt) {
          const pt = canvas.createSVGPoint();
          pt.x = evt.clientX;
          pt.y = evt.clientY;
          return pt.matrixTransform(canvas.getScreenCTM().inverse());
        }

        function enableDrag(shape, target) {
          let offsetX, offsetY;
          let dragging = false;
          let initPos; // store initial position attributes for revert

          shape.addEventListener("mousedown", (e) => {
            e.preventDefault();
            dragging = true;

            const cursorPt = getSVGPoint(e);
            if (shape.tagName === "circle") {
              const cx = parseFloat(shape.getAttribute("cx"));
              const cy = parseFloat(shape.getAttribute("cy"));
              offsetX = cursorPt.x - cx;
              offsetY = cursorPt.y - cy;
              initPos = { cx, cy };
            } else if (shape.tagName === "rect") {
              const x = parseFloat(shape.getAttribute("x"));
              const y = parseFloat(shape.getAttribute("y"));
              offsetX = cursorPt.x - x;
              offsetY = cursorPt.y - y;
              initPos = { x, y };
            } else {
              // polygon: calculate offset based on first point
              const points = shape.getAttribute("points").split(" ").map(p => p.split(",").map(Number));
              offsetX = cursorPt.x - points[0][0];
              offsetY = cursorPt.y - points[0][1];
              initPos = points;
            }

            shape.setAttribute("opacity", "0.8");

            document.addEventListener("mousemove", dragMove);
            document.addEventListener("mouseup", dragEnd);
          });

          function dragMove(e) {
            if (!dragging) return;
            e.preventDefault();
            const cursorPt = getSVGPoint(e);
            const newX = cursorPt.x - offsetX;
            const newY = cursorPt.y - offsetY;

            if (shape.tagName === "circle") {
              shape.setAttribute("cx", newX);
              shape.setAttribute("cy", newY);
            } else if (shape.tagName === "rect") {
              shape.setAttribute("x", newX);
              shape.setAttribute("y", newY);
            } else {
              // reposition polygon points relative to new x,y offset based on initial points
              const newPoints = initPos.map(([px, py]) => `${px - initPos[0][0] + newX},${py - initPos[0][1] + newY}`);
              shape.setAttribute("points", newPoints.join(" "));
            }
          }

          function dragEnd() {
            dragging = false;
            shape.setAttribute("opacity", "1");
            document.removeEventListener("mousemove", dragMove);
            document.removeEventListener("mouseup", dragEnd);

            const shapeBBox = shape.getBBox();
            const targetBBox = target.getBBox();

            const dx = (shapeBBox.x + shapeBBox.width / 2) - (targetBBox.x + targetBBox.width / 2);
            const dy = (shapeBBox.y + shapeBBox.height / 2) - (targetBBox.y + targetBBox.height / 2);
            const distance = Math.sqrt(dx * dx + dy * dy);

            if (distance < 35 && shape.getAttribute("data-type") === target.getAttribute("data-type")) {
              let animX = targetBBox.x + targetBBox.width / 2 - (shapeBBox.x + shapeBBox.width / 2);
              let animY = targetBBox.y + targetBBox.height / 2 - (shapeBBox.y + shapeBBox.height / 2);
              animateMove(shape, animX, animY, () => {
                shape.setAttribute("pointer-events", "none");
                shape.classList.add("matched-shape");
                matched++;
                updateProgress();
              });
            } else {
              // revert to initial position
              if (shape.tagName === "circle") {
                shape.setAttribute("cx", initX + shapeBBox.width / 2);
                shape.setAttribute("cy", initY + shapeBBox.height / 2);
              } else if (shape.tagName === "rect") {
                shape.setAttribute("x", initX);
                shape.setAttribute("y", initY);
              } else {
                // polygons revert skipped for simplicity
              }
            }
          }
        }

      function animateMove(shape, dx, dy, callback) {
        let steps = 15, i = 0;
        function step() {
          if (i >= steps) {
            callback();
            return;
          }
          if (shape.tagName === "circle") {
            shape.setAttribute("cx", parseFloat(shape.getAttribute("cx")) + dx / steps);
            shape.setAttribute("cy", parseFloat(shape.getAttribute("cy")) + dy / steps);
          } else if (shape.tagName === "rect") {
            shape.setAttribute("x", parseFloat(shape.getAttribute("x")) + dx / steps);
            shape.setAttribute("y", parseFloat(shape.getAttribute("y")) + dy / steps);
          } else {
            const pts = shape.getAttribute("points").split(" ").map(p => {
              const [px, py] = p.split(",");
              return `${parseFloat(px) + dx / steps},${parseFloat(py) + dy / steps}`;
            });
            shape.setAttribute("points", pts.join(" "));
          }
          i++;
          requestAnimationFrame(step);
        }
        step();
      }

      function updateProgress() {
        const total = shapes.length;
        const percent = total ? Math.round((matched / total) * 100) : 0;
        progressBar.style.width = percent + "%";
        progressText.textContent = `${matched} / ${total}`;
        if (matched === total && total > 0) {
          completedNote.textContent = "Completed! 🎉";
          spawnConfetti();
        }
      }

      function spawnConfetti(count = 50) {
        confettiCanvas.classList.remove("hidden");
        const ctx = confettiCanvas.getContext("2d");
        confettiCanvas.width = window.innerWidth;
        confettiCanvas.height = window.innerHeight;
        const particles = [];
        for (let i = 0; i < count; i++) {
          particles.push({
            x: Math.random() * confettiCanvas.width,
            y: -10 - Math.random() * 200,
            vx: (Math.random() - 0.5) * 6,
            vy: Math.random() * 4 + 2,
            r: Math.random() * 8 + 6,
            color: getRandomColor(),
            rot: Math.random() * 360,
            vr: (Math.random() - 0.5) * 8
          });
        }
        function loop() {
          ctx.clearRect(0, 0, confettiCanvas.width, confettiCanvas.height);
          for (let i = particles.length - 1; i >= 0; i--) {
            const p = particles[i];
            p.x += p.vx;
            p.y += p.vy;
            p.rot += p.vr;
            ctx.save();
            ctx.translate(p.x, p.y);
            ctx.rotate(p.rot * Math.PI / 180);
            ctx.fillStyle = p.color;
            ctx.fillRect(-p.r / 2, -p.r / 2, p.r, p.r);
            ctx.restore();
            if (p.y > confettiCanvas.height + 20) particles.splice(i, 1);
          }
          if (particles.length > 0) requestAnimationFrame(loop);
          else confettiCanvas.classList.add("hidden");
        }
        loop();
      }

      // Initialize level with shapes and targets
      function initLevel(level) {
        currentLevel = level;
        matched = 0;
        canvas.innerHTML = '';
        shapes = [];
        targets = [];
        completedNote.textContent = 'Not yet completed.';
        progressBar.style.width = '0%';
        progressText.textContent = `0 / ${getShapeCount(level)}`;
        const spacingX = 100; // larger than size to prevent overlap
        const spacingY = 120;

        const count = getShapeCount(level);
        const usedShapes = shapeTypes.slice(0, count);

        usedShapes.forEach((type, i) => {
          // Create targets (dimmed shapes on right)
          const xTarget = 400 + (i % 3) * spacingX;
          const yTarget = 120 + Math.floor(i / 3) * spacingY;
          const target = createShape(type, xTarget, yTarget, 80, true);
          targets.push(target);
          canvas.appendChild(target);

          // Create draggable shapes on left
          const xShape = 50 + (i % 3) * spacingX;
          const yShape = 120 + Math.floor(i / 3) * spacingY;
          const shape = createShape(type, xShape, yShape, 80);
          shapes.push(shape);
          canvas.appendChild(shape);

          enableDrag(shape, target);
        });
      }

      // Button event listeners
      levelButtons.forEach(btn => {
        btn.addEventListener('click', () => {
          levelButtons.forEach(b => b.classList.remove('active'));
          btn.classList.add('active');
          initLevel(btn.dataset.level);
        });
      });

      resetBtn.addEventListener('click', () => initLevel(currentLevel));

      exportBtn.addEventListener('click', () => {
        const serializer = new XMLSerializer();
        const source = serializer.serializeToString(canvas);
        const svgBlob = new Blob([source], { type: "image/svg+xml;charset=utf-8" });
        const url = URL.createObjectURL(svgBlob);
        const link = document.createElement("a");
        link.href = url;
        link.download = "shape-matcher.svg";
        document.body.appendChild(link);
        link.click();
        link.remove();
        URL.revokeObjectURL(url);
      });

      // Start initial level
      initLevel(currentLevel);
    })();
  </script>
</body>

</html>
