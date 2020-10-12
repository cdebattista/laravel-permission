<template>
    <jet-action-section>
        <template #title>
            Delete group
        </template>

        <template #description>
            Permanently delete this group.
        </template>

        <template #content>
            <div class="max-w-xl text-sm text-gray-600">
                Once a group is deleted, all of its resources and data will be permanently deleted. Before deleting this group, please download any data or information regarding this group that you wish to retain.
            </div>

            <div class="mt-5">
                <jet-danger-button @click.native="confirmGroupDeletion">
                    Delete group
                </jet-danger-button>
            </div>

            <!-- Delete Team Confirmation Modal -->
            <jet-confirmation-modal :show="confirmingGroupDeletion" @close="confirmingGroupDeletion = false">
                <template #title>
                    Delete group
                </template>

                <template #content>
                    Are you sure you want to delete this group? Once a group is deleted, all of its resources and data will be permanently deleted.
                </template>

                <template #footer>
                    <jet-secondary-button @click.native="confirmingGroupDeletion = false">
                        Nevermind
                    </jet-secondary-button>

                    <jet-danger-button class="ml-2" @click.native="deleteGroup" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                        Delete group
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
        props: ['group'],

        components: {
            JetActionSection,
            JetButton,
            JetConfirmationModal,
            JetDangerButton,
            JetSecondaryButton,
        },

        data() {
            return {
                confirmingGroupDeletion: false,
                deleting: false,

                form: this.$inertia.form({
                    //
                }, {
                    bag: 'deleteGroup'
                })
            }
        },

        methods: {
            confirmGroupDeletion() {
                this.confirmingGroupDeletion = true
            },

            deleteGroup() {
                this.form.delete(this.route('groups.destroy', { 'group': this.group.id }), {
                    preserveScroll: true
                });
            },
        },
    }
</script>
