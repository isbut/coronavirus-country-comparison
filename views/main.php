<div class="row">
	
	<div class="col-md-9">
		
		<div class="row">
		
			<div class="graph-container col-md-6">
				
				<div class="card">
					<div class="resizer">
						<button class="btn float-right"><i class="fas fa-arrows-alt-h"></i></button>
					</div>
					<div class="card-body">
						<div id="graph-confirmed" class="graph"></div>
					</div>
				</div>
				
			</div>
			
			<div class="graph-container col-md-6">
				
				<div class="card">
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
				
				<div class="card">
					<div class="resizer">
						<button class="btn float-right"><i class="fas fa-arrows-alt-h"></i></button>
					</div>
					<div class="card-body">
						<div id="graph-deaths" class="graph"></div>
					</div>
				</div>
				
			</div>
			
			<div class="graph-container col-md-6">
				
				<div class="card">
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
				
				<div class="card">
					<div class="card-body">
						<div id="graph-confirmed_daily" class="graph"></div>
					</div>
				</div>
				
			</div>
			
			<div class="col-md-12">
				
				<div class="card">
					<div class="card-body">
						<div id="graph-deaths_daily" class="graph"></div>
					</div>
				</div>
				
			</div>
			
			<div class="col-md-12">
				
				<div class="card">
					<div class="card-body">
						<div id="graph-recovered_daily" class="graph"></div>
					</div>
				</div>
				
			</div>
			
		</div>
		
	</div>
	
	<div class="col-md-3">
		
		<div id="ranking-menu" class="dropdown">
			<button class="btn btn-secondary dropdown-toggle" type="button" id="ranking-menu-button" data-toggle="dropdown">
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
								<td>' . $country_data['confirmed'] . '</td>
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

</div>