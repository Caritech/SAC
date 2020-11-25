<?php

function lists_relationship($type = null){
  $data = DB::table('setting_relationship');
  if($type == null){
    $data->selectRaw('ID, Relationship');
  }else if($type == 'opposite'){
    $data->selectRaw('ID,CONCAT(Relationship," -> ",relate_opposite_name) as Relationship');
  }

  return $data->pluck('Relationship', 'ID');
}

function lists_relationship_group_option(){
  return [
      'Emergency Contact' => 'Emergency Contact',
      'Family' => 'Family',
      'Primary Carer' => 'Primary Carer',
      'Billing' => 'Billing',
  ];
}

function lists_personal_details(){
  return DB::table('personal_details')
            ->selectRaw('id,REPLACE(TRIM(CONCAT(FirstName," ",MiddleName," ",Surname)),"  "," ") as name')
            ->where('FirstName', '<>', '')
            ->whereNotNull('FirstName')
            ->where('MiddleName', '<>', '')
            ->whereNotNull('MiddleName')
            ->where('Surname', '<>', '')
            ->whereNotNull('Surname')
            ->pluck('name', 'id');
}

function lists_services(){
  return DB::table('setting_services')
  ->pluck('code','id')
  ->toArray();
}

function lists_assignment_type(){
  return [
    'hh' => 'Home Help',
    'transport' => 'Transport',
    'centre' => 'Centre',
  ];
}

