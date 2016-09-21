
<?php if (count($this->mBanner) > 0): if (count($this->mBanner) > 1): ?>
        <div class="banner">
            <div class="fluid_container">
                <div class="fluid_dg_wrap fluid_dg_charcoal_skin" id="fluid_dg_wrap_1">

                    <?php
                    foreach ($this->mBanner as $itemBanner) {
                        ?>
                        <div data-src="<?php echo ImageHelper::getImageUrl($itemBanner, "large_image", "pagethumb") ?>">
                            <div class="fluid_dg_caption fadeFromBottom">
                                <div class="captionTopArea">
                                    <h2 class="mainTitle">
                                        <?php echo MyFunctionCustom::stripTagBannerString($itemBanner->banner_title) ?>
                                    </h2>
                                </div>
                            </div>
                        </div>

                    <?php } ?>


                </div><!-- #fluid_dg -->
            </div><!-- .fluid_container -->
        </div>
    <?php else: ?>
        <div class="inner-banner">
            <img src="<?php echo ImageHelper::getImageUrl($this->mBanner[0], "large_image", "pagethumb") ?>" alt="">
        </div>
    <?php endif;
else:
    ?>
    <!-- banner for property detail     -->
    <?php if (count($this->propertyBanner) > 0): if (count($this->propertyBanner) > 1): ?>
            <div class="banner">
                <div class="fluid_container">
                    <div class="fluid_dg_wrap fluid_dg_charcoal_skin" id="fluid_dg_wrap_1">

                        <?php
                        foreach ($this->propertyBanner as $itemBanner) {
                            ?>
                            <div data-src="<?php echo ImageHelper::getImageUrl($itemBanner, "large_image", "pagethumb") ?>">
                                <div class="fluid_dg_caption fadeFromBottom">
                                    <div class="captionTopArea">
                                        <h2 class="mainTitle">
                                        <?php echo MyFunctionCustom::stripTagBannerString($itemBanner->name) ?>
                                        </h2>
                                    </div>
                                </div>
                            </div>

                        <?php } ?>


                    </div><!-- #fluid_dg -->
                </div><!-- .fluid_container -->
            </div>
        <?php else: ?>

            <div class="inner-banner">
                <img src="<?php echo ImageHelper::getImageUrl($this->propertyBanner[0], "large_image", "pagethumb") ?>" alt="">
            </div>
        <?php endif; ?>
    <?php endif;
endif; ?>    