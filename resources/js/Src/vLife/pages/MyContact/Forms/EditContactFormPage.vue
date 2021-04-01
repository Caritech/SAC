<template>
    <div class="profile">
        <h3>Edit Profile</h3>
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
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <label>Name :</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_data.name"
                                />
                            </div>
                            <div class="col-md-4">
                                <label>Nickname :</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_data.nickname"
                                />
                            </div>
                            <div class="col-md-4">
                                <label>Email :</label>
                                <input
                                    type="email"
                                    class="form-control"
                                    v-model="contact_data.email"
                                />
                            </div>
                        </div>
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <label>Mobile :</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_data.mobile"
                                />
                            </div>
                            <div class="col-md-4">
                                <label>NRIC/Passport No. :</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_data.nric_passport"
                                />
                            </div>
                            <div class="col-md-4">
                                <label>Date of Birth :</label>
                                <date-picker v-model="contact_data.dob"></date-picker>
                            </div>
                        </div>
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <label>Gender :</label>
                                <my-select
                                    size="sm"
                                    :items="gender_options"
                                    v-model="contact_data.gender"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                            <div class="col-md-4">
                                <label>Race :</label>
                                <my-select
                                    size="sm"
                                    :items="race_options"
                                    v-model="contact_data.race"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                            <div class="col-md-4">
                                <label>Marital Status :</label>
                                <my-select
                                    size="sm"
                                    :items="marital_options"
                                    v-model="contact_data.marital_status"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                        </div>
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <label>Nationality :</label>
                                <my-select
                                    size="sm"
                                    :items="nationality_options"
                                    v-model="contact_data.nationality_id"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                            <div class="col-md-4">
                                <label>Country of Birth :</label>
                                <my-select
                                    size="sm"
                                    :items="country_options"
                                    v-model="contact_data.birth_country_id"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>religion_options
                            <div class="col-md-4">
                                <label>Religion :</label>
                                <my-select
                                    size="sm"
                                    :items="religion_options"
                                    v-model="contact_data.religion"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>

                            </div>
                        </div>
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <label>Relationship Status :</label>
                                <my-select
                                    size="sm"
                                    :items="relationship_status_options"
                                    v-model="contact_data.relationship_status"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                            <div class="col-md-8">
                                <label>How You Know This Person :</label>
                                <table style="width: 100%">
                                    <tr>
                                        <td>
                                            <my-select
                                                size="sm"
                                                :items="how_you_know_options"
                                                v-model="contact_data.how_you_know"
                                                itemText="text"
                                                itemValue="value"
                                            ></my-select>
                                        </td>
                                        <td>From</td>
                                        <td>
                                            <input
                                                type="text"
                                                class="form-control"
                                                v-model="contact_data.how_you_know_from"
                                            />
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <label>Social Media (FB) :</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_data.fb_link"
                                />
                            </div>
                            <div class="col-md-4">
                                <label>Social Media (IG) :</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_data.ig_link"
                                />
                            </div>
                            <div class="col-md-4">
                                <label>Social Media (LinkedIn) :</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_data.linkedin_link"
                                />
                            </div>
                        </div>

                        <b-card title="">
                            <b-row class="mb-2">
                                <b-col v-b-toggle.contact-address-container>
                                    <h4 class="link">
                                        Address ({{ contact_data.address.length }})
                                    </h4>
                                </b-col>
                                <b-col class="text-right">
                                    <button
                                        class="btn btn-primary"
                                        @click="addAddress"
                                    >
                                        Add New Address
                                    </button>
                                </b-col>
                            </b-row>
                            <b-collapse id="contact-address-container">
                                <div
                                    v-for="(address, address_index) in contact_data.address"
                                    class="card mb-2"
                                >
                                    <div class="card-header">
                                        <a
                                            data-toggle="collapse"
                                            :data-parent="'resident_address' + address_index"
                                            href="#resident_address_one"
                                            aria-expanded="true"
                                            aria-controls="resident_address_one"
                                        >
                                            <h5 class="mb-0">
                                                Resident Address
                                                {{ address_index + 1 }}
                                                <i
                                                    class="fas fa-trash-alt float-right btn btn-danger"
                                                    style="margin-right: 5px"
                                                    @click="
                            deleteRow('address', address_index, address.id)
                          "
                                                ></i>
                                            </h5>
                                        </a>
                                    </div>
                                    <div
                                        id="resident_address_one"
                                        class="collapse show"
                                        data-parent="#resident_address"
                                    >
                                        <div class="card-body">
                                            <div class="row form-group form-group-sm">
                                                <div class="col-md-4">
                                                    <label>Residential Address Line One :</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="address.address_one"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Residential Address Line Two :</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="address.address_two"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Residential Address Line Three :</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="address.address_three"
                                                    />
                                                </div>
                                            </div>
                                            <div class="row form-group form-group-sm">
                                                <div class="col-md-4">
                                                    <label>Postcode :</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="address.postcode"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Town :</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="address.town"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Country :</label>
                                                    <my-select
                                                        size="sm"
                                                        :items="country_options"
                                                        v-model="address.country_id"
                                                        itemText="text"
                                                        itemValue="value"
                                                    ></my-select>
                                                </div>
                                            </div>
                                            <div class="row form-group form-group-sm">
                                                <div class="col-md-4">
                                                    <label>State :</label>
                                                    <my-select
                                                        v-if="address.country_id != null"
                                                        :items="state_options[address.country_id]"
                                                        v-model="address.state_id"
                                                    ></my-select>

                                                    <span
                                                        class="row col-12"
                                                        v-else
                                                    >Select Country First</span>
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Property Type :</label>
                                                    <input
                                                        type="text"
                                                        class="form-control"
                                                        v-model="address.property_type"
                                                    />
                                                </div>
                                                <div class="col-md-4">
                                                    <label>Stay Since :</label>
                                                    <table style="width: 100%">
                                                        <tr>
                                                            <td>
                                                                <date-picker v-model="address.stay_since_start"></date-picker>
                                                            </td>
                                                            <td>Till</td>
                                                            <td>
                                                                <date-picker v-model="address.stay_since_end"></date-picker>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </b-collapse>
                        </b-card>
                    </div>
                </div>
            </div>
            <!-- Preference -->
            <div class="card">
                <div class="card-header">
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
                        <div class="row form-group form-group-sm">
                            <div class="col-md-3 border-right">
                                <h4>Likes</h4>
                                <my-multiple-input :value="contact_data.preference.likes"></my-multiple-input>
                            </div>
                            <div class="col-md-3">
                                <h4>Dislikes</h4>
                                <my-multiple-input :value="contact_data.preference.dislikes"></my-multiple-input>
                            </div>
                            <div class="col-md-3">
                                <h4>Hobbies</h4>
                                <my-multiple-input :value="contact_data.preference.hobby"></my-multiple-input>
                            </div>
                            <div class="col-md-3">
                                <h4>Activity Of Interest</h4>
                                <my-multiple-input :value="contact_data.preference.activity_interest"></my-multiple-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Financail Status-->
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
                        <div class="row form-group form-group-sm with-notes">
                            <div class="col-md-4">
                                <label>Customer Class :</label>
                                <my-select
                                    size="sm"
                                    :items="class_type_options"
                                    v-model="contact_data.class_type"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                            <div class="col-md-4">
                                <label>Trust Level :</label>
                                <my-select
                                    size="sm"
                                    :items="one_to_ten_options"
                                    v-model="contact_data.trust_level"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                                <small>0 - Lowest, 10 - highest</small>
                            </div>
                            <div class="col-md-4">
                                <label>Financial Literacy Level :</label>
                                <my-select
                                    size="sm"
                                    :items="one_to_ten_options"
                                    v-model="contact_data.financial_literacy_level"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                                <small>0 - Lowest, 10 - highest</small>
                            </div>
                        </div>
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <label>Risk Appetite :</label>
                                <my-select
                                    size="sm"
                                    :items="risk_appetite_options"
                                    v-model="contact_data.risk_appetite"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                            <div class="col-md-4">
                                <label>Desired Retirement Age :</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    step="1"
                                    v-model="contact_data.desired_retirement_age"
                                />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Health-->
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
                        href="#health"
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
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <label>Height (CM) :</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    step="1"
                                    v-model="contact_data.health.height"
                                />
                            </div>
                            <div class="col-md-4">
                                <label>Weight (kg) :</label>
                                <input
                                    type="number"
                                    class="form-control"
                                    min="0"
                                    step="1"
                                    v-model="contact_data.health.weight"
                                />
                            </div>
                            <div class="col-md-4">
                                <label>Smoker :</label>
                                <my-select
                                    size="sm"
                                    :items="yes_no_options"
                                    v-model="contact_data.health.smoker"
                                    itemText="text"
                                    itemValue="value"
                                ></my-select>
                            </div>
                        </div>
                        <div class="row form-group form-group-sm">
                            <div class="col-md-6">
                                <h4>Medical Condition :</h4>
                                <my-multiple-input :value="contact_data.health.medical_condition"></my-multiple-input>
                            </div>
                            <div class="col-md-6">
                                <h4>Medical History :</h4>
                                <my-multiple-input :value="contact_data.health.medical_history"></my-multiple-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Value and belief-->
            <div class="card">
                <div
                    class="card-header"
                    role="tab"
                    id="headingTwo2"
                >
                    <a
                        class="collapsed"
                        data-toggle="collapse"
                        data-parent="#accordionEx"
                        href="#values_beliefs"
                        aria-expanded="false"
                        aria-controls="values_beliefs"
                    >
                        <h5 class="mb-0">VALUES & BELIEFS</h5>
                    </a>
                </div>
                <div
                    id="values_beliefs"
                    class="collapse"
                    role="tabpanel"
                    aria-labelledby="headingTwo2"
                    data-parent="#accordionEx"
                >
                    <div class="card-body">
                        <div class="row form-group form-group-sm">
                            <div class="col-md-3">
                                <h4>Belief :</h4>
                                <my-multiple-input :value="contact_data.values_beliefs.belief"></my-multiple-input>
                            </div>
                            <div class="col-md-3">
                                <h4>Values :</h4>
                                <my-multiple-input :value="contact_data.values_beliefs.value"></my-multiple-input>
                            </div>
                            <div class="col-md-3">
                                <h4>Philosophy :</h4>
                                <my-multiple-input :value="contact_data.values_beliefs.philosophy"></my-multiple-input>
                            </div>
                            <div class="col-md-3">
                                <h4>Quote :</h4>
                                <my-multiple-input :value="contact_data.values_beliefs.quote"></my-multiple-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Acehivement-->
            <div class="card">
                <div
                    class="card-header"
                    role="tab"
                    id="headingTwo2"
                >
                    <a
                        class="collapsed"
                        data-toggle="collapse"
                        data-parent="#accordionEx"
                        href="#achievement"
                        aria-expanded="false"
                        aria-controls="achievement"
                    >
                        <h5 class="mb-0">ACHIEVEMENT</h5>
                    </a>
                </div>
                <div
                    id="achievement"
                    class="collapse"
                    role="tabpanel"
                    aria-labelledby="headingTwo2"
                    data-parent="#accordionEx"
                >
                    <div class="card-body">
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <h4>Achievements :</h4>
                                <my-multiple-input :value="contact_data.achievement.achievement"></my-multiple-input>
                            </div>
                            <div class="col-md-4">
                                <h4>Award Won :</h4>
                                <my-multiple-input :value="contact_data.achievement.award_won"></my-multiple-input>
                            </div>
                            <div class="col-md-4">
                                <h4>Special Appointment :</h4>
                                <my-multiple-input :value="contact_data.achievement.special_appointment"></my-multiple-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--education-->
            <div class="card">
                <div
                    class="card-header"
                    role="tab"
                    id="headingTwo2"
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
                    aria-labelledby="headingTwo2"
                    data-parent="#accordionEx"
                >
                    <div class="card-body">
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <label>Education Level :</label>
                                <input
                                    type="text"
                                    class="form-control"
                                    v-model="contact_data.education.education_level"
                                />
                            </div>
                            <div class="col-md-4">
                                <h4>Other Qualification :</h4>
                                <my-multiple-input :value="contact_data.education.other_qualification"></my-multiple-input>
                            </div>
                            <div class="col-md-4">
                                <h4>School/College/Uni :</h4>
                                <my-multiple-input :value="contact_data.education.education_type"></my-multiple-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!--famil-->
            <div class="card">
                <div
                    class="card-header"
                    role="tab"
                    id="headingTwo2"
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
                    aria-labelledby="headingTwo2"
                    data-parent="#accordionEx"
                >
                    <div class="card-body">
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <h4>Spouse:</h4>
                                <my-multiple-input :value="contact_data.family.spouse"></my-multiple-input>
                            </div>
                            <div class="col-md-4">
                                <label>Anniversary Date :</label>
                                <my-datepicker v-model="contact_data.family.anniversary_date" />
                            </div>
                        </div>
                        <div class="row form-group form-group-sm">
                            <div class="col-md-4">
                                <h4>Children :</h4>
                                <my-multiple-input :value="contact_data.family.child"></my-multiple-input>
                            </div>
                            <div class="col-md-4">
                                <h4>Sibling :</h4>
                                <my-multiple-input :value="contact_data.family.sibling"></my-multiple-input>
                            </div>
                            <div class="col-md-4">
                                <h4>Parent :</h4>
                                <my-multiple-input :value="contact_data.family.parent"></my-multiple-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Work -->
            <div class="card">
                <div
                    class="card-header"
                    role="tab"
                    id="headingTwo2"
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
                    aria-labelledby="headingTwo2"
                    data-parent="#accordionEx"
                >
                    <div class="card-body">
                        <div
                            class="accordion md-accordion"
                            id="company"
                            role="tablist"
                            aria-multiselectable="true"
                        >
                            <b-row class="mb-2">
                                <b-col>
                                    <button
                                        class="btn btn-primary"
                                        @click="addCompany"
                                    >
                                        Add Company
                                    </button>
                                </b-col>
                            </b-row>

                            <div
                                class="card"
                                v-for="(company, company_index) in contact_data.company"
                            >
                                <div
                                    class="card-header"
                                    role="tab"
                                    id="headingOne1"
                                >
                                    <a
                                        data-toggle="collapse"
                                        data-parent="#company"
                                        :href="'#company_' + company_index"
                                    >
                                        <h5 class="mb-0">
                                            Company {{ company_index + 1 }}
                                            <i
                                                class="fas fa-trash-alt float-right btn btn-danger"
                                                style="margin-right: 5px"
                                                @click="deleteRow('company', company_index, company.id)"
                                            ></i>
                                        </h5>
                                    </a>
                                </div>
                                <div
                                    :id="'company_' + company_index"
                                    class="collapse show"
                                    role="tabpanel"
                                    aria-labelledby="headingOne1"
                                    data-parent="#company"
                                >
                                    <div class="card-body">
                                        <div class="row form-group form-group-sm">
                                            <div class="col-md-4">
                                                <label>Occupation :</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.occupation"
                                                />
                                            </div>
                                            <div class="col-md-4">
                                                <label>Occupation Quadrant :</label>
                                                <my-select
                                                    :items="occupation_quadrant_options"
                                                    v-model="company.occupation_quadrant"
                                                ></my-select>
                                            </div>
                                            <div class="col-md-4">
                                                <label>Nature of Business :</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.nature_of_business"
                                                />
                                            </div>
                                        </div>
                                        <div class="row form-group form-group-sm">
                                            <div class="col-md-3">
                                                <label>Sector :</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.sector"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>Monthly Income :</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.monthly_income"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>EPF Contribution (Self):</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.epf_self"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>EPF Contribution (Employer):</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.epf_employer"
                                                />
                                            </div>
                                        </div>
                                        <div class="row form-group form-group-sm">
                                            <div class="col-md-3">
                                                <label>Company Name:</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.company_name"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>Work Address Line One:</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.company_address_one"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>Work Address Line Two:</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.company_address_two"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>Work Address Line Three:</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.company_address_three"
                                                />
                                            </div>
                                        </div>
                                        <div class="row form-group form-group-sm">
                                            <div class="col-md-3">
                                                <label>Postcode:</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.company_postcode"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>Town:</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.company_town"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>Country:</label>
                                                <my-select
                                                    size="sm"
                                                    :items="country_options"
                                                    v-model="company.company_country_id"
                                                    itemText="text"
                                                    itemValue="value"
                                                ></my-select>
                                            </div>
                                            <div class="col-md-3">
                                                <label>State:</label>
                                                <my-select
                                                    size="sm"
                                                    :items="state_options[company.company_country_id]"
                                                    v-model="company.company_state_id"
                                                    itemText="text"
                                                    itemValue="value"
                                                ></my-select>
                                            </div>
                                        </div>
                                        <div class="row form-group form-group-sm">
                                            <div class="col-md-3">
                                                <label>Phone No. (Work):</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.company_phone_no"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>Email (Work):</label>
                                                <input
                                                    type="text"
                                                    class="form-control"
                                                    v-model="company.company_email"
                                                />
                                            </div>
                                            <div class="col-md-3">
                                                <label>Work Since:</label>
                                                <table style="width: 100%">
                                                    <tr>
                                                        <td>
                                                            <date-picker v-model="company.work_start"></date-picker>
                                                        </td>
                                                        <td>Till</td>
                                                        <td>
                                                            <date-picker v-model="company.work_end"></date-picker>
                                                        </td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- NOTES-->
            <div class="card">
                <div
                    class="card-header"
                    role="tab"
                    id="headingOne1"
                >
                    <a
                        data-toggle="collapse"
                        data-parent="#accordionEx"
                        href="#meeting_remarks"
                        aria-expanded="true"
                        aria-controls="meeting_remarks"
                    >
                        <h5 class="mb-0">MEETING REMARKS</h5>
                    </a>
                </div>
                <div
                    id="meeting_remarks"
                    class="collapse"
                    role="tabpanel"
                    aria-labelledby="headingOne1"
                    data-parent="#accordionEx"
                >
                    <div class="card-body">
                        <div class="row form-group form-group-sm">
                            <div class="col-md-12">
                                <h4>Notes</h4>

                                <my-multiple-input :value="contact_data.notes.notes"></my-multiple-input>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--<fab
            position="bottom-right"
            bg-color="#0275b8"
            :actions="fabActions"
            @save="save"
            icon-size="big"
            main-tooltip="More Actions"
        ></fab>-->

        <div class="profile-floating-btn-sc">
            <b-button @click="save"><i class="md-24 material-icons">save</i></b-button>
        </div>
        <!--<div class="profile-floating-btn-sc">
        <button type="button" class="profile-floating-btn" @save="save">
            <i class="md-24 material-icons">save</i>
        </button>
    </div>-->
    </div>
</template>

<script>
export default {
    data() {
        return {
            fabActions: [
                {
                    color: "#43a047",
                    name: "save",
                    icon: "save",
                    tooltip: "Save Contact Info",
                },
            ],
            //START OF LISTS
            gender_options: [],
            marital_options: [],
            class_type_options: [],
            race_options: [],
            nationality_options: [],
            country_options: [],
            state_options: [],
            religion_options: [],
            relationship_status_options: [],
            how_you_know_options: [],
            one_to_ten_options: [],
            risk_appetite_options: [],
            yes_no_options: [],
            medical_conditions_options: [],
            occupation_quadrant_options: [],
            //END OF LISTS
            contact_data: {},
        }
    },

    methods: {
        save: function () {
            axios
                .post("/vlife/my_contact/profile/save", {
                    contact_data: this.contact_data,
                })
                .then((response) => {
                    var data = response.data
                    if (data.errors != null) {
                        Vue.swal(
                            "Validation Error",
                            data.error_message,
                            "error"
                        )
                    } else {
                        Vue.swal("Success", "Record has been saved", "success")
                        //refersh psage
                        this.$router.replace(
                            "/my_contact/" + data + "/edit/profile"
                        )
                    }
                })
        },

        initMulitpleInput() {
            //Value to init
            let arr_init = {
                preference: ["likes", "dislikes", "hobby", "activity_interest"],
                values_beliefs: ["belief", "value", "philosophy", "quote"],
                achievement: [
                    "achievement",
                    "award_won",
                    "special_appointment",
                ],
                education: ["other_qualification", "education_type"],
                family: ["spouse", "child", "sibling", "parent"],
                health: ["medical_history", "medical_condition"],
                notes: ["notes"],
            }

            for (let key in arr_init) {
                let val_to_init = arr_init[key]
                if (this.contact_data[key] == null) {
                    this.$set(this.contact_data, key, {})
                }
                for (let val_key in val_to_init) {
                    let col_name = val_to_init[val_key]
                    if (this.contact_data[key][col_name] == null) {
                        this.$set(this.contact_data[key], col_name, [])
                    }
                }
            }
        },

        //Get All Lists First
        async init() {
            var $vm = this
            await axios
                .get("/vlife/get_nationality_option/")
                .then((response) => {
                    var res = response.data
                    $vm.nationality_options = res
                })

            await axios.get("/vlife/get_country_option/").then((response) => {
                var res = response.data
                $vm.country_options = res
            })

            await axios.get("/vlife/get_state_option/").then((response) => {
                var res = response.data
                $vm.state_options = res
            })

            if (this.$route.params.contact_id) {
                await axios
                    .get(
                        "/vlife/get_contact_profile_data/" +
                            this.$route.params.contact_id
                    )
                    .then((res) => {
                        var data = res.data

                        for (let key in data) {
                            Vue.set(this.contact_data, key, data[key])
                        }

                        this.initMulitpleInput()
                        this.isLoaded = true
                    })
            }

            return true
        },

        addAddress() {
            this.contact_data.address.push({})
        },
        addCompany() {
            this.contact_data.company.push({})
        },
        deleteRow(name, index, id) {
            this.contact_data[name].splice(index, 1)
            this.contact_data.deleted_data.push({
                id: id,
                name: name,
            })
        },
    },
    created: function () {
        this.init()

        this.contact_data.deleted_data = []

        this.gender_options = [
            {
                value: "Male",
                text: "Male",
            },
            {
                value: "Female",
                text: "Female",
            },
        ]
        this.marital_options = [
            {
                value: "Single",
                text: "Single",
            },
            {
                value: "Married",
                text: "Married",
            },
            {
                value: "Widow",
                text: "Widow",
            },
            {
                value: "Divorced",
                text: "Divorced",
            },
            {
                value: "Other",
                text: "Other",
            },
        ]
        this.race_options = [
            {
                value: "Chinese",
                text: "Chinese",
            },
            {
                value: "Malay",
                text: "Malay",
            },
            {
                value: "Indian",
                text: "Indian",
            },
            {
                value: "Others",
                text: "Others",
            },
        ]
        this.class_type_options = [
            {
                value: "A",
                text: "A",
            },
            {
                value: "B",
                text: "B",
            },
            {
                value: "C",
                text: "C",
            },
            {
                value: "F",
                text: "F",
            },
        ]
        this.relationship_status_options = [
            {
                value: "Acquaintance",
                text: "Acquaintance",
            },
            {
                value: "Friend",
                text: "Friend",
            },
            {
                value: "Prospect Customer",
                text: "Prospect Customer",
            },
            {
                value: "Prospect Recruit",
                text: "Prospect Recruit",
            },
            {
                value: "Customer",
                text: "Customer",
            },
            {
                value: "Partner",
                text: "Partner",
            },
            {
                value: "Competitor",
                text: "Competitor",
            },
        ]
        this.how_you_know_options = [
            {
                value: "Cold Call",
                text: "Cold Call",
            },
            {
                value: "Event",
                text: "Event",
            },
            {
                value: "Referral",
                text: "Referral",
            },
        ]
        this.religion_options = [
            {
                value: "Buddhism",
                text: "Buddhism",
            },
            {
                value: "Christian",
                text: "Christian",
            },
            {
                value: "Free-Thinker",
                text: "Free-Thinker",
            },
            {
                value: "Muslim",
                text: "Muslim",
            },
            {
                value: "Other",
                text: "Other",
            },
        ]

        for (var i = 0; i <= 10; i++) {
            this.$set(this.one_to_ten_options, i, {
                value: i,
                text: i,
            })
        }

        this.risk_appetite_options = [
            {
                value: "Very Secure",
                text: "Very Secure",
            },
            {
                value: "Secure",
                text: "Secure",
            },
            {
                value: "Medium",
                text: "Medium",
            },
            {
                value: "High",
                text: "High",
            },
            {
                value: "Very High",
                text: "Very High",
            },
        ]
        this.yes_no_options = [
            {
                value: "Yes",
                text: "Yes",
            },
            {
                value: "No",
                text: "No",
            },
        ]
        this.medical_conditions_options = [
            {
                value: "Diabetes",
                text: "Diabetes",
            },
            {
                value: "Dialysis",
                text: "Dialysis",
            },
            {
                value: "Hypertension",
                text: "Hypertension",
            },
            {
                value: "CI Survivor",
                text: "CI Survivor",
            },
        ]
        this.occupation_quadrant_options = [
            {
                value: "Employed",
                text: "Employed",
            },
            {
                value: "Self-Employed/Professional",
                text: "Self-Employed/Professional",
            },
            {
                value: "Business",
                text: "Business",
            },
            {
                value: "Investor",
                text: "Investor",
            },
            {
                value: "Retiree",
                text: "Retiree",
            },
            {
                value: "Unemployed",
                text: "Unemployed",
            },
            {
                value: "Other",
                text: "Other",
            },
        ]
    },
    mounted() {},
}
</script>

<style>
.accordion > .card {
    overflow: visible !important;
}
</style>
