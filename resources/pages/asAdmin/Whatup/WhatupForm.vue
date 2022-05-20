<template>
    <div>
        <form class="p-4" action="" ENCTYPE="multipart/form-data">
            <div class="field">
                <div class="control">
                    <input v-model="wForm.wp_title" class="input" 
                    type="text" ref="title">
                </div>
            </div>

            <div class="is-post-list mt-4 pb-4 ">

                <div class="columns is-mobile">
                    <div class="column">
                        <div class="field">
                            <div class="control">
                                <input ref="cover_file" class="input" 
                                type="file" name="" 
                                @change="select_preview">
                            </div>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field is-horizontal">
                            <div class="field-body">
                                <div class="field">
                                    <div class="control">
                                        <input v-model="wForm.wp_img_url" 
                                        class="input" type="text" name="" 
                                        >
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="control">
                                        <button class="button 
                                            is-primary is-rounded is-outlined" 
                                            @click="url_preview">
                                            <font-awesome-icon 
                                                icon="eye"></font-awesome-icon>
                                        </button>
                                    </div>
                                </div>

                            </div>
                        </div><!-- end of div.field.is-horizontal -->

                    </div>

                </div>

                <!-- preview area START -->
                <div class="mb-4 pb-4">
                    <figure >
                        <img :src="photo.src" :alt="photo.alt" 
                        class="is-3by2">
                    </figure>

                    <p>
                        {{photo.alt}}  
                        <span v-if="is_has_error === true" 
                              class="has-text-danger 
                              has-text-weight-bold">{{is_error_msg}}</span>

                    </p>
                </div>
                <!-- preview area END -->

            </div>
            <!-- end of div.mt-4 select cover -->


            <div class="field ">
                <div class="control has-icons-right">
                    <textarea v-model="wForm.wp_excerpt" class="textarea" 
                        name="" ></textarea>
                    <span class="icon is-right">
                        {{wForm.wp_excerpt.length}}
                    </span>
                </div>
            </div>
            <!-- end of textarea wp_excerpt -->

            <div class="field">
                <div class="control">
                    <jodit-editor 
                        v-model="wForm.wp_body" 
                        height=450 
                        :editorOptions="options"></jodit-editor>
                </div>
            </div>

            <div class="mb-4 pb-4 pt-4 is-post-list">
                <div class="columns is-mobile">
                    <div class="column">
                        <div v-html="res_status"></div>
                    </div>
                    <div class="column">
                        <div class="field">
                            <label for="" class="checkbox">
                                <input v-model="wForm.is_public" 
                                type="checkbox" name="">
                                <span>public</span>
                            </label>
                        </div>
                    </div>
                    <div class="column">
                        <div class="field is-pulled-right">
                            <button class="button is-primary is-outlined 
                                is-rounded" 
                                type="submit" 
                                @click="post">
                                <font-awesome-icon  
                                    icon='check'></font-awesome-icon>
                            </button>
                        </div>
                    </div>
                </div>
            </div><!-- end of div.mb-4 button -->

        </form>
    </div>
</template>
<script>

import {ref,reactive,watchEffect} from "vue"

export default{
    name:"WhatupForm",
    props:['editId'],
    setup(props){
        const wForm = reactive(new Form({
            wp_title:'',
            wp_file_upload:'',
            wp_img_url:'',
            wp_excerpt:'',
            wp_body:'',
            is_public:''
        }))


        const res_status = ref('')
        const is_error_msg = ref('')
        const is_has_error = ref(false)

        const cover_file = ref(null)

        const  photo = ref('') // will return array of image and alt tag
        

        const options = {
            disablePlugins:"powered-by-jodit"
        }

        const select_preview = (e) =>{
            // reset error
            reset_error()

            // reset the input field
            wForm.wp_img_url = ''

            let theFile = e.target.files[0]
            let f_size = theFile.size/1024/1024
            let f_name = theFile.name

            if(f_size > 2){

                res_status.value = `<span class="has-text-danger 
                has-text-weight-bold">Error the upload file is too big.</span>`
                is_has_error.value = true
                is_error_msg.value = `Error! file too big! 
                    please select file size less than 2 MB.`
            }else{

                // show preview 
                photo.value = {
                    src:URL.createObjectURL(theFile),
                    alt:theFile.name
                }
                // set value for upload field
                wForm.wp_file_upload = theFile
            }
        }
        const url_preview = (e) =>{
            e.preventDefault()
            reset_error()

            // try to reset the upload 
            wForm.wp_file_upload = null



            if(wForm.wp_img_url.length !== 0){
                // preview the url 
                photo.value = {
                    src:wForm.wp_img_url,
                    alt:wForm.wp_title
                }

            }

        }

        const edit_id  = watchEffect(() => {

            if(props.editId !== 0){

                let url = `/api/admin/whatup/${props.editId}`
                axios.get(url)
                    .then(res=>{
                        console.log(res.data.whatup)
                        let rData = res.data.whatup 
                        photo.value = {
                            src:rData.wp_cover,
                            alt:rData.wp_title
                        }
                        if(rData.is_public !== 0){
                            wForm.is_public = true
                        }
                    })
            }

        })


        const post = (e) =>{
            e.preventDefault()
            res_status.value = ''

            let url = `/api/admin/whatup`
            let fData = new FormData()
            fData.append('wp_title',wForm.wp_title)
            fData.append('wp_excerpt',wForm.wp_excerpt)
            fData.append('wp_body',wForm.wp_body)
            fData.append('is_public',wForm.is_public)
            fData.append('wp_file_upload',wForm.wp_file_upload)
            fData.append('wp_img_url',wForm.wp_img_url)

            axios.post(url,fData)
                .then(res => {
                    res_status.value = res.data.msg
                })
                .catch(err => {
                    res_status.value = `<span class="has-text-danger 
                    has-text-weight-bold">${Object.values(err
                        .response.data.errors).join()}</span>`
                })
        }



        const reset_error = () =>{
            is_has_error.value = false 
            is_error_msg.value = ''
            res_status.value = ''
        }


        return{
            wForm,
            select_preview,
            res_status,
            options,
            url_preview,
            photo,
            is_has_error,
            is_error_msg,
            reset_error,
            cover_file,
            post,
            edit_id,
        }
    }
}
</script>
