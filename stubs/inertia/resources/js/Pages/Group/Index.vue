<template>
    <app-layout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Groups
            </h2>
        </template>

        <div>
            <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
                <portal-target name="dropdown" slim/>
                <inertia-table
                        v-can="canViewOrEdit"
                        :data="groups"
                        id="id"
                        :order="order"
                        :filters="filters"
                        :columns="columns"
                        routeName="groups.index"
                        createLink="groups.create"
                        :createLinkPermission="canCreate"
                        createLinkLabel="a group"
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
            groups: Array,
            filters: Object,
            order: Object,
        },
        data() {
            return {
                canViewOrEdit: ['administrator', 'view_group', 'edit_group'],
                canCreate: ['administrator', 'create_group'],
                canEdit:['administrator', 'edit_group'],
                unauthorized: false,
                columns: ["name", "group"],
            }
        },
        methods: {
            show(groups) {
                if(this.HasPermissions(this.canEdit)) {
                    this.$inertia.replace(this.route('groups.edit', groups.id));
                }else{
                    this.unauthorized = true;
                }
            }
        },
    }
</script>
