@extends('layout')


@section('body')
<style>
     .stretch-card>.card {
     width: 100%;
     min-width: 100%
 }


 .flex {
     -webkit-box-flex: 1;
     -ms-flex: 1 1 auto;
     flex: 1 1 auto
 }

 @media (max-width:991.98px) {
     .padding {
         padding: 1.5rem
     }
 }

 @media (max-width:767.98px) {
     .padding {
         padding: 1rem
     }
 }

 .padding {
     padding: 3rem
 }

 .card {
     box-shadow: none;
     -webkit-box-shadow: none;
     -moz-box-shadow: none;
     -ms-box-shadow: none
 }

 .card {
     position: relative;
     display: flex;
     flex-direction: column;
     min-width: 0;
     word-wrap: break-word;
     background-color: #fff;
     background-clip: border-box;
     border: 1px solid #3da5f;
     border-radius: 0
 }

 .card .card-body {
     padding: 1.25rem 1.75rem
 }

 .card .card-title {
     color: #000000;
     margin-bottom: 0.625rem;
     text-transform: capitalize;
     font-size: 0.875rem;
     font-weight: 500
 }

 .card .card-description {
     margin-bottom: .875rem;
     font-weight: 400;
     color: #76838f
 }

 .widget-user .widget-user-header {
    padding: 10px;
    height: 120px;
    border-top-right-radius: 3px;
    border-top-left-radius: 3px;
}

.bg-aqua-active{
    background-color: #3C91E6 !important;
    color:#fff;
}

.widget-user .widget-user-username {
    margin-top: 0;
    margin-bottom: 5px;
    font-size: 20px;
    font-weight: 300;
    text-shadow: 0 1px 1px rgba(0,0,0,0.2);
}
.widget-user .widget-user-desc {
    margin-top: 0;
     font-size: 15px;
}


h1, h2, h3, h4, h5, h6, .h1, .h2, .h3, .h4, .h5, .h6 {
    font-family: 'Source Sans Pro',sans-serif;
}
.box-widget {
    border: none;
    position: relative;
}

.box {
    position: relative;
    border-radius: 3px;
    background: #ffffff;
    border-top: 3px solid #d2d6de;
    margin-bottom: 20px;
    width: 100%;
    box-shadow: 0 1px 1px rgba(0,0,0,0.1);
}

.widget-user .widget-user-image {
    position: absolute;
    top: 65px;
    left: 50%;
    margin-left: -45px;
}

.widget-user .widget-user-image>img {
    max-width:200px;
    height: auto;
    border: 3px solid #fff;
}

.img-circle {
    border-radius: 50%;
}


.widget-user .box-footer {
    padding-top: 30px;
}

.box-footer {
    border-top-left-radius: 0;
    border-top-right-radius: 0;
    border-bottom-right-radius: 3px;
    border-bottom-left-radius: 3px;
    border-top: 1px solid #f4f4f4;
    padding: 10px;
    background-color: transparent; /* Inherit background color from the parent element (body) */
}


.box .border-right {
    border-right: 1px solid #f4f4f4;
}

.description-block {
    display: block;
    margin: 10px 0;
    text-align: center;
}

.description-block>.description-header {
    margin: 0;
    padding: 0;

    font-size: 15px;
}

.description-block>.description-text {
      margin: 0;
    padding: 0;
    font-size: 15px;
    text-transform: uppercase;
}

.description-block {
    display: block;
    margin: 10px 0;
    text-align: center;
}

.tableDiv{
    position: absolute;
    margin-left: 330px; /* Adjust the margin here */
    margin-top: 175px;
    z-index: 999;
    max-height: 380px; /* Set your desired maximum height here */
    overflow-y: auto;
}
.table{
    width: 300px;
    border-collapse: collapse;
    text-align: left;
    height: 10px;
}
#thead{
    background-color: #3C91E6;
    color: white
}
.table tr {
    border-bottom: 1px solid #ccc; /* Add a border to the bottom of each row */
}

#thead tr {
    border-bottom: 2px solid #fff; /* Add a border to the header row */
}
.btn{
    background-color: #007bff;
     color: #fff;
      border: none;
      border-radius: 5px;
      padding: 8px 15px;
      cursor: pointer;
}
.table table{
    height: 100px;
}
.filter{
    position: absolute;
    z-index: 999;
    margin-top: 150px;
    margin-left: 50px

}
.btn2 i {
        font-size: 18px; /* Adjust the size as needed */
        color: #333; /* Adjust the color as needed */
    }
</style>
<body class="page-body">

    <div class="filter" id="filContainer" >
        <input type="date" id="filterDate" placeholder="Filter by Date" style="margin-left: 300px">
        <button id="clearFilter" class="btn2" title="Clear Filter" style="width:15px;height: 20px" ><i class="fas fa-times">x</i></button>
    </div>
<div class="tableDiv" id="tableDivID">
    <table border="1" class="table" id="table">
        <thead id="thead" >
            <tr>
                <th>name</th>
                <th>amount</th>
                <th>price</th>
                <th>Date</th>
            </tr>
            @foreach ($sales as $sale )

        </thead>
        <tbody>
                <tr>
                <td>{{ $sale->name }}</td>
                <td>{{ $sale->amount }}</td>
                <td style="max-width: 100px;word-wrap: break-word;">{{ $sale->price }}</td>
                <td>{{ $sale->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

@foreach ($typeProfile as $people )
<div class="page-content page-container" id="containerID" style="margin-left: 270px">
    <div class="padding">
        <div class="row container d-flex justify-content-center">
<div class="col-md-4">

          <div class="box box-widget widget-user">

            <div class="widget-user-header bg-aqua-active">
              <h3 class="widget-user-username">{{ $people->name }}</h3>
            </div>
            <div class="widget-user-image">

              <img class="img-circle" src="{{ $people->image }}" alt="User Avatar">

            </div>
            <div class="box-footer" >
              <div class="row" >
                <div class="col-sm-4 border-right"><br><br><br><br><br><br><br><br>
                  <div class="description-block">
                    <span id="totalDisplay" class="description-text">الكلي</span>
                    <h5  class="description-header">{{ $total }}</h5>
                    ------------

                </div>

                </div>

                <div class="col-sm-4 border-right">
                  <div class="description-block">
                    <span class="description-text">عدد مرات البيع</span>
                    <h5 class="description-header">{{ $count }}</h5>

                </div>

                </div>

                <div class="col-sm-4" >
                  <div class="description-block">
                    <br><br><br>
                    <button id="show-table" class="btn">Table</button>
                    <button class="btn" id="delete" style="background-color: red">Delete</button>

                  </div>

                </div>

              </div>

            </div>

        </div>


        </div>
        </div>
        </div>
        </div>
@endforeach
</body>
<script>


document.getElementById('show-table').onclick = function() {
    if (document.getElementById('tableDivID').style.display === 'none') {
        document.getElementById('tableDivID').style.display = 'block';
        document.getElementById('totalDisplay').style.display = 'block';
        document.getElementById('filContainer').style.display = 'block';

    } else {
        document.getElementById('tableDivID').style.display = 'none';
        document.getElementById('totalDisplay').style.display = 'none';
        document.getElementById('filContainer').style.display = 'none';

    }
}

document.getElementById('delete').onclick = function() {
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    fetch('del', {
        method: 'delete',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ id: {{ $typeProfile[0]->id }} })
    })
    .then(function(response) {
        // Check if the response indicates a successful deletion (you might need to customize this)
        if (response.status === 200) {
            // Redirect to the "People" route
            window.location.href = '/People'; // Replace '/people' with the actual URL of your "People" route
        }
    })
    .catch(function(error) {
        console.error('Error:', error);
    });
}

function colorBack() {
    var bodyBackgroundColor = getComputedStyle(document.body).backgroundColor;

    // Apply the body's background color to the .box-footer
    var boxFooter = document.querySelector(".box-footer");
    boxFooter.style.backgroundColor = bodyBackgroundColor;
    if (localStorage.getItem('dark') == null) {
        document.body.style.color = 'black'
    } else {
        document.body.style.color = 'white'

    }
}

document.addEventListener('DOMContentLoaded', function() {
    colorBack();
});

setInterval(function() {
    colorBack();
}, 1000);

</script>


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("paymentTable");
        const dateFilter = document.getElementById("filterDate");
        const totalDisplay = document.getElementById("totalDisplay");

        function updateTotal() {
            let total = 0;

            // Loop through the visible rows in the table
            for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
                const row = table.rows[i];
                const cell = row.cells[0]; // Assuming the "mony" column is the first column (index 0)

                if (row.style.display !== "none") {
                    total += parseFloat(cell.textContent);
                }
            }

            // Update the "الكلي" value
            totalDisplay.textContent = total.toFixed(2); // You can adjust the formatting as needed
        }

        dateFilter.addEventListener("input", function () {
            const filterDate = dateFilter.value;

            // Loop through the rows in the table
            for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
                const row = table.rows[i];
                const cell = row.cells[2]; // Assuming the date column is the third column (index 2)

                // Extract the date part from the full 'created_at' value
                const createdDate = cell.textContent.split(" ")[0];

                if (filterDate === "" || createdDate === filterDate) {
                    row.style.display = ""; // Show the row
                } else {
                    row.style.display = "none"; // Hide the row
                }
            }

            // Update the "الكلي" value after filtering
            updateTotal();
        });

        // Calculate and display the initial total when the page loads
        updateTotal();
    });
    </script>



<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("table");
        const dateFilter = document.getElementById("filterDate");
        const clearFilterButton = document.getElementById("clearFilter");
        const totalDisplay = document.getElementById("totalDisplay");

        function updateTotal() {
            let total = 0;

            // Loop through the visible rows in the table
            for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
                const row = table.rows[i];
                const cell = row.cells[2]; // Assuming the "mony" column is the first column (index 0)

                if (row.style.display !== "none") {
                    total += parseFloat(cell.textContent);
                }
            }

            // Update the "الكلي" value
            totalDisplay.textContent = total.toFixed(2); // You can adjust the formatting as needed
        }

        function clearFilter() {
            dateFilter.value = ""; // Clear the filter input

            // Loop through the rows in the table and show all rows
            for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
                const row = table.rows[i];
                row.style.display = ""; // Show the row
            }

            // Update the "الكلي" value after clearing the filter
            updateTotal();
        }

        dateFilter.addEventListener("input", function () {
            const filterDate = dateFilter.value;

            // Loop through the rows in the table
            for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
                const row = table.rows[i];
                const cell = row.cells[3]; // Assuming the date column is the third column (index 2)

                // Extract the date part from the full 'created_at' value
                const createdDate = cell.textContent.split(" ")[0];

                if (filterDate === "" || createdDate === filterDate) {
                    row.style.display = ""; // Show the row
                } else {
                    row.style.display = "none"; // Hide the row
                }
            }

            // Update the "الكلي" value after filtering
            updateTotal();
        });

        // Add an event listener to the "Clear Filter" button
        clearFilterButton.addEventListener("click", clearFilter);

        // Calculate and display the initial total when the page loads
        updateTotal();
    });
    </script>


@endsection
