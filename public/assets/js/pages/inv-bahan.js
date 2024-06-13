function initTable(){
    table = $('#tblAllInOne').DataTable({
        ordering:false,
        paging:true,
        searching: true,
        "ajax" : murlnull
    });
}

function initTableBarang(){
    tableBarang = $('#tableBarang').DataTable({
    responsive:true,
    processing: true,
    serverSide: true,
    pageLength: 25,
    ajax: tableUrl,
    columns: [
        { data: 'id' },
        { data: 'brg' },
        { data: 'satuan' },
        { data: 'jmlh' },
        { data: 'action' },
    ]
    });
}
$("body").on("click",".addMode",function(){
    console.log("addMode");
    $('.wrap-bahan-to-lab').hide("slide", { direction: 'down' }, 1000, function() {
        $('.wrap-master-alat').show("slide", { direction: 'down' }, 1000);
    });
});

$("body").on("click","#btnCancel",function(){
    $('.wrap-master-alat').hide("slide", { direction: 'down' }, 1000, function() {
        $('.wrap-bahan-to-lab').show("slide", { direction: 'down' }, 1000);
        $('#satuanDefault').val(null).trigger('change');
        $('#barang').val("");
        $('#spesifikasi').val("");
    });
});

$("body").on("click",".btnDetailClass",function(){
    event.preventDefault();
    var id      = $(this).attr("data-val");
    $('.tableElement').hide("slide",{direction:'up'},1000, function(){
        $('.tableKartuStok').show("slide",{direction:'up'},1000);
        let murlid = murl+"/"+id;
        table.ajax.url(murlid).load();
        console.log(murlid);
    });
});

$("body").on("keyup", "input.number", function(event) {
if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
    $(this).val(function(index, value) {
        return value.replace(/\D/g, "");
    });
}
});

$("body").on("click","#btnBahanLab",function(){
let tm_barang_id = $('#selectBahan').val();
let jumlah       = $('#jmlh').val();
if(tm_barang_id!="" && jumlah!=""){
    $.ajax({
        type: "POST",
        url: saveBahan,
        data: { id: tm_barang_id,jumlah:jumlah, _token: token },
        dataType: "html",
        success: function(data) {
            $('#ShowAddBahanlab').modal('hide');
            swal.fire({
                title: "Simpan Data Berhasil!",
                text: "",
                icon: "success"
            }).then(function() {
                tableBarang.ajax.reload();
                $('#selectBahan').val(null).trigger('change');
                $('#jmlh').val(0);
            });
        },
        error: function(xhr, ajaxOptions, thrownError) {
            swal.fire("Gagal Menambahkan Data!", "Please try again", "error");
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
            url: saveMasterBahan,
            data: { barang: barang, satuan: satuan , spesifikasi:spesifikasi , _token: token },
            dataType: "html",
            success: function(data) {
                swal.fire({
                    title: "Simpan Data Berhasil!",
                    text: "",
                    icon: "success"
                }).then(function() {
                    $('.wrap-master-alat').hide("slide", { direction: 'down' }, 1000, function() {
                        $('.wrap-bahan-to-lab').show("slide", { direction: 'down' }, 1000);
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

$('.AddBahan').click(function(){
initailizeSelect2();
initailizeSatuan();
$('.mdlHeaderTitle').text(nmLab);
$('#ShowAddBahanlab').modal('show');
});

function initailizeSelect2() {
$(".select2_el").select2({
    dropdownParent: $('#ShowAddBahanlab .modal-body'),
    ajax: {
        url: bahanSelect,
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
    },
    escapeMarkup: function (m) { return m; }
});
}

function initailizeSatuan() {
$("#satuanDefault").select2({
    dropdownParent: $('#ShowAddBahanlab .modal-body'),
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

$("body").on("click",".btnEditClass",function(){
event.preventDefault();
dataUpdate = $(this).attr("data-href");
var brg = $(this).attr("data-barang");
var jml = $(this).attr("data-jumlah");
$("#jmlhubah").val(jml);
$("#nmbrg").val(brg);

$('#ShowEditBahanlab').modal('show');

});

$("body").on("click","#btnBahanLabUpdate",function(){
var jml = $("#jmlhubah").val();
$.ajax({
    type: "POST",
    url: dataUpdate,
    data: { jml:jml, _method:"PUT", _token: token},
    success: function(data) {
        $('#ShowEditBahanlab').modal('hide');
        swal.fire({
            title: "Data Berhasil Di Ubah",
            text: "",
            icon: "success"
        }).then(function() {
            tableBarang.ajax.reload();
            $("#jmlhubah").val("");
            $("#nmbrg").val("");
        });
    },
    error: function(xhr, ajaxOptions, thrownError) {
        swal.fire("Gagal Mengubah Data!", "Please try again", "error");
    }
});
});
