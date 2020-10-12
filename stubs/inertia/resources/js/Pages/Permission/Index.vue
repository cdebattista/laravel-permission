<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Permissions
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <portal-target name="dropdown" slim />
                <inertia-table
                        v-can="canViewOrEdit"
                           :data="permissions"
                           id="id"
                           :order="order"
                           :filters="filters"
                           :columns="columns"
                           routeName="permissions.index"
                           createLink="permissions.create"
                           :createLinkPermission="canCreate"
                           createLinkLabel="a permission"
                           @item-selected="show">
                </inertia-table>
                <dialog-modal :show="unauthorized" @close="unauthorized = false"></dialog-modal>
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
            permissions: Array,
            filters: Object,
            order: Object,
        },
        data() {
            return {
                canViewOrEdit: ['administrator', 'view_permission', 'edit_permission'],
                canCreate: ['administrator', 'create_permission'],
                canEdit:['administrator', 'edit_permission'],
                unauthorized: false,
                columns: ["name", "group", "slug"],
            }
        },
        methods: {
            show(permissions) {
                if(this.HasPermissions(this.canEdit)) {
                    this.$inertia.replace(this.route('permissions.edit', permissions.id));
                }else{
                    this.unauthorized = true;
                }
            },
        },
    }
</script>
