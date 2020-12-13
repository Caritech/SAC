<template>
    <div class="col-12 row">
        <label class="col-9">{{title}}</label>
        <div class="col-3">
            <verte
                v-model="service.css_background_color"
                picker="square"
                model="rgb"
            ></verte>
        </div>
    </div>
</template>

<script>
    export default{
        props: ["title", "value"],
    }
</script>
