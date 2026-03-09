<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside | Tuition & Payment Info</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">

  <!-- Custom User CSS -->
  <link rel="stylesheet" href="assets/css/user.css">
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
        <a href="<?= base_url('student-progress-report'); ?>" class="nav-link d-flex align-items-center  ">
          <i class="fas fa-chart-line me-4 fa-lg fa-fw text-secondary"></i> Progress Report
        </a>
        <a href="<?= base_url('student-guardiansetup'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-users me-4 fa-lg fa-fw text-secondary"></i> Guardian Setup
        </a>
        <a href="<?= base_url('student-attendance'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-calendar-check me-4 fa-lg fa-fw text-secondary"></i> Attendance
        </a>
        <a href="<?= base_url('student-paymentInfo'); ?>" class="nav-link d-flex align-items-center active">
          <i class="fa-solid fa-money-bill me-4 fa-lg fa-fw text-secondary"></i> Tuition & Payment Info
        </a>
        <!-- <a href="<?= base_url('student-interactive-learning'); ?>" class="nav-link d-flex align-items-center ">
          <i class="fa-solid fa-chalkboard me-4 fa-lg fa-fw text-secondary"></i> Interactive Learning
        </a> -->
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
            <h5 class="text-primary m-0 ms-3">Tuition & Payment Info</h5>
          </div>

          <div class="d-flex align-items-center ms-auto py-1">
            <a href="#" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-bell fa-lg fa-fw"></i>
            </a>
            <a href="<?= base_url(); ?>student-chat" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
            </a>

            <!-- Profile Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>" alt="Profile Picture"
                  class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($student->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('student-profile'); ?>"><i class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>
                <li class="dropdown-item-text d-flex align-items-center mt-2">
                  <a href="<?= base_url('/guardian/dashboard/' . esc($student->parent_id)) ?>">
                        <img src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>" alt="Parent"
                            class="rounded-circle border border-2 me-2" width="25" height="25">
                        <span> (Parent)</span>
                  </a>
                </li>
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

      <!-- Main Section -->
      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <h2 class="text-primary mb-4 d-block d-md-none">Tuition & Payment Info</h2>
        <div class="container mt-4">

          <!-- Fee Breakdown -->
          <div class="card mb-4">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              Fee Breakdown
              <!-- View Button -->
              <button class="btn btn-info btn-sm text-light" data-bs-toggle="modal" data-bs-target="#breakdownModal">
                View Full Breakdown
              </button>
            </div>

            <!-- Student Info -->
            <div class="row g-3 m-3">
              <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                  <div class="card-body">
                    <h6 class="fw-bold text-primary mb-3">Student Information</h6>
                    <p><strong>Name:</strong> <span id="summaryStudentName">Juan Dela Cruz</span></p>
                    <p><strong>Class Enrolled:</strong> <span id="summaryClass">Kindergarten</span></p>
                  </div>
                </div>
              </div>

              <div class="col-md-6">
                <div class="card shadow-sm border-0 h-100">
                  <div class="card-body">
                    <h6 class="fw-bold text-primary mb-3">Due Information</h6>
                    <p>
                      <strong>Next Due Date:</strong>
                      <span id="dueDate" class="fw-bold text-danger">2025-09-15</span>
                    </p>
                  </div>
                </div>
              </div>
            </div>

            <div class="card-body">
              <div class="table-responsive">
                <table class="table table-bordered text-center align-middle mb-0">
                  <thead class="table-light">
                    <tr>
                      <th>Fee Type</th>
                      <th>Total</th>
                      <th>Monthly</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr>
                      <td>Tuition Fee</td>
                      <td>₱25,000</td>
                      <td>₱2,500</td>
                    </tr>
                    <tr>
                      <td>Miscellaneous Fee</td>
                      <td>₱8,000</td>
                      <td>-</td>
                    </tr>
                    <tr>
                      <td>Registration Fee</td>
                      <td>₱2,000</td>
                      <td>-</td>
                    </tr>
                    <tr class="table-primary fw-bold">
                      <td>Total</td>
                      <td>₱35,000</td>
                      <td>-</td>
                    </tr>
                  </tbody>
                </table>
              </div>
              <!-- Notes -->
              <div class="alert alert-info mt-3 mb-0 small">
                <ul class="mb-0">
                  <li>Miscellaneous Fee (<strong>₱8,000</strong>) and Registration Fee (<strong>₱2,000</strong>) are <u>paid during enrollment</u>.</li>
                  <li>Monthly Tuition Fee: <strong>₱2,500</strong></li>
                  <li>July – April (10 months) → Total Tuition: <strong>₱25,000</strong></li>
                  <li>If <strong>Full Payment</strong> is made at enrollment: <strong>₱2,000 discount</strong> (Total: ₱33,000)</li>
                </ul>
              </div>
            </div>
          </div>

          <!-- Payment Section -->
          <div class="card mb-4">
            <div class="card-header bg-success text-white">Pay Online</div>
            <div class="card-body">
              <form action="<?= base_url('payment/create_payment_link'); ?>" method="post" id="paymentForm">
                <?php 
                  $amount = $payment->monthly_payment ?? 0; 
                  $remaining = $remainingBalance->remaining_balance ?? 0; 
                  if (isset($payment->payment_type) && $payment->payment_type === 'full') {
                      $remaining = 0;
                      $amount =0;
                  }
                  log_message('info', "amount: {$amount}");
                ?>
                
                <input type="hidden" name="amount" id="selectedAmount" value="<?= esc($amount) ?>">

                <!-- Payment Option -->
                <div class="mb-3">
                  <label class="form-label"><strong>Select Payment Option:</strong></label>
                  <select id="paymentOption" name="paymentOption" class="form-select" required>
                    <option value="tuition" selected>Tuition Fee (Monthly ₱2,500)</option>
                    <option value="remaining">Pay Remaining Balance (₱<?= number_format($remaining, 2) ?>)</option>
                  </select>
                </div>

                <!-- Payment Summary -->
                <div class="bg-light p-3 mb-4 rounded-2 border border-1 border-dark">
                  <p class="mb-2"><strong>Amount Due:</strong> ₱<span id="displayAmount"><?= number_format($amount, 2) ?></span></p>
                  <p class="mb-0"><strong>Next Due Date:</strong>
                    <?php
                      $monthName = $payment->month ?? "Contact admin for detail";
                      $monthDate = DateTime::createFromFormat('F Y', $monthName);
                      if ($monthDate) {
                        $monthDate->modify('+2 weeks');
                        echo $monthDate->format('F Y');
                      } else {
                        echo "No schedule set";
                      }
                    ?>
                  </p>
                </div>

                <!-- Payment Method -->
                <?php if ($amount != 0): ?>
                  <div class="mb-3">
                    <label class="form-label"><strong>Select Payment Method:</strong></label><br>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="paymentMethod" id="gcash" value="gcash" required>
                      <label class="form-check-label" for="gcash">Gcash</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="paymentMethod" id="paymaya" value="paymaya">
                      <label class="form-check-label" for="paymaya">PayMaya</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="paymentMethod" id="card" value="card">
                      <label class="form-check-label" for="card">Card</label>
                    </div>

                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="paymentMethod" id="dob" value="dob">
                      <label class="form-check-label" for="dob">DOB</label>
                    </div>
                  </div>
                <?php else: ?>
                  <div class="alert alert-warning">
                    Please wait for the next payment.
                  </div>
                <?php endif; ?>


                <!-- Payment Details -->
                <div id="paymentDetails" class="mt-3 border border-1 border-dark p-3 rounded-2 bg-light" style="display: none;">
                  <div class="mb-3">
                    <label for="payamount" class="form-label">Amount to Pay</label>
                    <input type="text" class="form-control" id="payamount" name="payamount"
                      value="₱<?= number_format($amount, 2) ?>" readonly>
                  </div>
                  <div class="mb-3">
                    <label for="fullname" class="form-label">Full Name (Gcash/PayMaya Owner)</label>
                    <input type="text" class="form-control" id="fullname" name="fullname" required>
                  </div>
                  <div class="mb-3">
                    <label for="number" class="form-label">Gcash/PayMaya Number</label>
                    <input type="text" class="form-control" id="number" name="number" required>
                  </div>
                  <div class="mb-3">
                    <label for="email" class="form-label">Email Address (for receipt)</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                  </div>
                  <button type="submit" class="btn btn-success w-100">Pay Now via PayMongo</button>
                </div>
              </form>
              <small class="text-muted d-block mt-2">* You will be redirected to PayMongo's secure payment page.</small>
            </div>
          </div>

          <!-- Payment History -->
          <div class="card mb-4">
            <div class="card-header bg-secondary text-white">Payment History</div>
            <div class="card-body">
              <ul class="list-group">
                <?php foreach ($paymenthistorys as $paymenthistory) : ?>
                  <li class="list-group-item">
                    <strong>₱<?= esc($paymenthistory->amount_paid) ?></strong><br>
                    <small>Remarks: <?= esc($paymenthistory->month) ?> Payment</small>
                  </li>
                <?php endforeach; ?>
              </ul>
            </div>
          </div>
        </div>
      </main>

      <!-- Bootstrap Modal for Full Breakdown -->
      <div class="modal fade" id="breakdownModal" tabindex="-1" aria-labelledby="breakdownModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-scrollable">
          <div class="modal-content">
            <div class="modal-header bg-primary text-white">
              <h5 class="modal-title" id="breakdownModalLabel">Full Fee Breakdown (S.Y. 2025-2026)</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <h6 class="fw-bold text-primary">Monthly Tuition Fee (₱2,500 × 10 months = ₱25,000)</h6>
              <ul>
                <li>School Modules</li>
                <li>Learning Materials</li>
                <li>Instructional Tools & Supplies</li>
                <li>Montessori Apparatus</li>
              </ul>
              <hr>

              <h6 class="fw-bold text-primary">Registration Fee: ₱2,000</h6>
              <hr>

              <h6 class="fw-bold text-primary">Miscellaneous Fee: ₱8,000</h6>
              <ul>
                <li>Communication Notebook</li>
                <li>Writing Notebook</li>
                <li>Academic Notebook</li>
                <li>Arts & Crafts Project Materials</li>
                <li>Sensory Materials</li>
                <li>Energy Fee</li>
                <li>Health & Sanitation Fee</li>
                <li>Operational Fee</li>
              </ul>
              <hr>

              <h6 class="fw-bold text-primary">Total Tuition Fee (1 year): ₱35,000</h6>
              <h6 class="fw-bold text-success">Discount (upon full payment): ₱33,000</h6>

            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <!-- Bootstrap JS -->
  <script src="dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/user.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
  document.querySelectorAll('input[name="paymentMethod"]').forEach((elem) => {
    elem.addEventListener("change", function () {
      const details = document.getElementById("paymentDetails");
      let content = "";

      if (this.value === "gcash" || this.value === "paymaya") {
        content = `
          <div class="mb-3">
            <label for="payamount" class="form-label">Amount to Pay</label>
            <input type="text" class="form-control" id="payamount" name="payamount"
              value="₱<?= number_format($amount, 2) ?>" readonly>
          </div>
          <div class="mb-3">
            <label for="fullname" class="form-label">Full Name (Gcash/PayMaya Owner)</label>
            <input type="text" class="form-control" id="fullname" name="fullname" required>
          </div>
          <div class="mb-3">
            <label for="number" class="form-label">Gcash/PayMaya Number</label>
            <input type="text" class="form-control" id="number" name="number" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email Address (for receipt)</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Pay Now via PayMongo</button>
        `;
      } 
      else if (this.value === "card") {
        content = `
          <div class="mb-3">
            <label for="payamount" class="form-label">Amount to Pay</label>
            <input type="text" class="form-control" id="payamount" name="payamount"
              value="₱<?= number_format($amount, 2) ?>" readonly>
          </div>
          <div class="mb-3">
            <label for="cardNumber" class="form-label">Card Number</label>
            <input type="text" class="form-control" id="cardNumber" name="cardNumber" required>
          </div>
          <div class="mb-3">
            <label for="expiryMonth" class="form-label">Month Date</label>
            <input type="number" class="form-control" id="expiryMonth" name="expiryMonth" 
                  placeholder="MM(e.g 01)" min="1" max="2" required>
          </div>

          <div class="mb-3">
            <label for="expiryYear" class="form-label">Year Date</label>
            <input type="number" class="form-control" id="expiryYear" name="expiryYear" 
                  placeholder="YYYY(eg 2026)" min="2025" max="2100" required>
          </div>

          <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" required>
          </div>
          <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" >
          </div>
         
          <div class="mb-3">
            <label for="email" class="form-label">Email Address(for receipt)</label>
            <input type="email" class="form-control" id="email" name="email" >
          </div>
          <button type="submit" class="btn btn-success w-100">Pay Now via Card</button>
        `;
      } 
      else if (this.value === "dob") {
        content = `
          <div class="mb-3">
            <label for="payamount" class="form-label">Amount to Pay</label>
            <input type="text" class="form-control" id="payamount" name="payamount"
              value="₱<?= number_format($amount, 2) ?>" readonly>
          </div>
          <div class="mb-3">
            <label for="accountName" class="form-label">Select Bank</label>
            <select class="form-select" id="accountName" name="accountName" required>
              <option value="">-- Select Bank --</option>

              <!-- DOB Banks -->
              
              <option value="test_bank_one">BPI (Test)</option>
              <option value="test_bank_two">UnionBank (Test)</option>

              <!-- Brankas Banks -->
              <option value="bdo">BDO (not available or testing)</option>
              <option value="metrobank">Metrobank (not available or testing)</option>
              <option value="landbank">Landbank (not available or testing) </option>
            </select>
          </div>
          <div class="mb-3">
            <label for="fullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="fullname" name="fullname" >
          </div>
          
          <div class="mb-3">
            <label for="email" class="form-label">Email Address(for receipt)</label>
            <input type="email" class="form-control" id="email" name="email" >
          </div>

          
          <button type="submit" class="btn btn-success w-100">Pay Now via DOB</button>
        `;
      }

      details.innerHTML = content;
      details.style.display = "block";
    });
  });
</script>

  

  <script>
    

    // Handle payment option change
    document.getElementById("paymentOption").addEventListener("change", function () {
      const option = this.value;
      const monthly = <?= $payment->monthly_payment ?? 0 ?>;
      const remaining = <?= $remainingBalance->remaining_balance ?? 0 ?>;
      const amountField = document.getElementById("payamount");
      const displayAmount = document.getElementById("displayAmount");
      const hiddenAmount = document.getElementById("selectedAmount");

      if (option === "monthly") {
        amountField.value = "₱" + monthly.toLocaleString();
        displayAmount.textContent = monthly.toLocaleString();
        hiddenAmount.value = monthly;
      } else if (option === "remaining") {
        amountField.value = "₱" + remaining.toLocaleString();
        displayAmount.textContent = remaining.toLocaleString();
        hiddenAmount.value = remaining;
      }
    });



    <?php if(session()->getFlashdata('error')): ?>
        Swal.fire({
            icon: 'error',
            title: 'Warning',
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

    
  </script>
</body>
</html>
