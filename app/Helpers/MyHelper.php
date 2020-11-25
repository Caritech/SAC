<?php

//better dd
function d()
{

}

/*
 * This function is used to convert php key => value array to javascript array of object
 *
 * For example ['key1' => 'apple','key2' => 'orange']
 * it will become
 * [{key:'key1','value'=>'apple'},{key:'key2','value'=>'orange}]
 *
 * FOR for Single dimension array only.
 * */
function array_to_js_array($assoc_arr)
{
    $new_arr = [];
    foreach ($assoc_arr as $k => $v) {
        $new_arr[] = [
            'value' => $k,
            'text' => $v,
        ];
    }
    return $new_arr;
}

/*
Covert Validator's error message to html (<br>)
It is suitable to use for Sweetalert , but not alert()
 */
function covert_validation_errror_to_html($validator)
{
    $valdiator_msg = $validator->errors()->getMessages();
    $error_msg = [];
    foreach ($valdiator_msg as $k => $bag) {
        foreach ($bag as $v) {
            $error_msg[] = $v;
        }
    }
    return implode("<br>", $error_msg);
}

function add_create_dt_user($data){
    $data['created_by'] = \Auth::id();
    $data['created_at'] = \Carbon\Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString();
    return $data;
}

function add_update_dt_user($data){
    $data['updated_by'] = \Auth::id();
    $data['updated_at'] = \Carbon\Carbon::now('Asia/Kuala_Lumpur')->toDateTimeString();
    return $data;
}
