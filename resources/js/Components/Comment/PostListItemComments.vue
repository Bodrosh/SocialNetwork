<template>
    <div class="flex justify-between">
        <div
            v-if="count > 0"
            @click="showComments"
            class="cursor-pointer hover:text-amber-700"
        >
            {{isShowedComments ? 'Скрыть' : 'Показать'}} комментарии ({{count}})
        </div>
        <span
            @click="isShowedForm = !isShowedForm"
            class="cursor-pointer hover:text-amber-700"
        >Комментировать</span>
    </div>
    <CommentList
        v-if="isShowedComments"
        :comments='comments'
        @reply="reply"
    />
    <CommentPostForm
        @newComment="newComment"
        @replyCancel="replyId = null"
        v-if="isShowedForm"
        :post-id="postId"
        :reply-id="replyId"
    />
</template>

<script setup>
import CommentPostForm from "@/Components/Comment/CommentPostForm.vue";
import {ref} from "vue";
import CommentList from "@/Components/Comment/CommentList.vue";
const props = defineProps({
    postId: {
        required: true,
        type: Number
    },
    count: {
        type: Number,
        default: 0
    }
})

const emit = defineEmits(['incrCommentsCount'])

const isShowedForm = ref(false)
const isShowedComments = ref(false)
const comments = ref([])
const replyId = ref(null)
const showComments = () => {
    if (isShowedComments.value) {
        isShowedComments.value = false
        return
    }
    axios.get(`/api/posts/${props.postId}/comment`)
        .then(res => {
            comments.value = res.data
            isShowedComments.value = true
        })
}

const newComment = (data) => {
    comments.value.unshift(data)
    emit('incrCommentsCount')
}

const reply = (commentId) => {
    isShowedForm.value = true
    replyId.value = commentId
}

</script>

<style scoped>

</style>
