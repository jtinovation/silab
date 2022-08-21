$("#SelectJurusan").select2({
    placeholder: "Pilih Jurusan",
    allowClear: true
});

$("#SelectKaLab").select2({
    placeholder: "Pilih Ka.Lab",
    allowClear: true
});

$("#SelectTeknisi").select2({
    placeholder: "Pilih Teknisi",
    allowClear: true
});

$('#tableLab').DataTable({
    responsive:true,
    processing: true,
    serverSide: true,
    ajax: getLab,
    columns: [
        { data: 'id' },
        { data: 'kode' },
        { data: 'laboratorium' },
        { data: 'kalab' },
        /* { data: 'is_aktif' }, */
        { data: 'action' },
    ]
});

var tableMember = $('#tblAllInOneProdi').DataTable({
    ordering:false,
    paging:false,
    searching: false,
    "ajax" : url,
});

$('.tableElementMember').hide("slide",{direction:'up'},900);

$("#BtnAddLaboratorium").click(function() {

    event.preventDefault();

     $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.formElement').show("slide",{direction:'left'},1000);
        document.getElementById("frmLaboratorium").action = act
    });
    $("#btnSubmit").html('Simpan Data Laboratorium');
    $("#btnCancel").html('Batal Tambah Laboratorium');
    //console.log(urlProdi);
});

$("#btnCancel").click(function() {
    $('.formElement').hide("slide",{direction:'left'},1000, function(){
        $('.tableElement').show("slide",{direction:'left'},1000);
    });
    $('#kodelaboratorium').val("");
    $('#laboratorium').val("");
    $('#memberid').val("");
    $('#SelectKaLab').val("");
    $('#SelectKaLab').select2().trigger('change');
    $('#SelectJurusan').val("");
    $('#SelectJurusan').select2().trigger('change');
})

$("body").on("click",".btnEditClass",function(){
    event.preventDefault();
    var kode = $(this).attr("data-kode");
    var laboratorium = $(this).attr("data-laboratorium");
    var staff = $(this).attr("data-staff");
    var jurusan = $(this).attr("data-jurusan");
    var memberid = $(this).attr("data-memberid");
    let dataUpdate=$(this).attr("data-update");
    $('#kodelaboratorium').val(kode);
    $('#laboratorium').val(laboratorium);
    $('#memberid').val(memberid);
    $('#SelectKaLab').val(staff);
    $('#SelectKaLab').select2().trigger('change');
    $('#SelectJurusan').val(jurusan);
    $('#SelectJurusan').select2().trigger('change');
    $('#metod').val("PUT");
    var act = dataUpdate;
    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.formElement').show("slide",{direction:'left'},1000);
        document.getElementById("frmLaboratorium").action = act;
    });
    $("#btnSubmit").html('Ubah Data Laboratorium');
    $("#btnCancel").html('Batal Ubah Laboratorium');
});

$("body").on("click",".btnDetailClass",function(){
    let kode = $(this).attr("data-kode");
    let laboratorium = $(this).attr("data-laboratorium");
    let titlekode = laboratorium+" ( "+kode+" ) ";
    let id=$(this).attr("data-val");

    idlab = id;
    //$(".header-title-prodi").text(tm_jurusan_title);
    $(".header-title-member").text(titlekode);
    let url = urlMember+"/"+id;
    //console.log(url);
    //table.ajax.reload();
    tableMember.ajax.url(url).load();
    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        $('.tableElementMember').show("slide",{direction:'left'},1000);
        //document.getElementById("frmJurusan").action = actEdit;
    });
});

$("#BtnAddMemberLab").click(function() {
    event.preventDefault();
    mode = "add";
     $('.tableElementMember').hide("slide",{direction:'left'},1000, function(){
        $('.formElementMember').show("slide",{direction:'left'},1000);
        document.getElementById("frmMember").action = "";
    });
    $('#txtProdiKode').val("");
    $('#txtProgramStudiTitle').val("");
    $('#txtIdProgramStudi').val("");

    $("#btnSubmitMember").html('Simpan Data Teknisi');
    $("#btnCancelMember").html('Batal Tambah Teknisi');
});

$("#btnSubmitMember").click(function(){
    event.preventDefault();
    if(mode=="add"){
        let tm_staff_id = $('#SelectTeknisi').val();
        console.log(tm_staff_id);
        var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            method: "POST",
            url: memberstore,
            data: { labid: idlab, staff: tm_staff_id, _token: token}
        })
            .done(function( msg ) {
            //alert( "Data Saved: " + msg );
            //Swal.fire(msg);
            Swal.fire({
                type: 'success',
                title: 'Berhasil',
                text: 'Data Teknisi Berhasil Di Simpan',
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



    $('#SelectTeknisi').val("");
    $('#SelectTeknisi').select2().trigger('change');
    let jurlid = urlMember+"/"+idlab;
    tableMember.ajax.url(jurlid).load();
    $('.formElementMember').hide("slide",{direction:'left'},1000, function(){
        $('.tableElementMember').show("slide",{direction:'left'},1000);
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

    $('.tableElementMember').hide("slide",{direction:'left'},1000, function(){
        $('.formElementMember').show("slide",{direction:'left'},1000);
    });
    $("#btnSubmitMember").html('Ubah Data Program Studi');
    $("#btnSubmitMember").html('Batal Ubah Program Studi');
});

$("#BtnBackProdi").click(function(){
    event.preventDefault();
    $('.tableElementMember').hide("slide",{direction:'left'},1000, function(){
        $('.tableElement').show("slide",{direction:'left'},1000);
    });
    //console.log("test");
});

$("#btnSubmitMember").click(function() {
    $('.formElementMember').hide("slide",{direction:'left'},1000, function(){
        $('.tableElementMember').show("slide",{direction:'left'},1000);
    });
    $('#txtProdiKode').val("");
    $('#txtProgramStudiTitle').val("");
    $('#txttm_program_studi_id').val("");
});

$("body").on("click",".btnDeleteClassMember",function(){
    event.preventDefault();
    var currentRow = $(this).closest("tr");
    let tm_program_studi_title   =currentRow.find("td:eq(0)").text(); // get current row 2nd TD
    var id=$(this).attr("data-val");
    //console.log(id);
    swal.fire({
        title: 'Hapus Data Teknisi?',
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
                url: memberDelete,
                data: {id:id, _token: token},
                dataType: "html",
                success: function (data) {
                    swal.fire({
                        title: "Hapus Data Berhasil!",
                        text: "",
                        icon: "success"
                    }).then(function(){
                        let jurlid = urlMember+"/"+idlab;
                        tableMember.ajax.url(jurlid).load();

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
