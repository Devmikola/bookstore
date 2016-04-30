<?php
namespace app\assets;
use yii\web\AssetBundle;

class LightBoxAsset extends AssetBundle {
    public $sourcePath = '@bower/lightbox2/src';
    public $css = ['css/lightbox.css'];
    public $js = ['js/lightbox.js'];
}