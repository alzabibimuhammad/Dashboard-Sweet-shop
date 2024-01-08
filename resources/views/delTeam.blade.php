@extends('layout')

<head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .container {
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start; /* Start from the left edge of the container */
            padding: 3  0px; /* Add padding to create space between the cards and the sidebar */
            margin-left: 400px; /* Set the left margin to 400px */
        }

        .card {
            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
            margin: 20px; /* Adjust margin to create more space between cards horizontally */
            margin-bottom: 20px; /* Add margin-bottom to increase vertical spacing between cards */
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
        #undelete{
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
    <h2 style="color: gray" >الغروبات المحذوفة</h2>
    <div id="search"style="margin-left: 800px;">
        <form action="DelTeam" style="display: inline-block;">
            @csrf
            <input type="text" name="term" placeholder="Search" style="padding: 8px; border: 1px solid #ccc; border-radius: 5px;">
            <button type="submit" name="submit" style="background-color: #007bff; color: #fff; border: none; border-radius: 5px; padding: 8px 15px; cursor: pointer;">Search</button>
        </form>
    </div>
</div>

<div class="container" id="containerID">

    @foreach ($DelTeam as $people )
    <div class="card" data-id="{{ $people->id }}">
        <img src="{{ $people->image }}" alt="{{ $people->image }}">

        <h2 style="color: gray">{{ $people->name }}</h2>


        <div class="button-container">
            <!-- Use the class for the delete button -->
            <button class="undelete-button" style="width: 100%" id='undelete' onclick="undel({{ $people->id }})">unDelete</button>
        </div>
    </div>
    @endforeach
</div>

<script>
    // Define the del function in the global scope
    function undel(id) {

        const modal = document.getElementById('myModal'); // Replace 'myModal' with the actual ID of your modal element
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const cardToDelete = document.querySelector(`.card[data-id="${id}"]`); // Select the card element to delete

        fetch('/undel', {
            method: 'post',
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
</script>

@endsection
