@extends('layouts.pdf') @section('title') Insurance Summary Report @endsection
@section('content')

<style>
  .p-5 {
    padding: 10px;
  }

  .center {
    text-align: center;
  }

  .right {
    text-align: right;
  }

  .left {
    text-align: left;
  }

  .bold {
    font-weight: bold;
  }

  .category-title {
    font-size: 18px;
    padding: 5px;
    text-align: center;
    width: 100%;
  }

  .category-body {
    padding: 5px;
    margin: 5px;
    text-align: center;
  }

  .label-text {
    font-weight: bold;
  }

  .pb-1 {
    padding-bottom: 8px;
  }

  .p-1 {
    padding: 5px;
  }

  .category-container {
    padding: 8px 5px;
    margin-bottom: 2px;
    margin-left: 3px;
    margin-right: 2px;
    height: 200px;
  }

  .remark-field {
    font-size: 15px;
    line-height: 1.5;
    text-align: justify;
    padding: 5px;
    border: 1px solid black;
  }

  .image-container {
    padding: 10px;
  }
</style>

<h1 class="blue-grey darken-4 p-5 center bold white-text">
  <div class="">LIVE ASSURANCE NEEDS SUMMARY OF</div>
  <div class="yellow-text">Prospect</div>
</h1>

<div class="w100">
  <?php
  $type_personal_medical = [
    'personal_medical' => 'Personal Medical',
  ];

  $type_critical_illness = [
    'income_replacement' => 'Income Replacement',
  ];

  $type_death_tpd = [
    'final_expenses' => 'Final Expenses',
    'estate_execution' => 'Estate Execution',
    'parents_allowance' => 'Parents Allowance',
    'spouse_allowance' => 'Spouse Allowance',
    'spouse_retirement' => 'Spouse Retirement',
    'children_allowance' => 'Children Allowance',
    'children_education' => 'Children Education',
    'children_competition_capital' => 'Competition Capital',
    'mortgage_loan' => 'Mortgage Loan',
    'car_loan' => 'Car Loan',
    'study_loan' => 'Study Loan',
    'credit_card' => 'Credit Card',
    'personal_loan' => 'Personal Loan',
    'business_loan' => 'Business Loan',
    'other_loan' => 'Other Loan',
    'special_wish' => 'Special Wish',
  ];


  $lists_of_type = array_merge($type_personal_medical, $type_critical_illness, $type_death_tpd);
  ?>

  @php($count = 0)
  @foreach($lists_of_type AS $type => $type_title)
  <?php
  //Amount Want
  $amount_want = $want[$type]['want'] ?? 0;
  $description_want = $want[$type]['description'] ?? '';

  //Amount Have, reduce amount have for each loop
  if (
    array_key_exists($type, $type_personal_medical)
  ) {
    $amount_have = $have['medical'] ?? 0;
    $have['medical'] -= $amount_want;
  } else if (
    array_key_exists($type, $type_critical_illness)
  ) {
    $amount_have = $have['critical_illness'] ?? 0;
    $have['critical_illness'] -= $amount_want;
  } else if (
    array_key_exists($type, $type_death_tpd)
  ) {
    $amount_have = $have['death_tpd'] ?? 0;
    if ($have['death_tpd'] <= $amount_want) {
      $have['death_tpd'] = 0;
    } else {
      $have['death_tpd'] -= $amount_want;
    }
  }

  //to prevent value exceed 100% too much, for death tpd use, since it has multiple
  if (
    array_key_exists($type, $type_death_tpd)
  ) {
    $amount_have = $amount_have > $amount_want ? $amount_want : $amount_have;
  }

  if ($type == "personal_medical") {
    $insurance = $medical_insurance ?? [];
  } else {
    $insurance = [];
  }

  ?>
  <div class="w50">
    <div class="pr-3">
      @include('reports.my_contact.components.insurance_item',[
      'title'=>$type_title,
      'want'=>$amount_want,
      'have'=>$amount_have,
      'description' => $description_want,
      'insurance' => [],
      'type'=>$type
      ])
    </div>
  </div>
  @php($count ++)
  @if($count == 6)
    @php($count = 0)
    <pagebreak />
    <div class="" style="height:20px"></div>
  @endif
  @endforeach


</div>
<!-- Category Section-->

<!--    REMARK SECTION  -->
<div class="" style="height:20px"></div>

<!-- Special Remark -->
{{-- <div class="w100">
  <div class="p-1 blue-grey darken-4 yellow-text bold w30">
    <span class="" style="font-size:20px">Special Remarks : </span>
  </div>
  <p class="w100 remark-field"></p>
</div> --}}


<!-- What Right Time to male review -->
<div>
  <div class="w100 blue-grey darken-4 white-text bold p-5" style="font-size:20px">
    When is the <span class="yellow-text">RIGHT</span> time to review
    your insurance policies?
  </div>

  <div class="w100">
    <div class="w90 grey lighten-3" style="padding:20px">
      <div class="w15" style="font-size:35px;font-weight:bold">
        01
      </div>
      <div class="w85" style="font-size:15px;line-height:1.5">
        When you overheard there’s a tremendous change in what the
        insurance industry has to offer in compared to what you
        have.
      </div>
    </div>
    <div class="w10 white white-text">.</div>
  </div>

  <div class="w100">
    <div class="w10 white white-text">.</div>
    <div class="w85 grey lighten-3" style="padding:20px">
      <div class="w85" style="font-size:15px;line-height:1.5;text-align:right">
        When there is a life changing event, such as starting up a
        career or business, getting a job promotion, or career
        advancement, buying your first car, getting married, buying
        your first home, having your first born, buying another car,
        buying another property, having another child & etc.
      </div>
      <div class="w15 center" style="font-size:40px;font-weight:bold">
        02
      </div>
    </div>
    <div class="w10 white white-text">.</div>
  </div>

  <div class="w100">
    <div class="w90 grey lighten-3" style="padding:20px">
      <div class="w15" style="font-size:35px;font-weight:bold">
        03
      </div>
      <div class="w85" style="font-size:15px;line-height:1.5">
        Before you go for a thorough medical check-up.
      </div>
    </div>
    <div class="w10 white white-text">.</div>
  </div>

  <div class="w100">
    <div class="w10 white white-text">.</div>
    <div class="w85 grey lighten-3" style="padding:20px">
      <div class="w85" style="font-size:15px;line-height:1.5;text-align:right">
        If none of the above is happening to you, the best time to
        review your policies is still every 3 years.
      </div>
      <div class="w15 center" style="font-size:40px;font-weight:bold">
        04
      </div>
    </div>
    <div class="w10 white white-text">.</div>
  </div>
</div>
<!-- What Right Time to male review -->

<div class="" style="height:50px"></div>

<!-- Next Review Date -->
{{-- <div class="w100 center">
  <div class="w10 white white-text">.</div>
  <div class="w30 p-5 bold" style="font-size:15px">
    Your next Review is on
  </div>
  <div class="w30 blue-grey darken-4 p-5 bold yellow-text" style="font-size:20px">
    {{ date("F Y", strtotime(" + 3 year")) }}
  </div>
</div> --}}
@endsection