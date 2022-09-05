$(".cp").change(function(){
    let val = parseInt($(".cp:checked").val());
    if(val){
        $('.mahasiswa').hide("slide", { direction: 'down' }, 1000, function() {
            $('.pegawai').show("slide", { direction: 'down' }, 1000);
        });
      /*   $(".mahasiswa").hide();
        $(".pegawai").show(); */
        $("#SelectStaff").attr('required', true);
        $("#nim").attr('required', false);
        $("#nama").attr('required', false);
        $("#gol").attr('required', false);
        console.log("Pegawai");
    }else{
        $('.pegawai').hide("slide", { direction: 'down' }, 1000, function() {
            $('.mahasiswa').show("slide", { direction: 'down' }, 1000);
        });
      /*   $(".pegawai").hide();
        $(".mahasiswa").show(); */
        $("#SelectStaff").attr('required', false);
        $("#nim").attr('required', true);
        $("#nama").attr('required', true);
        $("#gol").attr('required', true);
        console.log("Mahasiswa");
    }
});

$("#SelectStaff").select2({
    placeholder: "Pilih Pegawai",
    allowClear: true
});

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

$("body").on("change", ".select2_el", function() {
    console.log("ubah");
    let idStok = $(this).val();
    let arr = idStok.split("#");
    $(this).parents(".wrap").find('.stok').val(arr[1]);
    console.log(arr[1]);
});

$("body").on("click", ".add-more", function() {
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
});

function initailizeSelect2() {
    $(".select2_el").select2({
        ajax: {
            url: alatLabSelect,
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
}




function initDaterangpicker() {
    $('#tanggalPinjam').daterangepicker({
        singleDatePicker: true,
        timePicker:true,
        timePicker24Hour: true,
        locale: {
            format: 'D/M/Y H:mm',
        }
    });
}

$("form").submit(function(event) {
    $('.hit').each(function(i, obj) {
        if (obj.value <= 0) {
            Swal.fire({
                title: "Jumlah Tidak Boleh Kosong!",
                icon: "warning",
                text: "Jumlah Harus Di isi",
                didClose: () => {
                    obj.focus();
                }
            });
            event.preventDefault();
        }
    });

    $('.select2_el').each(function(i, obj) {
        console.log(obj.value);
        if (obj.value == " ") {
            Swal.fire({
                title: "Silahkan Pilih alat!",
                icon: "warning",
                text: "Data Alat Harus dipilih terlebih dahulu",
                didClose: () => {
                    obj.focus();
                }
            });
            event.preventDefault();
        }
    });

});
