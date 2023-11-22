<template>
    <AuthenticatedWithStructureLayout title="Лента новостей">
        <PostList
            :posts="posts"
            class="w-1/2"
        />
    </AuthenticatedWithStructureLayout>
</template>

<script setup>
import AuthenticatedWithStructureLayout from "@/Layouts/AuthenticatedWithStructureLayout.vue"
import PostList from "@/Components/Post/PostList.vue"

const props = defineProps({
    posts: {
        type: Array,
        required: true,
        default: []
    }
})
</script>

<style scoped>

</style>
