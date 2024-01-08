    @extends('layout')

    <head>
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <style>
            .container {
                display:flex ;
                flex-wrap: wrap;
                justify-content: flex-start; /* Start from the left edge of the container */
                padding: 3  0px; /* Add padding to create space between the cards and the sidebar */
                margin-left: 300px
            }

            .card {
                box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
                margin: 20px; /* Adjust margin to create more space between cards horizontally */
                margin-bottom: 10px; /* Add margin-bottom to increase vertical spacing between cards */
                text-align: center;
                font-family: arial;
                max-width: 250px;
            }


            .price {
                color: grey;
                font-size: 22px;
            }

            .card img {
                width: 250px;
                height: 250px;
            }

            /* Create a container for the buttons and use flexbox to display them horizontally */
            .button-container {
                display: flex;
                justify-content: space-between;
            }

            .card button {
                border: none;
                outline: 0;
                padding: 12px;
                color: white;
                background-color: #000;
                text-align: center;
                cursor: pointer;
                font-size: 18px;
                border-radius:10%;
            }

            .card button:hover {
                opacity: 0.7;
            }
            #edit{
                width: 40%;
                background-color: orange;
            }
            #delete{
                width: 60%;
                background-color: #3C91E6
            }
            .btn-submit {
            width: 10%;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            }
        </style>
    </head>


    @section('body')

    <div style=" margin-left: 300px; margin-top: 10px;display: flex;" id="container-header">
        <h1 style="color: gray">الأصناف </h1>
        <div id="search"style="margin-left: 800px;">
            <form action="products" style="display: inline-block;">
                @csrf
                <input type="text" name="term" placeholder="Search" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
                <button type="submit" name="submit" style="background-color: #007bff; color: #fff; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;">Search</button>
            </form>
        </div>
    </div>


    <div class="container" id="containerID" >
        @foreach ($index as $product)
        <div class="card" data-id="{{ $product->id }}">
            <form action="typeProfile"  id="form{{ $product->id }}">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">

                <img src="{{ $product->image }}" alt="{{ $product->image }}" onclick="submitForm({{ $product->id }})">

                <h1 style="color: gray">{{ $product->name }}</h1>
                <p class="price">{{ $product->price }}L.S</p>
            </form>
            <div class="button-container">
                <!-- Use the class for the delete button -->
                <button class="delete-button" id='delete' onclick="del({{ $product->id }})">Delete</button>
                <!-- Use the class for the edit button -->
                <button class="edit-button" id="edit" onclick="editProduct({{ $product->id }})">Edit</button>
            </div>
        </div>
        @endforeach
    </div>

    @endsection

    <script>
        // Define the del function in the global scope
        function del(id) {


            const modal = document.getElementById('myModal'); // Replace 'myModal' with the actual ID of your modal element
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const cardToDelete = document.querySelector(`.card[data-id="${id}"]`); // Select the card element to delete

            fetch('/deleteType', {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    'id': id
                }),
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (cardToDelete) {
                    cardToDelete.remove();
                }
                if (modal) {
                    modal.style.display = 'none';
                }
            })
            .catch(error => {
                console.error(error);
            });
        }
    </script>


    <div id="modal" class="modal"  >
        <div class="modal-content">
        <span class="close" id="close-modal">&times;</span>
        <h2>Edit product</h2>
        <form id="sale-form" action="editType" method="post" enctype="multipart/form-data">
            @csrf
            <input type="hidden" name="id" id="product-id" value="">

            <label for="type">Type:</label>
            <input type="text" id="type" name="type">

            <label for="price">Price:</label>
            <input type="number" id="price" name="price">
            <br><br>
            <label for="image">Image:</label>
            <input type="file" id="image" name="image">
            <br><br><br><br>

            <button type="submit" class="btn-submit" >Submit</button>
        </form>
        </div>
    </div>

    <script>
        let editProduct = id =>{
        const modal = document.getElementById('modal');
        const closeModal = document.getElementById('close-modal');
        const saleForm = document.getElementById('sale-form');
        const productTypeInput = document.getElementById('type');
        const productPriceInput = document.getElementById('price');
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        let currentEditId = id; // Store the ID of the currently edited product


        // Function to open the modal
        function openModal() {
            modal.style.display = 'block';
        }

        // Function to close the modal
        function closeModalHandler() {
            modal.style.display = 'none';
        }

        // Add event listener to close button
        closeModal.addEventListener('click', closeModalHandler);

        // Hide the modal when the user clicks outside of it
        window.addEventListener('click', (event) => {
            if (event.target === modal) {
                closeModalHandler();
            }
        });

        window.addEventListener('keydown', (event) => {
            if (event.key === 'Escape') {
                closeModalHandler();
            }
        });

        // Add event listener to all "Edit" buttons
    // Add event listener to all "Edit" buttons
        const editButtons = document.querySelectorAll('.edit-button');
        const productIDInput = document.getElementById('product-id');

        editButtons.forEach(editButton => {
            editButton.addEventListener('click', function () {
                const card = this.closest('.card');
                const productType = card.querySelector('h1').textContent;
                const productPrice = card.querySelector('.price').textContent.replace('L.S', ''); // Remove 'L.S' from the price
                const productId = card.getAttribute('data-id'); // Get the product ID from the data attribute

                // Set the values of the form inputs
                productTypeInput.value = productType;
                productPriceInput.value = productPrice;
                productIDInput.value = productId; // Set the product ID in the hidden input

                openModal(); // Open the modal after setting the values
            });
        });


        // saleForm.addEventListener('submit', (event) => {
        //     event.preventDefault();
        //     const formData = new FormData(saleForm);

        //     const productType = formData.get('type');
        //     const productPrice = formData.get('price');
        //     const productImage = formData.get('image');

        //     // Send the form data to the "ss" route using AJAX
        //     fetch('/editType/' + currentEditId +'/'+productType+'/'+productPrice+'/'+productImage, {
        //         method: 'post',// Assuming you are using PUT for editing
        //         headers: {
        //             'X-CSRF-TOKEN': csrfToken,
        //             'Content-Type': 'application/json',
        //         },
        //         body:JSON.stringify ({
        //             'type':productType,
        //             'price':productPrice,
        //             'image':productImage
        //         }),
        //     })
        //         .then(response => response.json())
        //         .then(data => {
        //             console.log(data);
        //             closeModalHandler();
        //         })
        //         .catch(error => {
        //             console.error(error);
        //         });
        // });
    }
    (function(){
        if(localStorage.getItem('dark')!=null){
            document.body.style.color='white';

        }
    })();

    function changeMargin() {
        if (localStorage.getItem('menu') == null) {
            document.getElementById('containerID').style.marginLeft = '60px';
            document.getElementById('container-header').style.marginLeft = '70px';



        } else {
            document.getElementById('containerID').style.marginLeft = '300px';
            document.getElementById('container-header').style.marginLeft = '300px';


        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        changeMargin();
    });

    setInterval(function() {
        changeMargin();
    }, 1000);


    function submitForm(id) {
            document.getElementById('form' + id).submit();
        }
    </script>
