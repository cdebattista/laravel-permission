<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit group
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <update-group-form v-can="canUpdate" :group="group" :permissions="permissions" :group_permissions="group_permissions"/>
                <jet-section-border />
                <delete-group-form v-can="canUpdate" :group="group"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'
    import UpdateGroupForm from "./UpdateGroupForm";
    import DeleteGroupForm from "./DeleteGroupForm";
    import JetSectionBorder from './../../Jetstream/SectionBorder'

    export default {
        props: ['group', 'permissions', 'group_permissions'],
        components: {
            AppLayout,
            UpdateGroupForm,
            DeleteGroupForm,
            JetSectionBorder,
        },
        data() {
            return {
                canUpdate: ['administrator', 'edit_group'],
                canDelete: ['administrator', 'delete_group']
            }
        },
    }
</script>
