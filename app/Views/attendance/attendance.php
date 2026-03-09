<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Attendance Monitoring</title>
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
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="assets/img/logoicon.png" rel="icon" />

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="assets/css/admin.css">
  <meta name="csrf-token" content="<?= csrf_hash() ?>">
  <script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>
</head>

<body>
  <div class="wrapper">
    <div class="main col-md-12">
      <!-- Top Navbar -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <h4 class="text-primary m-0 fw-bold ps-2">Attendance Monitoring</h4>
          <div class="dropdown ms-auto">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
              id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?= base_url('public/assets/profilepic/' . esc($profileAccount['profile_pic'])) ?>" alt="Parent"  class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
              <span class="fw-bold ms-2"><?= esc($profileAccount['full_name']) ?></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="<?= base_url('staffprofile'); ?>"><i
                    class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile</a></li>
              <li><a class="dropdown-item text-danger" href="<?= base_url(); ?>login"><i
                    class="fa-solid fa-right-from-bracket me-2"></i>Logout</a></li>
            </ul>
          </div>
        </div>
      </nav>

      <main class="px-4 py-4">
        <div class="container-fluid">

          <!-- Header: Class, Date, Time -->
          <div class="row mb-4 align-items-center">
            <div class="col-md-4 d-flex align-items-center">
              <label for="class" class="form-label fw-bold text-secondary me-2 mb-0 fs-5">Class</label>
              <select class="form-select rounded border-secondary" id="class">
               
                <?php foreach ($classes as $class): ?>
                  <option value="<?= esc($class['classname']) ?>">
                    <?= esc($class['classname']) ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>

            <div class="col-md-4 d-flex align-items-center justify-content-evenly">
              <div>
                <span class="fw-bold text-secondary fs-5 me-2"><i class="fa-solid fa-calendar-days me-1"></i> Date</span>
                <span class="text-dark fs-5 me-3 border border-secondary rounded bg-white px-3 py-1" id="date"></span>
              </div>

              <div>
                <span class="fw-bold text-secondary fs-5 me-2"><i class="fa-solid fa-clock me-1"></i> Time</span>
                <span class="text-dark fs-5 border border-secondary rounded bg-white px-3 py-1" id="time"></span>
              </div>
            </div>
          </div>

          <!-- Main Row: Table (left) and Camera (right) -->
          <div class="row">
            <!-- Left: Student Table -->
            <div class="col-md-8 mb-4">
              <div class="table-responsive">
                <table id="membersTable" class="table table-hover align-middle table-striped table-bordered">
                  <thead class="primary-table-header">
                    <tr>
                      <th>Student Name</th>
                      <th>Class Name</th>
                      <th>Arrival Time</th>
                      <th>Leave Time</th>
                      <th>Status</th>
                    </tr>
                  </thead>
                  <tbody id="admissionTable">
                    <?php foreach ($students as $student): ?>
                      <tr data-student-id="<?= $student->user_id ?>" data-contactnumber="<?= $student->contact_number ?>">
                        <td><?= esc($student->full_name); ?></td>
                        <td><?= esc($student->class_level); ?></td>
                        <td class="arrival-time"><?= esc($student->arrival_time ?? ''); ?></td>
                        <td class="leave-time"><?= esc($student->leave_time ?? ''); ?></td>
                        <td>
                          <button
                            class="btn btn-sm status-btn <?= ($student->status === 'Present') ? 'btn-success' : 'btn-danger' ?>"
                            disabled>
                            <?= esc($student->status ?? 'Absent'); ?>
                          </button>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  </tbody>
                </table>
              </div>
            </div>

            <!-- Right: QR Scanner -->
            <div class="col-md-4">
              <div class="card shadow-sm p-3">
                <h5 class="text-center text-primary fw-semibold mb-3">QR Code Scanner</h5>
                <div id="reader" class="mb-3" style="width: 100%; height: auto;"></div>
                <div id="status" class="text-center text-muted">Ready to scan...</div>
              </div>
            </div>
          </div>
        </div>
      </main>
    </div>
  </div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/admin.js"></script>

  <!-- jQuery + DataTables -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Attendance Scanner Script -->
  <script>
   
    const statusDiv = document.getElementById('status');

    // Hidden console logger
    function logMessage(message) {
      console.log(`[${new Date().toLocaleTimeString()}] ${message}`);
    }

    async function sendScanData(qrText) {
      const now = new Date();
      const dateStr = now.toISOString().split('T')[0];
      const timeStr = now.toLocaleTimeString();

      const payload = {
        qr_code: qrText,
        date: dateStr,
        time: timeStr
      };

      statusDiv.textContent = 'Sending data...';
      logMessage(`Sending scan data: ${JSON.stringify(payload)}`);

      try {
        const res = await fetch('attendance/mark-scan', {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest',
          },
          body: JSON.stringify(payload)
        });

        const data = await res.json();

        if (res.ok && data.success) {
          statusDiv.textContent = ` ${data.message}`;
          logMessage(`Success: ${data.message}`);

          // ✅ SweetAlert success popup
          Swal.fire({
            icon: 'success',
            title: 'Attendance Recorded',
            text: data.message,
            showConfirmButton: false,
            timer: 2000,
            timerProgressBar: true
          });
          window.location.reload();
        } else {
          statusDiv.textContent = `Failed to record attendance.`;
          logMessage(`Server responded: ${data.message || 'Unknown error'}`);
        }
      } catch (err) {
        statusDiv.textContent = `Connection issue. Please try again.`;
        logMessage(`Fetch error: ${err.message}`);
      }
    }

    const html5QrCode = new Html5Qrcode("reader");

    const qrCodeSuccessCallback = async (decodedText) => {
      logMessage(`QR Code detected: ${decodedText}`);
      await html5QrCode.pause();
      statusDiv.textContent = 'Processing...';

      await sendScanData(decodedText);

      setTimeout(async () => {
        try {
          await html5QrCode.resume();
          statusDiv.textContent = 'Ready to scan...';
          logMessage('Scanner resumed');
        } catch (resumeErr) {
          statusDiv.textContent = 'Scanner paused.';
          logMessage(`Resume error: ${resumeErr.message}`);
        }
      }, 3000);
    };

    const config = { fps: 10, qrbox: 250 };

    html5QrCode.start(
      { facingMode: "environment" },
      config,
      qrCodeSuccessCallback
    ).then(() => {
      statusDiv.textContent = 'Scanner started. Point camera at QR code.';
      logMessage('Scanner started');
    }).catch(err => {
      statusDiv.textContent = 'Unable to start scanner.';
      logMessage(`Scanner start error: ${err}`);
    });


        $(document).ready(function () {
        var table = $('#membersTable').DataTable();

        // Filter by class
        // $('#class').on('change', function () {
        //     table.column(2).search($(this).val()).draw();
        // });
         $('#class').on('change', function () {
      table.column(1).search(this.value).draw(); // column index 2 = Class
    });

    // ✅ Automatically trigger filter on page load for selected class
    var selectedClass = $('#class').val();
    if(selectedClass){
      table.column(1).search(selectedClass).draw();
    }
    });



    
  </script>

</body>

</html>
