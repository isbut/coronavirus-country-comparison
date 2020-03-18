<body>

<div class="container">

	<header><h1>Coronavirus COVID-19 Country Comparison</h1></header>
	
	<div class="jumbotron">
		Texto introductorio
	</div>
	
	<div class="row">
		
		<div class="col-md-9">
			
			<div class="row">
				
				<div data-country="0" class="country-info country1-info col-md-6 text-center">
					<div class="select-wrapper">
						<select name="c1" class="custom-select">
							<?php
							foreach ($countries as $country => $country_data) {
								echo '<option value="' . $country . '">' . $country . '</option>';
							}
							?>
						</select>
					</div>
					<ul class="list-group">
						<li class="info-population"><strong class="color-population">Population:</strong><span></span></li>
						<li class="info-confirmed"><strong class="color-confirmed">Confirmed:</strong><span></span></li>
						<li class="info-active"><strong class="color-active">Active:</strong><span></span></li>
						<li class="info-deaths"><strong class="color-deaths">Deaths:</strong><span></span></li>
						<li class="info-recovered"><strong class="color-recovered">Recovered:</strong><span></span></li>
					</ul>
				</div>
				
				<div data-country="1" class="country-info country2-info col-md-6 text-center">
					<div class="select-wrapper">
						<select name="c2" class="custom-select">
							<?php
							foreach ($countries as $country => $country_data) {
								echo '<option value="' . $country . '">' . $country . '</option>';
							}
							?>
						</select>
					</div>
					<ul class="list-group">
						<li class="info-population"><strong class="color-population">Population:</strong><span></span></li>
						<li class="info-confirmed"><strong class="color-confirmed">Confirmed:</strong><span></span></li>
						<li class="info-active"><strong class="color-active">Active:</strong><span></span></li>
						<li class="info-deaths"><strong class="color-deaths">Deaths:</strong><span></span></li>
						<li class="info-recovered"><strong class="color-recovered">Recovered:</strong><span></span></li>
					</ul>
				</div>
				
				<div class="countries-extra-list col-md-12"></div>
				
			</div>
			
		</div>
		
		<div class="country-add col-md-3">
			
			<select name="ca" class="custom-select">
				<?php
				foreach ($countries as $country => $country_data) {
					echo '<option value="' . $country . '">' . $country . '</option>';
				}
				?>
			</select>
			<button type="button" class="btn btn-outline-secondary">Add country</button>
		
		</div>
	
	</div>
	
	<div class="options row sticky-top">
		
		<div class="menu-mode col-md-3">
			<label>Data mode</label>
			<div class="btn-group" role="group">
				<button type="button" data-value="absolute" class="btn btn-sm btn-outline-secondary">Absolute</button>
				<button type="button" data-value="relative" class="btn btn-sm btn-outline-secondary">Relative</button>
			</div>
			<i class="fas fa-question-circle" title="Absolute: Total number of cases. Relative: % relative to country population (in daily data, number of cases per <?= $this->config['defaults']['relative_num'] ?> habitants)." data-toggle="tooltip" data-placement="bottom"></i>
		</div>
		
		<div class="menu-start col-md-3">
			<label>Graph start</label>
			<div class="btn-group" role="group">
				<button type="button" data-value="10" class="btn btn-sm btn-outline-secondary">10</button>
				<button type="button" data-value="100" class="btn btn-sm btn-outline-secondary">100</button>
				<button type="button" data-value="500" class="btn btn-sm btn-outline-secondary">500</button>
			</div>
			<i class="fas fa-question-circle" title="Number of confirmed cases to start comparison." data-toggle="tooltip" data-placement="bottom"></i>
		</div>
		
		<div class="menu-graph col-md-3">
			<label>Graph mode</label>
			<div class="btn-group" role="group">
				<button type="button" data-value="linear" class="btn btn-sm btn-outline-secondary">Linear</button>
				<button type="button" data-value="logarithmic" class="btn btn-sm btn-outline-secondary">Logarithmic</button>
			</div>
			<i class="fas fa-question-circle" title="Logarithmic Scale. A scale of measurement where the position is marked using the logarithm of a value instead of the actual value." data-toggle="tooltip" data-placement="bottom"></i>
		</div>
		
	</div>