<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | <?php echo (empty($model)) ? 'Form Tambah Faq' : 'Form Edit Faq' ?></title>
  <?=  view('admin/template/header-form');?>
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
<div class="wrapper">
  <!-- Navbar -->
  <?php echo view('admin/template/navbar'); ?>
  <!-- /.navbar -->

  <!-- Main Sidebar Container -->
  <?php echo view('admin/template/aside'); ?>

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Faq</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo (empty($model)) ? 'Tambah Faq' : 'Edit Faq' ?></li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
              <div class="card-header">
                <h3 class="card-title"><?php echo (empty($model)) ? 'Form Tambah Faq' : 'Form Edit Faq' ?></h3>
              </div>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url('admin'); ?><?php echo (empty($model)) ? '/faq/save' : '/faq/update/'.$model->id ?>">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="question">Question</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('question') : $model->question ?>" name="question" class="form-control" id="question" placeholder="Question" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Answer</label>
                                <textarea name="answer" id="answer" ><?php echo (empty($model)) ? old('answer') : $model->answer ?></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <?php
                    if(empty($model)){
                      ?> 
                        <button type="submit" class="btn btn-primary">Submit</button>
                      <?php
                    }else {
                      ?>
                        <button type="submit" class="btn btn-primary" onclick="return confirm('Apakah anda yakin akan mengupdate data?')">Update</button>
                      <?php
                    }
                  ?>
                </div>
              </form>
            </div>
            <!-- /.card -->
            </div>
          <!--/.col (left) -->
          <!-- right column -->
          <div class="col-md-6">

          </div>
          <!--/.col (right) -->
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php echo view('admin/template/footer'); ?>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
  <?= view('admin/template/foot-form'); ?>
<!-- InputMask -->
<script src="<?php echo base_url() ?>/assets/plugins/moment/moment.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/inputmask/jquery.inputmask.min.js"></script>
<!-- date-range-picker -->
<script src="<?php echo base_url() ?>/assets/plugins/daterangepicker/daterangepicker.js"></script>
<!-- bootstrap color picker -->
<script src="<?php echo base_url() ?>/assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js"></script>
<!-- Page specific script -->
<script>
$(function () {
    $('.select2').select2({
        theme: 'bootstrap4'
    })
    $('#answer').summernote()
});

$('#id_provinsi').change(function(){
     var prov_id = $('#id_provinsi').val();
     if (prov_id != ""){
         var post_url = "<?php echo base_url('admin');?>/produk/get_city/" + prov_id;
         $.ajax({
             type: "POST",
             url: post_url,
             data: {'id_provinsi':prov_id},
             success: function(cities)
             {
                 $('#id_kota').show();
                 $('#id_kota').html(cities);
             }
          });
     } else {
         $('#id_kota').hide();
     }
 });

</script>
</body>
</html>
