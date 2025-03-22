<?php
/* @var $this SiteController */
/* @var $model ContactForm */
/* @var $form CActiveForm */

$this->pageTitle=Yii::app()->name . ' - Contact Us';
$this->breadcrumbs=array(
	'Contact',
);

/*$command = Yii::app()->db->createCommand('CALL sp_tes(
			"'.$mMinoutline->Barang_ID.'",
			"'.Yii::app()->user->getState('NamaPegawai').'"
		)');
*/

//$command = Yii::app()->db->createCommand('CALL sp_tes()');
//$result = $command ->execute(); 
		
?>

<?php
//$myObj = new stdClass();
//$myObj->name = "John";
//$myObj->age = 30;
//$myObj->city = "New York";

//$myJSON = json_encode($myObj);
//echo $myJSON;



/*$total = 5;
$id = 0;
for ($i = 0; $i < $total; $i++){
	if($id == 0){
		$mSave 				= new piutang();
		$mSave->ID 	= 1;
		$mSave->Konsumen_ID 	= 1;
		$mSave->JumlahBayar 	= 1;
		$mSave->save();
		
		$id = $mSave->Piutang_ID;
	}
	$mSaveDtl					= new piutangdetail();
	$mSaveDtl->Sisa 		= $i;
	$mSaveDtl->Pembayaran_ID = $id;
	$mSaveDtl->save();
}					
	*/				
?>

<h1>Contact Us</h1>
<?php //echo $myJSON2; ?>
<?php if(Yii::app()->user->hasFlash('contact')): ?>

<div class="flash-success">
	<?php echo Yii::app()->user->getFlash('contact'); ?>
</div>

<?php else: ?>

<p>
If you have business inquiries or other questions, please fill out the following form to contact us. Thank you.
</p>


<?php endif; ?>