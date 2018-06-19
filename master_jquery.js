/**
 * Function to capture the ajax event
 */
$(document).ajaxSend(function () {

    waiting();
}).ajaxStop(function () {

    not_waiting();
});
/**
 * Function to get a product by id
 */
function consult()
{
  var id      = parseInt($("#productId").val()) || 0;
  var urlAjax = "master_query.php?product_id="+id;
  $("#result").empty();

  var datalist = [];
  $.getJSON(urlAjax, function(result) {

        if(result.success) {

          var table = $('<table id="table_set">').addClass('foo');
          $('#result').append(table);

          var t = {
           'id': 'table_set',
           'header':[{'a': 'Product', 'b' : 'Price', 'c':'Action'}],
           'data': [{ a: result.name, b: result.price, c: '<button onclick="delete_id('+result.id+')">Eliminar </button>' }]
          };

          feed_table(t);
        } else {
          $("#result").append('<strong>'+result.message+'</strong>');
        }
  });

}
/**
 * Function to get all records from db
 */
function get_all()
{
  var urlAjax = "master_query.php?get_all=true";

  $("#result").empty();

  $.getJSON(urlAjax, function(result) {

    if(result.message) {

      $("#result").append('<strong>'+result.message+'</strong>');

    } else {

      var datalist = [];

      $.each(result, function(i, item) {

          datalist.push({a: result[i].name, b: result[i].price, c:'<button onclick="delete_id('+result[i].id+')">Eliminar </button>' });

      });

      var table = $('<table id="table_set">').addClass('foo');
      $('#result').append(table);

      var t = {
       'id': 'table_set',
       'header':[{'a': 'Product', 'b' : 'Price', 'c':'Action'}],
       'data': datalist
      };

      feed_table(t);

    }

  });

}
/**
 * Function to delete a records from db
 */
function delete_id(id)
{
 var urlAjax = "master_query.php?delete_id="+id;

 if(confirm('Sure to delete this product ?'))
 {
   $.ajax({
     url: urlAjax,
     cache: false,
     success: function(data) {

       $("#result").empty();
       $("#result").append('<strong> Product deleted </strong>');

     }

   });

 }

}
/**
 * Function to render a table with records json data
 */
function feed_table(tableobj)
{
  $('#' + tableobj.id).html( '' );

  $.each([tableobj.header, tableobj.data], function(_index, _obj){

    $.each(_obj, function(index, row){
        var line = "";
        $.each(row, function(key, value){
            if(0 === _index) {
                line += '<th>' + value + '</th>';
            } else {
                line += '<td>' + value + '</td>';
            }
        });
        line = '<tr>' + line + '</tr>';
        $('#' + tableobj.id).append(line);
    });

  });
}
/**
 * Function to show waiting
 */
function waiting() {

  $("#result").append('<div id="waiting"> Cargando ... </strong>');
}
/**
 * Function to hide waiting
 */
function not_waiting() {

  $("#waiting").hide();
}
