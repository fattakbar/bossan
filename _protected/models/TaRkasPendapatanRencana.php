<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "ta_rkas_pendapatan_rencana".
 *
 * @property string $tahun
 * @property integer $sekolah_id
 * @property integer $Kd_Rek_1
 * @property integer $Kd_Rek_2
 * @property integer $Kd_Rek_3
 * @property integer $Kd_Rek_4
 * @property integer $Kd_Rek_5
 * @property integer $kd_penerimaan_1
 * @property integer $kd_penerimaan_2
 * @property string $juli
 * @property string $agustus
 * @property string $september
 * @property string $oktober
 * @property string $november
 * @property string $desember
 * @property string $januari1
 * @property string $februari1
 * @property string $maret1
 * @property string $april1
 * @property string $mei1
 * @property string $juni1
 */
class TaRkasPendapatanRencana extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'ta_rkas_pendapatan_rencana';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['tahun', 'sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'required'],
            [['tahun'], 'safe'],
            [['sekolah_id', 'Kd_Rek_1', 'Kd_Rek_2', 'Kd_Rek_3', 'Kd_Rek_4', 'Kd_Rek_5', 'kd_penerimaan_1', 'kd_penerimaan_2'], 'integer'],
            [['juli', 'agustus', 'september', 'oktober', 'november', 'desember', 'januari1', 'februari1', 'maret1', 'april1', 'mei1', 'juni1'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'tahun' => 'Tahun',
            'sekolah_id' => 'Sekolah ID',
            'Kd_Rek_1' => 'Kd  Rek 1',
            'Kd_Rek_2' => 'Kd  Rek 2',
            'Kd_Rek_3' => 'Kd  Rek 3',
            'Kd_Rek_4' => 'Kd  Rek 4',
            'Kd_Rek_5' => 'Kd  Rek 5',
            'kd_penerimaan_1' => 'Kd Penerimaan 1',
            'kd_penerimaan_2' => 'Kd Penerimaan 2',
            'juli' => 'Juli',
            'agustus' => 'Agustus',
            'september' => 'September',
            'oktober' => 'Oktober',
            'november' => 'November',
            'desember' => 'Desember',
            'januari1' => 'Januari',
            'februari1' => 'Februari',
            'maret1' => 'Maret',
            'april1' => 'April',
            'mei1' => 'Mei',
            'juni1' => 'Juni',
        ];
    }
}
