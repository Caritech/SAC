<?php

namespace Modules\DataAdapter\Http\Controllers;

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Schema;

class ContactGenerator extends Controller
{
    public static function generate_contact_table()
    {
        /*
        Start Personal Particular
         */
        Schema::dropIfExists('personal_particular');
        Schema::create('personal_particular', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->string('salutation')->nullable();
            $table->string('first_name')->nullable();
            $table->string('middle_name')->nullable();
            $table->string('surname')->nullable();
            $table->string('chinese_name')->nullable();
            $table->string('prefer_name')->nullable();

            $table->date('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('photo')->nullable();

            //contact way
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('mobile')->nullable();

            //license & vehicle
            $table->integer('driving_license')->nullable();
            $table->string('driving_license_no')->nullable();
            $table->date('driving_license_expiring_date')->nullable();
            $table->integer('has_vehicle')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->integer('vehicle_insurance_chk')->nullable();
            $table->date('vehicle_insurance_expiring_date')->nullable();
            $table->date('vehicle_last_service_date')->nullable();
            $table->date('police_cert_expiring_date')->nullable();
            $table->tinyInteger('working_child_check')->nullable();
            $table->date('workign_child_expiring_date')->nullable();

            //language
            $table->string('primary_language')->nullable();
            $table->string('seconday_language')->nullable();
            $table->string('other_language')->nullable();
            $table->string('prefer_language')->nullable();

            //Other information
            $table->string('medical_care_no')->nullable();
            $table->string('medical_care_status')->nullable();
            $table->string('slk_no')->nullable();
            $table->string('nationality')->nullable();
            $table->string('understand_english')->nullable();
            $table->string('living_status')->nullable();
            $table->string('housing_type')->nullable();
            $table->string('income_type')->nullable();
            $table->string('religion')->nullable();

            //person info
            $table->string('occupation')->nullable();
            $table->string('residential_status')->nullable();

            $table->string('note_service_type')->nullable();
            $table->string('note_hobby')->nullable();
            $table->string('note')->nullable();
            $table->string('mailing_langauge_code')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End Personal Particular
         */

        /*
        Start personal_particular_address
         */
        Schema::dropIfExists('personal_particular_address');
        Schema::create('personal_particular_address', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('street_no')->nullable();
            $table->string('street_name')->nullable();
            $table->string('suburb')->nullable();
            $table->string('state')->nullable();
            $table->string('post_code')->nullable();
            $table->string('address_info')->nullable();
            $table->string('gps_location')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longtitude')->nullable();
            $table->tinyInteger('with_pet')->nullable();
            $table->string('remark')->nullable();
            $table->string('address_type')->nullable(); //mailing , livin
            $table->string('mailing')->nullable();
            $table->string('region')->nullable(); //Austrial use

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End personal_particular_address
         */

        /*
        Start personal_particular_medical_history
         */
        Schema::dropIfExists('personal_particular_medical_history');
        Schema::create('personal_particular_medical_history', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('medical')->nullable();
            $table->date('start_date')->nullable();
            $table->string('remark')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End personal_particular_medical_history

        /*
        Start personal_particular_leave
         */
        Schema::dropIfExists('personal_particular_leave');
        Schema::create('personal_particular_leave', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('leave_type')->nullable();
            $table->string('remark')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->double('no_day', 12, 1)->nullable();
            $table->string('leave_status')->nullable(); // pending
            $table->string('supervisor_status')->nullable(); // rejected
            $table->string('supervisor_reason')->nullable(); //
            $table->tinyInteger('on_behalf')->nullable(); //applied by admin
            $table->string('leave_document')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End personal_particular_leave
         */

        /*
        Start personal_details_roles
         */
        Schema::dropIfExists('personal_details_roles');
        Schema::create('personal_details_roles', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('role')->nullable();
            $table->string('status')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End personal_details_roles
         */

        /*
        Start personal_particular_journey
         */
        Schema::dropIfExists('personal_particular_journey');
        Schema::create('personal_particular_journey', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('title')->nullable();
            $table->string('detail')->nullable();
            $table->date('date')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End personal_particular_journey
         */

        /*
        Start personal_particular_relationship
         */
        Schema::dropIfExists('personal_particular_relationship');
        Schema::create('personal_particular_relationship', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->integer('relate_pp_id')->nullable();
            $table->integer('relationship_id')->nullable();
            $table->string('relationship')->nullable();
            $table->string('group_relation')->nullable(); // Emergency Contact, Family, Primary Carer

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End personal_particular_relationship
         */

        /*
        Start support_worker
         */
        Schema::dropIfExists('support_worker');
        Schema::create('support_worker', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('sw_no')->nullable();
            $table->string('caseworker_id')->nullable();
            $table->string('supervisor_id')->nullable();
            $table->tinyInteger('active')->nullable();
            $table->tinyInteger('is_staff')->nullable(); //internal suport worker
            $table->date('employ_date')->nullable(); //internal suport worker
            $table->date('induction_date')->nullable(); //internal suport worker
            $table->date('resign_date')->nullable(); //internal suport worker

            //part time
            $table->tinyInteger('part_time')->nullable();
            $table->double('part_time_hrs', 12, 1)->nullable();
            $table->date('part_time_start')->nullable();
            $table->date('part_time_end')->nullable();

            //student
            $table->tinyInteger('sw_student')->nullable();
            $table->double('sw_student_hrs', 12, 1)->nullable();
            $table->date('sw_student_start')->nullable();
            $table->date('sw_student_end')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End support_worker
         */

        /*
        Start Support_worker_type
         */
        Schema::dropIfExists('support_worker_type');
        Schema::create('support_worker_type', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('sw_no')->nullable();
            $table->string('type')->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable(); //internal suport worker
            $table->date('hrs_allocated_per_fortnight')->nullable(); //internal suport worker

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End support_worker_available_time
         */

        /*
        Start support_worker_available_time
         */
        Schema::dropIfExists('support_worker_available_time');
        Schema::create('support_worker_available_time', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->integer('sw_id')->nullable();
            $table->string('sw_no')->nullable();
            $table->string('day')->nullable();
            $table->time('start_time')->nullable();
            $table->time('end_time')->nullable(); //internal suport worker

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End support_worker_available_time
         */

        /*
        Start support_worker_pay_point
         */
        Schema::dropIfExists('support_worker_pay_point');
        Schema::create('support_worker_pay_point', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->integer('sw_id')->nullable();
            $table->string('sw_no')->nullable();
            $table->string('pay_point_id')->nullable(); // need maintenance
            $table->time('start_date')->nullable();
            $table->time('end_date')->nullable(); //internal suport worker

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End support_worker_pay_point
         */

        /*
        Start support_worker_qualification
         */
        Schema::dropIfExists('support_worker_qualification');
        Schema::create('support_worker_qualification', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->integer('sw_id')->nullable();
            $table->string('sw_no')->nullable();
            $table->string('rank')->nullable(); // need maintenance
            $table->string('qualification_id')->nullable();
            $table->string('qualification_title')->nullable();
            $table->date('qualification_date')->nullable(); //internal suport worker
            $table->date('qualification_expiring_date')->nullable(); //internal suport worker
            $table->string('pay_level')->nullable(); //internal suport worker

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End support_worker_qualification
         */

        /*
        Start support_worker_qualification
         */
        Schema::dropIfExists('support_worker_training');
        Schema::create('support_worker_training', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->integer('sw_id')->nullable();
            $table->string('sw_no')->nullable();
            $table->integer('training_id')->nullable(); // need maintenance
            $table->string('training_name')->nullable(); // need maintenance
            $table->date('training_date')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End support_worker_training
         */

        //**************  START Customer ***************** */
        /*
        Start customer
         */
        Schema::dropIfExists('customer');
        Schema::create('customer', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('customer_no')->nullable();
            $table->string('aged_care_user_id')->nullable();
            $table->string('customer_status')->nullable(); //active, inactive
            $table->string('mds_no')->nullable(); //internal suport worker
            $table->string('note')->nullable(); //internal suport worker
            $table->string('note_health_condition')->nullable(); //internal suport worker
            $table->string('note_transport')->nullable(); //internal suport worker

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });

        Schema::dropIfExists('customer_dex');
        Schema::create('customer_dex', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('customer_no')->nullable();
            $table->json('json')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });

        Schema::dropIfExists('customer_mds');
        Schema::create('customer_mds', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('customer_no')->nullable();
            $table->json('json')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });

        /*
        End customer
         */
        //**************  START Agency ***************** */
        /*
        Start Agency
         */
        Schema::dropIfExists('agency');
        Schema::create('agency', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('pp_id')->nullable();
            $table->string('agency_no')->nullable();
            $table->string('agency_name')->nullable();

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
        End Agency
         */

        //**************  START Other Contact ***************** */
        /*
        Start Contact
         */
        Schema::dropIfExists('personal_particular_contact');
        Schema::create('personal_particular_contact', function (Blueprint $table) {
            $table->increments('id');

            //personal info
            $table->integer('contact_no')->nullable();
            $table->string('contact_title')->nullable();
            $table->string('email')->nullable();
            $table->string('title')->nullable();
            $table->string('street_no')->nullable();
            $table->string('street_name')->nullable();
            $table->string('state')->nullable();
            $table->string('postcode')->nullable();
            $table->string('work_phone')->nullable();
            $table->string('mobile_phone')->nullable();
            $table->string('home_phone')->nullable();
            $table->string('fax')->nullable();
            $table->string('website')->nullable();

            $table->string('organization')->nullable();
            $table->string('department')->nullable();
            $table->string('po_box')->nullable();
            $table->string('contact_category')->nullable(); //store as json

            //timestamp
            $table->timestamps();
            $table->integer('created_by')->nullable();
            $table->integer('updated_by')->nullable();
        });
        /*
    End Contact
     */

    }

}
