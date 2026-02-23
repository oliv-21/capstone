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
    /* small improvements (kept design) */
    .notice-card { border: 2px dashed #ffc107; background: #fff8e1; }
    .child-line { gap: .5rem; }
    .method-section { margin-top: 1rem; }
    .masked { font-family: monospace; }
  </style>
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
          <a href="<?= base_url('guardian/dashboard'); ?>" class="nav-link d-flex align-items-center">
          <i class="fas fa-child me-4 fa-lg fa-fw text-secondary"></i>
            Admission
          </a>
          <a href="<?= base_url('/guardian-announcement/'. esc($student->user_id)); ?>" class="nav-link d-flex align-items-center ">
            <i class="fas fa-tachometer-alt me-4 fa-lg fa-fw text-secondary"></i>
            <?php if ($unread_announcement > 0): ?>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                <?= $unread_announcement ?>
              </span>
            <?php endif; ?>
            Announcement
          </a>
          
          <a href="<?= base_url('/payment-history/'. esc($student->user_id)); ?>" class="nav-link d-flex align-items-center active ">
            <i class="fa-solid fa-money-bill me-4 fa-lg fa-fw text-secondary"></i> Payment
          </a>

        </div>
      </div>

      
      <div class="mt-5">
        <hr>
        <span class="fw-bold text-secondary small ms-1">Children</span>
        <ul class="list-unstyled ms-1 mt-2">
          <?php if (!empty($childrens)): ?>
            <?php foreach ($childrens as $child): ?>
              <li class="dropdown-item-text d-flex align-items-center mt-2">
                <a href="<?= base_url('/StudentviewDashboard/' . $child->admission_id) ?>" class="d-flex align-items-center text-decoration-none">
                  <img src="<?= base_url('public/assets/profilepic/' . esc($child->profile_pic)) ?>" 
                    alt="Child" class="rounded-circle border border-2 me-2" width="25" height="25">
                  <span  class="text-primary fw-bold"><?= esc($child->full_name) ?></span>
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
            <h5 class="text-primary m-0 ms-3 ">Miscellaneous</h5>
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
              <a href="#" 
                class="text-decoration-none text-primary position-relative"
                id="notifDropdown"
                data-bs-toggle="dropdown"
                aria-expanded="false"
                onclick="markAsRead(<?= esc($student->user_id) ?>)">
                
                <i class="fa-solid fa-bell fa-lg fa-fw"></i>
                <?php if ($unreadCount > 0): ?>
                  <span id="notifBadge" class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                    <?= $unreadCount ?>
                  </span>
                <?php endif; ?>
              </a>

              <ul class="dropdown-menu dropdown-menu-end shadow-sm overflow-auto" 
                  aria-labelledby="notifDropdown" 
                  style="width: 350px; max-height:320px;">
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
            
            <a href="<?= base_url(); ?>student-chat" class="text-decoration-none text-primary me-3 position-relative border-start border-2 ps-3">
              <i class="fa-solid fa-comment-dots fa-lg fa-fw"></i>
            </a>

            <!-- Admin Dropdown -->
            <div class="dropdown border-start border-2 ps-4">
              <a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
                 id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                 <img  src="<?= base_url('public/assets/profilepic/' . esc($student->profile_pic)) ?>"  alt="Profile Picture"
                    class="rounded-circle border border-2" width="30" height="30">
                <span class="fw-bold ms-2"><?= esc($student->full_name) ?></span>
              </a>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="profileDropdown">
                <li><a class="dropdown-item" href="<?= base_url('guardian-Profile'); ?>"><i class='fa-solid fa-user me-3 mb-2 text-primary mt-2'></i>Profile</a></li>
                <li><a class="dropdown-item" href="<?= base_url('guardian-resetPassword'); ?>"><i class='fa-solid fa-key me-3  mb-2 text-primary mt-2'></i>Reset Password</a></li>

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

      <main class="px-4 py-4" style="height: calc(100vh - 56px); overflow-y: auto;">
        <div class="container my-4">
          <h3 class="mb-3"></h3>

          <!-- Notice: removed paymentType select as requested -->
          <div id="none" class="card mb-4 notice-card text-center p-4" style="display:none;">
            <div>
              <i class="fa-solid fa-circle-exclamation fa-2x text-warning mb-2"></i>
              <p class="mb-0 fw-bold text-warning">Please select a payment method and children below</p>
            </div>
          </div>
          <?php foreach ($miscCard as $child): 
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

          <!-- MISC CARD (shown by default) -->
          <div id="miscCard" class="card mb-4">
            <div class="card-header bg-primary text-white">
              Bulk Payment (Miscellaneous)
            </div>
            <div class="card-body">
              <!-- Payment method radio (appear before children) -->
              <div class="mb-3">
                <label class="form-label"><strong>Select Payment Method:</strong></label><br>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="paymentMethod" id="method_gcash" value="gcash">
                  <label class="form-check-label" for="method_gcash">Gcash</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="paymentMethod" id="method_paymaya" value="paymaya">
                  <label class="form-check-label" for="method_paymaya">PayMaya</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="paymentMethod" id="method_card" value="card">
                  <label class="form-check-label" for="method_card">Card</label>
                </div>

                <div class="form-check form-check-inline">
                  <input class="form-check-input" type="radio" name="paymentMethod" id="method_dob" value="dob">
                  <label class="form-check-label" for="method_dob">DOB</label>
                </div>
              </div>

              <!-- Payment details and children (populated after method) -->
              <div id="paymentDetails" class="mt-3 border rounded p-3 bg-light" style="display:none;">
                <p class="mb-1"><strong>Select children to include in this payment:</strong></p>

                <ul id="miscChildrenList" class="list-group mb-3">
                  <!-- injected -->
                </ul>

                <div class="mb-3">
                  <p class="mb-1"><strong>Total Selected:</strong> ₱<span id="totalAmountMisc">0.00</span></p>
                  <label class="form-label mt-2"><strong>Enter Partial Payment:</strong></label>
                  <input type="number" id="partialInput" class="form-control mb-2" placeholder="Enter amount">
                  <p class="mb-0"><strong>Balance After Payment:</strong> ₱<span id="balanceMisc">0.00</span></p>
                </div>

                <!-- method-specific form area -->
                <div id="methodFields" class="method-section"></div>

                <!-- Pay Now opens modal with final form -->
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
            <form id="finalPaymentForm" class="modal-content" action="<?= base_url('payment-link-miscellaneous'); ?>" method="POST">
              <div class="modal-header">
                <h5 class="modal-title">Confirm Payment</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
              </div>

              <div class="modal-body">
                <!-- Hidden meta: plan_id (misc=3) & paymentMethod for server -->
                <input type="hidden" name="plan_id" id="modal_plan_id" value="3">
                <input type="hidden" name="paymentMethod" id="paymentMethodHidden" value="">

                <!-- Hidden children inputs will be injected here -->
                <div id="modalChildrenContainer"></div>

                <!-- hidden method inputs -->
                <div id="modalMethodHidden"></div>

                <div class="mb-2">
                  <p class="mb-1"><strong>Payment Method:</strong> <span id="modalMethodLabel"></span></p>
                  <p class="mb-1"><strong>Method detail:</strong> <span id="modalMethodDetail" class="masked"></span></p>
                  <p class="mb-1"><strong>Selected Total:</strong> ₱<span id="modalTotal">0.00</span></p>
                  <p class="mb-1"><strong>Partial Payment:</strong> ₱<span id="modalPartialLabel">0.00</span></p>
                </div>

                <div class="mb-2">
                  <label class="form-label">Name (Owner)</label>
                  <input type="text" name="fullname" id="modalFullname" class="form-control" required>
                </div>

                <div class="mb-2" id="contactNumberDiv">
                  <label class="form-label">Contact Number</label>
                  <input type="text" name="number" id="modalNumber" class="form-control" >
                </div>

                <div class="mb-2">
                  <label class="form-label">Email</label>
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

      </main>
    </div>
  </div>

  <!-- scripts -->
  <script src="<?= base_url('dist/js/bootstrap.bundle.min.js') ?>"></script>

  <script>
  document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM ready - Miscellaneous only");

    // elements
    const miscCard = document.getElementById("miscCard");
    const paymentDetails = document.getElementById("paymentDetails");
    const miscChildrenList = document.getElementById("miscChildrenList");
    const openModalBtn = document.getElementById("openModalBtn");
    const methodFields = document.getElementById("methodFields");
    const paymentMethodHidden = document.getElementById("paymentMethodHidden");

    // modal elements
    const finalModalEl = document.getElementById('finalModal');
    const bootstrapModal = new bootstrap.Modal(finalModalEl, {});
    const modalChildrenContainer = document.getElementById('modalChildrenContainer');
    const modalTotal = document.getElementById('modalTotal');
    const modalPartialLabel = document.getElementById('modalPartialLabel');
    const modalMethodLabel = document.getElementById('modalMethodLabel');
    const modalMethodDetail = document.getElementById('modalMethodDetail');
    const modalMethodHidden = document.getElementById('modalMethodHidden');
    const modalFullname = document.getElementById('modalFullname');
    const modalNumber = document.getElementById('modalNumber');
    const modalEmail = document.getElementById('modalEmail');
    const modalPlanInput = document.getElementById('modal_plan_id');

    // helper formatters
    function fmt(num) {
      if (isNaN(num)) return "0.00";
      return parseFloat(num).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
    function fmtFixed(num) {
      if (isNaN(num)) return "0.00";
      return parseFloat(num).toFixed(2);
    }

    // state
    let childrenCache = []; // array from server for misc plan
    let selectedPaymentMethod = null;
    const PLAN_ID = 3; // miscellaneous

    // totals updater
    function updateTotals() {
      let total = 0;
      const checkboxes = miscChildrenList.querySelectorAll('.child-checkbox');
      checkboxes.forEach(cb => {
        if (cb.checked) total += Number(cb.dataset.amount || 0);
      });
      document.getElementById('totalAmountMisc').textContent = fmt(total);

      const partialInput = document.getElementById('partialInput');
      const partial = partialInput ? Number(partialInput.value || 0) : 0;
      const balance = Math.max(total - partial, 0);
      document.getElementById('balanceMisc').textContent = fmt(balance);

      // update modal preview values (if open later)
      modalTotal.textContent = fmt(total);
      modalPartialLabel.textContent = fmt(partial);
      if (partialInput) {
    partialInput.max = total;
    if (partial > total) {
      partialInput.value = total;
    }
  }
    }

    // populate children into the list
    function populateMiscChildren(children) {
      console.log("populateMiscChildren", children);
      miscChildrenList.innerHTML = '';
      if (!Array.isArray(children) || children.length === 0) {
        miscChildrenList.innerHTML = '<li class="list-group-item">No children found.</li>';
        return;
      }

      children.forEach(child => {
        const li = document.createElement('li');
        li.className = "list-group-item d-flex justify-content-between align-items-center child-line";

        const left = document.createElement('div');
        left.innerHTML = `<label class="mb-0">
          <input class="child-checkbox me-2" type="checkbox" value="${child.admission_id}" data-amount="${child.remaining_balance}">
          ${child.full_name}
        </label>`;

        const right = document.createElement('strong');
        right.textContent = "₱" + Number(child.remaining_balance || 0).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});

        li.appendChild(left);
        li.appendChild(right);
        miscChildrenList.appendChild(li);
      });

      // attach checkbox listeners
      miscChildrenList.querySelectorAll('.child-checkbox').forEach(cb => {
        cb.addEventListener('change', updateTotals);
      });

      paymentDetails.style.display = 'block';
      updateTotals();
    }

    // render method fields dynamically
    function renderMethodFields(method) {
      selectedPaymentMethod = method;
      paymentMethodHidden.value = method || '';
      methodFields.innerHTML = '';
      modalMethodHidden.innerHTML = '';
      modalMethodLabel.textContent = method ? method.toUpperCase() : '';

      if (!method) return;

      if (method === 'gcash' || method === 'paymaya') {
        methodFields.innerHTML = `
          <div class="mb-3">
            <label class="form-label">Full Name (Owner)</label>
            <input type="text" id="ownerFullname" class="form-control" placeholder="Name">
          </div>
          <div class="mb-3">
            <label class="form-label">Gcash/PayMaya Number</label>
            <input type="text" id="ownerNumber" class="form-control" placeholder="09XXXXXXXXX">
          </div>
          <div class="mb-3">
            <label class="form-label">Email Address (for receipt)</label>
            <input type="email" id="ownerEmail" class="form-control" placeholder="email@example.com">
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

      // attach partial input listener just once
      const partialInput = document.getElementById('partialInput');
      if (partialInput) {
        partialInput.oninput = updateTotals;
      }
      updateTotals();
    }

    // mask card helper
    function maskCard(card) {
      if (!card) return '—';
      const digits = card.replace(/\D/g,'');
      if (digits.length <= 4) return '**** ' + digits;
      return '**** **** **** ' + digits.slice(-4);
    }

    // create hidden input helper
    function createHidden(name, value) {
      const el = document.createElement('input');
      el.type = 'hidden';
      el.name = name;
      el.value = value;
      return el;
    }

    // fetch children for misc on load
    function fetchMiscChildren() {
      // set plan id constant to 3
      childrenCache = [];
      // show loading placeholder
      miscChildrenList.innerHTML = '<li class="list-group-item">Loading children...</li>';
      fetch("<?= base_url('get-payments') ?>/" + PLAN_ID + "/<?= esc($student->user_id) ?>")
        .then(res => res.json())
        .then(data => {
          console.log("fetched children data:", data);
          childrenCache = Array.isArray(data) ? data : [];
          populateMiscChildren(childrenCache);
        })
        .catch(err => {
          console.error("fetch error", err);
          miscChildrenList.innerHTML = '<li class="list-group-item">Unable to load children.</li>';
          childrenCache = [];
        });
    }

    // wire up payment method radio change
    document.querySelectorAll('input[name="paymentMethod"]').forEach(r => {
      r.addEventListener('change', function() {
        renderMethodFields(this.value);
        // show paymentDetails when method chosen
        paymentDetails.style.display = 'block';
      });
    });

    // Open modal: validate, copy children into hidden inputs, copy method-specific fields, show modal
    openModalBtn.addEventListener('click', function(e) {
      e.preventDefault();

      // require method selected
      if (!selectedPaymentMethod) {
        alert("Please select a payment method first.");
        return;
      }

      // collect checked children
      const checked = Array.from(miscChildrenList.querySelectorAll('.child-checkbox')).filter(c => c.checked);
      if (checked.length === 0) {
        alert("Please select at least one child to pay for.");
        return;
      }

      // method-specific basic validation
      if (selectedPaymentMethod === 'card') {
        const cardNumber = document.getElementById('cardNumber');
        const expM = document.getElementById('expiryMonth');
        const expY = document.getElementById('expiryYear');
        const cvv = document.getElementById('cvv');
        if (!cardNumber || !expM || !expY || !cvv ||
            !cardNumber.value.trim() || !expM.value || !expY.value || !cvv.value.trim()) {
          alert("Please complete card details before proceeding.");
          return;
        }
      }
      if (selectedPaymentMethod === 'dob') {
        const acc = document.getElementById('accountName');
        if (!acc || !acc.value) {
          alert("Please select a bank for DOB before proceeding.");
          return;
        }
      }

      // prepare modal hidden children inputs
      modalChildrenContainer.innerHTML = '';
      let total = 0;
      checked.forEach(c => {
        modalChildrenContainer.appendChild(createHidden('children[]', c.value));
        total += Number(c.dataset.amount || 0);
      });

      // set plan id explicitly (just in case)
      modalPlanInput.value = PLAN_ID;

      // set totals in modal
      modalTotal.textContent = fmt(total);
      const partialVal = Number(document.getElementById('partialInput').value || 0);
      modalPartialLabel.textContent = fmt(partialVal);

      // set visible method label and detail
      modalMethodLabel.textContent = (selectedPaymentMethod || '').toUpperCase();

      // clear method hidden area
      modalMethodHidden.innerHTML = '';

      // copy method-specific inputs to hidden fields for server
      if (selectedPaymentMethod === 'card') {
        const cardNumberVal = (document.getElementById('cardNumber') || {}).value || '';
        const expMVal = (document.getElementById('expiryMonth') || {}).value || '';
        const expYVal = (document.getElementById('expiryYear') || {}).value || '';
        const cvvVal = (document.getElementById('cvv') || {}).value || '';
        const ownerNameVal = (document.getElementById('ownerFullname') || {}).value || '';
        const ownerEmailVal = (document.getElementById('ownerEmail') || {}).value || '';
        const payamountVal = (document.getElementById('partialInput') || {}).value || fmtFixed(total);

        modalMethodHidden.appendChild(createHidden('payment_method', 'card'));
        modalMethodHidden.appendChild(createHidden('cardNumber', cardNumberVal));
        modalMethodHidden.appendChild(createHidden('expiryMonth', expMVal));
        modalMethodHidden.appendChild(createHidden('expiryYear', expYVal));
        modalMethodHidden.appendChild(createHidden('cvv', cvvVal));
        modalMethodHidden.appendChild(createHidden('payamount', payamountVal));

        modalMethodDetail.textContent = maskCard(cardNumberVal);
        modalFullname.value = ownerNameVal;
        modalEmail.value = ownerEmailVal;
        modalNumber.value = '';
        
        document.getElementById("modalNumber").style.display = "none";
      } else if (selectedPaymentMethod === 'dob') {
        const bankVal = (document.getElementById('accountName') || {}).value || '';
        const bankText = (document.getElementById('accountName') || {}).selectedOptions?.[0]?.text || bankVal;
        const ownerNameVal = (document.getElementById('ownerFullname') || {}).value || '';
        const ownerEmailVal = (document.getElementById('ownerEmail') || {}).value || '';
        const payamountVal = (document.getElementById('partialInput') || {}).value || fmtFixed(total);

        modalMethodHidden.appendChild(createHidden('payment_method', 'dob'));
        modalMethodHidden.appendChild(createHidden('accountName', bankVal));
        modalMethodHidden.appendChild(createHidden('payamount', payamountVal));

        modalMethodDetail.textContent = bankText;
        modalFullname.value = ownerNameVal;
        modalEmail.value = ownerEmailVal;
        modalNumber.value = '';
         document.getElementById("modalNumber").style.display = "none";
      } else if (selectedPaymentMethod === 'gcash' || selectedPaymentMethod === 'paymaya') {
        const ownerNameVal = (document.getElementById('ownerFullname') || {}).value || '';
        const ownerNumberVal = (document.getElementById('ownerNumber') || {}).value || '';
        const ownerEmailVal = (document.getElementById('ownerEmail') || {}).value || '';
        const payamountVal = (document.getElementById('partialInput') || {}).value || fmtFixed(total);

        modalMethodHidden.appendChild(createHidden('payment_method', selectedPaymentMethod));
        modalMethodHidden.appendChild(createHidden('payamount', payamountVal));

        modalMethodDetail.textContent = selectedPaymentMethod.toUpperCase();
        modalFullname.value = ownerNameVal;
        modalEmail.value = ownerEmailVal;
        modalNumber.value = ownerNumberVal;
       
       
      }

      // show modal
      bootstrapModal.show();
    });

    // form submit validation
    const finalPaymentForm = document.getElementById('finalPaymentForm');
    finalPaymentForm.addEventListener('submit', function(e) {
      if (!modalFullname.value || !modalEmail.value) {
        e.preventDefault();
        alert("Please fill in fullname and email in the modal.");
        return;
      }
      document.getElementById('confirmPayBtn').textContent = 'Processing...';
      // allow submit
    });

    // when the page loads: fetch children for misc plan automatically
    fetchMiscChildren();

    // helper to mask card (kept)
    function maskCard(card) {
      if (!card) return '—';
      const digits = card.replace(/\D/g, '');
      if (digits.length <= 4) return '**** ' + digits;
      return '**** **** **** ' + digits.slice(-4);
    }

    // expose renderMethodFields to radio change events (we already attached above but ensure selectedPaymentMethod updated)
    document.querySelectorAll('input[name="paymentMethod"]').forEach(r => {
      r.addEventListener('change', function() {
        renderMethodFields(this.value);
      });
    });

  }); // DOMContentLoaded end
  
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

  <!-- Optional Backdrop -->
  <div id="sidebarBackdrop" class="sidebar-backdrop d-lg-none"></div>

  <script src="<?= base_url('assets/js/user.js') ?>"></script>
</body>
</html>
