@extends('layout')

@section('body')
<style>
    .form-container {
        margin: 100px auto;
        width: 400px;
        padding: 20px;
        border: 1px solid #ccc;
        border-radius: 5px;
        background-color: #f9f9f9;
    }

    .custom-form {
        text-align: left;
    }

    .form-group {
        margin-bottom: 20px;
    }

    label {
        font-weight: bold;
    }

    input[type="text"],
    input[type="number"],
    input[type="file"] {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
    }

    .btn-submit {
        background-color: #007bff;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .btn-submit:hover {
        background-color: #0056b3;
    }
</style>


<div class="form-container" id="container" >
    <form class="custom-form" method="POST" action="saveTeam" enctype="multipart/form-data">
        @csrf
        <h2>Add a New Team Member</h2><br>
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" placeholder="Enter the Type name" required >
        </div>
        <div class="form-group">
            <label for="image">Image:</label>
            <input type="file" id="image" name="image" accept="image/*" >
        </div>
        <div class="form-group">
            <button type="submit" class="btn-submit">Submit</button>
        </div>
    </form>
</div>

<script>
    function colorBack() {
        var bodyBackgroundColor = getComputedStyle(document.body).backgroundColor;

        // Apply the body's background color to the .box-footer
        var boxFooter = document.getElementById('container');
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

@endsection
