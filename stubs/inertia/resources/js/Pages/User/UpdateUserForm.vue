<template>
    <jet-form-section @submitted="updateUser">
        <template #title>
            User details
        </template>

        <template #description>
            Edit user : #{{ userSelected.id}} - {{ userSelected.lastname }} {{ userSelected.firstname }}
        </template>

        <template #form>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="lastname" value="User lastname"/>
                <jet-input id="lastname" type="text" class="mt-1 block w-full" v-model="form.lastname" autofocus/>
                <jet-input-error :message="form.error('lastname')" class="mt-2"/>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="firstname" value="User firstname"/>
                <jet-input id="firstname" type="text" class="mt-1 block w-full" v-model="form.firstname" autofocus/>
                <jet-input-error :message="form.error('firstname')" class="mt-2"/>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="email" value="Email" />
                <jet-input id="email" type="email" class="mt-1 block w-full" v-model="form.email" />
                <jet-input-error :message="form.error('email')" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password" value="New Password" />
                <jet-input id="password" type="password" class="mt-1 block w-full" v-model="form.password" autocomplete="new-password" />
                <jet-input-error :message="form.error('password')" class="mt-2" />
            </div>

            <div class="col-span-6 sm:col-span-4">
                <jet-label for="password_confirmation" value="Confirm Password" />
                <jet-input id="password_confirmation" type="password" class="mt-1 block w-full" v-model="form.password_confirmation" autocomplete="new-password" />
                <jet-input-error :message="form.error('password_confirmation')" class="mt-2" />
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="permission" value="Permissions" />
                <multiselect class="z-1" v-model="form.user_permissions" :options="optionsPermissions" :multiple="true" group-values="options" group-label="group" :group-select="true" placeholder="Type to search" track-by="name" label="name">
                    <template slot="selection" slot-scope="{ values, search, isOpen }">
                        <span class="multiselect__single" v-if="values.length &amp;&amp; !isOpen">{{ values.length }} options selected</span>
                    </template>
                </multiselect>
            </div>
            <div class="col-span-6 sm:col-span-4">
                <jet-label for="group" value="Groups" />
                <multiselect v-model="form.user_groups" :options="optionsGroups" :multiple="true" group-values="options" group-label="group" :group-select="true" placeholder="Type to search" track-by="name" label="name">
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
    import('vue-multiselect/dist/vue-multiselect.min.css');

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

        props: ['userSelected', 'groups', 'permissions', 'user_permissions', 'user_groups'],

        data() {
            return {
                optionsPermissions: this.permissions,
                optionsGroups: this.groups,
                form: this.$inertia.form({
                    '_method': 'PUT',
                    lastname: this.userSelected.lastname,
                    firstname: this.userSelected.firstname,
                    email: this.userSelected.email,
                    password: '',
                    password_confirmation: '',
                    user_permissions: this.user_permissions,
                    user_groups: this.user_groups
                }, {
                    bag: 'updateUser',
                    resetOnSuccess: false,
                }),
            }
        },
        methods: {
            updateUser() {
                this.form.put(this.route('users.update', { 'user': this.userSelected.id }), {
                    preserveScroll: true
                });
            },
        },
    }
</script>