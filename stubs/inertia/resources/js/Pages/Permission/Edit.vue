<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit permission
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <update-permission-form v-can="canUpdate" :permission="permission"/>
                <jet-section-border />
                <delete-permission-form v-can="canDelete" :permission="permission"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'
    import UpdatePermissionForm from "./UpdatePermissionForm";
    import DeletePermissionForm from "./DeletePermissionForm";
    import JetSectionBorder from './../../Jetstream/SectionBorder'

    export default {
        props: ['permission'],
        components: {
            AppLayout,
            UpdatePermissionForm,
            DeletePermissionForm,
            JetSectionBorder,
        },
        data() {
            return {
                canUpdate: ['administrator', 'edit_permission'],
                canDelete: ['administrator', 'delete_permission']
            }
        },
    }
</script>
