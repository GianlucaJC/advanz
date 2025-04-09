ismobile=false

$(document).ready( function () {
  LoadGoogle();

  if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
    ismobile=true
  else
    ismobile=false
  
   set_table()
})



  function stat() {
    let CSRF_TOKEN = $("#token_csrf").val();
    base_path = $("#url").val();

    timer = setTimeout(function() {	
      fetch(base_path+"/stat", {
          method: 'post',
          headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
          },
          body: "_token="+ CSRF_TOKEN+"&id=1"
      })
      .then(response => {
          if (response.ok) {
            return response.json();
          }
      })
      .then(obj=>{        
        //grafico GEO
        title=obj['stat_gen']['title'];
        dati=obj['stat_gen']['data'];
        var data = google.visualization.arrayToDataTable(dati);
        var options = {
          sizeAxis: { minValue: 0, maxValue: 100 },
          region: '150', // Western Europe
       
        };

        var chart = new google.visualization.GeoChart(document.getElementById('regions_div'));
        var container = document.getElementById('regions_div');
        if (container) container.style.display = 'block';
        chart.draw(data, options);

        //Grafico istogrammi
        // Set Options
        var options = {
          title: title
        };        
        var data = google.visualization.arrayToDataTable(dati);
        // Draw1
        var chart = new google.visualization.BarChart(document.getElementById('myChart1'));
        chart.draw(data, options);

      })
      .catch(status, err => {
          return console.log(status, err);
      })     

    }, 800)	    


  }

function LoadGoogle() {
  google.charts.load('current', {'packages':['corechart','table','geochart']});
  stat();
}

function LoadGoogle_old(){
  google.charts.load('current', {
    callback: drawChart,
    packages:['corechart']
  });




  function drawChart() {

    // Set Data
    const data = google.visualization.arrayToDataTable([
      ['Country', 'Units'],      
      ['France', 60],
      ['Austria',55],
      ['Denmark',49],
      ['Germany',44],
      ['Ireland',24],
      ['Spain',15],
      ['United Kingdom',10]
    ]);
    
    // Set Options
    const options = {
      title:'Orders 2025'
    };
    
    // Draw1
    const chart = new google.visualization.BarChart(document.getElementById('myChart1'));
    chart.draw(data, options);

    //Image 2

    // Set Data
    const data1 = google.visualization.arrayToDataTable([
      ['', 'Units'],
      ['Ceftobiprole ',20],
      ['Dalbavancin ',15],
      ['Cefepime/Enmetazobactam',18],
    ]);

    // Set Options
    const options1 = {
      title:'',
      is3D:true
    };

    // Draw
    const chart1 = new google.visualization.PieChart(document.getElementById('myChart2'));
    chart1.draw(data1, options1);

    
    }
   
} 

function check_choice(id_molecola,id,value) {
    $(".molecola"+id_molecola).prop('disabled',false);
    $(".molecola"+id_molecola).val('')
    if (value.length>0) {
      $(".molecola"+id_molecola).prop('disabled',true);
      $("#"+id).prop('disabled',false);
      $("#"+id).val(value)
    }
  
    
  }

  
  function set_table() {
    scroll=false;
    if (ismobile==true)  scroll=true
      

    $('#tbl_order tfoot th').each(function () {
        var title = $(this).text();
		if (title.length!=0) {
			style='style="max-width:80px;"'
			if (title=="ID") style='style="max-width:30px;"'
            placeholder="' + title + '"
			$(this).html('<input class="form-control" '+style+' type="text"  />');
		}
    });	
        
    $('#tbl_articoli, #tbl_order').DataTable({
    order: [[0, 'desc']],
    pageLength: 10,
    "scrollX": scroll,
    pagingType: 'full_numbers',
    dom: 'Bfrtip',
    buttons: [
      'excel'
    ],		
     		
        initComplete: function () {
            // Apply the search
            this.api()
                .columns()
                .every(function () {
                    var that = this;
 
                    $('input', this.footer()).on('keyup change clear', function () {
                        if (that.search() !== this.value) {
                            that.search(this.value).draw();
                        }
                    });
                });
        },    
      /*
      language: {
          lengthMenu: 'Visualizza _MENU_ records per pagina',
          zeroRecords: 'Nessuna urgenza trovata',
          info: 'Pagina _PAGE_ di _PAGES_',
          infoEmpty: 'Non sono disponibili urgenze',
          infoFiltered: '(Filtrati da _MAX_ urgenze totali)',
      },
      */
  });	
    
}


