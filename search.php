<!DOCTYPE html>
<html lang="en">

<head>
  <title>Search</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="css/bootstrap.min.css" />
<style>
    div {

        margin: auto;
    }

    table {

        width: 100%;
        height: 120%;
        padding: 10px;
        border-style: solid;
    }

    button {
        width: 100%;
        height: 100%;
    }

    th,
    td {
        text-align: left;
        padding: 10px;
        height: 50px;
        border: 1px solid;
    }
    

</style>
</head>

<body>
  <!-- สร้างช่อง search -->
  <div style="margin-left: 20px; margin-right: 20px;">
    <div><br></div>
    <input type="text" class="form-control" id="search" style="width:1100px;" placeholder="Search">
    <!-- <table class="table table-hover"> -->

    <div>
      <br>
    </div>
    <!-- สร้างหัวตาราง -->
    <table width="1200">
      <thead>
        <tr>
          <th width="50">
            <div align="center"> invoice_id </div>
          </th>
          <th width="50">
            <div align="center"> company_id </div>
          </th>
          <th width="70">
            <div align="center"> company_format </div>
          </th>
          <th width="120">
            <div align="center"> invoice_number </div>
          </th>
          <th width="150">
            <div align="center"> name </div>
          </th>
          <th width="200">
            <div align="center"> organization </div>
          </th>
          <th width="200">
            <div align="center"> address </div>
          </th>
          <th width="150">
            <div align="center"> email </div>
          </th>
          <th width="150">
            <div align="center"> create_dt </div>
          </th>
          <th width="50">
            <div align="center"> more </div>
        </tr>
      </thead>
      <div>
        <!-- เรียกข้อมูลหลักมาแสดง -->
        <tbody id="output"></tbody>
        </tbody>
      </div>
      <!-- <div>
        <br>
        <tbody id="more-table">
        </tbody>
      </div> -->
    </table>

    <!-- <div id="page-selection"></div> -->

    <!-- ทำปุ่มกดหน้า -->
    <nav aria-label="Page navigation example">
      <ul class="pagination">
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Previous">
            <span aria-hidden="true">&laquo;</span>
            <span class="sr-only">Previous</span>
          </a>
        </li>
        <li class="page-item"><a class="page-link" href="#">1</a></li>
        <li class="page-item"><a class="page-link" href="#">2</a></li>
        <li class="page-item"><a class="page-link" href="#">3</a></li>
        <li class="page-item">
          <a class="page-link" href="#" aria-label="Next">
            <span aria-hidden="true">&raquo;</span>
            <span class="sr-only">Next</span>
          </a>
        </li>
      </ul>
    </nav>

  </div>


  <!-- เมื่อเริ่มหา -->

  <script type="text/javascript">
    $(document).ready(function() {
      $("#search").keypress(function() {

        let name = $("#search").val()
        // data["page"] = page;

        // เตรียมข้อมูลไว้แปลงเป็นJSON
        let obj = {
          name: name,
          type: "search-input"
        }
        // แปลงเป็นstring
        var json = JSON.stringify(obj);
        $.ajax({
          type: 'POST',
          url: 'searchd1.php',
          dataType: 'json',
          data: {
            "json": json
            // name: $("#search").val(),
          },
          success: function(data) {
            // alert(data);
            // console.log(data);
            var textHtml = ""
            data.forEach((item) => {

              textHtml += "<tr>"

              textHtml += "<td>" + item.invoice_id + "</td><td>" + item.company_id + "</td><td>" + item.company_format + "</td><td>" + item.invoice_number + "</td><td>" + item.name + "</td><td>" + item.organization + "</td><td>" + item.address + "</td><td>" + item.email + "</td><td>" + item.create_dt + "</td> <td><button id='btn' name='btn' onclick=myFunction1(" + item.invoice_id + ")> + </button></td>"

              textHtml += "</tr>"
              textHtml += "<br><tr id='bodyResult" + item.invoice_id + "'></tr><br>"

            });
            document.getElementById("output").innerHTML = textHtml
            // createPagination(res.currentPage, res.page);
          }
        });
      })
    });
  </script>

  <!-- เมื่อกด +  -->
  <script>
    function myFunction1(invoiceId) {
      // alert("Hello! I am an alert box!");
      let obj = {
        //customer_id: customerId,
        id: invoiceId,
        type: "more-button"
      }
      // แปลงเป็นstring
      var json = JSON.stringify(obj);
      $.ajax({
        type: 'POST',
        url: 'searchd1.php',
        dataType: 'json',
        data: {
          "json": json
          // name: $("#search").val(),
        },
        success: function(data) {
          console.log(data);
          var textHtml1 = ""
          textHtml1 += "<table>"
          textHtml1 +=
            `<tr>
          <td> invoice_id </td>
          <td> name </td>
          <td> item_id </td>
          <td> company_id </td>
          <td> description </td>
          <td> price </td>
          <td> total </td>
          </tr>`;
          // textHtml1 += "</table>"
          // textHtml1 += ""
// textHtml1 += "<br>"

          data.forEach((item1) => {
             

            textHtml1 += "<tr>"

            textHtml1 += "<td>" + item1.invoice_id + "</td><td>" + item1.name + "</td><td>" + item1.item_id + "</td><td>" + item1.company_id + "</td><td>" + item1.description + "</td><td>" + item1.price + "</td><td>" + item1.total + "</td><td>...</td>"

            textHtml1 += "</tr>"

          });
          // textHtml1 += "<br>"
          textHtml1 += "</table>"

          $("#bodyResult" + invoiceId).html(textHtml1);
          // $("#bodyResult" + invoiceId).append(textHtml1);
          // document.getElementById("more-table").innerHTML = textHtml1
        }
      });
    }
  </script>

</body>

</html>