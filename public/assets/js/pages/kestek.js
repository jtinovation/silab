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
    let jml_kel = parseInt($('#jml_kel').val());
    let jml_gol = parseInt($('#jml_gol').val());
    let keb_kel = parseInt($(this).val());
    if (jml_kel <= 0) {
        /*  swal.fire("Jumlah Kelompok Tidak Boleh Kosong!", "Silahkan Isi Jumlah Kelompok", "warning");
         */
        Swal.fire({
            title: "Jumlah Kelompok Tidak Boleh Kosong!",
            icon: "warning",
            text: "Silahkan Isi Jumlah Kelompok",
            didClose: () => {
                $('#jml_kel').focus();
            }
        })

    } else {
        let Jumlah = jml_kel * keb_kel * jml_gol;
        $(this).parents(".wrap").find('.jmltotalqty').val(Jumlah);
        //console.log($(this).parents(".wrap").find('.jml_total').val());
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
    initailizeSatuan();
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
    $(".satuan_el").select2({
        ajax: {
            url: satuanSelect,
            type: "get",
            dataType: 'json',
            delay: 250,
            data: function(params) {
                let valBarang = $(this).parents(".wrap").find('.select2_el').val();
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
    if ($("#jml_kel").val() <= 0) {
        Swal.fire({
            title: "Jumlah Kelompok Tidak Boleh Kosong!",
            icon: "warning",
            text: "Silahkan Isi Jumlah Kelompok",
            didClose: () => {
                $('#jml_kel').focus();
            }
        })
        event.preventDefault();
    }

    $('.hit').each(function(i, obj) {
        if (obj.value <= 0) {
            Swal.fire({
                title: "Silahkan Isi Kebutuhan Kelompok!",
                icon: "warning",
                text: "Jumlah Kebutuhan Kelompok Tidak Boleh Kurang dari atau sama dengan nol",
                didClose: () => {
                    obj.focus();
                }
            });
            event.preventDefault();
        }
    });

    $('.select2_el').each(function(i, obj) {
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

    $('.select2_el').each(function(i, obj) {
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
