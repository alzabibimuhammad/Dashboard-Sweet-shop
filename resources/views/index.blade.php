@extends('layout')

    @section('body')


    <section id="content">

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">الصفحة الرئيسية</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="#">Home</a>
						</li>
					</ul>
				</div>
				{{-- <a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a> --}}
			</div>
			<ul class="box-info">
                <a href="sales">
                <li>
					<i class='bx bxs-shopping-bag-alt'  ></i>
					<span class="text">
						<h3>{{ $sales }}</h3>
						<p>المبيعات لليوم </p>
					</span>
				</li>
                </a>
                <a href="Payments">
                <li>
					<i class='bx bx-credit-card' style="color: rgb(215, 255, 209);background-color: rgb(25, 232, 218)"></i>
					<span class="text">
						<h3>{{ $payments}}</h3>
						<p>المدفوعات لليوم</p>
					</span>
				</li>
            </a>
            {{-- <a href="sales">

                <li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
						<h3>$2543</h3>
						<p>Total Sales</p>
					</span>
				</li>
            </a> --}}

            </ul>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Sales</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>Name</th>
								<th>Date</th>
								<th>Price</th>
							</tr>
						</thead>
						<tbody>
                            @foreach ($latestSales as $sale )
                            <tr>
                                {{-- <td>{{ $sale->name }}</td> --}}
								<td><span class="status completed" style="font-size: 14px" >{{ $sale->name }}</span></td>
                                <td>{{ $sale->created_at }}</td>

                                <td><span class="status pending" style="font-size: 14px">{{ $sale->price }}</span></td>
                            </tr>
                            @endforeach
							{{-- <tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status process">Process</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status pending">Pending</span></td>
							</tr>
							<tr>
								<td>
									<img src="img/people.png">
									<p>John Doe</p>
								</td>
								<td>01-10-2021</td>
								<td><span class="status completed">Completed</span></td>
							</tr> --}}
						</tbody>
					</table>
				</div>

                {{-- <div class="todo">
					<div class="head">
						<h3>Todos</h3>
						<i class='bx bx-plus' ></i>
						<i class='bx bx-filter' ></i>
					</div>
					<ul class="todo-list">
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
						<li class="not-completed">
							<p>Todo List</p>
							<i class='bx bx-dots-vertical-rounded' ></i>
						</li>
					</ul>
				</div>
			</div> --}}
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->



@endsection
