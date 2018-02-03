<?php

namespace app\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * CoupleSearch represents the model behind the search form about `app\models\Couple`.
 */
class InSearch extends In
{
//    public $nomer;
    public $dancerId1;
    public $dancerId2;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [

            // [['couple_nomer', 'couple.age', 'dancer_id_1', 'dancer_id_2', 'nomer'], 'integer'],
            // [['couple.dancerId1.dancerFullName', 'couple.dancerId1.classes', 'couple.dancerId2.dancerFullName', 'couple.dancerId2.classes', 'couple.dancerId1.club0.city.name', 'couple.club', 'couple.trenersString'], 'safe'],
            [['nomer', 'dancerId1', 'dancerId2'], 'safe'],
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
        $query = In::find()
            ->joinWith(['couple', 'tur', 'tur.category', 'tur.category.otd'])
            
            ->joinWith(['couple.dancerId1'=> function($q){
                                $q->from('dancer dancer1');
                            }])
            ->joinWith(['couple.dancerId2'=> function($q){
                                $q->from('dancer dancer2');
                            }]);
            

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
        $query
            ->andFilterWhere(['like', 'in.nomer', $this->nomer])
            ->andFilterWhere(['like', 'dancer1.sname', $this->dancerId1])
            ->andFilterWhere(['like', 'dancer2.sname', $this->dancerId2]);    
        
        $query->andFilterWhere(['category.otd_id' => $this->otd_id]);
        $query->andFilterWhere(['category.id' => $this->category_id]);
        
        $query->orderBy('tur.id');
        
        return $dataProvider;
    }
}
