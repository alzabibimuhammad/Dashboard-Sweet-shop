<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

    <title>Dawalibi</title>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Poppins:wght@400;500;600;700&display=swap');

* {
	margin: 0;
	padding: 0;
	box-sizing: border-box;
}

a {
	text-decoration: none;
}

li {
	list-style: none;
}

:root {
	--poppins: 'Poppins', sans-serif;
	--lato: 'Lato', sans-serif;

	--light: #F9F9F9;
	--blue: #3C91E6;
	--light-blue: #CFE8FF;
	--grey: #eee;
	--dark-grey: #AAAAAA;
	--dark: #342E37;
	--red: #DB504A;
	--yellow: #FFCE26;
	--light-yellow: #FFF2C6;
	--orange: #FD7238;
	--light-orange: #FFE0D3;
}

html {
	overflow-x: hidden;
}

body.dark {
	--light: #0C0C1E;
	--grey: #060714;
	--dark: #FBFBFB;
}

body {
	background: var(--grey);
	overflow-x: hidden;
}





/* SIDEBAR */
#sidebar {
	position: fixed;
	top: 0;
	left: 0;
	width: 280px;
	height: 100%;
	background: var(--light);
	z-index: 2000;
	font-family: var(--lato);
	transition: .3s ease;
	overflow-x: hidden;
	scrollbar-width: none;
}
#sidebar::--webkit-scrollbar {
	display: none;
}
#sidebar.hide {
	width: 60px;
}
#sidebar .brand {
	font-size: 24px;
	font-weight: 700;
	height: 56px;
	display: flex;
	align-items: center;
	color: var(--blue);
	position: sticky;
	top: 0;
	left: 0;
	background: var(--light);
	z-index: 500;
	padding-bottom: 20px;
	box-sizing: content-box;
}
#sidebar .brand .bx {
	min-width: 60px;
	display: flex;
	justify-content: center;
}
#sidebar .side-menu {
	width: 100%;
	margin-top: 48px;
}
#sidebar .side-menu li {
	height: 48px;
	background: transparent;
	margin-left: 6px;
	border-radius: 48px 0 0 48px;
	padding: 4px;
}
#sidebar .side-menu li.active {
	background: var(--grey);
	position: relative;
}
#sidebar .side-menu li.active::before {
	content: '';
	position: absolute;
	width: 40px;
	height: 40px;
	border-radius: 50%;
	top: -40px;
	right: 0;
	box-shadow: 20px 20px 0 var(--grey);
	z-index: -1;
}
#sidebar .side-menu li.active::after {
	content: '';
	position: absolute;
	width: 40px;
	height: 40px;
	border-radius: 50%;
	bottom: -40px;
	right: 0;
	box-shadow: 20px -20px 0 var(--grey);
	z-index: -1;
}
#sidebar .side-menu li a {
	width: 100%;
	height: 100%;
	background: var(--light);
	display: flex;
	align-items: center;
	border-radius: 48px;
	font-size: 16px;
	color: var(--dark);
	white-space: nowrap;
	overflow-x: hidden;
}
#sidebar .side-menu.top li.active a {
	color: var(--blue);
}
#sidebar.hide .side-menu li a {
	width: calc(48px - (4px * 2));
	transition: width .3s ease;
}
#sidebar .side-menu li a.logout {
	color: var(--red);
}
#sidebar .side-menu.top li a:hover {
	color: var(--blue);
}
#sidebar .side-menu li a .bx {
	min-width: calc(60px  - ((4px + 6px) * 2));
	display: flex;
	justify-content: center;
}
/* SIDEBAR */





/* CONTENT */
#content {
	position: relative;
	width: calc(100% - 280px);
	left: 280px;
	transition: .3s ease;
}
#sidebar.hide ~ #content {
	width: calc(100% - 60px);
	left: 60px;
}




/* NAVBAR */
#content nav {
	height: 56px;
	background: var(--light);
	padding: 0 24px;
	display: flex;
	align-items: center;
	grid-gap: 24px;
	font-family: var(--lato);
	position: sticky;
	top: 0;
	left: 0;
	z-index: 1000;
}
#content nav::before {
	content: '';
	position: absolute;
	width: 40px;
	height: 40px;
	bottom: -40px;
	left: 0;
	border-radius: 50%;
	box-shadow: -20px -20px 0 var(--light);
}
#content nav a {
	color: var(--dark);
}
#content nav .bx.bx-menu {
	cursor: pointer;
	color: var(--dark);
}
#content nav .nav-link {
	font-size: 16px;
	transition: .3s ease;
}
#content nav .nav-link:hover {
	color: var(--blue);
}
#content nav form {
	max-width: 400px;
	width: 100%;
	margin-right: auto;
}
#content nav form .form-input {
	display: flex;
	align-items: center;
	height: 36px;
}
#content nav form .form-input input {
	flex-grow: 1;
	padding: 0 16px;
	height: 100%;
	border: none;
	background: var(--grey);
	border-radius: 36px 0 0 36px;
	outline: none;
	width: 100%;
	color: var(--dark);
}
#content nav form .form-input button {
	width: 36px;
	height: 100%;
	display: flex;
	justify-content: center;
	align-items: center;
	background: var(--blue);
	color: var(--light);
	font-size: 18px;
	border: none;
	outline: none;
	border-radius: 0 36px 36px 0;
	cursor: pointer;
}
#content nav .notification {
	font-size: 20px;
	position: relative;
}
#content nav .notification .num {
	position: absolute;
	top: -6px;
	right: -6px;
	width: 20px;
	height: 20px;
	border-radius: 50%;
	border: 2px solid var(--light);
	background: var(--red);
	color: var(--light);
	font-weight: 700;
	font-size: 12px;
	display: flex;
	justify-content: center;
	align-items: center;
}
#content nav .profile img {
	width: 36px;
	height: 36px;
	object-fit: cover;
	border-radius: 50%;
}
#content nav .switch-mode {
	display: block;
	min-width: 50px;
	height: 25px;
	border-radius: 25px;
	background: var(--grey);
	cursor: pointer;
	position: relative;
}
#content nav .switch-mode::before {
	content: '';
	position: absolute;
	top: 2px;
	left: 2px;
	bottom: 2px;
	width: calc(25px - 4px);
	background: var(--blue);
	border-radius: 50%;
	transition: all .3s ease;
}
#content nav #switch-mode:checked + .switch-mode::before {
	left: calc(100% - (25px - 4px) - 2px);
}
/* NAVBAR */





/* MAIN */
#content main {
	width: 100%;
	padding: 36px 24px;
	font-family: var(--poppins);
	max-height: calc(100vh - 56px);
	overflow-y: auto;
}
#content main .head-title {
	display: flex;
	align-items: center;
	justify-content: space-between;
	grid-gap: 16px;
	flex-wrap: wrap;
}
#content main .head-title .left h1 {
	font-size: 36px;
	font-weight: 600;
	margin-bottom: 10px;
	color: var(--dark);
}
#content main .head-title .left .breadcrumb {
	display: flex;
	align-items: center;
	grid-gap: 16px;
}
#content main .head-title .left .breadcrumb li {
	color: var(--dark);
}
#content main .head-title .left .breadcrumb li a {
	color: var(--dark-grey);
	pointer-events: none;
}
#content main .head-title .left .breadcrumb li a.active {
	color: var(--blue);
	pointer-events: unset;
}
#content main .head-title .btn-download {
	height: 36px;
	padding: 0 16px;
	border-radius: 36px;
	background: var(--blue);
	color: var(--light);
	display: flex;
	justify-content: center;
	align-items: center;
	grid-gap: 10px;
	font-weight: 500;
}




#content main .box-info {
	display: grid;
	grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
	grid-gap: 24px;
	margin-top: 36px;
}
#content main .box-info li {
	padding: 24px;
	background: var(--light);
	border-radius: 20px;
	display: flex;
	align-items: center;
	grid-gap: 24px;
}
#content main .box-info li .bx {
	width: 80px;
	height: 80px;
	border-radius: 10px;
	font-size: 36px;
	display: flex;
	justify-content: center;
	align-items: center;
}
#content main .box-info li:nth-child(1) .bx {
	background: var(--light-blue);
	color: var(--blue);
}
#content main .box-info li:nth-child(2) .bx {
	background: var(--light-yellow);
	color: var(--yellow);
}
#content main .box-info li:nth-child(3) .bx {
	background: var(--light-orange);
	color: var(--orange);
}
#content main .box-info li .text h3 {
	font-size: 24px;
	font-weight: 600;
	color: var(--dark);
}
#content main .box-info li .text p {
	color: var(--dark);
}





#content main .table-data {
	display: flex;
	flex-wrap: wrap;
	grid-gap: 24px;
	margin-top: 24px;
	width: 100%;
	color: var(--dark);
}
#content main .table-data > div {
	border-radius: 20px;
	background: var(--light);
	padding: 24px;
	overflow-x: auto;
}
#content main .table-data .head {
	display: flex;
	align-items: center;
	grid-gap: 16px;
	margin-bottom: 24px;
}
#content main .table-data .head h3 {
	margin-right: auto;
	font-size: 24px;
	font-weight: 600;
}
#content main .table-data .head .bx {
	cursor: pointer;
}

#content main .table-data .order {
	flex-grow: 1;
	flex-basis: 500px;
}
#content main .table-data .order table {
	width: 100%;
	border-collapse: collapse;
}
#content main .table-data .order table th {
	padding-bottom: 12px;
	font-size: 13px;
	text-align: left;
	border-bottom: 1px solid var(--grey);
}
#content main .table-data .order table td {
	padding: 16px 0;
}
#content main .table-data .order table tr td:first-child {
	display: flex;
	align-items: center;
	grid-gap: 12px;
	padding-left: 6px;
}
#content main .table-data .order table td img {
	width: 36px;
	height: 36px;
	border-radius: 50%;
	object-fit: cover;
}
#content main .table-data .order table tbody tr:hover {
	background: var(--grey);
}
#content main .table-data .order table tr td .status {
	font-size: 10px;
	padding: 6px 16px;
	color: var(--light);
	border-radius: 20px;
	font-weight: 700;
}
#content main .table-data .order table tr td .status.completed {
	background: var(--blue);
}
#content main .table-data .order table tr td .status.process {
	background: var(--yellow);
}
#content main .table-data .order table tr td .status.pending {
	background: var(--orange);
}


#content main .table-data .todo {
	flex-grow: 1;
	flex-basis: 300px;
}
#content main .table-data .todo .todo-list {
	width: 100%;
}
#content main .table-data .todo .todo-list li {
	width: 100%;
	margin-bottom: 16px;
	background: var(--grey);
	border-radius: 10px;
	padding: 14px 20px;
	display: flex;
	justify-content: space-between;
	align-items: center;
}
#content main .table-data .todo .todo-list li .bx {
	cursor: pointer;
}
#content main .table-data .todo .todo-list li.completed {
	border-left: 10px solid var(--blue);
}
#content main .table-data .todo .todo-list li.not-completed {
	border-left: 10px solid var(--orange);
}
#content main .table-data .todo .todo-list li:last-child {
	margin-bottom: 0;
}
/* MAIN */
/* CONTENT */










@media screen and (max-width: 768px) {
	#sidebar {
		width: 200px;
	}

	#content {
		width: calc(100% - 60px);
		left: 200px;
	}

	#content nav .nav-link {
		display: none;
	}
}






@media screen and (max-width: 576px) {
	#content nav form .form-input input {
		display: none;
	}

	#content nav form .form-input button {
		width: auto;
		height: auto;
		background: transparent;
		border-radius: none;
		color: var(--dark);
	}

	#content nav form.show .form-input input {
		display: block;
		width: 100%;
	}
	#content nav form.show .form-input button {
		width: 36px;
		height: 100%;
		border-radius: 0 36px 36px 0;
		color: var(--light);
		background: var(--red);
	}

	#content nav form.show ~ .notification,
	#content nav form.show ~ .profile {
		display: none;
	}

	#content main .box-info {
		grid-template-columns: 1fr;
	}

	#content main .table-data .head {
		min-width: 420px;
	}
	#content main .table-data .order table {
		min-width: 420px;
	}
	#content main .table-data .todo .todo-list {
		min-width: 420px;
	}
}

.styled-table {
    border-collapse: collapse;
    margin-left: 400px;
    font-size: 0.9em;
    font-family: sans-serif;
    min-width: 1000px;
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.15);
}

.styled-table th,
.styled-table td {
    padding: 12px 15px;
    text-align: left;
    border-bottom: 1px solid #dddddd;
}

.styled-table th {
    background-color: #3C91E6;
    color: #ffffff;
}

.styled-table tbody tr:nth-of-type(even) {
    background-color: #f3f3f3;
}

.styled-table tbody tr:last-of-type {
    border-bottom: 2px solid #009879;
}

/* Add this CSS to your <style> section */
/* Container for the table with a maximum height and scrolling */

/* Container for the table with a maximum height and scrolling */
.table-container {
    max-height: 1200px; /* Adjust the max height as needed */
    overflow: auto;
    position: relative;
}

/* Style for the header table */
.header-table {
    table-layout: fixed;
    background-color: #fff; /* Optional: Set the background color for the header */
    margin-bottom: -1px; /* Remove the gap between header and body */
}

/* Style for the data table */
.data-table {
    table-layout: fixed;
    border-collapse: collapse; /* Optional: Collapse table borders */
}

/* Apply styles to the tbody for scrolling */
.data-table tbody {
    max-height: 320px; /* Adjust the max height as needed */
    overflow-y: auto; /* Add a scrollbar when content overflows */
    display: block;
}

/* Customize the scrollbar */
.data-table tbody::-webkit-scrollbar {
    width: 8px; /* Adjust scrollbar width as needed */
}

.data-table tbody::-webkit-scrollbar-thumb {
    background-color: #ccc; /* Adjust scrollbar color as needed */
    border-radius: 4px;
}

/* Style the table rows */
.data-table tbody tr {
    display: table;
    width: 100%; /* Optional: Make rows full width of the table */
    box-sizing: border-box; /* Optional: Include padding and border in width calculation */
}

/* add form sales table*/
/* Modal styles */
/* Modal styles */
.modal {
  display: none;
  position: fixed;
  z-index: 1;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  background-color: rgba(0, 0, 0, 0.5); /* Slightly transparent background */
  overflow: auto;
}

.modal-content {
  background-color: #fff; /* White background */
  margin: 10% auto;
  padding: 20px;
  border-radius: 5px;
  box-shadow: 0 0 10px rgba(0, 0, 0, 0.2); /* Subtle box shadow */
  max-width: 50%; /* Adjust as needed */
}

.close {
  position: absolute;
  top: 10px;
  right: 10px;
  font-size: 24px;
  color: #777; /* Light gray color for close button */
  cursor: pointer;
  transition: color 0.3s; /* Smooth color transition on hover */
}

.close:hover {
  color: #333; /* Darker color on hover */
}

/*end form*/
/* Style your form and other elements as needed */

/* CSS */
.switch-mode {
    display: flex;
    flex-direction: column;
    align-items: center;
    cursor: pointer;
}

.switch-label {
    margin-bottom: 4px; /* Adjust the spacing between the label and the sun icon */
    font-size: 14px; /* Adjust the font size of the label */
    color: var(--dark); /* Adjust the color of the label text */
}

.switch-mode .bx.bxs-sun {
    font-size: 24px;
    color: #FFD700;
}


    </style>
</head>
<body>

    @yield('nav')
<!-- SIDEBAR -->
<section id="sidebar">
    <a href="#" class="brand">
        <i class='bx bxs-smile'></i>
        <span class="text">Dawalibi</span>
    </a>
    <ul class="side-menu top">
        <li class="active">
            <a href="dashboard">
                <i class='bx bxs-dashboard' ></i>
                <span class="text">الصفحة الرئيسية</span>
            </a>
        </li>
        <li>
            <a href="sales">
                <i class='bx bxs-shopping-bag-alt' ></i>
                <span class="text">المبيعات</span>
            </a>
        </li>
        <li>
            <a href="Payments">
                <i class='bx bx-credit-card'></i> <!-- Replaced with credit card icon -->
                <span class="text">المدفوعات</span>
            </a>
        </li>
        <li>
            <a href="products">
                <i class='bx bx-category'></i> <!-- Replaced with category icon -->
                <span class="text">الاصناف</span>
            </a>
        </li>

        <li>
            <a href="/People">
                <i class='bx bxs-group' ></i>
                <span class="text">الغروبات</span>
            </a>
        </li>
    </ul>
    <ul class="side-menu">
        <li>
            <a href="AddType">
                <i class='bx bx-plus-circle'></i> <!-- Replaced with plus circle icon -->
                <span class="text">اضافة صنف</span>
            </a>
        </li>
        <li>
            <a href="AddTeam">
                <i class='bx bx-user-plus'></i> <!-- Replaced with user plus icon -->
                <span class="text">اضافة غروب</span>
            </a>
        </li>
        <li>
            <a href="DelType">
                <i class='bx bx-trash'></i> <!-- Replaced with trash icon -->
                <span class="text">الاصناف المحذوفة</span>
            </a>
        </li>
        <li>
            <a href="DelTeam">
                <i class='bx bx-user-minus'></i> <!-- Replaced with user minus icon -->
                <span class="text">الغروبات المحذوفة</span>
            </a>
        </li>
        {{-- <li>
            <a href="#" class="logout" id="logout-link">
                <i class='bx bx-log-out'></i>
                <span class="text">Exit</span>
            </a>
        </li> --}}

    </ul>
</section>
<!-- SIDEBAR -->
<section id="content">
    <!-- NAVBAR -->
    <nav>
        <i class='bx bx-menu' ></i>
        <form >
            <div class="form-input">
                <input type="hidden" placeholder="Search...">
                <button type="submit" class="search-btn"><i class='bx ' ></i></button>
            </div>
        </form>
        <input type="checkbox" id="switch-mode" hidden>
        <label for="switch-mode" class="switch-mode">
            <i class='bx bxs-sun'></i> <!-- Add the sun icon here -->
        </label>

        {{-- <a href="#" class="notification">
            <i class='bx bxs-bell' ></i>
            <span class="num">8</span>
        </a> --}}
        <a href="#" class="profile">
        </a>
    </nav>
    <!-- NAVBAR -->
    </section>

    @yield('body')

</body>
<script>
    const allSideMenu = document.querySelectorAll('#sidebar .side-menu.top li a');
    const switchMode = document.getElementById('switch-mode');

(function (){

    if (localStorage.getItem('switch') != null){

    if(localStorage.getItem('dark') != null){
        document.body.classList.add('dark');
    }
    }
})();



allSideMenu.forEach(item=> {
	const li = item.parentElement;

	item.addEventListener('click', function () {
		allSideMenu.forEach(i=> {
			i.parentElement.classList.remove('active');
		})
		li.classList.add('active');
	})
});



// TOGGLE SIDEBAR
const menuBar = document.querySelector('#content nav .bx.bx-menu');
const sidebar = document.getElementById('sidebar');

menuBar.addEventListener('click', function () {
	sidebar.classList.toggle('hide');
    if(localStorage.getItem('menu'))
        localStorage.removeItem('menu')
    else
        localStorage.setItem('menu',innerWidth)
})




const searchButton = document.querySelector('#content nav form .form-input button');
const searchButtonIcon = document.querySelector('#content nav form .form-input button .bx');
const searchForm = document.querySelector('#content nav form');

searchButton.addEventListener('click', function (e) {
	if(localStorage.getItem('menu') < 576) {
		e.preventDefault();
		searchForm.classList.toggle('show');
		if(searchForm.classList.contains('show')) {
			searchButtonIcon.classList.replace('bx-search', 'bx-x');
		} else {
			searchButtonIcon.classList.replace('bx-x', 'bx-search');
		}

	}
})





if(localStorage.getItem('menu') < 768) {
	sidebar.classList.add('hide');
} else if(localStorage.getItem('menu') > 576) {
	searchButtonIcon.classList.replace('bx-x', 'bx-search');
	searchForm.classList.remove('show');

}


window.addEventListener('resize', function () {
	if(localStorage.getItem('menu') > 576) {
		searchButtonIcon.classList.replace('bx-x', 'bx-search');
		searchForm.classList.remove('show');
	}
})




switchMode.addEventListener('change', function () {

    if(this.checked) {
        localStorage.setItem('switch',true);
	} else {
        localStorage.setItem('switch',false);
	}

    let storedValue = localStorage.getItem('switch');

    if (storedValue === 'true' || storedValue === 'True') {
        console.log('true');
        document.body.classList.add('dark');
        localStorage.setItem('dark','dark');
    } else {
        console.log('false');
        document.body.classList.remove('dark');
        localStorage.removeItem('dark');

    }


});


(function(){
    if(localStorage.getItem('dark') != null)
        switchMode.checked = true;
})();

</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.3.1/jspdf.umd.min.js"></script>

{{-- /* for form*/ --}}

{{-- end form  --}}
</html>