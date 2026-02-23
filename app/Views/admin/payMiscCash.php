<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />

  <!-- DataTables -->
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="<?= base_url('dist/css/bootstrap.min.css') ?>">
  <link rel="stylesheet" href="<?= base_url('assets/css/admin.css') ?>">
</head>

<body>
  <div class="wrapper">
    <!-- Sidebar -->
    <nav id="adminSidebar" class="admin-sidebar col-lg-2 bg-white border-end ps-3 vh-100">
      <div class="d-flex align-items-center mb-2 mt-3">
        <img  id="schoolLogo"   src="<?= base_url('assets/img/logoicon.png') ?>" alt="Logo" class="me-3 ms-1" style="width: 38px;">
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
        <div class="container">
          <h3 class="text-primary mb-4">
            <i onclick="window.location.href='<?= base_url(); ?>admin-payment'" class="fas fa-arrow-left me-3" style="cursor: pointer;"></i>Miscellaneous Fee
          </h3>
          <div class="row">
            <?php foreach ($childrens as $child): 
                $pendingShown = false;

                // Kung may remaining balance > 0
                if (!empty($child->remaining_balance) && $child->remaining_balance > 0): 
                    $pendingShown = true; ?>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="card border-warning h-100 shadow-sm">
                            <div class="card-body">
                                <h6 class="card-title text-primary mb-2">
                                    <i class="fas fa-child me-2"></i> <?= esc($child->full_name); ?>
                                </h6>
                                
                                <p class="card-text mb-2">
                                    <strong>Remaining Balance:</strong>
                                    <span class="text-warning fw-bold">
                                        ₱<?= number_format($child->remaining_balance, 2); ?>
                                    </span>
                                </p>
                                <span class="badge bg-warning">
                                    <i class="fas fa-clock me-1"></i> Pending
                                </span>
                            </div>
                        </div>
                    </div>
                <?php endif;

                // Kung fully paid
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





          <div id="miscCard" class="card mb-4">
            <div class="card-header bg-primary text-white">
             Miscellaneous
            </div>
            <div class="card-body">
              <div id="paymentDetails" class="mt-3 border rounded p-3 bg-light" style="display:none;">
                <p class="mb-1"><strong>Select children to include in this payment:</strong></p>

                <ul id="miscChildrenList" class="list-group mb-3">
                  <!-- children injected by JS -->
                </ul>

                <div class="mb-3">
                  <p class="mb-1"><strong>Total Selected:</strong> ₱<span id="totalAmountMisc">0.00</span></p>
                  <label class="form-label mt-2"><strong>Enter Partial Payment:</strong></label>
                  <input type="number" id="partialInput" class="form-control mb-2" placeholder="Enter amount">
                  <p class="mb-0"><strong>Balance After Payment:</strong> ₱<span id="balanceMisc">0.00</span></p>
                </div>

                <div class="d-grid">
                  <button id="openModalBtn" class="btn btn-success">Pay Now</button>
                </div>
              </div>
            </div>
          </div>
        </div>

        <!-- FINAL PAYMENT MODAL -->
        <div class="modal fade" id="finalModal" tabindex="-1" aria-hidden="true">
          <div class="modal-dialog modal-dialog-centered">
            <form id="finalPaymentForm" class="modal-content" action="<?= base_url('payment-Miscellaneous'); ?>" method="POST">
              <div class="modal-header">
                <h5 class="modal-title">Confirm Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <!-- Hidden inputs -->
                <input type="hidden" name="plan_id" id="modal_plan_id" value="3">
                <input type="hidden" name="payamount" id="modalPayAmount" value="0">
                <input type="hidden" name="paymentOption" value="cash">
                <input type="hidden" name="fullname" value="Admin">

                <!-- Children injected -->
                <div id="modalChildrenContainer"></div>

                <div class="mb-2">
                  <p class="mb-1"><strong>Selected Total:</strong> ₱<span id="modalTotal">0.00</span></p>
                  <p class="mb-1"><strong>Partial Payment:</strong> ₱<span id="modalPartialLabel">0.00</span></p>
                </div>

                <div class="mb-2">
                  <label class="form-label">Email (Recipient)</label>
                  <input type="email" name="email" id="modalEmail" class="form-control" required>
                </div>

                <div class="mt-2 text-muted small">
                  By confirming you agree to proceed with the payment. You may be redirected to a payment gateway if applicable.
                </div>
              </div>

              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" id="confirmPayBtn" class="btn btn-success">Confirm & Pay</button>
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
    document.addEventListener("DOMContentLoaded", function () {
      const miscChildrenList = document.getElementById("miscChildrenList");
      const paymentDetails = document.getElementById("paymentDetails");
      const openModalBtn = document.getElementById("openModalBtn");

      const modalChildrenContainer = document.getElementById('modalChildrenContainer');
      const modalTotal = document.getElementById('modalTotal');
      const modalPartialLabel = document.getElementById('modalPartialLabel');
      const modalPlanInput = document.getElementById('modal_plan_id');
      const modalPayAmount = document.getElementById('modalPayAmount');

      const bootstrapModal = new bootstrap.Modal(document.getElementById('finalModal'));

      function createHidden(name, value) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = name;
        input.value = value;
        return input;
      }

      function fmt(num) {
        if (isNaN(num)) return "0.00";
        return parseFloat(num).toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 });
      }

      function updateTotals() {
        let total = 0;
        miscChildrenList.querySelectorAll('.child-checkbox').forEach(cb => {
          if (cb.checked) total += Number(cb.dataset.amount || 0);
        });
        document.getElementById('totalAmountMisc').textContent = fmt(total);

        const partial = Number(document.getElementById('partialInput').value || 0);
        const balance = Math.max(total - partial, 0);
        document.getElementById('balanceMisc').textContent = fmt(balance);

        modalTotal.textContent = fmt(total);
        modalPartialLabel.textContent = fmt(partial);
        modalPayAmount.value = partial;
      }

      function populateMiscChildren(children) {
        miscChildrenList.innerHTML = '';
        if (!Array.isArray(children) || children.length === 0) {
          miscChildrenList.innerHTML = '<li class="list-group-item">No children found.</li>';
          return;
        }
        children.forEach(child => {
          const li = document.createElement('li');
          li.className = "list-group-item d-flex justify-content-between align-items-center child-line";
          li.innerHTML = `<label class="mb-0">
            <input class="child-checkbox me-2" type="checkbox" value="${child.admission_id}" data-amount="${child.remaining_balance}">
            ${child.full_name}
          </label><strong>₱${fmt(child.remaining_balance)}</strong>`;
          miscChildrenList.appendChild(li);
        });
        miscChildrenList.querySelectorAll('.child-checkbox').forEach(cb => cb.addEventListener('change', updateTotals));
        paymentDetails.style.display = 'block';
        updateTotals();
      }

      function fetchMiscChildren() {
        miscChildrenList.innerHTML = '<li class="list-group-item">Loading children...</li>';
        fetch("<?= base_url('get-payments') ?>/3/<?= esc($student->user_id) ?>")
          .then(res => res.json())
          .then(data => populateMiscChildren(Array.isArray(data) ? data : []))
          .catch(err => {
            console.error(err);
            miscChildrenList.innerHTML = '<li class="list-group-item">Unable to load children.</li>';
          });
      }

      openModalBtn.addEventListener('click', e => {
        e.preventDefault();
        const checked = Array.from(miscChildrenList.querySelectorAll('.child-checkbox')).filter(c => c.checked);
        if (checked.length === 0) return alert("Please select at least one child to pay for.");

        modalChildrenContainer.innerHTML = '';
        let total = 0;
        checked.forEach(c => {
          modalChildrenContainer.appendChild(createHidden('children[]', c.value));
          total += Number(c.dataset.amount || 0);
        });
        modalPlanInput.value = 3;
        modalTotal.textContent = fmt(total);
        modalPartialLabel.textContent = fmt(Number(document.getElementById('partialInput').value || 0));
        modalPayAmount.value = Number(document.getElementById('partialInput').value || 0);
        bootstrapModal.show();
      });

      document.getElementById('finalPaymentForm').addEventListener('submit', e => {
        if (!document.getElementById('modalEmail').value) {
          e.preventDefault();
          alert("Please fill in email.");
        } else {
          document.getElementById('confirmPayBtn').textContent = 'Processing...';
        }
      });

      fetchMiscChildren();
      document.getElementById('partialInput').addEventListener('input', updateTotals);
    });
    function populateChildren(children) {
  childrenList.innerHTML = '';
  if (!Array.isArray(children) || children.length === 0) {
    childrenList.innerHTML = '<li class="list-group-item">No children found.</li>';
    return;
  }

  children.forEach(child => {
    if (!child.remaining_balance || Number(child.remaining_balance) <= 0) return;

    // Add checkbox for payment
    const li = document.createElement('li');
    li.className = "list-group-item d-flex justify-content-between align-items-center";
    li.innerHTML = `
      <label class="mb-0">
        <input class="child-checkbox me-2" type="checkbox" value="${child.admission_id}" data-amount="${child.remaining_balance}">
        ${child.full_name}
      </label>
      <strong>₱${Number(child.remaining_balance).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</strong>
    `;
    childrenList.appendChild(li);

    // Optional: update the card remaining balance dynamically
    const cardBalanceElem = document.querySelector(`#child-card-${child.admission_id} .remaining-balance`);
    if (cardBalanceElem) {
      cardBalanceElem.textContent = `₱${Number(child.remaining_balance).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}`;
    }
  });

  childrenList.querySelectorAll('.child-checkbox').forEach(cb => cb.addEventListener('change', computeTotals));
  paymentDetails.style.display = 'block';
  computeTotals();
}
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
