var app = {
	
	cfg: {
		
		app_info: {},
		countries_selected: {},
		mode: '',
		start: 0,
		graph_mode: '',
		relative_num: 0,
		countries_data: {},
		graph_palette: [],
		info_palette: [],
		xaxis_lapses: {},
		initialized: false,
		charts: {
			confirmed: null,
			active: null,
			deaths: null,
			recovered: null,
		},
		ranking_table: null,
		xaxis_labels: [],
		cookie: {},
		
	},
	
	init: function () {
		
		$('div.country-info select').on('change', function () {
			app.country.change($(this).closest('div.country-info').attr('data-country'), $(this).val());
		});
		
		$('header div.update mark').html(app.cfg.app_info.last_update);
		
		$('div.country-add select').val($('div.country-add select option').first().attr('value'));
		$('div.country-add button').on('click', app.country.extraAdd);
		$(document).on('click', 'div.countries-extra-list button.close', app.country.extraRemove);
		
		$('div.menu-mode button').on('click', function () {
			app.options.changeMode($(this).attr('data-value'));
		});
		$('div.menu-start button').on('click', function () {
			app.options.changeStart($(this).attr('data-value'));
		});
		$('div.menu-graph button').on('click', function () {
			app.options.changeGraphMode($(this).attr('data-value'));
		});
		
		$('div.graph-container div.resizer button').on('click', app.graphs.resize);
		
		$('[data-toggle="tooltip"]').tooltip();
		
		app.cfg.ranking_table = $('#table-ranking').DataTable({
			ordering: true,
			paging: false,
			searching: false,
			info: false,
			columns: [
				{ orderable: false },
				{  },
				{  },
				{ visible: false },
				{ visible: false },
				{ visible: false },
			],
			order: [
				[2, 'desc']
			],
			language: {
				decimal: ",",
				thousands: "."
			},
			initComplete: function () {
				app.ranking.reorder();
				$('#ranking-menu').fadeIn();
				$('#table-ranking').fadeIn();
			},
		});
		app.cfg.ranking_table
			.on('order.dt', app.ranking.reorder);
		
		$('#ranking-menu button.dropdown-item').on('click', app.ranking.change);
		
		$('footer a.email').attr('href', 'mailto:coronavirus@isbut.com');
		
		var copylink = new ClipboardJS('footer .share .copy');
		copylink.on('success', function(e) {
			$('footer .share .copy').tooltip({
				placement: 'top',
				trigger: 'manual',
				title: 'Link copied',
			}).tooltip('show');
			setTimeout(function () {
				$('footer .share .copy').tooltip('hide').tooltip('dispose');
			}, 2000);
		});
		copylink.on('error', function(e) {
			$('footer .share .copy').tooltip({
				placement: 'top',
				trigger: 'manual',
				title: 'Link NOT copied, sorry!',
			}).tooltip('show');
			setTimeout(function () {
				$('footer .share .copy').tooltip('hide').tooltip('dispose');
			}, 2000);
		});
		
		app.country.change(0, app.cfg.countries_selected[0], true);
		app.country.change(1, app.cfg.countries_selected[1], true);
		app.options.changeMode(app.cfg.mode, true);
		app.options.changeStart(app.cfg.start, true);
		app.options.changeGraphMode(app.cfg.graph_mode, true);
		app.graphs.refresh();
		
		app.cfg.initialized = true;
		
	},
	
	country: {
		
		change: function(num, country, init) {
			
			init = typeof init === 'undefined' ? false : init;
			
			$('div[data-country="' + num + '"] select').val(country);
			
			app.country.setInfo(num, country);
			
			app.cfg.countries_selected[num] = country;
			
			app.country.setCookie();
			
			if (!init) {
				app.graphs.refresh();
			}
			
		},
		
		setInfo: function(num, country) {
			
			var country_info = $('div[data-country="' + num + '"]');
			var country_data = app.cfg.countries_data[country];
			
			country_info.find('li.info-population span').html(app.aux.numberFormat(country_data['population']));
			country_info.find('li.info-confirmed span').html(app.aux.numberFormat(country_data['confirmed']));
			country_info.find('li.info-active span').html(app.aux.numberFormat(country_data['active']));
			country_info.find('li.info-deaths span').html(app.aux.numberFormat(country_data['deaths']));
			country_info.find('li.info-recovered span').html(app.aux.numberFormat(country_data['recovered']));
			
		},
		
		extraAdd: function () {
			
			var country = $(this).closest('div.country-add').find('select').val();
			var country_data = app.cfg.countries_data[country];
			var extra_num = $('div.countries-extra-list div.country-extra').length;
			
			var html = '<div class="country-extra" data-country="' + (extra_num + 2) + '" data-country-name="' + country + '">'
				+ '<ul class="list-group list-group-horizontal">'
				+ '<li class="list-group-item list-group-item-secondary">' + country
				+ '<div class="info-start"><strong class="color-start">Graph start:</strong> <span></span></div>'
				+ '</li>'
				+ '<li class="list-group-item"><strong class="color-population">Population:</strong> <span>' + app.aux.numberFormat(country_data['population']) + '</span></li>'
				+ '<li class="list-group-item"><strong class="color-confirmed">Confirmed:</strong> <span>' + app.aux.numberFormat(country_data['confirmed']) + '</span></li>'
				+ '<li class="list-group-item"><strong class="color-active">Active:</strong> <span>' + app.aux.numberFormat(country_data['active']) + '</span></li>'
				+ '<li class="list-group-item"><strong class="color-deaths">Deaths:</strong> <span>' + app.aux.numberFormat(country_data['deaths']) + '</span></li>'
				+ '<li class="list-group-item"><strong class="color-recovered">Recovered:</strong> <span>' + app.aux.numberFormat(country_data['recovered']) + '</span></li>'
				+ '<li class="list-group-item"><button type="button" class="close" title="Delete"><span aria-hidden="true">&times;</span></button></li>'
				+ '</ul>'
				+ '</div>';
			
			$(html).hide().appendTo('div.countries-extra-list').slideDown();
			
			app.cfg.countries_selected[extra_num + 2] = country;
			
			if ((extra_num + 3) >= app.cfg.countries_max) {
				$('div.country-add button').prop('disabled', true).addClass('disabled');
			}
			
			app.graphs.refresh();
			
		},
		
		extraRemove: function () {
			
			$(this).closest('div.country-extra').slideUp(function () {
				
				$(this).remove();
				
				app.cfg.countries_selected = [];
				app.cfg.countries_selected[0] = $('div[data-country="0"] select').val();
				app.cfg.countries_selected[1] = $('div[data-country="1"] select').val();
				
				var n = 2;
				
				$('div.countries-extra-list div.country-extra').each(function () {
					
					app.cfg.countries_selected[n] = $(this).attr('data-country-name');
					
					n++;
					
				});
				
				$('div.country-add button').prop('disabled', false).removeClass('disabled');
				
				app.graphs.refresh();
				
			});
		
		},
		
		setCookie: function () {
			
			var expires = '';
			var date = new Date();
			date.setTime(date.getTime() + (app.cfg.cookie.life * 24 * 60 * 60 * 1000));
			expires = "; expires=" + date.toGMTString();
			
			var value = $('div[data-country="0"] select').val() + '|' + $('div[data-country="1"] select').val();
			
			document.cookie = app.cfg.cookie.name + "=" + value + expires + "; path=/";
			
		}
		
	},
	
	graphs: {
		
		calculate: function () {
			
			var data = {
					days: 0,
					countries: {},
				},
				days_max = 0,
				days = 0,
				count = false,
				t = {};
			
			for (var p = 0; p < app.cfg.countries_selected.length; p++) {
				
				t = {
					days: 0,
					graph_start: '',
					confirmed: [],
					active: [],
					deaths: [],
					recovered: [],
					confirmed_daily: [],
					deaths_daily: [],
					recovered_daily: [],
				};
				days = 0;
				count = false;
				
				for (var day in app.cfg.countries_data[app.cfg.countries_selected[p]].timeline) {
					
					if (count || app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].confirmed >= app.cfg.start) {
						
						if (t.graph_start == '') {
							t.graph_start = day;
						}
						
						t.confirmed.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].confirmed);
						t.active.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].active);
						t.deaths.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].deaths);
						t.recovered.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].recovered);
						t.confirmed_daily.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].confirmed_daily);
						t.deaths_daily.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].deaths_daily);
						t.recovered_daily.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].recovered_daily);
						
						days++;
						count = true;
						
					}
					
					t.days = days - 1;
					
					data.countries[p] = t;
					
				}
				
				if (t.days > data.days) {
					data.days = t.days;
				}
				
			}
			
			return data;
			
		},
		
		refresh: function () {
			
			var data = app.graphs.calculate();
			
			// Update graph_start info
			
			for (var p in data.countries) {
				
				if (data.countries[p].graph_start == '') {
					$('[data-country="' + p + '"] .info-start span').html('None');
				} else {
					$('[data-country="' + p + '"] .info-start span').html(app.aux.dateFormat(data.countries[p].graph_start));
				}
				
			}
			
			app.cfg.xaxis_labels = [];
			var steps = Math.floor(data.days / app.cfg.xaxis_lapse);
			var count = 0;
			for (var i=1; i<=data.days+1; i++) {
				if (count == steps) {
					app.cfg.xaxis_labels.push(i);
					count = 0;
				} else {
					app.cfg.xaxis_labels.push('');
					count++;
				}
			}
			
			// Confirmed
			app.graphs.draw({
				type: 'line',
				id: 'confirmed',
				category: 'confirmed',
				days: data.days,
				data: data.countries,
				title: 'Confimed',
			});
			
			// Active
			app.graphs.draw({
				type: 'line',
				id: 'active',
				category: 'active',
				days: data.days,
				data: data.countries,
				title: 'Active',
			});
			
			// Deaths
			app.graphs.draw({
				type: 'line',
				id: 'deaths',
				category: 'deaths',
				days: data.days,
				data: data.countries,
				title: 'Deaths',
			});
			
			// Recovered
			app.graphs.draw({
				type: 'line',
				id: 'recovered',
				category: 'recovered',
				days: data.days,
				data: data.countries,
				title: 'Recovered',
			});
			
			// Confirmed Daily
			app.graphs.draw({
				type: 'bar',
				id: 'confirmed_daily',
				category: 'confirmed',
				days: data.days,
				data: data.countries,
				title: 'Confimed (daily)',
			});
			
			// Deaths Daily
			app.graphs.draw({
				type: 'bar',
				id: 'deaths_daily',
				category: 'deaths',
				days: data.days,
				data: data.countries,
				title: 'Deaths (daily)',
			});
			
			// Recovered Daily
			app.graphs.draw({
				type: 'bar',
				id: 'recovered_daily',
				category: 'recovered',
				days: data.days,
				data: data.countries,
				title: 'Recovered (daily)',
			});
			
		},
		
		draw: function (options) {
			
			var xaxis = [];
			for (var i=1; i<=options.days+1; i++) {
				xaxis.push(i);
			}
			
			var series = [];
			
			if (app.cfg.mode == 'absolute') {
				// Absolute
				
				for (var i in options.data) {
					series[i] = {
						name: app.cfg.countries_selected[i],
						data: [],
					};
					for (var d in options.data[i][options.id]) {
						series[i].data.push(options.data[i][options.id][d]);
					}
				}
				
			} else {
				// Relative
				
				if (options.type == 'line') {
					// Percent of population
					
					for (var i in options.data) {
						series[i] = {
							name: app.cfg.countries_selected[i],
							data: [],
						};
						for (var d in options.data[i][options.id]) {
							series[i].data.push((options.data[i][options.id][d] / app.cfg.countries_data[app.cfg.countries_selected[i]].population) * 100);
						}
					}
					
				} else {
					// Cases por x population
					
					for (var i in options.data) {
						series[i] = {
							name: app.cfg.countries_selected[i],
							data: [],
						};
						for (var d in options.data[i][options.id]) {
							series[i].data.push((options.data[i][options.id][d] * app.cfg.relative_num) / app.cfg.countries_data[app.cfg.countries_selected[i]].population);
						}
					}
					
				}
				
			}
			
			var graph_options = {
				series: series,
				chart: {
					zoom: {
						enabled: false,
					},
					toolbar: {
						offsetX: 0,
					}
				},
				colors: app.cfg.graph_palette,
				tooltip: {
					shared: true,
					x: {
						formatter: function (value) {
							return 'Day ' + value;
						}
					}
				},
				dataLabels: {
					enabled: false
				},
				stroke: {
					curve: 'straight'
				},
				title: {
					text: options.title + ' *',
					align: 'left',
					style: {
						color: app.cfg.info_palette[options.category],
					}
				},
				grid: {
					row: {
						colors: ['#f3f3f3', 'transparent'], // takes an array which will be repeated on columns
						opacity: 0.5
					},
				},
				xaxis: {
					categories: xaxis,
					title: {
						text: 'Days from ' + app.cfg.start + 'th confirmed',
					},
					labels: {
						hideOverlappingLabels: false,
						formatter: function (value, timestamp, index) {
							return app.cfg.xaxis_labels[parseInt(value) - 1];
						}
					}
				},
				yaxis: {
					forceNiceScale: true,
					title: {
						text: 'Number of cases',
					}
				}
			};
			
			switch (options.type) {
				
				case 'line':
					graph_options.chart.toolbar.offsetX = -23;
					graph_options.chart.height = 350;
					graph_options.chart.type = 'line';
					if (app.cfg.graph_mode == 'logarithmic') {
						var t = [];
						for (var n in series) {
							t.push(series[n].data[0]);
						}
						graph_options.yaxis.logarithmic = true;
						graph_options.yaxis.min = Math.min.apply(null, t) + 1;
						graph_options.yaxis.max = function(max) { return max * 1.2; };
					} else {
						graph_options.yaxis.logarithmic = false;
						graph_options.yaxis.min = 0;
						graph_options.yaxis.max = function(max) { return max; };
					}
					if (app.cfg.mode == 'absolute') {
						graph_options.yaxis.title.text = 'Number of cases';
					} else {
						graph_options.yaxis.title.text = '% of Population';
					}
					break;
				
				case 'bar':
					graph_options.chart.toolbar.offsetX = 0;
					graph_options.chart.height = 250;
					graph_options.chart.type = 'bar';
					graph_options.tooltip.shared = false;
					graph_options.tooltip.followCursor = true;
					graph_options.tooltip.intersect = false;
					graph_options.yaxis.min = 0;
					if (app.cfg.mode == 'absolute') {
						graph_options.yaxis.title.text = 'Number of cases';
					} else {
						graph_options.yaxis.title.text = 'Cases per ' + app.cfg.relative_num + ' habitants';
					}
					break;
				
			}
			
			switch (app.cfg.mode) {
				
				case 'absolute':
					graph_options.yaxis.decimalsInFloat = 0;
					break;
				
				case 'relative':
					graph_options.yaxis.decimalsInFloat = 4;
					break;
				
			}
			
			if (!app.cfg.initialized) {
				
				app.cfg.charts[options.id] = new ApexCharts(document.querySelector('#graph-' + options.id), graph_options);
				app.cfg.charts[options.id].render();
				
			} else {
				
				app.cfg.charts[options.id].updateOptions(graph_options);
				
			}
			
		},
		
		resize: function () {
			
			if ($(this).closest('div.graph-container').hasClass('col-md-12')) {
				
				$(this).closest('div.graph-container').removeClass('col-md-12').addClass('col-md-6');
				
			} else {
				
				$('div.graph-container').removeClass('col-md-12');
				$(this).closest('div.graph-container').addClass('col-md-12');
				
			}
			
		}
		
	},
	
	options: {
		
		changeMode: function (mode, init) {
			
			init = typeof init === 'undefined' ? false : init;
			
			$('div.menu-mode button').removeClass('btn-dark').addClass('btn-outline-dark');
			$('div.menu-mode button[data-value="' + mode + '"]').removeClass('btn-outline-dark').addClass('btn-dark');
			
			app.cfg.mode = mode;
			
			if (!init) {
				app.graphs.refresh();
			}
			
		},
		
		changeStart: function (start, init) {
			
			init = typeof init === 'undefined' ? false : init;
			
			$('div.menu-start button').removeClass('btn-dark').addClass('btn-outline-dark');
			$('div.menu-start button[data-value="' + start + '"]').removeClass('btn-outline-dark').addClass('btn-dark');
			
			app.cfg.start = parseInt(start);
			
			if (!init) {
				app.graphs.refresh();
			}
			
		},
		
		changeGraphMode: function (graph_mode, init) {
			
			init = typeof init === 'undefined' ? false : init;
			
			$('div.menu-graph button').removeClass('btn-dark').addClass('btn-outline-dark');
			$('div.menu-graph button[data-value="' + graph_mode + '"]').removeClass('btn-outline-dark').addClass('btn-dark');
			
			app.cfg.graph_mode = graph_mode;
			
			if (!init) {
				app.graphs.refresh();
			}
			
		}
		
	},
	
	ranking: {
		
		change: function () {
			
			var column = $(this).attr('data-column'),
				text = $(this).text(),
				column;
			
			$('#ranking-menu button.dropdown-toggle').html(text);
			
			for (var i=2; i<=5; i++) {
				if (i == column) {
					app.cfg.ranking_table.column(i).visible(true);
				} else {
					app.cfg.ranking_table.column(i).visible(false);
				}
			}
			
			c = app.cfg.ranking_table.column(column).order('desc').draw();
			
		},
		
		reorder: function (e, settings, details) {
			
			n = 0;
			
			$('#table-ranking tr').each(function () {
				
				$(this).find('td').first().html(n);
				
				n++;
				
			});
			
		},
		
	},
	
	aux: {
		
		numberFormat: function (number, decimals, decPoint, thousandsSep) {
			// https://locutus.io/php/strings/number_format/
			
			number = (number + '').replace(/[^0-9+\-Ee.]/g, '')
			var n = !isFinite(+number) ? 0 : +number
			var prec = !isFinite(+decimals) ? 0 : Math.abs(decimals)
			var sep = (typeof thousandsSep === 'undefined') ? '.' : thousandsSep
			var dec = (typeof decPoint === 'undefined') ? ',' : decPoint
			var s = ''
			
			var toFixedFix = function (n, prec) {
				if (('' + n).indexOf('e') === -1) {
					return +(Math.round(n + 'e+' + prec) + 'e-' + prec)
				} else {
					var arr = ('' + n).split('e')
					var sig = ''
					if (+arr[1] + prec > 0) {
						sig = '+'
					}
					return (+(Math.round(+arr[0] + 'e' + sig + (+arr[1] + prec)) + 'e-' + prec)).toFixed(prec)
				}
			}
			
			// @todo: for IE parseFloat(0.55).toFixed(0) = 0;
			s = (prec ? toFixedFix(n, prec).toString() : '' + Math.round(n)).split('.')
			if (s[0].length > 3) {
				s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep)
			}
			if ((s[1] || '').length < prec) {
				s[1] = s[1] || ''
				s[1] += new Array(prec - s[1].length + 1).join('0')
			}
			
			return s.join(dec)
		},
		
		dateFormat: function (date) {
			
			var t = date.split('-');
			return t[2] + '/' + t[1] + '/' + t[0];
			
		},
		
	},
	
};

$(document).ready(function () {
	
	app.init();
	
});