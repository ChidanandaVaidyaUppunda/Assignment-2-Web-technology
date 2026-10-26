<?php
function e($value) { return htmlspecialchars((string)$value, ENT_QUOTES, 'UTF-8'); }
$submitted = ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_application']));
$errors = [];
$data = [
  'full_name' => trim($_POST['full_name'] ?? ''),
  'email' => trim($_POST['email'] ?? ''),
  'phone' => trim($_POST['phone'] ?? ''),
  'dob' => trim($_POST['dob'] ?? ''),
  'gender' => trim($_POST['gender'] ?? ''),
  'course' => trim($_POST['course'] ?? ''),
  'qualification' => trim($_POST['qualification'] ?? ''),
  'address' => trim($_POST['address'] ?? ''),
  'comments' => trim($_POST['comments'] ?? '')
];
if ($submitted) {
  if ($data['full_name'] === '') $errors[] = 'Please enter your full name.';
  if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Please enter a valid email address.';
  if (!preg_match('/^[0-9+()\-\s]{7,20}$/', $data['phone'])) $errors[] = 'Please enter a valid phone number.';
  if ($data['dob'] === '') $errors[] = 'Please select your date of birth.';
  if (!in_array($data['gender'], ['Female','Male','Prefer not to say'], true)) $errors[] = 'Please select a gender option.';
  if (!in_array($data['course'], ['Computer Science','Information Science','Electronics','Business Administration','Other'], true)) $errors[] = 'Please select a course.';
  if ($data['qualification'] === '') $errors[] = 'Please enter your highest qualification.';
  if ($data['address'] === '') $errors[] = 'Please enter your address.';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Application Registration</title>
  <link rel="stylesheet" href="style.css">
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>
<body>
<header class="site-header"><div class="brand-mark">OA</div><div><p class="eyebrow">ONLINE PORTAL</p><h1>Application & Registration</h1></div></header>
<main class="container">
<?php if ($submitted && !$errors): ?>
  <section class="result-card" aria-live="polite">
    <div class="success-icon">✓</div><p class="eyebrow">SUBMISSION COMPLETE</p>
    <h2>Application submitted successfully!</h2>
    <p class="muted">Thank you, <?= e($data['full_name']) ?>. Review the information you submitted below.</p>
    <div class="reference">Application reference <strong>APP-<?= date('Ymd') ?>-<?= strtoupper(substr(hash('sha256', $data['email'] . $data['full_name']), 0, 6)) ?></strong></div>
    <h3>Applicant details</h3>
    <div class="details-grid">
      <div class="detail"><span>Full name</span><strong><?= e($data['full_name']) ?></strong></div>
      <div class="detail"><span>Email address</span><strong><?= e($data['email']) ?></strong></div>
      <div class="detail"><span>Phone number</span><strong><?= e($data['phone']) ?></strong></div>
      <div class="detail"><span>Date of birth</span><strong><?= e($data['dob']) ?></strong></div>
      <div class="detail"><span>Gender</span><strong><?= e($data['gender']) ?></strong></div>
      <div class="detail"><span>Course applied for</span><strong><?= e($data['course']) ?></strong></div>
      <div class="detail"><span>Highest qualification</span><strong><?= e($data['qualification']) ?></strong></div>
      <div class="detail full"><span>Address</span><strong><?= nl2br(e($data['address'])) ?></strong></div>
      <?php if ($data['comments'] !== ''): ?><div class="detail full"><span>Additional information</span><strong><?= nl2br(e($data['comments'])) ?></strong></div><?php endif; ?>
    </div>
    <div class="actions"><button class="primary-btn" onclick="window.print()" type="button">Print application</button><a class="secondary-btn" href="index.php">Submit another response</a></div>
    <p class="notice">Demo note: this sample displays the submitted details but does not store them in a database or email them.</p>
  </section>
<?php else: ?>
  <section class="intro"><div><p class="eyebrow">WELCOME</p><h2>Start your application</h2><p class="muted">Complete the form below. Fields marked with * are required.</p></div><div class="step-pill"><span>01</span> Applicant details</div></section>
  <?php if ($submitted && $errors): ?><div class="error-box"><strong>Please correct the following:</strong><ul><?php foreach ($errors as $error): ?><li><?= e($error) ?></li><?php endforeach; ?></ul></div><?php endif; ?>
  <form id="applicationForm" method="post" action="index.php" novalidate>
    <div class="form-section"><h3>Personal information</h3><div class="form-grid">
      <div class="field"><label for="full_name">Full name *</label><input id="full_name" name="full_name" type="text" placeholder="Enter your full name" value="<?= e($data['full_name']) ?>" required></div>
      <div class="field"><label for="email">Email address *</label><input id="email" name="email" type="email" placeholder="you@example.com" value="<?= e($data['email']) ?>" required></div>
      <div class="field"><label for="phone">Phone number *</label><input id="phone" name="phone" type="tel" placeholder="e.g. +91 9876543210" value="<?= e($data['phone']) ?>" required></div>
      <div class="field"><label for="dob">Date of birth *</label><input id="dob" name="dob" type="date" value="<?= e($data['dob']) ?>" required></div>
      <div class="field"><label for="gender">Gender *</label><select id="gender" name="gender" required><option value="">Select an option</option><?php foreach (['Female','Male','Prefer not to say'] as $option): ?><option value="<?= e($option) ?>" <?= $data['gender']===$option?'selected':'' ?>><?= e($option) ?></option><?php endforeach; ?></select></div>
      <div class="field"><label for="qualification">Highest qualification *</label><input id="qualification" name="qualification" type="text" placeholder="e.g. PUC / 12th standard" value="<?= e($data['qualification']) ?>" required></div>
    </div></div>
    <div class="form-section"><h3>Application details</h3><div class="form-grid">
      <div class="field"><label for="course">Course / programme *</label><select id="course" name="course" required><option value="">Choose a programme</option><?php foreach (['Computer Science','Information Science','Electronics','Business Administration','Other'] as $option): ?><option value="<?= e($option) ?>" <?= $data['course']===$option?'selected':'' ?>><?= e($option) ?></option><?php endforeach; ?></select></div>
      <div class="field"><label for="address">Residential address *</label><textarea id="address" name="address" rows="3" placeholder="House number, street, city, PIN code" required><?= e($data['address']) ?></textarea></div>
      <div class="field full"><label for="comments">Additional information <span class="optional">(optional)</span></label><textarea id="comments" name="comments" rows="3" placeholder="Any additional information you would like to share"><?= e($data['comments']) ?></textarea></div>
    </div></div>
    <label class="consent"><input type="checkbox" id="confirm" required><span>I confirm that the information provided is accurate. *</span></label>
    <div id="clientMessage" class="client-message" role="alert"></div>
    <div class="form-footer"><p><span class="required-star">*</span> Required fields</p><button class="primary-btn" type="submit" name="submit_application" value="1">Submit application <span aria-hidden="true">→</span></button></div>
  </form>
<?php endif; ?>
</main>
<footer>Online Application Portal <span>•</span> Student registration demo</footer>
<script src="script.js"></script>
</body></html>
