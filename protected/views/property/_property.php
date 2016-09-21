
<div class="project-detailBox">
    <div class="project-picBox">
        <figure>
            <a href="<?php echo Yii::app()->createAbsoluteUrl('property/detail/', array('slug'=>$data->slug)) ?>">
                <img src="<?php echo ImageHelper::getImageUrl($data, 'featured_image', 'thumb1'); ?>" alt="">
            </a>
        </figure>
    </div>
    <div class="clear"></div>
    <div class="project-heading"><a href="<?php echo Yii::app()->createAbsoluteUrl('property/detail/', array('slug'=>$data->slug)) ?>"><?php echo $data->title;?></a></div>
    <div class="clear"></div>
    <table class="project-details">
        <tr>
            <th scope="row">Country</th>
            <td class="colon">:</td>
            <td><?php echo 'Singapore' ?></td>
        </tr>
        <tr>
            <th scope="row">Type</th>
            <td class="colon">:</td>
            <td><?php echo $data->propertytype->property_type ?></td>
        </tr>
        <tr>
            <th scope="row">Address</th>
            <td class="colon">:</td>
            <td><?php echo $data->address ?></td>
        </tr>
        <tr>
            <th scope="row">District</th>
            <td class="colon">:</td>
            <td><?php echo $data->district->district_name; ?></td>
        </tr>
        <tr>
            <th scope="row">Est. TOP</th>
            <td class="colon">:</td>
            <td><?php echo $data->est_top ?></td>
        </tr>
    </table>
</div> 