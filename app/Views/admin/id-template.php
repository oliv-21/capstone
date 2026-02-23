<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Student ID</title>

  <!-- Bootstrap & Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">
  <style>
    /* Custom for print */
    @media print {
      * {
        -webkit-print-color-adjust: exact !important;
        print-color-adjust: exact !important;
        color-adjust: exact !important;
      }
      body {
        background: none;
        margin: 0;
      }
      .no-print {
        display: none;
      }
      @page {
        size: A4 portrait;
        margin: 12mm;
      }
    }

    /* ID Card Base */
    .id-card {
      width: 300px;
      height: 450px;
      border: 2px solid #d3d3d3;
      border-radius: 15px;
      overflow: hidden;
      background: #fff;
      box-shadow: 0 4px 10px rgba(0,0,0,0.1);
    }

    /* Header */
    .id-header {
      background: linear-gradient(135deg, #ff6b6b, #ff8787);
      color: #fff;
      text-align: center;
      padding: 8px;
      border-bottom: 2px solid #e74c3c;
    }
    .id-header h4 {
      margin: 0;
      font-size: 16px;
      font-weight: 700;
    }

    .id-front-header {
      background: linear-gradient(135deg, #ff6b6b, #ff8787);
      color: #fff;
      text-align: center;
      padding: 8px;
      border-bottom: 2px solid #e74c3c;
    }
    .id-front-header h4 {
      margin: 0;
      font-size: 16px;
      font-weight: 700;
    }

    /* Profile Picture */
    .profile {
      width: 118px;
      height: 118px;
      border: 2px solid #ff6b6b;
      border-radius: 3px;
      object-fit: cover;
      padding:4px;
    }

    /* QR Code */
    .qr-box {
      width: 110px;
      height: 110px;
      border: 2px dashed #aaa;
      border-radius: 8px;
      padding: 4px;
      background: #fafafa;
    }
    .qr-box img {
      width: 100%;
      height: 100%;
      object-fit: contain;
    }

    /* Signature line */
    .signature {
      border-top: 1px solid #aaa;
      font-size: 12px;
      margin-top: 15px;
      padding-top: 5px;
      text-align: center;
      color: #333;
    }

    /* Footer */
    .id-footer {
      font-size: 11px;
      color: #777;
      text-align: center;
      margin-top: 10px;
    }

    .address, .gname, .contact{
      font-size: 0.9rem;
    }
    .school-logo{
      width: 30px;
      margin-right: 6px;
    }
  </style>
</head>
<body class="bg-light">

  <div class="container py-4">
    <!-- Top Controls -->
    <div class="d-flex justify-content-between align-item-center no-print mb-3">
      <a href="<?= base_url('admin-enrolled'); ?>" class="btn btn-sm btn-outline-secondary no-print">← Back</a>
      <button class="btn btn-primary no-print btn-sm" onclick="window.print()">
        <i class="fa-solid fa-print me-2"></i>Print
      </button>
    </div>

    <!-- Grid -->
    <div class="row justify-content-center g-4">

      <!-- FRONT -->
      <div class="col-auto">
        <div class="card id-card shadow d-flex flex-column justify-content-between">
          <div class="id-front-header text-center">
            <h4><img src="../../assets/img/logoicon.png" alt="school logo" class='school-logo'>Brightside Global Learning Center</h4>
          </div>
          <div class="text-center mb-3">
            <img src="<?= base_url('public/assets/profilepic/' . esc($student->picture ?? 'default.webp')) ?>"
                 alt="Profile Picture"
                 class="profile my-4">
            <h5 class="fw-semibold fs-5 mb-0"><?= esc($student->full_name) ?></h5>
            <hr class="p-2 mx-4 my-1 text-primary">
            <div class="qr-box mx-auto mb-2">
              <img src="<?= base_url('public/assets/qrstudentId/' . esc($student->qr_code ?? '')) ?>"
                   alt="QR Code">
            </div>
            <p class="mb-2"><strong>Class:</strong> <?= esc($student->class_applied) ?></p>
          </div>
        </div>
      </div>

      <!-- BACK -->
      <div class="col-auto">
        <div class="card id-card shadow d-flex flex-column justify-content-between">
          <div class="id-header">
            <h4>Guardian Information</h4>
          </div> 
          <div class="text-center">
            <!-- Name -->
            <p class="fw-semibold gname mb-0"><?= esc($student->mother_name) ?></p>
            <hr class="p-0 mx-4 my-1 text-primary">
            <p class="text-muted small mb-3">Guardian Name</p>

            <!-- Contact -->
            <p class="fw-semibold contact mb-0"><?= esc($student->contact_number) ?></p>
            <hr class="p-0 mx-5 my-1 text-primary">
            <p class="text-muted small mb-3">Contact</p>

            <!-- Address -->
            <p class="fw-semibold mb-0 address"><?= esc($student->address) ?></p>
            <hr class="p-0 mx-4 my-1 text-primary">
            <p class="text-muted small">Address</p>
          </div>
          <div class="p-3 text-center">

            <div style="height:20px;"></div>
            <div class="signature">Admin Signature</div>
            <div class="id-footer">
              If found, please return to Brightside Global Learning Center.
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
