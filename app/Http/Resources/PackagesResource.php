<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use App\Helper\Helper;
use Illuminate\Http\Resources\Json\JsonResource;

class PackagesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $pkgs = [];

        if ($this->resource->count() > 0) {
            foreach ($this->resource as $pkg) {

                $actions = '<div class="dropdown">';
                $actions .= '<button class="btn btn-active-dark btn-sm dropdown-toggle" type="button" id="actionsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="actionsMenu">';
                $actions .= '<li>
                                <a class="dropdown-item create_new_off_canvas_modal edit_blog"  data-id="' . $pkg->id . '" href="javascript:void(0);" >Edit</a>
                            </li>';
                $actions .= '<li>
                                <a class="dropdown-item delete_record" data-id="' . $pkg->id . '" href="javascript:void(0);">Delete</a>
                            </li>';

                $actions .= '</ul>';

                $actions .= '</div>';

                $pkgs[] = [
                    'name' => $pkg->name,
                    'no_of_session' => $pkg->no_of_session . " Session",
                    'session_time' => $pkg->session_time . " Minutes",
                    'discount_offer' => $pkg->discount_offer,
                    'sale_price' => $pkg->sale_price,
                    'price' => "$" . $pkg->price,
                    // 'createdAt' => Carbon::createFromFormat('Y-m-d H:i:s', $pkg->created_at)->format('d M, Y h:i A'),
                    'actions' => $actions
                ];
            }
        }
        return [
            'draw' => 1,
            'recordsTotal' => count($pkgs),
            'recordsFiltered' => count($pkgs),
            'data' => $pkgs
        ];
    }
}
