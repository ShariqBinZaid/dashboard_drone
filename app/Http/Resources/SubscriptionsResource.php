<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SubscriptionsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $subscriptions = [];

        if ($this->resource->count() > 0) {
            foreach ($this->resource as $subscription) {
                $picture = $subscription->image != null ? asset('storage/' . $subscription->image) : '/assets/media/avatars/blank.png';
                $userAvatar = '<div class="d-flex align-items-center">
                            <div class="symbol symbol-35px symbol-circle">
                                    <img alt="Pic" src="' . $picture . '"
                                         style=" object-fit: cover;"/>
                            </div>
                            <a href="' . route('user.admin.view', $subscription->id) . '" target="_blank" >
                                <div class="text-gray-800 text-hover-primary mb-1 ms-5 cursor-pointer">
                                    ' . $subscription->first_name . ' ' . $subscription->last_name . '
                                    <div class="fw-semibold text-muted">' . $subscription->email . '</div>
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
                                <a class="dropdown-item create_new_off_canvas_modal edit_blog"  data-id="' . $subscription->id . '" href="javascript:void(0);" >Edit</a>
                            </li>';
                $actions .= '<li>
                                <a class="dropdown-item delete_record" data-id="' . $subscription->id . '" href="javascript:void(0);">Delete</a>
                            </li>';

                $actions .= '</ul>';

                $actions .= '</div>';

                $subscriptions[] = [
                    'image' => $userAvatar,
                    'name' => $subscription->name,
                    'price' => $subscription->price,
                    'desc' => $subscription->desc,
                    'start_date' => $subscription->start_date,
                    'end_date' => $subscription->end_date,
                    // 'createdAt' => Carbon::createFromFormat('Y-m-d H:i:s', $subscription->created_at)->format('d M, Y h:i A'),
                    'actions' => $actions
                ];
            }
        }
        return [
            'draw' => 1,
            'recordsTotal' => count($subscriptions),
            'recordsFiltered' => count($subscriptions),
            'data' => $subscriptions
        ];
    }
}
