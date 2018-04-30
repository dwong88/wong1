<?php
$this->breadcrumbs=array(
	'',
);
$begin = new DateTime('2018-04-01');
$end = new DateTime('2018-04-10');

$interval = DateInterval::createFromDateString('1 day');
$period = new DatePeriod($begin, $interval, $end);

?>
<style>
.flex-container {
  display: flex;
  flex-wrap: nowrap;
  background-color: DodgerBlue;
}

.flex-container > div {
  background-color: #f1f1f1;
  width: 200px;
  margin: 10px;
  text-align: center;
  line-height: 75px;
  font-size: 30px;
}
</style>

<div class="flex-container">
  <div>1</div>
  <div>2</div>
  <div><font>Projects Done</font>3</div>
  <div>4</div>
  <div>5</div>
  <div>6</div>
  <div>7</div>
  <div>8</div>
</div>

<div id="container"></div>



		<script type="text/javascript">
		Highcharts.chart('container', {
		    chart: {
		        type: 'spline'
		    },
		    title: {
		        text: 'G-Hours'
		    },
		    subtitle: {
		        text: 'Irregular time data in Highcharts JS'
		    },
		    xAxis: {
		        type: 'datetime',
		        dateTimeLabelFormats: { // don't display the dummy year
		            month: '%e. %b',
		            year: '%b'
		        },
		        title: {
		            text: 'Date'
		        }
		    },
		    yAxis: {
		        title: {
		            text: 'Order (m)'
		        },
		        min: 0
		    },
		    tooltip: {
		        headerFormat: '<b>{series.name}</b><br>',
		        pointFormat: '{point.x:%e. %b}: {point.y:.2f} m'
		    },

		    plotOptions: {
		        spline: {
		            marker: {
		                enabled: true
		            }
		        }
		    },

		    colors: ['#6CF', '#39F', '#06C', '#036', '#000'],

		    // Define the data points. All series have a dummy year
		    // of 2017/71 in order to be compared on the same x axis. Note
		    // that in JavaScript, months start at 0 for January, 1 for February etc.
				series: [{
		        name: "2018",
		        data: [
								<?php
								$isi=0;
									foreach ($period as $dt) {
											$isi++;
											echo "[Date.UTC(".$dt->format("Y").','.$dt->format("m").','.$dt->format("d")."),".$isi."],";
											//echo "[Date.UTC(2018, 0,  4), 1.6],";
									}
								?>
		        ]
		    }]

				/*series: [{
		        name: "2018",
		        data: [
		            [Date.UTC(2017, 10, 25, 3, 4, 5), 0],
		            [Date.UTC(2017, 11,  6), 0.25],
		            [Date.UTC(2017, 11, 20), 1.41],
		            [Date.UTC(2017, 11, 25), 1.64],
		            [Date.UTC(2018, 0,  4), 1.6],
		            [Date.UTC(2018, 0, 17), 2.55],
		            [Date.UTC(2018, 0, 24), 2.62],
		            [Date.UTC(2018, 1,  4), 2.5],
		            [Date.UTC(2018, 1, 14), 2.42],
		            [Date.UTC(2018, 2,  6), 2.74],
		            [Date.UTC(2018, 2, 14), 2.62],
		            [Date.UTC(2018, 2, 24), 0],
		            [Date.UTC(2018, 3,  1), 4],
		            [Date.UTC(2018, 3, 11), 2.63],
		            [Date.UTC(2018, 3, 27), 2.77],
		            [Date.UTC(2018, 4,  4), 2.68],
		            [Date.UTC(2018, 4,  9), 2.56],
		            [Date.UTC(2018, 4, 14), 2.39],
		            [Date.UTC(2018, 4, 19), 2.3],
		            [Date.UTC(2018, 5,  4), 2],
		            [Date.UTC(2018, 5,  9), 1.85],
		            [Date.UTC(2018, 5, 14), 1.49],
		            [Date.UTC(2018, 5, 19), 1.27],
		            [Date.UTC(2018, 5, 24), 0.99],
		            [Date.UTC(2018, 5, 29), 0.67],
		            [Date.UTC(2018, 6,  3), 0.18],
		            [Date.UTC(2018, 6,  4), 0]
		        ]
		    }]*/
		});
		</script>
