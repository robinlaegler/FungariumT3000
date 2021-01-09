<!DOCTYPE html>
<html lang="de">
	
<!-- Site: 'Protokoll' -->

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Steuerung Fungarium</title>
        
		<!-- homescreen icon -->
		<link rel="icon" type="image/ico" href="favicon.ico/mushrooms.ico">
		
		<!-- css stylesheets -->
		<link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="css/tooplate.css">
		<link rel="stylesheet" href="css/time.css">
        <!-- css datatables -->
		<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.22/css/jquery.dataTables.css">
    </head>

    <body id="reportsPage">
        <div class="" id="home">
            <div class="container">
                <div class="row">
                    <div class="col-12">
						<!-- navigationbar with dropdown menu -->
                        <nav class="navbar navbar-expand-xl navbar-light bg-light">
                            <a class="navbar-brand" href="#">
								<!-- navigationbar icon -->
                                <img src="favicon.ico/mushrooms_30.ico" >
                                <h1 class="tm-site-title mb-0">Fungarium</h1>
                            </a>
                            <button class="navbar-toggler ml-auto mr-0" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                                aria-expanded="false" aria-label="Toggle navigation">
                                <span class="navbar-toggler-icon"></span>
                            </button>

                            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                                <ul class="navbar-nav mx-auto">
									
									<!-- pages in navigationbar -->
                                    <li class="nav-item">
                                        <a class="nav-link" href="index.php">Menü</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="temperature.php">Temperatur</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="feuchtigkeit.php">Feuchtigkeit</a>
                                    </li>                               
                                    <li class="nav-item">
                                        <a class="nav-link" href="protokoll.php">Protokoll</a>
                                    </li>     
                                    <li class="nav-item">
                                        <a class="nav-link" href="manuell.php">Manuell</a>
                                    </li>             
                                </ul>
                            </div>
                        </nav>
                    </div>
                </div>
            
				<!-- 1. white block, includes Datatable 'Protokoll'-->
				<div class="row tm-content-row tm-mt-big">
					<div class="tm-col tm-col-big">
						<div class="bg-white tm-block h-100">
						<h2 class="tm-block-title">Protokoll</h2>
						<!-- Datatable 'Protokoll' -->
						<table id="tableProtokoll">  					  
							<thead>
							<tr>
								<th>Zeit</th>
								<th>Eintrag</th>
							</tr>
							</thead>
							<tbody>
							<tr>
								<th>Zeit</th>
								<th>Eintrag</th>
							</tr>
							</tbody>
						</table>
						</div>
					</div>

			<div class="tm-col tm-col-big">
				<div class="bg-white tm-block h-100">
				<h2 class="tm-block-title">Licht Zustand</h2>
					<!-- LineChart 'Licht' -->
					<canvas id="lineChartLicht" height="300" ></canvas>
				</div>
			</div>
			
			<div class="tm-col tm-col-big">
				<div class="bg-white tm-block h-100">
				<h2 class="tm-block-title">Heizung Zustand</h2>
					<!-- LineChart 'Heizung' -->
					<canvas id="lineChartHeizung" height="300" ></canvas>
				</div>
			</div>
			
			<div class="tm-col tm-col-big">
				<div class="bg-white tm-block h-100">
				<h2 class="tm-block-title">Kühlung Zustand</h2>
					<!-- LineChart 'Kühlung' -->
					<canvas id="lineChartKuehlung" height="300" ></canvas>
				</div>
			</div>
			
			<div class="tm-col tm-col-big">
				<div class="bg-white tm-block h-100">
				<h2 class="tm-block-title">Fogger Zustand</h2>
					<!-- LineChart 'Fogger' -->
					<canvas id="lineChartFogger" height="300" ></canvas>
				</div>
			</div>
			
			<div class="tm-col tm-col-big">
				<div class="bg-white tm-block h-100">
				<h2 class="tm-block-title">Lüftung Zustand</h2>
					<!-- LineChart 'Lüftung' -->
					<canvas id="lineChartLueftung" height="300" ></canvas>
				</div>
			</div>
       	</div>
        <!-- java scripts -->    
		<script src="js/cdn_jsdelivr.js"></script>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/cdn_datatables.js"></script>
        <script src="js/bootstrap.min.js"></script>
        <script src="js/tooplate-scripts.js"></script>
        <script src="js/moment.min.js"></script>
        <!-- chartjs adapter and plugins -->            
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chart.js@2.9.3/dist/Chart.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-moment@0.1.1"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-adapter-date-fns@1.0.0/dist/chartjs-adapter-date-fns.bundle.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/hammerjs@2.0.8"></script>
        <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-zoom@0.7.7"></script>
        
        <!-- js to draw DataTable 'Protokoll' -->
        <script>
			$('#tableProtokoll').DataTable( {
			"searching": true,
			"pageLength": 20,
			"scrollY": "300px",
			"scrollCollapse": true,
			"lengthChange": false,
			"language": {
				"url": "js/dataTables.german.json"
			},
			ajax: {
				url: "data_protokoll.php",
				dataSrc: ''
			},
			columns: [
				{ data: "Zugriff" },
				{ data: "Eintrag" }
			]
			} );
		</script>
		
		<!-- js to draw LineChart 'Licht' -->
        <script>
			
		// configuration of the LineChart
		   var configLicht = {
		   type: "line",
		   data: {
			  labels: [],
			  datasets: [{
				 label: "Licht",
				 lineTension: 0,
				 backgroundColor: "#fdb302",
				 borderColor: "orange",
				 data: [],
				 fill: false,
			  }]
		   },
		   options: {
			    plugins: {
                  zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 20,
                        threshold: 10,
                        onPan: function({chart}) { console.log(`I'm panning!!!`); },
                        onPanComplete: function({chart}) { console.log(`I was panned!!!`); }
                    },

                    zoom: {
                        enabled: true,
                        drag: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 0.1,
                        threshold: 2,
                        sensitivity: 3,
                        onZoom: function({chart}) { console.log(`I'm zooming!!!`); },
                        onZoomComplete: function({chart}) { console.log(`I was zoomed!!!`); }
                    }
                }
              },
			  responsive: true,
			  legend: {
				 display: false
			  },
			  tooltips: {
				 mode: "index",
				 intersect: false,
			  },
			  hover: {
				 mode: "nearest",
				 intersect: true
			  },
			  scales: {
				 xAxes: [{
					type: "time",
					time: { displayFormats: { minute: "HH:mm" } },
					display: true,
					scaleLabel: {
					   display: true,
					   labelString: "Uhrzeit"
					}
				 }],
				 yAxes: [{
					display: true,
					ticks: {
						max: 1,
						min: 0,
						stepSize: 1
					},
					scaleLabel: {
					   display: true,
					   labelString: "Aus/An"
					}
				 }]
			  }
		   }
		} ;
        // get JSON-Data
		fetch( "licht_data.php" )
			 .then( response => response.json() )
			 .then( json => {
				  configLicht.data.labels = json.map( row => moment(row.Zugriff).toDate() ) ;
                  var rangeXMin = json.map( row => moment(row.Zugriff).toDate() )[0];
                  var rangeXMax = json.map( row => moment(row.Zugriff).toDate() )[(json.map( row => moment(row.Zugriff).toDate())).length-1];
                  configLicht.options.plugins.zoom.zoom.rangeMin.x = rangeXMin;
                  configLicht.options.plugins.zoom.pan.rangeMin.x = rangeXMin;
                  configLicht.options.plugins.zoom.zoom.rangeMax.x = rangeXMax;
                  configLicht.options.plugins.zoom.pan.rangeMax.x = rangeXMax;
                  configLicht.data.datasets[0].data = json.map( row => row.An ) ;
				  console.table( configLicht.data.datasets[0].data ) ;
                  // create Chart
				  var ctx   = document.getElementById( "lineChartLicht" ).getContext( "2d" ) ;
				  var chart = new Chart( ctx, configLicht ) ;
			 } )
			 .catch( error => alert("Error: "+error) ) ;
		</script>
		
		<!-- js to draw LineChart 'Heizung' -->
        <script>
		// configuration of the LineChart
		   var configHeizung = {
		   type: "line",
		   data: {
			  labels: [],
			  datasets: [{
				 label: "Heizung",
				 lineTension: 0,
				 backgroundColor: "red",
				 borderColor: "red",
				 data: [],
				 fill: false,
			  }]
		   },
		   options: {
			    plugins: {
                  zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 20,
                        threshold: 10,
                        onPan: function({chart}) { console.log(`I'm panning!!!`); },
                        onPanComplete: function({chart}) { console.log(`I was panned!!!`); }
                    },

                    zoom: {
                        enabled: true,
                        drag: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 0.1,
                        threshold: 2,
                        sensitivity: 3,
                        onZoom: function({chart}) { console.log(`I'm zooming!!!`); },
                        onZoomComplete: function({chart}) { console.log(`I was zoomed!!!`); }
                    }
                }
              },
			  responsive: true,
			  legend: {
				 display: false
			  },
			  tooltips: {
				 mode: "index",
				 intersect: false,
			  },
			  hover: {
				 mode: "nearest",
				 intersect: true
			  },
			  scales: {
				 xAxes: [{
					type: "time",
					time: { displayFormats: { minute: "HH:mm" } },
					display: true,
					scaleLabel: {
					   display: true,
					   labelString: "Uhrzeit"
					}
				 }],
				 yAxes: [{
					display: true,
					ticks: {
						max: 1,
						min: 0,
						stepSize: 1
					},
					scaleLabel: {
					   display: true,
					   labelString: "Aus/An"
					}
				 }]
			  }
		   }
		} ;
        // get JSON-Data
		fetch( "heizung_data.php" )
			 .then( response => response.json() )
			 .then( json => {
				  configHeizung.data.labels = json.map( row => moment(row.Zugriff).toDate() ) ;
                  var rangeXMin = json.map( row => moment(row.Zugriff).toDate() )[0];
                  var rangeXMax = json.map( row => moment(row.Zugriff).toDate() )[(json.map( row => moment(row.Zugriff).toDate())).length-1];
                  configHeizung.options.plugins.zoom.zoom.rangeMin.x = rangeXMin;
                  configHeizung.options.plugins.zoom.pan.rangeMin.x = rangeXMin;
                  configHeizung.options.plugins.zoom.zoom.rangeMax.x = rangeXMax;
                  configHeizung.options.plugins.zoom.pan.rangeMax.x = rangeXMax;
				  configHeizung.data.datasets[0].data = json.map( row => row.An );
                  // create Chart
				  var ctx   = document.getElementById( "lineChartHeizung" ).getContext( "2d" ) ;
				  var chart = new Chart( ctx, configHeizung ) ;
			 } )
			 .catch( error => alert("Error: "+error) ) ;
	    </script>
	    
	    <!-- js to draw LineChart 'Kühlung' -->
        <script>
	    // configuration of the LineChart
		   var configKuehlung = {
		   type: "line",
		   data: {
			  labels: [],
			  datasets: [{
				 label: "Kühlung",
				 lineTension: 0,
				 backgroundColor: "blue",
				 borderColor: "blue",
				 data: [],
				 fill: false,
			  }]
		   },
		   options: {
			    plugins: {
                  zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 20,
                        threshold: 10,
                        onPan: function({chart}) { console.log(`I'm panning!!!`); },
                        onPanComplete: function({chart}) { console.log(`I was panned!!!`); }
                    },

                    zoom: {
                        enabled: true,
                        drag: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 0.1,
                        threshold: 2,
                        sensitivity: 3,
                        onZoom: function({chart}) { console.log(`I'm zooming!!!`); },
                        onZoomComplete: function({chart}) { console.log(`I was zoomed!!!`); }
                    }
                }
              },
			  responsive: true,
			  legend: {
				 display: false
			  },
			  tooltips: {
				 mode: "index",
				 intersect: false,
			  },
			  hover: {
				 mode: "nearest",
				 intersect: true
			  },
			  scales: {
				 xAxes: [{
					type: "time",
					time: { displayFormats: { minute: "HH:mm" } },
					display: true,
					scaleLabel: {
					   display: true,
					   labelString: "Uhrzeit"
					}
				 }],
				 yAxes: [{
					display: true,
					ticks: {
						max: 1,
						min: 0,
						stepSize: 1
					},
					scaleLabel: {
					   display: true,
					   labelString: "Aus/An"
					}
				 }]
			  }
		   }
		} ;
        // get JSON-Data
		fetch( "kuehlung_data.php" )
			 .then( response => response.json() )
			 .then( json => {
				  configKuehlung.data.labels = json.map( row => moment(row.Zugriff).toDate() ) ;
                  var rangeXMin = json.map( row => moment(row.Zugriff).toDate() )[0];
                  var rangeXMax = json.map( row => moment(row.Zugriff).toDate() )[(json.map( row => moment(row.Zugriff).toDate())).length-1];
                  configKuehlung.options.plugins.zoom.zoom.rangeMin.x = rangeXMin;
                  configKuehlung.options.plugins.zoom.pan.rangeMin.x = rangeXMin;
                  configKuehlung.options.plugins.zoom.zoom.rangeMax.x = rangeXMax;
                  configKuehlung.options.plugins.zoom.pan.rangeMax.x = rangeXMax;
				  configKuehlung.data.datasets[0].data = json.map( row => row.An );
                  // create Chart
				  var ctx   = document.getElementById( "lineChartKuehlung" ).getContext( "2d" ) ;
				  var chart = new Chart( ctx, configKuehlung ) ;
			 } )
			 .catch( error => alert("Error: "+error) ) ;
	    </script>
	    <!-- js to draw LineChart 'Fogger' -->
        <script>
		// configuration of the LineChart
		   var configFogger = {
		   type: "line",
		   data: {
			  labels: [],
			  datasets: [{
				 label: "Fogger",
				 lineTension: 0,
				 backgroundColor: "green",
				 borderColor: "green",
				 data: [],
				 fill: false,
			  }]
		   },
		   options: {
			    plugins: {
                  zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 20,
                        threshold: 10,
                        onPan: function({chart}) { console.log(`I'm panning!!!`); },
                        onPanComplete: function({chart}) { console.log(`I was panned!!!`); }
                    },

                    zoom: {
                        enabled: true,
                        drag: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 0.1,
                        threshold: 2,
                        sensitivity: 3,
                        onZoom: function({chart}) { console.log(`I'm zooming!!!`); },
                        onZoomComplete: function({chart}) { console.log(`I was zoomed!!!`); }
                    }
                }
              },
			  responsive: true,
			  legend: {
				 display: false
			  },
			  tooltips: {
				 mode: "index",
				 intersect: false,
			  },
			  hover: {
				 mode: "nearest",
				 intersect: true
			  },
			  scales: {
				 xAxes: [{
					type: "time",
					time: { displayFormats: { minute: "HH:mm" } },
					display: true,
					scaleLabel: {
					   display: true,
					   labelString: "Uhrzeit"
					}
				 }],
				 yAxes: [{
					display: true,
					ticks: {
						max: 1,
						min: 0,
						stepSize: 1
					},
					scaleLabel: {
					   display: true,
					   labelString: "Aus/An"
					}
				 }]
			  }
		   }
		} ;
        // get JSON-Data
		fetch( "fogger_data.php" )
			 .then( response => response.json() )
			 .then( json => {
				  configFogger.data.labels = json.map( row => moment(row.Zugriff).toDate() ) ;
                  var rangeXMin = json.map( row => moment(row.Zugriff).toDate() )[0];
                  var rangeXMax = json.map( row => moment(row.Zugriff).toDate() )[(json.map( row => moment(row.Zugriff).toDate())).length-1];
                  configFogger.options.plugins.zoom.zoom.rangeMin.x = rangeXMin;
                  configFogger.options.plugins.zoom.pan.rangeMin.x = rangeXMin;
                  configFogger.options.plugins.zoom.zoom.rangeMax.x = rangeXMax;
                  configFogger.options.plugins.zoom.pan.rangeMax.x = rangeXMax;
				  configFogger.data.datasets[0].data = json.map( row => row.An );
                  // create Chart
				  var ctx   = document.getElementById( "lineChartFogger" ).getContext( "2d" ) ;
				  var chart = new Chart( ctx, configFogger ) ;
			 } )
			 .catch( error => alert("Error: "+error) ) ;
	    </script>
	    <!-- js to draw LineChart 'Lüftung' -->
        <script>
		// configuration of the LineChart
		   var configLueftung = {
		   type: "line",
		   data: {
			  labels: [],
			  datasets: [{
				 label: "Lüftung",
				 lineTension: 0,
				 backgroundColor: "grey",
				 borderColor: "grey",
				 data: [],
				 fill: false,
			  }]
		   },
		   options: {
			    plugins: {
                  zoom: {
                    pan: {
                        enabled: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 20,
                        threshold: 10,
                        onPan: function({chart}) { console.log(`I'm panning!!!`); },
                        onPanComplete: function({chart}) { console.log(`I was panned!!!`); }
                    },

                    zoom: {
                        enabled: true,
                        drag: true,
                        mode: 'x',
                        rangeMin: {
                            x: null,
                            y: null
                        },
                        rangeMax: {
                            x: null,
                            y: null
                        },
                        speed: 0.1,
                        threshold: 2,
                        sensitivity: 3,
                        onZoom: function({chart}) { console.log(`I'm zooming!!!`); },
                        onZoomComplete: function({chart}) { console.log(`I was zoomed!!!`); }
                    }
                }
              },
			  responsive: true,
			  legend: {
				 display: false
			  },
			  tooltips: {
				 mode: "index",
				 intersect: false,
			  },
			  hover: {
				 mode: "nearest",
				 intersect: true
			  },
			  scales: {
				 xAxes: [{
					type: "time",
					time: { displayFormats: { minute: "HH:mm" } },
					display: true,
					scaleLabel: {
					   display: true,
					   labelString: "Uhrzeit"
					}
				 }],
				 yAxes: [{
					display: true,
					ticks: {
						max: 1,
						min: 0,
						stepSize: 1
					},
					scaleLabel: {
					   display: true,
					   labelString: "Aus/An"
					}
				 }]
			  }
		   }
		} ;
        // get JSON-Data
		fetch( "lueftung_data.php" )
			 .then( response => response.json() )
			 .then( json => {
				  configLueftung.data.labels = json.map( row => moment(row.Zugriff).toDate() ) ;
                  var rangeXMin = json.map( row => moment(row.Zugriff).toDate() )[0];
                  var rangeXMax = json.map( row => moment(row.Zugriff).toDate() )[(json.map( row => moment(row.Zugriff).toDate())).length-1];
                  configLueftung.options.plugins.zoom.zoom.rangeMin.x = rangeXMin;
                  configLueftung.options.plugins.zoom.pan.rangeMin.x = rangeXMin;
                  configLueftung.options.plugins.zoom.zoom.rangeMax.x = rangeXMax;
                  configLueftung.options.plugins.zoom.pan.rangeMax.x = rangeXMax;
				  configLueftung.data.datasets[0].data = json.map( row => row.An );
                  // create Chart
				  var ctx   = document.getElementById( "lineChartLueftung" ).getContext( "2d" ) ;
				  var chart = new Chart( ctx, configLueftung ) ;
			 } )
			 .catch( error => alert("Error: "+error) ) ;
	    </script>
    </body>
</html>
