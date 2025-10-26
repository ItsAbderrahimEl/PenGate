<script setup>
    import { router, usePage } from '@inertiajs/vue3'
    import { route } from 'ziggy-js'

    //Variables
    let page = usePage()

    //Hooks
    let props = defineProps({
        user: {
            type: Object,
            required: true
        }
    })

    //Computed
    let is_followed_by_current_user = computed(() => props.user.is_followed_by_current_user !== false)

    //Functions
    let manageFollow = () => {
        if (!page.props.auth) {
            router.get(route('login.create'))
            return
        }

        if (is_followed_by_current_user.value) {
            router.delete(route('follows.destroy', props.user.is_followed_by_current_user), {
                preserveScroll: true
            })
            return
        }

        if (!is_followed_by_current_user.value) {
            router.post(route('follows.store', props.user.id), {}, {
                preserveScroll: true
            })
            return
        }

        return false
    }
</script>

<template>
    <button
        v-html="is_followed_by_current_user ? 'Unfollow' : 'Follow'"
        @click="manageFollow"
        class="text-xl py-2 px-3 rounded-lg cursor-pointer uppercase bg-[rgba(2,29,78,0.681)] text-[rgb(4, 4, 38)] font-bold shadow-md">

    </button>
</template>

<style scoped>
</style>