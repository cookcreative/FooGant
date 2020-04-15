<?php
//include "foogantt.php";
?>
<!DOCTYPE html>
      <html lang="en">
          <head>
              <title>FooGantt</title>
              <meta charset="utf-8">
              <meta http-equiv="X-UA-Compatible" content="IE=Edge;chrome=IE8">
              <meta name="viewport" content="width=device-width, initial-scale=1">
              <link href="css/bootstrap.min.css" rel="stylesheet" type="text/css">
              <link href="css/bootstrap-reboot.min.css" rel="stylesheet" type="text/css">
              <link href="css/bootstrap-grid.min.css" rel="stylesheet" type="text/css">

              <link href="css/style.css" type="text/css" rel="stylesheet">
              <script src="js/jquery-3.4.1.min.js"></script>
              <script src="js/bootstrap.bundle.min.js"></script>
              <script src="js/bootstrap.min.js"></script>
              <script src="js/jquery.fn.gantt.js"></script>
              <script src="js/moment.min.js"></script>
              <script src="js/jquery.form.min.js"></script>

        </head>
        <body>


          <div class="container">
            <h1>
                foogantt
            </h1>
            <div class="row">
              <div class="col-md-12 px-3 bg-light">

                <form class="form" id="addform" method="post" action="foogantt.php">
                  <div class="form-group">
                    <h3>Add Item</h3>
                    <label for="item-name">Item Name</label>
                    <input type="text" id="item-name" name="item-name" class="form-control mb-2" placeholder="Item Name"/>
                    <label for="date">Expiry Date</label>
                    <input type="date" id="date" name="date" class="form-control mb-2" value="<?php echo date("Y-m-d",strtotime('now'));?>"/>
                    <a href="#" class="btn btn-info mr-1" id="sub3">-3</a><a href="#" class="btn btn-info mx-1" id="sub2">-2</a><a href="#" class="btn btn-info mx-1" id="sub1">-1</a><a href="#" class="btn btn-info mx-1" id="add1">+1</a><a href="#" class="btn btn-info mx-1" id="add2">+2</a><a href="#" class="btn btn-info mx-1" id="add3">+3</a><br />
                    <label for="veg">Category</label><br />
                    <div class="btn-group btn-group-toggle" data-toggle="buttons">
                      <label class="btn btn-primary active">
                        <input type="radio" name="category" id="other" autocomplete="off" checked value="ganttBlue"> Other
                      </label>
                      <label class="btn btn-success">
                        <input type="radio" name="category" id="veg" autocomplete="off" value="ganttGreen"> Veg
                      </label>
                      <label class="btn btn-danger">
                        <input type="radio" name="category" id="meat" autocomplete="off" value="ganttRed"> Meat
                      </label>
                      <label class="btn btn-warning">
                        <input type="radio" name="category" id="dairy" autocomplete="off" value="ganttOrange"> Dairy
                      </label>
                    </div>
                    <input type="hidden" value="addform" name="form-id" />
                    <input type="submit" value="Add Item" class="btn btn-success mt-2 btn-block" />
                    <div id="addform-response" class="alert alert-warning my-2" style="display:none;"></div>
                  </div>
                </form>

              </div>

            </div>
          </div>
          <div class="container">
              <div class="gantt"></div>
          </div>


      <script>

          $(function() {

              "use strict";
              //some settings
              var today = moment();
              var andTwoHours = moment().add(2, "hours");
              var today_friendly = "/Date(" + today.valueOf() + ")/";
              var next_friendly = "/Date(" + andTwoHours.valueOf() + ")/";
              //user settings
              var ganttoptions = {
                source: "data.php",
                scale: "days",
                minScale: "hours",
                navigate: "scroll",
                itemsPerPage: "100",
                onItemClick: function(data) {
                    $('#deletemodal').modal('show');
                    $("#item-number").val( data );
                }
              };
              //when page loads, load the chart.
              $(".gantt").gantt(ganttoptions);

              //various forms stuff
              $("#addform").ajaxForm({
                url: 'foogantt.php',
                type: 'post',
                target: '#addform-response',
                success: function() {
                    $('#addform-response').fadeIn('slow');
                    $('#addform-response').delay('400').fadeOut('slow');
                    $(".gantt").gantt(ganttoptions);
                    $("#addform").closest('form').find("input[type=text]").val("");
                }
              })

              Date.prototype.addDays = function(days) {
                  var date = new Date(this.valueOf());
                  date.setDate(date.getDate() + days);
                  //return date;

                  var d = new Date(date),
                      month = '' + (d.getMonth() + 1),
                      day = '' + d.getDate(),
                      year = d.getFullYear();

                  if (month.length < 2)
                      month = '0' + month;
                  if (day.length < 2)
                      day = '0' + day;

                  return [year, month, day].join('-');
              }

              $("#add1").click( function() {
                var currdate = $("#date").val();
                var newdate = new Date(currdate);
                newdate = newdate.addDays(1);
                $('#date').val(newdate);
              });
              $("#add2").click( function() {
                var currdate = $("#date").val();
                var newdate = new Date(currdate);
                newdate = newdate.addDays(2);
                $('#date').val(newdate);
              });
              $("#add3").click( function() {
                var currdate = $("#date").val();
                var newdate = new Date(currdate);
                newdate = newdate.addDays(3);
                $('#date').val(newdate);
              });
              $("#sub1").click( function() {
                var currdate = $("#date").val();
                var newdate = new Date(currdate);
                newdate = newdate.addDays(-1);
                $('#date').val(newdate);
              });
              $("#sub2").click( function() {
                var currdate = $("#date").val();
                var newdate = new Date(currdate);
                newdate = newdate.addDays(-2);
                $('#date').val(newdate);
              });
              $("#sub3").click( function() {
                var currdate = $("#date").val();
                var newdate = new Date(currdate);
                newdate = newdate.addDays(-3);
                $('#date').val(newdate);
              });


              $("#deleteform").ajaxForm({
                url: 'foogantt.php',
                type: 'post',
                target: '#deleteform-response',
                success: function() {
                    // $('#deleteform-response').fadeIn('slow');
                    // $('#deleteform-response').delay('400').fadeOut('slow');
                    $("#deletemodal").modal('hide');
                    $(".gantt").gantt(ganttoptions);
                    //$("#deleteform").closest('form').find("input[type=text]").val("");

                }
              })

          });

      </script>

      <div class="modal" tabindex="-1" role="dialog" id="deletemodal">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title">Delete This Item</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <p>Are you sure you want to delete this item?</p>
            </div>
            <div class="modal-footer">
              <form class="form" id="deleteform" method="post" action="foogantt.php">
                <input type="hidden" value="deleteform" name="form-id" />
              <input type="hidden" id="item-number" value="" name="item-number" />
              <input type="submit" class="btn btn-danger" value="Delete Item" />
              <div id="deleteform-response" class="alert alert-warning my-2"  style="display:none;"></div>
            </form>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
      </body>
  </html>
