<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | <?php echo (empty($model)) ? 'Form Tambah User' : 'Form Edit User' ?></title>
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="icon">
  <link href="<?php echo base_url() ?>/assets/logo.png" rel="apple-touch-icon">
  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/back/css/adminlte.min.css">
  <!-- Select2 -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2/css/select2.min.css">
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css">
  <!-- summernote -->
  <link rel="stylesheet" href="<?php echo base_url() ?>/assets/plugins/summernote/summernote-bs4.min.css">
</head>
<body class="hold-transition dark-mode sidebar-mini layout-fixed layout-navbar-fixed layout-footer-fixed">
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
            <h1>Settings</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo (empty($model)) ? 'Tambah User' : 'Edit User' ?></li>
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
                <h3 class="card-title"><?php echo (empty($model)) ? 'Form Tambah User' : 'Form Edit User' ?></h3>
              </div>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url(); ?><?php echo (empty($model)) ? '/user/save' : '/user/update/'.$model->id ?>">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="username">Username</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('username') : $model->username ?>" name="username" class="form-control" id="username" placeholder="Username" required>
                            </div>
                            <?php if(empty($is_edit)){ ?>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" value="<?php echo (empty($model)) ? old('password') : $model->password ?>" name="password" class="form-control" id="password" placeholder="Password" required>
                            </div>
                            <?php } ?>
                            <div class="form-group">
                                <label for="level">Level</label>
                                <select class="form-control" name="level" id="level" required>
                                  <option value="">-- Pilih Level --</option>
                                  <option value="1" <?php echo (!empty($model) && $model->level == '1' ) ? 'selected' : '' ?> >Admin</option>
                                  <option value="2" <?php echo (!empty($model) && $model->level == '2' ) ? 'selected' : '' ?> >Operator</option>
                              </select>
                            </div>
                            <div class="form-group">
                                <label for="fullname">Nama Lengkap</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('fullname') : $model->fullname ?>" name="fullname" class="form-control" id="fullname" placeholder="Nama Lengkap" required>
                            </div> 
                            <div class="form-group">
                                <label for="hp">No HP</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('hp') : $model->hp ?>" name="hp" class="form-control" id="hp" required>
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" value="<?php echo (empty($model)) ? old('email') : $model->email ?>" name="email" class="form-control" id="email" required>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- /.card-body -->
                <div class="card-footer">
                  <button type="submit" class="btn btn-primary"><?php echo (empty($model)) ? 'Submit' : 'Update' ?></button>
                  <a href="<?php echo base_url() ?>/settings-user" ><button type="button" class="btn btn-success">Kembali</button></a>
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
<script src="<?php echo base_url() ?>/assets/plugins/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="<?php echo base_url() ?>/assets/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- Select2 -->
<script src="<?php echo base_url() ?>/assets/plugins/select2/js/select2.full.min.js"></script>
<!-- jquery-validation -->
<script src="<?php echo base_url() ?>/assets/plugins/jquery-validation/jquery.validate.min.js"></script>
<script src="<?php echo base_url() ?>/assets/plugins/jquery-validation/additional-methods.min.js"></script>
<!-- AdminLTE App -->
<script src="<?php echo base_url() ?>/assets/back/js/adminlte.min.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="<?php echo base_url() ?>/assets/back/js/demo.js"></script>
<!-- Summernote -->
<script src="<?php echo base_url() ?>/assets/plugins/summernote/summernote-bs4.min.js"></script>
<!-- Page specific script -->
<script>
$(function () {
    $('.select2').select2({
        theme: 'bootstrap4'
    })

    $.validator.setDefaults({
        submitHandler: function () {
            alert( "Form successful submitted!" );
        }
    });
});

$(document).ready(function(e) {
 $('#kategori').change(function(){
     var kat_id = $('#kategori').val();
     if (kat_id != ""){
         var post_url = "<?php echo base_url();?>/produk/get_sub_kategori/" + kat_id;
         $.ajax({
             type: "POST",
             url: post_url,
             data: {'id_kategori':kat_id},
             success: function(sub_kategori) //we're calling the response json array 'cities'
             {
                 //$('#f_city').empty();
                 $('#subkategori').show();
                 $('#subkategori').html(sub_kategori);
                 /*$.each(cities,function(id,city)
                 {
                     var opt = $('<option />'); // here we're creating a new select option for each group
                     opt.val(id);
                     opt.text(city);
                     $('#f_city').append(opt);
                 });*/
             } //end success
          }); //end AJAX
     } else {
         //$('#f_city').empty();
         //$('#subKategori').hide();
     }//end if
 }); //end change
 
 $('#provinsi').change(function(){
     var prov_id = $('#provinsi').val();
     if (prov_id != ""){
         var post_url = "<?php echo base_url();?>/produk/get_city/" + prov_id;
         $.ajax({
             type: "POST",
             url: post_url,
             data: {'id_provinsi':prov_id},
             success: function(cities) //we're calling the response json array 'cities'
             {
                 //$('#f_city').empty();
                 $('#kabkot').show();
                 $('#kabkot').html(cities);
                 /*$.each(cities,function(id,city)
                 {
                     var opt = $('<option />'); // here we're creating a new select option for each group
                     opt.val(id);
                     opt.text(city);
                     $('#f_city').append(opt);
                 });*/
             } //end success
          }); //end AJAX
     } else {
         //$('#f_city').empty();
         $('#kabkot').hide();
     }//end if
 }); //end change
});

</script>
</body>
</html>
