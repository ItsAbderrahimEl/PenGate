<script setup>
    import { useForm } from '@inertiajs/vue3'
    import Banner from '../../Components/General/Banner.vue'

    //Variables
    let form = useForm({})
    let resendVerificationEmail = () => form.post(route('verification.notice'), {
        onSuccess: () => {
            SuccessMessage.value = 'Verification link sent!'
        }
    })

    //Hooks
    defineOptions({
        layout: null
    })
</script>

<template>
    <Banner/>

    <Head title="Email Verification"/>
    <div class="h-screen w-screen grid place-items-center bg-gray-600">
        <div class="bg-gray-300 rounded-lg p-10 w-fit">
            <div class="text-center text-4xl font-semibold mb-7 text-gray-900">
                CineTalk
            </div>

            <h1 class="font-bold text-gray-900">Verify Email</h1>

            <p class="text-gray-900">An email has been sent to you for email verification.</p>

            <form @submit.prevent="resendVerificationEmail">
                <button class="p-2 bg-gray-900 text-gray-200 rounded-lg mt-5
                hover:bg-gray-800 transition-colors duration-300"
                        type="submit"
                >Resend Verification Email
                </button>
            </form>
        </div>
    </div>
</template>
