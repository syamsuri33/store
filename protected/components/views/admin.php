<ul id="portlet-content">
	<li> <?php echo CHtml::link('Data Sekolah', array('//sekolah/admin')); ?> </li>
	<li> <?php echo CHtml::link('Data Guru', array('//guru/admin')); ?> </li>
	<li> <?php echo CHtml::link('Pengumuman', array('//pengumuman/admin')); ?> </li>
	<li> <?php echo CHtml::link('Kunjungan', array('//kunjungan/admin')); ?> </li>
	<li> <?php echo CHtml::link('Kegiatan', array('//kegiatan/admin')); ?> </li>

	<?php /*if(isset(Yii::app()->controller->menu)) {
		foreach(Yii::app()->controller->menu as $value) {
		printf('<li>%s</li>', CHtml::link($value['label'], $value['url']));
		}
	}
	*/?>
</ul>

<script>
$(function() {
    var loc = window.location.href;
    $('#portlet-content li').each(function() {
        var link = $(this).find('a:first').attr('href');
        if(loc.indexOf(link) >= 0)
            $(this).addClass('active');
    });
});
</script>
