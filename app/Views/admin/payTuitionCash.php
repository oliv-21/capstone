<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Payment</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
  <link href="../assets/img/logoicon.png" rel="icon" />
</head>

<body>
<div class="wrapper">
  <!-- Sidebar -->
  <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img  id="schoolLogo"  src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
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

  <!-- Main Content -->
  <div class="main col-md-10">
    <nav class="navbar navbar-expand-lg bg-white border-bottom pe-4">
      <div class="container-fluid">
        <button class="btn d-md-none me-2" id="sidebarToggle">
          <i class="fas fa-bars"></i>
        </button>
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
          <select id="school_year" class="form-select">

              <?php foreach ($yearsRecord as $r): ?>
                <option value="<?= $r['id'] ?>" 
                  <?= ($r['id'] == $selectedOpeningId) ? 'selected' : '' ?>>
                  <?= $r['school_year'] ?>
                </option>
              <?php endforeach; ?>
            </select>

        <div class="dropdown me-3 position-relative border-start border-2 ps-3 ">
              <a href="#" class="text-decoration-none text-primary position-relative" id="notifDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
               
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
          <a href="<?= base_url(); ?>admin-chats" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
            <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
          </a>

          <!-- Admin Dropdown -->
          <div class="dropdown border-start border-2 ps-4">
            <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
              id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
              <img src="<?= base_url('public/assets/profilepic/' . esc($profilepic)) ?>" alt="Profile Image"
                class="me-2 rounded-circle" style="width: 36px; height: 36px; object-fit: cover;">
              <span class="fw-bold ms-2">Admin</span>
            </a>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
              <li><a class="dropdown-item" href="<?= base_url('adminProfile'); ?>"><i
                    class='fa-solid fa-user me-3 mb-3 text-primary mt-2'></i>Profile</a></li>
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
      <div class="container my-4">
        <h3 class="text-primary mb-4">
          <i onclick="window.location.href='<?= base_url(); ?>admin-payment'" class="fas fa-arrow-left me-3" style="cursor: pointer;"></i>Tuition Fee
        </h3>
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
                                                      <strong>Date:</strong> <?= date('F', strtotime($row['due_date'])); ?>
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
      <div class="container">
        
        <div id="paymentCard" class="card mb-4">
          <div class="card-header bg-primary text-white">Payment</div>
          <div class="card-body">
            <div id="paymentDetails" class="mt-3 border rounded p-3 bg-light" style="display:none;">
              <p class="mb-1"><strong>Select children:</strong></p>
              <ul id="childrenList" class="list-group mb-3"></ul>

              <div class="mb-3">
                <p class="mb-1"><strong>Total Selected:</strong> ₱<span id="totalAmount">0.00</span></p>

                <div class="mb-2" id="paymentTypeChoice" style="display:none;">
                  <label class="form-label"><strong>Payment Type</strong></label><br>
                  <div class="form-check form-check-inline" id='payFullOption'>
                    <input class="form-check-input" type="radio" name="pay_type" id="full" value="full">
                    <label class="form-check-label" for="full">Full Payment (8% Discount)</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pay_type" id="monthly" value="monthly">
                    <label class="form-check-label" for="monthly">Monthly</label>
                  </div>
                  <div class="form-check form-check-inline">
                    <input class="form-check-input" type="radio" name="pay_type" id="partial" value="partial" checked>
                    <label class="form-check-label" for="partial">Partial / Advance</label>
                  </div>
                </div>

                <label class="form-label mt-2"><strong>Amount to Pay (₱)</strong></label>
                <input type="number" id="partialInputMain" class="form-control mb-2" placeholder="Enter amount (Partial/Advance)" required>

                <p class="mb-0"><strong>Balance After Payment:</strong> ₱<span id="balance">0.00</span></p>
              </div>

              <div class="d-grid mt-3">
                <button id="openModalBtn" class="btn btn-success">Pay Now (Cash)</button>
              </div>
            </div>
          </div>
        </div>

      </div>

      <!-- FINAL PAYMENT MODAL -->
      <div class="modal fade" id="finalModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
          <form id="finalPaymentForm" class="modal-content" action="<?= base_url('payment-Tuition'); ?>" method="POST">
            <div class="modal-header">
              <h5 class="modal-title">Confirm Payment (Cash)</h5>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
              <input type="hidden" name="plan_id" value="4">
              <input type="hidden" name="pay_type" id="modalPayType" value="">
              <input type="hidden" name="paymentOption" value="cash">
              <input type="hidden" name="payamount" id="modalPartialInput" value="">
              <div id="modalChildrenContainer"></div>

              <div class="mb-2">
                <p class="mb-1" hidden><strong>Selected Total:</strong> ₱<span id="modalTotal">0.00</span></p>
                <p class="mb-1"><strong>Amount To Pay:</strong> ₱<span id="modalPartialLabel">0.00</span></p>
              </div>

              <div class="mb-2">
                <label class="form-label">Name</label>
                <input type="text" name="fullname" id="modalFullname" class="form-control" required>
              </div>

              <div class="mb-2">
                <label class="form-label">Email</label>
                <input type="email" name="email" id="modalEmail" class="form-control" required>
              </div>

              <div class="mt-2 text-muted small">
                By confirming you agree to proceed with the payment in cash.
              </div>
            </div>

            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
              <button type="submit" class="btn btn-success">Confirm & Pay</button>
            </div>
          </form>
        </div>
      </div>
      
<div class="container mt-4">
  <h4 class="text-primary mb-3">
    <i class="fa-solid fa-money-bill-wave me-2"></i> Miscellaneous Payment History
  </h4>

  <div class="table-responsive">
    <table class="table table-bordered table-hover align-middle">
      <thead class="table-primary text-center">
        <tr>
          <th>#</th>
          <th>Student Name</th>
          <th>Amount Paid</th>
          <th>Payment Method</th>
          <th>Payment Date</th>
          <th> Receipt</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($Mischistory)): ?>
          <?php $i = 1; foreach ($Mischistory as $history): ?>
            <tr>
              <td class="text-center"><?= $i++; ?></td>
              <td><?= esc($history['full_name']); ?></td>
              <td>₱<?= number_format($history['amount_paid'], 2); ?></td>
              <td><?= esc($history['payment_method']); ?></td>
              <td><?= date('F j, Y g:i A', strtotime($history['payment_date'])); ?></td>
              <td class="text-center fw-semibold">
                    <a href="<?= base_url('/guardian-report/'.esc($history['payment_id'])); ?>" 
                      class="btn btn-primary btn-sm" 
                      target="_blank">
                        View Receipt
                    </a>

                  </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="5" class="text-center text-muted">No payment history found.</td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

    </main>
  </div>
</div>

<!-- JS -->
<script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>
<script>
document.addEventListener("DOMContentLoaded", function() {
  const childrenList = document.getElementById('childrenList');
  const paymentDetails = document.getElementById('paymentDetails');
  const openModalBtn = document.getElementById('openModalBtn');
  const modalChildrenContainer = document.getElementById('modalChildrenContainer');
  const modalTotal = document.getElementById('modalTotal');
  const modalPartialLabel = document.getElementById('modalPartialLabel');
  const partialInputMain = document.getElementById('partialInputMain');
  const balance = document.getElementById('balance');
  const paymentTypeChoice = document.getElementById('paymentTypeChoice');
  const modalPayType = document.getElementById('modalPayType');
  const modalPartialInput = document.getElementById('modalPartialInput');

  const PLAN_ID = 4;
  //const FULL_PER_CHILD = 25000;
  // const MONTHLY_PER_CHILD = 2500;
  const DISCOUNT_RATE = 0.08;
  let childrenCache = [];

  function fmt(num) {
    if (isNaN(num)) return "0.00";
    return parseFloat(num).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
  }

  function getCheckedBoxes() {
    return Array.from(childrenList.querySelectorAll('.child-checkbox')).filter(cb => cb.checked);
  }

 function computeTotals() {
  const checked = getCheckedBoxes();
  let total = 0;
  let fullSum = 0;
  let monthlySum = 0;
  checked.forEach(c => {
    total += Number(c.dataset.amount || 0);
    fullSum += Number(c.dataset.amount || 0); 
    monthlySum += Number(c.dataset.monthly || 0);
  });

  const payType = document.querySelector('input[name="pay_type"]:checked')?.value || 'partial';

  if (payType === 'full') {
    const discounted = fullSum * (1 - DISCOUNT_RATE);
    partialInputMain.value = discounted.toFixed(2);
    partialInputMain.setAttribute('readonly', 'readonly');
    balance.textContent = "0.00";
  } else if (payType === 'monthly') {
    partialInputMain.value = monthlySum.toFixed(2);
    partialInputMain.setAttribute('readonly', 'readonly');
    balance.textContent = fmt(total - monthlySum);
  } else {
    partialInputMain.removeAttribute('readonly');
    balance.textContent = fmt(total - (partialInputMain.value || 0));
  }

  document.getElementById('totalAmount').textContent = fmt(total);
  modalTotal.textContent = fmt(total);
  modalPartialLabel.textContent = partialInputMain.value || "0.00";
  paymentTypeChoice.style.display = checked.length ? 'block' : 'none';
}

  function populateChildren(children) {
  childrenList.innerHTML = '';
  if (!Array.isArray(children) || children.length === 0) {
    childrenList.innerHTML = '<li class="list-group-item">No children found.</li>';
    return;
  }
  children.forEach(child => {
    if (!child.remaining_balance || Number(child.remaining_balance) <= 0) return;
    const monthly = child.monthly_payment || (child.tuition_fee / 10);  // Fallback: assume 10 months
    const li = document.createElement('li');
    li.className = "list-group-item d-flex justify-content-between align-items-center";
    li.innerHTML = `<label class="mb-0">
                      <input class="child-checkbox me-2" type="checkbox" value="${child.admission_id}" data-amount="${child.remaining_balance}" data-monthly="${monthly}">
                      ${child.full_name}
                    </label>
                    <strong>₱${fmt(child.remaining_balance)}</strong>`;
    childrenList.appendChild(li);
  });
  childrenList.querySelectorAll('.child-checkbox').forEach(cb => cb.addEventListener('change', computeTotals));
  paymentDetails.style.display = 'block';
  computeTotals();
}



  partialInputMain.addEventListener('input', computeTotals);

  document.querySelectorAll('input[name="pay_type"]').forEach(radio => {
    radio.addEventListener('change', () => {
      modalPayType.value = document.querySelector('input[name="pay_type"]:checked').value;
      computeTotals();
    });
    if (radio.checked) modalPayType.value = radio.value;
  });

  openModalBtn.addEventListener('click', () => {
    modalChildrenContainer.innerHTML = '';
    getCheckedBoxes().forEach(cb => {
      const child = childrenCache.find(c => c.admission_id == cb.value);
      if (child) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = 'children[]';
        input.value = cb.value;
        modalChildrenContainer.appendChild(input);

        modalChildrenContainer.insertAdjacentHTML('beforeend', `<p class="mb-1">${child.full_name} - ₱${fmt(child.remaining_balance)}</p>`);
      }
    });

    modalPartialInput.value = partialInputMain.value;
    modalPartialLabel.textContent = partialInputMain.value || "0.00";

    bootstrap.Modal.getOrCreateInstance(document.getElementById('finalModal')).show();
  });

  // Fetch children from API
  // Fetch children from API
fetch("<?= base_url('get-paymentsutition') ?>/" + PLAN_ID + "/<?= esc($student->user_id) ?>")
  .then(res => res.json())
  .then(data => {

    childrenCache = Array.isArray(data) ? data : [];
    populateChildren(childrenCache);
    // Check if first payment or not
let firstPaymentOnly = true;

childrenCache.forEach(child => {
  if (Number(child.remaining_balance) < Number(child.tuition_fee)) {
    firstPaymentOnly = false;
  }
});

// If not first payment, hide FULL option
const fullOption = document.getElementById('payFullOption'); // assign ID sa radio
if (!firstPaymentOnly && fullOption) {
  fullOption.style.display = 'none';

  // If currently selected, switch to partial automatically
  const selected = document.querySelector('input[name="pay_type"]:checked');
  if (selected && selected.value === 'full') {
    document.querySelector('input[value="partial"]').checked = true;
  }
}
  })
  .catch(err => {
    console.error(err);
    childrenList.innerHTML = '<li class="list-group-item">Unable to load children.</li>';
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
