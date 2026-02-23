<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Dashboard — Miscellaneous Payment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap"
    rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">

  <!-- ✅ DataTables Bootstrap 5 CSS -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet" />
  <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet" />

  <!-- Custom Admin CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">

  <style>
    .notice-card {
      border: 2px dashed #ffc107;
      background: #fff8e1;
    }

    .child-line {
      gap: .5rem;
    }

    .method-section {
      margin-top: 1rem;
    }

    .masked {
      font-family: monospace;
    }
  </style>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar (kept) -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 min-vh-100 d-flex flex-column">
      <div>
        <div class="d-flex align-items-center mb-2 mt-3">
          <img src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
          <span class="text-primary fw-bold fs-3">Brightside</span>
        </div>

        <div class="d-flex flex-column align-items-start">
          <hr class="mb-2" />
           <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center ">
            <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
            Admission
          </a>
          <a href="<?= base_url('/guardian-announcement/'. esc($student->user_id)); ?>"
            class="nav-link d-flex align-items-center ">
            
            <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
            <?php if ($unread_announcement > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $unread_announcement ?>
              </span>
            <?php endif; ?>
            Announcement
          </a>

          <a href="<?= base_url('/payment-history/'. esc($student->user_id)); ?>"
            class="nav-link d-flex align-items-center active ">
            <i class="fa-solid fa-money-bill me-4 fa-lg fa-fw text-secondary "></i> Payment
          </a>

        </div>
      </div>

      <!-- ✅ This section stays at the bottom -->
      <div class="mt-5">
        <hr>
        <span class="fw-bold text-secondary small ms-1">Children</span>
        <ul class="list-unstyled ms-1 mt-2">
          <?php if (!empty($childrens)): ?>
          <?php foreach ($childrens as $child): ?>
          <li class="dropdown-item-text d-flex align-items-center mt-2">
            <a href="<?= base_url('/StudentviewDashboard/' . $child->admission_id) ?>"
              class="d-flex align-items-center text-decoration-none">
              <img src="<?= base_url('public/assets/profilepic/' . esc($child->profile_pic)) ?>" alt="Child"
                class="rounded-circle border border-2 me-2" width="25" height="25">
              <span class="text-primary fw-bold">
                <?= esc($child->full_name) ?>
              </span>
            </a>
          </li>
          <?php endforeach; ?>
          <?php else: ?>
          <li class="dropdown-item-text text-muted">No children found.</li>
          <?php endif; ?>
        </ul>
      </div>

    </nav>

    <div class="main col-md-10">
      <!-- Top Navbar (kept) -->
      <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
        <div class="container-fluid">
          <button class="btn d-md-none me-2" id="sidebarToggle">
            <i class="fas fa-bars"></i>
          </button>
          <div class="text-primary m-0 ms-3 d-none d-md-block">
            <h5 class="text-primary m-0 ms-3 ">Tuition Fee</h5>
          </div>
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

          <div class="d-flex align-items-center ms-auto py-1">
             <select id="school_year" class="form-select">

              <?php foreach ($yearsRecord as $r): ?>
                <option value="<?= $r['id'] ?>" 
                  <?= ($r['id'] == $selectedOpeningId) ? 'selected' : '' ?>>
                  <?= $r['school_year'] ?>
                </option>
              <?php endforeach; ?>
            </select>
            <div class="dropdown me-3 position-relative border-start border-2 ps-3">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown"
                data-bs-toggle="dropdown" aria-expanded="false" onclick="markAsRead(<?= esc($student->user_id) ?>)">

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
                  <strong>
                    <?= esc($n['title']) ?>
                  </strong><br>
                  <span class="text-muted">
                    <?= esc($n['message']) ?>
                  </span>
                </li>
                <?php endforeach; ?>
                <?php else: ?>
                <li class="px-3 py-2 small text-muted">No new notifications</li>
                <?php endif; ?>
              </ul>
            </div>

            <a href="<?= base_url(); ?>student-chat"
              class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
            </a>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <img src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>"
                  alt="Profile Picture" class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2">
                  <?= esc($student->full_name) ?>
                </span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('guardian-Profile'); ?>"><i
                      class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>
                <li><a class="dropdown-item" href="<?= base_url('guardian-resetPassword'); ?>"><i
                      class='fa-solid fa-key me-3  mb-2 text-primary mt-2'></i>Reset Password</a></li>

                <li>
                  <hr class="dropdown-divider">
                </li>
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

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="container my-4">
          <div class="card shadow-sm border-0">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
              <h5 class="mb-0">
                <i class="fas fa-calendar-alt me-2"></i> Payment Schedule
              </h5>
            </div>

            <div class="card-body">
                  <div class="row" id="paymentScheduleContent">
                      <?php foreach ($childrens as $child): 
                          $childId = $child->admission_id; // use -> instead of ['']
                          $childSchedule = $schedules[$childId]['data'] ?? [];
                          $pendingShown = false;

                          if (!empty($childSchedule)) {
                              // Check if this child has a pending schedule
                              foreach ($childSchedule as $row) {
                                  if ($row['status'] !== 'Paid' && !$pendingShown) {
                                      $pendingShown = true;
                                      ?>
                                      <!-- Child Payment Card -->
                                      <div class="col-md-6 col-lg-4 mb-3">
                                          <div class="card border-warning h-100 shadow-sm">
                                              <div class="card-body">
                                                  <h6 class="card-title text-primary mb-2">
                                                      <i class="fas fa-child me-2"></i> <?= esc($child->full_name); ?>
                                                  </h6>
                                                  <p class="card-text mb-1">
                                                    <strong>Date:</strong> <?= date('F j, Y', strtotime($row['due_date'])); ?>
                                                  </p>
                                                  <p class="card-text mb-1">
                                                      <strong>Amount Due:</strong>
                                                      <span class="text-success fw-bold">
                                                          ₱<?= number_format($row['amount_due'], 2); ?>
                                                      </span>
                                                  </p>
                                                  <p class="card-text mb-2">
                                                      <strong>Remaining Balance:</strong>
                                                      <span class="text-warning fw-bold">
                                                          ₱<?= number_format($row['remaining_balance'], 2); ?>
                                                      </span>
                                                  </p>
                                                  <span class="badge bg-warning">
                                                      <i class="fas fa-clock me-1"></i> Pending
                                                  </span>
                                              </div>
                                          </div>
                                      </div>
                                      <?php
                                  }
                              }
                          }

                          // If this child has no pending schedule, show default card
                          if (!$pendingShown): ?>
                              <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card border-success h-100 shadow-sm">
                                  <div class="card-body text-start">
                                    <h6 class="card-title text-success mb-2">
                                      <i class="fas fa-check-circle me-2"></i> Fully Paid
                                    </h6>
                                    <h6 class="card-title text-primary mb-2">
                                      <i class="fas fa-child me-2"></i> <?= esc($child->full_name); ?>
                                    </h6>
                                    <p class="card-text mb-0 text-success fw-bold">All payments have been completed.</p>
                                  </div>
                                </div>
                              </div>

                          <?php endif; ?>
                      <?php endforeach; ?>
                  </div>
              </div>
            


          </div>
        </div>





        <!-- MISC CARD (shown by default) -->
        <div class="container my-4">
          <div id="miscCard" class="card mb-4 border-0">
            <div class=" card-header bg-primary text-white">
              <h5 class="mb-0 m"><i class="fas fa-credit-card me-2"></i> Payment Options</h5>
            </div>
            <div class="card-body">
              <div class="mb-4">
                <label class="form-label fw-bold"><i class="fas fa-wallet me-2"></i>Select Payment Method:</label><br>
                <div class="row">
                  <div class="col-md-3 mb-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="paymentMethod" id="method_gcash" value="gcash">
                      <label class="form-check-label" for="method_gcash">
                        <i class="fab fa-google-pay me-1 text-success"></i> Gcash
                      </label>
                    </div>
                  </div>
                  <div class="col-md-3 mb-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="paymentMethod" id="method_paymaya"
                        value="paymaya">
                      <label class="form-check-label" for="method_paymaya">
                        <i class="fas fa-mobile-alt me-1 text-info"></i> PayMaya
                      </label>
                    </div>
                  </div>
                  <div class="col-md-3 mb-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="paymentMethod" id="method_card" value="card">
                      <label class="form-check-label" for="method_card">
                        <i class="fas fa-credit-card me-1 text-primary"></i> Card
                      </label>
                    </div>
                  </div>
                  <div class="col-md-3 mb-2">
                    <div class="form-check form-check-inline">
                      <input class="form-check-input" type="radio" name="paymentMethod" id="method_dob" value="dob">
                      <label class="form-check-label" for="method_dob">
                        <i class="fas fa-calendar-day me-1 text-warning"></i> DOB
                      </label>
                    </div>
                  </div>
                </div>
              </div>


              <div id="paymentDetails" class="mt-4 border rounded p-4 bg-light shadow-sm" style="display:none;">
                <h6 class="mb-3 text-primary"><i class="fas fa-list-check me-2"></i>Select children to include in this
                  payment:</h6>
                <ul id="miscChildrenList" class="list-group mb-4"></ul>

                <div class="row">
                  <div class="col-md-6">
                    <p class="mb-2"><strong>Total Selected:</strong> <span class="text-success fw-bold">₱<span
                          id="totalAmountMisc">0.00</span></span></p>
                  </div>
                  <div class="col-md-6">
                    <p class="mb-2"><strong>Balance After Payment:</strong> <span class="text-warning fw-bold">₱<span
                          id="balanceMisc">0.00</span></span></p>
                  </div>
                </div>

                <!-- Payment type choices (Full / Monthly / Partial) -->
                <div class="mb-3" id="paymentTypeChoice" style="display:none;">
                  <label class="form-label fw-bold"><i class="fas fa-tags me-2"></i>Payment Type</label><br>
                  <div class="row">
                    <div class="col-md-4 mb-2">
                      <div class="form-check" id="fullpayment">
                        <input class="form-check-input" type="radio" name="pay_type" id="pay_full" value="full">
                        <label class="form-check-label" for="pay_full">
                          <i class="fas fa-percentage me-1 text-success"></i> Full Payment (with 8% Discount)
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4 mb-2">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="pay_type" id="pay_monthly" value="monthly">
                        <label class="form-check-label" for="pay_monthly">
                          <i class="fas fa-calendar-alt me-1 text-info"></i> Monthly
                        </label>
                      </div>
                    </div>
                    <div class="col-md-4 mb-2">
                      <div class="form-check">
                        <input class="form-check-input" type="radio" name="pay_type" id="pay_partial" value="partial"
                          checked>
                        <label class="form-check-label" for="pay_partial">
                          <i class="fas fa-coins me-1 text-warning"></i> Partial / Advance
                        </label>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold"><i class="fas fa-money-bill-wave me-2"></i>Amount to Pay (₱)</label>
                  <input type="number" id="partialInput" class="form-control" placeholder="Enter amount (Partial/Advance)"
                    required>
                </div>

                <!-- method-specific form area -->
                <div id="methodFields" class="method-section mb-3"></div>

                <!-- Pay Now opens modal with final form -->
                <div class="d-grid">
                  <button id="openModalBtn" class="btn btn-success btn-lg">
                    <i class="fas fa-credit-card me-2"></i> Pay Now
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
        


        <div class="modal fade" id="finalModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered modal-lg">
            <form id="finalPaymentForm" class="modal-content shadow-lg border-0"
              action="<?= base_url('payment-link-Tuition'); ?>" method="POST">
              <div class="modal-header bg-gradient-primary text-white">
                <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i> Confirm Payment</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                  aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <input type="hidden" name="plan_id" id="modal_plan_id" value="3">
                <input type="hidden" name="paymentMethod" id="paymentMethodHidden" value="">
                <input type="hidden" name="pay_type" id="pay_type" value="">
                <div id="modalChildrenContainer"></div>
                <div id="modalMethodHidden"></div>

                <div class="row mb-3">
                  <div class="col-md-6">
                    <p class="mb-1"><strong>Payment Method:</strong> <span id="modalMethodLabel"
                        class="text-primary"></span></p>
                    <p class="mb-1"><strong>Method Detail:</strong> <span id="modalMethodDetail"
                        class="masked text-muted"></span></p>
                  </div>
                  <div class="col-md-6">
                    <p class="mb-1"><strong>Selected Total:</strong> <span class="text-success fw-bold">₱<span
                          id="modalTotal">0.00</span></span></p>
                    <p class="mb-1"><strong>Amount To Pay:</strong> <span class="text-warning fw-bold">₱<span
                          id="modalPartialLabel">0.00</span></span></p>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-6 mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-user me-2"></i>Name (Owner)</label>
                    <input type="text" name="fullname" id="modalFullname" class="form-control" required>
                  </div>
                  <div class="col-md-6 mb-3" id="contactNumberDiv">
                    <label class="form-label fw-bold"><i class="fas fa-phone me-2"></i>Contact Number</label>
                    <input type="text" name="number" id="modalNumber" class="form-control">
                  </div>
                </div>

                <div class="mb-3">
                  <label class="form-label fw-bold"><i class="fas fa-envelope me-2"></i>Email</label>
                  <input type="email" name="email" id="modalEmail" class="form-control" required>
                </div>

                <div class="alert alert-info mt-3">
                  <i class="fas fa-info-circle me-2"></i> By confirming you agree to proceed with the payment. You may
                  be redirected to a payment gateway if applicable.
                </div>
              </div>

              <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                  <i class="fas fa-times me-1"></i> Cancel
                </button>
                <button type="submit" id="confirmPayBtn" class="btn btn-success">
                  <i class="fas fa-check me-1"></i> Confirm & Pay
                </button>
              </div>
            </form>
          </div>
        </div>
        
      </main>
    </div>
  </div>

  <!-- scripts -->
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      // Elements
      const miscChildrenList = document.getElementById('miscChildrenList');
      const paymentDetails = document.getElementById('paymentDetails');
      const methodFields = document.getElementById('methodFields');
      const openModalBtn = document.getElementById('openModalBtn');
      const modalChildrenContainer = document.getElementById('modalChildrenContainer');
      const modalMethodHidden = document.getElementById('modalMethodHidden');
      const modalTotal = document.getElementById('modalTotal');
      const modalPartialLabel = document.getElementById('modalPartialLabel');
      const modalMethodLabel = document.getElementById('modalMethodLabel');
      const modalMethodDetail = document.getElementById('modalMethodDetail');
      const modalFullname = document.getElementById('modalFullname');
      const modalNumber = document.getElementById('modalNumber');
      const modalEmail = document.getElementById('modalEmail');
      const paymentMethodHidden = document.getElementById('paymentMethodHidden');
      const modalPlanInput = document.getElementById('modal_plan_id');

      const totalAmountSpan = document.getElementById('totalAmountMisc');
      const balanceSpan = document.getElementById('balanceMisc');
      const partialInput = document.getElementById('partialInput');
      const paymentTypeChoice = document.getElementById('paymentTypeChoice');

      // constants & state
      const PLAN_ID = 4;          // miscellaneous
      // const FULL_PER_CHILD = 25000;
      // const MONTHLY_PER_CHILD = 2500;
      const DISCOUNT_RATE = 0.08; // 8% (D2)
      let childrenCache = [];
      let selectedPaymentMethod = null;

      // helpers
      function fmt(num) {
        if (isNaN(num)) return "0.00";
        return parseFloat(num).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }
      function toFixedNum(num) {
        if (isNaN(num)) return 0;
        return Number(parseFloat(num).toFixed(2));
      }
      function maskCard(card) {
        if (!card) return '—';
        const digits = card.replace(/\D/g, '');
        if (digits.length <= 4) return '**** ' + digits;
        return '**** **** **** ' + digits.slice(-4);
      }
      function createHidden(name, value) {
        const el = document.createElement('input');
        el.type = 'hidden';
        el.name = name;
        el.value = value;
        return el;
      }


      // totals logic
      function getCheckedBoxes() {

        return Array.from(miscChildrenList.querySelectorAll('.child-checkbox')).filter(cb => cb.checked);


      }
      function computeTotals() {
        const checked = Array.from(document.querySelectorAll('.child-checkbox')).filter(cb => cb.checked);
        const amounts = checked.map(cb => cb.dataset.amount || 0);
           const childIds = checked.map(cb => cb.value); // admission IDs

        console.log("Selected children amounts:", amounts);
        console.log("Selected children se:", childIds);

        const formData = new FormData();
        amounts.forEach(a => formData.append('children[]', a));
        formData.append('partial', partialInput.value || 0);
         childIds.forEach(b => formData.append('childrenID[]', b));
        

        fetch("<?= base_url('parent-paymentInfo-tuituin/computation') ?>", {
          method: 'POST',
          body: formData
        })
          .then(res => res.json())
          .then(data => {
            console.log("Backend response:", data);
            totalAmountSpan.textContent = data.total;
            balanceSpan.textContent = data.balance;
            modalTotal.textContent = data.total;
            modalPartialLabel.textContent = data.partial;
            paymentTypeChoice.style.display = 'block';
            const fullPaymentDiv = document.getElementById('fullpayment');
            if (data.showFullMonthly) {
              fullPaymentDiv.style.display = 'inline-block'; // show Full Payment
            } else {
              fullPaymentDiv.style.display = 'none'; // hide Full Payment

            }
            // 🔹 Limit partial input based on total
            const total = parseFloat(data.total.replace(/,/g, '')) || 0;
            const partial = parseFloat(partialInput.value || 0);
            partialInput.max = total; // set max value

            // if user enters more than total, reset it

            if (partial > total) {
              Swal.fire({
                icon: 'warning',
                title: 'Invalid Amount',
                text: 'Partial payment cannot exceed the total amount.',
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
              });
              partialInput.value = total.toFixed(2);
            }




          })
          .catch(err => console.error(err));

      }

      // preset amount behaviors for payment type
      function makeAmountReadOnlyAndSet(value) {

        partialInput.value = toFixedNum(value);
        partialInput.setAttribute('readonly', 'readonly');

      }
      function makeAmountEditable() {
        partialInput.removeAttribute('readonly');
      }

      // render children
      function populateMiscChildren(children) {
  miscChildrenList.innerHTML = '';
  if (!Array.isArray(children) || children.length === 0) {
    miscChildrenList.innerHTML = '<li class="list-group-item">No children found.</li>';
    return;
  }
  children.forEach(child => {
    if (!child.remaining_balance || Number(child.remaining_balance) <= 0) {
      // Skip children with 0 balance
      return;
    }
    const li = document.createElement('li');
    li.className = "list-group-item d-flex justify-content-between align-items-center child-line";
    const left = document.createElement('div');
    left.innerHTML = `<label class="mb-0">
                          <input class="child-checkbox me-2" type="checkbox" value="${child.admission_id}" data-amount="${child.remaining_balance}" data-tuition="${child.tuition_fee}" data-monthly="${child.monthly_payment}">
                          ${child.full_name}
                      </label>`;
    const right = document.createElement('strong');
    right.textContent = "₱" + Number(child.remaining_balance).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    li.appendChild(left);
    li.appendChild(right);
    miscChildrenList.appendChild(li);
  });

        // checkbox listeners
        miscChildrenList.querySelectorAll('.child-checkbox').forEach(cb => {

          cb.addEventListener('change', computeTotals);
          computeTotals();
        });

        // show details when children populated
        paymentDetails.style.display = 'block';
        computeTotals();
      }


      // render method fields based on chosen payment method
      function renderMethodFields(method) {
        selectedPaymentMethod = method;
        paymentMethodHidden.value = method || '';
        methodFields.innerHTML = '';
        modalMethodHidden.innerHTML = '';
        modalMethodLabel.textContent = method ? method.toUpperCase() : '';

        // reset contact showing
        document.getElementById('contactNumberDiv').style.display = 'block';

        if (!method) return;
        if (method === 'gcash' || method === 'paymaya') {
          methodFields.innerHTML = `
          <div class="mb-3">
            <label class="form-label">Full Name (Owner)</label>
            <input type="text" name='fullname' id="ownerFullname" class="form-control" placeholder="Name">
          </div>
          <div class="mb-3">
            <label class="form-label">Gcash/PayMaya Number</label>
            <input type="text" name='number' id="ownerNumber" class="form-control" placeholder="09XXXXXXXXX">
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address (for receipt)</label>
            <input type="email" name='email' id="ownerEmail" class="form-control" placeholder="email@example.com">
          </div>
        `;
        } else if (method === 'card') {
          methodFields.innerHTML = `
          <div class="mb-3">
            <label class="form-label">Card Number</label>
            <input type="text" id="cardNumber" class="form-control" maxlength="19" placeholder="1234 5678 9012 3456">
          </div>
          <div class="row">
            <div class="col mb-3">
              <label class="form-label">Expiry Month</label>
              <input type="number" id="expiryMonth" class="form-control" min="1" max="12" placeholder="MM">
            </div>
            <div class="col mb-3">
              <label class="form-label">Expiry Year</label>
              <input type="number" id="expiryYear" class="form-control" min="2025" max="2100" placeholder="YYYY">
            </div>
          </div>
          <div class="mb-3">
            <label class="form-label">CVV</label>
            <input type="text" id="cvv" class="form-control" maxlength="4" placeholder="123">
          </div>
          <div class="mb-3">
            <label class="form-label">Full Name (on Card)</label>
            <input type="text" id="ownerFullname" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address (for receipt)</label>
            <input type="email" id="ownerEmail" class="form-control">
          </div>
        `;
        } else if (method === 'dob') {
          methodFields.innerHTML = `
          <div class="mb-3">
            <label class="form-label">Select Bank</label>
            <select id="accountName" class="form-select">
              <option value="">-- Select Bank --</option>
              <option value="test_bank_one">BPI (Test)</option>
              <option value="test_bank_two">UnionBank (Test)</option>
              <option value="bdo">BDO</option>
              <option value="metrobank">Metrobank</option>
            </select>
          </div>
          <div class="mb-3">
            <label class="form-label">Full Name</label>
            <input type="text" id="ownerFullname" class="form-control">
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address (for receipt)</label>
            <input type="email" id="ownerEmail" class="form-control">
          </div>
        `;
        }
      }

      // when pay_type radio changes -> set amounts / readonly behavior
      function handlePayTypeChange() {
        const checked = getCheckedBoxes();
        const count = checked.length;
        let total = 0;
        let fullTotal = 0;
        let monthlyTotal = 0;
        checked.forEach(c => {
          total += Number(c.dataset.amount || 0);
          fullTotal += Number(c.dataset.tuition || 0);
          monthlyTotal += Number(c.dataset.monthly || 0);
        });
        const fullRadio = document.getElementById('pay_full');
        const monthlyRadio = document.getElementById('pay_monthly');
        const partialRadio = document.getElementById('pay_partial');
        if (fullRadio.checked) {
          // apply 8% discount
          const discount = fullTotal * DISCOUNT_RATE;
          const finalAmount = toFixedNum(fullTotal - discount);
          makeAmountReadOnlyAndSet(finalAmount);
          balanceSpan.textContent = "0.00"; // force balance 0
        } else if (monthlyRadio.checked) {
          computeTotals();
          makeAmountReadOnlyAndSet(monthlyTotal);
          balanceSpan.textContent = fmt(total - monthlyTotal); // update balance
        } else {
          // partial
          computeTotals();
          makeAmountEditable();
        }
        // update total & partial labels without overriding the above logic
        totalAmountSpan.textContent = fmt(total);
        modalTotal.textContent = fmt(total);
        modalPartialLabel.textContent = fmt(Number(partialInput.value || 0));
      }


      // attach listeners for pay_type radios
      document.getElementById('paymentTypeChoice').addEventListener('change', function (e) {
        if (e.target && e.target.name === 'pay_type') {
          handlePayTypeChange();
        }
      });

      // when a payment method radio changes
      document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
        radio.addEventListener('change', function () {
          renderMethodFields(this.value);                  // your existing function
          document.getElementById('paymentMethodHidden').value = this.value; // set hidden input
          console.log("Selected payment method:", this.value); // optional for debugging
        });
      });
      const payTypeRadios = document.querySelectorAll('input[name="pay_type"]');
      const hiddenPayType = document.getElementById('pay_type');

      payTypeRadios.forEach(radio => {
        radio.addEventListener('change', function () {
          hiddenPayType.value = this.value;  // update hidden input
          console.log("Selected pay type:", this.value);
        });
      });

      // Prefill hidden input on page load if a radio is already checked
      const checkedPayType = document.querySelector('input[name="pay_type"]:checked');
      if (checkedPayType) hiddenPayType.value = checkedPayType.value;


      // open modal: validation and copy hidden inputs
      openModalBtn.addEventListener('click', function (e) {
              e.preventDefault();

              // ensure payment method selected
              if (!selectedPaymentMethod) {
        Swal.fire({
          icon: 'warning',
          title: 'Missing Payment Method',
          text: 'Please select a payment method first.',
          confirmButtonColor: '#3085d6',
          confirmButtonText: 'OK'
        });
        return;
      }


        // collect selected children
        const checked = getCheckedBoxes();
                if (checked.length === 0) {
          Swal.fire({
            icon: 'warning',
            title: 'No Child Selected',
            text: 'Please select at least one child to pay for.',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
          });
          return;
        }


        // method-specific checks
        if (selectedPaymentMethod === 'card') {
          const cardNumber = document.getElementById('cardNumber');
          const expM = document.getElementById('expiryMonth');
          const expY = document.getElementById('expiryYear');
          const cvv = document.getElementById('cvv');
          if (
  !cardNumber || !expM || !expY || !cvv ||
  !cardNumber.value.trim() || !expM.value || !expY.value || !cvv.value.trim()
) {
  Swal.fire({
    icon: 'warning',
    title: 'Incomplete Card Details',
    text: 'Please complete card details before proceeding.',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
  });
  return;
}

        }
        if (selectedPaymentMethod === 'dob') {
          const acc = document.getElementById('accountName');
          if (!acc || !acc.value) {
  Swal.fire({
    icon: 'warning',
    title: 'Bank Not Selected',
    text: 'Please select a bank for DOB before proceeding.',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
  });
  return;
}

        }

        // assemble modal hidden children
        modalChildrenContainer.innerHTML = '';
        let total = 0;
        checked.forEach(c => {
          modalChildrenContainer.appendChild(createHidden('children[]', c.value));
          total += Number(c.dataset.amount || 0);
        });

        // set plan id and totals
        modalPlanInput.value = PLAN_ID;
        modalTotal.textContent = fmt(total);

        const amountToPay = toFixedNum(Number(partialInput.value || 0));
        modalPartialLabel.textContent = fmt(amountToPay);

        // set modal method labels
        modalMethodLabel.textContent = (selectedPaymentMethod || '').toUpperCase();

        // clear previous hidden method inputs
        modalMethodHidden.innerHTML = '';

        // copy method-specific values to hidden inputs and visible summary
        if (selectedPaymentMethod === 'card') {
          const cardNumberVal = (document.getElementById('cardNumber') || {}).value || '';
          const expMVal = (document.getElementById('expiryMonth') || {}).value || '';
          const expYVal = (document.getElementById('expiryYear') || {}).value || '';
          const cvvVal = (document.getElementById('cvv') || {}).value || '';
          const ownerNameVal = (document.getElementById('ownerFullname') || {}).value || '';
          const ownerEmailVal = (document.getElementById('ownerEmail') || {}).value || '';

          modalMethodHidden.appendChild(createHidden('payment_method', 'card'));
          modalMethodHidden.appendChild(createHidden('cardNumber', cardNumberVal));
          modalMethodHidden.appendChild(createHidden('expiryMonth', expMVal));
          modalMethodHidden.appendChild(createHidden('expiryYear', expYVal));
          modalMethodHidden.appendChild(createHidden('cvv', cvvVal));
          modalMethodHidden.appendChild(createHidden('payamount', amountToPay));

          modalMethodDetail.textContent = maskCard(cardNumberVal);
          modalFullname.value = ownerNameVal;
          modalEmail.value = ownerEmailVal;
          modalNumber.value = '';
          document.getElementById('contactNumberDiv').style.display = 'none';
        } else if (selectedPaymentMethod === 'dob') {
          const bankVal = (document.getElementById('accountName') || {}).value || '';
          const bankText = (document.getElementById('accountName') || {}).selectedOptions?.[0]?.text || bankVal;
          const ownerNameVal = (document.getElementById('ownerFullname') || {}).value || '';
          const ownerEmailVal = (document.getElementById('ownerEmail') || {}).value || '';

          modalMethodHidden.appendChild(createHidden('payment_method', 'dob'));
          modalMethodHidden.appendChild(createHidden('accountName', bankVal));
          modalMethodHidden.appendChild(createHidden('payamount', amountToPay));

          modalMethodDetail.textContent = bankText;
          modalFullname.value = ownerNameVal;
          modalEmail.value = ownerEmailVal;
          modalNumber.value = '';
          document.getElementById('contactNumberDiv').style.display = 'none';
        } else if (selectedPaymentMethod === 'gcash' || selectedPaymentMethod === 'paymaya') {
          const ownerNameVal = (document.getElementById('ownerFullname') || {}).value || '';
          const ownerNumberVal = (document.getElementById('ownerNumber') || {}).value || '';
          const ownerEmailVal = (document.getElementById('ownerEmail') || {}).value || '';

          modalMethodHidden.appendChild(createHidden('payment_method', selectedPaymentMethod));
          modalMethodHidden.appendChild(createHidden('payamount', amountToPay));

          modalMethodDetail.textContent = selectedPaymentMethod.toUpperCase();
          modalFullname.value = ownerNameVal;
          modalEmail.value = ownerEmailVal;
          modalNumber.value = ownerNumberVal;
          document.getElementById('contactNumberDiv').style.display = 'block';
        }

        // show modal
        const finalModalEl = document.getElementById('finalModal');
        const bootstrapModal = new bootstrap.Modal(finalModalEl, {});
        bootstrapModal.show();
      });

      // final form submit validation
      const finalPaymentForm = document.getElementById('finalPaymentForm');
      finalPaymentForm.addEventListener('submit', function (e) {
        if (!modalFullname.value || !modalEmail.value) {
  e.preventDefault();
  Swal.fire({
    icon: 'warning',
    title: 'Incomplete Information',
    text: 'Please fill in fullname and email in the modal.',
    confirmButtonColor: '#3085d6',
    confirmButtonText: 'OK'
  });
  return;
}

        document.getElementById('confirmPayBtn').textContent = 'Processing...';
      });

      // fetch children from server for misc plan
      function fetchMiscChildren() {
        miscChildrenList.innerHTML = '<li class="list-group-item">Loading children...</li>';
        fetch("<?= base_url('get-paymentsutition') ?>/" + PLAN_ID + "/<?= esc($student->user_id) ?>")
          .then(res => res.json())
          .then(data => {
            childrenCache = Array.isArray(data) ? data : [];
            populateMiscChildren(childrenCache);
          })
          .catch(err => {
            console.error('fetch error', err);
            miscChildrenList.innerHTML = '<li class="list-group-item">Unable to load children.</li>';
          });
      }

      // partial input listener
      partialInput.addEventListener('input', computeTotals);

      // when pay type radio is changed anywhere (we listened earlier on container)
      document.getElementById('paymentTypeChoice').addEventListener('change', function (e) {
        if (e.target && e.target.name === 'pay_type') {
          handlePayTypeChange();
        }
      });

      // attach event to paymentMethod radios to update selectedPaymentMethod variable
      document.querySelectorAll('input[name="paymentMethod"]').forEach(r => {
        r.addEventListener('change', function () {
          selectedPaymentMethod = this.value;
          renderMethodFields(this.value);
        });
      });

      // initial fetch
      fetchMiscChildren();
    }); // DOMContentLoaded
  </script>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

  <!-- DataTables -->
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

  <!-- Initialize DataTable -->
  <script>
    $(document).ready(function () {
      $('#paymentHistoryTable').DataTable({

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