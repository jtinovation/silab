$('#tableUser').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    ajax: getMinggu,
    columns: [
        { data: 'id' },
        { data: 'minggu_ke' },
        { data: 'start_date' },
        { data: 'end_date' },
        { data: 'keterangan' },
        /* { data: 'is_aktif' }, */
        { data: 'action' },
    ]
});

$("#btnSubmit").click(function() {
    if (($('#tahun_ajaran').val() == "") || ($('#semester').val() == "")) {
        swal.fire("Error Submit!", "Data Harus Lengkap", "error");
        return false;
    }
});
$("#BtnAddMinggu").click(function() {
    event.preventDefault();

    $('.tableElement').hide("slide", { direction: 'left' }, 1000, function() {
        $('.formElement').show("slide", { direction: 'left' }, 1000);
        document.getElementById("frmMinggu").action = act;
    });
    $("#btnSubmit").html('Simpan Data Minggu');
    $("#btnCancel").html('Batal Tambah Minggu');
});

$("#btnCancel").click(function() {
    $('.formElement').hide("slide", { direction: 'left' }, 1000, function() {
        $('.tableElement').show("slide", { direction: 'left' }, 1000);
    });
    $('#tahun_ajaran').val("");
    $('#semester').val("");
});

$("body").on("click", ".btnEditClass", function() {
    event.preventDefault();
    var svrMinggu = $(this).attr("data-minggu");
    let svrStart = $(this).attr("data-start");
    let svrEnd = $(this).attr("data-end");
    let svrTahunajaran = $(this).attr("data-tahunajaran");
    let svrKeterangan = $(this).attr("data-keterangan");
    let dataUpdate = $(this).attr("data-update");
    $('#minggu_ke').val(svrMinggu);
    $('#tahun_ajaran').val(svrTahunajaran);
    $('#keterangan').val(svrKeterangan);
    console.log($(this).attr("data-tahunajaran"));
    $('#tanggal').data('daterangepicker').setStartDate(svrStart);
    $('#tanggal').data('daterangepicker').setEndDate(svrEnd);
    $('#metod').val("PUT");

    console.log(dataUpdate);
    $('.tableElement').hide("slide", { direction: 'left' }, 1000, function() {
        $('.formElement').show("slide", { direction: 'left' }, 1000);
        document.getElementById("frmMinggu").action = dataUpdate;
    });
    $("#btnSubmit").html('Ubah Data Semester');
    $("#btnCancel").html('Batal Ubah Semester');
});

$(function() {
    setTimeout(function() {
        $(".alert-dismissable").hide('blind', {}, 500)
    }, 3000);
});

$("body").on("click", ".stts", function() {
    //console.log("click");
    //$(".stts").click(function(){
    var status = $(this).attr("data-val");
    var pk = $(this).attr("data-id");
    if (status == 0) {
        status = 1;
        //$(this).removeClass().addClass("btn btn-rouded btn-info status");
        $(this).removeClass().addClass("btn btn-rouded btn-info stts");
        $(this).attr("data-val", "1");
        //$(this).attr("data-id", pk);
        $(this).text("Aktif");
    } else if (status == 1) {
        status = 0
            //$(this).removeClass().addClass("btn btn-rouded btn-warning status");
        $(this).removeClass().addClass("btn btn-rouded btn-danger stts");
        $(this).attr("data-val", "0");
        //$(this).attr("data-id", pk);
        $(this).text("Non Aktif");
    }
    var curl = url + pk + "/" + status;
    $.ajax({
        url: "statusMK",
        method: "GET",
        data: { status: status, id: pk },
        dataType: 'json',
        success: function(response) {
            if (response) {

            } else {

            }
        }
    });
})


$("body").on("click", ".delete", function() {
    event.preventDefault();
    var id = $(this).attr("data-id");
    var currentRow = $(this).closest("tr");
    let tahun_ajaran = currentRow.find("td:eq(1)").text(); // get current row 2nd TD
    console.log($(this).closest("tr"));
    swal.fire({
        title: 'Yakin, Hapus Data Minggu?',
        text: "Data yang di hapus tidak bisa dikembalikan",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger ml-2',
        confirmButtonText: 'Yes, delete it!'
    }).then(function(result) {
        if (result.value) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                url: mingguDelete,
                data: { id: id, _token: token },
                dataType: "html",
                success: function(data) {
                    swal.fire({
                        title: "Hapus Data Berhasil!",
                        text: "",
                        icon: "success"
                    }).then(function() {
                        location.reload();
                    });
                },
                error: function(xhr, ajaxOptions, thrownError) {
                    swal.fire("Error deleting!", "Please try again", "error");
                }
            });
        }
    })
});