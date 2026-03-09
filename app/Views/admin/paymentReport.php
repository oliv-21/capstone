<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Admin Dashboard Payment Report</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Fonts & CSS -->
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="assets/img/logoicon.png" rel="icon" />

  <style>
    body {
      font-family: 'Inter', sans-serif;
      background-color: #f8f9fa;
    }

    .card {
      border-radius: 16px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
    }

    table th {
      background-color: #007bff;
      color: white;
      text-align: center;
    }

    table td {
      vertical-align: middle;
    }

    @media print {
      .no-print {
        display: none !important;
      }
    }
  </style>
</head>

<body>
  <div class="container mt-5 mb-5">
    <div class="card p-4">
      <div class="d-flex flex-wrap justify-content-between align-items-center mb-3">
        <h4 class="fw-bold text-primary">Payment Report</h4>

        <div class="no-print d-flex flex-wrap gap-2">
          <select id="planFilter" class="form-select form-select-sm">
            <option value="">All Plans</option>
            <option value="2">Registration</option>
            <option value="3">Miscellaneous</option>
            <option value="4">Tuition</option>
          </select>

          <!-- Date Filter -->
          <input type="date" id="fromDate" class="form-control form-control-sm" placeholder="From Date">
          <input type="date" id="toDate" class="form-control form-control-sm" placeholder="To Date">
          <button id="filterDate" class="btn btn-outline-primary btn-sm">Filter</button>

          <button id="exportCSV" class="btn btn-outline-success btn-sm">Export CSV</button>
          <button id="generatePaper" class="btn btn-primary btn-sm">Generate Paper</button>

        </div>
      </div>

      <div class="table-responsive">
        <table id="reportTable" class="table table-bordered table-striped align-middle">
          <thead>
            <tr>
              <th>#</th>
              <th>Student Name</th>
              <th>Guardian Name</th>
              <th>Contact Number</th>
              <th>Email</th>
              <th>Plan Type</th>
              <th>Status</th>
              <th>Amount Paid</th>
              <th>Payment Method</th>
              <th>Payment Date</th>
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
                  <td class="text-center"><?= $i++ ?></td>
                  <td><?= esc($row['student_name']) ?></td>
                  <td><?= esc($row['guardian_name']) ?></td>
                  <td><?= esc($row['contact_number']) ?></td>
                  <td><?= esc($row['email']) ?></td>
                  <td><?= esc($planType) ?></td>
                  <td><?= esc($row['status']) ?></td>
                  <td class="text-end">₱<?= number_format($row['amount_paid'], 2) ?></td>
                  <td><?= esc($row['payment_method']) ?></td>
                  <td><?= esc($row['payment_date']) ?></td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="10" class="text-center text-muted">No payment data available</td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
  <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>
<script>
$(document).ready(function () {
  const table = $('#reportTable').DataTable({
    pageLength: 10,
    order: [[0, 'asc']]
  });

  // Filter by Plan Type
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

  // Export to CSV
  $('#exportCSV').click(function () {
    let csv = [];
    const rows = document.querySelectorAll("#reportTable tr");
    for (let i = 0; i < rows.length; i++) {
      const cols = rows[i].querySelectorAll("td, th");
      const row = [];
      for (let j = 0; j < cols.length; j++) {
        row.push('"' + cols[j].innerText.replace(/"/g, '""') + '"');
      }
      csv.push(row.join(","));
    }

    const csvFile = new Blob([csv.join("\n")], { type: "text/csv" });
    const downloadLink = document.createElement("a");
    downloadLink.download = "payment_report.csv";
    downloadLink.href = window.URL.createObjectURL(csvFile);
    downloadLink.click();
  });

  // ✅ Generate Paper (Filtered Report)
  $('#generatePaper').click(function () {
    const filteredRows = [];
    $('#reportTable tbody tr:visible').each(function () {
      const cols = $(this).find('td');
      if (cols.length > 0) {
        filteredRows.push({
          student_name: cols.eq(1).text(),
          guardian_name: cols.eq(2).text(),
          contact_number: cols.eq(3).text(),
          email: cols.eq(4).text(),
          plan_type: cols.eq(5).text(),
          status: cols.eq(6).text(),
          amount_paid: cols.eq(7).text(),
          payment_method: cols.eq(8).text(),
          payment_date: cols.eq(9).text()
        });
      }
    });

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
    .catch(err => console.error('Error generating report:', err));
  });
});
</script>

  

</body>

</html>
