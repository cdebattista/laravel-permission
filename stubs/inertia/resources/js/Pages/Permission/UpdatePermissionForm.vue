<template>
    <jet-form-section @submitted="updatePermission">
        <template #title>
            Permission Details
        </template>

        <template #description>
            Edit permission : #{{ permission.id}} - {{ permission.name }}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Permission name" />
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus />
                <jet-input-error :message="form.error('name')" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="group" value="Permission group" />
                <jet-input id="group" type="text" class="mt-1 block w-full" v-model="form.group" autofocus />
                <jet-input-error :message="form.error('group')" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="slug" value="Permission slug" />
                <jet-input id="slug" type="text" class="mt-1 block w-full" v-model="form.slug" autofocus />
                <jet-input-error :message="form.error('slug')" class="mt-2" />
            </div>
        </template>

        <template #actions>
            <jet-action-message :on="form.recentlySuccessful" class="mr-3">
                Saved.
            </jet-action-message>

            <jet-button :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                Save
            </jet-button>
        </template>
    </jet-form-section>
</template>

<script>
    import JetActionMessage from './../../Jetstream/ActionMessage'
    import JetButton from './../../Jetstream/Button'
    import JetFormSection from './../../Jetstream/FormSection'
    import JetInput from './../../Jetstream/Input'
    import JetInputError from './../../Jetstream/InputError'
    import JetLabel from './../../Jetstream/Label'

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
        },

        props: ['permission'],

        data() {
            return {
                form: this.$inertia.form({
                    '_method': 'PUT',
                    name: this.permission.name,
                    slug: this.permission.slug,
                    group: this.permission.group
                }, {
                    bag: 'updatePermission',
                    resetOnSuccess: false,
                }),
            }
        },

        methods: {
            updatePermission() {
                this.form.put(this.route('permissions.update', { 'permission': this.permission.id }), {
                    preserveScroll: true
                });
            },
        },
    }
</script>
