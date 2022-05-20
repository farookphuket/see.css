<template>
    <div class="container">
        <p class="title">will show  {{msg}}</p>
        <whatup></whatup>
    </div>
</template>

<script>
import {ref} from 'vue'
import Whatup from './Whatup.vue'
export default{
    name:"Home",
    components:{
        Whatup,
    },
    setup(){
        const msg = ref('what"s going on here')
        return{
            msg,
        }
    }
}
</script>
