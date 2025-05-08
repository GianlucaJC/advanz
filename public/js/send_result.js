ismobile=false

$(document).ready( function () {
  
  if(/Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent))
    ismobile=true
  else
    ismobile=false
  
    $('.decimal').keydown(function (e) {
      //Get the occurence of decimal operator
      var match = $(this).val().match(/\./g);
      if(match!=null){
        // Allow: backspace, delete, tab, escape and enter 
        if ($.inArray(e.keyCode, [46,8, 9, 27, 13, 110]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
          // let it happen, don't do anything
          return;
        }  // Ensure that it is a number and stop the keypress
        else if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105 )&&(e.keyCode==190)) {
          e.preventDefault();
        }
      }
      else{
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
          // let it happen, don't do anything
          return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
          e.preventDefault();
        }
      }
    });
    //Allow Upto Two decimal places value only
    $('.decimal').keyup(function () {
      if ($(this).val().indexOf('.') != -1) {
        if ($(this).val().split(".")[1].length > 2) {
          if (isNaN(parseFloat(this.value))) return;
          this.value = parseFloat(this.value).toFixed(2);
        }
      }
    });
   set_decimal()    
   set_table()
})

  function set_decimal() {
    $('.decimal').keydown(function (e) {
      //Get the occurence of decimal operator
      var match = $(this).val().match(/\./g);
      if(match!=null){
        // Allow: backspace, delete, tab, escape and enter 
        if ($.inArray(e.keyCode, [46,8, 9, 27, 13, 110]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
          // let it happen, don't do anything
          return;
        }  // Ensure that it is a number and stop the keypress
        else if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105 )&&(e.keyCode==190)) {
          e.preventDefault();
        }
      }
      else{
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
            // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
            // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
          // let it happen, don't do anything
          return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
          e.preventDefault();
        }
      }
    });
    //Allow Upto Two decimal places value only
    $('.decimal').keyup(function () {
      if ($(this).val().indexOf('.') != -1) {
        if ($(this).val().split(".")[1].length > 2) {
          if (isNaN(parseFloat(this.value))) return;
          this.value = parseFloat(this.value).toFixed(2);
        }
      }
    });    
  }


  function delete_up(id_up) {
    if (!confirm('Are you sure?')) return false;

    let CSRF_TOKEN = $("#token_csrf").val();
    $("#spin"+id_up).show(100)
    base_path = $("#url").val();

    timer = setTimeout(function() {	
      fetch(base_path+"/delete_up", {
          method: 'post',
          headers: {
            "Content-type": "application/x-www-form-urlencoded; charset=UTF-8"
          },
          body: "_token="+ CSRF_TOKEN+"&id_up="+id_up,
      })
      .then(response => {
          if (response.ok) {
            return response.json();
          }
      })
      .then(resp=>{
          $("#spin"+id_up).hide(100)
          if (resp.header=="OK") {
            var rowid = '#row_'+id_up;
            $('#tbl_articoli tbody').find(rowid).remove();
            $(".divup"+id_up).remove()
          }
          else {
            alert("Error occurred while deleting file")
          }

      })
      .catch(status, err => {
          return console.log(status, err);
      })     

    }, 800)	    
  }
  
  function set_table() {
    scroll=false;
    if (ismobile==true)  scroll=true
/*
  $('#tbl_articoli tfoot th').each(function () {
      var title = $(this).text();
      if (title.length!=0) {
        style='style="max-width:80px;"'
        if (title=="ID") style='style="max-width:30px;"'
              placeholder="' + title + '"
        $(this).html('<input class="form-control" '+style+' type="text"  />');
      }
  });
*/
  var table =$('#tbl_articoli').DataTable({
    pageLength: 10,
    "scrollX": scroll,
    pagingType: 'full_numbers',
    dom: 'Bfrtip',
    buttons: [
      'excel'
    ],		
    

// #column3_search is a <input type="text"> element
  
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

    $('#tbl_articoli thead th').each( function () {
        var title = $(this).text();
        if (title.length!=0) {
            
          $(this).html( title+'<br><input type="text" class="form-control" placeholder="Search" />' );
        }
    } );

    // Apply the search
    table.columns().every( function () {
        var that = this;
        $( 'input', this.header() ).on( 'keyup change clear', function () {
            if ( that.search() !== this.value ) {
                that
                    .search( this.value )
                    .draw();
            }
        } );
    } );    
}

function set_um(value) {
  lbl="Test results (MIC ug/ml)*"
  if (value=="ds")
    lbl="Test results (mm)*"
  $("label[for*='test_result']").html(lbl);
}

