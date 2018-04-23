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

		<div style="width:160px; float:left;">
				<div id="nav"></div>
		</div>

		<div style="margin-left: 160px;">

				<div class="space">
						Show rooms:
						<select id="filter">
								<option value="0">All</option>
								<option value="1">Single</option>
								<option value="2">Double</option>
								<option value="4">Family</option>
						</select>

						<div class="space">
								Time range:
								<select id="timerange">
										<option value="days">Days</option>
										<option value="week">Week</option>
										<option value="month" selected>Month</option>
								</select>
								<label for="autocellwidth"><input type="checkbox" id="autocellwidth">Auto Cell Width</label>
						</div>
				</div>

				<div id="dp"></div>

		</div>
<?php
$subs=substr($_GET['r'],21)."<br>";
$myText = (string)$subs;
if($subs='index')
{
	$idtype=0;
}
?>
<script type="text/javascript">
		var nav = new DayPilot.Navigator("nav");
		nav.selectMode = "month";
		nav.showMonths = 3;
		nav.skipMonths = 3;
		nav.onTimeRangeSelected = function(args) {
				loadTimeline(args.start);
				loadEvents();
		};
		nav.init();

		$("#timerange").change(function() {
				switch (this.value) {
						case "days":
							dp.days = 1;
							nav.selectMode = "Day";
							nav.select(nav.selectionDay);
							break;
						case "week":
								dp.days = 7;
								nav.selectMode = "Week";
								nav.select(nav.selectionDay);
								break;
						case "month":
								dp.days = dp.startDate.daysInMonth();
								nav.selectMode = "Month";
								nav.select(nav.selectionDay);
								break;
				}
		});

		$("#autocellwidth").click(function() {
				dp.cellWidth = 40;  // reset for "Fixed" mode
				dp.cellWidthSpec = $(this).is(":checked") ? "Auto" : "Fixed";
				dp.update();
		});

		$("#add-room").click(function(ev) {
				ev.preventDefault();
				var modal = new DayPilot.Modal();
				modal.onClosed = function(args) {
						loadResources();
				};
				modal.showUrl("room_new.php");
		});
</script>
<script type="text/javascript">
			var dp = new DayPilot.Scheduler("dp");

			// view
			//dp.startDate = new DayPilot.Date("2013-03-24");  // or just dp.startDate = "2013-03-25";
			//dp.startDate = new DayPilot.Date("2018-04-17 14:00:00");
			dp.startDate =DayPilot.Date.today();
			//alert(dp.startDate);
			//dp.days = dp.startDate.daysInMonth();
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
			dp.bubble = new DayPilot.Bubble();

			dp.contextMenu = new DayPilot.Menu({items: [
			{text:"Show event ID", onclick: function() {alert("Event value: " + this.source.value());} },
			{text:"Show event text", onclick: function() {alert("Event text: " + this.source.text());} },
			{text:"Show event start", onclick: function() {alert("Event start: " + this.source.start().toStringSortable());} },
			{text:"Go to google.com", href: "http://www.google.com/?q={0}"},
			{text:"CallBack: Delete this event", command: "delete"} ,
			{text:"submenu", items: [
							{text:"Show event ID", onclick: function() {alert("Event value: " + this.source.value());} },
							{text:"Show event text", onclick: function() {alert("Event text: " + this.source.text());} }
					]
			}
			]});

			dp.treeEnabled = true;
			dp.treePreventParentUsage = true;
			dp.rowHeaderWidth = 200;

			dp.eventHoverHandling = "Bubble";

			dp.onBeforeEventRender = function(args) {
			args.e.bubbleHtml = args.e.start + " " + args.e.end;
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
	      var r = confirm("Press a button!");
	      if (r == true)
	      {
	        //$.post("backend_resize.php",
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
		//alert(args.resource);
		//modal.showUrl("new.php?start=" + args.start + "&end=" + args.end + "&resource=" + args.resource);
		//modal.showUrl("<?php //echo Yii::app()->createUrl('partner/reservations/loadcreateevent')?>&start=" + args.start + "&end=" + args.end + "&resource=" + args.resource);
		modal.showUrl("<?php echo Yii::app()->createUrl('partner/reservations/loadpages')?>&start=" + args.start + "&end=" + args.end + "&resource=" + args.resource+ "&idtype=" + <?php echo $idtype;?>);
		//dp.events.add(e);
		//dp.message("Created");
		};

		dp.onEventClicked = function(args) {
		var modal = new DayPilot.Modal();
			modal.closed = function() {
				// reload all events
				var data = this.result;
				if (data && data.result === "OK") {
					loadEvents();
				}
			};
			//modal.showUrl("edit.php?id=" + args.e.id());
			modal.showUrl("<?php echo Yii::app()->createUrl('partner/reservations/loadeditevent')?>&id=" + args.e.id()+ "&idtype=" + <?php echo $idtype;?>);
		};

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

		dp.onEventMoving = function(args) {
		var offset = args.start.getMinutes() % 5;
		if (offset) {
		args.start = args.start.addMinutes(-offset);
		args.end = args.end.addMinutes(-offset);
		}

		args.left.enabled = true;
		args.left.html = args.start.toString("h:mm tt");
		};

		dp.cellWidth = 60;

		dp.onIncludeTimeCell = function(args) {

		};

		dp.onBeforeEventRender = function(args) {
				var start = new DayPilot.Date(args.e.start);
				var end = new DayPilot.Date(args.e.end);

				var today = DayPilot.Date.today();
				var now = new DayPilot.Date();

				args.e.html = args.e.text + " (" + start.toString("M/d/yyyy") + " - " + end.toString("M/d/yyyy") + ")";

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
						default:
								args.e.toolTip = "Unexpected state";
								break;
				}

				args.e.html = args.e.html + "<br /><span style='color:gray'>" + args.e.toolTip + "</span>";

				var paid = args.e.paid;
				var paidColor = "#aaaaaa";

				args.e.areas = [
						{ bottom: 10, right: 4, html: "<div style='color:" + paidColor + "; font-size: 8pt;'>Paid: " + paid + "%</div>", v: "Visible"},
						{ left: 4, bottom: 8, right: 4, height: 2, html: "<div style='background-color:" + paidColor + "; height: 100%; width:" + paid + "%'></div>", v: "Visible" }
				];

		};

			dp.init();

			loadResources();
			loadEvents();

			function loadTimeline(date) {
				//alert(date);
				// dp.scale = "Hour";
				// dp.timeline = [];

				dp.startDate = new DayPilot.Date(date);
				/*
				var start = date.getDatePart().addHours(12);

				for (var i = 0; i < dp.days; i++) {
				dp.timeline.push({start: start.addDays(i), end: start.addDays(i+1)});
				}
				*/
				dp.update();
			}

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
				var capacity = $("#filter").val();
				$.post("<?php echo Yii::app()->createUrl('partner/reservations/loadroom')?>&capacity="+capacity,

				{ capacity: $("#filter").val() },
					function(data) {
					dp.resources = data;
					dp.update();
				});
		}
		$(document).ready(function() {
			var capacity = 0;
			$("#filter").change(function() {
				loadResources();
			});
		});
dp.scrollTo("2013-03-24T16:00:00");

</script>

<!-- bottom -->
</div>
</div>
</div>
</div>
<script type="text/javascript">
$(document).ready(function() {
var url = window.location.href;
var filename = url.substring(url.lastIndexOf('/')+1);
if (filename === "") filename = "index.html";
$(".menu a[href='" + filename + "']").addClass("selected");
});

</script>
