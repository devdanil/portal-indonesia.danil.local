<main id="main" style="margin-top: 100px;">
  <section id="about" class="about">
    <div class="container">
      <div class="row content">
        <div class="col-lg-6" align="center">
          <!-- <img class="responsive" src="<?php echo base_url() ?>/assets/uploads/<?php echo $produk[0]->foto_produk ?>" alt="" srcset=""> -->
          <img src="<?php echo base_url() ?>/assets/uploads/<?php echo $produk[0]->foto_produk ?>" height="300px">
        </div>
        <div class="col-lg-6 pt-4 pt-lg-0">
          <h4><?php echo $produk[0]->nama_produk ?></h4>
          <p style="color: grey;">
            Diposting <?php echo $produk[0]->insert_date ?>
          </p>
          <!-- spesifikasi -->
          <p><?php echo ($produk[0]->spesifikasi_in == null) ? '-' : $produk[0]->spesifikasi_in  ?></p>
          <ul>
            <li><i class="fa fa-check-double mt-2" style="font-size: 9pt;"></i> <?php echo ($produk[0]->nama_usaha == null) ? '-' : $produk[0]->nama_usaha  ?></li>
            <li><i class="fa fa-check-double mt-2" style="font-size: 9pt;"></i> <?php echo ($produk[0]->alamat == null) ? '-' : $produk[0]->alamat  ?></li>
            <li><i class="fa fa-check-double mt-2" style="font-size: 9pt;"></i> <?php echo ($produk[0]->nama_kota == null) ? '-' : $produk[0]->nama_kota  ?></li>
            <li><i class="fa fa-check-double mt-2" style="font-size: 9pt;"></i> <?php echo ($produk[0]->nama_provinsi == null) ? '-' : $produk[0]->nama_provinsi  ?></li>
            <li><i class="fa fa-check-double mt-2" style="font-size: 9pt;"></i> <?php echo ($produk[0]->handphone == null) ? '-' : $produk[0]->handphone  ?></li>
            <li><i class="fa fa-check-double mt-2" style="font-size: 9pt;"></i> <?php echo ($produk[0]->email == null) ? '-' : $produk[0]->email  ?></li>
          </ul>
          <p class="fst-italic">
            <?php if ($produk[0]->shoope != null || $produk[0]->bukalapak != null || $produk[0]->tokopedia != null) { ?>
              Dapat dipesan melalui link berikut ini:
            <?php } ?>

          <div align="center" style="margin-top: 10px;">
            <table>
              <tr>
                <?php if ($produk[0]->shoope != null) { ?>
                  <td>
                    <a href="<?php echo $produk[0]->shoope ?>" target="_blank">
                      <img src="<?php echo base_url() ?>/assets/front/social/shopee.png" alt="shoppi" height="50px">
                    </a>
                  </td>
                <?php } ?>
                <?php if ($produk[0]->bukalapak != null) { ?>
                  <td>
                    <a href="<?php echo $produk[0]->bukalapak ?>" target="_blank">
                      <img src="<?php echo base_url() ?>/assets/front/social/bukalapak.png" alt="bukalapak " height="50px">
                    </a>
                  </td>
                <?php } ?>
                <?php if ($produk[0]->tokopedia != null) { ?>
                  <td>
                    <a href="<?php echo $produk[0]->tokopedia ?>" target="_blank">
                      <img src="<?php echo base_url() ?>/assets/front/social/tokopedia.png" alt="tokopedia" height="50px">
                    </a>
                  </td>
                <?php } ?>
              </tr>
            </table>
          </div>
          </p>
        </div>
      </div>
    </div>
  </section>
</main>