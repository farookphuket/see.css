<template>
    <div class="container">
        <p class="title">this is admin page</p>
        <whatup></whatup>
    </div>
</template>
<script>
import Whatup from './Whatup/Whatup.vue'

export default{
    name:"AdminDashboard",
    components:{
        Whatup,
    },

}
</script>
