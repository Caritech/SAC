<?php
/*
  For Standardize HTML Single Component like:
  Button - add, remove, delete, view, search, search exactly, cancel
  Link
 */
function html_search_exactly_button(){
  return
    \Form::button(
      '<i class="fa fa-search" aria-hidden="true"></i>',
      [
        'class' => 'btn btn-info',
        'title'=>'Search Exactly',
        'type'=>'submit',
        'name'=>'SearchExactly',
        'value'=>'SearchExactly'
      ]
    );
}

function html_search_button(){
  return
    \Form::button(
      '<i class="fa fa-search" aria-hidden="true"></i>',
      [
        'class' => 'btn btn-default',
        'title'=>'Search',
        'type'=>'submit',
        'name'=>'Search',
        'value'=>'Search'
      ]
    );
}

function html_clear_search_button(){
  return
    \Form::button(
      config('btnFont.cross'),
      [
        'class' => 'btn btn-warning loading clear-search',
        'title'=>'Clear'
      ]
    );
}

function html_simple_input_text($name, $display_name, $value=null, $class=''){
  return '
    <div class="row">
      <label class="col-md-2">'.$display_name.'</label>
      <div class="col-md-8">
        <input class="form-control" name="'.$name.'" type="text" value="'.$value.'">
      </div>
    </div>
  ';
}

function html_simple_input_datepicker($name, $display_name, $value=null, $class=''){
  return '
    <div class="row">
      <label class="col-md-2">'.$display_name.'</label>
      <div class="col-md-8">
        <input class="form-control datepicker" name="'.$name.'" type="text" value="'.$value.'">
      </div>
    </div>
  ';
}
function html_simple_input_timepicker($name, $display_name, $value=null, $class=''){
  return '
    <div class="row">
      <label class="col-md-2">'.$display_name.'</label>
      <div class="col-md-8">
        <input class="form-control timepicker" name="'.$name.'" type="text" value="'.$value.'">
      </div>
    </div>
  ';
}

function html_simple_input_checkbox($name, $display_name, $value=null, $class=''){
  return '
    <div class="row">
      <label class="col-md-2">'.$display_name.'</label>
      <div class="col-md-8">
        <input name="'.$name.'" type="hidden" value="0">
        <input name="'.$name.'" type="checkbox" value="1" class="'.$class.'" >
      </div>
    </div>
  ';
}

function html_simple_textarea($name, $display_name, $value=null, $class=''){
  return '
    <div class="row">
      <label class="col-md-2">'.$display_name.'</label>
      <div class="col-md-8">
        <textarea name="'.$name.'" class="form-control simple-textarea '.$class.'"></textarea>
      </div>
    </div>
  ';
}

function html_simple_select($name, $display_name,$lists, $value=null, $class=''){
  $options = '';
  foreach($lists as $k => $v){
    $options .= "<option value='".$k."'>".$v."</option>";
  }

  return '
    <div class="row">
      <label class="col-md-2">'.$display_name.'</label>
      <div class="col-md-8">
        <select name="'.$name.'" class="form-control '.$class.' ">
          '.$options.'
        </select>
      </div>
    </div>
  ';
}


function html_add_button($arr=[],$attr=[]){
  $default_class = 'btn btn-success fa-plus'; //default attr
  $attr = $attr??[];
  $attr['class'] = $default_class.' '.$attr['class']??'';

  return
    Html::link(
      $arr['link']??null,
      ' '.$arr['label']??'',
      $attr
    );
}

function html_submit_button($arr=[],$attr=[]){
  $default_class = 'btn btn-success'; //default attr
  $label = $attr['label'] ?? 'Submit';
  $attr = $attr??[];
  $attr['class'] = $default_class.' '.($attr['class']??'');
  return Form::Submit(' '.$label , $attr);
}

function html_search_input_text($arr=[]){
  $name = $arr['name']??null;
  $label = $arr['label']??null;
  $size = $arr['size']??2;

  return "
    <div class='col-md-$size'>
      ".Form::label($name,$label)."
      ".Form::text(
        $name,null ,['class'=>'form-control'])."
    </div>
  ";
}

function html_search_input_select($arr=[]){
  $name = $arr['name']??null;
  $label = $arr['label']??null;
  $lists = $arr['lists']??[];
  $size = $arr['size']??2;
  $value =$arr['value']??null;

  return "
    <div class='col-md-$size'>
      ".Form::label($name,$label)."
      ".Form::select(
        $name,$lists,$value ,['class'=>'form-control'])."
    </div>
  ";
}

function html_search_input_select2($arr=[]){
  $name = $arr['name']??null;
  $label = $arr['label']??null;
  $lists = $arr['lists']??[];
  $size = $arr['size']??2;

  return "
    <div class='col-md-$size'>
      ".Form::label($name,$label,['class'=>'label-control'])."
      ".Form::select(
        $name,$lists,null ,['class'=>'form-control select2'])."
    </div>
  ";
}