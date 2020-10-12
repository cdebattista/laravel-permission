<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Users
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <portal-target name="dropdown" slim/>
                <inertia-table
                        v-can="canViewOrEdit"
                        :data="users"
                        id="id"
                        :order="order"
                        :filters="filters"
                        :columns="columns"
                        routeName="users.index"
                        createLink="users.create"
                        :createLinkPermission="canCreate"
                        createLinkLabel="a user"
                        @item-selected="show">
                </inertia-table>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from './../../Layouts/AppLayout'
    import InertiaTable from './../../InertiaTable/Table'
    import JetSectionBorder from './../../Jetstream/SectionBorder'
    import DialogModal from './../../Permission/DialogModal';

    export default {
        components: {
            AppLayout,
            InertiaTable,
            JetSectionBorder,
            DialogModal
        },
        props: {
            users: Array,
            filters: Object,
            order: Object,
        },
        data() {
            return {
                canViewOrEdit: ['administrator', 'view_user', 'edit_user'],
                canCreate: ['administrator', 'create_user'],
                canEdit: ['administrator', 'edit_user'],
                columns: ["lastname", "firstname", "email"],
            }
        },
        methods: {
            show(users) {
                if(this.HasPermissions(this.canEdit)) {
                    this.$inertia.replace(this.route('users.edit', users.id));
                }else{
                    this.unauthorized = true;
                }
            }
        },
    }
</script>
