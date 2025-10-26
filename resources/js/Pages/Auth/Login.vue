<script setup>
    import { route } from 'ziggy-js'
    import login_img from '@img/login.jpeg'
    import { useForm } from '@inertiajs/vue3'
    import Label from '../../Components/Form/Label.vue'
    import Title from '../../Components/General/Title.vue'
    import Banner from '../../Components/General/Banner.vue'
    import TextInput from '../../Components/Form/TextInput.vue'
    import RememberMe from '../../Components/Form/RememberMe.vue'
    import ErrorInput from '../../Components/Form/ErrorInput.vue'
    import PasswordInput from '../../Components/Form/PasswordInput.vue'

    //Variables
    let loginForm = useForm({
        email: null,
        password: null,
        remember: false
    })

    //Hooks
    defineOptions({
        layout: null
    })
</script>

<template>
    <Head title="Login"/>
    <Banner/>
    <div class="flex items-center justify-center h-screen bg-gray-900">
        <div class="grid grid-cols-2 place-items-center w-[75rem]">
            <div class="w-full h-full p-10 flex flex-col justify-evenly gap-y-8 items-center  ">
                <Title subtitle='Login'/>

                <form @submit.prevent='loginForm.post(route("login.store"))'
                      class='w-full space-y-6'
                >
                    <div>
                        <Label for="email">Email</Label>
                        <TextInput
                            id="email"
                            v-model="loginForm.email"
                            name='email'
                            type='email'
                        />
                        <ErrorInput :error="loginForm.errors.email"/>
                    </div>

                    <div>
                        <Label for="password">Password</Label>
                        <PasswordInput
                            id="password"
                            v-model="loginForm.password"
                            name='password'
                            type='password'

                        />
                        <ErrorInput :error="loginForm.errors.password"/>
                    </div>

                    <RememberMe
                        v-model='loginForm.remember'
                        name='remember'
                    > Remember Me
                    </RememberMe>

                    <button
                        :disable='loginForm.processing'
                        class='mt-8 button'
                    > Login
                    </button>
                </form>

                <div class="self-start font-semibold text-white text-sm">
                    Don't have an account yet?
                    <Link class="whitespace-break-spaces text-green-400"
                          :href="route('signup.create')"
                    >
                        Sign up!
                    </Link>
                </div>
            </div>
            <img
                alt="Image"
                :src='login_img'
                class="w-[35rem] h-full object-cover rounded-xl"
            >
        </div>
    </div>

</template>
