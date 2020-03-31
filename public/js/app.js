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
		charts: {},
		ranking_table: null,
		xaxis_labels: [],
		xaxis_labels_zoom: [],
		cookie: {},
		graph_data: {},
		obj: null,
		
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
		
		app.graphs.zoom.init();
		
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
			
			app.cfg.obj = $(this);
			
			app.aux.pageLock();
			
			setTimeout(function () {
				
				var country = app.cfg.obj.closest('div.country-add').find('select').val();
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
				
				app.aux.pageUnlock();
				
			}, 500);
			
		},
		
		extraRemove: function () {
			
			app.cfg.obj = $(this);
			
			app.aux.pageLock();
			
			setTimeout(function () {
				
				app.cfg.obj.closest('div.country-extra').slideUp(function () {
					
					$(this).remove();
					
				});
				
				app.cfg.countries_selected = [];
				app.cfg.countries_selected[0] = $('div[data-country="0"] select').val();
				app.cfg.countries_selected[1] = $('div[data-country="1"] select').val();
				
				var n = 2;
				
				$('div.countries-extra-list div.country-extra').each(function () {
					
					app.cfg.countries_selected[n] = app.cfg.obj.attr('data-country-name');
					
					n++;
					
				});
				
				$('div.country-add button').prop('disabled', false).removeClass('disabled');
				
				app.graphs.refresh();
				
				app.aux.pageUnlock();
				
			}, 500);
		
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
					days_list: [],
					confirmed: [],
					active: [],
					deaths: [],
					recovered: [],
					confirmed_daily: [],
					active_daily: [],
					deaths_daily: [],
					recovered_daily: [],
					confirmed_increment: [],
					active_increment: [],
					deaths_increment: [],
					recovered_increment: [],
				};
				days = 0;
				count = false;
				
				for (var day in app.cfg.countries_data[app.cfg.countries_selected[p]].timeline) {
					
					if (count || app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].confirmed >= app.cfg.start) {
						
						if (t.graph_start == '') {
							t.graph_start = day;
						}
						
						t.days_list.push(app.aux.dateFormat(day));
						t.confirmed.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].confirmed);
						t.active.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].active);
						t.deaths.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].deaths);
						t.recovered.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].recovered);
						t.confirmed_daily.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].confirmed_daily);
						t.active_daily.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].active_daily);
						t.deaths_daily.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].deaths_daily);
						t.recovered_daily.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].recovered_daily);
						t.confirmed_increment.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].confirmed_increment);
						t.active_increment.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].active_increment);
						t.deaths_increment.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].deaths_increment);
						t.recovered_increment.push(app.cfg.countries_data[app.cfg.countries_selected[p]].timeline[day].recovered_increment);
						
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
			
			app.cfg.graph_data = app.graphs.calculate();
			
			// Update graph_start info
			
			for (var p in app.cfg.graph_data.countries) {
				
				if (app.cfg.graph_data.countries[p].graph_start == '') {
					$('[data-country="' + p + '"] .info-start span').html('None');
				} else {
					$('[data-country="' + p + '"] .info-start span').html(app.aux.dateFormat(app.cfg.graph_data.countries[p].graph_start));
				}
				
			}
			
			app.cfg.xaxis_labels = [];
			var steps = Math.floor(app.cfg.graph_data.days / app.cfg.xaxis_lapse);
			var count = 0;
			for (var i=1; i<=app.cfg.graph_data.days+1; i++) {
				if (count == steps) {
					app.cfg.xaxis_labels.push(i);
					count = 0;
				} else {
					app.cfg.xaxis_labels.push('');
					count++;
				}
			}
			
			app.cfg.xaxis_labels_zoom = [];
			var steps = Math.floor(app.cfg.graph_data.days / app.cfg.xaxis_lapse_zoom);
			var count = 0;
			for (var i=1; i<=app.cfg.graph_data.days+1; i++) {
				if (count == steps) {
					app.cfg.xaxis_labels_zoom.push(i);
					count = 0;
				} else {
					app.cfg.xaxis_labels_zoom.push('');
					count++;
				}
			}
			
			$('.main-graphs .graph').each(function () {
				
				app.graphs.draw({
					type: $(this).attr('data-type'),
					id: $(this).attr('data-id'),
					selector: $(this).attr('data-selector'),
					category: $(this).attr('data-category'),
					days: app.cfg.graph_data.days,
					data: app.cfg.graph_data.countries,
					title: $(this).attr('data-title'),
				});
				
			});
			
		},
		
		draw: function (options) {
			
			var xaxis = [];
			for (var i = 1; i <= options.days + 1; i++) {
				xaxis.push(i);
			}
			
			var series = [];
			
			if (app.cfg.mode == 'absolute') {
				// Absolute
				
				for (var i in options.data) {
					series[i] = {
						name: app.cfg.countries_selected[i],
						category: options.category,
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
							category: options.category,
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
							category: options.category,
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
						formatter: function (value, config) {
							return 'Day ' + value + ' <small>(' + app.cfg.graph_data.countries[config.seriesIndex].days_list[[config.dataPointIndex]] + ')</small>';
						}
					},
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
					},
					tooltip: {
						enabled: false,
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
					graph_options.stroke.curve = 'straight';
					if (app.cfg.graph_mode == 'logarithmic') {
						var t = [];
						for (var n in series) {
							t.push(series[n].data[0]);
						}
						graph_options.yaxis.logarithmic = true;
						graph_options.yaxis.min = Math.min.apply(null, t) + 1;
						graph_options.yaxis.max = function (max) {
							return max * 1.2;
						};
					} else {
						graph_options.yaxis.logarithmic = false;
						graph_options.yaxis.min = 0;
						graph_options.yaxis.max = function (max) {
							return max;
						};
					}
					graph_options.tooltip.y = {
						formatter: function (value, config) {
							if (typeof value == 'undefined') return value;
							var country = config.w.config.series[config.seriesIndex].name;
							var category = config.w.config.series[config.seriesIndex].category;
							var data_serie = app.cfg.graph_data.countries[config.seriesIndex][category + '_increment'];
							var increment = data_serie[config.dataPointIndex];
							return app.aux.numberFormat(value)
								+ ' <span style="font-weight: normal;">(' + (increment >= 0 ? '+' : '') + app.aux.numberFormat(increment, 1) + '%)</span>';
						}
					};
					if (app.cfg.mode == 'absolute') {
						graph_options.yaxis.title.text = 'Number of cases';
					} else {
						graph_options.yaxis.title.text = '% of Population';
					}
					break;
				
				case 'area':
					graph_options.chart.toolbar.offsetX = -23;
					graph_options.chart.height = 280;
					graph_options.chart.type = 'area';
					graph_options.stroke.curve = 'smooth';
					if (app.cfg.graph_mode == 'logarithmic') {
						var t = [];
						for (var n in series) {
							t.push(series[n].data[0]);
						}
						graph_options.yaxis.logarithmic = true;
						graph_options.yaxis.min = Math.min.apply(null, t) + 1;
						graph_options.yaxis.max = function (max) {
							return max * 1.2;
						};
					} else {
						graph_options.yaxis.logarithmic = false;
						graph_options.yaxis.min = 0;
						graph_options.yaxis.max = function (max) {
							return max;
						};
					}
					graph_options.tooltip.y = {
						formatter: function (value, config) {
							if (typeof value == 'undefined') return value;
							var country = config.w.config.series[config.seriesIndex].name;
							var category = config.w.config.series[config.seriesIndex].category;
							var data_serie = app.cfg.graph_data.countries[config.seriesIndex][category + '_increment'];
							var increment = data_serie[config.dataPointIndex];
							return app.aux.numberFormat(value) + ' <span style="font-weight: normal;">(' + (increment >= 0 ? '+' : '') + app.aux.numberFormat(increment, 1) + '%)</span>';
						}
					};
					if (app.cfg.mode == 'absolute') {
						graph_options.yaxis.title.text = 'Number of cases';
					} else {
						graph_options.yaxis.title.text = 'Cases per ' + app.cfg.relative_num + ' habitants';
					}
					break;
				
			}
			
			if (options.selector == 'graph-zoom') {
				
				graph_options.chart.width = '100%';
				graph_options.chart.height = '100%';
				graph_options.xaxis.labels.formatter = function (value, timestamp, index) {
					return app.cfg.xaxis_labels_zoom[parseInt(value) - 1];
				};
				
			} else {
				
				graph_options.xaxis.labels.formatter = function (value, timestamp, index) {
					return app.cfg.xaxis_labels[parseInt(value) - 1];
				};
				
			}
			
			if (app.cfg.mode == 'absolute') {
				
				graph_options.yaxis.decimalsInFloat = 0;
			
			} else {
			
				graph_options.yaxis.decimalsInFloat = 4;
				
			}
			
			if (app.cfg.initialized && typeof app.cfg.charts[options.selector] !== 'undefined') {
				
				app.cfg.charts[options.selector].destroy();
				
			}
			
			app.cfg.charts[options.selector] = new ApexCharts(document.querySelector('#' + options.selector), graph_options);
			app.cfg.charts[options.selector].render();
			
		},
		
		zoom: {
			
			init: function () {
				
				$('div.graph-container div.resizer button').on('click', app.graphs.zoom.launch);
				$('.overlay .close').on('click', app.graphs.zoom.close);
				
			},
			
			launch: function () {
				
				app.cfg.obj = $(this);
				
				$('div.overlay').fadeIn(function () {
					
					var g = app.cfg.obj.closest('.card').find('div.graph');
					
					app.graphs.draw({
						type: g.attr('data-type'),
						id: g.attr('data-id'),
						selector: 'graph-zoom',
						category: g.attr('data-category'),
						days: app.cfg.graph_data.days,
						data: app.cfg.graph_data.countries,
						title: g.attr('data-title'),
					});
					
				});
				
				/*if ($(this).closest('div.graph-container').hasClass('col-md-12')) {
					
					$(this).closest('div.graph-container').removeClass('col-md-12').addClass('col-md-6');
					
				} else {
					
					$('div.graph-container').removeClass('col-md-12');
					$(this).closest('div.graph-container').addClass('col-md-12');
					
				}*/
				
			},
			
			close: function () {
				
				app.cfg.charts['graph-zoom'].destroy();
				$('div.overlay').fadeOut();
				
			}
			
		}
		
	},
	
	options: {
		
		changeMode: function (mode, init) {
			
			app.aux.pageLock();
			
			setTimeout(function () {
				
				init = typeof init === 'undefined' ? false : init;
				
				$('div.menu-mode button').removeClass('btn-dark').addClass('btn-outline-dark');
				$('div.menu-mode button[data-value="' + mode + '"]').removeClass('btn-outline-dark').addClass('btn-dark');
				
				app.cfg.mode = mode;
				
				if (!init) {
					app.graphs.refresh();
				}
				
				app.aux.pageUnlock();
				
			}, 500);
			
		},
		
		changeStart: function (start, init) {
			
			app.aux.pageLock();
			
			setTimeout(function () {
				
				init = typeof init === 'undefined' ? false : init;
				
				$('div.menu-start button').removeClass('btn-dark').addClass('btn-outline-dark');
				$('div.menu-start button[data-value="' + start + '"]').removeClass('btn-outline-dark').addClass('btn-dark');
				
				app.cfg.start = parseInt(start);
				
				if (!init) {
					app.graphs.refresh();
				}
				
				app.aux.pageUnlock();
				
			}, 500);
			
		},
		
		changeGraphMode: function (graph_mode, init) {
			
			app.aux.pageLock();
			
			setTimeout(function () {
				
				init = typeof init === 'undefined' ? false : init;
				
				$('div.menu-graph button').removeClass('btn-dark').addClass('btn-outline-dark');
				$('div.menu-graph button[data-value="' + graph_mode + '"]').removeClass('btn-outline-dark').addClass('btn-dark');
				
				app.cfg.graph_mode = graph_mode;
				
				if (!init) {
					app.graphs.refresh();
				}
				
				app.aux.pageUnlock();
				
			}, 500);
			
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
		
		pageLock: function () {
			$('.loader').show();
		},
		
		pageUnlock: function () {
			$('.loader').hide();
		},
		
	},
	
};

$(document).ready(function () {
	
	app.init();
	
});