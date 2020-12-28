<?php
$percentage = round($percentage);
$disabled = $disabled ?? false;

$default_color = $disabled ? 'grey' : 'green' ;
$default_text_color = $disabled ? 'grey-text' : 'green-text' ;

if(!$disabled){
    if($percentage >= 100){
        $default_color = 'green';
        $default_text_color = 'green-text';
    }else if($percentage >= 80){
        $default_color = 'yellow';
        $default_text_color = 'orange-text';
    }else if($percentage >= 60){
        $default_color = 'orange';
        $default_text_color = 'orange-text';
    }else{
        $default_color = 'red';
        $default_text_color = 'red-text';
    }
}

if($percentage > 0 && $percentage < 8 ){
    $percentage_width = 8;
}else{
    $percentage_width = $percentage;
}
if($percentage_width > 100){
    $percentage_width = 100;
}
?>
<div>
    <div class="grey lighten-1" style="height:20px;border:1px solid black">
        <div class="{{$default_color}}" style="height:20px;width:{{$percentage_width}}%"></div>
    </div>
    <div class="h5 mt-2 {{$default_text_color}}">{{$percentage}} %</div>
</div>