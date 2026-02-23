<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Student Registration — Print</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
    $isPdf = $isPdf ?? false;
  ?>
  <?php if (!$isPdf): ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php endif; ?>

  <style>
    @page { size: A4; margin: 12mm; }
    body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", sans-serif; font-size: 12px; color:#111; }
    .doc { max-width: 850px; margin: 0 auto; }
    .brand {
      display: flex; align-items: center; justify-content: space-between;
      border-bottom: 2px solid #000; padding-bottom: .5rem; margin-bottom: 1rem;
    }
    .brand-title .name { font-size: 20px; font-weight: 800; color: #c23c8a; letter-spacing: .5px; }
    .brand-title .sub { font-size: 14px; color: #333; margin-top:-2px }
    .no-print { display: block; }
    @media print {
      .no-print { display: none !important; }
      a[href]:after { content: ""; }
    }
  </style>
</head>
<body>
<div class="doc">

  <?php if (!$isPdf): ?>
    <div class="no-print d-flex justify-content-between align-items-center my-3">
      <a href="<?= base_url('admin-payment'); ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
      <button class="btn btn-primary btn-sm" onclick="window.print()">
        <i class="fa-solid fa-print me-1"></i> Print
      </button>
    </div>
  <?php endif; ?>

  <div class="brand">
    <div class="brand-title">
      <div class="name">BRIGHTSIDE GLOBAL</div>
      <div class="sub">LEARNING CENTER</div>
      <div class="mt-2 fw-bold" style="font-size:16px;">Payment Report</div>
    </div>
  </div>

  <table class="table table-bordered">
    <thead>
      <tr>
        <th>#</th>
        <th>Student Name</th>
        <th>Guardian Name</th>
        <th>Type</th>
        
        <th>Method</th>
        <th>Date</th>
        <th>Amount</th>
      </tr>
    </thead>
    <tbody>
      <?php 
        $totalAmount = 0;
        if (!empty($reports)): 
          $i = 1; 
          foreach ($reports as $row): 
            // Clean amount and add to total
            $amount = floatval(str_replace(['₱', ','], '', $row['amount_paid']));
            $totalAmount += $amount;
      ?>
      <tr>
        <td><?= $i++ ?></td>
        <td><?= esc($row['student_name']) ?></td>
        <td><?= esc($row['guardian_name']) ?></td>
       
        <!--  -->
        <td><?= esc($row['plan_type']) ?></td>
       
        
        <td><?= esc($row['payment_method']) ?></td>
        <td><?= esc($row['payment_date']) ?></td>
        <td>₱<?= number_format($amount, 2) ?></td>
      </tr>
      <?php endforeach; ?>
      <!-- ✅ Total Row -->
      <tr class="fw-bold bg-light">
    <td colspan="6" class="text-end">TOTAL</td>
    <td>₱<?= number_format($totalAmount, 2) ?></td>
</tr>
      <?php else: ?>
      <tr><td colspan="10" class="text-center text-muted">No data to print</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
</body>
</html>
