<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\Chess;

/**
 * ChessSearch represents the model behind the search form about `app\models\Chess`.
 */
class ChessSearch extends Chess
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'judge_id', 'category_id'], 'integer'],
            [['nomer'], 'safe'],
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
        $query = Chess::find();

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
            'judge_id' => $this->judge_id,
            'category_id' => $this->category_id,
        ]);

        $query->andFilterWhere(['like', 'nomer', $this->nomer]);

        return $dataProvider;
    }
}
