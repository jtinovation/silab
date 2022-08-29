$('#tableAlat').DataTable({
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
    });
});
$("body").on("click",".btnEditClass",function(){
    event.preventDefault();
    let pageEdit =$(this).attr("data-href");
    $('.tableElement').hide("slide",{direction:'left'},1000, function(){
        window.location.href = pageEdit;
    });
});

$('.AddAlat').click(function(){
    initailizeSelect2();
    initailizeSatuan();
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


