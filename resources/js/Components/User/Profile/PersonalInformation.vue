<script setup>
    import { useForm, usePage } from '@inertiajs/vue3'
    import camera_icon from '@img/camera_icon.png'
    import ProfileSection from './ProfileSection.vue'
    import ErrorInput from '../../Form/ErrorInput.vue'
    import Label from '../../Form/Label.vue'
    import FileInput from '../../Form/FileInput.vue'
    import TextInput from '../../Form/TextInput.vue'
    import TextArea from '../../Form/TextArea.vue'

    let page = usePage()
    let previewImage = ref(page.props.auth.user.avatar)
    let Form = useForm({
        name: page.props.auth.user.name,
        email: page.props.auth.user.email,
        phone: page.props.auth.user.phone,
        bio: page.props.auth.user.bio,
        avatar: null
    })

    defineEmits(['updating'])

    let previewAvatar = (event) => {
        if (event.target.files[0]) {
            previewImage.value = URL.createObjectURL(event.target.files[0])
        }
    }

    let cancel = () => {
        Form.reset()
        previewImage.value = page.props.auth.user.avatar
    }

</script>

<template>
    <ProfileSection
        title=" Profile Information"
        description=" Update your account's information and email address."
    >
        <form
            class="flex flex-col gap-y-4 px-7 py-5"
            @submit.prevent="$emit('updating', Form)"
        >
                <div class="flex w-full">
                    <img
                        :src="previewImage"
                        alt="Profile Picture"
                        class="rounded-full w-32 h-32 mx-auto border-4 border-gray-800 mb-4 ring ring-gray-400"
                    >
                    <div class="self-end flex-1">
                        <label for="avatar">
                            <img
                                alt="Camera Icon"
                                :src="camera_icon"
                                class="w-5 h-5 hover:cursor-pointer hover:scale-110 transition-transform duration-300">
                        </label>
                        <file-input
                            id="avatar"
                            name='avatar'
                            :hidden="true"
                            v-model="Form.avatar"
                            @change="previewAvatar"
                        />
                        <error-input :error="Form.errors.avatar"/>
                    </div>
                </div>

            <div>
                <label class="text-gray-900" for="name">Name</label>
                <text-input
                    id="name"
                    class="bg-gray-200"
                    v-model="Form.name"
                    name='name'
                />
                <error-input :error="Form.errors.name"/>
            </div>

            <div>
                <label for="email" class="text-gray-900">Email</label>
                <text-input
                    id="email"
                    class="bg-gray-200"
                    v-model="Form.email"
                    name='email'
                />
                <error-input :error="Form.errors.email"/>
            </div>

            <div>
                <label for="phone" class="text-gray-900">Phone</label>
                <text-input
                    id="phone"
                    type="text"
                    class="bg-gray-200"
                    placeholder="Add your phone number"
                    v-model="Form.phone"
                    name='phone'
                />
                <error-input :error="Form.errors.phone"/>
            </div>

            <div>
                <label for="bio" class="text-gray-900">Biography</label>
                <Text-area
                    id="bio"
                    placeholder="Write your beautiful Biography here."
                    class="bg-gray-200 h-32"
                    v-model="Form.bio"
                    name='bio'
                />
                <error-input :error="Form.errors.bio"/>
            </div>
            <div class="self-end space-x-5">

                <button
                    class="secondary-button mt-3 bg-gray-800 w-32 text-white hover:bg-gray-900"
                    :disable="Form.processing"
                >
                    Save
                </button>
                <button
                    @click.prevent="cancel"
                    class="secondary-button mt-3 bg-red-500 w-24 text-white hover:bg-red-600"
                >
                    Cancel
                </button>
            </div>
        </form>
    </ProfileSection>
</template>
