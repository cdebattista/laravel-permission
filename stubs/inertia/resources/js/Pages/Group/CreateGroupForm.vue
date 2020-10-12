<template>
    <jet-form-section @submitted="createGroup">
        <template #title>
            Group details
        </template>

        <template #description>
            Create a new group.
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="name" value="Group name"/>
                <jet-input id="name" type="text" class="mt-1 block w-full" v-model="form.name" autofocus/>
                <jet-input-error :message="form.error('name')" class="mt-2"/>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="group" value="Group group"/>
                <jet-input id="group" type="text" class="mt-1 block w-full" v-model="form.group" autofocus/>
                <jet-input-error :message="form.error('group')" class="mt-2"/>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="permission" value="Permissions" />
                <multiselect v-model="form.group_permissions" :options="options" :multiple="true" group-values="options" group-label="group" :group-select="true" placeholder="Type to search" track-by="name" label="name">
                    <template slot="selection" slot-scope="{ values, search, isOpen }">
                      <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span>
                    </template>
                </multiselect>
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
    import Multiselect from 'vue-multiselect'
    require('vue-multiselect/dist/vue-multiselect.min.css');

    export default {
        components: {
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            Multiselect
        },

        props: ['permissions'],

        data() {
            return {
                options: this.permissions,
                form: this.$inertia.form({
                    name: '',
                    group: '',
                    group_permissions: []
                }, {
                    bag: 'createGroup',
                    resetOnSuccess: false,
                })
            }
        },

        methods: {
            createGroup() {
                this.form.post(this.route('groups.store'), {
                    preserveScroll: true
                });
            },
        },
    }
</script>
