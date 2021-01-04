<?php

namespace App\Http\Resources\Manage;

use Illuminate\Http\Resources\Json\ResourceCollection;

class GoodsCollection extends ResourceCollection
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data' => GoodsResource::collection($this->collection),
            'pagination' => [
                'total' => $this->total(),
//                'count' => $this->count(),
//                'per_page' => $this->perPage(),
                'current_page' => $this->currentPage(),
//                'total_pages' => $this->lastPage()
            ],
        ];
    }

    /**
     * Customize the outgoing response for the resource.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Http\Response  $response
     * @return void
     */
//    public function withResponse($request, $response)
//    {
//        $jsonResponse = json_decode($response->getContent(), true);
////        unset($jsonResponse['links'],$jsonResponse['meta']);
//        $response->setContent(json_encode($jsonResponse));
//    }
}
