<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Vendor */
/* @var $form yii\widgets\ActiveForm */
?>
<div class="vendor-form">

    <?php 
        
        $formOptions                =   ['options' => [ 'enctype' =>  'multipart/form-data']];
        if($model->isNewRecord)
        {
            $model->vendor_category =   $categoryID;
            $formOptions['action']  =   Url::to(['vendor/create?id=' . $categoryID]);
        }
        else
            $formOptions['action']  =   Url::to(['vendor/update?id=' . $model->vendor_id  . '&categoryID=' . $category]);
        //var_dump($formOptions);die;
    ?>

    <?php $form = ActiveForm::begin($formOptions); ?>
    
    <?= $form->field($model, 'vendor_name_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_name_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_description_en')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'vendor_description_ar')->textarea(['rows' => 6]) ?>
    
    <?php 
        $toolTip = [];
        $i = 0;
        foreach($categories AS $category)
        {
            $categoryList = array_unique(array_reverse($model->getCategoryList($category['category_id'])));
            $toolTip[$category['category_id']] = ['data-content' => '<span title="' . implode(' > ', $categoryList) . '">' . $category['category_name_en'] . '</span>'];
        }
    ?>

    <!--$form->field($model, 'vendor_category')->dropDownList(ArrayHelper::map($categories, 'category_id', 'category_name_en'), ['multiple' => true, 'id' => 'category', 'class' => 'selectpicker', 'title' => 'Select Category', "data-selected-text-format" => "count", "data-live-search" => "true", "data-actions-box" => "true", 'options' => $toolTip]) ?>-->

    <label>Vendor Category</label>
    <?= "<div class='category_drop_down_list'><table class='table'>" . $categoryDropDownList . "</table></div>" ?>

    <br>

    <?= $form->field($model, 'vendor_phone1')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_phone2')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_logo')->fileInput(['accept' => 'image/*']) ?>

    <?php 
        if(!$model->isNewRecord && $model->vendor_logo)
            echo Html::img($model->vendor_logo, ['id' => 'vendor_logo']) ;
    ?>

    <?= $form->field($model, 'vendor_gallery[]')->fileInput(['multiple' => true, 'accept' => 'image/*']) ?>


    <?php 
        if(!$model->isNewRecord)
        {
            echo "<p class=hint>Note: Drag and drop images for changing the sort order</p>";
            $vendorGalleries = $model->getGalleries($model->vendor_id, 1);
            echo ($vendorGalleries) ? ($vendorGalleries . "<div style='clear:both;'></div>") : '';
        }
    ?>

    <?= $form->field($model, 'vendor_website')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_youtube_video')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_social_instagram')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_social_twitter')->textInput(['maxlength' => true]) ?>

    <?php 
        if($model->vendor_location != "")
        {
            $latLng     = explode(",", $model->vendor_location);
            $latitude   = (isset($latLng[0]) && !empty($latLng[0])) ? $latLng[0] : 0;
            $longitude  = (isset($latLng[1]) && !empty($latLng[1])) ? $latLng[1] : 0;
        }
        else
            $latitude = $longitude = '';
    ?>

    <?= $form->field($model, 'vendor_area_name_en')->textInput(['maxlength' => true]) ?>
    
    <?= $form->field($model, 'vendor_area_name_ar')->textInput(['maxlength' => true]) ?>
    
     <?php 
        $style = '';
        if($model->isNewRecord)
            $model->is_vendor_location = 1;
        else if($latitude && $longitude)
            $model->is_vendor_location = 1;
        else
            $model->is_vendor_location = 0;
    ?>

    <?= $form->field($model, 'is_vendor_location')->radioList([1 => 'Yes', 0 => 'No']) ?>
    
    <div class='vendorLocation'>
        <?= $form->field($model, 'vendor_location', ['template' => '{label}' . $form->field($model, 'vendor_area', ['template' => '{input}&nbsp;<input type="text" id="location-text-box" style="width:70%;"/><input type="hidden" id="latitude" name="latitude" value="' . $latitude . '"/><input type="hidden" id="longitude" name="longitude" value="' . $longitude . '"/>'])->dropDownList(ArrayHelper::map($areas, 'id', 'area_name_en'), ['multiple' => true, 'id' => 'area',  'class' => 'selectpicker', 'title' => 'Select Area', "data-selected-text-format" => "count", "data-live-search" => "true", "data-actions-box" => "true"]) . '{input}{hint}'])->hiddenInput(['maxlength' => true, 'value' => $model->vendor_location]) ?>
        <div id="map-canvas"></div>
        <br>
    </div>


    <?= $form->field($model, 'vendor_address_text_en')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_address_text_ar')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'vendor_account_start_date')->textInput(['id' =>'start_date', 'class' => 'datepicker', 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'vendor_account_end_date')->textInput(['id' => 'end_date', 'class' => 'datepicker', 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'sort_order')->textInput(['maxlength' => 9]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?php 
            if($model->isNewRecord) 
                echo Html::a('Back', Url::to(['vendor/index', 'id' => $categoryID]), ['class' => 'btn btn-default']);
            else
                echo Html::a('Back', Url::to(['vendor/index']), ['class' => 'btn btn-default']);
        ?>
        
    </div>
    <?php ActiveForm::end(); ?>

</div>
<div class="notification success"></div>

<?php
    $js = <<<JS
    // get the form id and set the event
    $('#w0').on('afterValidate', function(e) {
        // return false to prevent submission
        if(($('.has-error').length != 0)){
            $('#fade').remove();
            $('.processing_image').hide();
            return true;
        }
        return false;
    });
JS;
    $this->registerJs($js);
    if(!$model->isNewRecord && !empty($model->vendor_category))
    {
        $this->registerJs("var json = " . json_encode($model->vendor_category) . ";$.each(json, function(index, value){ $('input#' + value).attr('checked', true); });");
    }

    $this->registerJsFile($this->theme->baseUrl . "/js/jquery.aCollapTable.js", [
      'depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJs("$('.category_drop_down_list table').aCollapTable({ 
      startCollapsed: true,
      addColumn: false, 
      plusButton: '<span class=\"i\">&blacktriangleright;</span>', 
      minusButton: '<span class=\"i\">&blacktriangledown;</span>' 
    });");
    $this->registerCss(".ui-state-default{border:none;background:transparent;}.thumbnail a{color: #fff !important;}.form-group .field-vendor-vendor_governorate{display: inline-block;margin-bottom: 0px;}.checkbox_label{display:inline-block;}.category_drop_down_list{height: 150px;overflow-x:hidden;border: 1px solid #ccc;}.dropdown-menu.inner li a span{display: block;}.notification {display:none; position: fixed;bottom: 1%;right: 1%;background: #ccc;width: 20%;padding: 1%;border-radius: 3px;}#map-canvas {height: 350px;width: 100%;margin:0 auto;}.notification .loading, .notification .success{display:none;}.notification.success{background: #AECE4E;color:#556E0A;font-weight:bold;}.notification.error{background: #F35958;color:#fff;}div#ui-datepicker-div{z-index: 999 !important;}#vendor_logo{width: 30%;} .vendor_gallery{height: 120px !important;}");
    $this->registerCssFile($this->theme->baseUrl . "/plugins/bootstrap-select/css/bootstrap-select.min.css");
    $this->registerJsFile($this->theme->baseUrl . "/plugins/bootstrap-select/js/bootstrap-select.min.js", [
        'depends' =>  \yii\web\JqueryAsset::className(),
    ]);

    $this->registerJs('    
        //Change sort order of the vendor galleries
        function changeSortOrder()
        {
            var vendorGalleries = [];
            $("#sortable1 .ui-state-default").each(function(index, element){
                vendorGalleries.push({"id" : $(element).attr("data-attr-id"), "sort_order" : index});
            });
            $.ajax({
                url         :   "' . Url::to(['/vendor/change_order']) . '",
                type        :   "POST",
                data        :   {order : vendorGalleries},
                dataType    :   "json",
                beforeSend  :   function(){
                    $(".notification").removeClass("success").html(\'<div><img src="'. $this->theme->baseUrl .'/img/small-loader.gif"/><span>Loading...</span></div>\').fadeIn();
                },
                complete    :   function(){
                    $(".notification").fadeOut();
                },
                async       :   false,
                success     :   function(data){
                    if(data.status == 200)
                    {
                        $(".notification").html(\'<div><i class="fa fa-check fa-fw"></i><span>\' + data.message + \'</span></div>\').addClass("success").fadeIn().delay(3000).fadeOut();
                    }
                },
            })
            console.log(vendorGalleries);
        }

        //Drag and drop vendor gallery images
        $("#sortable1").sortable({
            connectWith :   ".connectedSortable",
            update      :   function(event, ui){
                changeSortOrder();
            }
        }).disableSelection();

        $("#start_date").datepicker({
            "dateFormat"   : "dd-mm-yy", 
            "minDate"      : 0,
            "onSelect" : function(dateText){
                $("#end_date").datepicker("option", "minDate", $(this).datepicker("getDate"));
            }
        }); 
        $("#end_date").datepicker({
            "dateFormat"   : "dd-mm-yy", 
            "minDate"      : 0,
            "onSelect" : function(dateText){
                $("#start_date").datepicker("option", "maxDate", $(this).datepicker("getDate"));
            }
        });
        $(document).on("click", ".gallery_action", function(e){
            e.preventDefault();
            var element     =   $(this);
            if(confirm("Are you sure want to delete?"))
            {
                $.ajax({
                    url         :   "' . Url::to(['/vendor/delete_gallery']) . '",
                    type        :   "POST",
                    data        :   {gallery: $(this).attr("id")},
                    dataType    :   "json",
                    beforeSend  :   function(){
                        $(".notification").removeClass("success").html(\'<div><img src="'. $this->theme->baseUrl .'/img/small-loader.gif"/><span>Loading...</span></div>\').fadeIn();
                    },
                    complete    :   function(){
                        $(".notification").fadeOut();
                    },
                    async       :   false,
                    success     :   function(data){
                        $(".notification").html(\'<div><i class="fa fa-check fa-fw"></i><span>Vendor image deleted successfully</span></div>\').addClass("success").fadeIn(function(){
                            $(element).parents(".col-sm-6").remove();
                        }).delay(3000).fadeOut();
                    },
                    error       :   function(){
                        alert("error");
                    },
                });
            }
        });'
    );

?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?v=3.exp&amp;key=AIzaSyD5pBOjUU2tT3jlSprqJzc-7HHJOZL2csg&amp;libraries=geometry,places"></script>
<script type="text/javascript">
    var map;
    var marker;

    //Prevent form submission by using enter key in google autocomplete search field
    document.getElementById("location-text-box").onkeypress = function(e) {
        var key = e.charCode || e.keyCode || 0;     
        if (key == 13)
            e.preventDefault();
    }

    //Google map initialization
    function initialize() 
    {
        var mapOptions = {
            zoom: 15
        };

        map             =   new google.maps.Map(document.getElementById("map-canvas"), mapOptions);
        var oldLatLng   =   "<?php echo $model->vendor_location; ?>";
        // Get GEOLOCATION
        if (navigator.geolocation) 
        {
            navigator.geolocation.getCurrentPosition(function(position) {
                if(oldLatLng)
                {
                    var latLngs     =   oldLatLng.split(",");
                    var latitude    =   latLngs[0];
                    var longitude   =   latLngs[1];
                    var pos         =   new google.maps.LatLng(latitude, longitude);
                    document.getElementById("location-text-box").value = "vadavalli";
                }
                else
                {
                    var pos         =   new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                }

                map.setCenter(pos);
                marker = new google.maps.Marker({
                    position    :   pos,
                    map         :   map,
                    draggable   :   true,
                });


                getLatitudeLongitude();

                google.maps.event.addListener(marker, "dragend", function(event){
                    getLatitudeLongitude();
                });

            }, function(error){
                if(error.code == error.PERMISSION_DENIED)
                {
                    if(oldLatLng)
                    {
                        var latLngs     =   oldLatLng.split(",");
                        var latitude    =   latLngs[0];
                        var longitude   =   latLngs[1];
                        var pos         =   new google.maps.LatLng(latitude, longitude);
                        document.getElementById("location-text-box").value = "vadavalli";
                    }
                    else
                        var pos         =   new google.maps.LatLng(11.0168, 76.9558);

                    map.setCenter(pos);
                    marker = new google.maps.Marker({
                        position    :   pos,
                        map         :   map,
                        draggable   :   true,
                    });

                    getLatitudeLongitude();

                    google.maps.event.addListener(marker, "dragend", function(event){
                        getLatitudeLongitude();
                    });
                }
            });
        } 
        else {
            // Browser does not support Geolocation
            handleNoGeolocation(false);
        }

        google.maps.event.addListener(map, 'click', function(event){
            if (marker) {
                //if marker already was created change positon
                marker.setPosition(event.latLng);
                getLatitudeLongitude();
            } else {
                //create a marker
                marker = new google.maps.Marker({          
                    position: event.latLng,
                    map: map,
                    draggable: true
                });
                getLatitudeLongitude();
            }
        })

        // get places auto-complete when user type in location-text-box
        var input = document.getElementById("location-text-box");

        var autocomplete = new google.maps.places.Autocomplete(input);
        autocomplete.bindTo("bounds", map);

        var infowindow = new google.maps.InfoWindow();
        marker = new google.maps.Marker({
            map         :   map,
            anchorPoint :   new google.maps.Point(0, -29),
            draggable   :   true
        });


        google.maps.event.addDomListener(input, 'keydown', function(e) { 
            if (e.keyCode == 13) 
            { 
                //$(".pac-container .pac-item:first").click();
                var firstResult = $(".pac-container .pac-item:first").text();

                var geocoder = new google.maps.Geocoder();
                geocoder.geocode({"address":firstResult }, function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK) 
                    {
                        var lat = results[0].geometry.location.lat(),
                            lng = results[0].geometry.location.lng(),
                            placeName = results[0].address_components[0].long_name,
                            latlng = new google.maps.LatLng(lat, lng);

                        $(".pac-container .pac-item:first").addClass("pac-selected");
                        $(".pac-container").css("display","none");
                        $("#searchTextField").val(firstResult);
                        $(".pac-container").css("visibility","hidden");

                        // If the place has a geometry, then present it on a map.
                        if (results[0].geometry.viewport) 
                            map.fitBounds(results[0].geometry.viewport);
                        else 
                        {
                            map.setCenter(results[0].geometry.location);
                            map.setZoom(17); // Why 17? Because it looks good.
                        }

                        marker.setPosition(results[0].geometry.location);
                        marker.setVisible(true);
                    }
                    getLatitudeLongitude();
                });
            }
        });

        google.maps.event.addListener(autocomplete, "place_changed", function() {
            infowindow.close();
            marker.setVisible(false);
            var place = autocomplete.getPlace();
            if (!place.geometry) {
                return;
            }

            geocoder    =   new google.maps.Geocoder();
            var address =   document.getElementById("location-text-box").value;
            geocoder.geocode( { 'address': address}, function(results, status) {
                if (status == google.maps.GeocoderStatus.OK) 
                {

                    document.getElementById("location-text-box").value      =   results[0].formatted_address;
                    document.getElementById("latitude").value               =   results[0].geometry.location.lat();
                    document.getElementById("longitude").value              =   results[0].geometry.location.lng();
                    document.getElementById("vendor-vendor_location").value =   results[0].geometry.location.lat() + "," + results[0].geometry.location.lng();
                } 
            });

            // If the place has a geometry, then present it on a map.
            if (place.geometry.viewport) 
                map.fitBounds(place.geometry.viewport);
            else 
            {
                map.setCenter(place.geometry.location);
                map.setZoom(17); // Why 17? Because it looks good.
            }
        
            marker.setIcon( /** @type {google.maps.Icon} */ ({
                url: place.icon,
                size: new google.maps.Size(71, 71),
                origin: new google.maps.Point(0, 0),
                anchor: new google.maps.Point(17, 34),
                scaledSize: new google.maps.Size(35, 35)
            }));
            
            marker.setPosition(place.geometry.location);
            marker.setVisible(true);

            var address = '';
            if (place.address_components) {
                address = [
                    (place.address_components[0] && place.address_components[0].short_name || ""), (place.address_components[1] && place.address_components[1].short_name || ""), (place.address_components[2] && place.address_components[2].short_name || "")
                ].join(" ");
            }

            google.maps.event.addListener(marker, "dragend", function(event){
                getLatitudeLongitude();
            });
        });
    }



    function getLatitudeLongitude()
    {
        var newLat      =   marker.getPosition().lat();
        var newLng      =   marker.getPosition().lng();
        var myLatlngs   =   new google.maps.LatLng(newLat,newLng);
        geocoder        =   new google.maps.Geocoder();
        geocoder.geocode({'latLng': myLatlngs }, function(results, status) 
        {
            if(results)
            {
                document.getElementById("location-text-box").value      =   results[0].formatted_address;
                document.getElementById("latitude").value               =   results[0].geometry.location.lat();
                document.getElementById("longitude").value              =   results[0].geometry.location.lng();
                document.getElementById("vendor-vendor_location").value =   results[0].geometry.location.lat() + "," + results[0].geometry.location.lng();
            }
        });
    }
    google.maps.event.addDomListener(window, 'load', initialize);
</script>