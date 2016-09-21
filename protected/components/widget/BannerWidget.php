<?php 
class BannerWidget extends _BaseWidget
{
	public $bannerType = '';
    public function run()
    {
		if ($this->bannerType == 'homepage')
			$this->getHomeBanner();
		else {
			$this->getPageBanner();
		}
    }
    public function getHomeBanner()
    {
        $current_link = $this->getCurrentUrlWithoutParam();
        $group = GroupBanner::getActiveBanner($current_link);
        if(isset($group))
            $data = BannerItem::getAllBanner($group->id);
        else
            $data = null;
        $this->render("banner/banner_slide",array('data'=>$data));
    }
	
	public function getPageBanner()
    {
        $current_link = $this->getCurrentUrlWithoutParam();
        $group = GroupBanner::getActiveBanner($current_link);
        if(isset($group))
            $data = BannerItem::getAllBanner($group->id);
        else
            $data = null;
        $this->render("banner/pagebanner",array('data'=>$data));
    }
}
?>