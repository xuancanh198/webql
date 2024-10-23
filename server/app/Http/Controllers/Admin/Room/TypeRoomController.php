<?php

namespace App\Http\Controllers\Admin\Room;

use App\Http\Controllers\Controller;
use App\Service\Function\Execute\TypeRoomService;
use App\Http\Resources\TypeRoomResource;
class TypeRoomController extends Controller
{
    protected $service;
    public function __construct(TypeRoomService $service) {
        $this->service = $service;
    }
    public function index() {
        $result = $this->service->getList();
            $data = TypeRoomResource::collection($result->items());
            $result->setCollection($data->collect());
            return $this->returnResponseData('success', $result, 'normal');
    }

    public function store() {}
    public function update($id) {}
    public function destroy($id) {}
}
