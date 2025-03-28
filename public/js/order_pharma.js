ismobile=false


function LoadGoogle(){
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
$(document).ready( function () {
  LoadGoogle();

  if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
    ismobile=true
  else
    ismobile=false
  
   set_table()
})

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


