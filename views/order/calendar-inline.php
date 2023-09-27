
    <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui-touch-punch/0.2.3/jquery.ui.touch-punch.min.js"></script>
    <script defer type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.7.0/moment-with-langs.min.js"></script>
    <script defer  type="text/javascript" src="/calendar-inline/js/jquery.rangecalendar.js"></script>
    <link rel="stylesheet" href="https://netdna.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="/calendar-inline/css/rangecalendar.css">
    <?php  $this->registerCssFile('@web/calendar-inline/css/rangecalendar.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]); ?>
    <?php  $this->registerCssFile('@web/calendar-inline/css/style.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]); ?>
    <script >
         window.onload= function() {
             var customizedRangeCalendar = $("#cal2").rangeCalendar({theme: "full-green-theme"});
             function rangeChanged(target, range) {
                 var startDay = moment(range.start).format('DD');
                 var startMonth = moment(range.start).format('MMM');
                 var startYear = moment(range.start).format('YY');
                 var endDay = moment(range.end).format('DD');
                 var endMonth = moment(range.end).format('MMM');
                 var endYear = moment(range.end).format('YY');
                 $(".calendar-values .start-date .value").html(startDay);
                 $(".calendar-values .start-date .label").html("");
                 $(".calendar-values .start-date .label").append(startMonth);
                 $(".calendar-values .start-date .label").append("<small>" + startYear + "</small>");
                 $(".calendar-values .end-date .value").html(endDay);
                 $(".calendar-values .end-date .label").html("");
                 $(".calendar-values .end-date .label").append(endMonth);
                 $(".calendar-values .end-date .label").append("<small>" + endYear + "</small>");
                 $(".calendar-values .days-width .value").html(range.width);
                 $(".calendar-values .from-now .label").html(range.fromNow);
             }
         }
    </script>

<div id="cal2"></div>

