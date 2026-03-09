<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Progress Report</title>
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
  <link href="assets/img/logoicon.png" rel="icon" />

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="assets/css/user.css">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <style>
  @media print {

    /* UI hide */
    nav,
    .admin-sidebar,
    .navbar,
    .btn,
    .nav-tabs,
    #showGraph {
      display: none !important;
    }

    /* IMPORTANT FIX */
    main {
      height: auto !important;
      overflow: visible !important;
    }

    body {
      margin: 0;
      padding: 0;
      background: #fff;
    }

    .main {
      width: 100% !important;
      margin: 0 !important;
    }

    /* ACTIVE QUARTER LANG */
    .tab-pane {
      display: none !important;
    }

    .tab-pane.active {
      display: block !important;
    }

    /* HUWAG MAPUTOL ANG CONTENT */
    .card {
      page-break-inside: avoid;
      border: none;
    }

    table {
      font-size: 13px;
    }

    h5 {
      color: #000 !important;
    }
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
        <a href="<?= base_url('student-classes'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fas fa-book me-4 fa-lg fa-fw text-secondary"></i> Materials
        </a>
        <a href="<?= base_url('student-progress-report'); ?>" class="nav-link d-flex align-items-center active ">
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
            <h5 class="text-primary m-0 ms-3 ">Progress Report</h5>
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
                <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false" onclick="markAsRead(<?= esc($student->user_id) ?>)"
               >
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
                  <a class="dropdown-item text-danger" href="<?= base_url(); ?>login">
                    <i class="fa-solid fa-right-from-bracket me-2"></i> Logout
                  </a>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">

        <!-- Student Info -->
        <div class="card mb-4 shadow-sm">
          <div class="card shadow-sm border-0 rounded-4">
            <div class="card-body d-flex align-items-center">
              <div class="me-3 text-primary fs-3">
                <i class="fa-solid fa-user-graduate"></i>
              </div>

              <div>
                <h5 class="card-title fw-bold mb-1 text-dark">
                  <i class="fa-solid fa-id-card me-2 text-secondary"></i>
                  <?= esc($student->full_name) ?>
                </h5>

                <p class="mb-0 text-muted">
                  <i class="fa-solid fa-layer-group me-3 text-info"></i>
                  <strong>Class:</strong> <?= esc($student->class_level) ?>
                </p>
              </div>
            </div>
          </div>

        </div>

        <!-- Quarter Tabs -->
        <ul class="nav nav-tabs" id="progressTabs" role="tablist">
          <li class="nav-item" role="presentation">
            <button class="nav-link active " id="q1-tab" data-bs-toggle="tab" data-bs-target="#q1" type="button" role="tab">1st Quarter</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link " id="q2-tab" data-bs-toggle="tab" data-bs-target="#q2" type="button" role="tab">2nd Quarter</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link " id="q3-tab" data-bs-toggle="tab" data-bs-target="#q3" type="button" role="tab">3rd Quarter</button>
          </li>
          <li class="nav-item" role="presentation">
            <button class="nav-link " id="q4-tab" data-bs-toggle="tab" data-bs-target="#q4" type="button" role="tab">4th Quarter</button>
          </li>
        </ul>
        <div class="d-flex justify-content-end mt-3">
          <button class="btn btn-secondary btn-sm me-2" onclick="printReport()">
            <i class="fa-solid fa-print me-1"></i> Print Report
          </button>

          <button class="btn btn-primary btn-sm" id="showGraph">
            <i class="fa-solid fa-chart-line me-1"></i> View Progress Graph
          </button>
        </div>
        <!-- Graph Modal -->
        <div class="modal fade" id="progressModal" tabindex="-1" aria-labelledby="progressModalLabel" aria-hidden="true">
          <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title text-primary" id="progressModalLabel"><i class="fa-solid fa-chart-line me-2"></i>Quarterly Progress Graph</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>
              <div class="modal-body">
                <canvas id="progressChart" height="150"></canvas>
              </div>
            </div>
          </div>
        </div>

        <!-- Tab Content -->
        <div class="tab-content mt-3" id="progressTabsContent">
          <?php
          // Define criteria lists once to avoid repetition
          $criteriaLists = [
            'social_emotional' => [
              'Getting along with others',
              'Gets use of school daily routines',
              'Builds good behavior with others',
              'Plays Cooperative',
              'Practice patience in doing the activity',
              'Builds good behavior with others',
              'Express feelings with simple words',
              'Smiles socially',
              'Develops attachment and trust to others'
            ],
            'practical_life' => [
              'Cross legs during circle time',
              'Sits on the chair with care',
              'Walks on the line',
              'Lines up with patience',
              'Recognizes own bag and belongings',
              'Carry things with independence'
            ],
            'fine_motor' => [
              'Squeezing toys with firmness',
              'Presses and rolls playdough with firmness',
              'Stacking sticks in the designated holes',
              'String large beads',
              'Place shapes in the right slots',
              'Bangs two toys together to create sounds',
              'Bangs hands on the table with coordination',
              'Assembles/Builds pink tower (sand, water)',
              'Performs pouring exercises',
              'Display grip in tongs exercise',
              'Grasps pencil, crayon with interest',
              'Performs pasting with eye-hand coordination'
            ],
            'gross_motor' => [
              'Walks with firm legs',
              'Perform stepping exercise on steppers',
              'Bend Body with balance',
              'Sits and stands up with balance',
              'Stands on foot at 2-3 counts',
              'Bounce and rolls the ball',
              'Kicking the ball with legs coordination',
              'Sticking pictures on designated area',
              'Catches, throws and kicks the ball with direction',
              'Dances with sense of rhythm'
            ],
            'sensory' => [
              'Listen attentively',
              'Develops sensory skills to identify hard and soft objects',
              'Recognize light and heavy objects',
              'Matches object to similar colors',
              'Develops hearing response on loud and soft sounds',
              'Responds to smelling exercises'
            ],
            'language' => [
              'Greets with simple words',
              'Head turns or nods when name is called',
              'Says own name',
              'Names people around',
              'Recognize family members',
              'Points parts of the body',
              'Recognize common fruits',
              'Names some common animals',
              'Names objects around',
              'Follows simple directions such as sit, down, jump, clap hands',
              'Recites finger plays and rhymes',
              'Listen during story time',
              'Shows interest in opening books'
            ]
          ];

          // Section configurations
          $sections = [
            [
              'key' => 'social_emotional',
              'title' => 'Social - Emotional',
              'icon' => 'fa-users'
            ],
            [
              'key' => 'practical_life',
              'title' => 'Practical Life (Ground Rules)',
              'icon' => 'fa-child'
            ],
            [
              'key' => 'fine_motor',
              'title' => 'Fine Motor Skills (Eye-Hand Coordination)',
              'icon' => 'fa-hand-paper'
            ],
            [
              'key' => 'gross_motor',
              'title' => 'Gross Motor Skills',
              'icon' => 'fa-running'
            ],
            [
              'key' => 'sensory',
              'title' => 'Sensory Skills',
              'icon' => 'fa-brain'
            ],
            [
              'key' => 'language',
              'title' => 'Language Development',
              'icon' => 'fa-language'
            ]
          ];

          // Loop through quarters (1-4)
          for ($quarter = 1; $quarter <= 4; $quarter++): 
            // Check if there's ANY data for this quarter
            $hasDataForQuarter = false;
            foreach ($studentGrade as $g) {
              if ($g['quarter'] == $quarter) {
                $hasDataForQuarter = true;
                break;
              }
            }
          ?>
            <div class="tab-pane fade <?= $quarter == 1 ? 'show active' : '' ?>" id="q<?= $quarter ?>" role="tabpanel">
              <?php if ($hasDataForQuarter): ?>
                <!-- If there's data, show all sections with tables -->
                <?php foreach ($sections as $section): 
                  $criteriaList = $criteriaLists[$section['key']];
                ?>
                  <div class="card shadow-sm <?= $section != $sections[0] ? 'mt-3' : '' ?>">
                    <div class="card-body">
                      <h5 class="fw-bold text-primary"><i class="fas <?= $section['icon'] ?> me-2 text-secondary"></i><?= $section['title'] ?></h5>
                      <table class="table table-bordered table-sm align-middle">
                        <thead class="table-light">
                          <tr>
                            <th>Criteria</th>
                            <th class="text-center" style="width: 250px;">Q<?= $quarter ?></th>
                          </tr>
                        </thead>
                        <tbody>
                          <?php foreach ($criteriaList as $criteria): 
                              $assessment = 'in progress'; // Default for individual criteria if no specific data
                              foreach ($studentGrade as $g):
                                  if ($g['criteria'] == $criteria && $g['quarter'] == $quarter): 
                                      $assessment = $g['assessment'];
                                      break;
                                  endif;
                              endforeach;

                              // Convert assessment text to stars
                              switch ($assessment) {
                                  case 'Excellent':
                                      $stars = '⭐⭐⭐⭐⭐';
                                      break;
                                  case 'Very Good':
                                      $stars = '⭐⭐⭐⭐';
                                      break;
                                  case 'Good':
                                      $stars = '⭐⭐⭐';
                                      break;
                                  case 'Average':
                                      $stars = '⭐⭐';
                                      break;
                                  case 'Needs Improvement':
                                      $stars = '⭐';
                                      break;
                                  default:
                                      $stars = 'In Progress';
                                      break;
                              }
                          ?>
                              <tr>
                                  <td><?= esc($criteria) ?></td>
                                  <td class="text-center"><?= esc($stars) ?></td>
                              </tr>
                          <?php endforeach; ?>
                          </tbody>

                      </table>
                      
                    </div>
                  </div>
                <?php endforeach; ?>

                <!-- Teacher Remarks (only if data exists for quarter) -->
                <div class="card shadow-sm mt-3 mb-5">
                  <div class="card-body">
                    <h5 class="fw-bold text-primary"><i class="fas fa-pen me-2 text-secondary"></i>Teacher Remarks / Comments</h5>
                    <div class="border rounded p-3 bg-light">
                      <p class="mb-0"><?= isset($remarks[$quarter]) ? esc($remarks[$quarter]['remarks']) : "No remarks available for this quarter." ?></p>
                    </div>
                  </div>
                </div>
              <?php else: ?>
                <!-- If no data for quarter, show a single message div instead of tables -->
                <div class="card shadow-sm mt-3 mb-5">
                  <div class="card-body text-center py-5">
                    <i class="fas fa-clock fa-3x text-warning mb-3"></i>
                    <h5 class="text-muted">Wait for Next Quarter</h5>
                    <p class="text-muted mb-0">Assessments and remarks for <?= $quarter == 1 ? '1st' : ($quarter == 2 ? '2nd' : ($quarter == 3 ? '3rd' : '4th')) ?> Quarter will be available soon.</p>
                  </div>
                </div>
              <?php endif; ?>
            </div>
          <?php endfor; ?>
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
document.getElementById('showGraph').addEventListener('click', function () {
  const rawData = <?= json_encode($studentGrade) ?>;
  
  const gradeMap = {
    'Excellent': 5,
    'Very Good': 4,
    'Good': 3,
    'Average': 2,
    'Needs Improvement': 1
  };

  const sectionRanges = {
    'Social - Emotional': [1, 9],
    'Practical Life (Ground Rules)': [10, 15],
    'Fine Motor Skills (Eye-Hand Coordination)': [16, 27],
    'Gross Motor Skills': [28, 37],
    'Sensory Skills': [38, 43],
    'Language Development': [44, 56]
  };

  // Prepare data
  const sectionAverages = {};
  for (const [section, [start, end]] of Object.entries(sectionRanges)) {
    sectionAverages[section] = [0, 0, 0, 0]; // quarters 1-4
  }

  // Sum scores per quarter and section
  rawData.forEach(g => {
    const q = parseInt(g.quarter) - 1;
    const id = parseInt(g.criteria_id);
    const score = gradeMap[g.assessment] || 0;

    for (const [section, [start, end]] of Object.entries(sectionRanges)) {
      if (id >= start && id <= end) {
        if (!sectionAverages[section][q]) sectionAverages[section][q] = 0;
        sectionAverages[section][q] += score;
      }
    }
  });

  // Count per section to compute average
  const sectionCounts = {
    'Social - Emotional': 9,
    'Practical Life (Ground Rules)': 6,
    'Fine Motor Skills (Eye-Hand Coordination)': 12,
    'Gross Motor Skills': 10,
    'Sensory Skills': 6,
    'Language Development': 13
  };

  for (const section in sectionAverages) {
    sectionAverages[section] = sectionAverages[section].map(
      (sum) => sum ? (sum / sectionCounts[section]).toFixed(2) : 0
    );
  }

  // Prepare datasets for Chart.js
  const colors = ['#4e73df','#1cc88a','#36b9cc','#f6c23e','#e74a3b','#858796'];
  const datasets = Object.entries(sectionAverages).map(([section, data], i) => ({
    label: section,
    data: data,
    borderColor: colors[i],
    backgroundColor: colors[i],
    fill: false,
    tension: 0.3,
    borderWidth: 2
  }));

  // Create chart
  const ctx = document.getElementById('progressChart').getContext('2d');
if (window.progressChart instanceof Chart) {
  window.progressChart.destroy();
}


  window.progressChart = new Chart(ctx, {
    type: 'line',
    data: {
      labels: ['1st Quarter', '2nd Quarter', '3rd Quarter', '4th Quarter'],
      datasets: datasets
    },
    options: {
      responsive: true,
      plugins: {
        title: {
          display: true,
          text: 'Section Progress Comparison per Quarter',
          font: { size: 18 }
        },
        legend: {
          position: 'bottom'
        },
        tooltip: {
          callbacks: {
            label: function(context) {
              return `${context.dataset.label}: ${context.parsed.y}⭐`;
            }
          }
        }
      },
      scales: {
        y: {
          beginAtZero: true,
          max: 5,
          title: { display: true, text: 'Average Stars (1–5)' }
        }
      }
    }
  });

  // Show modal
  new bootstrap.Modal(document.getElementById('progressModal')).show();
});
</script>
  <script>
    function printReport() {
      window.print();
    }
  </script>



</body>
</html>
