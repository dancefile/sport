<?php

/* @var $this \yii\web\View */
/* @var $content string */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <?php
    NavBar::begin([
        'brandLabel' => Yii::$app->name,
        'brandUrl' => Yii::$app->homeUrl,
        'options' => [
            'class' => 'navbar-inverse navbar-fixed-top',
        ],
    ]);
    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => [
        
                        ['label' => 'Регистрация', 'items' => [
                                ['label' => 'Список участников', 'url' => ['/in/index']],
                                ['label' => 'Регистрация', 'url' => ['/registration/create']],
                                ['label' => 'Предварительная Регистрация', 'url' => ['/preregistration']],
                                ],
                        ],
                       ['label' => 'Регламент', 'items' => [
                                ['label' => 'Регламент', 'url' => ['/reglament/index']],
                                ['label' => 'Расписание', 'url' => ['/timetable/index']],
                                ],
                        ],
		                ['label' => 'Судьи', 'items' => [
                                ['label' => 'Список', 'url' => ['/judges/list']],
                                ['label' => 'Шахматка', 'url' => ['/judges/shaxmat']],

                                ],
                        ],
                        ['label' => 'Печать', 'items' => [
                                ['label' => 'Заходы', 'url' => ['/print/list']],
                                ['label' => 'Результаты', 'url' => ['/judges/shaxmat']],
								['label' => 'Дипломы', 'url' => ['/print/list']],
                                ],
                        ],
                        ['label' => 'Справочники', 'items' => [
                                ['label' => 'Список танцев', 'url' => ['/dance']],
                                ['label' => 'Список отделений', 'url' => ['/otd']],
                                
                                ],
                        ],


            Yii::$app->user->isGuest ? (
                ['label' => 'Login', 'url' => ['/site/login']]
            ) : (
                '<li>'
                . Html::beginForm(['/site/logout'], 'post')
                . Html::submitButton(
                    'Logout (' . Yii::$app->user->identity->username . ')',
                    ['class' => 'btn btn-link logout']
                )
                . Html::endForm()
                . '</li>'
            )
        ],
    ]);
    NavBar::end();
    ?>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
        <p class="pull-left">&copy; Dancefile <?= date('Y') ?></p>

        <p class="pull-right"><?= Yii::powered() ?></p>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
