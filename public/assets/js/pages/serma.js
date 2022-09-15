
    function initAddSerma(){
        initDaterangpicker();
        initNumber();
        initailizeSelectHasil();
        initailizeSelect2();
        initailizeSatuan();
        initAllSelect();
        $("body").on("change", ".selectHasil", function() {
            let idHasil = $(this).val();
            $(this).parents(".wrap").find('.getBarangHasil').val(idHasil);
        });

        $("body").on("change", ".select2_el", function() {
            let idHasil = $(this).val();
            $(this).parents(".wrap").find('.getBahan').val(idHasil);
            $(this).parents(".wrap").find('.satuan_el').html('').append('<option>Pilih Satuan</option>');
        });

        $("body").on("click", ".remove", function() {
            $(this).parents(".input_copy").remove();
        });

        $("body").on("click", ".add-more", function() {
            arrBahan=[];
            $('.getBahan').each(function(i, obj) {
                arrBahan.push(obj.value);
            });
            arrBahan = arrBahan.filter(e => String(e).trim());
            var html = $(".copy-fields").html();
            var rep = html.replace('abc', "input_copy");
            var rep = rep.replace('place_barang', "place_barang-" + num);
            var rep = rep.replace('place_satuan', "place_satuan-" + num);
            var rep = rep.replace('first', "first-" + num);
            var rep = rep.replace('success', "danger");
            var rep = rep.replace('add-more', "remove");
            var rep = rep.replace('plus', "trash");
            $(".core-ans").append(rep);
            console.log(rep);

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

        $("body").on("click", ".remove-hasil", function() {
            $(this).parents(".input_copy-hasil").remove();
        });

        $("body").on("click", ".add-more-hasil", function() {
            arrBarangHasil=[];
            $('.getBarangHasil').each(function(i, obj) {
                arrBarangHasil.push(obj.value);
            });
            arrBarangHasil = arrBarangHasil.filter(e => String(e).trim());
            var html = $(".copy-fields-hasil").html();
            var rep = html.replace('abc', "input_copy_hasil");
            var rep = rep.replace('place_hasil', "place_hasil-" + num);
            var rep = rep.replace('first', "firsthasil-" + num);
            var rep = rep.replace('success', "danger");
            var rep = rep.replace('add-more-hasil', "remove-hasil");
            var rep = rep.replace('plus', "trash");
            $(".core-ans-hasil").append(rep);
            console.log(rep);

            //$(".first-"+num ).remove();

            let select = "<select class='form-control selectHasil ' style='font-size: 15px;' name='hasil[]'><option value=''>Pilih Hasil Praktikum</option></select>";

            $("#place_hasil-" + num).empty();
            $("#place_hasil-" + num).append(select);
            num++;
            initailizeSelectHasil();
        });

      /*   $("form").submit(function(event) {
            $('.hit').each(function(i, obj) {
                if (obj.value <= 0) {
                    Swal.fire({
                        title: "Sisa Tidak Boleh Kosong!",
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
        }); */

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

        $('.AddHasilPraktikum').click(function(){
            initHasilModal();
            initSatuanModal();
            $('.mdlHeaderTitle').text(nmLab);
            $('#ShowAddHasil').modal('show');
        });

        $("body").on("click","#btnMasterAlat",function(){
            let satuan = $('#satuanDefault').val();
            let barang = $('#barang').val();
            let spesifikasi = $('#spesifikasi').val();
            if(barang!="" && satuan!=""){
                $.ajax({
                    type: "POST",
                    url: saveMasterHasil,
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

        $("body").on("click","#btnHasilLab",function(){
            let tm_barang_id = $('#selectAlat').val();
            let jumlah       = $('#jmlh').val();
            if(tm_barang_id!=""){
                $.ajax({
                    type: "POST",
                    url: saveHasilLab,
                    data: { id: tm_barang_id,jumlah:jumlah, _token: token },
                    dataType: "html",
                    success: function(data) {
                        $('#ShowAddHasil').modal('hide');
                        swal.fire({
                            title: "Simpan Data Berhasil!",
                            text: "",
                            icon: "success"
                        }).then(function() {

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


    };

    function initEditSerma() {
        initSatuanHasSelect();
        initDaterangpicker();
        initNumber();
        initailizeSelectHasil();
        initailizeSelect2();
        initailizeSatuan();
        initAllSelect();

        $("body").on("click", ".removeDetail", function() {
            var id = $(this).attr("data-remove");
            var div = $(this).attr("data-div");
            var rid = $(this).attr("data-id");
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
                        url: sisaDetailDelete,
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
    }

    function initAllSelect() {
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

    function initailizeSelectHasil() {
        $(".selectHasil").select2({
            ajax: {
                url: hasilSelect,
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        valBarang: arrBarangHasil,
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

    function initailizeSelect2() {
        $(".select2_el").select2({
            ajax: {
                url: barangSelect,
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    return {
                        searchTerm: params.term,
                        valBarang: arrBahan,
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

    $("body").on("click", ".add-more", function() {
        arrBahan=[];
        $('.getBahan').each(function(i, obj) {
            arrBahan.push(obj.value);
        });
        arrBahan = arrBahan.filter(e => String(e).trim());
        var html = $(".copy-fields").html();
        var rep = html.replace('abc', "input_copy");
        var rep = rep.replace('place_barang', "place_barang-" + num);
        var rep = rep.replace('place_satuan', "place_satuan-" + num);
        var rep = rep.replace('first', "first-" + num);
        var rep = rep.replace('success', "danger");
        var rep = rep.replace('add-more', "remove");
        var rep = rep.replace('plus', "trash");
        $(".core-ans").append(rep);
        console.log(rep);

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

    function initSatuanHasSelect() {
        $(".satuan_has_select").select2({
            ajax: {
                url: satuanSelect,
                type: "get",
                dataType: 'json',
                delay: 250,
                data: function(params) {
                    let valBarang = $(this).parents(".wrap").find('.barang_has_select').val();
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
    }

    function initHasilModal() {
        $("#selectAlat").select2({
            dropdownParent: $('#ShowAddHasil .modal-body'),
            ajax: {
                url: hasilSelectNotIn,
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

    function initSatuanModal() {
        $("#satuanDefault").select2({
            dropdownParent: $('#ShowAddHasil .modal-body'),
            ajax: {
                url: satuanDefault,
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

    function initNumber() {
        $("body").on("keyup", "input.number", function(event) {
            if (event.which != 8 && event.which != 0 && event.which < 48 || event.which > 57) {
                $(this).val(function(index, value) {
                    return value.replace(/\D/g, "");
                });
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
