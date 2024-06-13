function initBarang(){
    let url = urlTableBarang+"/"+id;
    tableBarang = $('#tableBarang').DataTable({
        ordering:false,
        paging:false,
        searching: false,
        "ajax" : url,
        columns: [
            { data: 'id'},
            { data: 'nama'},
            { data: 'satuan'},
            { data: 'qty',},
            { data: 'jb',}
        ],
        createdRow: function( row, data, dataIndex ) {
            $(row).addClass( 'detailBarang' );
        }
    });
}

$("body").on("click","#BtnAddMinggu",function(){
    $('.tableBarangElement').hide("slide",{direction:'up'},900);
});

$("body").on("click",".detailBarang",function(){
    idDetail = $(this).attr("id");
    var currentRow = $(this).closest("tr");
    let barang   =currentRow.find("td:eq(1)").text();
    let url = urlDetailBarang+"/"+idDetail;
    console.log(barang);
    $.getJSON(url, function(response) {
        chart.updateSeries([{
          name: 'Sales',
          data: response
        }])
      });
      $('.modal-title').text("Detail Data "+barang);
      $('#showDetailBarang').modal('show');
});

$("body").on("click",".jenisbarang",function(){
    id=$(this).attr("data-id");
    //idjur = id;
    //$(".header-title-prodi").text(tm_jurusan_title);
    //$(".header-title-prodi").text(titlekode);
    let url = urlTableBarang+"/"+id;

    tableBarang.ajax.url(url).load();
  //  $('.tableBarangElement').show("slide",{direction:'up'},900);
    $('.tableBarangElement').hide("slide",{direction:'up'},1000, function(){
        $('.tableBarangElement').show("slide",{direction:'up'},1000);
        //document.getElementById("frmJurusan").action = actEdit;
    });
});

$("body").on("click",".laboratorium",function(){
    event.preventDefault();
    let pageMove =$(this).attr("data-href");
    $(this).hide("slide",{direction:'left'},1000, function(){
        window.location.href=pageMove
    });
});


options = {
    series: [],
    theme: {
        palette: 'palette1' // upto palette10
    },
    chart: {
        height: 350,
        type: 'bar',
    },
    dataLabels: {
      enabled: false
    },
    noData: {
      text: 'Loading...'
    },
    xaxis: {
      type: 'category',
      tickPlacement: 'on',
      labels: {
        rotate: -45,
        rotateAlways: true,
      }
    }
    };

    chart = new ApexCharts(document.querySelector("#test"), options);
    chart.render();
