<?php include '../bootstrap.php'; ?>
<?php include '../partials/header.php'; ?>

<div class="container py-4">
  <h1>Log</h1>
  <select class="form-select mb-3" id="log-type">
    <option value="all">All</option>
    <option value="withdraw">Withdrawals</option>
    <option value="restock">Restocks</option>
  </select>

  <div id="log-container">
    <!-- Logs populated via JS -->
  </div>
</div>

<?php include '../partials/footer.php'; ?>
