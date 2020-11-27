<?php

namespace Modules\VLife\Classes;

class Lists
{
    static function insurance_assured()
    {
        $d = ['Self', 'Spouse name', 'Child name'];
        $rs = array_combine($d, $d);
        return array_to_js_array($rs);
    }

    static function insurance_plan_type()
    {
        $d = [
            'Investment Linked',
            'Wholelife (Par)',
            'Wholelife (Non-Par)',
            'Endowment',
            'Universal Life',
            'Standalone H&S',
            'Personal Accident',
            'Term Life',
            'Annuity',
            'Others'
        ];
        $rs = array_combine($d, $d);
        return array_to_js_array($rs);
    }

    static function premium_status()
    {
        $d = [
            'Inforce',
            'Lapsed',
            'Surrendered',
            'Fully-Paid',
            'Extended Term',
            'APL',
            'Premium Holiday',
            'Matured',
            'Assigned (Conditional)',
            'Assigned (Absolute)',
        ];
        $rs = array_combine($d, $d);
        return array_to_js_array($rs);
    }

    static function coverage_type()
    {
        $d = [
            'Death',
            'TPD',
            'Critical Illesses',
            'Early CI',
            'Others',
        ];
        $rs = array_combine($d, $d);
        return array_to_js_array($rs);
    }

    static function coverage_frequency()
    {
        $d = [
            'One-Off',
            'Periodically',
        ];
        $rs = array_combine($d, $d);
        return array_to_js_array($rs);
    }

    static function premium_frequency()
    {
        $d = [
            'Monthly',
            'Quarterly',
            'Half-yearly',
            'Yearly',
            'One-Off',
        ];
        $rs = array_combine($d, $d);
        return array_to_js_array($rs);
    }

    static function relationship()
    {
        $d = [
            'None',
            'Child',
            'Husband',
            'Wife',
            'Father',
            'Mother',
            'Sibling',
            'Other',
        ];
        $rs = array_combine($d, $d);
        return array_to_js_array($rs);
    }
}