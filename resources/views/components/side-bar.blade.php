<!-- Sidebar -->
<ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

	<!-- Sidebar - Brand -->
	<a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
		<div class="sidebar-brand-text mx-3">Europa 3</div>
	</a>

	<x-side-bar-divider />
	<li class="nav-item">
		<a class="nav-link" href="index.html">
			<i class="fas fa-users"></i>
			<span>Inicio</span>
		</a>
	</li>

	<x-side-bar-divider />
	<x-side-bar-heading title="Solicitudes" />
	<li class="nav-item">
		<a class="nav-link" href="charts.html">
			<i class="fas fa-fw fa-chart-area"></i>
			<span>Usuarios</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="charts.html">
			<i class="far fa-newspaper"></i>
			<span>Solicitudes</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="charts.html">
			<i class="fas fa-walking"></i>
			<span>Solicitudes de visita</span>
		</a>
	</li>

	<x-side-bar-divider />
	<x-side-bar-heading title="Mobiliario y servicios" />
	<li class="nav-item">
		<a class="nav-link" href="{{ route('dashboard.mobiliario.index') }}">
			<i class="fas fa-chair"></i>
			<span>Mobiliario</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('dashboard.adicionales.index') }}">
			<i class="fas fa-mug-hot"></i>
			<span>Adicionales</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('dashboard.servicios.index') }}">
			<i class="fas fa-concierge-bell"></i>
			<span>Servicios</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('dashboard.idiomas-atencion.index') }}">
			<i class="fa fa-comment"></i>
			<span>Idiomas de atención</span>
		</a>
	</li>

	<x-side-bar-divider />
	<x-side-bar-heading title="Oficinas" />
	<li class="nav-item">
		<a class="nav-link" href="{{ route('dashboard.edificios.index') }}">
			<i class="fas fa-building"></i>
			<span>Edificios</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="{{ route('dashboard.oficinas.index') }}">
			<i class="fas fa-briefcase"></i>
			<span>Oficinas fisicas</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="charts.html">
			<i class="fas fa-couch"></i>
			<span>Sala de juntas</span>
		</a>
	</li>
	<li class="nav-item">
		<a class="nav-link" href="charts.html">
			<i class="fas fa-laptop"></i>
			<span>Oficinas virtuales</span>
		</a>
	</li>


	{{-- <!-- Nav Item - Charts -->
	<li class="nav-item">
		<a class="nav-link" href="charts.html">
			<i class="fas fa-fw fa-chart-area"></i>
			<span>Charts</span></a>
	</li>

	<!-- Nav Item - Tables -->
	<li class="nav-item">
		<a class="nav-link" href="tables.html">
			<i class="fas fa-fw fa-table"></i>
			<span>Tables</span></a>
	</li> --}}

	<x-side-bar-divider />
	<x-side-bar-heading title="Configuración" />
	<li class="nav-item">
		<a class="nav-link" href="charts.html">
			<i class="fas fa-user-shield"></i>
			<span>Gestión de usuarios</span>
		</a>
	</li>


	<hr class="sidebar-divider d-none d-md-block">
	<div class="text-center d-none d-md-inline">
		<button class="rounded-circle border-0" id="sidebarToggle"></button>
	</div>



</ul>
