$(function() {
    $('#tableBarang').DataTable({
        responsive: false,
        processing: true,
        serverSide: true,
        pageLength: 25,
        ajax: getBarang,
        columns: [
            { data: 'id', width: "10%" },
            { data: 'barang', width: "40%" },
            { data: 'qty', width: "20%" },
            { data: 'action', width: "30%" },
        ]
    });
});

$("#satuanDefault").select2({
    placeholder: "Satuan Default",
    allowClear: true
});

$("#jenisBarang").select2({
    placeholder: "Pilih Jenis Barang",
    allowClear: true
});

$("#SelectJurusan").select2({
    placeholder: "Pilih Jurusan",
    allowClear: true
});

$("body").on("click",".delete",function(){
    event.preventDefault();
    var currentRow = $(this).closest("tr");
    let barang   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
    var id=$(this).attr("data-id");

    Swal.fire({
        title: 'Hapus Data Barang?',
        text: "Anda akan menghapus barang "+barang,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonClass: 'btn btn-success',
        cancelButtonClass: 'btn btn-danger ml-2',
        confirmButtonText: 'Yes, delete it!'
    }).then(function (result) {
        if (result.value) {
            var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
            $.ajax({
                type: "POST",
                url: barangDelete,
                data: {id:id, _token: "{{ csrf_token() }}"},
                dataType: "html",
                success: function (data) {
                    Swal.fire({
                        title: "Hapus Data Berhasil!",
                        text: "",
                        icon: "success"
                    }).then(function(){
                        location.reload();
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Swal.fire("Error deleting!", "Please try again", "error");
                }
            });
        }
    });

});

$("#BtnAddBarang").click(function() {
    event.preventDefault();
    $('.tableElement').hide("slide", { direction: 'left' }, 1000, function() {
        $('.formElementAdd').show("slide", { direction: 'left' }, 1000);
        //$('.formElementAddSatuan').show("slide",{direction:'left'},1000);
        document.getElementById("frmBarang").action = act;
        //document.getElementById("frmSatuanBarang").action = act;
    });
    $("#btnSubmitAdd").html('Simpan Data Barang');
    $("#btnCancelAdd").html('Batal Tambah Barang');
});

$("#btnCancel").click(function() {
    $('.formElementEdit').hide("slide", { direction: 'left' }, 1000, function() {
        $('.tableElement').show("slide", { direction: 'left' }, 1000);
    });
    $('#barang').val("");
});

$("#btnCancelAdd").click(function() {
    $('.formElementAdd').hide("slide", { direction: 'left' }, 1000, function() {
        $('.tableElement').show("slide", { direction: 'left' }, 1000);
    });
    $('.txtSatuan').val("");
});

$("body").on("click", ".add-more", function() {
    var html = $(".copy-fields").html();
    var rep = html.replace('none', "block");
    var rep = rep.replace('abc', "input_copy");
    var rep = rep.replace('success', "danger");
    var rep = rep.replace('add-more', "remove");
    var rep = rep.replace('plus', "trash");
    $(".core-ans").append(rep);
    //console.log(rep);
});

$("body").on("click", ".remove", function() {
    $(this).parents(".input_copy").remove();
});

$(function() {
    setTimeout(function() {
        $(".alert-dismissable").hide('blind', {}, 500)
    }, 3000);
});
