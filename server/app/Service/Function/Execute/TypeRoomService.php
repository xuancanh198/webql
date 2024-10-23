<?php 

namespace App\Service\Function\Execute;
use App\Models\Room\TypeRoomModel;
use App\Http\Requests\TypeRoomRequest;
use App\Service\Function\Base\BaseService;
class TypeRoomService extends BaseService
{
    protected $model;
    protected $request;
    protected $columSearch = ['name', 'code'];
    public function __construct(TypeRoomModel $model, TypeRoomRequest $request) {
        $this->model = $model;
        $this->request = $request;
    }
    public function getList(){
        $page = $this->request->page ?? 1;
        $limit = $this->request->limit ?? 10;
        $excel = $this->request->excel ?? null;
        $search = $this->request->search ?? null;
        $typeTime = $this->request->typeTime ?? null;
        $start = $this->request->start ?? null;
        $end = $this->request->end ?? null;
        $result = $this->getListBaseFun($this->model, $page, $limit , $search, $this->columSearch, $excel, $typeTime, $start, $end);
        return $result;
    }
}