<?php
//Required Parameter
$with_insurance = $with_insurance ?? false;

/*
    Medical : green
    Critical Illness :  red
    Dealth Tpd: blue
*/
if($category == 'medical'){
    $text_color = 'green-text'; //green for surplus, red for shortfall
}else if($category == 'critical_illness'){
    $text_color = 'pink-text'; //green for surplus, red for shortfall
}else if($category == 'death_tpd'){
    $text_color = 'blue-text'; //green for surplus, red for shortfall
}else{
    $text_color = 'teal-text'; //green for surplus, red for shortfall
}






$have = $have ?? 0;
$want = $want ?? 0;
$title = $title ?? 'N/A';

$description = $description == '' ? '-' : $description;
$type = $type ?? '';
$insurance = $insurance ?? [];

$percentage = ($want != 0) ? $have / $want * 100 : 0;

$precent_grey_out = false;

//IF Want is zero, add grey overlap
if ($want == 0) {
    $text_color = 'grey-text';
    $precent_grey_out = true;
}

$image_path = get_icon_path_by_type($type);
?>
<!-- FOR DEFAULT -->
<div class="grey lighten-4 p-5 mb-5">
    <div class="{{$text_color}} ">
        <div class="h3 bold">{{$title}}</div>
        <div class="mt-2">
            <img src="{{$image_path}}" width="35" height="35" />
        </div>

        <table class="mt-2 h5 {{$text_color}} ">
            <tr>
                <td width=" 50%" align="right">Want</td>
                <td width="50%" align="right">$ {{displayMoney($want)}}</td>
            </tr>
            <tr>
                <td width="50%" align="right">HAVE</td>
                <td width="50%" align="right">$ {{displayMoney($have)}}</td>
            </tr>
        </table>

        <?php
            /*
                //Layout issues
                @if(count($insurance) > 0)
                @foreach($insurance as $d)
                <table class="mt-5 h5 {{$text_color}} w100">
                    <tr>
                        <td>Insurer</td>
                        <td>:</td>
                        <td>{{$d->insurer}}</td>
                    </tr>
                    <tr>
                        <td>R & B</td>
                        <td>:</td>
                        <td>$ {{displayMoney($d->medical_benefit_room_board_rate)}} / day</td>
                    </tr>
                    <tr>
                        <td>Annual Lmt.</td>
                        <td>:</td>
                        <td>$ {{displayMoney($d->medical_benefit_annual_limit)}}</td>
                    </tr>
                    <tr>
                        <td>Lifetime Lmt.</td>
                        <td>:</td>
                        <td>$ {{displayMoney($d->medical_benefit_lifetime_limit)}}</td>
                    </tr>
                    <tr>
                        <td>Co-Insurance</td>
                        <td>:</td>
                        <td>{{$d->medical_benefit_co_insurance}}</td>
                    </tr>
                    <tr>
                        <td>Term</td>
                        <td>:</td>
                        <td>Till Age {{$d->medical_benefit_maturity_age ?? '-'}}</td>
                    </tr>
                    <tr>
                        <td>Remarks</td>
                        <td>:</td>
                        <td>{{$d->medical_benefit_remarks}}</td>
                    </tr>
                </table>
                @endforeach
                @endif
            */
        ?>

        <div class="mt-5 h5" style="height:{{$box_height}};max-height:{{$box_height}}">
            {{$description}}
        </div>
        <div class="mt-4">
            @include('reports/my_contact/components/percentage_bar',['percentage'=>$percentage,'disabled'=>$precent_grey_out])
        </div>
    </div>
</div>