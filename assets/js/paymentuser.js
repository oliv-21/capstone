    document.addEventListener("DOMContentLoaded", function() {
    console.log("DOM ready");

    const paymentType = document.getElementById("paymentType");
    const miscCard = document.getElementById("miscCard");
    const tuitionCard = document.getElementById("tuitionCard");
    const noneCard = document.getElementById("none");
    const miscChildrenList = document.getElementById("miscChildrenList");
    const paymentDetails = document.getElementById("paymentDetails");
    const openModalBtn = document.getElementById("openModalBtn");
    const methodFields = document.getElementById("methodFields");

    // modal related
    const finalModalEl = document.getElementById('finalModal');
    const bootstrapModal = new bootstrap.Modal(finalModalEl, {});
    const modalChildrenContainer = document.getElementById('modalChildrenContainer');
    const modalTotal = document.getElementById('modalTotal');
    const modalPartialLabel = document.getElementById('modalPartialLabel');
    const modalPaymentMethod = document.getElementById('modalMethodLabel');
    const modalMethodDetail = document.getElementById('modalMethodDetail');
    const modalMethodHidden = document.getElementById('modalMethodHidden');
    const modalFullname = document.getElementById('modalFullname');
    const modalNumber = document.getElementById('modalNumber');
    const modalEmail = document.getElementById('modalEmail');
    const modalPlanInput = document.getElementById('modal_plan_id');

    // helper: format number with commas and 2 decimals
    function fmt(num) {
      if (isNaN(num)) return "0.00";
      return parseFloat(num).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2});
    }
    // plain fixed (no commas) for editable numeric input defaults
    function fmtFixed(num) {
      if (isNaN(num)) return "0.00";
      return parseFloat(num).toFixed(2);
    }

    // state storage
    let childrenCache = []; // fetched children list
    let selectedPaymentMethod = null;

    // totals updater (reads checkboxes in miscChildrenList)
    function updateTotals() {
      let total = 0;
      const checkboxes = miscChildrenList.querySelectorAll('.child-checkbox');
      checkboxes.forEach(cb => {
        if (cb.checked) total += Number(cb.dataset.amount || 0);
      });
      document.getElementById('totalAmountMisc').textContent = fmt(total);

      // set the payamount input (if exists) to total by default but keep editable
      const payamountEl = document.getElementById('payamount');
      if (payamountEl) {
        // set value as plain number format with 2 decimals (editable)
        payamountEl.value = fmtFixed(total);
      }

      // partial input & balance
      const partialInput = document.getElementById('partialInput');
      const partial = partialInput ? Number(partialInput.value || 0) : 0;
      const balance = Math.max(total - partial, 0);
      document.getElementById('balanceMisc').textContent = fmt(balance);

      // update modal total preview if modal is open
      modalTotal.textContent = fmt(total);
      modalPartialLabel.textContent = fmt(partial);
    }

    // build children list (Style 1)
    function populateMiscChildren(children) {
      console.log("populateMiscChildren", children);
      miscChildrenList.innerHTML = '';
      children.forEach(child => {
        const li = document.createElement('li');
        li.className = "list-group-item d-flex justify-content-between align-items-center child-line";

        // left: checkbox + name
        const left = document.createElement('div');
        left.innerHTML = `<label class="mb-0"><input class="child-checkbox me-2" type="checkbox" name="children[]" value="${child.admission_id}" data-amount="${child.remaining_balance}"> ${child.full_name}</label>`;

        // right: amount
        const right = document.createElement('strong');
        right.textContent = "₱" + Number(child.remaining_balance || 0).toLocaleString(undefined, {minimumFractionDigits:2, maximumFractionDigits:2});

        li.appendChild(left);
        li.appendChild(right);
        miscChildrenList.appendChild(li);
      });

      // attach listeners to checkboxes
      miscChildrenList.querySelectorAll('.child-checkbox').forEach(cb => {
        cb.addEventListener('change', () => {
          updateTotals();
        });
      });

      // show details area
      paymentDetails.style.display = 'block';
      updateTotals();
    }

    // Render method fields depending on selectedPaymentMethod
    function renderMethodFields(method) {
      selectedPaymentMethod = method;
      methodFields.innerHTML = ''; // reset
      modalMethodHidden.innerHTML = '';

      if (!method) return;

      if (method === 'gcash' || method === 'paymaya') {
        // simple owner fields (existing)
        methodFields.innerHTML = `
          <div class="mb-3">
            <label for="ownerFullname" class="form-label">Full Name (Owner)</label>
            <input type="text" id="ownerFullname" class="form-control" placeholder="Name">
          </div>
          <div class="mb-3">
            <label for="ownerNumber" class="form-label">Gcash/PayMaya Number</label>
            <input type="text" id="ownerNumber" class="form-control" placeholder="09XXXXXXXXX">
          </div>
          <div class="mb-3">
            <label for="ownerEmail" class="form-label">Email Address (for receipt)</label>
            <input type="email" id="ownerEmail" class="form-control" placeholder="email@example.com">
          </div>
        `;
      } else if (method === 'card') {
        // full card form (NOT readonly as requested)
        methodFields.innerHTML = `
          
          <div class="mb-3">
            <label for="cardNumber" class="form-label">Card Number</label>
            <input type="text" class="form-control" id="cardNumber" name="cardNumber" required maxlength="19" placeholder="1234 5678 9012 3456">
          </div>
          <div class="row">
            <div class="col mb-3">
              <label for="expiryMonth" class="form-label">Expiry Month</label>
              <input type="number" class="form-control" id="expiryMonth" name="expiryMonth" placeholder="MM (e.g. 01)" min="1" max="12" required>
            </div>
            <div class="col mb-3">
              <label for="expiryYear" class="form-label">Expiry Year</label>
              <input type="number" class="form-control" id="expiryYear" name="expiryYear" placeholder="YYYY (e.g. 2026)" min="2025" max="2100" required>
            </div>
          </div>
          <div class="mb-3">
            <label for="cvv" class="form-label">CVV</label>
            <input type="text" class="form-control" id="cvv" name="cvv" required maxlength="4" placeholder="123">
          </div>
          <div class="mb-3">
            <label for="ownerFullname" class="form-label">Full Name (on Card)</label>
            <input type="text" class="form-control" id="ownerFullname" name="ownerFullname">
          </div>
          <div class="mb-3">
            <label for="ownerEmail" class="form-label">Email Address (for receipt)</label>
            <input type="email" class="form-control" id="ownerEmail" name="ownerEmail">
          </div>
        `;
      } else if (method === 'dob') {
        methodFields.innerHTML = `
          
          <div class="mb-3">
            <label for="accountName" class="form-label">Select Bank</label>
            <select class="form-select" id="accountName" name="accountName" required>
              <option value="">-- Select Bank --</option>
              <!-- DOB Banks -->
              <option value="test_bank_one">BPI (Test)</option>
              <option value="test_bank_two">UnionBank (Test)</option>
              <!-- Brankas Banks -->
              <option value="bdo">BDO (not available / testing)</option>
              <option value="metrobank">Metrobank (not available / testing)</option>
              <option value="landbank">Landbank (not available / testing)</option>
            </select>
          </div>
          <div class="mb-3">
            <label for="ownerFullname" class="form-label">Full Name</label>
            <input type="text" class="form-control" id="ownerFullname" name="ownerFullname">
          </div>
          <div class="mb-3">
            <label for="ownerEmail" class="form-label">Email Address (for receipt)</label>
            <input type="email" class="form-control" id="ownerEmail" name="ownerEmail">
          </div>
        `;
      }

      // attach event: partial input change affects totals
      const partialInput = document.getElementById('partialInput');
      if (partialInput) {
        partialInput.addEventListener('input', updateTotals);
      }

      // ensure payamount updates when totals change
      updateTotals();
    }

    // when payment type changes -> show the appropriate card and fetch data for misc (plan 2)
    paymentType.addEventListener('change', function() {
      const planId = this.value;
      console.log("paymentType changed:", planId);
      noneCard.style.display = 'none';
      miscCard.style.display = planId == 3 ? 'block' : 'none';
      tuitionCard.style.display = planId == 4 ? 'block' : 'none';

      if (planId == 3) {
        // hide details until method selected
        paymentDetails.style.display = 'none';
        miscChildrenList.innerHTML = '';
        childrenCache = [];

        // fetch children data for this guardian & plan
        fetch("<?= base_url('get-payments') ?>/" + planId + "/<?= esc($student->user_id) ?>")
          .then(res => res.json())
          .then(data => {
            console.log("fetched children data:", data);
            // store cache but DO NOT show until payment method chosen
            childrenCache = Array.isArray(data) ? data : [];
          })
          .catch(err => {
            console.error("fetch error", err);
            childrenCache = [];
          });
      }
      if (planId == 4) {
        // hide details until method selected
        paymentDetails.style.display = 'none';
        miscChildrenList.innerHTML = '';
        childrenCache = [];

        // fetch children data for this guardian & plan
        fetch("<?= base_url('get-payments') ?>/" + planId + "/<?= esc($student->user_id) ?>")
          .then(res => res.json())
          .then(data => {
            console.log("fetched children data:", data);
            // store cache but DO NOT show until payment method chosen
            childrenCache = Array.isArray(data) ? data : [];
          })
          .catch(err => {
            console.error("fetch error", err);
            childrenCache = [];
          });
      }
      
    });

    // payment method radio change: when chosen -> populate children & setup payment details
    document.querySelectorAll('input[name="paymentMethod"]').forEach(radio => {
      radio.addEventListener('change', function() {
        selectedPaymentMethod = this.value;
         document.getElementById("paymentMethodHidden").value = this.value;
        const contactDiv = document.getElementById("contactNumberDiv");
        console.log("paymentMethod chosen:", selectedPaymentMethod);

        // populate children from cached data
        if (childrenCache.length > 0) {
          populateMiscChildren(childrenCache);
        } else {
          miscChildrenList.innerHTML = '<li class="list-group-item">No children found.</li>';
          paymentDetails.style.display = 'block';
        }

        // render method fields area
        renderMethodFields(selectedPaymentMethod);

        // show paymentDetails (owner fields already inside)
        paymentDetails.style.display = 'block';
        

        if (selectedPaymentMethod === "card" || selectedPaymentMethod === "dob") {
          contactDiv.style.display = "none";        // hide contact field
          document.getElementById('modalNumber').value = ""; // clear old value
        } else {
          contactDiv.style.display = "block";       // show for gcash & paymaya
        }
      });
    });

    // partial input live update
    document.addEventListener('input', function(e){
      if (e.target && e.target.id === 'partialInput') {
        updateTotals();
      }
      // if payamount edited manually, update modal preview partial/total accordingly
      if (e.target && e.target.id === 'payamount') {
        // user changed payment amount manually; reflect in modalTotal or modalPartial as appropriate
        // We'll keep modalTotal showing selected total (children) and payamount is the amount user wants to pay now.
        // Update partial preview if partialInput is empty.
        const payamountVal = Number(e.target.value || 0);
        // no need to change totalAmountMisc; just keep partial/labels updated when opening modal
      }
    });

    // Open modal button click: validate, prepare modal form fields and show
    openModalBtn.addEventListener('click', function(e) {
      e.preventDefault();
      console.log("Open modal clicked");

      // validations: at least one child selected
      const checked = Array.from(miscChildrenList.querySelectorAll('.child-checkbox')).filter(c => c.checked);
      if (checked.length === 0) {
        alert("Please select at least one child to pay for.");
        return;
      }

      // payment method chosen?
      if (!selectedPaymentMethod) {
        alert("Please select a payment method first.");
        return;
      }

      // Basic method-specific validation before modal:
      if (selectedPaymentMethod === 'card') {
        const cardNumber = document.getElementById('cardNumber');
        const expM = document.getElementById('expiryMonth');
        const expY = document.getElementById('expiryYear');
        const cvv = document.getElementById('cvv');
        if (!cardNumber || !expM || !expY || !cvv ||
            !cardNumber.value.trim() || !expM.value || !expY.value || !cvv.value.trim()) {
          alert("Please fill all card details before proceeding.");
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

      // copy selected children to modal as hidden inputs
      modalChildrenContainer.innerHTML = '';
      let total = 0;
      checked.forEach(c => {
        const hid = document.createElement('input');
        hid.type = 'hidden';
        hid.name = 'children[]';
        hid.value = c.value;
        modalChildrenContainer.appendChild(hid);

        total += Number(c.dataset.amount || 0);
      });

      // set plan id (misc = 3)
      modalPlanInput.value = 3;

      // set totals & partial into modal
      modalTotal.textContent = fmt(total);

      const partialVal = Number(document.getElementById('partialInput').value || 0);
      modalPartialLabel.textContent = fmt(partialVal);

      // set modal payment method label
      modalPaymentMethod.textContent = selectedPaymentMethod.toUpperCase();

      // clear previous method hidden inputs
      modalMethodHidden.innerHTML = '';

      // copy method-specific fields into hidden inputs for server submission and set summary detail
      if (selectedPaymentMethod === 'card') {
        const cardNumberVal = (document.getElementById('cardNumber') || {}).value || '';
        const expMVal = (document.getElementById('expiryMonth') || {}).value || '';
        const expYVal = (document.getElementById('expiryYear') || {}).value || '';
        const cvvVal = (document.getElementById('cvv') || {}).value || '';
        const ownerNameVal = (document.getElementById('ownerFullname') || {}).value || '';
        const ownerEmailVal = (document.getElementById('ownerEmail') || {}).value || '';
        const payamountVal = (document.getElementById('payamount') || {}).value || fmtFixed(total);

        // hidden inputs
        modalMethodHidden.appendChild(createHidden('payment_method', 'card'));
        modalMethodHidden.appendChild(createHidden('cardNumber', cardNumberVal));
        modalMethodHidden.appendChild(createHidden('expiryMonth', expMVal));
        modalMethodHidden.appendChild(createHidden('expiryYear', expYVal));
        modalMethodHidden.appendChild(createHidden('cvv', cvvVal));
        modalMethodHidden.appendChild(createHidden('payamount', payamountVal));

        // set modal visible fields (masked card)
        modalMethodDetail.textContent = maskCard(cardNumberVal);
        // set owner fields into modal visible inputs
        modalFullname.value = ownerNameVal;
        modalEmail.value = ownerEmailVal;
        modalNumber.value = ''; // card payments may not need number but keep blank if not provided
      } else if (selectedPaymentMethod === 'dob') {
        const bankVal = (document.getElementById('accountName') || {}).value || '';
        const bankText = (document.getElementById('accountName') || {}).selectedOptions?.[0]?.text || bankVal;
        const ownerNameVal = (document.getElementById('ownerFullname') || {}).value || '';
        const ownerEmailVal = (document.getElementById('ownerEmail') || {}).value || '';
        const payamountVal = (document.getElementById('payamount') || {}).value || fmtFixed(total);

        modalMethodHidden.appendChild(createHidden('payment_method', 'dob'));
        modalMethodHidden.appendChild(createHidden('accountName', bankVal));
        modalMethodHidden.appendChild(createHidden('payamount', payamountVal));

        modalMethodDetail.textContent = bankText;
        modalFullname.value = ownerNameVal;
        modalEmail.value = ownerEmailVal;
        modalNumber.value = ''; // bank transfer number optional
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

    // helper: create hidden input element
    function createHidden(name, value) {
      const el = document.createElement('input');
      el.type = 'hidden';
      el.name = name;
      el.value = value;
      return el;
    }

    // simple mask function for card (keeps last 4 digits)
    function maskCard(card) {
      if (!card) return '—';
      // remove spaces then format masked
      const digits = card.replace(/\D/g, '');
      if (digits.length <= 4) return '**** ' + digits;
      const last4 = digits.slice(-4);
      return '**** **** **** ' + last4;
    }

    // Before modal form submit, you can add client-side validation if wanted
    const finalPaymentForm = document.getElementById('finalPaymentForm');
    finalPaymentForm.addEventListener('submit', function(e) {
      console.log("Final payment form submit triggered");
      // validate modal fields
      if (!modalFullname.value || !modalEmail.value) {
        e.preventDefault();
        alert("Please fill in fullname, number, and email in the modal.");
        return;
      }

      // proceed — the form will submit to /pay-miscellaneous (server side handles)
      document.getElementById('confirmPayBtn').textContent = 'Processing...';
    });

    // Debug: create mock children cache if fetch not available (for dev) -- remove in prod
    if (!childrenCache.length) {
      // Optionally leave commented or remove. Example mock:
      // childrenCache = [
      //   { admission_id: 'A001', full_name: 'Juan Dela Cruz', remaining_balance: 1500.00 },
      //   { admission_id: 'A002', full_name: 'Maria Clara', remaining_balance: 2000.00 }
      // ];
      // populateMiscChildren(childrenCache);
    }

    // updateTotals initial hook in case something changed
    setTimeout(updateTotals, 200);

  }); // DOMContentLoaded end
  document.addEventListener("DOMContentLoaded", function() {
  document.getElementById("paymentType").addEventListener("change", function() {
    let selectedValue = this.value;
    document.getElementById("modal_plan_id").value = selectedValue;
    console.log("Selected Plan ID:", selectedValue);
  });
});

  function getSelectedAdmissionIds() {
  return Array.from(document.querySelectorAll('.child-checkbox:checked'))
              .map(cb => cb.value);
}
const selectedIds = getSelectedAdmissionIds();
console.log("Selected Admission IDs:", selectedIds);
modalChildrenContainer.innerHTML = "";

getSelectedAdmissionIds().forEach(id => {
    const hidden = document.createElement("input");
    hidden.type = "hidden";
    hidden.name = "children[]";
    hidden.value = id;
    modalChildrenContainer.appendChild(hidden);
});

