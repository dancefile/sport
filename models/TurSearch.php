<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Tur;

/**
 * TurSearch represents the model behind the search form about `app\models\Tur`.
 */
class TurSearch extends Tur
{
    public $otd_id;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'category_id', 'nomer', 'zahodcount', 'typezahod', 'ParNextTur', 'typeSkating', 'status'], 'integer'],
            [['name', 'dances'], 'safe'],
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
        $query = Tur::find()->innerJoinWith('category');

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
            'category_id' => $this->category_id,
            'nomer' => $this->nomer,
            'zahodcount' => $this->zahodcount,
            'typezahod' => $this->typezahod,
            'ParNextTur' => $this->ParNextTur,
            'typeSkating' => $this->typeSkating,
            'status' => $this->status,
            'category.otd_id' => $this->otd_id,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'dances', $this->dances]);
        
        $query->orderBy('category.otd_id');
        
        return $dataProvider;
    }
}
