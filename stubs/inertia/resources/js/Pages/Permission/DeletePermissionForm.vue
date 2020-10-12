<template>
    <jet-action-section>
        <template #title>
            Delete permission
        </template>

        <template #description>
            Permanently delete this permission.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once a permission is deleted, all of its resources and data will be permanently deleted. Before deleting this permission, please download any data or information regarding this permission that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click.native="confirmPermissionDeletion">
                    Delete permission
                </jet-danger-button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <jet-confirmation-modal :show="confirmingPermissionDeletion" @close="confirmingPermissionDeletion = false">
                <template #title>
                    Delete permission
                </template>

                <template #content>
                    Are you sure you want to delete this permission? Once a permission is deleted, all of its resources and data will be permanently deleted.
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="confirmingPermissionDeletion = false">
                        Nevermind
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click.native="deletePermission" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete permission
                    </jet-danger-button>
                </template>
            </jet-confirmation-modal>
        </template>
    </jet-action-section>
</template>

<script>
    import JetActionSection from './../../Jetstream/ActionSection'
    import JetButton from './../../Jetstream/Button'
    import JetConfirmationModal from './../../Jetstream/ConfirmationModal'
    import JetDangerButton from './../../Jetstream/DangerButton'
    import JetSecondaryButton from './../../Jetstream/SecondaryButton'

    export default {
        props: ['permission'],

        components: {
            JetActionSection,
            JetButton,
            JetConfirmationModal,
            JetDangerButton,
            JetSecondaryButton,
        },

        data() {
            return {
                confirmingPermissionDeletion: false,
                deleting: false,

                form: this.$inertia.form({
                    //
                }, {
                    bag: 'deletePermission'
                })
            }
        },

        methods: {
            confirmPermissionDeletion() {
                this.confirmingPermissionDeletion = true
            },

            deletePermission() {
                this.form.delete(this.route('permissions.destroy', { 'permission': this.permission.id }), {
                    preserveScroll: true
                });
            },
        },
    }
</script>
