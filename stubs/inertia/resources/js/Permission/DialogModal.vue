<template>
    <modal :show="show":max-width="maxWidth" :closeable="closeable" @close="close">
        <div class="px-6 py-4">
            <div class="text-lg">
                <div class="title">
                    Action is unauthorized
                </div>
            </div>

            <div class="mt-4">
                <div class="content">
                    You're are not allowed to perform this action !
                </div>
            </div>
        </div>

        <div class="px-6 py-4 bg-gray-100 text-right">
            <div class="footer">
                <jet-danger-button @click.native="$emit('close')">
                    Understood !
                </jet-danger-button>
            </div>
        </div>
    </modal>
</template>

<script>
    import Modal from './../Jetstream/Modal'
    import JetDangerButton from './../Jetstream/DangerButton'

    export default {
        components: {
            Modal,
            JetDangerButton
        },

        props: {
            show: {
                default: false
            },
            maxWidth: {
                default: '2xl'
            },
            closeable: {
                default: true
            },
        },

        methods: {
            close() {
                this.$emit('close')
            },
        }
    }
</script>
