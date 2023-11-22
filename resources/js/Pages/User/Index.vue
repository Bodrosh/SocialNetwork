<template>
    <AuthenticatedWithStructureLayout title="Пользователи">
        <div v-if="users.length > 0">
            <div
                v-for="user of users"
                class="mt-4 mb-4"
            >
                <Link :href="route('user.show', { user: user.id })">
                    #{{ user.id }} {{ user.email }}
                </Link>
                <PrimaryButton
                    @click="toggleFollowing(user)"
                    class="ml-4"
                    :is-light="user.is_followed"
                > {{user.is_followed ? 'Отписаться' : 'Подписаться' }} </PrimaryButton>
            </div>
        </div>
    </AuthenticatedWithStructureLayout>
</template>

<script setup>
import AuthenticatedWithStructureLayout from "@/Layouts/AuthenticatedWithStructureLayout.vue";
import {Link} from "@inertiajs/vue3";
import PrimaryButton from "@/Components/PrimaryButton.vue";

const props = defineProps({
    users: {
        type: Array,
        required: true,
        default: []
    }
})

const toggleFollowing = (user) => {
    axios.post(`/api/users/${user.id}/toggle_following`)
        .then(res => {
            user.is_followed = res.data === 1
            console.log(user.is_followed)
        })
}

</script>

<style scoped>

</style>
