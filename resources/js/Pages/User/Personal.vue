<template>
    <AuthenticatedWithStructureLayout title="Социальная сеть">
        <div class="w-1/2">
            <Stats :data="statsData" />
            <CreatePostForm  />
        </div>
        <PostList
            :posts="posts"
            class="w-1/2"
        />
    </AuthenticatedWithStructureLayout>
</template>

<script setup>
import CreatePostForm from "@/Components/Post/CreatePostForm.vue"
import PostList from "@/Components/Post/PostList.vue"
import AuthenticatedWithStructureLayout from "@/Layouts/AuthenticatedWithStructureLayout.vue"
import {ref} from "vue"
import Stats from "@/Components/Stats.vue";

const posts = ref([])
const statsData = ref(null)
axios.get('/api/posts')
    .then(res => {
        posts.value = res.data
    })

axios.post('/api/users/stats')
.then(res => {
    statsData.value = res.data
})
</script>
