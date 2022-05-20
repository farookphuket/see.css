<template>
    <div class="container">
        <h1>this is About.vue</h1>
        <p>this is About page vue ref ha ha {{msg}}</p>
    </div>
</template>

<script>
import {ref} from 'vue'
export default{
    name:"About",
    setup(){
        const msg = ref('hello from ref')
        return{
            msg,
        }
    }
}
</script>
