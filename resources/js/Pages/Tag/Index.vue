<template>
    <AuthenticatedWithStructureLayout :title="`Тег #${tag}`">
        <div class="w-1/2 py-4">
            <span class="text-gray-400">Посты</span>
            <PostList :posts="posts" />
        </div>
        <div class="w-1/2 py-4">
            <span class="text-gray-400">Комментарии</span>
            <CommentList :comments="comments" />
        </div>
    </AuthenticatedWithStructureLayout>
</template>

<script setup>
import AuthenticatedWithStructureLayout from "@/Layouts/AuthenticatedWithStructureLayout.vue";
import PostList from "@/Components/Post/PostList.vue";
import {ref} from "vue";
import CommentList from "@/Components/Comment/CommentList.vue";

const posts = ref([])
const comments = ref([])
const tag = route().params.tag

axios.post('/api/posts/by_tag', {tag: tag})
    .then(res => {
        posts.value = res.data
    })
axios.post('/api/comments/by_tag', {tag: tag})
    .then(res => {
        comments.value = res.data
    })
</script>

<style scoped>

</style>
