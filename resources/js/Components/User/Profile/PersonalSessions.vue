<script setup>
    import { useForm } from '@inertiajs/vue3'
    import SessionDisplay from './SessionDisplay.vue'
    import ProfileSection from './ProfileSection.vue'
    import ErrorInput from '../../Form/ErrorInput.vue'
    import PasswordInput from '../../Form/PasswordInput.vue'
    import Modal from '../../General/Modal.vue'
    import { route } from 'ziggy-js'

    let Form = useForm({ password: null })
    let sessions = ref([])

    onMounted(async () => {
        await axios.get(route('sessions.index')).then(response => {
                sessions.value = response.data.sessions
            }
        )
    })

    defineEmits(['deleting'])

</script>

<template>
    <ProfileSection
        title="Browser Sessions"
        description="Manage and log out your active sessions on other browsers and devices."
    >
        <div class="space-y-10 px-7 py-5">
            <p>
                If necessary, you may log out of all of your other browser sessions across all your devices.
                Some of your recent sessions are listed below; however, this list may not be exhaustive. If you feel
                your account has been compromised, you should also update your password.
            </p>
            <div class="flex gap-x-4 overflow-scroll shadow rounded-lg shadow-neutral-500 p-3 scroll-hidden">
                <template v-for="session in sessions">
                    <SessionDisplay :session="session"/>
                </template>
            </div>

            <Modal title="Deleting Sessions">
                <template #trigger>
                    <div class="flex justify-end">
                        <button class="secondary-button bg-gray-800 text-white hover:bg-gray-900 ">
                            Log out other browsers sessions
                        </button>
                    </div>
                </template>

                <template #content>
                    <div class="m-10 space-y-5">
                        <div>
                            <p>Proceeding with this action will log you out from all other devices.</p>
                            <p class="font-semibold">Enter your password to continue : </p>
                        </div>

                        <form class="flex flex-col gap-y-4" @submit.prevent="$emit('deleting', Form)">
                            <div>
                                <PasswordInput
                                    type="password"
                                    name='password'
                                    :show-eye="false"
                                    placeholder="Password"
                                    :style="'bg-gray-200'"
                                    v-model="Form.password"
                                />
                                <ErrorInput :error="Form.errors.password"/>
                            </div>

                            <button
                                :disable="Form.processing"
                                class="secondary-button bg-red-600 w-32 text-white mt-3 hover:bg-red-700">
                                Delete
                            </button>
                        </form>
                    </div>
                </template>
            </Modal>
        </div>
    </ProfileSection>
</template>
