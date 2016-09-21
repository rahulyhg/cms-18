<?php
$this->breadcrumbs = array(
	$this->pluralTitle => array('index'),
	'Update ' . $this->singleTitle,
);

$this->menu = array(	
	array('label' => $this->pluralTitle, 'url' => array('index'), 'icon' => $this->iconList),
	array('label' => 'View ' . $this->singleTitle, 'url' => array('view', 'id' => $model->id)),	
	array('label' => 'Create ' . $this->singleTitle, 'url' => array('create')),
);
?>

<h1>Update <?php echo $this->singleTitle . ': ' . $title_name; ?></h1>

<?php
//for notify message
$this->renderNotifyMessage(); 
//for list action button
echo $this->renderControlNav();
?><?php echo $this->renderPartial('_form', array('model'=>$model)); ?>


<style>
    .row input[type="text"], .row input[type=password]{
        min-width: 100%;
    }
</style>

<script>
    $(window).ready(function(){
        $('#Patient_dob').change(function(){
            var dob = $(this).val();
            var age = getAge(dob);
            $('.bio-age').html(age);
            $('#Patient_age').val(age);
        });
    });

    function getAge(birth) {
        var pieces = birth.split('/');
        var birth_date = pieces[0];
        var birth_month = pieces[1];
        var birth_year = pieces[2];
        var today = new Date();
        var today_year = today.getFullYear();
        var today_month = today.getMonth();
        var today_day = today.getDate();

        var age = today_year - birth_year;
        if ( today_month < (birth_month - 1))
        {
            age--;
        }
        if (((birth_month - 1) == today_month) && (today_day < birth_date))
        {
            age--;
        }
        if (age <= 0) {
            age = 0;
        }
        return age;
    }
</script>