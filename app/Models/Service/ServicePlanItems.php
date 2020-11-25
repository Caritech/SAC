<?php

namespace App\Models\Service;

use App\Traits\ModelObservantTrait;
use DB;
use Illuminate\Database\Eloquent\Model;

class ServicePlanItems extends Model
{
    use ModelObservantTrait;
    protected $table = 'service_plan_items';
    protected $guarded = ['id'];
    public $timestamps = false;

    /*
    Handle Save Function in vue form
     */
    public function scopeVueSave($q, $items, $plan_id)
    {

        foreach ($items as $i) {
            $item_id = $i['item_id'];

            $breakdown = DB::table('setting_services_breakdown')
                ->where('id', $item_id)
                ->first();
            if ($breakdown == null) {
                continue;
            }

            $insert = [
                'plan_id' => $plan_id,
                'item_id' => $item_id,
                'item_value' => $i['item_value'],
                'item_code' => $breakdown->code,
                'item_name' => $breakdown->name,
                'item_uom' => $breakdown->uom,
            ];

            if ($i['type'] == 'NEW') {
                if ($insert['item_value'] != 0) {
                    ServicePlanItems::create($insert);
                }

            }
            if ($i['type'] == 'EDIT') {
                $edit = ServicePlanItems::find($i['id']);

                if ($insert['item_value'] != 0) {
                    if ($edit != null) {
                        $edit->update($insert);
                    }
                } else {
                    if ($edit != null) {
                        $edit->delete();
                    }
                }
            }

            if ($i['type'] == 'DELETE') {
                $delete = ServicePlanItems::find($i['id']);
                if ($delete != null) {
                    $delete->delete();
                }

            }

        }
    }
}
