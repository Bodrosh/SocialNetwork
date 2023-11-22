<template>
    <div class="p-5 pt-3 border-2 border-gray-100 mt-4 mb-4 rounded-2xl">
        <span class="text-gray-400">Репост поста</span>
        <hr class="mt-1 mb-2 border-dashed">
        <div class="mb-2">
            <InputLabel for="title" value="Заголовок" />
            <TextInput
                id="title"
                type="text"
                class="mt-1 block w-full"
                v-model="form.title"
                required
                autofocus
            />
            <InputError class="mt-2" :message="errors.title" />
        </div>

        <div class="mb-2">
            <InputLabel for="content" value="Содержимое" />
            <TextInput
                id="content"
                type="text"
                class="mt-1 block w-full"
                v-model="form.content"
                required
                autofocus
            />
            <InputError class="mt-2" :message="errors.content ?? ''" />
        </div>

        <PrimaryButton @click="repost">Репостнуть</PrimaryButton>
    </div>
</template>

<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import InputLabel from "@/Components/InputLabel.vue";
import InputError from "@/Components/InputError.vue";
import TextInput from "@/Components/TextInput.vue";
import {reactive, ref} from "vue";

const props = defineProps({
    postId: {
        required: true,
        type: Number
    }
})

const form = reactive({})
const errors = ref([])

const setDefaultFormData = () => {
    form.title = ''
    form.content = ''
}
setDefaultFormData()

const repost = () => {
    axios.post(`/api/posts/${props.postId}/repost`, form)
        .then(res => {
            errors.value = []
            setDefaultFormData()
        })
        .catch(e => {
            errors.value = e.response.data.errors
        })
}

</script>

<style scoped>

</style>
