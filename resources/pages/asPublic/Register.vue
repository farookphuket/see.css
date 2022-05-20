<template>
    <div class="container">

        <form action="" class="p-4 pb-6 mb-6">
            <div class="field">
                <div class="control">
                    <label for="" class="label">Name</label>
                    <input v-model="rForm.name" 
                    class="input" type="text" name="" 
                    placeholder="user name...">
                </div>

            </div>
            <div class="field">

                <div class="control">
                    <label class="label" for="">E-mail</label>
                    <input v-model="rForm.email" 
                    class="input" type="email" name="" 
                    placeholder="email...">
                </div>
            </div>
            <div class="field">
                <div class="control">
                    <label class="label" for="">Password</label>
                    <input v-model="rForm.password" 
                    class="input" type="password" name="" 
                    placeholder="~~~~">
                </div>
            </div>

            <!-- status ,button START -->
            <div class="columns is-mobile">
                <div class="column">
                    <div v-html="res_status"></div>
                </div>

                <div class="column">
                    <div class="mb-4 pb-4">
                        <div class="field is-pulled-right">
                            <button 
                                class="button is-primary is-outlined 
                                is-rounded" 
                                type="submit" 
                                @click.prevent="saveUser">
                                Register
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <!-- status ,button END -->
        </form>


        <div class="mt-4 pt-4 mb-4">
            <p class="title">your friends 're 'all here.</p>
        </div>
        <div class="post-thumbnail">
            <div class="columns is-mobile is-multiline">
                <div class="column is-3 is-post-list" 
                    v-for="u in users.data">

                <!-- card START -->
                <div class="card">
                  <div class="card-image">
                    <figure class="image is-5by3">
                      <img :src="u.avatar" :alt="u.name" 
                      >
                    </figure>
                  </div>
                  <div class="card-content">
                    <div class="media">
                      <div class="media-content">
                          <p class="title is-4">{{u.name}}</p>
                          <p class="subtitle is-6">@{{u.name}}</p>
                      </div>
                    </div>

                    <div class="content">
                      <time datetime="2016-1-1">11:09 PM - 1 Jan 2016</time>
                    </div>
                  </div>
                </div>
                <!-- card END -->

                </div><!-- end of div.column thumbnail -->

            </div><!-- end of div.columns -->



        <!-- pagination area START -->
        <div class="mt-6 mb-4 d-flex justify-content-center" 
            v-if="users.data != ''">
            <nav class="pagination is-rounded" role="navigation" aria-label="pagination">
                <a class="pagination-previous is-current">All post(s) {{users.total}}</a>
                <a class="pagination-next is-current">page {{users.current_page}}</a>
              <ul class="pagination-list" v-for="ln in users.links">
                <li v-if="ln.url != null && ln.active == false">
                  <a class="pagination-link" 
                  aria-label="Page 1" aria-current="page" v-html="ln.label" 
                  @click="getUsers(ln.url)"></a>
                </li>
                <li v-else>
                  <a class="pagination-link is-current"  v-if="ln.active == true" 
                  aria-label="" aria-current="page" v-html="ln.label" 
                  ></a>

                  <a class="pagination-link"  v-else 
                  aria-label="" aria-current="page" v-html="ln.label" 
                  ></a>
                </li>

              </ul>
            </nav>
        </div>
        <!-- pagination area END -->

        </div>

    </div>
</template>
<script>
import {ref,reactive,onMounted,watch} from 'vue'
import useUser from '../../composable/useUser.js'

export default{
    name:"Register",

    setup(){


        // get the user to show in your friend list 
        const {getUsers,users} = useUser()


        onMounted(() =>{
            getUsers()
        })



        const res_status = ref('')
        
        const rForm = reactive(new Form({
            name:'',
            email:'',
            password:''
        }))

            

        // laravel version
        const laravel_version = window.lsDefault.laravel_version

        
        const saveUser = () =>{
            let url  = `/api/register`
            axios.post(url,{...rForm})
                .then(res=>{
                    res_status.value = res.data.msg
                    
                    setTimeout(()=>{
                        resetMyForm()
                        getUsers()
                    },2500)

                })
                .catch(err=>{
                    res_status.value = `<span class="has-text-danger 
                    has-text-weight-bold">
                    ${Object.values(err.response.data.errors).join()}
                        </span>`
                })
        }

        const resetMyForm = () =>{
            rForm.reset()
            res_status.value = ''
        }

        

        return{
            rForm,
            res_status,
            saveUser,
            laravel_version,
            getUsers,
            users,
            resetMyForm,
        }

    },



}
</script>
