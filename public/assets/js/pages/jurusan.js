
$('#tableUser').DataTable({
    responsive:true,
    processing: true,
    serverSide: true,
    ajax: getJurusan,
    columns: [
        { data: 'id' },
        { data: 'kode' },
        { data: 'jurusan' },
        /* { data: 'is_aktif' }, */
        { data: 'action' },
    ]
});

var tableProdi = $('#tblAllInOneProdi').DataTable({
    ordering:false,
    paging:false,
    searching: false,
    "ajax" : url,
});

$('.tableElementProdi').hide("slide",{direction:'up'},900);

$("#BtnAddJurusan").click(function() {

    event.preventDefault();

     $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.formElement').show("slide",{direction:'left'},1000);
        document.getElementById("frmJurusan").action = act
    });
    $("#btnSubmit").html('Simpan Data Jurusan');
    $("#btnCancel").html('Batal Tambah Jurusan');
    //console.log(urlProdi);
});

$("#btnCancel").click(function() {
    $('.formElement').hide("slide",{direction:'left'},1000, function(){
        $('.tableElement').show("slide",{direction:'left'},1000);
    });
    $('#kodejurusan').val("");
    $('#jurusan').val("");
});

$("body").on("click",".btnEditClass",function(){
    event.preventDefault();
    var kode = $(this).attr("data-kode");
    var jurusan = $(this).attr("data-jurusan");
    let dataUpdate=$(this).attr("data-update");
    $('#kodejurusan').val(kode);
    $('#jurusan').val(jurusan);
    $('#metod').val("PUT");
    var act = dataUpdate;
    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.formElement').show("slide",{direction:'left'},1000);
        document.getElementById("frmJurusan").action = act;
    });
    $("#btnSubmit").html('Ubah Data Jurusan');
    $("#btnCancel").html('Batal Ubah Jurusan');
});

$("body").on("click",".btnDetailClass",function(){
    let kode = $(this).attr("data-kode");
    let jurusan = $(this).attr("data-jurusan");
    let titlekode = jurusan+" ( "+kode+" ) ";
    let id=$(this).attr("data-val");
    idjur = id;
    //$(".header-title-prodi").text(tm_jurusan_title);
    $(".header-title-prodi").text(titlekode);
    let url = urlProdi+"/"+id;
    //console.log(url);
    //table.ajax.reload();
    tableProdi.ajax.url(url).load();
    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.tableElementProdi').show("slide",{direction:'left'},1000);
        //document.getElementById("frmJurusan").action = actEdit;
    });
});

$("#BtnAddProdi").click(function() {
    event.preventDefault();
    mode = "add";
     $('.tableElementProdi').hide("slide",{direction:'left'},1000, function(){
        $('.formElementProdi').show("slide",{direction:'left'},1000);
        document.getElementById("frmProdi").action = "";
    });
    $('#txtProdiKode').val("");
    $('#txtProgramStudiTitle').val("");
    $('#txtIdProgramStudi').val("");

    $("#btnSubmitProdi").html('Simpan Data Program Studi');
    $("#btnCancelProdi").html('Batal Tambah Program Studi');
});

$("#btnSubmitProdi").click(function(){
    event.preventDefault();
    if(mode=="add"){
        let tm_program_studi_kode  = $('#txtProdiKode').val();
        let tm_program_studi_title = $('#txtProgramStudiTitle').val();
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: prodistore,
            data: { kode: tm_program_studi_kode, prodi: tm_program_studi_title, jurusan_id:idjur, _token: token}
        })
            .done(function( msg ) {
            //alert( "Data Saved: " + msg );
            //Swal.fire(msg);
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: 'Data Prodi Berhasil Di Simpan',
             });
        });
    }else if(mode=="edit"){
        let tm_program_studi_kode  = $('#txtProdiKode').val();
        let tm_program_studi_title = $('#txtProgramStudiTitle').val();
        let dataUpdate= $('#txtIdProgramStudi').val();
        $.ajax({
            method: "POST",
            url: dataUpdate,
            data: { kode: tm_program_studi_kode, prodi: tm_program_studi_title, _method:"PUT", _token: token}
        }).done(function( msg ) {
    //        alert( "Data Saved: " + msg );
            //Swal.fire(msg);
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: 'Data Prodi Berhasil Di Simpan',
             });
        });
    }

    let jurlid = urlProdi+"/"+idjur;
    tableProdi.ajax.url(jurlid).load();
    $('.formElementProdi').hide("slide",{direction:'left'},1000, function(){
        $('.tableElementProdi').show("slide",{direction:'left'},1000);
    });
});

$("body").on("click",".btnEditClassProdi",function(){
    event.preventDefault();
    mode = "edit";
    var currentRow = $(this).closest("tr");
    let tm_program_studi_kode    =currentRow.find("td:eq(0)").text(); // get current row 1st TD value
    let tm_program_studi_title   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
    //var col3=currentRow.find("td:eq(2)").text(); // get current row 3rd TD
    let id=$(this).attr("data-update");
    $('#txtProdiKode').val(tm_program_studi_kode);
    $('#txtProdiKode').focus();
    $('#txtProgramStudiTitle').val(tm_program_studi_title);
    $('#txtIdProgramStudi').val(id);

    $('.tableElementProdi').hide("slide",{direction:'left'},1000, function(){
        $('.formElementProdi').show("slide",{direction:'left'},1000);
    });
    $("#btnSubmitProdi").html('Ubah Data Program Studi');
    $("#btnCancelProdi").html('Batal Ubah Program Studi');
});

$("#BtnBackProdi").click(function(){
    event.preventDefault();
    $('.tableElementProdi').hide("slide",{direction:'left'},1000, function(){
        $('.tableElement').show("slide",{direction:'left'},1000);
    });
    //console.log("test");
});

$("#btnCancelProdi").click(function() {
    $('.formElementProdi').hide("slide",{direction:'left'},1000, function(){
        $('.tableElementProdi').show("slide",{direction:'left'},1000);
    });
    $('#txtProdiKode').val("");
    $('#txtProgramStudiTitle').val("");
    $('#txttm_program_studi_id').val("");
});

$("body").on("click",".btnDeleteClassProdi",function(){
    event.preventDefault();
    var currentRow = $(this).closest("tr");
    let tm_program_studi_title   =currentRow.find("td:eq(1)").text(); // get current row 2nd TD
    var id=$(this).attr("data-val");
    //console.log(id);
    swal.fire({
        title: 'Hapus Data Program Studi?',
        text: "Anda akan menghapus "+tm_program_studi_title,
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
                url: prodidelete,
                data: {id:id, _token: token},
                dataType: "html",
                success: function (data) {
                    swal.fire({
                        title: "Hapus Data Berhasil!",
                        text: "",
                        icon: "success"
                    }).then(function(){
                        let jurlid = urlProdi+"/"+idjur;
                        tableProdi.ajax.url(jurlid).load();

                    });
                },
                error: function (xhr, ajaxOptions, thrownError) {
                    swal.fire("Error deleting!", "Please try again", "error");
                }
            });
        }
    })
});

$(function(){
    setTimeout(function(){
        $(".alert-dismissable").hide('blind', {}, 500)
    },3000);
});

$("body").on("click",".stts",function(){
//console.log("click");
    var status = $(this).attr("data-val");
    var pk = $(this).attr("data-id");
    if(status==0){status =1;
    //$(this).removeClass().addClass("btn btn-rouded btn-info status");
        $(this).removeClass().addClass("btn btn-rouded btn-info stts");
        $(this).attr("data-val", "1");
        //$(this).attr("data-id", pk);
        $(this).text("Aktif");
    }else if(status==1){status =0
    //$(this).removeClass().addClass("btn btn-rouded btn-warning status");
        $(this).removeClass().addClass("btn btn-rouded btn-danger stts");
        $(this).attr("data-val", "0");
        //$(this).attr("data-id", pk);
        $(this).text("Non Aktif");
    }
    var curl= url + pk+"/"+status;
    $.ajax({
        url : "statusMK",
        method : "GET",
        data : {status: status, id:pk},
        dataType: 'json',
        success: function(response){
            if (response) {

            }else{

            }
        }
    });
});


$("body").on("click",".delete",function(){
        event.preventDefault();
        var currentRow = $(this).closest("tr");
        let jurusan   =currentRow.find("td:eq(2)").text(); // get current row 2nd TD
       /*  console.log($(this).closest("tr")); */
        var id=$(this).attr("data-id");
        //console.log(id);
        swal.fire({
            title: 'Apakah Anda Yakin?',
            text:"Anda akan menghapus "+jurusan,
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
                    url: jurusanDelete,
                    data: {id:id, _token: token},
                    dataType: "html",
                    success: function (data) {
                        swal.fire({
                            title: "Hapus Data "+jurusan+"<strong> Berhasil!</strong>",
                            text: "",
                            icon: "success"
                        }).then(function(){
                            location.reload();
                        });
                    },
                    error: function (xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
        })
    });
