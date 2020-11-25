<template>
    <div>
        <h4>Contact Information Home</h4>
        <div class="col-md-12 row">
            <template v-for="(l,k) in lists_action">
                <div class="col-md-2 col-sm-6" :key="k">
                    <div class="card">
                        <div class="card-body text-center bg-danger">
                            <i :class="l.icon" class="text-white"></i>
                            <div class="divider"></div>
                            <router-link :to="l.url" class="btn btn-block btn-light">{{l.text}}</router-link>
                        </div>
                    </div>
                </div>
            </template>
        </div>
    </div>
</template>

<script>
    export default {
        data(){
            return {
                lists_action: [
                    {
                        'text':'All',
                        'url': '/all_contact',
                        'icon': 'fa fa-5x fa-users'
                    },
                    {
                        'text':'Worker',
                        'url': '/worker',
                        'icon': 'fa fa-5x fa-user-nurse'
                    },
                    {
                        'text':'Client',
                        'url': '/client',
                        'icon': 'fa fa-5x fa-house-user'
                    }

                ]
            }
        }
    }
</script>
