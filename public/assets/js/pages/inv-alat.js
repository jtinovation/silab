var table = $('#tableAlat').DataTable({
    responsive: true,
    processing: true,
    serverSide: true,
    pageLength: 16,
    ajax: getInvAlat,
    columns: [
        { data: 'id' },
        { data: 'brg' },
        { data: 'jmlh' },
        { data: 'keterangan' },
        { data: 'action' },
    ]
});

$("body").on("click",".addMode",function(){
    $('.wrap-alat-to-lab').hide("slide", { direction: 'down' }, 1000, function() {
        $('.wrap-master-alat').show("slide", { direction: 'down' }, 1000);
    });
});
$("body").on("click","#btnCancel",function(){
    $('.wrap-master-alat').hide("slide", { direction: 'down' }, 1000, function() {
        $('.wrap-alat-to-lab').show("slide", { direction: 'down' }, 1000);
        $('#satuanDefault').val(null).trigger('change');
        $('#barang').val("");
        $('#spesifikasi').val("");
    });
});
$("body").on("click",".btnEditClass",function(){
    event.preventDefault();
    dataUpdate = $(this).attr("data-href");
    var brg = $(this).attr("data-barang");
    var jml = $(this).attr("data-jumlah");
    $("#jmlhubah").val(jml);
    $("#nmbrg").val(brg);

    $('#ShowEditAlatlab').modal('show');

});

$("body").on("click","#btnAlatLabUpdate",function(){
    var jml = $("#jmlhubah").val();
    $.ajax({
        type: "POST",
        url: dataUpdate,
        data: { jml:jml, _method:"PUT", _token: token},
        success: function(data) {
            $('#ShowEditAlatlab').modal('hide');
            swal.fire({
                title: "Data Berhasil Di Ubah",
                text: "",
                icon: "success"
            }).then(function() {
                table.ajax.reload();
                $("#jmlhubah").val("");
                $("#nmbrg").val("");
            });
        },
        error: function(xhr, ajaxOptions, thrownError) {
            swal.fire("Error deleting!", "Please try again", "error");
        }
    });
});

$("body").on("click","#btnAlatLab",function(){
    let tm_barang_id = $('#selectAlat').val();
    let jumlah       = $('#jmlh').val();
    if(tm_barang_id!=""){
        $.ajax({
            type: "POST",
            url: saveAlat,
            data: { id: tm_barang_id,jumlah:jumlah, _token: token },
            dataType: "html",
            success: function(data) {
                $('#ShowAddAlatlab').modal('hide');
                swal.fire({
                    title: "Simpan Data Berhasil!",
                    text: "",
                    icon: "success"
                }).then(function() {
                    table.ajax.reload();
                    $('#selectAlat').val(null).trigger('change');
                    $('#jmlh').val(0);
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                swal.fire("Error deleting!", "Please try again", "error");
            }
        });
    }
    console.log(tm_barang_id);
});


$("body").on("click","#btnMasterAlat",function(){
    let satuan = $('#satuanDefault').val();
    let barang = $('#barang').val();
    let spesifikasi = $('#spesifikasi').val();
    if(barang!="" && satuan!=""){

        $.ajax({
            type: "POST",
            url: saveMasterAlat,
            data: { barang: barang, satuan: satuan , spesifikasi:spesifikasi , _token: token },
            dataType: "html",
            success: function(data) {
                swal.fire({
                    title: "Simpan Data Berhasil!",
                    text: "",
                    icon: "success"
                }).then(function() {
                    $('.wrap-master-alat').hide("slide", { direction: 'down' }, 1000, function() {
                        $('.wrap-alat-to-lab').show("slide", { direction: 'down' }, 1000);
                        $('#satuanDefault').val(null).trigger('change');
                        $('#barang').val("");
                        $('#spesifikasi').val("");
                    });
                });
            },
            error: function(xhr, ajaxOptions, thrownError) {
                swal.fire("Error deleting!", "Please try again", "error");
            }
        });
       // console.log(barang+" # "+satuan);
    }else if(barang == ""){
        //console.log("Isi Data Barang Untuk Melanjutkan");
        swal.fire({
            title: "Isi Data Barang Untuk Melanjutkan!",
            text: "",
            icon: "error"
        });
    }else if(satuan == ""){
        //console.log("Isi Data Satuan Untuk Melanjutkan");
        swal.fire({
            title: "Isi Data Satuan Untuk Melanjutkan!",
            text: "",
            icon: "error"
        });
    }

});

$('.AddAlat').click(function(){
    initailizeSelect2();
    initailizeSatuan();
    $('.mdlHeaderTitle').text(nmLab);
    $('#ShowAddAlatlab').modal('show');
});

$("#satuanDefault").select2({
    placeholder: "Pilih Satuan",
    allowClear: true,
    dropdownParent: $('#ShowAddAlatlab .modal-body'),
});

function initailizeSelect2() {
    $("#selectAlat").select2({
        dropdownParent: $('#ShowAddAlatlab .modal-body'),
        ajax: {
            url: alatSelect,
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
}

function initailizeSatuan() {
    $("#satuanDefault").select2({
        dropdownParent: $('#ShowAddAlatlab .modal-body'),
        ajax: {
            url: satuanSelect,
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term,
                };
            },
            processResults: function(response) {
                return {
                    results: response
                };
            },
            cache: true
        }
    });
}

$("body").on("keyup", "input.number", function(event) {
    if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
    }
});

$("body").on("click",".delete",function(){
    event.preventDefault();
    let id      = $(this).attr("data-id");
    let href    = $(this).attr("data-href");
    let barang    = $(this).attr("data-barang");

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
            $.ajax({
                type: "POST",
                url: href,
                data: { id:id , _token: token},
                dataType: "html",
                success: function (data) {
                    Swal.fire({
                        title: "Hapus Data Berhasil!",
                        text: "",
                        icon: "success"
                    }).then(function(){
                        table.ajax.reload();
                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    Swal.fire("Error deleting!", "Please try again", "error");
                }
            });
        }
    });

});




