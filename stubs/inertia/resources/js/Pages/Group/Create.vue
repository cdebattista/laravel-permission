<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Create group
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <create-group-form :permissions="permissions"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'
    import CreateGroupForm from "./CreateGroupForm";
    import JetSectionBorder from './../../Jetstream/SectionBorder'

    export default {
        props: ['permissions'],
        components: {
            AppLayout,
            CreateGroupForm,
            JetSectionBorder,
        },

    }
</script>
