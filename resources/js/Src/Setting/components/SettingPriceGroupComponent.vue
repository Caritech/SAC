<template v-for="(g, k) in price_plan_group_by_id">
    <div :key="k" class="card mt-4">
        <div class="card-header card-header-sm">
            {{ g.group_name }} [{{ g.id }}]
            <span class="float-right">
                <Button class="btn btn-sm btn-primary " type="button"
                    >Edit</Button
                >
                <Button class="btn btn-sm btn-primary " type="button"
                    >Add Item</Button
                >
            </span>
        </div>
        <div class="card-body">
            <input type="checkbox" />Daily
            <small
                >user need to provide detail data in every day of a week</small
            >
            <div class="row">
                <table class="table table-bordered table-hover">
                    <thead>
                        <tr>
                            <th class="fit">Option</th>
                            <th style="width:200px">Item Name</th>
                            <th style="width:150px">Inc / Exp</th>
                            <th style="width:150px">Input Type</th>
                            <th style="width:80px">Level 1</th>
                            <th style="width:80px">Level 2</th>
                            <th style="width:80px">Level 3</th>
                            <th style="width:80px">Level 4</th>
                            <th>More</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template v-for="(item, k2) in g.item">
                            <tr :key="k2">
                                <td>
                                    <Button
                                        type="button"
                                        class="btn btn-sm btn-danger"
                                        ><i class="fa fa-trash"></i
                                    ></Button>
                                </td>
                                <td>
                                    <input
                                        type="text"
                                        class="form-control"
                                        v-model="item.title"
                                    />
                                </td>
                                <td>
                                    <v2-select
                                        :options="lists_item_type"
                                        v-model="item.type"
                                    ></v2-select>
                                </td>
                                <td>
                                    <v2-select
                                        :options="lists_item_input_type"
                                        v-model="item.input_type"
                                    ></v2-select>
                                </td>
                                <template v-for="(lv, k3) in [1, 2, 3, 4]">
                                    <td :key="k3">
                                        <div class="input-group">
                                            <span
                                                class="input-group-addon"
                                                id="basic-addon1"
                                            >
                                                <i
                                                    v-if="
                                                        item.input_type ==
                                                            'percentage'
                                                    "
                                                    class="fa fa-percent"
                                                ></i>
                                                <i
                                                    v-else-if="
                                                        item.input_type ==
                                                            'checkbox'
                                                    "
                                                    class="fa fa-check-square-o"
                                                ></i>
                                                <i
                                                    v-else-if="
                                                        item.input_type ==
                                                            'fixed'
                                                    "
                                                    class="fa fa-tag"
                                                ></i>
                                                <i
                                                    v-else-if="
                                                        item.input_type ==
                                                            'user_enter'
                                                    "
                                                    class="fa fa-pencil"
                                                ></i>
                                                <i
                                                    v-else
                                                    class="fa fa-question"
                                                ></i>
                                            </span>
                                            <input
                                                type="text"
                                                class="form-control text-right"
                                                v-model="item['level' + k]"
                                            />
                                        </div>
                                    </td>
                                </template>
                                <td>
                                    <template
                                        v-if="item.input_type == 'percentage'"
                                    >
                                        Refer to Group
                                        <v2-select
                                            :options="plan_groups"
                                            v-model="item.refer_group_id"
                                        ></v2-select>
                                    </template>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            <Button type="button" class="btn btn-sm btn-success"
                >Save This</Button
            >
        </div>
    </div>
</template>
