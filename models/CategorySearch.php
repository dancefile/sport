<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Category;

/**
 * CategorySearch represents the model behind the search form about `app\models\Category`.
 */
class CategorySearch extends Category
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'solo', 'otd_id', 'program', 'agemin', 'agemax', 'age_id', 'skay'], 'integer'],
            [['name', 'clas', 'dances'], 'safe'],
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
        $query = Category::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'solo' => $this->solo,
            'otd_id' => $this->otd_id,
            'program' => $this->program,
            'agemin' => $this->agemin,
            'agemax' => $this->agemax,
            'age_id' => $this->age_id,
            'skay' => $this->skay,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'clas', $this->clas])
            ->andFilterWhere(['like', 'dances', $this->dances]);

        // $query->andFilterWhere(['otd' => $otd]);
        

        return $dataProvider;
    }
}
