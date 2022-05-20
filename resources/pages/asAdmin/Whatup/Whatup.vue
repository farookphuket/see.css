<template>
    <div class="post-thumbnail">


        <whatup-form 
            :editId="editId"></whatup-form>

        <div class="columns is-mobile is-multiline">
            <div class="column is-4 is-post-list" 
                v-for="wp in whatup.data" v-if="whatup.data">


                <!-- card START -->
                <div class="card">
                  <div class="card-image">
                    <figure class="image is-5by3">
                      <img :src="wp.wp_cover" :alt="wp.wp_title" 
                      >
                    </figure>
                  </div>
                  <div class="card-content">
                    <div class="media">
                      <div class="media-content">
                          <p class="title is-4">{{wp.wp_title}}</p>
                          <p class="subtitle is-6">@{{wp.user.name}}</p>
                      </div>
                    </div>

                    <div class="content">

                        <span class="mr-2">
                            {{moment(wp.created_at).format("YYYY-MM-DD H:m:s")}}
                        </span>
                        <span>
                            {{moment(wp.created_at).fromNow()}}
                        </span>
                    </div>
                  </div>
                  <div class="card-footer">
                      <div class="field is-pulled-right">
                          <button class="button is-primary is-small is-rounded 
                                  is-outlined"
                                  @click.prevent="editButton(wp.id)"
                              >
                              <font-awesome-icon 
                                  icon="edit"></font-awesome-icon>
                          </button>
                          <button class="button is-danger is-small is-rounded 
                                  is-outlined ml-2" 

                              >
                              <font-awesome-icon 
                                  icon="trash"></font-awesome-icon>
                          </button>
                      </div>
                  </div>
                </div>
                <!-- card END -->
            </div>
            <div class="column" v-else>
                <p class="title has-text-danger">no data</p>
            </div>
        </div>
    </div>
</template>
<script>
import WhatupForm from './WhatupForm.vue'
import useWhatup from '../../../composable/useWhatup.js'
import {ref,onMounted} from 'vue'
import moment from 'moment'
export default{
    name:"Whatup",
    components:{
        WhatupForm,
    },
    created:function(){
        this.moment = moment
    },
    setup(){
        const {getWhatup,whatup,resMsg,perpage} = useWhatup()

        // edit id 
        const editId = ref(0)

        onMounted(() =>{
            getWhatup()
        })
        const editButton = (id) => {
            if(id && id !== 0){
                editId.value = id
            }
        }
        return{
            getWhatup,
            whatup,
            resMsg,
            editButton,
            editId,
        }
    }
}
</script>
