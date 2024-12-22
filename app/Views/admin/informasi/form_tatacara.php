<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | <?php echo (empty($model)) ? 'Form Tambah Tata Cara' : 'Form Edit Tata Cara' ?></title>
  <?=  view('admin/template/header-form');?>
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
            <h1>Kegiatan</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo (empty($model)) ? 'Tambah Tata Cara' : 'Edit Tata Cara' ?></li>
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
                <h3 class="card-title"><?php echo (empty($model)) ? 'Form Tambah Tata Cara' : 'Form Edit Tata Cara' ?></h3>
              </div>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url('admin'); ?><?php echo (empty($model)) ? '/tatacara/save' : '/tatacara/update/'.$model->id_tatacara ?>">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="kategori">Kategori</label>
                                <select class="form-control select2" name="kategori" id="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($kategori_tatacara as $kat_value) { ?>
                                        <option value="<?php echo $kat_value->id_kategori?>" <?php echo (!empty($model) && $model->id_kategori == $kat_value->id_kategori ) ? 'selected' : ((old('kategori') == $kat_value->id_kategori ) ? 'selected' : '' ) ?> ><?php echo $kat_value->kategori?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="judul">Judul</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('judul') : $model->judul ?>" name="judul" class="form-control" id="judul" placeholder="Judul" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label for="content">Content </label>
                                <textarea name="content" id="content" ><?php echo (empty($model)) ? old('content') : $model->content ?></textarea>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="url">File</label>
                                <input type="file" value="<?php echo (empty($model)) ? old('url') : $model->url ?>" name="url" class="form-control" id="url" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="keyword">Keyword</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('keyword') : $model->keyword ?>" name="keyword" class="form-control" id="keyword" required>
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
<!-- Page specific script -->
<script>
$(function () {
    $('#content').summernote()

    $('.select2').select2({
        theme: 'bootstrap4'
    })

    $.validator.setDefaults({
        submitHandler: function () {
            alert( "Form successful submitted!" );
        }
    });
});

</script>
</body>
</html>
