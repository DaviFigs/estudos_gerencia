<?php
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}
?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">OrderMind 🧠</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="home.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="disciplinas.php">Disciplinas</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="perfil.php">Perfil</a>
        </li>
        <?php if (!empty($_SESSION['logged'])): ?>
          <li class="nav-item">
            <a href="logout.php" class="btn btn-danger">Logout</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>