<template>
    <div class="wrapper">
        <pub-header v-if="user_id === false"></pub-header>
        <member-nav v-if="is_login === true && is_member === true"></member-nav>
        <admin-nav v-if="is_login === true && is_root === true"></admin-nav>
        <main>
            <pub-view v-if="is_login === false && token === null"></pub-view>
            <member-view v-if="is_login !== false && is_member === true"></member-view>
            <admin-view v-if="is_root === true && is_login === true"></admin-view>
        </main>
        <a-footer></a-footer>
    </div>
</template>


<script>

import {ref,onMounted} from 'vue'
import {useCookies} from 'vue3-cookies'
import PubView from '../components/PubView.vue'
import AFooter from '../components/Footer.vue'
import PubHeader from '../components/PubNav.vue'

import MemberView from '../components/MemberView.vue'
import MemberNav from '../components/MemberNav.vue'

import AdminView from '../components/AdminView.vue'
import AdminNav from '../components/AdminNav.vue'

export default{
    name:"App",
    components:{
        PubHeader,
        PubView,
        MemberView,
        MemberNav,
        AdminView,
        AdminNav,
        AFooter,
    },
    setup(){
        
        const is_login = ref(false)
        const token = ref('')
        const is_member = ref(false)
        const is_root = ref(false)
        const user_id = ref(false)
        const {cookies} = useCookies()

        const user_login = () => {
            token.value = cookies.get('token')
            is_login.value = false
            if(token.value !== null){
                is_login.value = window.lsDefault.USER_IS_LOGIN
                is_member.value = window.lsDefault.is_member
                is_root.value = window.lsDefault.is_root
                user_id.value = window.lsDefault.user_id
            } 
            if(!user_id.value || user_id.value === undefined){
                cookies.remove('token')
            }
        }

        onMounted(() => {
            user_login()
        })
        return{
            is_login,
            user_login,
            cookies,
            token,
            is_member,
            is_root,
            user_id
        }
    }
}
</script>
<style scope>

main{
    min-height:100vh;
    margin-top:85px;
}

@media screen and(max-width:760px){
    main{

    }
}
</style>
