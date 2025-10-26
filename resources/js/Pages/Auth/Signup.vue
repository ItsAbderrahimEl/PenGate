<script setup>
    import { route } from 'ziggy-js'
    import signup_img from '@img/signup.jpeg'
    import { useForm } from '@inertiajs/vue3'
    import Label from '../../Components/Form/Label.vue'
    import Title from '../../Components/General/Title.vue'
    import Banner from '../../Components/General/Banner.vue'
    import TextInput from '../../Components/Form/TextInput.vue'
    import ErrorInput from '../../Components/Form/ErrorInput.vue'
    import PasswordInput from '../../Components/Form/PasswordInput.vue'

    //Variables
    let signForm = useForm({
        name: null,
        email: null,
        password: null,
        password_confirmation: null
    })

    //Hooks
    defineOptions({
        layout: null
    })
</script>

<template>
    <Head title="Sign up"/>
    <Banner/>

    <div class="flex items-center justify-center h-screen bg-gray-900">
        <div class="grid grid-cols-2 place-items-center w-[75rem]">
            <div class="w-full h-full p-10 flex flex-col justify-evenly gap-y-5 items-center ">
                <Title subtitle="Sign Up"/>

                <form @submit.prevent="signForm.post(route('signup.store'))"
                      class="w-full space-y-4"
                >
                    <div>
                        <Label for="name">Name</Label>
                        <TextInput
                            id="name"
                            v-model="signForm.name"
                            name='name'
                            type='name'
                        />
                        <ErrorInput :error="signForm.errors.email"/>
                    </div>

                    <div>
                        <Label for="email">Email</Label>
                        <TextInput
                            id="email"
                            v-model="signForm.email"
                            name='email'
                            type='email'
                        />
                        <ErrorInput :error="signForm.errors.email"/>
                    </div>

                    <div>
                        <Label for="password">Password</Label>
                        <PasswordInput
                            id="password"
                            v-model="signForm.password"
                            name='password'
                            type='password'
                        />
                        <ErrorInput :error="signForm.errors.password"/>
                    </div>

                    <div>
                        <Label for="password_confirmation">Password</Label>
                        <PasswordInput
                            id="password_confirmation"
                            v-model="signForm.password_confirmation"
                            name='password_confirmation'
                            type='password'
                        />
                        <ErrorInput :error="signForm.errors.password_confirmation"/>
                    </div>

                    <div>
                        <button class="button mt-5" :disable='signForm.processing'>
                            Sign Up
                        </button>
                    </div>
                </form>

                <div class="self-start font-semibold text-white text-sm mt-3">
                    Already have an account?
                    <Link class="whitespace-break-spaces text-green-400"
                          :href="route('login.create')"
                    >
                        Log in!
                    </Link>
                </div>
            </div>
            <img
                alt="Image"
                 :src="signup_img"
                class="w-[35rem] h-[35rem] object-cover rounded-xl"
            >
        </div>
    </div>
</template>

