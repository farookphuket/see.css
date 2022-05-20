
import {ref} from 'vue'
import axios from 'axios'

export default function useUser(){

    const users = ref('')

    const getUsers = async (page)=>{
        let url = ''
        if(page){
            url = `${page}`
        }else{
            url = `/api/your-friends`
        }

        let res = await axios.get(url)
        users.value = res.data.users
    }


    return{
        users,
        getUsers,

    }
}
