<template>
    <app-layout>
        <template #header >
            <h2 class="font-semibold text-xl text-gray-800 leading-tight pt-3">
                Invoices
            </h2>

        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg p-4">
                    <!-- Name -->
                    <div class="col-span-6 sm:col-span-4">
                        <jet-label for="title" value="Title" />
                        <jet-input id="title" type="text" class="mt-1 block w-full" v-model="form.title" autocomplete="title" />
                        <jet-input-error :message="form.error('title')" class="mt-2" />
                    </div>

                    <button v-on:click="save" class="p-3 px-6 bg-blue-300 text-white rounded-full mt-4 mr-4">
                        Save
                    </button>
                    <a :href="'/invoices/'+ invoice.id +'/pdf/preview'" class="p-3 px-6 bg-purple-700 text-white rounded-full mt-4 mr-4">
                        PDF preview
                    </a>
                    <a :href="'/invoices/'+ invoice.id +'/pdf'" class="p-3 px-6 bg-blue-300 text-white rounded-full mt-4 mr-4">
                        to PDF
                    </a>
                    <button v-on:click="ready" v-if="state === 'draft'" class="p-3 px-6 bg-green-300 text-white rounded-full mt-4 mr-4">
                        ready
                    </button>
                    <button v-on:click="sent" v-if="state === 'ready'" class="p-3 px-6 bg-green-300 text-white rounded-full mt-4 mr-4">
                        Sent
                    </button>
                    <span title="Last updated">
                        <i class="fa fa-clock-o" aria-hidden="true"></i>
                        {{last_updated}}
                    </span>
                    <span title="Last updated" v-if="sent_when != null">
                        <i class="fa fa-envelope" aria-hidden="true"></i>
                        {{sent_when}}
                    </span>
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import AppLayout from '../../Layouts/AppLayout'
    import Welcome from '../../Jetstream/Welcome'
    import JetButton from './../../Jetstream/Button'
    import JetFormSection from './../../Jetstream/FormSection'
    import JetInput from './../../Jetstream/Input'
    import JetInputError from './../../Jetstream/InputError'
    import JetLabel from './../../Jetstream/Label'
    import JetActionMessage from './../../Jetstream/ActionMessage'
    import JetSecondaryButton from './../../Jetstream/SecondaryButton'
    export default {
        props: [
            'invoice',
            'last_updated',
            'state',
            'sent_when',
        ],
        components: {
            AppLayout,
            Welcome,
            JetActionMessage,
            JetButton,
            JetFormSection,
            JetInput,
            JetInputError,
            JetLabel,
            JetSecondaryButton,
        },
        data() {
            return {
                form: this.$inertia.form({
                    title: this.invoice.title,
                }, {
                    bag: 'createInvoice',
                    resetOnSuccess: false,
                }),
            }
        },
        methods: {
            sent() {
                this.$swal.fire({
                    title: 'Are you sure?',
                    showDenyButton: true,
                    showCancelButton: true,
                    confirmButtonText: `Save`,
                    denyButtonText: `Don't save`,
                }).then((result) => {
                    if (!result.isConfirmed) {
                        return;
                    }

                    this.form.put('/invoices/' + this.invoice.id + '/sent', {
                        preserveScroll: true
                    });

                })
            },
            ready() {
                this.form.put('/invoices/' + this.invoice.id + '/ready', {
                    preserveScroll: true
                });
            },
            save() {
                this.form.put('/invoices/' + this.invoice.id, {
                    preserveScroll: true
                });
            }
        }
    }
</script>
