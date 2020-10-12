<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Edit user
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <update-user-form v-can="canUpdate" :userSelected="userSelected" :groups="groups" :permissions="permissions" :user_permissions="user_permissions" :user_groups="user_groups"/>
                <jet-section-border />
                <delete-user-form v-can="canDelete" :userSelected="userSelected"/>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'
    import UpdateUserForm from "./UpdateUserForm";
    import DeleteUserForm from "./DeleteUserForm";
    import JetSectionBorder from './../../Jetstream/SectionBorder'

    export default {
        props: ['userSelected', 'groups', 'permissions', 'user_permissions', 'user_groups'],
        components: {
            AppLayout,
            UpdateUserForm,
            DeleteUserForm,
            JetSectionBorder,
        },
        data() {
            return {
                canUpdate: ['administrator', 'edit_user'],
                canDelete: ['administrator', 'delete_user']
            }
        },
    }
</script>
