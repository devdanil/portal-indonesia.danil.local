<main id="main">

  <!-- ======= Blog Section ======= -->
  <section id="blog" class="blog">
    <div class="container" data-aos="fade-up">
      <div class="section-title" style="margin-top: 100px;">
        <h2>Info</h2>
        <p>Video Produk Indonesia</p>
      </div>
      <div class="row">
        <!-- <div class="col-lg-12 entries">

        <article class="entry">
          <div>
            <iframe width="1280" height="720" src="https://www.youtube.com/embed/qcpWTIXZxI8"
              title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; 
              clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen>
            </iframe>
          </div>

          <h2 class="entry-title">
            <a href="blog-single.html">ETALASE UMKM - SEKAR JAWI Food - Produk Jamu dan Minuman Tradisional</a>
          </h2>

          <div class="entry-meta">
            <ul>
              <li class="d-flex align-items-center"><i class="bi bi-person"></i> <a
                  href="blog-single.html">Admin</a></li>
              <li class="d-flex align-items-center"><i class="bi bi-clock"></i> <a href="blog-single.html"><time
                    datetime="2020-01-01">Nov 1, 2021</time></a></li>
            </ul>
          </div>

          <div class="entry-content">
            <p>
              Menarik untuk diketahui berbagai produk unggulan dari SEKAR JAWI Food - Produk Jamu dan Minuman
              Tradisional
            </p>
          </div>

        </article>

        <div class="blog-pagination">
          <ul class="justify-content-center">
            <li><a href="#">1</a></li>
            <li class="active"><a href="#">2</a></li>
            <li><a href="#">3</a></li>
          </ul>
        </div>

      </div> -->
        <!-- <table cellpadding="3" cellspacing="0" border="0" style="width: 67%;">
        <thead>
            <tr>
                <th>Pencarian</th>
                <th>Tulis kata</th>
            </tr>
        </thead>
        <tbody>
            <tr id="filter_col1" data-column="0">
                <td>Judul </td>
                <td><input type="text" class="column_filter" id="col0_filter"></td>
            </tr>
        </tbody>
      </table>
      <table id="example1" class="table table-bordered table-striped">
        <thead>
        <tr>
          <th>Judul</th>
          <th>Keyword</th>
          <th>Video</th>
        </tr>
        </thead>
        <tbody>
        
        <tr>
          <td></td>
          <td></td>
          <td></td>
        </tr>
        
        </tbody>
      </table> -->
        <section id="team" class="team ">
          <div class="container">
            <div class="row">
              <?php foreach ($video as $value) { ?>
                <div class="col-lg-6">
                  <div class="member d-flex align-items-start">
                    <?php echo ($value->url_video == null) ? '-' : preg_replace("/\s*[a-zA-Z\/\/:\.]*youtube.com\/watch\?v=([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i", "<iframe width=\"420\" height=\"315\" src=\"//www.youtube.com/embed/$1\" frameborder=\"0\" allowfullscreen></iframe>", $value->url_video) ?>
                    <div class="member-info">
                      <h4><?php echo ($value->judul_video == null) ? '-' : $value->judul_video ?></h4>
                      <p><?php echo ($value->keyword == null) ? '-' : $value->keyword ?></p>
                      <!-- <div align="right" style="margin-top: 50px;">
                    <button class="btn btn-primary">Detail</button>
                  </div> -->
                    </div>
                  </div>
                </div>
              <?php } ?>
            </div>
          </div>
        </section>
      </div>
    </div>
  </section><!-- End Blog Section -->
</main>