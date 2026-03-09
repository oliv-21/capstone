<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <title>Student Registration — Print</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <?php
    // If we render for PDF, we usually avoid remote CDNs.
    // We'll include Bootstrap only when viewed in browser.
    $isPdf = $isPdf ?? false;
  ?>
  <?php if (!$isPdf): ?>
    <!-- Bootstrap 5 (for on-screen viewing/printing from browser) -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <?php endif; ?>

  <style>
    @page { size: A4; margin: 12mm; }
    body { font-family: system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial, "Noto Sans", "Apple Color Emoji", "Segoe UI Emoji", sans-serif; font-size: 12px; color:#111; }
    .doc {
      max-width: 850px;
      margin: 0 auto;
    }
    .brand {
      display: flex; align-items: center; justify-content: space-between;
      border-bottom: 2px solid #000; padding-bottom: .5rem; margin-bottom: 1rem;
    }
    .brand-title { line-height: 1.1 }
    .brand-title .name { font-size: 20px; font-weight: 800; color: #c23c8a; letter-spacing: .5px; }
    .brand-title .sub { font-size: 14px; color: #333; margin-top:-2px }
    .photo-box {
      width: 110px; height: 110px; border: 1px solid #000; display:flex; align-items:center; justify-content:center;
      text-align:center; font-size: 11px;
    }
    .section {
      border: 1px solid #000; border-radius: 6px; padding: 10px 12px; margin-bottom: 10px;
    }
    .section-title {
      font-weight: 700; margin-bottom: 6px; font-size: 13px; letter-spacing: .2px;
    }
    .row-line { border-top: 1px dashed #bbb; margin: 6px 0; }
    .label { font-weight: 600; min-width: 140px; }
    .value { word-break: break-word; }
    .small-note { font-size: 11px; color: #555; }
    .no-print { display: block; }
    @media print {
      .no-print { display: none !important; }
      a[href]:after { content: ""; } /* cleaner links in print */
    }
  </style>
</head>
<body>
<div class="doc">
  <!-- Top controls (hidden in print/PDF) -->
  <?php if (!$isPdf): ?>
    <div class="no-print d-flex justify-content-between align-items-center my-3">
      <a href="<?= base_url('admin-admission'); ?>" class="btn btn-outline-secondary btn-sm">← Back</a>
      <div class="d-flex gap-2">
        <button class="btn btn-primary btn-sm" onclick="window.print()">
          <i class="fa-solid fa-print me-1"></i> Print
        </button>
      </div>
    </div>
  <?php endif; ?>

  <!-- Header -->
  <div class="brand">
    <div class="brand-title">   
      <div class="name">
        <div class="d-flex justify-content-center align-items-center"> 
          <div><img src="../../assets/img/logoicon.png" alt="" style="width:80px;" class="me-3"></div>
          <div>
            <div  >
              <div>BRIGHTSIDE GLOBAL</div> 
              <div class="sub">LEARNING CENTER</div> 
            </div> 
          </div> 
        </div>    
      </div>
      <div class="mb-5"></div>
      <div class="mt-2 fw-bold" style="font-size:16px;">Student Registration</div>
    </div>

    <div class="text-end">
      <img src="<?= base_url('public/assets/profilepic/' . esc($student->picture ?? 'default.webp')) ?>" 
               alt="Profile Picture" class="photo-box my-3">
      <div class="mt-2 small-note">
        <div class="fw-semibold">DATE OF REGISTRATION</div>
        <div><?= esc($student->submitted_at ?? '') ?></div>
      </div>
    </div>
  </div>

  <!-- PERSONAL INFORMATION -->
  <div class="section">
    <div class="section-title">PERSONAL INFORMATION</div>

    <div class="d-flex"><div class="label">Full Name:</div><div class="value flex-grow-1"><?= esc($student->full_name ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Nickname:</div><div class="value flex-grow-1"><?= esc($student->nickname ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Date of Birth:</div><div class="value flex-grow-1"><?= esc($student->birthday ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Age:</div><div class="value flex-grow-1"><?= esc($student->age ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Gender:</div><div class="value flex-grow-1"><?= esc($student->gender ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Nationality:</div><div class="value flex-grow-1"><?= esc($student->nationality ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Class Applied:</div><div class="value flex-grow-1"><?= esc($student->class_applied ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Address:</div><div class="value flex-grow-1"><?= esc($student->address ?? '') ?></div></div>
  </div>

  <!-- PARENT INFORMATION -->
  <div class="section">
    <div class="section-title">PARENT INFORMATION</div>

    <div class="d-flex"><div class="label">Father's Name:</div><div class="value flex-grow-1"><?= esc($student->father_name ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Father's Occupation:</div><div class="value flex-grow-1"><?= esc($student->father_occupation ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Mother's Name:</div><div class="value flex-grow-1"><?= esc($student->mother_name ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Mother's Occupation:</div><div class="value flex-grow-1"><?= esc($student->mother_occupation ?? '') ?></div></div>
  </div>

  <!-- CONTACT INFORMATION -->
  <div class="section">
    <div class="section-title">CONTACT INFORMATION</div>

    <div class="d-flex"><div class="label">Contact Number:</div><div class="value flex-grow-1"><?= esc($student->contact_number ?? '') ?></div></div>
    <div class="row-line"></div>

    <div class="d-flex"><div class="label">Email:</div><div class="value flex-grow-1"><?= esc($student->email ?? '') ?></div></div>
  </div>

  <div class="small-note text-center mt-3">This is a system-generated printout.</div>
</div>
</body>
</html>
