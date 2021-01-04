<?php

namespace App\Http\Resources\Manage;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class GoodsResource extends JsonResource
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
            'name' => $this->name,
            'subtitle' => $this->subtitle,
            'sn' => $this->sn,
            'sku_id' => $this->sku_id,
            'goods_type' => $this->goods_type,
            'spec_type' => $this->spec_type,
            'pay_type' => $this->pay_type,
            'thumb' => $this->thumb,
            'brand_id' => $this->brand_id,
            'category' => $this->category,
            'category_names' => $this->category_names,
            'region_id' => $this->region_id,
            'region_ids' => $this->region_ids,
            'keywords' => $this->keywords,
            'description' => $this->description,
            'is_free_shipping' => $this->is_free_shipping,
            'status' => $this->status,
            'tags' => $this->tags,
            'goods_content' => $this->goods_content,
            'sort' => $this->sort,
            'seller_id' => $this->seller_id,
            'store_id' => $this->store_id,
            'physical_store_id' => $this->physical_store_id,
            'suppliers_id' => $this->suppliers_id,
            'join_activity' => $this->join_activity,
            'sale_counts' => $this->sale_counts,
            'view_counts' => $this->view_counts,
            'comment_counts' => $this->comment_counts,
            'collect_counts' => $this->collect_counts,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
