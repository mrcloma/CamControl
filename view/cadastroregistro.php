<?php
session_start();

// Verifica se o usuário está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Cadastro de Câmeras</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="../assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="../assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="../assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="../assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="status.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">Cam control</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div><!-- End Logo -->

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="#">
            <i class="bi bi-search"></i>
          </a>
        </li><!-- End Search Icon-->

        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
            <span class="d-none d-md-block dropdown-toggle ps-2"><?php echo $_SESSION['username']; ?></span>
          </a><!-- End Profile Iamge Icon -->

          <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow profile">
            <li class="dropdown-header">
              <h6><?php echo $_SESSION['username']; ?></h6>
            </li>
            <li>
              <hr class="dropdown-divider">
            </li>
            <li>
              <a class="dropdown-item d-flex align-items-center" href="../controller/logout.php">
                <i class="bi bi-box-arrow-right"></i>
                <span>Sair</span>
              </a>
            </li>

          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  <!-- ======= Sidebar ======= -->
  <aside id="sidebar" class="sidebar">

    <ul class="sidebar-nav" id="sidebar-nav">

      <li class="nav-item">
        <a class="nav-link collapsed" href="status.php">
          <i class="bi bi-grid"></i>
          <span>Status</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="registros.php">
          <i class="bi bi-grid"></i>
          <span>Registros</span>
        </a>
      </li><!-- End Dashboard Nav -->
      <li class="nav-item">
        <a class="nav-link collapsed" href="relatorioresumido.php">
          <i class="bi bi-grid"></i>
          <span>Relatorio Resumido</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="camera.php">
          <i class="bi bi-grid"></i>
          <span>Cadastro de Câmeras</span>
        </a>
      </li>
    </ul>

  </aside><!-- End Sidebar-->

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>Formulário de cadastro de evento por alteração de status</h1>
    </div><!-- End Page Title -->
  <section class="section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Cadastro de Evento</h5>

	      <!-- Vertical Form -->
		<form method="post" action="../controller/ControllerCadastroEvento.php" id="form" name="form" class="row g-3 col-md-10 mx-auto">
                    <div class="col-12">
                        <label for="evento" class="form-label">Evento</label>
                        <input class="form-control" type="text" id="evento" name="evento" required autofocus>
                    </div>
                    <div class="col-12">
                        <input type="hidden" id="camera_id" name="camera_id" value="<?php echo htmlspecialchars($_GET['id']); ?>">
                    </div>
                    <div class="col-12">
                        <label for="it2m" class="form-label">Número IT2M</label>
                        <input class="form-control" type="number" id="it2m" name="it2m">
                    </div>
                    <div class="col-12">
                        <label for="fman" class="form-label">FMAN</label>
                        <input class="form-control" type="text" id="fman" name="fman" required autofocus>
                    </div>
                    <div class="col-12">
                        <label for="vmanut" class="form-label">VMANUT</label>
                        <input class="form-control" type="text" id="vmanut" name="vmanut" required autofocus>
                    </div>
                    <div class="col-12">
                        <label for="data_abertura" class="form-label">Data de Abertura</label>
                        <input class="form-control" type="date" id="data_abertura" name="data_abertura" required>
                    </div>
                    <div class="col-12">
                        <label for="data_fechamento" class="form-label">Data de Fechamento</label>
                        <input class="form-control" type="date" id="data_fechamento" name="data_fechamento" required>
                    </div>
                    <div class="col-12">
                        <label for="responsavel" class="form-label">Responsável</label>
                        <select class="form-control" id="responsavel" name="responsavel" required>
                            <option value="" disabled selected>Selecione uma opção</option>
                            <option value="procempa">Procempa</option>
                            <option value="radiante">Radiante</option>
                            <option value="icp">ICP</option>
                            <option value="resolvido">Resolvido</option>
                        </select>
                    </div>
         	    <div class="col-12">
		        <label for="problema" class="form-label">Problema</label>
		        <textarea class="form-control" id="problema" name="problema" rows="4" required></textarea>
		    </div>
                    <div class="col-12">
                        <label for="acao" class="form-label">Ação</label>
                        <textarea class="form-control" id="acao" name="acao" rows="4" required></textarea>
                    </div>
		    <div class="col-12 text-center">
		        <button type="submit" class="btn btn-success">Cadastrar</button>
		    </div>
		</form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  </main><!-- End #main -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="../assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="../assets/vendor/chart.js/chart.umd.js"></script>
  <script src="../assets/vendor/echarts/echarts.min.js"></script>
  <script src="../assets/vendor/quill/quill.min.js"></script>
  <script src="../assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="../assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="../assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="../assets/js/main.js"></script>

</body>
</html>
