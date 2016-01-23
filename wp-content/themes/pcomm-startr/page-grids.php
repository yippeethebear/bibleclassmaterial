<?php 
/* Template Name: Grids */

get_header(); ?>

<div class="wrap_body">
	<section role="main">
		<div class="container">
			<h1>Grid Tests</h1>
		</div>

		<div class="container">
			<!-- 12 columns -->
			<div class="grid_tests">
				<h2>Twelve columns</h2>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
				<div class="col-1">
					<p>.col-1</p>
				</div>
			</div>
		</div>

		<div class="container">
			<!-- 6 columns -->
			<div class="grid_tests">
				<h2>Six columns</h2>
				<div class="col-2">
					<p>.col-2</p>
				</div>
				<div class="col-2">
					<p>.col-2</p>
				</div>
				<div class="col-2">
					<p>.col-2</p>
				</div>
				<div class="col-2">
					<p>.col-2</p>
				</div>
				<div class="col-2">
					<p>.col-2</p>
				</div>
				<div class="col-2">
					<p>.col-2</p>
				</div>
			</div>
		</div>

		<div class="container">
			<!-- 4 columns -->
			<div class="grid_tests">
				<h2>Four columns</h2>
				<div class="col-3">
					<p>.col-3</p>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
			</div>
		</div>

		<div class="container">
			<!-- 3 columns -->
			<div class="grid_tests">
				<h2>Three columns</h2>
				<div class="col-4">
					<p>.col-4</p>
				</div>
				<div class="col-4">
					<p>.col-4</p>
				</div>
				<div class="col-4">
					<p>.col-4</p>
				</div>
			</div>
		</div>

		<div class="container">
			<!-- 2 columns -->
			<div class="grid_tests">
				<h2>Two columns</h2>
				<div class="col-6">
					<p>.col-6</p>
				</div>
				<div class="col-6">
					<p>.col-6</p>
				</div>
			</div>
		</div>

		<div class="container">
			<!-- 1 column -->
			<div class="grid_tests">
				<h2>One column</h2>
				<div class="col-12">
					<p>.col-12</p>
				</div>
			</div>
		</div>

		<div class="container">
			<!-- 8-4 column -->
			<div class="grid_tests">
				<h2>Eight-Four column layout</h2>
				<div class="col-8">
					<p>.col-8</p>
				</div>
				<div class="col-4">
					<p>.col-4</p>
				</div>
			</div>
		</div>

		<div class="container">
			<!-- 6-3-3 column -->
			<div class="grid_tests">
				<h2>Six-Three-Three column layout</h2>
				<div class="col-6">
					<p>.col-6</p>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
			</div>
		</div>

		<div class="container">
			<!-- 2-7-3 column -->
			<div class="grid_tests">
				<h2>Two-Seven-Three column layout</h2>
				<div class="col-2">
					<p>.col-2</p>
				</div>
				<div class="col-7">
					<p>.col-7</p>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
			</div>
		</div>

		<div class="container">
			<h1>Nested Grids</h1>
		</div>

		<div class="container">
			<!-- 12 columns -->
			<div class="grid_tests">
				<h2>Nine-Three nested (same context)</h2>
				<div class="col-9">
					<div class="container">
						<div class="inner-col-3">
							<p>.inner-col-3</p>
						</div>
						<div class="inner-col-3">
							<p>.inner-col-3</p>
						</div>
						<div class="inner-col-3">
							<p>.inner-col-3</p>
						</div>
					</div>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
			</div>
			<div class="grid_tests">
				<h2>Nine-Three nested (new context)</h2>
				<div class="col-9">
					<div class="container-3">
						<div class="inner-col">
							<p>.inner-col</p>
						</div>
						<div class="inner-col">
							<p>.inner-col</p>
						</div>
						<div class="inner-col">
							<p>.inner-col</p>
						</div>
					</div>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
			</div>

			<div class="grid_tests">
				<h2>Nine-Three nested (new context &amp; new grid)</h2>
				<div class="col-9">
					<div class="container-5">
						<div class="inner-col-5">
							<p>.inner-col-5</p>
						</div>
						<div class="inner-col-5">
							<p>.inner-col-5</p>
						</div>
						<div class="inner-col-5">
							<p>.inner-col-5</p>
						</div>
						<div class="inner-col-5">
							<p>.inner-col-5</p>
						</div>
						<div class="inner-col-5">
							<p>.inner-col-5</p>
						</div>
					</div>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
			</div>

			<div class="grid_tests">
				<h2>Nine-Three nested (grid isolated)</h2>
				<div class="col-9">
					<div class="container-4">
						<div class="inner-col-4">
							<p>.inner-col-4</p>
						</div>
						<div class="inner-col-4">
							<p>.inner-col-4</p>
						</div>
						<div class="inner-col-4">
							<p>.inner-col-4</p>
						</div>
						<div class="inner-col-4">
							<p>.inner-col-4</p>
						</div>
					</div>
				</div>
				<div class="col-3">
					<p>.col-3</p>
				</div>
			</div>
		</div>
	</section>
</div>

<?php get_header(); ?>