<?php

/* @var $this yii\web\View */

$this->title = 'Dashboard';
?>
<div class="site-index">

    <div class="body-content">
        <div class="row">
            <div class="col-md-4 col-vlg-3 col-sm-6">
                <div class="tiles green m-b-10">
                    <div class="tiles-body">
                        <div class="controller"> <a href="javascript:;"></a>  </div>
                        <div class="tiles-title text-black">OVERALL CATEGORIES</div>
                        <div class="widget-stats">
                            <div class="wrapper transparent">
                                <span class="item-title">Count</span> <span class="item-count animate-number semi-bold" data-value="<?= $categoryCount ?>" data-animation-duration="700"><?= $categoryCount ?></span>
                            </div>
                        </div>
                        <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
                            <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="64.8%" style="width: 64.8%;"></div>
                        </div>
                    </div>
                </div>  
            </div>
            <div class="col-md-4 col-vlg-3 col-sm-6">
                <div class="tiles green m-b-10">
                    <div class="tiles-body">
                        <div class="controller"> <a href="javascript:;"></a>  </div>
                        <div class="tiles-title text-black">OVERALL VENDORS</div>
                        <div class="widget-stats">
                            <div class="wrapper transparent">
                                <span class="item-title">Count</span> <span class="item-count animate-number semi-bold" data-value="<?= $vendorCount ?>" data-animation-duration="700"><?= $vendorCount ?></span>
                            </div>
                        </div>
                        <div class="progress transparent progress-small no-radius m-t-20" style="width:90%">
                            <div class="progress-bar progress-bar-white animate-progress-bar" data-percentage="64.8%" style="width: 64.8%;"></div>
                        </div>
                    </div>
                </div>  
            </div>
        </div>

        <div class="col-md-12 col-vlg-12m-b-10 ">
            <div class="tiles white">
                <div class="row">
                    <h4>Vendors Statistics</h4>
                    
                </div>
            </div>
        </div>

    </div>
</div>
