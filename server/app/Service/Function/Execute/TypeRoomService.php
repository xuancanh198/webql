<?php 

namespace App\Service\Function\Execute;
use App\Models\Room\TypeRoomModel;
use App\Http\Requests\TypeRoomRequest;
use App\Service\Function\Base\BaseService;
class TypeRoomService extends BaseService
{
    protected $model;
    protected $request;

    public function __construct(TypeRoomModel $model, TypeRoomRequest $request) {
        $this->model = $model;
        $this->request = $request;
    }
    public function getList(){
        $page = $this->request->page ?? 1;
        $limit = $this->request->limit ?? 10;
        $excel = $this->request->excel ?? null;
       
        $result = $this->getListBaseFun($this->model, $page, $limit);
        return $result;
    }
}