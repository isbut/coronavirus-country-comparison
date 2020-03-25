	<footer class="row">
		<div class="app-info col-12 col-lg-8">
			<div class="isbut">Developed by <img src="images/logo-isbut.png" alt="Isbut Interactive">&nbsp;<a href="https://www.isbut.com/" title="Isbut Interactive">Isbut Interactive</a> - <a class="email" href="" title="Contact with Isbut Interactive">Contact us</a> - <span>Source code available at <a href="https://github.com/isbut/coronavirus-country-comparison" title="Source code">GitHub</a></span></div>
			<div class="source">Data source: <a href="https://github.com/CSSEGISandData/COVID-19">GitHub Data Repository by Johns Hopkins CSSE</a> (thank you!)</div>
		</div>
		<div class="share col-12 col-lg-4">
			<p>Share!</p>
			<ul>
				<li><a href="https://twitter.com/intent/tweet?text=<?= urlencode('Coronanirus COVID-19 Country Comparison - ' . $this->config['url']) ?>" class="btn" title="Twitter" target="_blank"><i class="fab fa-twitter"></i></a></li>
				<li><a href="https://www.facebook.com/sharer/sharer.php?u=<?= urlencode($this->config['url']) ?>" class="btn" title="Facebook" target="_blank"><i class="fab fa-facebook"></i></a></li>
				<li class="d-xl-none d-lg-none d-md-none"><a href="whatsapp://send?text=<?= urlencode('Coronanirus COVID-19 Country Comparison - ' . $this->config['url']) ?>" class="btn" title="Whatsapp" target="_blank"><i class="fab fa-whatsapp"></i></a></li>
				<li><a href="https://www.linkedin.com/shareArticle?mini=true&url=<?= urlencode($this->config['url']) ?>&title=<?= urlencode('Coronanirus COVID-19 Country Comparison - isbut.com') ?>&summary=&source=" class="btn" title="Linkedin" target="_blank"><i class="fab fa-linkedin"></i></a></li>
				<li><button type="button" data-clipboard-text="<?= $this->config['url'] ?>" class="btn copy"><i class="fas fa-link"></i></button></li>
			</ul>
		</div>
	</footer>

</div>
	
<script src="https://code.jquery.com/jquery-3.4.1.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
<script src="https://kit.fontawesome.com/bf4417eaae.js" crossorigin="anonymous"></script>
<script type="text/javascript" src="vendor/datatables/datatables.min.js"></script>
<script type="text/javascript" src="vendor/clipboard.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script src="js/app.js"></script>

<script>
	app.cfg.countries_selected = ['<?= $country1 ?>', '<?= $country2 ?>'];
	app.cfg.mode = '<?= $mode ?>';
	app.cfg.start = <?= $start ?>;
	app.cfg.graph_mode = '<?= $graph_mode ?>';
	app.cfg.relative_num = <?= $this->config['defaults']['relative_num'] ?>;
	app.cfg.countries_data = <?php include $this->config['paths']['data-json'] . '/' . $this->config['files']['countries']; ?>;
	app.cfg.countries_max = <?= $this->config['defaults']['countries_max'] ?>;
	app.cfg.graph_palette = <?= json_encode($this->config['defaults']['graph_palette']) ?>;
	app.cfg.info_palette = <?= json_encode($this->config['defaults']['info_palette']) ?>;
	app.cfg.xaxis_lapse = <?= $this->config['defaults']['xaxis_lapse'] ?>;
	app.cfg.app_info = <?php include $this->config['paths']['data-json'] . '/' . $this->config['files']['app-info']; ?>;
	app.cfg.cookie = <?= json_encode($this->config['defaults']['cookie']) ?>;
</script>

</body>

</html>