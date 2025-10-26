<script setup>
    import ProfileSection from './ProfileSection.vue'

    defineEmits(['deleting'])
</script>

<template>
    <ProfileSection
        title="Delete Account"
        description="Permanently delete your account."
    >
        <div class="px-7 py-5 space-y-5">
                <p>
                    Once your account is deleted, all of it's resources and data will be permanently deleted.
                    Before deleting your account, pleas download any data or information that you wish to retain.
                </p>

            <form class="flex" @submit.prevent="$emit('deleting')">
                <button class="secondary-button bg-red-600 w-32 text-white hover:bg-red-700 ml-auto">
                    Delete
                </button>
            </form>
        </div>
    </ProfileSection>
</template>
