<script setup>
    import Header from '../Components/General/Header.vue'
    import Banner from '../Components/General/Banner.vue'
    import ConfirmModal from '../Components/General/ConfirmModal.vue'
</script>

<template>
    <div class=' flex flex-col min-h-screen'>

        <Header/>
        <Banner/>

        <main class=''>
            <slot/>
        </main>

        <footer class='text-white px-8 py-10 m-5 mt-auto bg-gray-800 rounded-lg'>
        </footer>
        <ConfirmModal/>
    </div>
</template>
