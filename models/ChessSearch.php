<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\db\Query;
use yii\data\ActiveDataProvider;

/**
 * ChessSearch represents the model behind the search form about `app\models\Chess`.
 */
class ChessSearch extends Chess
{
    public $otd_id;
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
        $category_list = Category::find()->all();
        
        $cat_query = '';
        
        foreach ($category_list as $category) {
            $cat_query = $cat_query 
                    . 'SUM(IF(category_id='. $category->id
                    . ', nomer, 0)) AS "'.$category->id.'", ' 
                    . 'SUM(IF(category_id='. $category->id
                    . ', chief, 0)) AS "c'.$category->id.'", '; 
        }
        $cat_query = rtrim($cat_query, " \t,");
        
        $query = new Query();
        
        $query
                ->select([
                    'judge.id judge_id',
                    'CONCAT(judge.name, " ", judge.sname) full_name',
                    $cat_query
                ])
                ->from('chess')
                ->join('RIGHT JOIN', 'judge', 'judge.id = chess.judge_id')
                ->groupBy('judge_id')
                ->orderBy('judge_id')
                ;
        

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
