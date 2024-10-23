<?php 

namespace App\Service\Function\Base;


class BaseService 
{
   public function getListBaseFun($model, $page = 1, $limit = 10){

       $result =  $model->paginate($limit, ['*'], 'page', $page);
      
       return $result;
   }
}