<template>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-2">
                    <img
                        src="/icon/user-icon.png"
                        style="width: 100%"
                    />
                </div>
                <div
                    class="col-md-6"
                    style="
            vertical-align: middle;
            padding-top: 42px;
            padding-bottom: 42px;
          "
                >
                    <h1>

                        {{ contact_user.statutory }} {{ contact_user.name }}
                        <template v-if="contact_user.nickname">({{ contact_user.nickname }})</template>
                    </h1>
                    <p>Be the person that you wish you could have met.</p>
                </div>
                <div
                    class="col-md-4"
                    style="
            vertical-align: middle;
            padding-top: 42px;
            padding-bottom: 42px;
          "
                >
                    <i
                        class="fas fa-edit float-right btn btn-secondary"
                        style="margin-right: 23px"
                        @click="editProfile()"
                    ></i>
                    <i
                        class="fas fa-trash-alt float-right btn btn-danger"
                        style="margin-right: 5px"
                        @click="deleteProfile()"
                    ></i>
                </div>
            </div>
            <div
                class="accordion md-accordion"
                id="accordionEx"
                role="tablist"
                aria-multiselectable="true"
            >
                <div class="card">
                    <div
                        class="card-header"
                        role="tab"
                        id="headingOne1"
                    >
                        <a
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#basic_info"
                            aria-expanded="true"
                            aria-controls="basic_info"
                        >
                            <h5 class="mb-0">BASIC INFO</h5>
                        </a>
                    </div>
                    <div
                        id="basic_info"
                        class="collapse show"
                        role="tabpanel"
                        aria-labelledby="headingOne1"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table profile">
                                    <tbody>
                                        <tr>
                                            <td>Mobile</td>
                                            <td
                                                rowspan="2"
                                                style="vertical-align: middle"
                                                width="5%"
                                            >
                                                <a :href="'tel:' + contact_user.mobile">
                                                    <i class="fas fa-3x fa-phone-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.mobile) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td>Email (Personal)</td>
                                            <td
                                                rowspan="2"
                                                style="vertical-align: middle"
                                                width="5%"
                                            >
                                                <a :href="'mailto:' + contact_user.email">
                                                    <i class="fas fa-3x fa-envelope-square"></i>
                                                </a>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.email) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">NRIC/Passport No.</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.nric_passport) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Date of Birth</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.dob) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Age</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ countAge(contact_user.dob) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Gender</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.gender) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Race</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.race) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Marital Status</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.marital_status) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Nationality</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.nationality_name) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Country of Birth</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.birth_country_name) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Religion</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.religion) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Relationship Status</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.relationship_status) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">How You Know This Person</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.how_you_know) }}
                                                From
                                                {{ checkEmpty(contact_user.how_you_know_from) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Social Media (FB)</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.fb_link) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Social Media (IG)</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.ig_link) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Social Media (LinkedIn)</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.linkedin_link) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Residential Address</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                <div
                                                    v-for="address in contact_user.address"
                                                    :key="address.id"
                                                    class="card mb-2"
                                                >
                                                    {{ address.address_one }}<br />
                                                    {{ address.address_two }}<br />
                                                    {{ address.address_three }}<br />
                                                    {{ address.postcode }}<br />
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- <tr>
                      <td colspan="2">Property Type</td>
                    </tr>
                    <tr>
                      <td class="table-no-border-top text-primary">{{ checkEmpty(contact_user.property_type) }}</td>
                    </tr>
                    <tr>
                      <td colspan="2">Stay Since</td>
                    </tr>
                    <tr>
                      <td class="table-no-border-top text-primary">
                        {{ checkEmpty(contact_user.stay_since_start) }} Till
                        {{ checkEmpty(contact_user.stay_since_end) }}
                      </td>
                    </tr>
                    -->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="card"
                    v-if="contact_user.preference != null"
                >
                    <div
                        class="card-header"
                        role="tab"
                        id="headingTwo2"
                    >
                        <a
                            class="collapsed"
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#preference"
                            aria-expanded="false"
                            aria-controls="preference"
                        >
                            <h5 class="mb-0">PREFERENCE</h5>
                        </a>
                    </div>
                    <div
                        id="preference"
                        class="collapse"
                        role="tabpanel"
                        aria-labelledby="headingTwo2"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table profile">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">Likes</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                           checkEmpty(contact_user.preference.likes.join(', '))
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Dislikes</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(contact_user.preference.dislikes.join(', '))
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Hobbies</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(contact_user.preference.hobby.join(', '))
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Activity of Interest</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.preference.activity_interest.join(', ')
                          )
                        }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div
                        class="card-header"
                        role="tab"
                        id="headingThree3"
                    >
                        <a
                            class="collapsed"
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#financial_status"
                            aria-expanded="false"
                            aria-controls="financial_status"
                        >
                            <h5 class="mb-0">FINANCIAL STATUS</h5>
                        </a>
                    </div>
                    <div
                        id="financial_status"
                        class="collapse"
                        role="tabpanel"
                        aria-labelledby="headingThree3"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table profile">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">Customer Class</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.class_type) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Trust Level</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.trust_level) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Financial Literacy Level</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.financial_literacy_level) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Risk Appetite</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.risk_appetite) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Desired Retirement Age</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.desired_retirement_age) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="card"
                    v-if="contact_user.health != null"
                >
                    <div
                        class="card-header"
                        role="tab"
                        id="headingThree3"
                    >
                        <a
                            class="collapsed"
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#health"
                            aria-expanded="false"
                            aria-controls="health"
                        >
                            <h5 class="mb-0">HEALTH</h5>
                        </a>
                    </div>
                    <div
                        id="health"
                        class="collapse"
                        role="tabpanel"
                        aria-labelledby="headingThree3"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table profile">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">Height</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.health.height) }}cm
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Weight</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.health.weight) }}kg
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Smoker</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.health.smoker) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Medical Condition</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.health.medical_condition.join(', ')
                          )
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Medical History</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.health.medical_history.join(', ')
                          )
                        }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="card"
                    v-if="contact_user.values_beliefs != null"
                >
                    <div
                        class="card-header"
                        role="tab"
                        id="headingThree3"
                    >
                        <a
                            class="collapsed"
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#value_belief"
                            aria-expanded="false"
                            aria-controls="value_belief"
                        >
                            <h5 class="mb-0">VALUES & BELIEFS</h5>
                        </a>
                    </div>
                    <div
                        id="value_belief"
                        class="collapse"
                        role="tabpanel"
                        aria-labelledby="headingThree3"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table profile">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">Belief</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.values_beliefs.belief

                          )
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Value</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.values_beliefs.value
                          )
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Philosophy</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.values_beliefs.philosophy
                          )
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Quote</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.values_beliefs.quote
                          )
                        }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="card"
                    v-if="contact_user.achievement != null"
                >
                    <div
                        class="card-header"
                        role="tab"
                        id="headingThree3"
                    >
                        <a
                            class="collapsed"
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#achievements"
                            aria-expanded="false"
                            aria-controls="value_belief"
                        >
                            <h5 class="mb-0">ACHIEVEMENT</h5>
                        </a>
                    </div>
                    <div
                        id="achievements"
                        class="collapse"
                        role="tabpanel"
                        aria-labelledby="headingThree3"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table profile">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">Achievements</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.achievement.achievement.join(', ')
                          )
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Awards Won</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.achievement.award_won.join(', ')
                          )
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Special Appointment</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.achievement.special_appointment.join(', ')
                          )
                        }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="card"
                    v-if="contact_user.education != null"
                >
                    <div
                        class="card-header"
                        role="tab"
                        id="headingThree3"
                    >
                        <a
                            class="collapsed"
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#education_background"
                            aria-expanded="false"
                            aria-controls="education_background"
                        >
                            <h5 class="mb-0">EDUCATION BACKGROUND</h5>
                        </a>
                    </div>
                    <div
                        id="education_background"
                        class="collapse"
                        role="tabpanel"
                        aria-labelledby="headingThree3"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table profile">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">Education Level</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.education.education_level) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Other Qualification</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.education.other_qualification.join(', ')
                          )
                        }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">School/College/Uni</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{
                          checkEmpty(
                            contact_user.education.education_type.join(', ')
                          )
                        }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="card"
                    v-if="contact_user.family != null"
                >
                    <div
                        class="card-header"
                        role="tab"
                        id="headingThree3"
                    >
                        <a
                            class="collapsed"
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#family_information"
                            aria-expanded="false"
                            aria-controls="family_information"
                        >
                            <h5 class="mb-0">FAMILY INFORMATION</h5>
                        </a>
                    </div>
                    <div
                        id="family_information"
                        class="collapse"
                        role="tabpanel"
                        aria-labelledby="headingThree3"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table profile">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">Spouse</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.family.spouse.join(', ')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Anniversary Date</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.family.anniversary_date) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Child/Children</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.family.child.join(', ')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Siblings</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.family.sibling.join(', ')) }}
                                            </td>
                                        </tr>
                                        <tr>
                                            <td colspan="2">Parents</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                {{ checkEmpty(contact_user.family.parent.join(', ')) }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div
                    class="card"
                    v-if="contact_user.company != null"
                >
                    <div
                        class="card-header"
                        role="tab"
                        id="headingThree3"
                    >
                        <a
                            class="collapsed"
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#work_information"
                            aria-expanded="false"
                            aria-controls="work_information"
                        >
                            <h5 class="mb-0">WORK INFORMATION</h5>
                        </a>
                    </div>
                    <div
                        id="work_information"
                        class="collapse"
                        role="tabpanel"
                        aria-labelledby="headingThree3"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <!-- loop comapyn-->
                            <b-tabs content-class="mt-3">
                                <div
                                    v-for="(company, company_index) in contact_user.company"
                                    :key="'COMP'+company_index"
                                >
                                    <b-tab :title="'#' + company_index">
                                        <div class="table-responsive">
                                            <table class="table profile">
                                                <tbody>
                                                    <tr>
                                                        <td colspan="2">Occupation</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ checkEmpty(company.occupation) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Occupation Quadrant</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ checkEmpty(company.occupation_quadrant) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Nature of Business</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ checkEmpty(company.nature_of_business) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Sector</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ checkEmpty(company.sector) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Monthly Income</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ checkEmpty(company.monthly_income) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">EPF Contribution</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            Self -
                                                            {{ checkEmpty(company.epf_self) }}
                                                            <br />
                                                            Employer -
                                                            {{ checkEmpty(company.epf_employer) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Company Name</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ checkEmpty(company.company_name) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Work Address</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ company.company_addredd_one }}<br />
                                                            {{ company.company_address_two }}<br />
                                                            {{ company.company_address_three }}<br />
                                                            {{ company.company_postcode }}<br />
                                                            {{ company.company_town }}<br />
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Phone No. (Work)</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ checkEmpty(company.company_phone_no) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Email (Work)</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ checkEmpty(company.company_email) }}
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">Work Since</td>
                                                    </tr>
                                                    <tr>
                                                        <td class="table-no-border-top text-primary">
                                                            {{ checkEmpty(company.work_start) }}
                                                            till
                                                            {{ checkEmpty(company.work_end) }}
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </b-tab>
                                </div>
                            </b-tabs>
                        </div>
                    </div>
                </div>
                <div
                    class="card"
                    v-if="contact_user.notes != null"
                >
                    <div
                        class="card-header"
                        role="tab"
                        id="headingThree3"
                    >
                        <a
                            class="collapsed"
                            data-toggle="collapse"
                            data-parent="#accordionEx"
                            href="#meeting"
                            aria-expanded="false"
                            aria-controls="meeting"
                        >
                            <h5 class="mb-0">MEETING REMARKS</h5>
                        </a>
                    </div>
                    <div
                        id="meeting"
                        class="collapse"
                        role="tabpanel"
                        aria-labelledby="headingThree3"
                        data-parent="#accordionEx"
                    >
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table profile">
                                    <tbody>
                                        <tr>
                                            <td colspan="2">Notes</td>
                                        </tr>
                                        <tr>
                                            <td class="table-no-border-top text-primary">
                                                <b-card
                                                    v-for="(notes,note_index) in contact_user.notes.notes"
                                                    :key="'note_'+note_index"
                                                    class="mb-2"
                                                >
                                                    {{ notes }}
                                                </b-card>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    data() {
        return {
            id: "",
            contact_user: {},
        }
    },
    methods: {
        checkEmpty(val) {
            if (!val) {
                val = "-"
            }
            return val
        },
        getProfileDetails() {
            axios
                .get("/vlife/get_contact_profile_data/" + this.id)
                .then((response) => {
                    this.contact_user = response.data
                })
        },
        countAge(dob) {
            if (dob != null) {
                dob = new Date(dob)
                var today = new Date()
                var age = Math.floor(
                    (today - dob) / (365.25 * 24 * 60 * 60 * 1000)
                )
                return age
            }
            return "-"
        },
        editProfile() {
            this.$router.push("/my_contact/profile/" + this.id + "/edit")
        },
        deleteProfile() {
            var vm = this
            vm.id = vm.$route.params.id
            Vue.swal({
                title: "Are you sure?",
                text: "It will be inactive this profile!",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes",
                showLoaderOnConfirm: true,

                preConfirm: function () {
                    return new Promise(function (resolve) {
                        axios
                            .post("/vlife/my_contact/profile/inactive", {
                                id: vm.id,
                            })
                            .then((response) => {
                                /*swal('Event Status Updated!', response.message, response.status);*/

                                Vue.swal(
                                    response.data.title,
                                    response.data.message,
                                    response.data.status
                                )
                                setTimeout(function () {
                                    window.location.replace("/vlife/my_contact")
                                }, 2000)
                            })
                    })
                },
                allowOutsideClick: false,
            })
        },
        /*async init() {
            await this.getProfileDetails();
        },*/
    },
    created() {
        this.id = this.$route.params.id
        axios
            .get("/vlife/get_contact_profile_data/" + this.id)
            .then((response) => {
                this.contact_user = response.data
            })
    },
}
</script>
