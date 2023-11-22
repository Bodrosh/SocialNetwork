<template>
    <div v-if="comments.length > 0">
        <ul>
           <li
               v-for="comment of comments"
               class="mt-2 p-4 rounded-2xl even:bg-gray-50 border-2 border-gray-100"
           >
               <span class="flex justify-between">
                   <span>{{comment.user.email}} </span>
                   <span
                       @click="reply(comment.id)"
                       class="cursor-pointer hover:text-amber-700"
                   >Ответить</span>
               </span>
               {{ comment.replyToUser ? `${comment.replyToUser}, ` : '' }}
               <span class="comment" v-html="comment.body"></span>
               <br>
               <small>{{comment.date}}</small>
           </li>
        </ul>
    </div>
</template>

<script setup>
defineProps({
    comments: {
        type: Array,
        default: []
    }
})

const emit = defineEmits(['reply'])

const reply = (commentId) => {
    emit('reply', commentId)
}
</script>

<style scoped lang="scss">
.comment :deep(a) {
    color: #2563eb;
    &:hover {
        color: #ef4444;
    }
}
</style>
