import {createWebHistory,createRouter} from 'vue-router'

// template 
import PubView from '../components/PubView.vue'


// pages 
import Home from '../pages/asPublic/Home.vue'
import About from '../pages/asPublic/About.vue'
import Blog from '../pages/asPublic/Blog.vue'
import Register from "../pages/asPublic/Register.vue"
import Login from "../pages/asPublic/Login.vue"

// member
import MemberView from "../components/MemberView.vue"
import MemberDashboard from "../pages/asMember/Dashboard.vue"

// admin route
import AdminView from "../components/AdminView.vue"
import AdminDashboard from '../pages/asAdmin/Dashboard.vue'


export const user_id = window.lsDefault.user_id

const routes = [
    {
        path:'/',
        redirect:'/',
        component:PubView,
        children:[
            {
                name:'Home',
                path:'/',
                component:Home
            },
            {
                name:'About',
                path:'/about',
                component:About
            },
            {
                name:'Blog',
                path:'/blog',
                component:Blog
            },
            {
                name:'Register',
                path:'/register',
                component:Register,
            },
            {
                name:'Login',
                path:'/login',
                component:Login
            },
        ]
    },
    {
        path:'/member',
        redirect:'/member/member-dashboard',
        component:MemberView,
        children:[
            {
                name:'MemberDashboard',
                component:MemberDashboard,
                path:'/member-dashboard'
            }
        ],
        beforeEnter:(to,from,next)=>{
            if(!user_id){
                next({name:'Login'})
            }else{
                next()
            }

        },
    },
    {
        /* ==== ADMIN START ============== */
        path:'/admin',
        redirect:'/admin/admin-dashboard',
        component:AdminView,
        children:[
            {
                name:'AdminDashboard',
                path:'/admin-dashboard',
                component:AdminDashboard
            }
        ],
        beforeEnter:(to,from,next)=>{
            if(!user_id){
                next({name:'Login'})
            }else{
                next()
            }

        },
        /* ==== ADMIN END ============== */
    },
]


const router = createRouter({
    history:createWebHistory(),
    routes:routes
})



export default router
