<?php

namespace App\Models\Service;

use App\Traits\ModelObservantTrait;
use DB;
use Illuminate\Database\Eloquent\Model;

class ServiceAssignmentItems extends Model
{
    use ModelObservantTrait;
    protected $table = 'service_assignment_items';
    protected $guarded = ['id'];
    public $timestamps = false;

    /*
    Handle Save Function in vue form
     */
    public function scopeVueSave($q, $items, $asg_id)
    {

        foreach ($items as $i) {
            $item_id = $i['item_id'];

            $breakdown = DB::table('setting_services_breakdown')
                ->where('id', $item_id)
                ->first();

            $insert = [
                'assignment_id' => $asg_id,
                'item_id' => $item_id,
                'item_value' => $i['item_value'],
                'item_code' => $breakdown->code,
                'item_name' => $breakdown->name,
                'item_uom' => $breakdown->uom,
            ];

            if ($i['type'] == 'NEW') {
                if ($insert['item_value'] != 0) {
                    ServiceAssignmentItems::create($insert);
                }
            }
            if ($i['type'] == 'EDIT') {

                $edit = ServiceAssignmentItems::find($i['id']);
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
                $delete = ServiceAssignmentItems::find($i['id']);
                if ($delete != null) {
                    $delete->delete();
                }

            }

        }
    }
}
