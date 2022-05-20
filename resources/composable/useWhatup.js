import axios from 'axios'
import {ref} from 'vue'

import {useCookies} from 'vue3-cookies'

export default function useWhatup(){

    const resMsg = ref('')
    const whatup = ref('')
    const perpage = ref('')
    const {cookies} = useCookies()
    const getWhatup = async (page)=>{
        let url = ""
        if(perpage.value === '') perpage.value = 15
        if(page){
            url = `${page}&perpage=${perpage.value}`
            cookies.set("a_whatup_old",url)
        }
        url = cookies.get('a_whatup_old')
        if(!url) url = `/api/whatup?perpage=${perpage.value}`
        axios.get(url)
            .then(res=>{
                //console.log(`the get`)
                whatup.value = res.data.whatup
            })
    }

    return{
        resMsg,
        getWhatup,
        whatup,
        perpage
    }
}
