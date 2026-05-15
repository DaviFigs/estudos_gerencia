<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
  <div class="container-fluid px-3">
    <a class="navbar-brand fw-bold" href="home.php">🧠 OrderMind</a>

    <button class="navbar-toggler" type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation">

      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link" href="home.php">Home</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="dashboard.php">DashBoard</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="disciplinas.php">Disciplinas</a>
        </li>

        <li class="nav-item">
          <a class="nav-link" href="perfil.php">Perfil</a>
        </li>

        <?php if (!empty($_SESSION['logged'])): ?>
          <li class="nav-item">
            <a href="logout.php" class="btn btn-sm btn-danger ms-2">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
