<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = Yii::t('app', 'Categories');
$this->params['breadcrumbs'][] = $this->title;
?>

<?= Html::a('Create Category', '#', ['class' => 'create_category btn btn-success']) ?>
<br><br>

<?= Html::dropDownList('categoryList', '', ArrayHelper::map($categoryList, 'category_id', 'category_name_en'), ['class' => 'categoryList', 'prompt' => 'Select category']) ?>
<?= $categories ?>
<?php
    $this->registerCss(".categoryList{ display:none; }.category_list ul{padding-left: 0%;}.category_list li {list-style: none; padding: 1%; cursor: pointer;}
    .category_list li > ul {display: none;}.category_list li ul{padding-left: 0px;}.category_list li ul li{padding: 1% 0px}");
    $this->registerJsFile($this->theme->baseUrl . "/js/jquery.aCollapTable.js", [
      'depends' => \yii\web\JqueryAsset::className()]);
    $this->registerJs("$('.table-striped').aCollapTable({ 
      startCollapsed: true,
      addColumn: false, 
      plusButton: '<span class=\"i\">&blacktriangleright;</span>', 
      minusButton: '<span class=\"i\">&blacktriangledown;</span>' 
    });
    $(document).on('click', '.category_list li', function(e){
        $(this).children('ul').slideToggle();
        e.stopPropagation();
    });
    $(document).on('click', '.actions', function(e){
        e.stopPropagation();
    })
    $(document).on('click', '.add_category', function(e){
      e.stopImmediatePropagation();
      $('#w0')[0].reset();
      $('#category-parent_category_id').html(\"<option value='\" + $(this).attr('data-attribute-id') + \"'>\" + $(this).attr('data-attribute-name') + \"</option>\");
      $('#myModal').modal();
    })
    $(document).on('click', '.create_category', function(){
      $('#w0')[0].reset();
      $('#myModal').modal();
      $('#category-parent_category_id').html($('.categoryList').html());
      return false;
    })
    $(document).on('click', '.view', function(e){
      e.stopPropagation();
      $.ajax({
        url         : '" . Url::to(['view_category']) . "',
        type        : 'post',
        data        : {'id' : $(this).attr('id')},
        dataType    : 'json',
        beforeShow  : function(){
          $('#fade').remove();
          $('body').append('<div id=\"fade\"></div>');
          $('.processing_image').show();
        },
        complete    : function(){
          $('#fade').remove();
          $('.processing_image').hide();
        },
        success     : function(data){
          $('#view_category .modal-body').html(data.category_details);
          $('#view_category').modal();
        }
      })
    })

    $(document).on('click', '.update', function(e){
      e.stopPropagation();
      $.ajax({
        url         : '" . Url::to(['get_category']) . "',
        type        : 'post',
        data        : {'id' : $(this).attr('id')},
        dataType    : 'json',
        beforeShow  : function(){
          $('#fade').remove();
          $('body').append('<div id=\"fade\"></div>');
          $('.processing_image').show();
        },
        complete    : function(){
          $('#fade').remove();
          $('.processing_image').hide();
        },
        success     : function(data){
          $('#w1 #category-category_name_en').val(data.category.category_name_en);
          $('#w1 #category-category_name_ar').val(data.category.category_name_ar);
          $('#w1 #category-category_id').val(data.category.category_id);
          $('#w1 #category-parent_category_id').html($('.categoryList').html());
          $('#w1 #category-parent_category_id').val(data.category.parent_category_id);
          $('#w1 #category-category_vendors_filterable_by_area').val(data.category.category_vendors_filterable_by_area);
          //$('#update_category .modal-body').html(data.category_details);
          $('#update_category').modal();
        }
      })
    })
    ");
?>

<div class="modal fade" id="myModal">
  <div class="modal-dialog">
    <div class="modal-content">
      <?php $form = ActiveForm::begin(['action' => Url::to(['create'])]); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Create Category</h4>
      </div>
      <div class="modal-body">
       <?= $form->field($model, 'category_name_en')->textInput(['maxlength' => true])->label('Category Name (English)') ?>

    <?= $form->field($model, 'category_name_ar')->textInput(['maxlength' => true])->label('Category Name (Arabic)') ?>

    <?=  $form->field($model, 'parent_category_id')->dropDownList([])->label('Parent Category');
    ?>

    <?php
        if($model->isNewRecord)
            $model->category_vendors_filterable_by_area = 0;
    ?>
    
    <?= $form->field($model, 'category_vendors_filterable_by_area')->radioList([1 => 'Yes', 0 => 'No']) ?>
      </div>
      <div class="modal-footer">
        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
    </div>
      </div>
      <?php ActiveForm::end(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="update_category">
  <div class="modal-dialog">
    <div class="modal-content">
      <?php $form = ActiveForm::begin(['action' => Url::to(['update'])]); ?>
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">Update Category</h4>
      </div>
      <div class="modal-body">
       <?= $form->field($model, 'category_name_en')->textInput(['maxlength' => true])->label('Category Name (English)') ?>

    <?= $form->field($model, 'category_name_ar')->textInput(['maxlength' => true])->label('Category Name (Arabic)') ?>

    <?=  $form->field($model, 'parent_category_id')->dropDownList([])->label('Parent Category');
    ?>

    <?php
        if($model->isNewRecord)
            $model->category_vendors_filterable_by_area = 0;
    ?>
    <?= $form->field($model, 'category_id')->hiddenInput(); ?>
    <?= $form->field($model, 'category_vendors_filterable_by_area')->radioList([1 => 'Yes', 0 => 'No']) ?>
      </div>
      <div class="modal-footer">
        <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Update') : Yii::t('app', 'Update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
        <?= Html::a('Back', ['index'], ['class' => 'btn btn-default']) ?>
    </div>
      </div>
      <?php ActiveForm::end(); ?>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
<div class="modal fade" id="view_category">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h4 class="modal-title">View Category</h4>
      </div>
      <div class="modal-body">
          
      </div>
    </div><!-- /.modal-content -->
  </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

<!-- <div class="panel panel-default">
    <div class="panel-heading">
        <h4 class="panel-title">
            <a data-toggle="collapse" data-parent="#accordion" href="#collapseTwo"><span class="glyphicon glyphicon-th">
            </span>Categories</a>
        </h4>
    </div>
    <div id="collapseTwo" class="panel-collapse collapse">
        <div class="panel-body">
            <table class="table">
                <tr>
                    <td>
                        <a href="http://www.jquery2dotnet.com">Orders</a> <span class="label label-success">$ 320</span>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.jquery2dotnet.com">Invoices</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.jquery2dotnet.com">Shipments</a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <a href="http://www.jquery2dotnet.com">Tex</a>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseThree"><span class="glyphicon glyphicon-user">
                            </span>Account</a>
                        </h4>
                    </div>
                    <div id="collapseThree" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <a href="http://www.jquery2dotnet.com">Change Password</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="http://www.jquery2dotnet.com">Notifications</a> <span class="label label-info">5</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <a href="http://www.jquery2dotnet.com">Import/Export</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-trash text-danger"></span><a href="http://www.jquery2dotnet.com" class="text-danger">
                                            Delete Account</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h4 class="panel-title">
                            <a data-toggle="collapse" data-parent="#accordion" href="#collapseFour"><span class="glyphicon glyphicon-file">
                            </span>Reports</a>
                        </h4>
                    </div>
                    <div id="collapseFour" class="panel-collapse collapse">
                        <div class="panel-body">
                            <table class="table">
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-usd"></span><a href="http://www.jquery2dotnet.com">Sales</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-user"></span><a href="http://www.jquery2dotnet.com">Customers</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-tasks"></span><a href="http://www.jquery2dotnet.com">Products</a>
                                    </td>
                                </tr>
                                <tr>
                                    <td>
                                        <span class="glyphicon glyphicon-shopping-cart"></span><a href="http://www.jquery2dotnet.com">Shopping Cart</a>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>

<ul class="cd-accordion-menu">
    <li class="has-children">
        <input type="checkbox" name ="group-1" id="group-1" checked>
        <label for="group-1">Group 1</label>
 
        <ul>
            <li class="has-children">
                <input type="checkbox" name ="sub-group-1" id="sub-group-1">
                <label for="sub-group-1">Sub Group 1</label>
 
                <ul>
                    <li><a href="#0">Image</a></li>
                    <li><a href="#0">Image</a></li>
                    <li><a href="#0">Image</a></li>
                </ul>
            </li>
            <li><a href="#0">Image</a></li>
            <li><a href="#0">Image</a></li>
        </ul>
    </li>
 
    <li><a href="#0">Image</a></li>
    <li><a href="#0">Image</a></li>
</ul> 
<style>
.cd-accordion-menu {
  width: 90%;
  max-width: 600px;
  background: #4d5158;
  margin: 4em auto;
  box-shadow: 0 4px 40px #70ac77;
}
.cd-accordion-menu ul {
  /* by default hide all sub menus */
  display: none;
}
.cd-accordion-menu li {
  -webkit-user-select: none;
  -moz-user-select: none;
  -ms-user-select: none;
  user-select: none;
}
.cd-accordion-menu input[type=checkbox] {
  /* hide native checkbox */
  position: absolute;
  opacity: 0;
}
.cd-accordion-menu label, .cd-accordion-menu a {
  position: relative;
  display: block;
  padding: 18px 18px 18px 64px;
  background: #4d5158;
  box-shadow: inset 0 -1px #565a60;
  color: #ffffff;
  font-size: 1.6rem;
}
.no-touch .cd-accordion-menu label:hover, .no-touch .cd-accordion-menu a:hover {
  background: #52565d;
}
.cd-accordion-menu label::before, .cd-accordion-menu label::after, .cd-accordion-menu a::after {
  /* icons */
  content: '';
  display: inline-block;
  width: 16px;
  height: 16px;
  position: absolute;
  top: 50%;
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}
.cd-accordion-menu label {
  cursor: pointer;
}
.cd-accordion-menu label::before, .cd-accordion-menu label::after {
  background-image: url(../img/cd-icons.svg);
  background-repeat: no-repeat;
}
.cd-accordion-menu label::before {
  /* arrow icon */
  left: 18px;
  background-position: 0 0;
  -webkit-transform: translateY(-50%) rotate(-90deg);
  -moz-transform: translateY(-50%) rotate(-90deg);
  -ms-transform: translateY(-50%) rotate(-90deg);
  -o-transform: translateY(-50%) rotate(-90deg);
  transform: translateY(-50%) rotate(-90deg);
}
.cd-accordion-menu label::after {
  /* folder icons */
  left: 41px;
  background-position: -16px 0;
}
.cd-accordion-menu a::after {
  /* image icon */
  left: 36px;
  background: url(../img/cd-icons.svg) no-repeat -48px 0;
}
.cd-accordion-menu input[type=checkbox]:checked + label::before {
  /* rotate arrow */
  -webkit-transform: translateY(-50%);
  -moz-transform: translateY(-50%);
  -ms-transform: translateY(-50%);
  -o-transform: translateY(-50%);
  transform: translateY(-50%);
}
.cd-accordion-menu input[type=checkbox]:checked + label::after {
  /* show open folder icon if item is checked */
  background-position: -32px 0;
}
.cd-accordion-menu input[type=checkbox]:checked + label + ul,
.cd-accordion-menu input[type=checkbox]:checked + label:nth-of-type(n) + ul {
  /* use label:nth-of-type(n) to fix a bug on safari (<= 8.0.8) with multiple adjacent-sibling selectors*/
  /* show children when item is checked */
  display: block;
}
.cd-accordion-menu ul label,
.cd-accordion-menu ul a {
  background: #35383d;
  box-shadow: inset 0 -1px #41444a;
  padding-left: 82px;
}
.no-touch .cd-accordion-menu ul label:hover, .no-touch
.cd-accordion-menu ul a:hover {
  background: #3c3f45;
}
.cd-accordion-menu > li:last-of-type > label,
.cd-accordion-menu > li:last-of-type > a,
.cd-accordion-menu > li > ul > li:last-of-type label,
.cd-accordion-menu > li > ul > li:last-of-type a {
  box-shadow: none;
}
.cd-accordion-menu ul label::before {
  left: 36px;
}
.cd-accordion-menu ul label::after,
.cd-accordion-menu ul a::after {
  left: 59px;
}
.cd-accordion-menu ul ul label,
.cd-accordion-menu ul ul a {
  padding-left: 100px;
}
.cd-accordion-menu ul ul label::before {
  left: 54px;
}
.cd-accordion-menu ul ul label::after,
.cd-accordion-menu ul ul a::after {
  left: 77px;
}
.cd-accordion-menu ul ul ul label,
.cd-accordion-menu ul ul ul a {
  padding-left: 118px;
}
.cd-accordion-menu ul ul ul label::before {
  left: 72px;
}
.cd-accordion-menu ul ul ul label::after,
.cd-accordion-menu ul ul ul a::after {
  left: 95px;
}
@media only screen and (min-width: 600px) {
  .cd-accordion-menu label, .cd-accordion-menu a {
    padding: 24px 24px 24px 82px;
    font-size: 1.9rem;
  }
  .cd-accordion-menu label::before {
    left: 24px;
  }
  .cd-accordion-menu label::after {
    left: 53px;
  }
  .cd-accordion-menu ul label,
  .cd-accordion-menu ul a {
    padding-left: 106px;
  }
  .cd-accordion-menu ul label::before {
    left: 48px;
  }
  .cd-accordion-menu ul label::after,
  .cd-accordion-menu ul a::after {
    left: 77px;
  }
  .cd-accordion-menu ul ul label,
  .cd-accordion-menu ul ul a {
    padding-left: 130px;
  }
  .cd-accordion-menu ul ul label::before {
    left: 72px;
  }
  .cd-accordion-menu ul ul label::after,
  .cd-accordion-menu ul ul a::after {
    left: 101px;
  }
  .cd-accordion-menu ul ul ul label,
  .cd-accordion-menu ul ul ul a {
    padding-left: 154px;
  }
  .cd-accordion-menu ul ul ul label::before {
    left: 96px;
  }
  .cd-accordion-menu ul ul ul label::after,
  .cd-accordion-menu ul ul ul a::after {
    left: 125px;
  }
}
.cd-accordion-menu.animated label::before {
  /* this class is used if you're using jquery to animate the accordion */
  -webkit-transition: -webkit-transform 0.3s;
  -moz-transition: -moz-transform 0.3s;
  transition: transform 0.3s;
}</style> -->