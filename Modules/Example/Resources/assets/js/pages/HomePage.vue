<template>
    <div>
        <example-component></example-component>
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
