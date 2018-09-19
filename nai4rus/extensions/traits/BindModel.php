<?php
namespace Nai4rus\Extensions\Traits;


trait BindModel
{

//    public function addProperty(){
//        $this->properties['is_detail_page'] =  [
//            'title'             => 'Подробная страница',
//            'default'           => 0,
//            'type'              => 'checkbox'
//        ];
//    }

    public function bindModel($model,$propertyName = 'model'){
        if($this->property('is_detail_page')){
            if($model){
                $this->page[$propertyName] = $model;

            }else{
                return $this->controller->run('404',404);
            }
        }
    }

    public function bindMeta($model,$fields = ['title' => 'title','description' => 'description']){
        if($model){
            $meta = [];
            foreach ($fields as $key => $field){
                $meta[$key] = $model->$field;
            }
            $this->page['meta'] = $meta;
        }
    }


}