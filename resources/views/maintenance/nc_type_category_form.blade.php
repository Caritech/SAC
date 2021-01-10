@extends('layouts.app_v1.master')

@section('content')

<div class="card m-2">
    <div class="card-body">

        <h2>Needs Calculator Type Maintenance</h2>

        <form autocomplete="off" method="POST" action="{{url('vlife/setting/nc_type_category/'.$category->id)}}">
            <input name="_method" type="hidden" value="PUT">
            {{csrf_field()}}
            <div class="h3">Category: {{$category->category_name}}</div>

            <div>
                Use Annual Income: 
                {{Form::select('use_annual_income',[0=>'No',1=>'Yes'],$category->use_annual_income,['class'=>'use_annual_income'])}}
            </div>

            <div class="div_amount_prefered">
                Amount Allocated: 
                <input type="number" name="amount_prefered" class="amount_prefered" value="{{$category->amount_prefered}}">
            </div>
            
            <div class="div_multiply_annual_income">
                Multiply Rate For Annual Income: 
                <input type="number" name="multiply_annual_income" class="multiply_annual_income" value="{{$category->multiply_annual_income}}">
            </div>

            <table class="table table-bordered table-striped">
                <tr>
                    <th>Type Name</th>
                    {{-- <th>Amount Prefered</th> --}}
                    <th>Percentage Prefered</th>
                    <th>Amount</th>
                </tr>
                @foreach($data as $d)
                <tr>
                        <td>{{$d->type_name}}</td>
                        {{-- <td>{{$d->amount_prefered}}</td> --}}
                        <td>
                            <input 
                                type="number" 
                                name="type[{{$d->id}}][percentage_prefered]" 
                                value="{{$d->percentage_prefered }}"
                                class="type_percentage"
                                max="100"
                            >
                        </td>
                        <td>
                            <span class="amount_calculated"></span>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td>Total</td>
                    <td><span class="total_percentage"></span></td>
                    <td></td>
                </tr>
            </table>

            <div class="m-2">
                <input type="submit" class="btn btn-success" value="Save">
            </div>
        </form>

    </div>

</div>

@endsection

@section('js')
<script>
    $(function(){
        onAnnualIncomeChange();
        recalculate();

        $('.type_percentage, .amount_prefered').change(function(){
            recalculate();
        })
        $('.use_annual_income').change(function(){
            let v = $(this).val();
            onAnnualIncomeChange(v);
        })
    })

    function recalculate(){
        
        let total = $('.amount_prefered').val();
        let total_percentage = 0;
        $('.type_percentage').each(function(){
            let percentage = $(this).val();
            let amount = total * percentage / 100;
            
            if($('.use_annual_income').val() == 0){
                $(this).closest('tr').find('.amount_calculated').html(amount)
            }
            
            total_percentage += parseFloat(percentage)
        })
        
        $('.total_percentage').html(total_percentage)
        
    }

    function onAnnualIncomeChange(v){
        let check;
        
        if(v == null){
            check = $('.use_annual_income').val();
        }else{
            check = v
        }

        if(check == 1){
            $('.div_amount_prefered').hide();
            $('.div_multiply_annual_income').show();
        }else{
            $('.div_amount_prefered').show();
            $('.div_multiply_annual_income').hide();
        }
    }
</script>
@endsection




