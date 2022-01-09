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
				<svg width="24" height="24" xmlns="http://www.w3.org/2000/svg" fill-rule="evenodd" clip-rule="evenodd"><path d="M15.853 16.56c-1.683 1.517-3.911 2.44-6.353 2.44-5.243 0-9.5-4.257-9.5-9.5s4.257-9.5 9.5-9.5 9.5 4.257 9.5 9.5c0 2.442-.923 4.67-2.44 6.353l7.44 7.44-.707.707-7.44-7.44zm-6.353-15.56c4.691 0 8.5 3.809 8.5 8.5s-3.809 8.5-8.5 8.5-8.5-3.809-8.5-8.5 3.809-8.5 8.5-8.5z"/></svg>
			</div>
			<div id="user_box"><a href="{{ url('/login') }}">Iniciar Sessão</a></div>
			<div id="user_box"><a href="{{ url('/signup') }}">Criar Conta</a></div>
		</div>
	</div>
	<div id="navbar">
		<div id="navbar_sections">
			<ul>
				<li>	
					<a href="{{ url('/OArdina') }}"> Home</a>
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