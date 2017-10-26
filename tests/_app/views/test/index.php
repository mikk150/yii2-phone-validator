<?php

use yii\widgets\ActiveForm;
?>

<?php $form = ActiveForm::begin(); ?>
<?= $form->field($model, 'phone') ?>
<?php ActiveForm::end();