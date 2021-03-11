<!DOCTYPE HTML>
<!--
	Big Picture by HTML5 UP
	html5up.net | @ajlkn
	Free for personal and commercial use under the CCA 3.0 license (html5up.net/license)
-->
<html>
	<head>
		<title>DND char craetor</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="resources/css/main.min.css" />
		<noscript><link rel="stylesheet" href="resources/css/noscript.css" /></noscript>
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <script src="https://polyfill.io/v3/polyfill.min.js?features=IntersectionObserver"></script>
	</head>
	<body  class="is-preload">
		<!-- Header -->
			<header id="header">
				<h1>Big Picture</h1>
				<nav>
					<ul>
						<li><a href="#intro">Intro</a></li>
						<li><a href="#one">What I Do</a></li>
						<li><a href="#two">Who I Am</a></li>
						<li><a href="#work">My Work</a></li>
						<li><a href="#contact">Contact</a></li>
					</ul>
				</nav>
			</header>
            <div id="app">
                @yield('content')
            </div>



		<!-- Scripts -->
            <script src="public/js/app.js"></script>
			<script src="resources/js/jquery.min.js"></script>
			<script src="resources/js/jquery.poptrox.min.js"></script>
			<script src="resources/js/jquery.scrolly.min.js"></script>
			<script src="resources/js/jquery.scrollex.min.js"></script>
			<script src="resources/js/browser.min.js"></script>
			<script src="resources/js/breakpoints.min.js"></script>
			<script src="resources/js/util.js"></script>
			<script src="resources/js/main.js"></script>

	</body>
</html>
