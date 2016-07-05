<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\helpers\Url;
/* @var $this yii\web\View */
/* @var $model backend\models\Vendor */

$this->title                    =   ($category) ? Yii::t('app', 'Categories') : Yii::t('app', 'Vendors');
$initalBreadCrumb               =   ($category) ? ['label' => Yii::t('app', 'Category'), 'url' => [Url::to(['category/index'])]] : ['label' => Yii::t('app', 'Vendors'), 'url' => ['index']];
$this->params['breadcrumbs'][]  =   $initalBreadCrumb;

if($categoryList)
{
    $count = count($categoryList) - 1;
    for($i = 0; $i <= $count; $i++)
        $this->params['breadcrumbs'][] = ['url' => Url::to(['index', 'id' => $categoryList[$i]['category_id']]), 'label' => $categoryList[$i]['category_name_en']];
}

$this->title = $model->vendor_name_en;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="vendor-view">

    <p>
        <?= Html::a(Yii::t('app', 'Update'), ['update', 'id' => $model->vendor_id, 'categoryID' => $category], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->vendor_id, 'category' => $category], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
        <?php  
            if($category)
                echo Html::a('Back', ['category/index', 'id' => $category], ['class' => 'btn btn-default']);
            else
                echo Html::a('Back', ['vendor/index'], ['class' => 'btn btn-default']);
        ?>

    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            [
                'attribute' =>  'vendor_logo',
                'value'     =>  ($model->vendor_logo) ? Html::img($model->vendor_logo, ['id' => 'vendor_logo']) : '',
                'format'    =>  'raw',
            ],
            'vendor_name_en',
            'vendor_name_ar',
            'vendor_description_en:ntext',
            'vendor_description_ar:ntext',
            'vendor_phone1',
            'vendor_phone2',
            'vendor_website',
            'vendor_youtube_video',
            'vendor_social_instagram',
            'vendor_social_twitter',
            'vendor_governorate',
            [
                'attribute' => 'vendor_location',
                'value'     =>  '<div id="map"></div>',
                'format'    =>  'raw',
            ],
            'vendor_address_text_en',
            'vendor_address_text_ar',
            [
                'attribute' =>  'vendor_account_start_date',
                'format'    =>  'date',
            ],
            [
                'attribute' =>  'vendor_account_end_date',
                'format'    =>  'date',
            ],
            [
                'label'     =>  'Vendor Categories',
                'value'     =>  $model->getCategories($model->vendor_id),
                'format'    =>  'raw',
            ],
            [
                'label'     =>  'Vendor Areas',
                'value'     =>  $model->getAreas($model->vendor_id),
                'format'    =>  'raw',
            ],
            [
                'label'     =>  'Vendor Gallery',
                'value'     =>  $model->getGalleries($model->vendor_id),
                'format'    =>  'raw',
            ],
            'sort_order',
        ],
    ]) ?>

</div>
<?php $this->registerCss("#vendor_logo{width: 30%;} .vendor_gallery{height: 120px !important;}#map {width: 100%;height: 400px;}"); ?>

<script src="http://maps.googleapis.com/maps/api/js"></script>

<script>
    var oldLatLng   =   "<?php echo $model->vendor_location; ?>";
    var latLngs     =   oldLatLng.split(",");
    var latitude    =   latLngs[0];
    var longitude   =   latLngs[1];
    var map;
    var myCenter    =   new google.maps.LatLng(latitude, longitude);

    function initialize()
    {
        var mapProp     = {
            center  :   myCenter,
            zoom    :   15,
        };

        map             = new google.maps.Map(document.getElementById("map"),mapProp);
        var address     = '';
        var geocoder    = new google.maps.Geocoder();
        geocoder.geocode({ 'latLng': myCenter }, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) 
            {
                if (results[1]) 
                {
                    address     = results[1].formatted_address;
                    var marker  = new google.maps.Marker({
                        position    : myCenter,
                        title       : address,
                    });

                    marker.setMap(map);
                }
            }
        });
    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>