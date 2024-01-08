
@extends('layout')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<head>
    <!-- Include jsPDF here -->
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.70/vfs_fonts.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.3/html2pdf.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script> --}}

    <!-- Your other script tags -->
</head>

<style>


    .btn-submit {
        width: 10%;
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    table {
        border-collapse: collapse;
        font-family: Tahoma, Geneva, sans-serif;
        width: 90%; /* Set the table width to 100% */
    }
    table td {
        padding: 15px;
        width: 20%; /* Set a fixed width for each table cell */
    }
    table thead th {
        background-color: #54585d;
        color: #ffffff;
        font-weight: bold;
        font-size: 13px;
        border: 1px solid #54585d;
    }
    table tbody td {
        border: 0.1px solid #000;
    }
    table tbody tr {
        /* background-color: #f9fafb; */
    }

    /* Fix thead */
    table thead {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    /* Hide the table header cells in the scrollable tbody */
    table tbody {
        overflow-y: scroll;
        width: 100%;
        max-height: 300px; /* Adjust the max-height as needed */
    }

    /* Wrap tbody content in a div */
    .tbody-wrapper {
        display: table;
        width: 100%;
    }
    table th,
    table td {
        width: 16.67%;
        text-align: left;
        padding: 0;
        padding: 8px;
    }
    table th{
        height: 50px;
    }
    .message {
        position: fixed;
        top: 90px; /* Remove top position */
        right: 20px; /* Add right position */
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        display: none;
        z-index: 999; /* Add a high z-index value to ensure it's above other elements */

    }
    .message.success {
        background-color: green;
    }

    .delete-payment,
    .edit-payment {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px; /* Adjust the size as needed */
        margin: 0 5px;
        padding: 0;
    }
    .delete-payment{
        color: gray;
    }
    .edit-payment {
        color: 007bff;
    }
    /* Optional hover effect */
    .delete-payment:hover,
    .edit-payment:hover {
        color: #ff0000; /* Hover color */
    }
    #addPaymentButton{
        background: none;
        border: none;
        cursor: pointer;
        color: #636363;
        margin: 0 5px;
        padding: 0;
        font-size: 29px;
    }
    #tahead{
        background-color: rgb(82, 80, 80);
        color: white;
        font-size: 85%;
    }
    .reduced-height td {
    lineHeight: 1; /* Adjust the value to reduce row height as needed */
    }

    .total{
        margin-left: 300px;
        color:grey;
        font-size: 25px;
        border: 1px solid #007bff;
        padding: 0px;
        display: inline-block;
    }

    .filter{
        position: absolute;
        margin-top: 10px;
        margin-left: 700px;

    }
</style>
@section('body')

<div class="message" id="message">
    <p id="message-content"></p>
</div>
{{-- <style>
    /* @media print{
        body * {
            visibility: hidden;
        }
        .print-container, .print-container * {
            visibility: visible;
        }
    } */
    @media print {
    /* Show the entire table */
    table {
        display: table;
        width: 100%;
    }
    table thead, table tbody {
        display: table-header-group;
    }
    table th, table td {
        display: table-cell;
    }
    @media print {
    .no-print {
        display: none;
    }
}

}

</style> --}}
<div style="display:flex; margin-left: 400px; margin-top: 10px;">
    <h1 style="color: gray" >المبيعات</h1>
    <button id="printButton" style="margin-left: 900px; font-size: 100%" class="btn-submit" >Print</button>

</div>




<div style="margin-left: 1000px;">
    <form action="sales" style="display: inline-block;">
        @csrf
        <input type="text" name="term" placeholder="Search" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        <button type="submit" name="submit" style="background-color: #007bff; color: #fff; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;">Search</button>
    </form>
</div>

<!--tabel-->

<h2 id="totalDisplay" class="total">الكلي:{{ $total }}</h2>

<div class="filter" >
    <input type="date" id="filterDate" placeholder="Filter by Date" style="width: 200px" >
    <button id="clearFilter" class="btn2" title="Clear Filter"><i class="fas fa-times" style="width: 30px"></i></button>
</div>

<div style="margin-top: 5px;margin-left: 300px" id="container-table" class="container" >

    <button style=" margin-bottom: 10px; margin-left: 1000px" id="addPaymentButton">
        <i class="fas fa-plus-circle"></i> <!-- FontAwesome plus-circle icon -->
    </button>
    <div class="print-container" style="height: 600px; overflow-y: auto;">
            <table id="table_pdf" >
                    <tr class="reduced-height" id="tahead">
                        <th>Name</th>
                        <th>Type</th>
                        <th>Amount</th>
                        <th>Price</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                <tbody id="tbody">
                    @foreach ($sales as $sale )
                    <tr id="avoid" >

                        <td>{{ $sale->name }}</td>
                        @foreach ($sale->type as $type )

                            @if ($type->deleted_at != null)

                            <td><p style="color: red;">{{ $type->name }} </p></td>

                            @else
                            <td>{{ $type->name }}</td>
                            @endif

                        @endforeach
                        <td>{{ $sale->amount }}</td>
                        <td>{{ $sale->price }}</td>
                        <td>{{ $sale->created_at }}</td>
                        <td id="actionse">
                            <button class="delete-payment" id="delete-button" data-payment-id="{{ $sale->id }}">
                                <i class="fas fa-trash"></i> <!-- FontAwesome trash icon -->
                            </button>
                            <button class="edit-payment" id="edit-button" data-payment-id="{{ $sale->id }}">
                                <i class="fas fa-edit"></i> <!-- FontAwesome edit icon -->
                            </button>

                        </td>
                        </tr>
                    @endforeach


                    <!-- Add more table rows as needed -->
                </tbody>
            </table>

            </div>

        </div>
        <div id="edit-modal" class="modal" style="display: none;">
            <div class="modal-content">
                <span class="close" id="close-edit-modal">&times;</span>
                <h2>Edit Sale</h2>
                <form id="edit-sale-form">
                    @csrf
                    <!-- Add input fields for editing -->
                    <label for="edit-name">Name:</label>
                    <input type="text" id="edit-name" name="name">
                    <label for="edit-type">Type:</label>
                    <select id="edit-mySelect" name="type_id" style="width: 150px">
                        @foreach ($products as $product )

                        <option value="{{ $product->id }}"> {{ $product->name}} </option>

                         @endforeach
                    </select>
                    <label for="edit-amount">Amount:</label>
                    <input type="number" id="edit-amount" name="amount">
                    <br><br><br>
                    <button type="submit" class="btn-submit">Update</button>
                </form>
            </div>
        </div>

          <!--end tabel-->
<script>

function updateTotalsa() {
            let total = 0;
            const table = document.getElementById("table_pdf");
            const totalDisplay = document.getElementById("totalDisplay");

            // Loop through the visible rows in the table
            for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
                const row = table.rows[i];
                const cell = row.cells[3]; // Assuming the "mony" column is the first column (index 0)

                if (row.style.display !== "none") {
                    total += parseFloat(cell.textContent);
                }
            }

            // Update the "الكلي" value
            totalDisplay.textContent = total.toFixed(2); // You can adjust the formatting as needed
        }
  document.addEventListener('DOMContentLoaded', function() {
    var deleteButtons = document.querySelectorAll('.delete-payment');

    deleteButtons.forEach(function(button) {
    button.addEventListener('click', function() {
        var paymentId = button.getAttribute('data-payment-id');

        // Use the confirm method to show a confirmation dialog
        var confirmDelete = confirm('Are you sure you want to delete this sale?');

        if (confirmDelete) {
            var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            var url = '/delSale/' + paymentId;

            fetch(url, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => {
                if (response.ok) {
                    // Sale deleted successfully
                    showMessage('Success! Sale deleted.');
                    var rowToDelete = button.closest('tr');
                    rowToDelete.remove();
                    updateTotalsa();
                } else {
                    showMessage('Error: Sale not deleted.');
                    updateTotalsa();
                }
            })
            .catch(error => {
                console.error(error);
                showMessage('Error: Sale not deleted.');
                updateTotalsa();
            });
        }
    });
});

    });
let saleId;
/*edit form */
document.addEventListener('DOMContentLoaded', function () {
    const editButtons = document.querySelectorAll('.edit-payment');

    editButtons.forEach(function (button) {
    button.addEventListener('click', function () {
        saleId = button.getAttribute('data-payment-id');
        console.log('Sale ID:', saleId); // Add this line for debugging

        // Show the edit form
        const editModal = document.getElementById('edit-modal');
        editModal.style.display = 'block';
    });
});


    // Add event listeners to close the edit form
    const closeEditModal = document.getElementById('close-edit-modal');
    closeEditModal.addEventListener('click', function () {
        const editModal = document.getElementById('edit-modal');
        editModal.style.display = 'none';
    });

    window.addEventListener('click', function (event) {
        const editModal = document.getElementById('edit-modal');
        if (event.target === editModal) {
            editModal.style.display = 'none';
        }
    });

    // Handle form submission for updating the sale data
    const editSaleForm = document.getElementById('edit-sale-form');
    editSaleForm.addEventListener('submit', function (event) {
        event.preventDefault();
        // Handle the sale data update (e.g., using AJAX)
        // Close the edit form when the update is successful
        const editModal = document.getElementById('edit-modal');
        editModal.style.display = 'none';
    });

    // ... (Your existing code)


});
/*edit form */
// Handle form submission for updating the sale data
// ... (other code)

// Handle form submission for updating the sale data
const editSaleForm = document.getElementById('edit-sale-form');
editSaleForm.addEventListener('submit', function (event) {
    event.preventDefault();
    const editedName = document.getElementById('edit-name').value; // Define editedName here
    // You can also define other variables here if needed
    const editedTypeId = document.getElementById('edit-mySelect').value;
    const editedAmount = document.getElementById('edit-amount').value;
    var csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Rest of your code to make the PUT request
    // ...

    fetch(`/updateSale/${saleId}`, {
        method: 'PUT',
        headers: {
            'X-CSRF-TOKEN': csrfToken,
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            name: editedName,
            type_id: editedTypeId,
            amount: editedAmount,
        }),
    })
    .then(response => {
        if (response.ok) {
            showMessage('Success! Sale updated.');
            const editModal = document.getElementById('edit-modal');
            editModal.style.display = 'none';
            location.reload();

        } else {
            showMessage('Error: Sale not updated.');
        }
    })
    .catch(error => {
        console.error(error);
        showMessage('Error: Sale not updated.');
    });
});

/* workssssssssssssssssssssssssss to html**/
// document.addEventListener('DOMContentLoaded', function() {
//     const exportButton = document.getElementById('printButton');

//     exportButton.addEventListener('click', function() {
//         // Create a Blob with the HTML content of the table page
//         const tableHTML = document.getElementById('tbody').innerHTML;
//         const blob = new Blob([`<html><head>

//             </head>${document.head.innerHTML}${tableHTML}</html>`], {
//             type: 'text/html',
//         });

//         // Create a URL for the Blob
//         const url = URL.createObjectURL(blob);

//         // Create an anchor element to trigger the download
//         const a = document.createElement('a');
//         a.href = url;
//         a.download = 'table_data.html';

//         // Trigger a click event on the anchor to start the download
//         a.click();

//         // Revoke the URL to release resources
//         URL.revokeObjectURL(url);
//     });
// });
function changeMargin() {
    if (localStorage.getItem('menu') == null) {
        document.getElementById('container-table').style.marginLeft = 100;
    } else {
        document.getElementById('container-table').style.marginLeft = 300;
    }
}

changeMargin();

setInterval(function() {
    changeMargin();
}, 1000);



</script>
<script src="{{ asset('js/html2pdf.bundle.min.js') }}"></script>
<script type="text/javascript">
document.getElementById('printButton').onclick = function() {
    // Clone the table element
    var tableToPrint = document.getElementById('table_pdf').cloneNode(true);

    // Remove action cells (last cell in each row)
    var rows = tableToPrint.querySelectorAll('tr');
    for (var i = 0; i < rows.length; i++) {
        var cells = rows[i].querySelectorAll('td');
        if (cells.length > 0) {
            var lastCell = cells[cells.length - 1];
            rows[i].removeChild(lastCell);
        }
    }

    // Remove the last th (header) element in the header row
    var headerRow = tableToPrint.querySelector('tr#tahead');
    var headerCells = headerRow.querySelectorAll('th');
    if (headerCells.length > 0) {
        var lastHeaderCell = headerCells[headerCells.length - 1];
        headerRow.removeChild(lastHeaderCell);
    }

    var opt = {
        margin: [0, 0,0.07,0],
        filename: 'sales.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
    };
    html2pdf(tableToPrint,opt);


};


</script>

          <div id="modal" class="modal">
            <div class="modal-content">
                <span class="close" id="close-modal">&times;</span>
                <h2>Add Sale</h2>
              <form id="sale-form" >
                @csrf
                <label for="name">Name:</label>
                <input type="text" id="name" value="زبون" name="name" >

                <label for="type">Type:</label>
                <select id="mySelect" name="type_id" style="width: 150px" >
                    @foreach ($products as $product )
                        <option value="{{ $product->id }}"> {{ $product->name}} </option>
                    @endforeach
                </select>

                <label for="amount">Amount:</label>
                <input type="text" id="amount" value="1" name="amount">
                <br><br><br>
                <button type="submit" class="btn-submit" >Submit</button>
              </form>
            </div>
          </div>

          <script>
            // Get references to the modal and close button
            const modal = document.getElementById('modal');
            const closeModal = document.getElementById('close-modal');
            const addButton = document.querySelector('.container button');
            const saleForm = document.getElementById('sale-form');
            const amount = document.getElementById('amount');
            const name = document.getElementById('name');
            //select
            const selectElement = document.getElementById('mySelect');
            let selectedIndex = 0; // Initialize the selected index


            addButton.addEventListener('click', () => {
              modal.style.display = 'block';
              selectElement.focus();
            });

            // Hide the modal when the close button is clicked
            closeModal.addEventListener('click', () => {
              modal.style.display = 'none';
            });
            document.addEventListener('keydown', function(event) {
                if(modal.style.display === 'none'){
                    if (event.key === 'e' ||event.key === 'E' ||event.key === 'ث'  ) {
                        addButton.click();
                    }
                }
                else{
                if (event.key === 'e' ||event.key === 'E' || event.key === 'ث'  ) {
                        modal.style.display='none';
                    }
                }

            });
            // Hide the modal when the user clicks outside of it
            window.addEventListener('click', (event) => {
              if (event.target === modal) {
                modal.style.display = 'none';
              }
            });

            // Prevent the default form submission behavior
            // saleForm.addEventListener('submit', (event) => {
            //   event.preventDefault(); // Prevent the form from submitting
            //   // Here, you can handle the form data as needed (e.g., send it to a server).
            //   // Optionally, you can clear the form inputs:
            //   saleForm.reset(); // Clear the form inputs
            // });
            window.addEventListener('keyup', (event) => {
                let hasReloaded = false;
              if (event.key === 'Escape') {
                modal.style.display = 'none';
                if (!hasReloaded) {
                    window.location.reload();
                    hasReloaded = true;
                }
              }
            });
            document.addEventListener('keydown', (event) => {
            if (event.key === 'Shift' || event.key === 'ShiftRight') {
                const amountInt = parseInt(amount.value, 10);
                if (!isNaN(amountInt)) {
                    amount.value = amountInt + 1;
                }
            }
             });

            // window.addEventListener('change', (event) => {
            //     amountInt=parseInt(amount.value)
            //     if (amountInt < 1) {
            //     amount.value = 1;
            //     }
            // });


           // ...

// Sale form submission
        saleForm.addEventListener('submit', (event) => {
            event.preventDefault(); // Prevent the form from submitting
            const formData = new FormData(saleForm);

            fetch('/add', {
                method: 'POST',
                body: formData,
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Form submission was successful
                    showMessage('Success! Sale added.');
                    modal.style.display = 'none'; // Optionally close the modal
                    saleForm.reset(); // Clear the form inputs
                } else {
                    showMessage('Success! Sale added.');
                }
            })
            .catch(error => {
                console.error(error);
                showMessage('Error: Sale not added.');
            });
        });

        // Function to display the message
        function showMessage(messageText) {
            const message = document.getElementById('message');
            const messageContent = document.getElementById('message-content');

            messageContent.textContent = messageText;
            message.classList.add('success'); // You can modify this class based on the message type (success or error)
            message.style.display = 'block';

            // Hide the message after a few seconds (adjust as needed)
            setTimeout(() => {
                message.style.display = 'none';
            }, 3000); // Hide after 3 seconds (3000 milliseconds)
        }

        (function(){
        if(localStorage.getItem('dark')!=null){
            document.body.style.color='white';
        }
    })();


function colorBack() {
    if (localStorage.getItem('dark') == null) {
        document.getElementById('table_pdf').style.backgroundColor = 'white'
        document.getElementById('table_pdf').style.color = 'black'

    } else {
        document.getElementById('table_pdf').style.backgroundColor = 'black'
        document.getElementById('table_pdf').style.color = 'white'
    }
}
document.addEventListener('DOMContentLoaded', function() {
    colorBack();
});
setInterval(function() {
    colorBack();
}, 1000);



    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("table_pdf");
        const dateFilter = document.getElementById("filterDate");
        const clearFilterButton = document.getElementById("clearFilter");
        const totalDisplay = document.getElementById("totalDisplay");

        function updateTotal() {
            let total = 0;

            // Loop through the visible rows in the table
            for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
                const row = table.rows[i];
                const cell = row.cells[3]; // Assuming the "mony" column is the first column (index 0)

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
                const cell = row.cells[4]; // Assuming the date column is the third column (index 2)

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

        // Set the default value for the filter input to today's date and trigger the input event
        const today = new Date();
        const year = today.getFullYear();
        const month = (today.getMonth() + 1).toString().padStart(2, "0");
        const day = today.getDate().toString().padStart(2, "0");
        const currentDate = `${year}-${month}-${day}`;
        dateFilter.value = currentDate;

        // Trigger the input event to filter the table with the default date
        const inputEvent = new Event("input", {
            bubbles: true,
            cancelable: true,
        });
        dateFilter.dispatchEvent(inputEvent);
    });


</script>

{{-- /*******************/ --}}


<script>
    document.addEventListener("DOMContentLoaded", function () {
        const table = document.getElementById("table_pdf");
        const dateFilter = document.getElementById("filterDate");
        const clearFilterButton = document.getElementById("clearFilter");
        const totalDisplay = document.getElementById("totalDisplay");

        function updateTotal() {
            let total = 0;

            // Loop through the visible rows in the table
            for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
                const row = table.rows[i];
                const cell = row.cells[3]; // Assuming the "mony" column is the first column (index 0)

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
                const cell = row.cells[4]; // Assuming the date column is the third column (index 2)

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
