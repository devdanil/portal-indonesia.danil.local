$(document).ready(function () {
  const base_url = location.origin;
  $(".filter").on("change", function () {
    $(this).closest("form").trigger("submit");
  });

  $(".custom-editor").each(function (index, element) {
    $(element).summernote();
  });

  $("#provinsi_id").on("change", function (e) {
    let opt = '<option value="">Pilih</option>';
    if ($("#kota_id").length < 1) return false;
    let data = {
      provinsi_id: $(this).val(),
    };
    postData(data, "/ajax/getKota", function (result) {
      $.each(result, function (i, val) {
        opt += '<option value="' + val.id + '">' + val.nama + "</option>";
      });
      $("#kota_id").html(opt);
    });
  });

  $("#kategori_id").on("change", function (e) {
    let opt = '<option value="">Pilih</option>';
    if ($("#subkategori_id").length < 1) return false;
    let data = {
      kategori_id: $(this).val(),
    };
    postData(data, "/ajax/getSubKategori", function (result) {
      $.each(result, function (i, val) {
        opt += '<option value="' + val.id_sub + '">' + val.nama + "</option>";
      });
      $("#subkategori_id").html(opt);
    });
  });
  $(".btn-delete-produk").on("click", function (e) {
    e.preventDefault();
    if (!$(this).data("id")) return false;
    let data = {
      produk_id: $(this).data("id"),
    };
    if (confirm("Apakah anda yakin akan menghapus produk ini ?")) {
      postData(data, "/ajax/deleteProduk", function (result) {
        console.log(result);
         location.reload();
      });
    }
  });
  function postData(data, url, getOnSuccess) {
    $.ajax({
      headers: {
        "X-CSRF-TOKEN": $('meta[name="X-CSRF-TOKEN"]').attr("content"),
      },
      type: "POST",
      url: base_url + url,
      data: data,
      dataType: "JSON",
      success: getOnSuccess,
      error: ajaxOnError,
    });
  }

  function ajaxOnError(data) {
    alert("Mohon periksa koneksi anda");
    console.log(data);
  }
});
