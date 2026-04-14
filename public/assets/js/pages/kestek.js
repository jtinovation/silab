function initAdd(){
    initDaterangpicker();
    initAllSelect();
    initBarang();
    initAddMore();
    initRemove();
    initArrayBarang();
}

function initEdit(){
    initDaterangpicker();
    initAllSelect();
    initBarang();
    initAddMore();
    initRemove();
    initArrayBarang();
  /*   $('#tanggal').data('daterangepicker').setStartDate(svrStart);
    $('#tanggal').data('daterangepicker').setEndDate(svrEnd); */
    $("body").on("click", ".removeDetail", function() {
        var id = $(this).attr("data-remove");
        var div = $(this).attr("data-div");
        var rid = $(this).attr("data-id");
        url = kestekDetailDelete;

        swal.fire({
            title: 'Yakin, Hapus Barang?',
            text: "Data yang di hapus tidak bisa dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButton: 'btn btn-success',
            cancelButton: 'btn btn-danger ml-2',
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: url,
                    data: { id: id, _token: token },
                    dataType: "html",
                    success: function(data) {
                        swal.fire({
                            title: "Hapus Data Berhasil!",
                            text: "",
                            icon: "success"
                        }).then(function() {
                            //location.reload();
                            console.log(div);
                            $('#'+div).remove();
                            //$(this).parents("#"+div).remove();
                        });
                    },
                    error: function(xhr, ajaxOptions, thrownError) {
                        swal.fire("Error deleting!", "Please try again", "error");
                    }
                });
            }
        })
    });

    $("#BtnBackKestek").click(function(){
        event.preventDefault();
        movePage = $(this).attr("data-move");
        $('.page-edit').hide("slide",{direction:'left'},1000, function(){
            window.location.href = movePage;
        });
        //console.log("test");
    });
}

$("body").on("keyup", "input.number", function(event) {
    if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
        $(this).val(function(index, value) {
            return value.replace(/\D/g, "");
        });
    }
});

new AutoNumeric.multiple('.txtNumeric', { 'digitGroupSeparator': '.', 'decimalCharacter': ',', 'decimalPlaces': '0' });

$("body").on("keyup", ".hit", function() {
    let jml = parseInt($(this).val());
    let stok = $(this).parents(".wrap").find('.stok').val();

    if (jml > stok) {
        Swal.fire({
            title: "Jumlah Terlalu Banyak!",
            icon: "warning",
            text: "Jumlah tidak boleh lebih besar dari stok",
            didClose: () => {
                $(this).val(0);
                $(this).focus();
                $('#btnSubmit').hide();
            }
        });
    }else{
        $('#btnSubmit').show();
    }
});

$("#SelectMinggu").change(function() {
    let selectMinggu = $(this).find(":selected").text();
    let myArray = selectMinggu.split(" ");
    //console.log(myArray[1]);
    let waktu = myArray[1].split("-");
    //console.log(waktu[1]);
    min = waktu[0].replace('(', '');
    max = waktu[1].replace(')', '');
    //console.log(min + " - " + max);

    initDaterangpicker();
});

$("body").on("change", ".select2_el", function() {
    console.log("ubah");
    let idStok = $(this).val();
    let arr = idStok.split("#");
    $(this).parents(".wrap").find('.stok').val(arr[1]);
    console.log(arr[1]);
});

/* $("body").on("click", ".add-more", function() {
    var html = $(".copy-fields").html();
    var rep = html.replace('abc', "input_copy");
    var rep = rep.replace('place_barang', "place_barang-" + num);
    var rep = rep.replace('place_satuan', "place_satuan-" + num);
    var rep = rep.replace('first', "first-" + num);
    var rep = rep.replace('success', "danger");
    var rep = rep.replace('add-more', "remove");
    var rep = rep.replace('plus', "trash");
    $(".core-ans").append(rep);
    //console.log(rep);

    //$(".first-"+num ).remove();

    let select = "<select class='form-control select2_el ' style='font-size: 15px;' name='barang[]'><option value=''>Pilih Barang</option></select>";
    let satuan = "<select class='form-control satuan_el ' style='font-size: 15px;' name='satuan[]'><option value=''>Pilih Satuan</option></select>";

    $("#place_barang-" + num).empty();
    $("#place_satuan-" + num).empty();
    $("#place_barang-" + num).append(select);
    $("#place_satuan-" + num).append(satuan);
    num++;
    initailizeSelect2();
});

$("body").on("click", ".remove", function() {
    $(this).parents(".input_copy").remove();
}); */
/*
function initailizeSelect2() {
    $(".select2_el").select2({
        ajax: {
            url: barangSelect,
            type: "get",
            dataType: 'json',
            delay: 500,
            data: function(params) {
                return {
                    searchTerm: params.term // search term
                };
            },
            processResults: function(r) {
                return {
                    results: r
                };
            },
            cache: true
        }
    });
} */

function initDaterangpicker() {
    $('#tanggal').daterangepicker({
        singleDatePicker: true,
        minDate: min,
        maxDate: max,
        locale: {
            format: 'D/M/Y',
        }
    });
}

$("form").submit(function(event) {

    $('.hit').each(function(i, obj) {
        if (obj.value <= 0) {
            Swal.fire({
                title: "Silahkan Isi Jumlah Kebutuhan!",
                icon: "warning",
                text: "Jumlah Kebutuhan Tidak Boleh Kurang dari atau sama dengan nol",
                didClose: () => {
                    obj.focus();
                }
            });
            event.preventDefault();
        }
    });

    $('.selectBarang').each(function(i, obj) {
        if (obj.value <= 0) {
            Swal.fire({
                title: "Silahkan Pilih Barang!",
                icon: "warning",
                text: "Barang Harus dipilih terlebih dahulu",
                didClose: () => {
                    obj.focus();
                }
            });
            event.preventDefault();
        }
    });

    $('.satuan_el').each(function(i, obj) {
        if (obj.value <= 0) {
            Swal.fire({
                title: "Silahkan Pilih Satuan!",
                icon: "warning",
                text: "Satuan Harus dipilih terlebih dahulu",
                didClose: () => {
                    obj.focus();
                }
            });
            event.preventDefault();
        }
    });





});

function initAllSelect() {
    $("#selectRekomendasi").select2({
        placeholder: "Pilih Rekomendasi Dosen",
        allowClear: true
    });

    $("#SelectMinggu").select2({
        placeholder: "Pilih Minggu Ke",
        allowClear: true
    });

    $("#SelectMinggu").change(function() {
        let selectMinggu = $(this).find(":selected").text();
        let myArray = selectMinggu.split(" ");
        let waktu = myArray[1].split("-");
        min = waktu[0].replace('(', '');
        max = waktu[1].replace(')', '');
        initDaterangpicker();
    });

    $("#selectStaff").select2({
        placeholder: "Pilih Dosen Pengampu",
        allowClear: true
    });

    $("#SelectMK").select2({
        placeholder: "Pilih Matakuliah",
        allowClear: true
    });

    $("#SelectProdi").select2({
        placeholder: "Pilih Program Studi",
        allowClear: true
    });

    $("#SelectTahunAjaran").select2({
        placeholder: "Pilih Tahun Ajaran",
        allowClear: true
    });

    $("#SelectSemester").select2({
        placeholder: "Pilih Semester",
        allowClear: true
    });

    $( "#SelectTahunAjaran" ).change(function() {
        let tahunAjaran= $("#SelectTahunAjaran").val();
        $.ajax({
            url : tahunAjaranSelect,
            type:'GET',
            data:{
                id:tahunAjaran
            },
            dataType: 'json',
            success: function(response) {
                $('#SelectSemester').html('');
                $('#SelectSemester').append('<option></option>');
                $.each(response,function(key, value){
                    $("#SelectSemester").append(
                        $('<option></option>').attr('value', value.id).text(value.nama)
                    );
                });
            }
        });
    });

    $('#SelectSemester').change(function(){
        $(".core-ans").empty();
        let id=$(this).val();
        let prodi= $('#SelectProdi option:selected').val();
        console.log(prodi+" "+id);
        $.ajax({
            url :  getMK,
            method : "GET",
            data : {id: id, prodi: prodi},
            async : true,
            dataType: 'json',
            success: function(response){
                $('#SelectMK').html('');
                $('#SelectMK').append('<option></option>');
                $('#selectStaff').html('');
                $('#selectStaff').append('<option></option>');
                if ($.trim(response) == '' ) {
                    console.log("no data found");
                    //$("#txtMatakuliahId").prop('selectedIndex',-1);
                }else{
                    $.each(response,function(key, value){
                        $("#SelectMK").append(
                            $('<option></option>').attr('value', value.id).text(value.mk)
                        );
                    });
                }
            }
        });
    });

    $('#SelectProdi').change(function(){
        $(".core-ans").empty();
        let id=$('#SelectSemester option:selected').val();
        let prodi= $(this).val();
        console.log(prodi+" "+id);
        $.ajax({
            url : getMK,
            method : "GET",
            data : {id: id, prodi: prodi},
            async : true,
            dataType: 'json',
            success: function(response){
                $('#SelectMK').html('');
                $('#SelectMK').append('<option></option>');
                $('#selectStaff').html('');
                $('#selectStaff').append('<option></option>');
                if ($.trim(response) == '' ) {
                    console.log("no data found");
                    //$("#txtMatakuliahId").prop('selectedIndex',-1);
                }else{
                    $.each(response,function(key, value){
                        $("#SelectMK").append(
                            $('<option></option>').attr('value', value.id).text(value.mk)
                            );
                    });
                }
            }
        });
    });

    $("#SelectMK" ).change(function() {
        let mk= $("#SelectMK").val();
        $.ajax({
            url : getPengampu,
            type:'GET',
            data:{
                id:mk
            },
            dataType: 'json',
            success: function(response) {
                $('#selectStaff').html('');
                $('#selectStaff').append('<option></option>');
                $.each(response,function(key, value){
                    $("#selectStaff").append(
                        $('<option></option>').attr('value', value.id).text(value.nama)
                    );
                });
            }
        });
    });

}

function initArrayBarang(){
    arrBarang=[];
    $('.getBarang').each(function(i, obj) {
        arrBarang.push(obj.value);
    });
    arrBarang = arrBarang.filter(e => String(e).trim());
    console.log(arrBarang);
}

function initAddMore(){
    $("body").on("click", ".add-more", function() {
        initArrayBarang();

        var html = $(".copy-fields").html();
        var rep = html.replace('abc', "input_copy");
        var rep = rep.replace('place_barang', "place_barang-" + num);
        var rep = rep.replace('place_satuan', "place_satuan-" + num);
        var rep = rep.replace('first', "first-" + num);
        var rep = rep.replace('success', "danger");
        var rep = rep.replace('add-more', "remove");
        var rep = rep.replace('selectBarang', "selectBarang");
        var rep = rep.replace('hhh', "hit");
        var rep = rep.replace('sss', "satuan_el");
        var rep = rep.replace('xxa', "required");
        var rep = rep.replace('xxb', "required");
        var rep = rep.replace('plus', "trash");
        $(".core-ans").append(rep);
        console.log(rep);

        //$(".first-"+num ).remove();

        let select = "<select class='form-control selectBarang ' style='font-size: 15px;' name='barang[]'><option value=''>Pilih Barang</option></select>";
        let satuan = "<select class='form-control satuan_el ' style='font-size: 15px;' name='satuan[]'><option value=''>Pilih Satuan</option></select>";

        $("#place_barang-" + num).empty();
        $("#place_satuan-" + num).empty();
        $("#place_barang-" + num).append(select);
        $("#place_satuan-" + num).append(satuan);
        num++;
        initBarang();
    });
}

function initRemove(){
    $("body").on("click", ".remove", function() {
        $(this).parents(".input_copy").remove();
    });
}

function initBarang() {
    $(".selectBarang").select2({
        ajax: {
            url: saranaLabSelect,
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                return {
                    searchTerm: params.term,
                    valBarang: arrBarang,
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

    $(".satuan_el").select2({
        ajax: {
            url: satuanSelect,
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                let valBarang = $(this).parents(".wrap").find('.getBarang').val();
                //console.log(valBarang);
                return {
                    searchTerm: params.term,
                    valBarang: valBarang,
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

    $(".satuan_els").select2({
        ajax: {
            url: satuanSelect,
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                let valBarang = $(this).parents(".wrap").find('.getBarang').val();
                console.log(valBarang);
                return {
                    searchTerm: params.term,
                    valBarang: valBarang,
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

    $("body").on("change", ".selectBarang", function() {
        //console.log("ubah");
        let idStok = $(this).val();
        let arr = idStok.split("#");
        $(this).parents(".wrap").find('.stok').val(arr[1]);
        $(this).parents(".wrap").find('.getBarang').val(arr[0]);
        let hit = $(this).parents(".wrap").find('.hit').val();
        let intStok = parseInt(arr[1]);
        let intHit = parseInt(hit);
        if(intHit > intStok){
            $(this).parents(".wrap").find('.hit').val("0");
        }
        //console.log(arr[0]);
        initArrayBarang();
    });

    $("body").on("change", ".satuan_el", function() {
        //console.log("ubah");
        let idStok = $(this).val();
        let arr = idStok.split("#");
        $(this).parents(".wrap").find('.stok').val(arr[0]);
        let hit = $(this).parents(".wrap").find('.hit').val();
        let intStok = parseInt(arr[0]);
        let intHit = parseInt(hit);
        if(intHit > intStok){
            $(this).parents(".wrap").find('.hit').val("0");
        }
        //$(this).parents(".wrap").find('.getBarang').val(arr[0]);
        //console.log(hit);
        //initArrayBarang();
    });

    $("body").on("change", ".satuan_els", function() {
        //console.log("ubah");
        let idStok = $(this).val();
        let arr = idStok.split("#");
        let stok = $(this).parents(".wrap").find('.stok').val(arr[0]);
        let stok_ori = $(this).parents(".wrap").find('.stok').attr("data-val-ori");
        let satuanQty = arr[2];
        let satuanStok = Math.floor(stok_ori / satuanQty);
        $(this).parents(".wrap").find('.stok').val(satuanStok);
        let hit = $(this).parents(".wrap").find('.hit').val();
        let intStok = parseInt(arr[0]);
        let intHit = parseInt(hit);
        if(intHit > intStok){
            $(this).parents(".wrap").find('.hit').val("0");
        }

        //console.log(stok_ori+"/"+satuanQty+"="+satuanStok);
    });

}
