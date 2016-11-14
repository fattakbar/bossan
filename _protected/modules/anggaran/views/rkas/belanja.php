<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use yii\bootstrap\Modal;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $searchModel app\modules\anggaran\models\TaRkasKegiatan */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Belanja';
$this->params['breadcrumbs'][] = ['label' => 'RKAS', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Belanja Langsung', 'url' => ['rkaskegiatan']];
$this->params['breadcrumbs'][] = $kegiatan->refKegiatan->uraian_kegiatan;
?>
<div class="ta-rkas-kegiatan-index">
<div class="row">
<div class="col-md-9">
    <div class="box box-primary">
        <div class="box-header with-border">
            <h3 class="box-title"><?= $kegiatan->kd_program.'.'.$kegiatan->kd_sub_program.'.'.$kegiatan->kd_kegiatan.' '.$kegiatan->refKegiatan->uraian_kegiatan ?></h3>
        </div><!-- /.box-header -->
        <div class="box-body">

        <?= DetailView::widget([
            'model' => $kegiatan,
            'attributes' => [
                [
                    'label' => 'Sumber Dana',
                    'value' => $kegiatan->penerimaan2->uraian,
                ],
                'pagu_anggaran:decimal',
            ],
        ]) ?>
        </div><!-- /.box-body -->
    </div>        

    <p>
        <?= Html::a('Tambah Belanja', [
            'createbelanja',
                'tahun' => $kegiatan->tahun,
                'sekolah_id' => $kegiatan->sekolah_id,
                'kd_program' => $kegiatan->kd_program,
                'kd_sub_program' => $kegiatan->kd_sub_program,
                'kd_kegiatan' => $kegiatan->kd_kegiatan,
            ], [
                'class' => 'btn btn-xs btn-success',
                'data-toggle'=>"modal",
                'data-target'=>"#myModal",
                'data-title'=>"Tambah Belanja",
            ]) ?>
    </p>
    <?= GridView::widget([
        'id' => 'ta-rkas-kegiatan',    
        'dataProvider' => $dataProvider,
        'export' => false, 
        'responsive'=>true,
        'hover'=>true,     
        'resizableColumns'=>true,
        'panel'=>['type'=>'primary', 'heading'=>$this->title],
        'responsiveWrap' => false,        
        'toolbar' => [
            [
                // 'content' => $this->render('_search', ['model' => $searchModel, 'Tahun' => $Tahun]),
            ],
        ],       
        'pager' => [
            'firstPageLabel' => 'Awal',
            'lastPageLabel'  => 'Akhir'
        ],
        'pjax'=>true,
        'pjaxSettings'=>[
            'options' => ['id' => 'belanjarinci-pjax', 'timeout' => 5000],
        ],        
        // 'filterModel' => $searchModel,
        'columns' => [
            [
                'class' => 'kartik\grid\ExpandRowColumn',
                'value' => function ($model, $key, $index, $column) {

                    return GridView::ROW_COLLAPSED;
                },

                'allowBatchToggle'=>true,
               'detail'=>function ($model, $key, $index, $column) {

                    $searchModel = new \app\modules\anggaran\models\TaRkasBelanjaRincSearch();
                    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
                    $dataProvider->query->where([
                            'tahun' => $model->tahun,
                            'sekolah_id' => $model->sekolah_id,
                            'kd_program' => $model->kd_program,
                            'kd_sub_program' => $model->kd_sub_program,
                            'kd_kegiatan' => $model->kd_kegiatan,
                            'Kd_Rek_1' => $model->Kd_Rek_1,
                            'Kd_Rek_2' => $model->Kd_Rek_2,
                            'Kd_Rek_3' => $model->Kd_Rek_3,
                            'Kd_Rek_4' => $model->Kd_Rek_4,
                            'Kd_Rek_5' => $model->Kd_Rek_5,
                        ]);
                    return Yii::$app->controller->renderPartial('belanjarinci', [
                        'dataProvider' => $dataProvider,
                        'model'=>$model,
                        ]);
                },
                'detailOptions'=>[
                    'class'=> 'kv-state-enable',
                ],

            ],
            [
                'label' => 'Jenis',
                'group' => true,
                'value' => function($model){
                    return $model->refRek3->Nm_Rek_3;
                }
            ],
            [
                'label' => 'Belanja',
                'value' => function($model){
                    return $model->Kd_Rek_1.'.'.$model->Kd_Rek_2.'.'.$model->Kd_Rek_3.'.'.substr('0'.$model->Kd_Rek_4, -2).'.'.substr('0'.$model->Kd_Rek_5, -2).' '.$model->refRek5->Nm_Rek_5;
                }
            ],
            [
                'label' => 'Sumber Dana',
                'value' => function($model){
                    return $model->penerimaan2->uraian;
                }
            ],
            [
                'label' => 'Komponen',
                'value' => function($model){
                    return $model->komponen->komponen;
                }
            ],
            [
                'class' => 'kartik\grid\ActionColumn',
                'template' => '{updatebelanja} {deletebelanja} {rkasbelanjarinc}',
                'noWrap' => true,
                'vAlign'=>'top',
                'buttons' => [
                        'updatebelanja' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'ubah'),
                                 'data-toggle'=>"modal",
                                 'data-target'=>"#myModalubah",
                                 'data-title'=> "Ubah Belanja",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
                        'deletebelanja' => function ($url, $model) {
                          return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url,
                              [  
                                 'title' => Yii::t('yii', 'hapus'),
                                 // 'data-toggle'=>"modal",
                                 // 'data-target'=>"#myModalubah",
                                 // 'data-title'=> "Ubah Unit",                                 
                                 'data-confirm' => "Yakin menghapus belanja ini?",
                                 'data-method' => 'POST',
                                 'data-pjax' => 1
                              ]);
                        },                        
                        'rkasbelanjarinc' => function ($url, $model) {
                          return Html::a('Rincian Belanja <i class="glyphicon glyphicon-menu-right"></i>', $url,
                              [  
                                 'title' => Yii::t('yii', 'Input Rincian Belanja'),
                                 'class'=>"btn btn-xs btn-default",                                 
                                 // 'data-confirm' => "Yakin menghapus sasaran ini?",
                                 // 'data-method' => 'POST',
                                 // 'data-pjax' => 1
                              ]);
                        },
                ]
            ],
        ],
    ]); ?>
</div><!--col-->
<div class="col-md-3">
    <div class="box box-info">
        <div class="box-header with-border">
            <h3 class="box-title">Program</h3>
        </div><!-- /.box-header -->    
                <ul class="tree arrow">
                    <?php foreach($treeprogram AS $treeprogram): ?>
                    <li class="open root">
                        <i></i><a href="#"><?= $treeprogram->kd_program == $kegiatan->kd_program ? '<div class="label label-default">'.$treeprogram->refProgram->uraian_program.'</div>' : $treeprogram->refProgram->uraian_program ?></a>
                        <?php IF($treeprogram->kd_program == $kegiatan->kd_program) : ?>
                        <ul>
                            <li class="open">
                                <i></i><a href="#"><?= $treesubprogram->uraian_sub_program ?></a>
                                <ul>
                                    <li class="leaf">
                                        <i></i><a href="#"><?= $kegiatan->refKegiatan->uraian_kegiatan ?></a>
                                        <ul></ul>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <?php endif; ?>
                    </li>
                    <?php endforeach; ?>              
                </ul>
    </div>
</div><!--col-->
</div><!--row-->
</div>
<?php Modal::begin([
    'id' => 'myModal',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

Modal::begin([
    'id' => 'myModalubah',
    'header' => '<h4 class="modal-title">Lihat lebih...</h4>',
        'options' => [
            'tabindex' => false // important for Select2 to work properly
        ], 
]);
 
echo '...';
 
Modal::end();

$this->registerJs("
    $('#myModal').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
");
$this->registerJs("
    $('#myModalubah').on('show.bs.modal', function (event) {
        var button = $(event.relatedTarget)
        var modal = $(this)
        var title = button.data('title') 
        var href = button.attr('href') 
        modal.find('.modal-title').html(title)
        modal.find('.modal-body').html('<i class=\"fa fa-spinner fa-spin\"></i>')
        $.post(href)
            .done(function( data ) {
                modal.find('.modal-body').html(data)
            });
        })
       
");
?>