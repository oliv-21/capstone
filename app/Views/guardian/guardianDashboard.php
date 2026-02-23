<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <title>Brightside Guardian Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1" />

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css2?family=Handlee&family=Nunito:wght@300;400;600;700&display=swap" rel="stylesheet" />

  <!-- Font Awesome -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet" />
  <!-- Bootstrap CSS -->
  <link rel="stylesheet" href="dist/css/bootstrap.min.css">
	<!-- Custom CSS -->
  <link rel="stylesheet" href="<?= base_url('assets/css/user.css') ?>">
  <style>
    .welcome-box {
      background: #fff;
      border-radius: 16px;
      box-shadow: 0 3px 8px rgba(0, 0, 0, 0.08);
      padding: 30px;
      max-width: 700px;
      margin: 40px auto;
    }

    .welcome-box h4 {
      font-weight: 700;
    }

    .btn {
      border-radius: 30px;
      padding: 10px 20px;
    }

    .alert {
      border-radius: 12px;
      font-size: 0.95rem;
    }
    .child-card {
      background: #fff;
      border: 1px solid #e0e7ff;
      border-radius: 16px;
      box-shadow: 0 3px 6px rgba(0, 0, 0, 0.05);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .child-card:hover {
      transform: translateY(-3px);
      box-shadow: 0 5px 12px rgba(0, 0, 0, 0.1);
    }

    .child-card img {
      border: 3px solid #ff6b6b;
    }

    .child-card h6 {
      font-weight: 700;
    }

    .badge {
      padding: 0.5em 1em;
      border-radius: 20px;
    }

    @media (max-width: 768px) {
      .welcome-box {
        margin: 20px;
        padding: 20px;
      }
    }
  </style>
</head>

<body>
  	<?php $isProfileIncomplete = empty($guardian->profile_pic); ?>

	<nav class="navbar navbar-expand-lg bg-white border-bottom py-3">
		<div class="container">
		<a class="navbar-brand d-flex align-items-center" href="#">
			<img src="assets/img/logoicon.png" alt="Logo" style="width: 40px;" class="me-2">
			<span class="text-primary fw-bold">Brightside</span>
		</a>

		<div class="dropdown ms-auto">
			<a href="#" class="d-flex align-items-center text-dark text-decoration-none dropdown-toggle"
			id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false">
			<img src="<?= base_url('public/assets/profilepic/' . esc($guardian->profile_pic)) ?>" alt="Profile Picture"
				class="rounded-circle border border-2" width="35" height="35">
			<span class="fw-semibold ms-2"><?= esc($guardian->full_name) ?></span>
			</a>
			<ul class="dropdown-menu dropdown-menu-end shadow-sm" aria-labelledby="profileDropdown">
			<li><a class="dropdown-item" href="<?= base_url('guardian-profile'); ?>"><i class='fa-solid fa-user me-2 text-primary'></i>Profile</a></li>
			<li><a class="dropdown-item" href="<?= base_url('guardian-resetPassword'); ?>"><i class='fa-solid fa-key me-2 text-primary'></i>Reset Password</a></li>
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
	</nav>

	<main class="main-content">
		<div class="welcome-box text-center">
      <h4 class="text-primary">Welcome, <?= esc($guardian->full_name) ?>!</h4>

      <?php if (empty($isProfileIncomplete)): ?>
        <div class="alert alert-warning mt-3">
        ⚠️ Your profile is incomplete. Please complete it to avoid issues during admission.
        </div>
      <?php endif; ?>

      <?php if (empty($student)): ?>
        <a href="<?= base_url('/guardian-admission'); ?>" class="btn btn-success mt-3">
        Proceed to Admission
        </a>
      <?php endif; ?>

      <?php if ($isProfileIncomplete != 'default.webp'): ?>
        <a href="<?= base_url('guardian/edit-profile/1'); ?>" class="btn btn-primary mt-3">
        Complete Profile
        </a>
      <?php endif; ?>

      <?php if ($allEnrolled == true): ?>
        <div class="alert alert-warning mt-4">
        ⚠️ <strong>Note:</strong> Once activated, you can no longer access the enrollment process.
        </div>
        <a href="<?= base_url('guardian/edit-profile/1'); ?>" class="btn btn-primary mt-3">
        Activate Account
        </a>
      <?php endif; ?>
		</div>

		<?php if (!empty($student)): ?>
		<div class="children-section text-center">
			<h5 class="text-primary fw-bold mb-4">Your Children</h5>
			<div class="row justify-content-center">
			<?php foreach ($student as $child): ?>
				<div class="col-md-4 col-sm-6 mb-4">
				<div class="child-card p-4 text-center">
					<img src="<?= base_url('public/assets/profilepic/' . (!empty($child->picture) ? esc($child->picture) : 'default.webp')) ?>"
					class="rounded-circle mb-3" width="90" height="90" alt="Child Profile">
					<h6 class="mb-1"><?= esc($child->full_name) ?></h6>
					<?php
					$statusColors = [
					'Pending' => 'bg-primary',
					'Approved' => 'bg-success',
					'Disapproved' => 'bg-danger',
					'Enrolled' => 'bg-success',
					'Pre-enrollee' => 'bg-success',
					'Interview Failed' => 'bg-danger',
					];
					$status = $child->status ?? 'Pending';
					$badgeClass = $statusColors[$status] ?? 'bg-secondary';
					?>
					<span class="badge <?= $badgeClass ?>"><?= esc($status) ?></span>
					<div class="mt-3">
					<?php if (($child->status ?? 'Pending') === 'Enrolled'): ?>
						<a href="<?= base_url('/StudentviewDashboard/' . $child->admission_id) ?>" class="btn btn-primary btn-sm">View Dashboard</a>
					<?php endif; ?>
					<a href="<?= base_url('/Studentview/' . $child->admission_id) ?>" class="btn btn-outline-primary btn-sm ms-1">View</a>
					</div>
				</div>
				</div>
			<?php endforeach; ?>
			</div>
			<a href="<?= base_url('/guardian-admission'); ?>" class="btn btn-outline-success mt-3">
			Add Another Child
			</a>
		</div>
		<?php endif; ?>
	</main>

  	<script src="dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
