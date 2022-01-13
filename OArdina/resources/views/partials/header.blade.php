<div id="header">
	<div id="top_header">
		<div id="logo">
		{{-- <a href="{{ url('/OArdina') }}">
			@include('partials.svg.logo')
		</a> --}}
		@include('partials.svg.logo')
		</div>
		<div id="user_container">
			<div id="search">
				@include('partials.svg.icons.search')
			</div>
			<div id="user_box">
				@include('partials.svg.icons.user')
				{{-- <a href="{{ url('/login') }}">Iniciar Sessão</a>
				<a href="{{ url('/signup') }}">Criar Conta</a> --}}
			</div>
		</div>
	</div>
	<div id="navbar">
		<div id="navbar_sections">
			<ul>
				<li>	
					<a href="{{ url('/') }}"> Home</a>
				</li>
				<li>Nacional</li>
				<li>Local</li>
				<li>Justiça</li>
				<li>Mundo</li>
				<li>Economia</li>
				<li>Desporto</li>
				<li>Ciência</li>
				<li>Inovação</li>
				<li>Cultura</li>
			</ul>
		</div>
		<div id="sections_dropdown" class="dropdown">
			<span>Mais secções ></span>
			<div class="dropdown_content">
				<ul>
					<li>1</li>
					<li>2</li>
					<li>3</li>
				</ul>
			</div>
		</div>
	</div>
</div>