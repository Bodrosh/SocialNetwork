<template>
    <div class="p-5 pt-3 border-2 border-gray-100 mt-4 mb-4 rounded-2xl">
        <span class="text-gray-400">Добавление поста</span>
        <hr class="mt-1 mb-2 border-dashed">
        <div class="mb-2">
            <InputLabel for="title" value="Заголовок" />
            <TextInput
                id="name"
                type="text"
                class="mt-1 block w-full"
                v-model="form.title"
                required
                autofocus
            />
            <InputError class="mt-2" :message="errors.title" />
        </div>

       <div class="mb-2">
           <InputLabel for="title" value="Содержимое" />
           <TextInput
               id="name"
               type="text"
               class="mt-1 block w-full"
               v-model="form.content"
               required
               autofocus
           />
           <InputError class="mt-2" :message="errors.content ?? ''" />
       </div>

        <input
            type="file"
            accept="image/*"
            @change="storeImage"
        >
        <div
            v-if="image"
            class="flex justify-center w-[100px] h-[100px] mt-4 mb-4 border-2 overflow-hidden border-dashed rounded-2xl"
        >
            <img
                :src="image.url"
                alt=""
                class="self-center"
            >
        </div>
        <InputError class="mt-2" :message="errors.image ?? ''" />

        <PrimaryButton @click="storePost">Опубликовать</PrimaryButton>
    </div>
</template>

<script setup>
import TextInput from "@/Components/TextInput.vue"
import InputLabel from "@/Components/InputLabel.vue"
import InputError from "@/Components/InputError.vue"
import {reactive, ref} from "vue";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const form = reactive({})
const setDefaultFormData = () => {
    form.title = ''
    form.content =''
    form.image_id = null
}
setDefaultFormData()

const errors = ref([])
const image = ref(null)
const storePost = () => {
    axios.post('/api/posts', form)
        .then(res => {
            errors.value = []
            setDefaultFormData()
            image.value = null
        })
        .catch(e => {
            errors.value = e.response.data.errors
        })
}

const storeImage = (val) => {
    const data = new FormData()
    data.append('image', val.target.files[0])
    axios.post('/api/post_images', data)
        .then(res => {
            image.value = res.data
            form.image_id = res.data.id
            errors.value = []
        }).catch(e => {
            image.value = null
            errors.value = e.response.data.errors
        })
}
</script>

<style scoped>

</style>
