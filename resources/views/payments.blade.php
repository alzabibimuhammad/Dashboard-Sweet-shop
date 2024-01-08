@extends('layout')

<title>Payment Form</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/chosen/1.8.7/chosen.min.css">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">

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
        width: 90%;
    }
    table td {
        padding: 15px;
        width: 20%;
    }
    table thead td {
        background-color: #54585d;
        color: #ffffff;
        font-weight: bold;
        font-size: 13px;
        border: 1px solid #54585d;
    }
    table tbody td {
        border: 1px solid #000;
    }

    table thead {
        display: table;
        width: 100%;
        table-layout: fixed;
    }

    table tbody {
        overflow-y: scroll;
        max-height: 300px;
    }

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

    .message {
        position: fixed;
        top: 90px;
        right: 20px;
        background-color: #333;
        color: #fff;
        padding: 10px 20px;
        border-radius: 5px;
        display: none;
        z-index: 999;
    }

    .message.success {
        background-color: green;
    }
    /* Style for the icon buttons */
    .delete-payment,
    .edit-payment {
        background: none;
        border: none;
        cursor: pointer;
        font-size: 16px;
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
        font-size: 16px; /* Adjust the size as needed */
        margin: 0 5px;
        padding: 0;
        font-size: 29px;
    }
    #tahead{
        background-color: rgb(82, 80, 80);
        color: white;
        font-size: 85%;
    }
/* Add CSS for the "reduced-height" class to reduce row height */
.reduced-height td {
    lineHeight: 1; /* Adjust the value to reduce row height as needed */
}
.avoid-page-break {
    page-break-inside: avoid;
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

<div style="margin-left: 400px;margin-top: 10px;display: flex;" >
    <h1 style="color: gray" > المدفوعات</h1>
    <button id="printButton" style="margin-left: 800px; font-size: 100%" class="btn-submit" >Print</button>

</div>
<div style="margin-left: 1000px;">
    <form action="Payments" style="display: inline-block;">
        @csrf
        <input type="text" name="term" placeholder="Search" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
        <button type="submit" name="submit" style="background-color: #007bff; color: #fff; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;">Search</button>
    </form>
</div>
<h2 id="totalDisplay" class="total">الكلي:{{ $total }}</h2>
<div class="filter" >
    <input type="date" id="filterDate" placeholder="Filter by Date" style="width: 200px" >
    <button id="clearFilter" class="btn2" title="Clear Filter"><i class="fas fa-times" style="width: 30px"></i></button>
</div>

<div  id="container-table" style="margin-top: 5px;margin-left: 300px" class="container" >
        <!-- Remove the old button element -->
        <button style="width: 60px; margin-bottom: 10px; margin-left: 1000px" id="addPaymentButton">
            <i class="fas fa-plus-circle"></i> <!-- FontAwesome plus-circle icon -->
        </button>


        <div  style="height: 600px; overflow-y: auto;">
        <table id="table_pdf">
                <tr class="reduced-height" id="tahead" >
                    <td>Name</td>
                    <td>Mony</td>
                    <td>Reason</td>
                    <td>date</td>
                    <td>Action</td>
                </tr>

            <tbody id="payment-table-body">
                @foreach ($payments as $payment )
                <tr class="avoid-page-break" >
                    <input type="hidden" name="id" value="{{ $payment->id }}">

                    @foreach ($payment->team as $people )

                    @if ($people->deleted_at != null)
                    <td><p style="color: red;">{{ $people->name }} </p></td>
                    @else

                    <td>{{ $people->name }}</td>

                    @endif


                    @endforeach


                    <td>{{ $payment->mony }}</td>
                    <td>{{ $payment->reason }}</td>
                    <td>{{ $payment->created_at }}</td>
                    <td>
                        <button class="delete-payment" id="delete-button" data-payment-id="{{ $payment->id }}">
                            <i class="fas fa-trash"></i> <!-- FontAwesome trash icon -->
                        </button>
                        <button class="edit-payment" id="edit-button" data-payment-id="{{ $payment->id }}">
                            <i class="fas fa-edit"></i> <!-- FontAwesome edit icon -->
                        </button>

                    </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
<!-- Edit Modal -->
<div id="edit-modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-edit-modal">&times;</span>
        <h2>Edit Payment</h2>
        <form id="Edit-form" action="edit">
            @csrf
            <input type="hidden" id="edit-payment-id" name="payment_id">
            <label for="edit-name">Name:</label>
            <select id="edit-mySelect" name="team_id" style="width: 130px">
                @foreach ($team as $people)
                    <option value="{{ $people->id }}">{{ $people->name }}</option>
                @endforeach
            </select>
            <label for="edit-mony">Mony:</label>
            <input type="number" id="edit-mony" value="0" name="mony" required>
            <label for="edit-reason">Reason:</label>
            <input type="text" id="edit-reason" name="reason">
            <br><br><br>
            <button type="submit" class="btn-submit" id="submitEditButton">Save</button>
        </form>
    </div>
</div>

<script>
// Select the delete button element by its class name
// Select the delete button element by its class name
// Select the delete button element by its class name

function updateTotalsa() {
            let total = 0;
            const table = document.getElementById("table_pdf");
            const totalDisplay = document.getElementById("totalDisplay");

            // Loop through the visible rows in the table
            for (let i = 1; i < table.rows.length; i++) { // Start from 1 to skip the header row
                const row = table.rows[i];
                const cell = row.cells[1]; // Assuming the "mony" column is the first column (index 0)

                if (row.style.display !== "none") {
                    total += parseFloat(cell.textContent);
                }
            }

            // Update the "الكلي" value
            totalDisplay.textContent = total.toFixed(2); // You can adjust the formatting as needed
        }


var deleteButtons = document.querySelectorAll('.delete-payment');
deleteButtons.forEach(function (button) {
    button.onclick = async function () {
        var idInput = this.closest('tr').querySelector('input[name="id"]');
        var id = idInput.value;

        // Show a confirmation dialog
        var confirmed = confirm('Are you sure you want to delete this payment?');

        if (confirmed) {
            try {
                // Send the delete request
                const response = await fetch(`/delPay/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token header
                    },
                });

                if (response.ok) {
                    // Delete request was successful, remove the table row
                    var tableRow = this.closest('tr');
                    tableRow.remove();
                    // Show a success message
                    showMessage('Payment deleted successfully.');

                    // Update the total money after deleting a row
                updateTotalsa()
                } else {
                    showMessage('Payment deleted successfully.');
                    updateTotalsa()
                }
            } catch (error) {
                console.error(error);
                showMessage('Payment deleted successfully.');
                updateTotalsa()
            }
        }
    };
});


////////edit
// Add click event handler to edit buttons
// Add click event handler to edit buttons
var editButtons = document.querySelectorAll('.edit-payment');
editButtons.forEach(function (button) {
    button.onclick = function () {
            var tableRow = this.closest('tr');
        var paymentId = tableRow.querySelector('input[name="id"]').value;
        document.getElementById('edit-payment-id').value = paymentId;
        document.getElementById('edit-modal').style.display = 'block';
        document.getElementById('edit-mySelect').focus();
    };
});
// Handle Shift key press to increase mony value
    document.getElementById('edit-mony').addEventListener('keydown', function(event) {
        if (event.key === 'Shift' || event.key === 'ShiftRight') {
            const monyInt = parseInt(this.value, 10);
            if (!isNaN(monyInt)) {
                this.value = monyInt + 1000;
            }
        }
    });

// Close the edit modal
document.getElementById('close-edit-modal').onclick = function () {
    document.getElementById('edit-modal').style.display = 'none';
};

// Handle the form submission for editing
// Handle the form submission for editing
document.getElementById('Edit-form').addEventListener('submit', function (event) {
    event.preventDefault(); // Prevent the form from submitting

    // Get the form data
    var formData = new FormData(this);

    // Send an AJAX request to update the payment
    fetch('/editPay', {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}', // Add CSRF token header
        },
    })
    .then(function (response) {
        if (response.ok) {
            // Edit request was successful, close the edit modal
            document.getElementById('edit-modal').style.display = 'none';

            // Show a success message
            // showMessage('Payment updated successfully.');
            showMessage('Payment updated successfully.');
            updateTotalsa()
            // Reload the page after a brief delay
            setTimeout(function() {

                window.location.reload();

            }, 1500);

        } else {
            showMessage('Error: Payment not updated.');
            updateTotalsa()
        }
    })
    .catch(function (error) {
        console.error(error);
        showMessage('Error: Payment not updated.');
        updateTotalsa()
    });
});


</script>

<div id="modal" class="modal">
    <div class="modal-content">
        <span class="close" id="close-modal">&times;</span>
        <h2>Add Payment</h2>
        <form id="Pay-form">
            @csrf
            <label for="name">Name:</label>
            <select id="mySelect" name="team_id" style="width: 130px" chosen-select  >
                @foreach ($team as $people )
                <option value="{{ $people->id }}"> {{ $people->name}} </option>
                @endforeach
            </select>
            <label for="mony">Mony:</label>
            <input type="number" id="mony" value="0" name="mony" required>
            <label for="reason">Reason:</label>
            <input type="text" id="reason" name="reason">
            <br><br><br>
            <button type="submit" class="btn-submit" id="submitPaymentButton">Submit</button>
        </form>
    </div>
</div>

<script>
    $(document).ready(function() {
        $("#mySelect").select2({
            tags: true,
            tokenSeparators: [',', ' '],
            createTag: function(params) {
                const term = $.trim(params.term);
                if (term === '') {
                    return null;
                }
                return {
                    id: term,
                    text: term,
                    newOption: true
                };
            }
        });
    });

        // Open modal when addPaymentButton is clicked
// Define an array to store existing option values
    const existingOptions = [];

    $(document).ready(function() {
        // Your existing code...

        // Open modal when addPaymentButton is clicked
        $("#addPaymentButton").click(function() {
            $("#modal").css("display", "block");
            $("#mySelect").select2("open");
            // Focus the select input explicitly using plain JavaScript
            setTimeout(function() {
                const selectInput = document.querySelector('.select2-search__field');
                if (selectInput) {
                    selectInput.value=null;
                    selectInput.focus();
                }
            }, 10);
        });

        // Your existing code...
    });
// Add an event listener for the "keydown" event on the document
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape' || event.key === 'Esc' || event.keyCode === 27) {
                // Check if the "Esc" key was pressed (key code 27)
                // Close the modal
                $("#modal").css("display", "none");
                // Reload the page
                location.reload();
            }

        });
        document.addEventListener('keydown', function(event) {
                if(modal.style.display === 'none'){
                    if (event.key === 'e' ||event.key === 'E' || event.key === 'ث' ) {
                        document.getElementById('addPaymentButton').click();
                    }
                }
                else{
                if (event.key === 'e' ||event.key === 'E' ||event.key === 'ث'  ) {
                    $("#modal").css("display", "none");

                    }
                }

            });


        // Close modal when close-modal is clicked
        $("#close-modal").click(function() {
            $("#modal").css("display", "none");
        });

        // Close modal when clicking outside the modal
        $(window).click(function(event) {
            if (event.target === document.getElementById('modal')) {
                $("#modal").css("display", "none");
            }
        });

        // Handle Shift key press to increase mony value
        $("#mony").keydown(function(event) {
            if (event.key === 'Shift' || event.key === 'ShiftRight') {
                const monyInt = parseInt($("#mony").val(), 10);
                if (!isNaN(monyInt)) {
                    $("#mony").val(monyInt + 1000);
                }
            }
        });

        // Ensure mony value is not less than 1
        $("#mony").change(function() {
            const monyInt = parseInt($("#mony").val(), 10);
            if (monyInt < 1) {
                $("#mony").val(0);
            }
        });

        $("#mySelect").select2({
        tags: true,
        tokenSeparators: [',', ' '],
        createTag: function(params) {
            const term = $.trim(params.term);
            if (term === '') {
                return null;
            }
            return {
                id: term,
                text: term,
                newOption: true
            };
        }
    });

    // Add an event listener for when new values are selected in the select input
    $("#mySelect").on("select2:select", function(e) {
        const selectedValue = e.params.data.id;
        saveTeam(selectedValue)
            .then(() => {
                // After saving the team, you can update the 'existingOptions' array
                existingOptions.push(selectedValue);
            })
            .catch(error => {
                console.error(error);
            });
    });

        // Pay form submission
       // ...

// Pay form submission
// ...

// Pay form submission
// ...

// Pay form submission
// ...

// Pay form submission
// ...

// Pay form submission
// Pay form submission
// Pay form submission
// Pay form submission
// Pay form submission
// Pay form submission
$("#Pay-form").submit(async function(event) {
    event.preventDefault(); // Prevent the form from submitting
    console.log("Form submitted");

    const formData = new FormData($("#Pay-form")[0]);
    const selectedValues = $("#mySelect").val();

    try {
        // Ensure selectedValues is an array
        const selectedArray = Array.isArray(selectedValues) ? selectedValues : [selectedValues];

        // Check if there are new values selected
        const newValues = selectedArray.filter(value => {
            // Replace 'existingOptions' with the array of existing option values
            return !existingOptions.includes(value);
        });

        if (newValues.length > 0) {
            // Save the new team values
            await saveTeam(newValues);
        }

        // Proceed with the addPay API call
        const response = await fetch('/addPay', {
            method: 'POST',
            body: formData,
        });

        if (response.ok) {
            // Form submission was successful
            const data = await response.json();
            showMessage('Success! Sale added.');

            // Clear the mony field
            $("#mony").val('');

            // Refocus on the select input
            $("#mySelect").select2('focus');

            // Refresh the page after a brief delay
            setTimeout(function() {
                window.location.reload();
            }, 1000); // Adjust the delay time as needed
        } else {
            showMessage('Success! Sale added.');
        }
    } catch (error) {
        console.error(error);
        showMessage('Success! Sale added.');
    }
});




// ...

// ...

// ...

// ...


// ...


        // Function to display the message
        function showMessage(messageText) {
            const message = document.getElementById('message');
            const messageContent = document.getElementById('message-content');

            messageContent.textContent = messageText;
            message.classList.add('success');
            message.style.display = 'block';

            setTimeout(() => {
                message.style.display = 'none';
            }, 3000);
        }

        // Function to save the team and return a Promise
// Function to save the team and return a Promise
// Function to save the team and return a Promise
// Function to save the team and return a Promise
function saveTeam(selectedValues) {
    return new Promise((resolve, reject) => {
        // Ensure selectedValues is an array
        if (!Array.isArray(selectedValues)) {
            selectedValues = [selectedValues];
        }

        // Filter out values that are numeric (assumed to be IDs)
        const newValues = selectedValues.filter(value => {
            // Check if the value is numeric (assumed to be an ID)
            return isNaN(value);
        });

        if (newValues.length > 0) {
            // There are new values to save
            $.ajax({
                url: '/saveTeam', // Replace with your API endpoint
                type: 'POST',
                data: {
                    _token: '{{ csrf_token() }}',
                    'name': newValues.join(', ') // Join the array into a comma-separated string
                },
                success: function(response) {
                    console.log('saveTeam API response:', response);
                    resolve();
                },
                error: function(error) {
                    console.error('saveTeam API error:', error);
                    reject(error);
                }
            });
        } else {
            // No new values to save, resolve immediately
            resolve();
        }
    });
}
(function(){
    if(localStorage.getItem('dark')!=null){
        document.body.style.color='white';

    }
})();

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
        margin: [0.2, 0, 0.01,0], // Adjust the margins as needed
        filename: 'payments.pdf',
        html2canvas: { scale: 2 },
        jsPDF: { unit: 'in', format: 'letter', orientation: 'landscape' }
    };
    // Generate the PDF from the cloned table
    html2pdf(tableToPrint,opt);


};

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


</script>





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
        const cell = row.cells[1]; // Assuming the "mony" column is the first column (index 0)

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



@endsection
