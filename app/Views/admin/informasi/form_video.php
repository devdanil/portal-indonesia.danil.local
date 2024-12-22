<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Portal Indonesia | <?php echo (empty($model)) ? 'Form Tambah Video' : 'Form Edit Video' ?></title>
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
            <h1>Video</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active"><?php echo (empty($model)) ? 'Tambah Video' : 'Edit Video' ?></li>
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
                <h3 class="card-title"><?php echo (empty($model)) ? 'Form Tambah Video' : 'Form Edit Video' ?></h3>
              </div>
                <?php if (!empty(session()->getFlashdata('error'))) : ?>
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <h4>Periksa Entrian Form</h4>
                        </hr />
                        <?php echo session()->getFlashdata('error'); ?>
                    </div>
                <?php endif; ?>
              <form enctype="multipart/form-data" method="post" action="<?php echo base_url('admin'); ?><?php echo (empty($model)) ? '/video/save' : '/video/update/'.$model->id_video ?>">
                <?= csrf_field(); ?>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="kategori">Kategori Produk</label>
                                <select class="form-control select2" name="kategori" id="kategori" required>
                                    <option value="">-- Pilih Kategori --</option>
                                    <?php foreach ($kategori_produk as $kat_value) { ?>
                                        <option value="<?php echo $kat_value->id_kategori?>" <?php echo (!empty($model) && $model->id_kategori == $kat_value->id_kategori ) ? 'selected' : ((old('kategori') == $kat_value->id_kategori ) ? 'selected' : '' ) ?> ><?php echo $kat_value->kategori?></option>
                                    <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="judul_video">Judul Video</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('judul_video') : $model->judul_video ?>" name="judul_video" class="form-control" id="judul_video" placeholder="Judul Video" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="url_video">Url Video</label>
                                <input type="text" value="<?php echo (empty($model)) ? old('url_video') : $model->url_video ?>" name="url_video" class="form-control" id="url_video" required>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="img_preview">Image Preview</label>
                                <input type="file" value="<?php echo (empty($model)) ? old('img_preview') : $model->img_preview ?>" name="img_preview" class="form-control" id="img_preview" accept="images/jpeg, images/png">
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="publish_date">Tahun</label>
                                <input type="date" value="<?php echo (empty($model)) ? old('publish_date') : $model->publish_date ?>" name="publish_date" class="form-control" id="publish_date" required>
                            </div>
                        </div>
                        <div class="col-md-4">
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
