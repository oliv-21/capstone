<!doctype html>
<html>
<head>
    <meta charset="utf-8"/>
    <style>
        body { font-family: DejaVu Sans, Arial, sans-serif; color:#222; font-size:12px; }
        .header { display:flex; align-items:center; gap:12px; margin-bottom:8px; }
        .logo { width:72px; }
        .school { font-weight:700; font-size:16px; }
        .address { font-size:11px; color:#444; }
        .title { text-align:center; margin:8px 0 6px; font-size:14px; font-weight:700; }
        table { width:100%; border-collapse:collapse; margin-top:8px; }
        th, td { border:1px solid #ddd; padding:6px; }
        th { background:#f4f4f4; text-align:left; }
        .right { text-align:right; }
        .center { text-align:center; }
        .total-row td { font-weight:700; }
        .section { margin-top:12px; }
        .print-btn { margin-bottom:12px; padding:6px 12px; font-size:12px; cursor:pointer; }
        @media print { .print-btn { display: none; } }
    </style>
</head>
<body>

    <button class="print-btn" onclick="window.print()">Print Receipt</button>

    <div class="header">
        <div><img src="<?= base_url('assets/img/logoicon.png') ?>" class="logo" alt="logo"></div>
        <div>
            <div class="school">Brightside Learning Center</div>
            <div class="address">Barangay, Bagumbayan, Santa Cruz, Laguna</div>
        </div>
    </div>

    <div class="title">OFFICIAL PAYMENT RECEIPT</div>

    <div style="font-size:12px; margin-bottom:6px;">
        <strong>Parent Name:</strong> <?= esc($payment['guardianfull_name']) ?> &nbsp; | &nbsp;
        <strong>Receipt No:</strong> OR-<?= esc($payment['payment_id']) ?> &nbsp; | &nbsp;
        <strong>Date:</strong> <?= date('F d, Y', strtotime($payment['payment_date'])) ?>
    </div>

    <div class="section">
        <table>
            <thead>
                <tr>
                    <th style="width:4%;">#</th>
                    <th style="width:36%;">Student Name</th>
                    <th style="width:18%;" class="center">Fee Type</th>
                    <th style="width:14%;" class="right">Amount Paid (₱)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $feetype = '';
                    switch ($payment['plan_id'] ?? 0) {
                        case 2: $feetype = 'Registration'; break;
                        case 3: $feetype = 'Miscellaneous'; break;
                        case 4: $feetype = 'Tuition'; break;
                        default: $feetype = 'Other'; break;
                    }
                ?>
                <tr>
                    <td class="center">1</td>
                    <td><?= esc($payment['full_name']) ?></td>
                    <td class="center"><?= $feetype ?></td>
                    <td class="right"><?= number_format($payment['amount_paid'], 2) ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <td colspan="3" class="right">TOTAL</td>
                    <td class="right"><?= number_format($payment['amount_paid'], 2) ?></td>
                </tr>
            </tfoot>
        </table>
    </div>

    <?php
$feetype = '';
switch ($payment['plan_id'] ?? 0) {
    case 2: $feetype = 'Registration'; break;
    case 3: $feetype = 'Miscellaneous'; break;
    case 4: $feetype = 'Tuition'; break;
    default: $feetype = 'Other'; break;
}
?>

<div class="section">
    <?php if ($payment['plan_id'] == 2): ?>
        <h4 style="margin:8px 0 6px;">Registration Fee Breakdown</h4>
        <ul style="margin:0; padding-left:18px; line-height:1.4;">
            <li>Registration Fee: ₱<?= number_format($payment['amount_paid'], 2) ?></li>
        </ul>

    <?php elseif ($payment['plan_id'] == 3): ?>
        <h4 style="margin:8px 0 6px;">Miscellaneous Fee Breakdown</h4>
        <ul>
            <li>Communication Notebook: Included</li>
            <li>Writing Notebook: Included</li>
            <li>Academic Notebook: Included</li>
            <li>Arts & Crafts Project Materials: Included</li>
            <li>Sensory Materials: Included</li>
            <li>Energy Fee: Included</li>
            <li>Health & Sanitation Fee: Included</li>
            <li>Operational Fee: Included</li>
        </ul>

    <?php elseif ($payment['plan_id'] == 4): ?>
        <h4 style="margin:8px 0 6px;">Tuition Fee Breakdown</h4>
        <?php if ($payment['amount_paid'] == 23000): ?>
            <ul>
                <li>School Modules: Included</li>
                <li>Learning Materials: Included</li>
                <li>Instructional Tools & Supplies: Included</li>
                <li>Montessori Apparatus: Included</li>
            </ul>
            <p><strong>Total Paid:</strong> ₱<?= number_format($payment['amount_paid'], 2) ?></p>
        <?php else: ?>
            <ul>
                <li>Monthly Tuition Fee (₱2,500 × 10 months): ₱25,000</li>
                <li>School Modules: Included</li>
                <li>Learning Materials: Included</li>
                <li>Instructional Tools & Supplies: Included</li>
                <li>Montessori Apparatus: Included</li>

                
            </ul>
            <p><strong>Total Annual Tuition (Monthly Option):</strong> ₱2,500 per month</p>
        <?php endif; ?>
    <?php endif; ?>
</div>


    <div style="margin-top:12px;">
        <p>Thank you for your payment.</p>
    </div>

</body>
</html>
