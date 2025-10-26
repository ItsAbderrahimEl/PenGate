<script setup>
    import { useForm } from '@inertiajs/vue3'
    import ProfileSection from './ProfileSection.vue'
    import Label from '../../Form/Label.vue'
    import ErrorInput from '../../Form/ErrorInput.vue'
    import PasswordInput from '../../Form/PasswordInput.vue'

    defineEmits(['updating'])

    let Form = useForm({
        current_password: null,
        new_password: null,
        new_password_confirmation: null
    })
</script>

<template>
    <ProfileSection
        title="Update Password"
        description=" Ensure your are using a long, random password to stay secure."
    >
        <form
            class="p-7 flex flex-col gap-y-4"
            @submit.prevent="$emit('updating', Form)"
        >
            <div>
                <Label for="current_password" class="text-gray-900">Current Password</Label>
                <PasswordInput
                    type="password"
                    id="current_password"
                    name='current_password'
                    :show-eye="false"
                    :style="'bg-gray-200'"
                    v-model="Form.current_password"
                />
                <ErrorInput :error="Form.errors.current_password"/>
            </div>

            <div>
                <Label for="new_password" class="text-gray-900">New Password</Label>
                <PasswordInput
                    type="password"
                    id="new_password"
                    :style="'bg-gray-200'"
                    name='new_password'
                    v-model="Form.new_password"
                />
                <ErrorInput :error="Form.errors.new_password"/>
            </div>

            <div>
                <Label for="new_password_confirmation" class="text-gray-900">New Password Confirmation</Label>
                <PasswordInput
                    type="password"
                    id="new_password_confirmation"
                    name='new_password_confirmation'
                    :style="'bg-gray-200'"
                    v-model="Form.new_password_confirmation"
                />
                <ErrorInput :error="Form.errors.new_password_confirmation"/>
            </div>

            <button
                :disable="Form.processing"
                class="secondary-button bg-gray-800 w-32 text-white hover:bg-gray-900"
                >
                    Update
            </button>
        </form>
    </ProfileSection>
</template>
