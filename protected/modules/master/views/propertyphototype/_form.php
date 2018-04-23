<!-- daypilot libraries -->
<script src="js/daypilot/daypilot-all.min.js" type="text/javascript"></script>

<link type="text/css" rel="stylesheet" href="icons/style.css" />

<style type="text/css">
		.icon {
				font-size: 14px;
				text-align: center;
				line-height: 14px;
				vertical-align: middle;

				cursor: pointer;
		}

		.scheduler_default_rowheader_inner
		{
				border-right: 1px solid #ccc;
		}
		.scheduler_default_rowheadercol2
		{
				background: White;
		}
		.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
		{
				top: 2px;
				bottom: 2px;
				left: 2px;
				background-color: transparent;
				border-left: 5px solid #38761d; /* green */
				border-right: 0px none;
		}
		.status_dirty.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
		{
				border-left: 5px solid #cc0000; /* red */
		}
		.status_cleanup.scheduler_default_rowheadercol2 .scheduler_default_rowheader_inner
		{
				border-left: 5px solid #e69138; /* orange */
		}

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

<div class="form">

<?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'propertyphototype-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
)); ?>

	<p class="note">Fields with <span class="required">*</span> are required.</p>

	<?php if($model->hasErrors()) echo $form->errorSummary($model); ?>

	<?php Helper::showFlash(); ?>
	<div class="row">
		<?php echo $form->labelEx($model,'propertyphototype_name'); ?>
		<?php echo $form->textField($model,'propertyphototype_name',array('size'=>20,'maxlength'=>20,'placeholder'=>'Masukan Type Photo')); ?>
		<?php echo $form->error($model,'propertyphototype_name'); ?>
	<div class="row buttons">
		<?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save'); ?>
	</div>

<?php $this->endWidget(); ?>

</div><!-- form -->

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

dp.timeHeaders = [
{ groupBy: "Day" },
{ groupBy: "Hour" }
];
dp.scale = "CellDuration";

// bubble, sync loading
// see also DayPilot.Event.data.staticBubbleHTML property
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
dp.rowHeaderWidth = 200;

dp.eventHoverHandling = "Bubble";

dp.onBeforeEventRender = function(args) {
args.e.bubbleHtml = args.e.start + " " + args.e.end;
};

// event moving
dp.onEventMoved = function (args) {
$.post("backend_move.php",
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
$.post("backend_resize.php",
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
alert(args.resource);
//modal.showUrl("new.php?start=" + args.start + "&end=" + args.end + "&resource=" + args.resource);
<?php Yii::app()->createUrl('core/globalsetting/loadCreateEvent')?>
//alert("<?php //echo Yii::app()->createUrl('core/globalsetting/loadcities')?>");
modal.showUrl("<?php echo Yii::app()->createUrl('core/globalsetting/loadCreateEvent')?>&start=" + args.start + "&end=" + args.end + "&resource=" + args.resource);
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
modal.showUrl("edit.php?id=" + args.e.id());
};

dp.onTimeHeaderClick = function(args) {
alert("clicked: " + args.header.start);
};

dp.snapToGrid = false;
dp.useEventBoxes = "Never";

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


dp.init();

loadResources();
loadEvents();

function loadTimeline(date) {
alert(date);
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

$.post("backend_events.php",
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
$.post("<?php echo Yii::app()->createUrl('core/globalsetting/loadcreateevent')?>",

{ capacity: $("#filter").val() },
function(data) {
dp.resources = data;
dp.update();
});
}
$(document).ready(function() {
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
