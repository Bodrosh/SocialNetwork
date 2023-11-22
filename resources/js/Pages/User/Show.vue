<template>
    <AuthenticatedWithStructureLayout :title="'Пользователь ' + userId">
        <div class="w-1/2">
            <Stats :data="statsData" />
            <PostList
                :posts="posts"
            />
        </div>
    </AuthenticatedWithStructureLayout>
</template>

<script setup>

import AuthenticatedWithStructureLayout from "@/Layouts/AuthenticatedWithStructureLayout.vue"
import PostList from "@/Components/Post/PostList.vue"
import {ref} from "vue"
import Stats from "@/Components/Stats.vue";
const posts = ref([])
const statsData = ref(null)

const userId = route().params.user
// https://github.com/tighten/ziggy
//const userId = usePage().props.auth.user.id

axios.get(`/api/users/${userId}/posts`)
    .then(res => {
        posts.value = res.data
    })

axios.post('/api/users/stats', {user_id: userId})
    .then(res => {
        statsData.value = res.data
    })
</script>

<style scoped>

</style>
