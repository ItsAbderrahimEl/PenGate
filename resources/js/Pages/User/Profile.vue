<script setup>
    import { route } from 'ziggy-js'
    import { router } from '@inertiajs/vue3'
    import { useConfirm } from '../../Composables/useConfirm.js'
    import Separator from '../../Components/User/Profile/Separator.vue'
    import PersonalAccount from '../../Components/User/Profile/PersonalAccount.vue'
    import PersonalSessions from '../../Components/User/Profile/PersonalSessions.vue'
    import PersonalPassword from '../../Components/User/Profile/PersonalPassword.vue'
    import PersonalInformation from '../../Components/User/Profile/PersonalInformation.vue'

    //Variables
    let { confirmation } = useConfirm()

    //Functions
    let deleteAccount = async () => {
        if (await confirmation('Are you sure you want to delete your account', 'Deletion Of Account')) {
            router.delete(route('profile.destroy'))
        }
    }

    let updatePassword = (Form) => Form.post(route('profile.update'), {
        preserveScroll: true,
        onSuccess: () => Form.reset()
    })

    let updateInformation = (Form) => Form.post(route('profile.update'), {
        preserveScroll: true,
        forceFormData: true
    })

    let deleteSessions = (Form) => Form.delete(route('sessions.destroy'), {
        preserveScroll: true,
        onSuccess: () => Form.reset()
    })
</script>

<template>
    <div class="m-10">

        <PersonalInformation @updating="updateInformation"/>

        <Separator/>

        <PersonalPassword @updating="updatePassword"/>

        <Separator/>

        <PersonalSessions
            @deleting="deleteSessions"
        />

        <Separator/>

        <PersonalAccount @deleting="deleteAccount"/>
    </div>
</template>
