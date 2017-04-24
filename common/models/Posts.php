<?php

namespace common\models;
use yii\helpers\Url;
use Yii;

/**
 * This is the model class for table "posts".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $title
 * @property string $description
 * @property string $status
 * @property integer $views
 * @property string $create_at
 * @property string $update_at
 * @property string $slug
 * @property string $type
 */
class Posts extends BaseDB
{
    const TYPE_POST = 'post';
    const TYPE_PAGE = 'page';
    const STATUS_TRASH = 1;
    const STATUS_DRAFT = 2;
    const STATUS_ACTIVE = 5;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'posts';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'title', 'description', 'status', 'update_at', 'slug', 'type'], 'required'],
            [['author_id', 'views'], 'integer'],
            [['description'], 'string'],
            [['create_at', 'update_at'], 'safe'],
            [['title', 'slug', 'type'], 'string', 'max' => 255],
            [['status'], 'string', 'max' => 11]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Author ID',
            'title' => 'Title',
            'description' => 'Description',
            'status' => 'Status',
            'views' => 'Views',
            'create_at' => 'Create At',
            'update_at' => 'Update At',
            'slug' => 'Slug',
            'type' => 'Type',
        ];
    }
    //relational model
    function getAuthor() {
        return $this->hasOne(\common\models\User::className(), ['id' => 'author_id']);
    }

    public function getTitle($the ='',$className = '') {

        if ($the != '' && $the != 'none') {
            $link = "<a href='" . $this->getLink() . "' class='$className'><$the>$this->title</$the></a>";
        }  elseif($the == 'none') {
            $link = $this->title;
        }else{
            $link = "<a href='" . $this->getLink() . "' class='$className'>$this->title</a>";
        }
        return $link;
    }
    public function getLink(){
        $link = Url::to(['/home/category/post','slug'=>  $this->getSlug()]);
        return $link;;
    }
    function getHinhAnhLink() {
        $img = "<a href='".$this->getLink()."' class='img-feature'>".$this->getHinhAnh()."</a>";
        return $img;
    }
    function getContent() {
        return $this->description;
    }
    function getHinhAnh() {
        $src = $this->getLinkAnh();
        $img = "<img src='$src' alt='' class='img-responsive'>";
        return $img;
    }
    function getTime() {
        return \common\func\FunctionCommon::time_fomat($this->create_at);
    }

    function getLinkAnh() {
        $src = '';
        if ($this->image) {
            $src = $this->image->getUrl();
        }
        return $src;
    }
    public function getMota() {
        $this->getSeoPost();
        $link = "<p>$this->seo_description</p>";
        return $link;
    }

}
