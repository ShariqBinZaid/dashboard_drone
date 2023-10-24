<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class BestPlaceResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $places = [];

        if ($this->resource->count() > 0) {
            foreach ($this->resource as $place) {
                $picture = $place->file != null ? asset('storage/' . $place->file) : '/assets/media/avatars/blank.png';
                $userAvatar = '<div class="d-flex align-items-center">
                            <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="' . $picture . '"
                                         style=" object-fit: cover;"/>
                            </div>
                            <a href="' . route('user.admin.view', $place->id) . '" target="_blank" >
                                <div class="text-gray-800 text-hover-primary mb-1 ms-5 cursor-pointer">
                                    ' . $place->first_name . ' ' . $place->last_name . '
                                    <div class="fw-semibold text-muted">' . $place->email . '</div>
                                </div>
                                </a>
                            <!--end::Details-->
                        </div>';

                $actions = '<div class="dropdown">
                              <button class="btn btn-active-dark btn-sm dropdown-toggle" type="button" id="actionsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="actionsMenu">';

                $actions = '<div class="dropdown">';
                $actions .= '<button class="btn btn-active-dark btn-sm dropdown-toggle" type="button" id="actionsMenu" data-bs-toggle="dropdown" aria-expanded="false">
                                Action
                              </button>
                              <ul class="dropdown-menu" aria-labelledby="actionsMenu">';
                $actions .= '<li>
                                <a class="dropdown-item create_new_off_canvas_modal edit_blog"  data-id="' . $place->id . '" href="javascript:void(0);" >Edit</a>
                            </li>';
                $actions .= '<li>
                                <a class="dropdown-item delete_record" data-id="' . $place->id . '" href="javascript:void(0);">Delete</a>
                            </li>';

                $actions .= '</ul>';

                $actions .= '</div>';

                $places[] = [
                    'file' => $userAvatar,
                    'user_id' => $place->getUser->first_name . ' ' . $place->getUser->last_name,
                    'title' => $place->title,
                    'loc' => $place->loc,
                    'desc' => $place->desc,
                    // 'createdAt' => Carbon::createFromFormat('Y-m-d H:i:s', $place->created_at)->format('d M, Y h:i A'),
                    'actions' => $actions
                ];
            }
        }
        return [
            'draw' => 1,
            'recordsTotal' => count($places),
            'recordsFiltered' => count($places),
            'data' => $places
        ];
    }
}
