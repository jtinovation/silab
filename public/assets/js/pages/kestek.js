$("#SelectMinggu").select2({
    placeholder: "Pilih Minggu Ke",
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
}



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

    $('.jml').each(function(i, obj) {
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




});
