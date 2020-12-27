<?php
//Required Parameter
$with_insurance = $with_insurance ?? false;
$text_color = 'teal-text'; //green for surplus, red for shortfall
$have = $have ?? 0;
$want = $want ?? 0;
$title = $title ?? 'N/A';

$percentage = ($want != 0) ? $have / $want * 100 : 0;

$precent_grey_out = false;

//IF Want is zero, add grey overlap
if ($want == 0) {
    $text_color = 'grey-text';
    $precent_grey_out = true;
}


?>
<!-- FOR DEFAULT -->
<div class="grey lighten-4 {{$text_color}} p-5 mb-2">
    <div class="h3">{{$title}}</div>
    <div class="mt-2">ICON</div>

    <table class="mt-2 h5 {{$text_color}} ">
        <tr>
            <td>Want</td>
            <td>$ {{displayMoney($want)}}</td>
        </tr>
        <tr>
            <td>HAVE</td>
            <td>$ {{displayMoney($have)}}</td>
        </tr>
    </table>

    @if($with_insurance)
    <table class="mt-5 h5 {{$text_color}} ">
        <tr>
            <td>Insurer</td>
            <td>:</td>
            <td>GEL</td>
        </tr>
        <tr>
            <td>R & B</td>
            <td>:</td>
            <td>$ 150 / day</td>
        </tr>
        <tr>
            <td>Annual Lmt.</td>
            <td>:</td>
            <td>$ 150 / day</td>
        </tr>
        <tr>
            <td>Lifetime Lmt.</td>
            <td>:</td>
            <td>$ 150 / day</td>
        </tr>
        <tr>
            <td>Co-Insurance</td>
            <td>:</td>
            <td>$ 150 / day</td>
        </tr>
        <tr>
            <td>Term</td>
            <td>:</td>
            <td>$ 150 / day</td>
        </tr>
        <tr>
            <td>Remarks</td>
            <td>:</td>
            <td>$ 150 / day</td>
        </tr>
    </table>
    @endif

    <div class="mt-5">
        PERSONAL MEDICAL HBAVE NOTE
    </div>
    <div class="mt-4">
        @include('reports/my_contact/components/percentage_bar',['percentage'=>$percentage,'disabled'=>$precent_grey_out])
    </div>
</div>