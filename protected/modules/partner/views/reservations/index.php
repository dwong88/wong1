<!-- daypilot libraries -->
<script src="js/daypilot/daypilot-all.min.js" type="text/javascript"></script>
<!-- helper libraries -->
<script src="js/jquery/jquery-1.9.1.min.js" type="text/javascript"></script>
<link type="text/css" rel="stylesheet" href="icons/style.css" />

<style type="text/css">
		.scheduler_default_corner div:nth-of-type(2) {
				display: none !important;
		}
</style>

<div style="margin-left: 0px;">
	<table>
		<tr>
			<td>
					<div class="space">
							<div class="row">
								<strong>	Date: </strong><span id="start"></span> <a href="#" onclick="picker.show(); return false;">Change</a>
								</div>
						</div>
				</td>
			</tr>
			<tr>
				<td>
					<div class="space">
							<div class="row">
									<?php
											Property:
											echo CHtml::activeDropDownList($model, 'property_id',
											CHtml::listData(Property::model()->findAll(), 'property_id', 'property_name'),
											array('empty'=>'Select Property','id'=>'filter'))
									?>
							</div>
						</div>
				</td>
			</tr>
			<tr>
				<td>
						<div class="space">
								Filter: <input id="filtersearch" /> <a href="#" id="clear">Clear</a>
						</div>
				</td>
			</tr>
	</table>
		<div id="dp"></div>
</div>

<?php
#fungsi cek url index regular atau flexible
$subs=substr($_GET['r'],21)."<br>";
$myText = (string)$subs;
if($subs='index')
{
	$idtype=0;
}
?>

<!--script untuk calendar navigasi/DatePicker-->
<script type="text/javascript">
		var picker = new DayPilot.DatePicker({
				target: 'start',
				pattern: 'yyyy-MM-dd',
				onTimeRangeSelected: function(args) {
						dp.startDate = args.start;
						loadTimeline(args.start);
						loadEvents();
						dp.update();
				}
		});
</script>

<!--script untuk calendar Scheduler-->
<script type="text/javascript">
			var dp = new DayPilot.Scheduler("dp");

			// view
			dp.startDate =DayPilot.Date.today();
			dp.cellGroupBy = "Month";
			dp.days = 1;
			dp.cellDuration = 60; // one day
			dp.eventDeleteHandling = "Update";
			dp.timeHeaders = [
				{ groupBy: "Day" },
				{ groupBy: "Hour" }
			];
			dp.scale = "CellDuration";

			// bubble, sync loading
			// see also DayPilot.Event.data.staticBubbleHTML property
			dp.eventHeight = 60;
			dp.eventStackingLineHeight = 30;

			//declare functions bubbleHtml
			dp.bubble = new DayPilot.Bubble({
        onLoad: function(args) {
            var ev = args.source;
            //args.html = "testing bubble for: " + ev.text();
        }
    });

		dp.contextMenu = new DayPilot.Menu({items: [
				{text:"Edit", onClick: function(args) { dp.events.edit(args.source); } },
				{text:"Delete", onClick: function(args) { dp.events.remove(args.source); } },
				{text:"-"},
				{text:"Select", onClick: function(args) { dp.multiselect.add(args.source); } },
		]});

			dp.progressiveRowRendering = true;
			dp.progressiveRowRenderingPreload = 25;

			dp.treeEnabled = true;
			dp.treePreventParentUsage = true;
			dp.rowHeaderWidth = 200;

			dp.eventHoverHandling = "Bubble";

			dp.onBeforeEventRender = function(args) {
					//console.log(JSON.stringify(args));
					var start = new DayPilot.Date(args.e.start);
					var end = new DayPilot.Date(args.e.end);
					//console.log('masuk event render');
					var today = DayPilot.Date.today();
					var now = new DayPilot.Date();

					args.e.html = args.e.text + " (" + start.toString("M/d/yyyy") + " - " + end.toString("M/d/yyyy") + ")";

					if(isNaN(args.e.id)){
						args.data.fontColor = "#fff";
	          args.data.backColor = "#E06666";
	          args.data.borderColor = "#E06666";
						args.e.barColor = 'red';
					}
					else {
						//none
					}

					//cekstatus events dan room closure
					switch (args.e.status) {
							case "New":
									var in2days = today.addDays(1);
									if (start < in2days) {
											args.e.barColor = 'red';
											args.e.toolTip = 'Expired (not confirmed in time)';
									}
									else {
											args.e.barColor = 'orange';
											args.e.toolTip = 'New';
									}
									break;
							case "Confirmed":
									var arrivalDeadline = today.addHours(18);

									if (start < today || (start.getDatePart() === today.getDatePart() && now > arrivalDeadline)) { // must arrive before 6 pm
											args.e.barColor = "#f41616";  // red
											args.e.toolTip = 'Late arrival';
									}
									else {
											args.e.barColor = "green";
											args.e.toolTip = "Confirmed";
									}
									break;
							case 'Arrived': // arrived
									var checkoutDeadline = today.addHours(10);

									if (end < today || (end.getDatePart() === today.getDatePart() && now > checkoutDeadline)) { // must checkout before 10 am
											args.e.barColor = "#f41616";  // red
											args.e.toolTip = "Late checkout";
									}
									else
									{
											args.e.barColor = "#1691f4";  // blue
											args.e.toolTip = "Arrived";
									}
									break;
							case 'CheckedOut': // checked out
									args.e.barColor = "gray";
									args.e.toolTip = "Checked out";
									break;
							case 'Cancel': // Cancel
									args.e.barColor = "#f41616";  // red
									args.e.toolTip = "Cancel";
									break;
							case 'unallocated': // is_unallocated
									args.e.barColor = "black";
									args.e.toolTip = "unallocated";
									break;
							default:
									//args.e.toolTip = "Unexpected state";
									args.e.toolTip = "Unavailable";
									break;
					}

					args.e.html = args.e.html + "<br /><span style='color:gray'>" + args.e.toolTip + "</span>";

					var paid = args.e.paid;
					var paidColor = "#aaaaaa";

					args.data.areas = [
	            {
	                onClick: function(args) { DayPilot.Modal.alert("<b>Event name:</b><br>" + args.source.text()); },
	                height:17,
	                width:20,
									visibility: "Hover",
			 						css: "event_action_delete",
	                html:"info",
	                top:36,
	                right:2,
	                style: "border: 1px solid #ccc; border-radius: 5px; font-size: 10px; box-sizing: border-box; padding: 1px; background-color: #fff;"
	            },
							{ bottom: 10, right: 4, html: "<div style='color:" + paidColor + "; font-size: 8pt;'>Paid: " + paid + "%</div>", v: "Visible"},
							{ left: 4, bottom: 8, right: 4, height: 2, html: "<div style='background-color:" + paidColor + "; height: 100%; width:" + paid + "%'></div>", v: "Visible" }
	        ];

	        args.e.bubbleHtml = "<div><b>" + args.e.text + "</b></div><div>Start: " + new DayPilot.Date(args.e.start).toString() + "</div><div>End: " + new DayPilot.Date(args.e.end).toString() + "</div>";

			};

			//fungsi sebelum load cell
			dp.onBeforeCellRender = function(args) {
				//console.log(JSON.stringify(args.cell.events()));
				if (args.cell.start < DayPilot.Date.today()) {
						args.cell.disabled = true;
						args.cell.backColor = "#ccc";
				}
				if (args.cell.start.getDay() === 1) { // first day of month
						args.cell.backColor = "#ffffd5";
						args.cell.html = "<div style='position:absolute;right:2px;bottom:2px;font-size:8pt;color:#666;'>Maintenance</div>";
						args.cell.properties.status = "Under Maintenance";
				}

				var row = dp.rows.find(args.cell.resource);
			};


		// event moving
		dp.onEventMoved = function (args) {
			//$.post("backend_move.php",
			$.post("<?php echo Yii::app()->createUrl('partner/reservations/loadmovedevent')?>&start="+args.newStart.toString()+"&end="+args.newEnd.toString()+"&id="+args.e.id()+"&resource="+args.newResource,
			{
					id: args.e.id(),
					newStart: args.newStart.toString(),
					newEnd: args.newEnd.toString(),
					newResource: args.newResource
			},
			function(data) {
				dp.message(data.message);
			});
		};

		// event resizing
		dp.onEventResized = function (args) {
			var r = confirm("Press a button!"); //buat konfirmasi
			if (r == true)
			{
				if(isNaN(args.e.id())){
					//$.post("backend_resize.php",
					$.post("<?php echo Yii::app()->createUrl('partner/reservations/loadresizedclosure')?>&start="+args.newStart.toString()+"&end="+args.newEnd.toString()+"&id="+args.e.id(),
					{
							id: args.e.id(),
							newStart: args.newStart.toString(),
							newEnd: args.newEnd.toString()
					},

					function() {
							dp.message("Resized.");
					});
				}
				else{
					$.post("<?php echo Yii::app()->createUrl('partner/reservations/loadresizedevent')?>&start="+args.newStart.toString()+"&end="+args.newEnd.toString()+"&id="+args.e.id(),
					{
							id: args.e.id(),
							newStart: args.newStart.toString(),
							newEnd: args.newEnd.toString()
					},

					function() {
							dp.message("Resized.");
					});
				}
			}
		};

		// event creating
		dp.onTimeRangeSelected = function (args) {
			//var name = prompt("New event name:", "Event");
			var modal = new DayPilot.Modal();
			modal.closed = function() {
				dp.clearSelection();

				// reload all events
				var data = this.result;
				if (data && data.result === "OK") {
					loadEvents();
				}
			};
			modal.showUrl("<?php echo Yii::app()->createUrl('partner/reservations/loadpages')?>&start=" + args.start + "&end=" + args.end + "&resource=" + args.resource+ "&idtype=" + <?php echo $idtype;?>);
		};

		//module edit events
		dp.onEventClicked = function(args) {
				var modal = new DayPilot.Modal();
				modal.closed = function() {
					// reload all events
					var data = this.result;
					if (data && data.result === "OK") {
						loadEvents();
					}
				};

				//console.log(JSON.stringify(args));
				//fungsi cek event atau roomclosure
				if(isNaN(args.e.id())){
					modal.showUrl("<?php echo Yii::app()->createUrl('partner/roomclosure/updatecal')?>&id=" + args.e.id());
				}
				else {
					modal.showUrl("<?php echo Yii::app()->createUrl('partner/reservations/loadeditevent')?>&id=" + args.e.id()+ "&idtype=" + <?php echo $idtype;?>);
				}
		};

		// event delete
		dp.onEventDeleted = function(args) {
        //$.post("backend_delete.php",
				$.post("<?php echo Yii::app()->createUrl('partner/reservations/delete')?>&id="+args.e.id(),
        {
            id: args.e.id()
        },
        function() {
            dp.message("Deleted.");
        });
    };

		dp.onTimeHeaderClick = function(args) {
			alert("clicked: " + args.header.start);
		};

		//event onmoving
		dp.onEventMoving = function(args) {
			var offset = args.start.getMinutes() % 5;
			if (offset) {
			args.start = args.start.addMinutes(-offset);
			args.end = args.end.addMinutes(-offset);
		}

		args.left.enabled = true;
		args.left.html = args.start.toString("h:mm tt");
		};

		//dp.cellWidth = 60;
		dp.cellWidth = 40;  // reset for "Fixed" mode
		dp.cellWidthSpec ="Auto";
		dp.update();

		dp.onIncludeTimeCell = function(args) {

		};

		dp.onRowFilter = function(args) {
				if (args.row.name.toUpperCase().indexOf(args.filter.toUpperCase()) === -1) {
						args.visible = false;
				}
		};

		dp.init();

		loadResources();
		loadEvents();

		function loadTimeline(date) {

			dp.startDate = new DayPilot.Date(date);
			dp.update();
		}

		//load events/reservation
		function loadEvents() {
			var start = dp.visibleStart();
			var end = dp.visibleEnd();
			//alert(start);
			//$.post("backend_events.php",
			$.post("<?php echo Yii::app()->createUrl('partner/reservations/loadevents')?>&start="+start+"&end="+end,
				{
					start: start.toString(),
					end: end.toString()
				},
				function(data) {
					dp.events.list = data;
					dp.update();
				}
			);
		}

		function loadResources() {
				//$.post("backend_rooms.php",
				//console.log($("#filter").val());
				var pid =$("#filter").val();
				$.post("<?php echo Yii::app()->createUrl('partner/reservations/loadroom')?>&pid="+pid,
					function(data) {
					dp.resources = data;
					//console.log(data);
					dp.update();
				});
		}

		$(document).ready(function() {
				var capacity = 0;
				$("#filter").change(function() {
					loadResources();
				});
				$("#print-button").click(function(ev) {
	            ev.preventDefault();
	            var format = $("#format").val();
	            dp.exportAs(format).print();
	        });
				//buat filter search
				$("#filtersearch").keyup(function() {
	            var query = $(this).val();
	            dp.rows.filter(query); // see dp.onRowFilter below
	        });
        $("#clear").click(function() {
            $("#filtersearch").val("");
            dp.rows.filter(null);
            return false;
        });
		});
dp.scrollTo(new DayPilot.Date());

</script>

<!-- bottom -->

<script type="text/javascript">
		$(document).ready(function() {
			var url = window.location.href;
			var filename = url.substring(url.lastIndexOf('/')+1);
			if (filename === "") filename = "index.html";
			$(".menu a[href='" + filename + "']").addClass("selected");
		});
</script>
