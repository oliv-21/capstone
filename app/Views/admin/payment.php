<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Tuition Payment Management</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">
  <link href="assets/img/logoicon.png" rel="icon" />
  <!-- DataTables -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">

  <!-- Custom CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
  <style>
    #reportTable_filter {
    display: none !important;
}

  </style>
</head>

<body>
  <div class="wrapper">
    <!-- SIDEBAR -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img  id="schoolLogo"  src="assets/img/logoicon.png" alt="Logo" class="me-3 ms-1" style="width: 38px;">
        <span id="schoolName" class="text-primary fw-bold fs-3">Brightside</span>
      </div>
      <div class="d-flex flex-column align-items-start">
        <hr class="mb-2" />
        <a href="<?= base_url(); ?>admin-dashboard" class="nav-link d-flex align-items-center ">
          <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i> Dashboard
        </a>
         
        <a href="<?= base_url(); ?>admin-admission" class="nav-link d-flex align-items-center position-relative">
            <div class="position-relative me-4">
              <i class="fas fa-users fa-lg fa-fw text-secondary"></i>
              <?php if ($unread_count > 0): ?>
                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                  <?= $unread_count ?>
                </span>
              <?php endif; ?>
            </div>
            Admission
        </a>

        <a href="<?= base_url(); ?>admin-enrolled" class="nav-link d-flex align-items-center">
          <i class="fas fa-chalkboard-teacher me-4 fa-lg fa-fw text-secondary"></i> Enrolled Students
        </a>
        <a href="<?= base_url(); ?>admin-attendance" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Attendance Summary
        </a>
        
         <a href="<?= base_url(); ?>admin-accountManagement" class="nav-link d-flex align-items-center">
          <i class="fas fa-user-gear me-4 fa-lg fa-fw text-secondary"></i> Account Management
        </a>
        
        
        <a href="<?= base_url(); ?>admin-payment" class="nav-link d-flex align-items-center active">
          <i class="fa-solid fa-money-check-dollar me-4 fa-lg fa-fw text-secondary"></i> Tuition Payment Management
        </a>
        <a href="<?= base_url(); ?>admin-announcement" class="nav-link d-flex align-items-center">
          <i class="fa-solid fa-bell me-4 fa-lg fa-fw text-secondary"></i> Announcement
        </a>
        
        <a href="<?= base_url(); ?>admin-settings" class="nav-link d-flex align-items-center">
          <i class="fas fa-cogs me-4 fa-lg fa-fw text-secondary"></i> Settings 
        </a>
         
      </div>
    </nav>

    <!-- MAIN CONTENT -->
    <div class="main col-md-10">
      <!-- NAVBAR -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>

          <div class="d-flex align-items-center ms-auto py-1">
             <select id="school_year" class="form-select">

              <?php foreach ($yearsRecord as $r): ?>
                <option value="<?= $r['id'] ?>" 
                  <?= ($r['id'] == $selectedOpeningId) ? 'selected' : '' ?>>
                  <?= $r['school_year'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <!-- Notifications -->
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell fa-lg"></i>
               
                  
   
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

            <!-- Chats -->
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="<?= base_url(); ?>admin-chats" class="text-decoration-none text-primary">
                <i class="fa-solid fa-comment-dots fa-lg"></i>
              </a>
            </div>

            <!-- Profile -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                 id="profileDropdown" data-bs-toggle="dropdown">
                <img src="<?= base_url('public/assets/profilepic/' . esc($profilepic)) ?>"
                     alt="Profile Image"
                     class="me-2 rounded-circle"
                     style="width: 36px; height: 36px; object-fit: cover;">
                <span class="fw-bold ms-2">Admin</span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end">
                <li><a class="dropdown-item" href="<?= base_url('adminProfile'); ?>"><i class="fa-solid fa-user me-3 text-primary"></i>Profile</a></li>
                <li><a class="dropdown-item text-danger" href="<?= base_url(); ?>login"><i class="fa-solid fa-right-from-bracket me-2"></i> Logout</a></li>
              </ul>
            </div>
          </div>
        </div>
      </nav>

      <!-- MAIN -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="container-fluid">
          <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="text-primary mb-0"><i class="fa-solid fa-coins me-2"></i> Parent Payment Management</h3>
           
          </div>

          
          

          <!-- PAYMENT TABLE -->
          <div class="card border-0 shadow-sm">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0"><i class="fa-solid fa-money-check-dollar me-2"></i>Cash Payment</h5>
            </div>
            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-hover align-middle mb-0" id="parentsTable">
                  <thead class="table-light">
                    <tr>
                      <th class="text-muted">Parent Name</th>
                      <th class="text-muted">Contact</th>
                      <th class="text-muted">Address</th>
                      <th class="text-center text-muted">Action</th>
                    </tr>
                  </thead>
                  <tbody>
                    <?php if (!empty($parents)): ?>
                      <?php foreach ($parents as $parent): ?>
                        <tr>
                          <td class="fw-semibold"><?= esc($parent['first_name'] . ' ' . $parent['last_name']) ?></td>
                          <td><?= esc($parent['contact_number']) ?></td>
                          <td><?= esc($parent['address']) ?></td>
                          <td class="text-center">
                            <a href="<?= base_url('/admin-paymentInfo/' . $parent['user_id']) ?>" class="btn btn-sm btn-outline-primary me-1">
                              <i class="fa-solid fa-receipt me-1"></i>Misc
                            </a>
                            <a href="<?= base_url('/admin-paymentTuition/' . $parent['user_id']) ?>" class="btn btn-sm btn-outline-success">
                              <i class="fa-solid fa-book me-1"></i>Tuition
                            </a>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                    <?php else: ?>
                      <tr>
                        <td colspan="4" class="text-center text-muted py-3">No parents found.</td>
                      </tr>
                    <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        

          <!-- TRANSACTION HISTORY -->

          <div class="card border-0 shadow-sm mt-4">

            <!-- HEADER -->
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
              <h5 class="mb-0 fw-semibold text-dark">
                <i class="fa-solid fa-clock-rotate-left me-2 text-primary"></i>
                Transaction History
              </h5>
            </div>

            <div class="card-body">

              <!-- FILTERS + ACTION BUTTONS -->
              <div class="d-flex flex-wrap justify-content-between align-items-end mb-3 p-3 rounded-3 border bg-white">                <!-- LEFT FILTERS -->
                <div class="d-flex flex-wrap gap-3">
                  <div>
                    <label class="form-label form-label-sm mb-1 text-muted">Search</label>
                    <input type="text"  id="customSearch" class="form-control form-control-sm">
                  </div>
                  <div>
                    <label class="form-label form-label-sm mb-1 text-muted">Plan Type</label>
                    <select id="planFilter" class="form-select form-select-sm">
                      <option value="">All Plans</option>
                      <option value="2">Registration</option>
                      <option value="3">Miscellaneous</option>
                      <option value="4">Tuition</option>
                    </select>
                  </div>

                  <div>
                    <label class="form-label form-label-sm mb-1 text-muted">From</label>
                    <input type="date" id="fromDate" class="form-control form-control-sm">
                  </div>

                  <div>
                    <label class="form-label form-label-sm mb-1 text-muted">To</label>
                    <input type="date" id="toDate" class="form-control form-control-sm">
                  </div>

                  <div class="d-flex align-items-end">
                    <button id="filterDate" class="btn btn-primary btn-sm px-3">
                      <i class="fa-solid fa-filter me-1"></i> Apply
                    </button>
                  </div>
                </div>

                

                <!-- RIGHT BUTTONS -->
                <div class="d-flex gap-2 mt-3 mt-md-0">
                  <button id="exportCSV" class="btn btn-outline-success btn-sm px-3">
                    <i class="fa-solid fa-file-export me-1"></i> Export CSV
                  </button>

                  <button id="generatePaper" class="btn btn-outline-primary btn-sm px-3">
                    <i class="fa-solid fa-file-lines me-1"></i> Generate Report
                  </button>
                </div>

              </div>

              <table class="table table-hover align-middle mb-0" id="reportTable">
                <thead class="table-light">
                  <tr>
                    <th class="text-muted">#</th>
                    <th class="text-muted">Parent Name</th>
                    <th class="text-muted">Student Name</th>
                    <th class="text-muted">Plan Type</th>
                    <th class="text-muted">Amount Paid</th>
                    <th class="text-muted">Payment Method</th>
                    <th class="text-muted">Payment Date</th>
                  </tr>
                </thead>

                <tbody>
                  <?php if (!empty($reports)): ?>
                    <?php $i = 1; foreach ($reports as $row): ?>

                      <?php
                        $planType = '';
                        if ($row['plan_id'] == 2) $planType = 'Registration';
                        elseif ($row['plan_id'] == 3) $planType = 'Miscellaneous';
                        elseif ($row['plan_id'] == 4) $planType = 'Tuition';
                        else $planType = 'Other';
                      ?>

                      <tr data-plan="<?= $row['plan_id'] ?>" data-date="<?= $row['payment_date'] ?>">

                        <!-- Row Number -->
                        <td class="text-center text-muted"><?= $i++ ?></td>

                        <!-- Names -->
                        <td class="fw-semibold"><?= esc($row['guardian_name']) ?></td>
                        <td><?= esc($row['student_name']) ?></td>

                        <!-- Plan Type Badge -->
                        <td>
                          <span class="badge bg-secondary-subtle text-dark px-2 py-1">
                            <?= esc($planType) ?>
                          </span>
                        </td>

                        <!-- Amount -->
                        <td class="fw-bold text-success">
                          ₱<?= number_format($row['amount_paid'], 2) ?>
                        </td>

                        <!-- Payment Method -->
                        <td><?= esc($row['payment_method']) ?></td>

                        <!-- Date -->
                        <td><?= esc($row['payment_date']) ?></td>

                      </tr>

                    <?php endforeach; ?>

                  <?php else: ?>
                    <tr>
                      <td colspan="7" class="text-center text-muted py-3">
                        No payment data available
                      </td>
                    </tr>
                  <?php endif; ?>
                </tbody>
              </table>
              </div>

            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- JS Libraries -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Script -->
    <script>
      $(document).ready(function () {
    const table = $('#reportTable').DataTable({
      pageLength: 10,
      order: [[0, 'dec']],
      // Disable DataTable's default search box since we're using a custom one
      searching: true
    });

    // Connect custom Search input to DataTable
    $('#customSearch').on('keyup', function () {
      table.search(this.value).draw();
    });

    // Filter by Plan Type (using DataTable's column search for better integration)
  $('#planFilter').on('change', function () {
      const selected = $(this).val();
      if (selected) {
        table.rows().every(function () {
          const planId = $(this.node()).data('plan');
          $(this.node()).toggle(planId == selected);
        });
      } else {
        table.rows().every(function () {
          $(this.node()).show();
        });
      }
    });
    // Filter by Date Range
    $('#filterDate').on('click', function () {
      const fromDate = $('#fromDate').val();
      const toDate = $('#toDate').val();

      table.rows().every(function () {
        const rowDate = new Date($(this.node()).data('date'));
        const from = fromDate ? new Date(fromDate) : null;
        const to = toDate ? new Date(toDate) : null;

        let show = true;
        if (from && rowDate < from) show = false;
        if (to && rowDate > to) show = false;

        $(this.node()).toggle(show);
      });
    });

    // Export to CSV (only visible/filtered rows)
    $('#exportCSV').click(function () {
      let csv = [];
      const headers = $('#reportTable thead th').map(function() { return '"' + $(this).text().replace(/"/g, '""') + '"'; }).get();
      csv.push(headers.join(','));

      $('#reportTable tbody tr:visible').each(function () {
        const cols = $(this).find('td');
        const row = cols.map(function() { return '"' + $(this).text().replace(/"/g, '""') + '"'; }).get();
        csv.push(row.join(','));
      });

      const csvFile = new Blob([csv.join('\n')], { type: 'text/csv' });
      const downloadLink = document.createElement('a');
      downloadLink.download = 'payment_report.csv';
      downloadLink.href = window.URL.createObjectURL(csvFile);
      downloadLink.click();
    });

    // Generate Paper (Filtered Report) - Fixed column indices and removed non-existent fields
    $('#generatePaper').click(function () {
      const filteredRows = [];
      $('#reportTable tbody tr:visible').each(function () {
        const cols = $(this).find('td');
        if (cols.length >= 7) { // Ensure enough columns
          filteredRows.push({
            guardian_name: cols.eq(1).text(), // Parent Name
            student_name: cols.eq(2).text(),  // Student Name
            plan_type: cols.eq(3).text(),     // Plan Type
            amount_paid: cols.eq(4).text(),   // Amount Paid
            payment_method: cols.eq(5).text(), // Payment Method
            payment_date: cols.eq(6).text()   // Payment Date
          });
        }
      });

      // Add loading indicator
      // $('#generatePaper').prop('disabled', true).text('Generating...');

      fetch('<?= site_url("admin/print_report") ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ data: filteredRows })
      })
      .then(res => res.text())
      .then(html => {
        const printWindow = window.open('', '_blank');
        printWindow.document.write(html);
        printWindow.document.close();
      
      })
      .catch(err => {
        console.error('Error generating report:', err);
        alert('Failed to generate report. Please try again.');
      })
      .finally(() => {
        $('#generatePaper').prop('disabled', false).text('Generate Report');
      });
    });
  });
  <?php if(session()->getFlashdata('error')): ?>
          Swal.fire({
              icon: 'error',
              title: 'Oops...',
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
$(document).ready(function () {
    $('#parentsTable').DataTable({
      pageLength: 10,
      lengthChange: false,
      ordering: true,
      searching: true,
      info: true,
      columnDefs: [
        { orderable: false, targets: 3 } // Disable sorting on Action column
      ]
    });
  });

  </script>

  
</body>
</html>
