	<footer class="row">
		<div class="app-info col-12 col-lg-8">
			<div class="isbut">Developed by <img src="images/logo-isbut.png" alt="Isbut Interactive">&nbsp;<a href="https://www.isbut.com/" title="Isbut Interactive">Isbut Interactive</a> - <span>Source code available at <a href="https://github.com/isbut/coronavirus-country-comparison" title="Source code">GitHub</a></span></div>
			<div class="source">Data source: <a href="https://github.com/CSSEGISandData/COVID-19">GitHub Data Repository by Johns Hopkins CSSE</a> (thank you!)</div>
		</div>
		<div class="share col-12 col-lg-4">
			<p>Share!</p>
			<ul>
				<li><button type="button" class="btn" title="Twitter"><i class="fab fa-twitter"></i></button></li>
				<li><button type="button" class="btn" title="Facebook"><i class="fab fa-facebook"></i></button></li>
				<li><button type="button" class="btn" title="Whatsapp"><i class="fab fa-whatsapp"></i></button></li>
				<li><button type="button" class="btn" title="Copy link"><i class="fas fa-link"></i></button></li>
			</ul>
		</div>
	</footer>

</div>
	
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/bf4417eaae.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="vendor/datatables/datatables.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="js/app.js"></script>

<script>
	app.cfg.countries_selected = ['<?= $country1 ?>', '<?= $country2 ?>'];
	app.cfg.mode = '<?= $mode ?>';
	app.cfg.start = <?= $start ?>;
	app.cfg.graph_mode = '<?= $graph_mode ?>';
	app.cfg.relative_num = <?= $this->config['defaults']['relative_num'] ?>;
	app.cfg.countries_data = <?php include PUBLIC_PATH . $this->config['folders']['data-json'] . '/' . $this->config['files']['countries']; ?>;
	app.cfg.countries_max = <?= $this->config['defaults']['countries_max'] ?>;
	app.cfg.graph_palette = <?= json_encode($this->config['defaults']['graph_palette']) ?>;
</script>

</body>

</html>