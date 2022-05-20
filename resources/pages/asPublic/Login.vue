<template>
    <div class="container">
        <div class="post-thumbnail">

            <div class="columns is-mobile is-multiline">
                <div class="column is-post-list">
                    <p class="title has-text-info">
                        please login with your credentials
                    </p>
                </div>
                <div class="column is-post-list">
                    <login-form></login-form>
                </div>
            </div>
        </div>

    </div>
</template>
<script>
import LoginForm from '../../components/LoginForm.vue'

import {ref,reactive,onMounted} from 'vue'

import {useCookies} from 'vue3-cookies'

export default{
    name:"Login",
    components:{
        LoginForm,
    },
    setup(){

        onMounted(()=>{
            reToken()
        })
        const cookies = useCookies()

        const reToken = () =>{

        }
        const msg = ref('')
        return{
            msg,
            reToken,
        }
    }
}
</script>
