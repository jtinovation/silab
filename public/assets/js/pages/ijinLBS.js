
function initIndex(){
    initTable();
    $("body").on("click",".btnEditClass",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = pageEdit;
        });
    });

    $("body").on("click",".btnKembaliClass",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = pageEdit;
        });
    });

    $("body").on("click",".btnDetailClass",function(){
        event.preventDefault();
        let pageEdit =$(this).attr("data-href");
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = pageEdit;
        });
    });

    $("body").on("click","#BtnAddIjinLBS",function(){
        event.preventDefault();
        let pageMove =$(this).attr("data-href");
        $('.tableElement').hide("slide",{direction:'left'},1000, function(){
            window.location.href = pageMove;
        });
    });

    $("body").on("click", ".delete", function() {
        event.preventDefault();
        var id = $(this).attr("data-id");
        swal.fire({
            title: 'Yakin, Hapus Data Bon Alat?',
            text: "Data yang di hapus tidak bisa dikembalikan",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger ml-2',
            confirmButtonText: 'Yes, delete it!'
        }).then(function(result) {
            if (result.value) {
                var CSRF_TOKEN = $('meta[name="csrf-token"]').attr('content');
                $.ajax({
                    type: "POST",
                    url: bonAlatDelete,
                    data: { id: id, _token: token },
                    dataType: "html",
                    success: function(data) {
                        swal.fire({
                            title: "Hapus Data Berhasil!",
                            text: "",
                            icon: "success"
                        }).then(function() {
                            location.reload();
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

function initAdd(){
    initStartDate();
    initSelect2();
    initBarang();
    initAddMore();
    initRemove();
    initArrayBarang();
    initCP();
}

function initTable(){
    var tableIjinLBS = $('#tableIjinLBS').DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        pageLength: 16,
        ajax: getBonAlat,
        columns: [
            { data: 'id' },
            { data: 'nm' },
            { data: 'tglMulai' },
            { data: 'tglAkhir' },
            { data: 'status' },
            { data: 'action' },
        ]
    });
}

function initStartDate() {
    $('#tanggal').daterangepicker({
        locale: {
            format: 'D/M/Y',
        }
    });
}

function initSelect2(){
    $("#tm_staff_id_pembimbing").select2({
        placeholder: "Pilih Dosen Pembimbing",
        allowClear: true
    });

    $("#tm_program_studi_id").select2({
        placeholder: "Pilih Program Studi",
        allowClear: true
    });

    $("#SelectStaff").select2({
        placeholder: "Pilih Pegawai",
        allowClear: true
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
                let valBarang = $(this).parents(".wrap").find('.selectBarang').val();
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

    $("body").on("change", ".selectBarang", function() {
        //console.log("ubah");
        let idStok = $(this).val();
        let arr = idStok.split("#");
        $(this).parents(".wrap").find('.stok').val(arr[1]);
        $(this).parents(".wrap").find('.getBarang').val(arr[0]);
        //console.log(arr[0]);
        initArrayBarang();
    });

    $("body").on("change", ".satuan_el", function() {
        //console.log("ubah");
        let idStok = $(this).val();
        let arr = idStok.split("#");
        $(this).parents(".wrap").find('.stok').val(arr[0]);
        //$(this).parents(".wrap").find('.getBarang').val(arr[0]);
        //console.log(arr[0]);
        //initArrayBarang();
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

function initCP(){
    $(".cp").change(function(){
        let val = parseInt($(".cp:checked").val());
        if(val){
            $('.mahasiswa').hide("slide", { direction: 'down' }, 1000, function() {
                $('.pegawai').show("slide", { direction: 'down' }, 1000);
            });
            $("#SelectStaff").attr('required', true);
            $("#nim").attr('required', false);
            $("#nama").attr('required', false);
            $("#tm_program_studi_id").attr('required', false);
            $("#tm_staff_id_pembimbing").attr('required', false);
            //console.log("Pegawai");
        }else{
            $('.pegawai').hide("slide", { direction: 'down' }, 1000, function() {
                $('.mahasiswa').show("slide", { direction: 'down' }, 1000);
            });
            $("#SelectStaff").attr('required', false);
            $("#nim").attr('required', true);
            $("#nama").attr('required', true);
            $("#tm_program_studi_id").attr('required', true);
            $("#tm_staff_id_pembimbing").attr('required', true);
            //console.log("Mahasiswa");
        }
    });
}
