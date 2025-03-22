<?php $this->widget('bootstrap.widgets.TbBreadcrumb', array('links' => array()));
?>

<style>
  .modal {
    position: fixed !important;
    top: 30% !important;
    left: 50% !important;
    transform: translate(-50%, -50%) !important;
    z-index: 1050 !important;
    width: 70% !important;
    /* Retain your original width */
    /*display: block !important;*/
    /* Ensure the modal is displayed */
    margin-left: auto !important;
    margin-right: auto !important;
  }
</style>


<h1>Dashboard</h1>

<div class="container-fluid">
  <!-- Small boxes (Stat box) -->
  <div class="row">
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-info">
        <div class="inner">
          <h3><?php echo $count; ?></h3>

          <p>Total Barang</p>
        </div>
        <div class="icon">
          <i class="ion ion-bag"></i>
        </div>
        <?php
        echo CHtml::link(
          'More info<i class="fas fa-arrow-circle-right"></i>',
          array('/site/getData', 'dashboard' => 'totalBarang'),
          array(
            'class' => 'small-box-footer',
            'title' => 'View',
            'onclick' => 'openModal(this); return false;',
            'rel' => 'tooltip'
          )
        );
        ?>
      </div>
    </div>

    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-success">
        <div class="inner">
          <h3><?php echo $totalMinStok; ?></h3>

          <p>Stok Limit</p>
        </div>
        <div class="icon">
          <i class="ion ion-stats-bars"></i>
        </div>
        <?php
        echo CHtml::link(
          'More info<i class="fas fa-arrow-circle-right"></i>',
          array('/site/getData', 'dashboard' => 'stokLimit'),
          array(
            'class' => 'small-box-footer',
            'title' => 'View',
            'onclick' => 'openModal(this); return false;',
            'rel' => 'tooltip'
          )
        );
        ?>

      </div>
    </div>
    <!-- ./col -->
    <div class="col-lg-3 col-6">
      <!-- small box -->
      <div class="small-box bg-warning">
        <div class="inner">
          <h3><?php echo $totalTransaksiPenjualan; ?></h3>

          <p>Penjualan Bulan ini</p>
        </div>
        <div class="icon">
          <i class="ion ion-person-add"></i>
        </div>
        <?php
        // echo CHtml::link(
        //   'More info<i class="fas fa-arrow-circle-right"></i>',
        //   array('/site/getData', 'dashboard' => 'totalPenjualan'),
        //   array(
        //     'class' => 'small-box-footer',
        //     'title' => 'View',
        //     'onclick' => 'openModal(this); return false;',
        //     'rel' => 'tooltip'
        //   )
        // );

        echo CHtml::link(
          'More info<i class="fas fa-arrow-circle-right"></i>',
          array('/penjualan/index', 'pagePenjualan' => 'penjualan'),
          array(
            'class' => 'small-box-footer',
            'title' => 'View',
            //'onclick' => 'openModal(this); return false;',
            'rel' => 'tooltip'
          )
        );

        ?>
      </div>
    </div>
    <div class="col-lg-3 col-6">
      <div class="small-box bg-danger">
        <div class="inner">
          <h3><?php echo $totalData; ?></h3>
          <p>Expired Date</p>
        </div>
        <div class="icon">
          <i class="ion ion-pie-graph"></i>
        </div>
        <?php
        echo CHtml::link(
          'More info<i class="fas fa-arrow-circle-right"></i>',
          array('/site/getData', 'dashboard' => 'expired'),
          array(
            'class' => 'small-box-footer',
            'title' => 'View',
            'onclick' => 'openModal(this); return false;',
            'rel' => 'tooltip'
          )
        );
        ?>
      </div>
    </div>
  </div>
</div>
<br></br>

<!-- Modal -->
<div class="modal fade" id="dataModal" style="display: none; width:70% !important;" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel" aria-hidden="true">
  <div class="modal-content">
    <div class="modal-header">
      <h5 class="modal-title" id="dataModalLabel">Info</h5>
      <button type="button" class="close" data-dismiss="modal" aria-label="Close">
        <span aria-hidden="true">&times;</span>
      </button>
    </div>
    <div class="modal-body" id="dataContent">
    </div>
  </div>
</div>

<script>
  function openModal(button) {
    var url = $(button).attr('href');
    $('#dataContent').html('');

    $.ajax({
      url: url,
      type: 'GET',
      success: function(data) {
        $('#dataContent').html(data);
        $('#dataModal').modal('show');
      },
      error: function(jqXHR, textStatus, errorThrown) {
        console.error("Error loading data: " + textStatus, errorThrown);
        $('#dataContent').html('<p>Error loading data.</p>');
      }
    });
  }
</script>


<!-- <div class="container">
  <button onclick="printContent()">Print</button>
  <div id="printArea">
    <h1>Printable Content</h1>
    <p>This is the content that will be printed.</p>
  </div>
</div> -->

<style>
  @media print {
    body {
      margin: 0;
      /* Remove default margin */
      padding: 0;
      /* Remove default padding */
    }

    #printArea {
      position: absolute;
      /* Positioning to control alignment */
      top: 0;
      /* Align to the top */
      left: 0;
      /* Align to the left */
      width: 100%;
      /* Full width */
      height: auto;
      /* Auto height */
    }

    button {
      display: none;
      /* Hide the button when printing */
    }
  }
</style>

<script type="text/javascript">
  // function printContent() {
  //   var printContents = document.getElementById('printArea').innerHTML;
  //   var originalContents = document.body.innerHTML;
  //   document.body.innerHTML = printContents;
  //   window.print();
  //   document.body.innerHTML = originalContents;
  // }
</script>