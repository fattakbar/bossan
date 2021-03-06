<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use kartik\widgets\DepDrop;

/* @var $this yii\web\View */
/* @var $model app\models\TaRkasKegiatan */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ta-rkas-kegiatan-form">
    <?= Html::a('Kamus Kegiatan', ['kamuskegiatan'], [
                                                'class' => 'btn btn-xs btn-info',
                                                'onClick' => "return !window.open(this.href, 'SPH', 'width=1024,height=600,scrollbars=1')"
                                                ]) ?>

    <?php $form = ActiveForm::begin(['id' => $model->formName()
    // , 'layout' => 'horizontal'
    ]); ?>

    <?php 
            echo $form->field($model, 'kd_program')->widget(Select2::classname(), [
                'data' => ArrayHelper::map(\app\models\RefProgramSekolah::find()->select(['kd_program', 'CONCAT(kd_program,\' \',uraian_program) AS uraian_program'])->all(),'kd_program','uraian_program'),
                'options' => ['placeholder' => 'Pilih Program ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>
    <?php  echo $form->field($model, 'kd_sub_program')->widget(DepDrop::classname(), [
            'options'=>['id'=>'tarkaskegiatan-kd_sub_program'],
            'pluginOptions'=>[
                'depends'=>['tarkaskegiatan-kd_program'],
                'placeholder'=>'Pilih Sub Program ...',
                'url'=>Url::to(['subprogram'])
            ]
        ]); ?>
    <?php echo $form->field($model, 'kd_kegiatan')->widget(DepDrop::classname(), [
            'pluginOptions'=>[
                'depends'=>['tarkaskegiatan-kd_program', 'tarkaskegiatan-kd_sub_program'],
                'placeholder'=>'Pilih Kegiatan ...',
                'url'=>Url::to(['kegiatan'])
            ]
        ]);
    ?>

    <?php 
            $connection = \Yii::$app->db;
            $skpd = $connection->createCommand('SELECT CONCAT(kd_penerimaan_1,".",kd_penerimaan_2) AS kd_penerimaan_2, CONCAT(kd_penerimaan_1,".",kd_penerimaan_2," ",uraian) AS uraian FROM ref_penerimaan_sekolah_2 WHERE sekolah = 1');
            $data = $skpd->queryAll();
            // $data = \app\models\RefPenerimaanSekolah2::find()
            //         ->select(['CONCAT(kd_penerimaan_1,".",kd_penerimaan_2) AS kd_penerimaan_2', 'CONCAT(kd_penerimaan_1,".",kd_penerimaan_2," ",uraian) AS uraian'])
            //         ->where(['sekolah' => 1])
            //         ->all();     
            echo $form->field($model, 'penerimaan_2')->widget(Select2::classname(), [
                'data' => ArrayHelper::map($data, 'kd_penerimaan_2','uraian'),
                'options' => ['placeholder' => 'Sumber Dana ...'],
                'pluginOptions' => [
                    'allowClear' => true
                ],
            ]);
    ?>     

    <?= $form->field($model, 'pagu_anggaran')->textInput(['maxlength' => true]) ?>   

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? 'Simpan' : 'Simpan', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<?php IF($model->isNewRecord){

$script = <<<JS
$('form#{$model->formName()}').on('beforeSubmit',function(e)
{
    var \$form = $(this);
    $.post(
        \$form.attr("action"), //serialize Yii2 form 
        \$form.serialize()
    )
        .done(function(result){
            if(result == 1)
            {
                $("#myModal").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#kegiatan-pjax'});
            }else
            {
                $("#message").html(result);
            }
        }).fail(function(){
            console.log("server error");
        });
    return false;
});

JS;
$this->registerJs($script);
}ELSE{

$script = <<<JS
$('form#{$model->formName()}').on('beforeSubmit',function(e)
{
    var \$form = $(this);
    $.post(
        \$form.attr("action"), //serialize Yii2 form 
        \$form.serialize()
    )
        .done(function(result){
            if(result == 1)
            {
                $("#myModalubah").modal('hide'); //hide modal after submit
                //$(\$form).trigger("reset"); //reset form to reuse it to input
                $.pjax.reload({container:'#kegiatan-pjax'});
            }else
            {
                $("#message").html(result);
            }
        }).fail(function(){
            console.log("server error");
        });
    return false;
});

JS;
$this->registerJs($script);
}
?>