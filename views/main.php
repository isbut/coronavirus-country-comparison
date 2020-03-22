<main class="row">
	<div class="col-md-12 col-lg-9">
		
		<div class="row small-padding">

			<div class="col-6 text-center">
				<div data-country="0" class="country-info country1-info text-center">
					<div class="legend">Select country to compare:</div>
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
						<li class="info-population"><strong class="color-population">Population:</strong> <span></span></li>
						<li class="info-confirmed"><strong class="color-confirmed">Confirmed:</strong> <span></span></li>
						<li class="info-active"><strong class="color-active">Active:</strong> <span></span></li>
						<li class="info-deaths"><strong class="color-deaths">Deaths:</strong> <span></span></li>
						<li class="info-recovered"><strong class="color-recovered">Recovered:</strong><span></span></li>
						<li class="info-start"><strong class="color-start">Graph start:</strong> <span></span></li>
					</ul>
				</div>
			</div>
			
			<div class="col-6 text-center">
				<div data-country="1" class="country-info country2-info text-center">
					<div class="legend">Select country to compare:</div>
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
						<li class="info-population"><strong class="color-population">Population:</strong> <span></span></li>
						<li class="info-confirmed"><strong class="color-confirmed">Confirmed:</strong> <span></span></li>
						<li class="info-active"><strong class="color-active">Active:</strong> <span></span></li>
						<li class="info-deaths"><strong class="color-deaths">Deaths:</strong> <span></span></li>
						<li class="info-recovered"><strong class="color-recovered">Recovered:</strong> <span></span></li>
						<li class="info-start"><strong class="color-start">Graph start:</strong> <span></span></li>
					</ul>
				</div>
			</div>
			
			<div class="countries-extra-list col-md-12"></div>
			
		</div>

		<div class="row position-relative">
			<div class="country-add col-12 col-md-8">
				<div class="input-group">
					<select name="ca" class="custom-select">
						<?php
						foreach ($countries as $country => $country_data) {
							echo '<option value="' . $country . '">' . $country . '</option>';
						}
						?>
					</select>
					<div class="input-group-prepend">
						<button type="button" class="btn btn-dark">
							<strong>+</strong> Add country
						</button>
					</div>
				</div>
			</div>
			<div class="country-add-info col-12 col-md-4">
				You can add up to <?= $this->config['defaults']['countries_max'] - 2 ?> extra countries.
			</div>
		</div>

		<div class="row options row sticky-top">
			<div class="menu menu-mode">
				<label>Data mode</label>
				<div class="btn-group" role="group">
					<button type="button" data-value="absolute" class="btn btn-sm btn-outline-dark">Absolute</button>
					<button type="button" data-value="relative" class="btn btn-sm btn-outline-dark">Relative</button>
				</div>
				<i class="fas fa-question-circle" title="Absolute: Total number of cases. Relative: % relative to country population (in daily data, number of cases per <?= $this->config['defaults']['relative_num'] ?> habitants)." data-toggle="tooltip" data-placement="bottom"></i>
			</div>
			
			<div class="menu menu-start">
				<label>Graph start</label>
				<div class="btn-group" role="group">
					<button type="button" data-value="10" class="btn btn-sm btn-outline-dark">10</button>
					<button type="button" data-value="100" class="btn btn-sm btn-outline-dark">100</button>
					<button type="button" data-value="500" class="btn btn-sm btn-outline-dark">500</button>
				</div>
				<i class="fas fa-question-circle" title="Number of confirmed cases to start comparison." data-toggle="tooltip" data-placement="bottom"></i>
			</div>
			
			<div class="menu menu-graph">
				<label>Graph mode</label>
				<div class="btn-group" role="group">
					<button type="button" data-value="linear" class="btn btn-sm btn-outline-dark">Linear</button>
					<button type="button" data-value="logarithmic" class="btn btn-sm btn-outline-dark">Logarithmic</button>
				</div>
				<i class="fas fa-question-circle" title="Logarithmic Scale. A scale of measurement where the position is marked using the logarithm of a value instead of the actual value." data-toggle="tooltip" data-placement="bottom"></i>
			</div>
		</div>

		<div class="row">
		
			<div class="graph-container col-md-6">
				
				<div class="card position-relative">
					<div class="resizer">
						<button class="btn float-right"><i class="fas fa-arrows-alt-h"></i></button>
					</div>
					<div class="card-body">
						<div id="graph-confirmed" class="graph"></div>
					</div>
				</div>
				
			</div>
			
			<div class="graph-container col-md-6">
				
				<div class="card position-relative">
					<div class="resizer">
						<button class="btn float-right"><i class="fas fa-arrows-alt-h"></i></button>
					</div>
					<div class="card-body">
						<div>
						
						</div>
						<div id="graph-active" class="graph"></div>
					</div>
				</div>
				
			</div>
			
		</div>
		
		<div class="row">
			
			<div class="graph-container col-md-6">
				
				<div class="card position-relative">
					<div class="resizer">
						<button class="btn float-right"><i class="fas fa-arrows-alt-h"></i></button>
					</div>
					<div class="card-body">
						<div id="graph-deaths" class="graph"></div>
					</div>
				</div>
				
			</div>
			
			<div class="graph-container col-md-6">
				
				<div class="card position-relative">
					<div class="resizer">
						<button class="btn float-right"><i class="fas fa-arrows-alt-h"></i></button>
					</div>
					<div class="card-body">
						<div id="graph-recovered" class="graph"></div>
					</div>
				</div>
				
			</div>
			
		</div>
		
		<div class="row">
			
			<div class="col-md-12">
				
				<div class="card position-relative">
					<div class="card-body">
						<div id="graph-confirmed_daily" class="graph"></div>
					</div>
				</div>
				
			</div>
			
			<div class="col-md-12">
				
				<div class="card position-relative">
					<div class="card-body">
						<div id="graph-deaths_daily" class="graph"></div>
					</div>
				</div>
				
			</div>
			
			<div class="col-md-12">
				
				<div class="card position-relative">
					<div class="card-body">
						<div id="graph-recovered_daily" class="graph"></div>
					</div>
				</div>
				
			</div>
			
		</div>
		
		<div class="disclaimer">
			(*) Isbut declines all responsibility about the accuracy and veracity of the data shown here.<br />
			This information must not be used for medical purposes.
		</div>
		
	</div>

	<div class="col-md-12 col-lg-3">
		
		<div id="ranking-menu" class="dropdown">
			<button class="btn btn-dark btn-block dropdown-toggle" type="button" id="ranking-menu-button" data-toggle="dropdown">
				Confirmed
			</button>
			<div class="dropdown-menu" aria-labelledby="ranking-menu-button">
				<button class="dropdown-item" type="button" data-column="2">Confirmed</button>
				<button class="dropdown-item" type="button" data-column="3">Active</button>
				<button class="dropdown-item" type="button" data-column="4">Deaths</button>
				<button class="dropdown-item" type="button" data-column="5">Recovered</button>
			</div>
		</div>
		
		<div class="ranking-container">
			<table id="table-ranking" class="display" style="width: 100%;">
				<thead>
					<tr>
						<th>#</th>
						<th>Country</th>
						<th>Confirmed</th>
						<th>Active</th>
						<th>Deaths</th>
						<th>Recovered</th>
					</tr>
				</thead>
				<tbody>
					<?php
					$n = 1;
					foreach ($countries as $country => $country_data) {
						echo '<tr>
									<td>' . $n . '</td>
									<td>' . $country . '</td>
									<td>' . numberFormat($country_data['confirmed']) . '</td>
									<td>' . $country_data['active'] . '</td>
									<td>' . $country_data['deaths'] . '</td>
									<td>' . $country_data['recovered'] . '</td>
								</tr>';
						$n++;
					}
					?>
				</tbody>
			</table>
		</div>
	
	</div>
</main>