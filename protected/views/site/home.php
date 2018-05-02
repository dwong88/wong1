<?php
$this->breadcrumbs=array(
	'',
);

$gtime = date("Y-m-d");
$begin = new DateTime($gtime);
//$end = new DateTime('2018-04-10');

$time = strtotime($gtime);
$final = date("Y-m-d", strtotime("+1 month", $time));
$end = new DateTime($final);

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
  <div><font>Rerservations:<br> <?php echo count(Reservations::model()->findAll());?></font></div>
  <div><font>Rooms:<br> <?php echo count(Room::model()->findAll());?></font></div>
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
				rangeSelector:{
							 enabled:true,
							 inputPosition: {
										align: 'left',
										x: 0,
										y: 0
								},
									buttonPosition: {
										align: 'right',
										x: -30,
										y: 0
								},
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
		            text: 'Order'
		        },
		        min: 0
		    },
		    tooltip: {
		        headerFormat: '<b>{series.name}</b><br>',
		        pointFormat: '{point.x:%e. %b}: {point.y:.2f}'
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
									foreach ($period as $dt) {
											/*echo ("select count(rev.reservations_id) as id, rev.customer_name as name, rev.start_date as start, rev.end_date as end,rev.status,rev.paid from tghreservations as rev
											WHERE rev.start_date like'%".$dt->format("Y-m-d")."%';");*/
											$hasil = DAO::queryAllSql("select count(rev.reservations_id) as id, rev.customer_name as name, rev.start_date as start, rev.end_date as end,rev.status,rev.paid from tghreservations as rev
											WHERE rev.start_date like'%".$dt->format("Y-m-d")."%';");
											echo "[Date.UTC(".$dt->format("Y").','.(($dt->format("m"))-1).','.$dt->format("d")."),".$hasil[0]['id']."],";
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
