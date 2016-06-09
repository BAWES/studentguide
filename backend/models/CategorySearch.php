<?php

namespace backend\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use backend\models\Category;

/**
 * CategorySearch represents the model behind the search form about `backend\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id', 'parent_category_id', 'category_vendors_filterable_by_area'], 'integer'],
            [['category_name_en', 'category_name_ar', 'category_created_datetime', 'category_updated_datetime'], 'safe'],
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
    public function search($params, $id)
    {
        $query = Category::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => ($id) ? $query->where(['parent_category_id' => $id]) : $query->where(['parent_category_id' => NULL]),
            'sort'  =>  ['defaultOrder' => ['category_created_datetime' => SORT_DESC]],
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'category_id' => $this->category_id,
            'parent_category_id' => $this->parent_category_id,
            'category_vendors_filterable_by_area' => $this->category_vendors_filterable_by_area,
            'category_created_datetime' => $this->category_created_datetime,
            'category_updated_datetime' => $this->category_updated_datetime,
        ]);

        $query->andFilterWhere(['like', 'category_name_en', $this->category_name_en])
            ->andFilterWhere(['like', 'category_name_ar', $this->category_name_ar]);

        return $dataProvider;
    }
}