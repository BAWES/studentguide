<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\VendorView;

/**
 * VendorSearch represents the model behind the search form about `backend\models\Vendor`.
 */
class VendorViewSearch extends VendorView
{
    /**
     * @inheritdoc
     */
    public $vendor_name_en, $vendor_name_ar;
    public function rules()
    {
        return [
            [['vendor_id', 'number_of_views'], 'integer'],
            [['view_date', 'vendor_name_ar', 'vendor_name_en'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = VendorView::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query'         =>  $query,
            'sort'      =>  ['defaultOrder' => ['view_date' => SORT_DESC, 'number_of_views' => SORT_DESC]],
        ]);

        $this->load($params);
        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        
        //die;
        // grid filtering conditions
        $query->andFilterWhere([
            'vendor_id'         => $this->vendor_id,            
        ]);
        if($this->view_date)
        {
            $dates = explode(" - ", $this->view_date);
            if(isset($dates[0]) && !empty($dates[0]))
                $query->andFilterWhere(['>=', 'view_date', $dates[0]]);
            if(isset($dates[1]) && !empty($dates[1]))
                $query->andFilterWhere(['<=', 'view_date', $dates[1]]);
        }
        
        if($this->vendor_name_en || $this->vendor_name_ar)
        {
            $query->join('JOIN', '{{%vendor}}', '{{%vendor}}.vendor_id = {{%vendor_view}}.vendor_id');
            if($this->vendor_name_en)
                $query->andFilterWhere(['like', 'vendor_name_en', $this->vendor_name_en]);
            if($this->vendor_name_ar)
                $query->andFilterWhere(['like', 'vendor_name_ar', $this->vendor_name_ar]);
        }
        /*if($this->from_date)
        {
            $from_date = \DateTime::createFromFormat('d-m-Y', $this->from_date);
            $from_date = $from_date->format('Y-m-d');
            $query->andFilterWhere(['>=1', 'view_date', $this->number_of_views]);
        }
        if($this->to_date)
        {
            $to_date = \DateTime::createFromFormat('d-m-Y', $this->to_date);
            $to_date = $to_date->format('Y-m-d');
            $query->andFilterWhere(['<=', 'view_date', $this->number_of_views]);
        }*/

        $query->andFilterWhere(['>=', 'number_of_views', $this->number_of_views]);
        return $dataProvider;
    }
}