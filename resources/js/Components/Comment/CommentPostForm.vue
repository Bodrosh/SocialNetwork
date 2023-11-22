<template>
    <div class="p-5 pt-3 border-2 border-gray-100 mt-4 mb-4 rounded-2xl">
        <div class="mb-2">
            <div class="flex justify-between">
                <InputLabel for="body" :value="replyId ? 'Ответ пользователю' : 'Комментарий'" />
                <span
                    @click="emit('replyCancel')"
                    class="text-sm cursor-pointer hover:text-amber-700"
                >Отменить</span>
            </div>

            <TextInput
                id="body"
                type="text"
                class="mt-1 block w-full"
                v-model="form.body"
                required
                autofocus
            />
            <InputError class="mt-2" :message="errors.body ?? ''" />
        </div>

        <PrimaryButton @click="repost">{{ replyId ? 'Ответить' : 'Комментировать' }}</PrimaryButton>
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
    },
    replyId: {
        default: null
    }
})
const emit = defineEmits(['newComment', 'replyCancel'])

const form = reactive({})
const errors = ref([])

const setDefaultFormData = () => {
    form.body = ''
}
setDefaultFormData()

const repost = () => {
    form.parent_id = props.replyId
    axios.post(`/api/posts/${props.postId}/comment`, form)
        .then(res => {
            errors.value = []
            setDefaultFormData()
            emit('newComment', res.data)
        })
        .catch(e => {
            errors.value = e.response.data.errors
        })
}
</script>

<style scoped>

</style>
