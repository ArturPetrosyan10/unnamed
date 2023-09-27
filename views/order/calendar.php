<?php
$this->registerCssFile('@web/calendar/css/style.css', ['depends'=>'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_READY]);
$this->registerJsFile('@web/calendar/js/jquery.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/calendar/js/popper.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/calendar/js/bootstrap.min.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
$this->registerJsFile('@web/calendar/js/main.js', ['depends' => 'yii\web\JqueryAsset', 'position' => \yii\web\View::POS_END]);
?>
<style>
    .calendar_header h2{
        color:whitesmoke;
    }
    .ftco-section {
        padding:  0;
    }
</style>
<section class="ftco-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="calendar calendar-first" id="calendar_first">
                    <div class="calendar_header">
                        <button class="switch-month switch-left"> <i class="fa fa-chevron-left"></i></button>
                        <h2></h2>
                        <button class="switch-month switch-right"> <i class="fa fa-chevron-right"></i></button>
                    </div>
                    <div class="calendar_weekdays"></div>
                    <div class="calendar_content">
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

