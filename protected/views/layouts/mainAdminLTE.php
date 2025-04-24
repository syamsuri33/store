<?php
if (!empty(Yii::app()->user->role)) {
  $role = Yii::app()->user->role;
} else {
  $role = '';
}
?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <link rel="shortcut icon" href="<?php echo Yii::app()->request->baseUrl; ?>/images/system/logo.png">

  <!-- blueprint CSS framework -->
  <!--<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/screen.css" media="screen, projection">
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/print.css" media="print">
	--><!--[if lt IE 8]>
	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" media="screen, projection">
	<![endif]-->

  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/main.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/form.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/important.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/edited.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/mediascreen.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/jquery.datepick.css">
  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/khusus.css">

  <!--bootstrap
	<?php
  Yii::app()->bootstrap->register();
  // Yii::app()->clientScript->scriptMap['bootstrap.css'] = false; 
  Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
  Yii::app()->clientScript->scriptMap['bootstrap-responsive.css'] = false;
  Yii::app()->clientScript->scriptMap['yiistrap.css'] = false;
  ?> 



	<!--adminLTE-->
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css">
  <!-- Ionicons -->
  <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
  <!-- Tempusdominus Bootstrap 4 -->
  <link rel="stylesheet" href="plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css">
  <!-- iCheck -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css">
  <!-- JQVMap -->
  <link rel="stylesheet" href="plugins/jqvmap/jqvmap.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css">
  <!-- overlayScrollbars -->
  <link rel="stylesheet" href="plugins/overlayScrollbars/css/OverlayScrollbars.min.css">
  <!-- Daterange picker -->
  <link rel="stylesheet" href="plugins/daterangepicker/daterangepicker.css">
  <!-- summernote -->
  <link rel="stylesheet" href="plugins/summernote/summernote-bs4.min.css">

  <!-- toastr -->
  <script src="//code.jquery.com/jquery-3.6.0.min.js"></script>
  <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/toastr.min.css">
  <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/toastr.min.js"></script>


  <title><?php echo CHtml::encode($this->pageTitle); ?></title>
</head>

<body class="hold-transition sidebar-mini layout-fixed">

  <?php
  $pagePembelian = isset($_GET['pagePembelian']) ? $_GET['pagePembelian'] : '';
  $pagePenjualan = isset($_GET['pagePenjualan']) ? $_GET['pagePenjualan'] : '';
  $pageOperasional = isset($_GET['pageOperasional']) ? $_GET['pageOperasional'] : '';
  ?>

  <?php
  if (
    Yii::app()->controller->id == 'customer' ||
    Yii::app()->controller->id == 'masterbarang' ||
    Yii::app()->controller->id == 'kategori' ||
    Yii::app()->controller->id == 'vendor' ||
    Yii::app()->controller->id == 'satuan'
  ) {
    $menuMasterli = "menu-open";
    $menuMasteraHref = "active";
  } else {
    $menuMasterli = "";
    $menuMasteraHref = "";
  }
  ?>

  <?php
  //   if (isset(Yii::app()->controller->getActionParams()['pageOperasional'])) {
  //     $pageOperasional = Yii::app()->controller->getActionParams()['pageOperasional'];
  // }

  if (
    $pagePembelian == 'report' ||
    $pagePenjualan == 'report' ||
    $pageOperasional == 'report'

  ) {
    $menuReportli = "menu-open";
    $menuReportAHref = "active";
  } else {
    $menuReportli = "";
    $menuReportAHref = "";
  }
  ?>



  <div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
      <!-- Left navbar links -->
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
          <a href="index3.html" class="nav-link">Home</a>
        </li>
      </ul>

      <!-- Right navbar links -->
      <!-- <ul class="navbar-nav ml-auto">
      // Notifications Dropdown Menu
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
          <i class="far fa-bell"></i>
          <span class="badge badge-warning navbar-badge">15</span>
        </a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <span class="dropdown-item dropdown-header">15 Notifications</span>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-envelope mr-2"></i> 4 new messages
            <span class="float-right text-muted text-sm">3 mins</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-users mr-2"></i> 8 friend requests
            <span class="float-right text-muted text-sm">12 hours</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item">
            <i class="fas fa-file mr-2"></i> 3 new reports
            <span class="float-right text-muted text-sm">2 days</span>
          </a>
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
        </div>
      </li>
    </ul> -->
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
      <!-- Brand Logo -->
      <a href="index3.html" class="brand-link">
        <img src="dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Store</span>
      </a>

      <!-- Sidebar -->
      <div class="sidebar mb-3">

        <!-- Sidebar Menu -->
        <nav class="mt-2">
          <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
            <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
            <li class="nav-item">
              <a href="<?php echo Yii::app()->createUrl('site/index'); ?>" class="nav-link <?php echo (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Dashboard
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo Yii::app()->createUrl('pembelian/index', array('pagePembelian' => 'pembelian')); ?>" class="nav-link <?php echo (Yii::app()->controller->id == 'pembelian' && $pagePembelian != 'report') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-shopping-cart"></i>
                <p>
                  Pengadaan
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo Yii::app()->createUrl('penjualan/index', array('pagePenjualan' => 'penjualan')); ?>" class="nav-link <?php echo (Yii::app()->controller->id == 'penjualan' && $pagePenjualan != 'report') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-shopping-bag"></i>
                <p>
                  Penjualan
                </p>
              </a>
            </li>
            <li class="nav-item">
              <a href="<?php echo Yii::app()->createUrl('operasional/index', array('pageOperasional' => 'operasional')); ?>" class="nav-link <?php echo (Yii::app()->controller->id == 'operasional' && $pageOperasional != 'report') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-credit-card"></i>
                <p>
                  Operasional
                </p>
              </a>
            </li>

            <li class="nav-item <?php echo $menuMasterli; ?>">
              <a href="#" class="nav-link <?php echo $menuMasteraHref; ?>">
                <i class="nav-icon fas fa-copy"></i>
                <p>
                  Master
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <?php echo CHtml::link('<i class="far fa-circle nav-icon"></i>Customer', array('customer/index'), array('class' => 'nav-link ' . (Yii::app()->controller->id == 'customer' ? 'active' : ''))); ?>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <?php echo CHtml::link('<i class="far fa-circle nav-icon"></i>Kategori', array('kategori/index'), array('class' => 'nav-link ' . (Yii::app()->controller->id == 'kategori' ? 'active' : ''))); ?>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <?php echo CHtml::link('<i class="far fa-circle nav-icon"></i>Master Barang', array('masterbarang/index'), array('class' => 'nav-link ' . (Yii::app()->controller->id == 'masterbarang' ? 'active' : ''))); ?>
                </li>
              </ul>

              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <?php echo CHtml::link('<i class="far fa-circle nav-icon"></i>Vendor', array('vendor/index'), array('class' => 'nav-link ' . (Yii::app()->controller->id == 'vendor' ? 'active' : ''))); ?>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <?php echo CHtml::link('<i class="far fa-circle nav-icon"></i>Satuan', array('satuan/index'), array('class' => 'nav-link ' . (Yii::app()->controller->id == 'satuan' && Yii::app()->controller->action->id == 'index' ? 'active' : ''))); ?>
                </li>
              </ul>
            </li>



            <li class="nav-item <?php echo $menuReportli; ?>">
              <a href="#" class="nav-link <?php echo $menuReportAHref; ?>">
                <i class="nav-icon fas fa-suitcase"></i>
                <p>
                  Report
                  <i class="fas fa-angle-left right"></i>
                </p>
              </a>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <?php echo CHtml::link('<i class="far fa-circle nav-icon"></i>Operasional', array('operasional/index&pageOperasional=report'), array('class' => 'nav-link ' . (Yii::app()->controller->id == 'operasional' && $pageOperasional == 'report' ? 'active' : ''))); ?>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <?php echo CHtml::link('<i class="far fa-circle nav-icon"></i>List Pengadaan', array('pembelian/index&pagePembelian=report'), array('class' => 'nav-link ' . (Yii::app()->controller->id == 'pembelian' && $pagePembelian == 'report' ? 'active' : ''))); ?>
                </li>
              </ul>
              <ul class="nav nav-treeview">
                <li class="nav-item">
                  <?php echo CHtml::link('<i class="far fa-circle nav-icon"></i>List Penjualan', array('penjualan/index&pagePenjualan=report'), array('class' => 'nav-link ' . (Yii::app()->controller->id == 'penjualan' && $pagePenjualan == 'report' ? 'active' : ''))); ?>
                </li>
              </ul>
            </li>





            <li class="nav-item">
              <a href="<?php echo Yii::app()->createUrl('site/logout'); ?>" class="nav-link <?php echo (Yii::app()->controller->id == 'site' && Yii::app()->controller->action->id == 'index') ? 'active' : ''; ?>">
                <i class="nav-icon fas fa-tachometer-alt"></i>
                <p>
                  Logout
                </p>
              </a>
            </li>
          </ul>
        </nav>
        <!-- /.sidebar-menu -->
      </div>
      <!-- /.sidebar -->
    </aside>


    <div class="content-wrapper">

      <section class="content">
        <div class="container footerbottom" id="page">
          <div class="content" ;>
            <?php echo $content; ?>
          </div>
          <div class="clear"></div>
          <br></br>
        </div><!-- page -->
      </section>

    </div>


    <footer class="main-footer">
      <strong> Copyright &copy; <?php echo date('Y'); ?> by seventh<br /></strong>
      All rights reserved.
    </footer>
  </div>




  <!-- jQuery -->

  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- jQuery UI 1.11.4 -->
  <script src="plugins/jquery-ui/jquery-ui.min.js"></script>
  <!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
  <script>
    // $.widget.bridge('uibutton', $.ui.button)
  </script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- ChartJS -->
  <script src="plugins/chart.js/Chart.min.js"></script>
  <!-- Sparkline -->
  <script src="plugins/sparklines/sparkline.js"></script>
  <!-- JQVMap -->
  <script src="plugins/jqvmap/jquery.vmap.min.js"></script>
  <script src="plugins/jqvmap/maps/jquery.vmap.usa.js"></script>
  <!-- jQuery Knob Chart -->
  <script src="plugins/jquery-knob/jquery.knob.min.js"></script>
  <!-- daterangepicker -->
  <script src="plugins/moment/moment.min.js"></script>
  <script src="plugins/daterangepicker/daterangepicker.js"></script>
  <!-- Tempusdominus Bootstrap 4 -->
  <script src="plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js"></script>
  <!-- Summernote -->
  <script src="plugins/summernote/summernote-bs4.min.js"></script>
  <!-- overlayScrollbars -->
  <script src="plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.js"></script>
  <!-- AdminLTE for demo purposes -->
  <script src="dist/js/demo.js"></script>
  <!-- AdminLTE dashboard demo (This is only for demo purposes) -->
  <script src="dist/js/pages/dashboard.js"></script>


  <script>
    // Toastr options (customize as needed)
    toastr.options = {
      "closeButton": true,
      "progressBar": true,
      "positionClass": "toast-bottom-right",
      "timeOut": "5000",
      "extendedTimeOut": "1000"
    };

    // Check for flash messages and display them
    <?php if (Yii::app()->user->hasFlash('success')): ?>
      toastr.success("<?php echo Yii::app()->user->getFlash('success'); ?>");
    <?php endif; ?>

    <?php if (Yii::app()->user->hasFlash('error')): ?>
      toastr.error("<?php echo Yii::app()->user->getFlash('error'); ?>");
    <?php endif; ?>

    $(document).on('click', '.delete-confirm', function(e) {

      e.preventDefault();
      toastr.remove();
      // Get ID from the href (URL)
      var deleteUrl = $(this).attr('href');
      var id = new URL(deleteUrl, window.location.origin).searchParams.get("id");

      console.log("ID:", id); // for confirmation

      var toast = toastr.warning(
        '<div style="margin-bottom:10px;">Are you sure you want to delete this item?</div>' +
        '<div>' +
        '<button class="btn btn-danger btn-xs confirm-delete" style="margin-right:5px;">Yes, Delete</button>' +
        '<button class="btn btn-default btn-xs cancel-delete">Cancel</button>' +
        '</div>',
        'Confirm Deletion', {
          closeButton: true,
          timeOut: 0,
          extendedTimeOut: 0,
          tapToDismiss: true,
          positionClass: 'toast-center-custom',
          onShown: function() {
            $('.confirm-delete').off('click').on('click', function() {
              window.location.href = deleteUrl;
            });
            $('.cancel-delete').off('click').on('click', function() {
              toastr.clear(toast);
            });
          }
        }
      );
    });
  </script>
</body>

</html>